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

        // Alleen de koper van deze bestelling mag een review plaatsen
        if ((int) $order->buyer_id !== (int) auth()->id()) {
            abort(403, 'Je mag alleen reviews plaatsen voor je eigen bestellingen.');
        }

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
                ->with('error', 'Je hebt al een review geplaatst voor deze bestelling.');
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

        // Alleen de koper van deze bestelling mag een review plaatsen
        if ((int) $order->buyer_id !== (int) auth()->id()) {
            abort(403, 'Je mag alleen reviews plaatsen voor je eigen bestellingen.');
        }

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
                ->with('error', 'Je hebt al een review geplaatst voor deze bestelling.');
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
}