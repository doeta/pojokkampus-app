<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = Product::where('user_id', $userId)->with('category');

        // Search
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $products = $query->latest()->paginate(12);

        // Stats
        $stats = [
            'total' => Product::where('user_id', $userId)->count(),
            'active' => Product::where('user_id', $userId)->where('status', 'active')->count(),
            'draft' => Product::where('user_id', $userId)->where('status', 'draft')->count(),
            'out_of_stock' => Product::where('user_id', $userId)->where('stock', 0)->count(),
        ];

        return view('seller.products.index', compact('products', 'stats'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'brand' => 'nullable|string|max:100',
            'description' => 'required|string|min:20',
            'price' => 'required|numeric|min:100',
            'weight' => 'nullable|numeric|min:1',
            'condition' => 'required|in:new,used',
            'stock' => 'required|integer|min:0',
            'min_order' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload main image
        $imagePath = $request->file('image')->store('products', 'public');

        // Upload additional images
        $additionalImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $additionalImages[] = $image->store('products', 'public');
            }
        }

        $product = Product::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'sku' => $validated['sku'] ?? null,
            'brand' => $validated['brand'] ?? null,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'weight' => $validated['weight'] ?? null,
            'condition' => $validated['condition'],
            'stock' => $validated['stock'],
            'min_order' => $validated['min_order'],
            'image' => $imagePath,
            'images' => $additionalImages,
            'status' => 'active',
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        // Check if product belongs to current user
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // SRS-06: Reviews are from guests, no user relation
        $product->load('category', 'reviews');
        return view('seller.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Check if product belongs to current user
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $categories = Category::where('is_active', true)->get();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Check if product belongs to current user
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'brand' => 'nullable|string|max:100',
            'description' => 'required|string|min:20',
            'price' => 'required|numeric|min:100',
            'weight' => 'nullable|numeric|min:1',
            'condition' => 'required|in:new,used',
            'stock' => 'required|integer|min:0',
            'min_order' => 'required|integer|min:1',
            'status' => 'required|in:draft,active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update main image if uploaded
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Upload additional images
        if ($request->hasFile('images')) {
            $additionalImages = $product->images ?? [];
            foreach ($request->file('images') as $image) {
                $additionalImages[] = $image->store('products', 'public');
            }
            $validated['images'] = $additionalImages;
        }

        $product->update($validated);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        // Check if product belongs to current user
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Delete images
        Storage::disk('public')->delete($product->image);
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
