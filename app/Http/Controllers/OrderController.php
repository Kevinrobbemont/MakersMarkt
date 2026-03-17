<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Credit;
use App\Models\CreditTransaction;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $isMaker = $user?->role?->name === 'maker';
        $isAdmin = $user?->role?->name === 'admin';

        $ordersQuery = Order::query()->with([
            'product',
            'buyer',
            'product.maker',
            'review',
        ]);

        if ($isMaker && !$isAdmin) {
            $ordersQuery->whereHas('product', function ($query) use ($user) {
                $query->where('maker_id', $user->id);
            });
        } elseif (!$isAdmin) {
            $ordersQuery->where('buyer_id', $user->id);
        }

        $orders = $ordersQuery->latest()->paginate(15);

        return view('orders.index', compact('orders', 'isMaker', 'isAdmin'));
    }

    /**
     * Display the specified order.
     */
    public function show(Request $request, Order $order): View
    {
        $this->ensureCanViewOrder($request, $order);

        $order->load([
            'product',
            'buyer',
            'product.maker',
            'review',
        ]);

        $isOwnerMaker = (int) $order->product->maker_id === (int) $request->user()?->id;
        $statusOptions = [
            Order::STATUS_IN_PRODUCTION => Order::statusOptions()[Order::STATUS_IN_PRODUCTION],
            Order::STATUS_SHIPPED => Order::statusOptions()[Order::STATUS_SHIPPED],
            Order::STATUS_REJECTED => Order::statusOptions()[Order::STATUS_REJECTED],
        ];

        return view('orders.show', compact('order', 'isOwnerMaker', 'statusOptions'));
    }

    /**
     * Store a newly created order.
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $user = $request->user();
        $productId = $request->integer('product_id');

        try {
            $product = Product::findOrFail($productId);
        } catch (ModelNotFoundException) {
            return redirect()->back()->with('error', 'Het product bestaat niet.');
        }

        if ((int) $product->maker_id === (int) $user->id) {
            return redirect()->back()->with('error', 'Je kunt je eigen producten niet bestellen.');
        }

        $buyerCredit = Credit::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        if ($buyerCredit->balance < $product->price) {
            $needed = $product->price - $buyerCredit->balance;
            return redirect()->back()->with('error', "Onvoldoende krediet. Je hebt nog {$needed} euro nodig.");
        }

        $makerCredit = Credit::firstOrCreate(
            ['user_id' => $product->maker_id],
            ['balance' => 0]
        );

        try {
            $order = Order::create([
                'product_id' => $product->id,
                'buyer_id' => $user->id,
                'status' => Order::STATUS_PENDING,
                'status_description' => 'Betaling ontvangen, maker start productie binnenkort.',
            ]);

            Notification::create([
                'user_id' => $product->maker_id,
                'product_id' => $product->id,
                'order_id' => $order->id,
                'message' => "Je hebt een nieuwe bestelling ontvangen voor '{$product->name}' van {$user->name}.",
            ]);

            $buyerCredit->decrement('balance', $product->price);
            $makerCredit->increment('balance', $product->price);

            CreditTransaction::create([
                'from_user_id' => $user->id,
                'to_user_id' => $product->maker_id,
                'amount' => $product->price,
                'order_id' => $order->id,
            ]);

            return redirect()
                ->route('orders.show', $order)
                ->with('status', 'Je bestelling is geplaatst! De maker zal deze spoedig in behandeling nemen.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het plaatsen van je bestelling. Probeer het later opnieuw.');
        }
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $order->loadMissing(['product.maker', 'buyer']);
        $this->ensureUserIsMakerOfProduct($request, $order);

        $newStatus = $request->string('status')->toString();
        $newDescription = trim((string) $request->input('status_description', ''));
        $wasRejected = $order->isRejected();

        try {
            DB::transaction(function () use ($order, $newStatus, $newDescription, $wasRejected) {
                if ($newStatus === Order::STATUS_REJECTED && !$wasRejected) {
                    $buyerCredit = Credit::firstOrCreate(
                        ['user_id' => $order->buyer_id],
                        ['balance' => 0]
                    );

                    $makerCredit = Credit::firstOrCreate(
                        ['user_id' => $order->product->maker_id],
                        ['balance' => 0]
                    );

                    $buyerCredit->increment('balance', $order->product->price);
                    $makerCredit->decrement('balance', $order->product->price);

                    CreditTransaction::create([
                        'from_user_id' => $order->product->maker_id,
                        'to_user_id' => $order->buyer_id,
                        'amount' => $order->product->price,
                        'order_id' => $order->id,
                    ]);
                }

                $order->update([
                    'status' => $newStatus,
                    'status_description' => $newDescription !== ''
                        ? $newDescription
                        : $order->status_description,
                ]);

                Notification::create([
                    'user_id' => $order->buyer_id,
                    'product_id' => $order->product_id,
                    'order_id' => $order->id,
                    'message' => "De status van je bestelling voor '{$order->product->name}' is gewijzigd naar {$order->getStatusLabel()}.",
                ]);
            });

            $message = $newStatus === Order::STATUS_REJECTED
                ? 'De bestelling is geweigerd en de terugbetaling is verwerkt.'
                : 'De bestelstatus is bijgewerkt.';

            return redirect()
                ->route('orders.show', $order)
                ->with('status', $message);
        } catch (\Throwable $e) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'De bestelstatus kon niet worden bijgewerkt.');
        }
    }

    /**
     * Ensure that the user can view the order.
     */
    private function ensureCanViewOrder(Request $request, Order $order): void
    {
        $order->loadMissing('product');

        $user = $request->user();
        $isAdmin = $user?->role?->name === 'admin';
        $isBuyer = (int) $order->buyer_id === (int) $user->id;
        $isMaker = (int) $order->product->maker_id === (int) $user->id;

        if (!$isAdmin && !$isBuyer && !$isMaker) {
            abort(403, 'Je mag deze bestelling niet bekijken.');
        }
    }

    /**
     * Ensure that only the maker of the product can update the order status.
     */
    private function ensureUserIsMakerOfProduct(Request $request, Order $order): void
    {
        if ((int) $order->product->maker_id !== (int) $request->user()?->id) {
            abort(403, 'Alleen de maker van dit product mag de status wijzigen.');
        }
    }
}