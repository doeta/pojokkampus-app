<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'user'])
            ->where('status', 'active')
            ->where('stock', '>', 0);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($categoryId = $request->input('category')) {
            $query->where('category_id', $categoryId);
        }

        // Filter by seller/store
        if ($storeSearch = $request->input('store')) {
            $query->whereHas('user', function ($q) use ($storeSearch) {
                $q->where('name', 'like', "%{$storeSearch}%");
            });
        }

        // Filter by location (jika ada seller profile terpisah)
        if ($province = $request->input('province')) {
            $query->whereHas('user.seller', function ($q) use ($province) {
                $q->where('provinsi', $province);
            });
        }

        if ($city = $request->input('city')) {
            $query->whereHas('user.seller', function ($q) use ($city) {
                $q->where('kabupaten_kota', $city);
            });
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sold', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20);
        $categories = Category::where('is_active', true)->get();

        // Get unique provinces and cities from sellers
        $provinces = \App\Models\Seller::whereNotNull('provinsi')
            ->distinct()
            ->pluck('provinsi')
            ->sort()
            ->values();

        $cities = \App\Models\Seller::whereNotNull('kabupaten_kota')
            ->distinct()
            ->pluck('kabupaten_kota')
            ->sort()
            ->values();

        return view('catalog.index', compact('products', 'categories', 'provinces', 'cities'));
    }

    public function indexByCategory(Category $category)
    {
        $query = Product::with(['category', 'user'])
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->where('category_id', $category->id);

        $sort = request()->input('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sold', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20);
        $categories = Category::where('is_active', true)->get();

        return view('catalog.index', compact('products', 'categories', 'category'));
    }

    public function show(Product $product)
    {
        // SRS-06: Reviews are from guests, no user relation
        $product->load(['category', 'user.seller', 'reviews']);

        // Only show active products with stock
        if ($product->status !== 'active' || $product->stock <= 0) {
            abort(404);
        }

        // Increment views
        $product->incrementViews();

        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->limit(5)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}
