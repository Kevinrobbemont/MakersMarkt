<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Credit;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $search = trim((string) $request->query('q', ''));
        $selectedCategory = $request->integer('category_id');
        $selectedMaterial = trim((string) $request->query('material', ''));
        $selectedProductionTime = trim((string) $request->query('production_time', ''));
        $selectedComplexity = trim((string) $request->query('complexity', ''));
        $roleName = $user?->role?->name;
        $isMaker = $roleName === 'maker';
        $isAdmin = $roleName === 'admin';

        $products = Product::query()
            ->with(['category', 'maker'])
            ->when($isAdmin, function ($query) {
                // Admin ziet alles
            })
            ->when($isMaker && !$isAdmin, function ($query) use ($user) {
                $query->where(function ($inner) use ($user) {
                    $inner->where('is_approved', true)
                        ->orWhere('maker_id', $user->id);
                });
            })
            ->when(!$isMaker && !$isAdmin, function ($query) {
                $query->where('is_approved', true);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('material', 'like', "%{$search}%")
                        ->orWhere('unique_features', 'like', "%{$search}%");
                });
            })
            ->when($selectedCategory > 0, function ($query) use ($selectedCategory) {
                $query->where('category_id', $selectedCategory);
            })
            ->when($selectedMaterial !== '', function ($query) use ($selectedMaterial) {
                $query->where('material', $selectedMaterial);
            })
            ->when($selectedProductionTime !== '', function ($query) use ($selectedProductionTime) {
                $query->where('production_time', $selectedProductionTime);
            })
            ->when($selectedComplexity !== '', function ($query) use ($selectedComplexity) {
                $query->where('complexity', $selectedComplexity);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $materials = Product::query()
            ->whereNotNull('material')
            ->where('material', '!=', '')
            ->distinct()
            ->pluck('material')
            ->sort()
            ->values();

        $productionTimes = Product::query()
            ->whereNotNull('production_time')
            ->where('production_time', '!=', '')
            ->distinct()
            ->pluck('production_time')
            ->sort()
            ->values();

        $complexities = Product::query()
            ->whereNotNull('complexity')
            ->where('complexity', '!=', '')
            ->distinct()
            ->pluck('complexity')
            ->sort()
            ->values();

        return view('products.index', compact(
            'products',
            'categories',
            'isMaker',
            'isAdmin',
            'search',
            'selectedCategory',
            'selectedMaterial',
            'selectedProductionTime',
            'selectedComplexity',
            'materials',
            'productionTimes',
            'complexities'
        ));
    }

    /**
     * Display the specified product.
     */
    public function show(Request $request, Product $product): View
    {
        $this->ensureCanViewProduct($request, $product);

        $product->load([
            'category',
            'maker',
            'reviews.order.buyer',
        ]);

        $averageRating = $product->reviews->avg('rating');
        $reviewCount = $product->reviews->count();
        $buyerCredit = null;

        if ($request->user()) {
            $buyerCredit = Credit::firstOrCreate(
                ['user_id' => $request->user()->id],
                ['balance' => 0]
            );
        }

        return view('products.show', compact('product', 'averageRating', 'reviewCount', 'buyerCredit'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'type' => ['nullable', 'string', 'max:255'],
            'production_time' => ['nullable', 'string', 'max:255'],
            'complexity' => ['nullable', 'string', 'max:255'],
            'specifications' => ['nullable', 'string'],
        ]);

        $isAdmin = $request->user()?->role?->name === 'admin';

        $product = Product::create([
            'maker_id' => $request->user()->id,
            'category_id' => (int) $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => (float) $validated['price'],
            'material' => $validated['type'] ?? null,
            'production_time' => $validated['production_time'] ?? null,
            'complexity' => $validated['complexity'] ?? null,
            'unique_features' => $validated['specifications'] ?? null,
            'is_approved' => $isAdmin,
            'has_external_links' => false,
        ]);

        $product->update([
            'has_external_links' => $product->checkForExternalLinks(),
        ]);

        return redirect()
            ->route('products.index')
            ->with('status', $isAdmin ? 'Product aangemaakt en goedgekeurd.' : 'Product aangemaakt en wacht op goedkeuring.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Request $request, Product $product): View
    {
        $this->ensureOwner($request, $product);

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->ensureOwner($request, $product);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'type' => ['nullable', 'string', 'max:255'],
            'production_time' => ['nullable', 'string', 'max:255'],
            'complexity' => ['nullable', 'string', 'max:255'],
            'specifications' => ['nullable', 'string'],
        ]);

        $product->update([
            'category_id' => (int) $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => (float) $validated['price'],
            'material' => $validated['type'] ?? null,
            'production_time' => $validated['production_time'] ?? null,
            'complexity' => $validated['complexity'] ?? null,
            'unique_features' => $validated['specifications'] ?? null,
        ]);

        $product->update([
            'has_external_links' => $product->checkForExternalLinks(),
        ]);

        return redirect()
            ->route('products.show', $product)
            ->with('status', 'Product succesvol bijgewerkt.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $this->ensureOwner($request, $product);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('status', 'Product succesvol verwijderd.');
    }

    /**
     * Ensure the authenticated user owns the product.
     */
    private function ensureOwner(Request $request, Product $product): void
    {
        $user = $request->user();
        $isAdmin = $user?->role?->name === 'admin';

        if (!$isAdmin && (int) $product->maker_id !== (int) $user->id) {
            abort(403, 'Je mag dit product niet aanpassen.');
        }
    }

    /**
     * Ensure the authenticated user can view the product.
     */
    private function ensureCanViewProduct(Request $request, Product $product): void
    {
        $user = $request->user();
        $isAdmin = $user?->role?->name === 'admin';
        $isOwner = $user && (int) $product->maker_id === (int) $user->id;

        if (!$product->is_approved && !$isAdmin && !$isOwner) {
            abort(403, 'Dit product is nog niet goedgekeurd.');
        }
    }
}