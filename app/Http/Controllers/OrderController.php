<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Credit;
use App\Models\CreditTransaction;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            // Makers see orders for their products
            $ordersQuery->whereHas('product', function ($query) use ($user) {
                $query->where('maker_id', $user->id);
            });
        } elseif (!$isAdmin) {
            // Buyers see their own orders
            $ordersQuery->where('buyer_id', $user->id);
        }
        // Admins see all orders

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

        return view('orders.show', compact('order'));
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

        // Ensure the user is not the product maker
        if ((int) $product->maker_id === (int) $user->id) {
            return redirect()->back()->with('error', 'Je kunt je eigen producten niet bestellen.');
        }

        // Get or create the buyer's credit
        $buyerCredit = Credit::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        // Check if buyer has sufficient balance
        if ($buyerCredit->balance < $product->price) {
            $needed = $product->price - $buyerCredit->balance;
            return redirect()->back()->with('error', "Onvoldoende krediet. Je hebt nog {$needed} euro nodig.");
        }

        // Get or create the maker's credit
        $makerCredit = Credit::firstOrCreate(
            ['user_id' => $product->maker_id],
            ['balance' => 0]
        );

        try {
            // Create the order
            $order = Order::create([
                'product_id' => $product->id,
                'buyer_id' => $user->id,
                'status' => 'pending',
                'status_description' => 'Betaling ontvangen, maker start productie binnenkort.',
            ]);

            // Create a notification for the maker
            Notification::create([
                'user_id' => $product->maker_id,
                'product_id' => $product->id,
                'order_id' => $order->id,
                'message' => "Je hebt een nieuwe bestelling ontvangen voor '{$product->name}' van {$user->name}.",
            ]);

            // Deduct credit from buyer
            $buyerCredit->decrement('balance', $product->price);

            // Add credit to maker
            $makerCredit->increment('balance', $product->price);

            // Record the credit transaction
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
     * Ensure that the user can view the order.
     */
    private function ensureCanViewOrder(Request $request, Order $order): void
    {
        $user = $request->user();
        $isAdmin = $user?->role?->name === 'admin';
        $isBuyer = (int) $order->buyer_id === (int) $user->id;
        $isMaker = (int) $order->product->maker_id === (int) $user->id;

        if (!$isAdmin && !$isBuyer && !$isMaker) {
            abort(403, 'Je mag deze bestelling niet bekijken.');
        }
    }
}