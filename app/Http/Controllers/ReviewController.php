<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review.
     */
    public function create(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = Order::with('product.maker')->findOrFail($orderId);
        
        // Check if the authenticated user is the buyer of this order
        if ($order->buyer_id !== auth()->id()) {
            abort(403, 'Je mag alleen reviews plaatsen voor je eigen bestellingen.');
        }
        
        // Check if a review already exists for this order
        if ($order->review) {
            return redirect()->back()->with('error', 'Je hebt al een review geplaatst voor deze bestelling.');
        }
        
        return view('reviews.create', compact('order'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Create the review
        $review = Review::create($validated);

        // Get the order and product to send notification to maker
        $order = Order::with('product.maker')->findOrFail($validated['order_id']);
        $product = $order->product;
        $maker = $product->maker;

        // Create notification for the maker
        Notification::create([
            'user_id' => $maker->id,
            'product_id' => $product->id,
            'message' => 'Je hebt een nieuwe review ontvangen voor ' . $product->name,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Review succesvol toegevoegd!');
    }
}
