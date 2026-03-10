<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Display statistics for moderators/admins.
     */
    public function index()
    {
        // 1. Aantal producten per categorie
        $productsPerCategory = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->products_count,
                ];
            });

        // 2. Gemiddelde rating per maker
        $averageRatingPerMaker = User::whereHas('role', function ($query) {
                $query->where('name', 'maker');
            })
            ->withCount('products')
            ->with(['products.orders.review'])
            ->get()
            ->map(function ($maker) {
                $allReviews = $maker->products->flatMap(function ($product) {
                    return $product->orders->pluck('review')->filter();
                });

                $averageRating = $allReviews->isEmpty() 
                    ? null 
                    : round($allReviews->avg('rating'), 2);

                return [
                    'name' => $maker->name,
                    'product_count' => $maker->products_count,
                    'review_count' => $allReviews->count(),
                    'average_rating' => $averageRating,
                ];
            })
            ->filter(function ($maker) {
                return $maker['review_count'] > 0;
            })
            ->sortByDesc('average_rating')
            ->values();

        // 3. Populairste producttype (materiaal)
        $popularMaterials = Product::select('material', DB::raw('count(*) as count'))
            ->whereNotNull('material')
            ->where('material', '!=', '')
            ->groupBy('material')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        // Extra statistiek: Populairste producten op basis van aantal orders
        $popularProducts = Product::withCount('orders')
            ->with(['maker', 'category'])
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'maker' => $product->maker->name,
                    'category' => $product->category->name ?? 'Onbekend',
                    'orders_count' => $product->orders_count,
                ];
            });

        return view('statistics.index', compact(
            'productsPerCategory',
            'averageRatingPerMaker',
            'popularMaterials',
            'popularProducts'
        ));
    }
}
