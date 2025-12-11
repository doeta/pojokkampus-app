<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display seller account status report
     * SRS-MartPlace-09
     */
    public function sellerAccounts(Request $request)
    {
        $filter = $request->get('filter', 'all'); // all, active, inactive
        $perPage = $request->get('per_page', 20);

        $query = User::where('role', 'seller')->with('seller');

        if ($filter === 'active') {
            $query->where('status', 'active');
        } elseif ($filter === 'inactive') {
            $query->where('status', '!=', 'active');
        }

        $sellers = $query->orderByRaw("CASE WHEN status = 'active' THEN 1 ELSE 2 END")
            ->orderBy('name')
            ->paginate($perPage);

        // Get total counts for summary cards
        $totalActive = User::where('role', 'seller')->where('status', 'active')->count();
        $totalInactive = User::where('role', 'seller')->where('status', '!=', 'active')->count();

        return view('admin.reports.seller-accounts', compact('sellers', 'filter', 'perPage', 'totalActive', 'totalInactive'));
    }

    /**
     * Generate PDF for seller account status report
     * SRS-MartPlace-09
     */
    public function sellerAccountsPdf(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = User::where('role', 'seller')->with('seller');

        if ($filter === 'active') {
            $query->where('status', 'active');
        } elseif ($filter === 'inactive') {
            $query->where('status', '!=', 'active');
        }

        $sellers = $query->orderByRaw("CASE WHEN status = 'active' THEN 1 ELSE 2 END")
            ->orderBy('name')
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf.seller-accounts', compact('sellers', 'filter'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-akun-penjual-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Display store distribution by province report
     * SRS-MartPlace-10
     */
    public function storeDistribution(Request $request)
    {
        $provinsi = $request->get('provinsi', 'all');
        $perPage = $request->get('per_page', 20);

        $query = Seller::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            });

        // Apply province filter
        if ($provinsi !== 'all') {
            $query->where('provinsi', $provinsi);
        }

        $stores = $query->orderBy('provinsi')
            ->orderBy('nama_toko')
            ->paginate($perPage);

        // Get all unique provinces for filter dropdown
        $provinces = Seller::whereHas('user', function ($query) {
            $query->where('status', 'active');
        })
            ->distinct()
            ->orderBy('provinsi')
            ->pluck('provinsi');

        return view('admin.reports.store-distribution', compact('stores', 'perPage', 'provinsi', 'provinces'));
    }

    /**
     * Generate PDF for store distribution report
     * SRS-MartPlace-10
     */
    public function storeDistributionPdf(Request $request)
    {
        $provinsi = $request->get('provinsi', 'all');

        $query = Seller::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            });

        // Apply province filter
        if ($provinsi !== 'all') {
            $query->where('provinsi', $provinsi);
        }

        $stores = $query->orderBy('provinsi')
            ->orderBy('nama_toko')
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf.store-distribution', compact('stores', 'provinsi'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-sebaran-toko-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Display product rating report
     * SRS-MartPlace-11
     */
    public function productRating(Request $request)
    {
        $perPage = $request->get('per_page', 20);

        $allProducts = Product::with(['seller.seller', 'category', 'reviews'])
            ->get()
            ->map(function ($product) {
                $product->avg_rating = $product->reviews()->avg('rating') ?? 0;
                return $product;
            })
            ->sortByDesc('avg_rating')
            ->values();

        // Manual pagination
        $currentPage = $request->get('page', 1);
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $allProducts->forPage($currentPage, $perPage),
            $allProducts->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Calculate stats for summary cards
        $totalProducts = $allProducts->count();
        $maxRating = $allProducts->max('avg_rating');
        $averageRating = $allProducts->avg('avg_rating');

        return view('admin.reports.product-rating', compact('products', 'perPage', 'totalProducts', 'maxRating', 'averageRating'));
    }

    /**
     * Generate PDF for product rating report
     * SRS-MartPlace-11
     */
    public function productRatingPdf()
    {
        $products = Product::with(['seller.seller', 'category', 'reviews'])
            ->get()
            ->map(function ($product) {
                $product->avg_rating = $product->reviews()->avg('rating') ?? 0;
                return $product;
            })
            ->sortByDesc('avg_rating')
            ->values();

        $pdf = Pdf::loadView('admin.reports.pdf.product-rating', compact('products'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-produk-rating-' . date('Y-m-d') . '.pdf');
    }
}
