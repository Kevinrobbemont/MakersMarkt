<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review.
     */
    public function create(Request $request): View|RedirectResponse
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return redirect()->route('orders.index')->with('error', 'Geen bestelling geselecteerd.');
        }

        $order = Order::with([
            'product.maker',
            'buyer',
            'review',
        ])->findOrFail($orderId);

        $this->ensureCanReviewOrder($request, $order);

        // Geen review bij een geweigerde bestelling
        if ($order->status === 'geweigerd') {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Je kunt geen review plaatsen voor een geweigerde bestelling.');
        }

        // Slechts één review per bestelling
        if ($order->review) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Er is al een review geplaatst voor deze bestelling.');
        }

        return view('reviews.create', compact('order'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $order = Order::with([
            'product.maker',
            'buyer',
            'review',
        ])->findOrFail($validated['order_id']);

        $this->ensureCanReviewOrder($request, $order);

        // Geen review bij een geweigerde bestelling
        if ($order->status === 'geweigerd') {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Je kunt geen review plaatsen voor een geweigerde bestelling.');
        }

        // Slechts één review per bestelling
        if ($order->review) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Er is al een review geplaatst voor deze bestelling.');
        }

        Review::create([
            'order_id' => $order->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        $product = $order->product;
        $maker = $product->maker;

        Notification::create([
            'user_id' => $maker->id,
            'product_id' => $product->id,
            'order_id' => $order->id,
            'message' => 'Je hebt een nieuwe review ontvangen voor ' . $product->name,
            'is_read' => false,
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('status', 'Review succesvol toegevoegd!');
    }

    /**
     * Alleen gebruikers die de bestelling mogen zien, mogen ook reviewen.
     */
    private function ensureCanReviewOrder(Request $request, Order $order): void
    {
        $user = $request->user();
        $isAdmin = $user?->role?->name === 'admin';
        $isBuyer = (int) $order->buyer_id === (int) $user->id;
        $isMaker = (int) $order->product->maker_id === (int) $user->id;

        if (!$isAdmin && !$isBuyer && !$isMaker) {
            abort(403, 'Je mag alleen een review plaatsen bij een bestelling die je mag bekijken.');
        }
    }
}