<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * SRS-MartPlace-12: Laporan Stok (Urut Stok Tertinggi)
     * Menampilkan daftar produk diurutkan dari stok terbanyak ke terkecil
     * Kolom: Nama Produk, Stok, Rating, Kategori, Harga
     */
    public function stock()
    {
        $seller = Auth::user();
        $products = Product::where('user_id', $seller->id)
            ->with(['category', 'reviews'])
            ->orderBy('stock', 'desc')
            ->get()
            ->map(function ($product) {
                $product->avg_rating = $product->reviews()->avg('rating') ?? 0;
                $product->total_reviews = $product->reviews()->count();
                return $product;
            });

        return view('seller.reports.stock', compact('products'));
    }

    public function stockPdf()
    {
        $seller = Auth::user();
        $products = Product::where('user_id', $seller->id)
            ->with(['category', 'reviews'])
            ->orderBy('stock', 'desc')
            ->get()
            ->map(function ($product) {
                $product->avg_rating = $product->reviews()->avg('rating') ?? 0;
                $product->total_reviews = $product->reviews()->count();
                return $product;
            });

        $pdf = Pdf::loadView('seller.reports.pdf.stock', compact('products'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('laporan-stok-produk-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * SRS-MartPlace-13: Laporan Performa (Urut Rating Tertinggi)
     * Menampilkan daftar produk diurutkan dari rating bintang 5 ke bawah
     * Kolom: Nama Produk, Rating, Stok, Kategori, Harga
     */
    public function performance()
    {
        $seller = Auth::user();
        $products = Product::where('user_id', $seller->id)
            ->with(['category', 'reviews'])
            ->get()
            ->map(function ($product) {
                $product->avg_rating = $product->reviews()->avg('rating') ?? 0;
                $product->total_reviews = $product->reviews()->count();
                return $product;
            })
            ->sortByDesc('avg_rating')
            ->values();

        return view('seller.reports.performance', compact('products'));
    }

    public function performancePdf()
    {
        $seller = Auth::user();
        $products = Product::where('user_id', $seller->id)
            ->with(['category', 'reviews'])
            ->get()
            ->map(function ($product) {
                $product->avg_rating = $product->reviews()->avg('rating') ?? 0;
                $product->total_reviews = $product->reviews()->count();
                return $product;
            })
            ->sortByDesc('avg_rating')
            ->values();

        $pdf = Pdf::loadView('seller.reports.pdf.performance', compact('products'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('laporan-rating-produk-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * SRS-MartPlace-14: Laporan Restock (Stok Menipis < 2)
     * Menampilkan barang dengan Stok < 2 sebagai peringatan restock
     * Kolom: Nama Produk, Stok, Rating, Kategori, Harga
     */
    public function restock()
    {
        $seller = Auth::user();
        $products = Product::where('user_id', $seller->id)
            ->where('stock', '<', 2)
            ->with(['category', 'reviews'])
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*')
            ->orderBy('categories.name', 'asc')
            ->orderBy('products.name', 'asc')
            ->get()
            ->map(function ($product) {
                $product->avg_rating = $product->reviews()->avg('rating') ?? 0;
                $product->total_reviews = $product->reviews()->count();
                return $product;
            });

        return view('seller.reports.restock', compact('products'));
    }

    public function restockPdf()
    {
        $seller = Auth::user();
        $products = Product::where('user_id', $seller->id)
            ->where('stock', '<', 2)
            ->with(['category', 'reviews'])
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*')
            ->orderBy('categories.name', 'asc')
            ->orderBy('products.name', 'asc')
            ->get()
            ->map(function ($product) {
                $product->avg_rating = $product->reviews()->avg('rating') ?? 0;
                $product->total_reviews = $product->reviews()->count();
                return $product;
            });

        $pdf = Pdf::loadView('seller.reports.pdf.restock', compact('products'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('laporan-restock-produk-' . now()->format('Y-m-d') . '.pdf');
    }
}
