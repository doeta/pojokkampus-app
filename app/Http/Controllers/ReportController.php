<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    private function getReportData()
    {
        return [
            'generatedBy' => Auth::user()->name,
            'generatedAt' => now()->format('d-m-Y'),
        ];
    }

    // SRS-9: Laporan daftar akun penjual berdasarkan aktif dan tidak aktif
    public function sellerAccounts()
    {
        $sellers = Seller::with('user')
            ->get()
            ->sortBy(function ($seller) {
                $order = ['approved' => 1, 'pending' => 2, 'rejected' => 3];
                return $order[$seller->verification_status] ?? 4;
            });

        $data = array_merge($this->getReportData(), ['sellers' => $sellers]);
        $pdf = Pdf::loadView('reports.seller_accounts', $data);
        return $pdf->stream('laporan-akun-penjual.pdf');
    }

    // SRS-10: Laporan daftar penjual (toko) untuk setiap Lokasi provinsi
    public function sellersByProvince()
    {
        $sellers = Seller::orderBy('provinsi')
            ->get();

        $data = array_merge($this->getReportData(), ['sellers' => $sellers]);
        $pdf = Pdf::loadView('reports.sellers_by_province', $data);
        return $pdf->stream('laporan-penjual-per-provinsi.pdf');
    }

    // SRS-11: Laporan daftar produk dan ratingnya yang diurutkan berdasarkan rating secara menurun
    public function productsByRating()
    {
        $products = Product::with(['seller.seller', 'category'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->get();

        $data = array_merge($this->getReportData(), ['products' => $products]);
        $pdf = Pdf::loadView('reports.products_by_rating', $data);
        return $pdf->stream('laporan-produk-rating.pdf');
    }

    // SRS-12: (Penjual) Laporan daftar stock produk yang diurutkan berdasarkan stock secara menurun
    public function sellerStock()
    {
        $user = Auth::user();
        
        if (!$user->isSeller()) {
            abort(403, 'Unauthorized');
        }

        $products = Product::where('user_id', $user->id)
            ->with(['category'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('stock')
            ->get();

        $data = array_merge($this->getReportData(), ['products' => $products]);
        $pdf = Pdf::loadView('reports.seller_stock', $data);
        return $pdf->stream('laporan-stok-produk.pdf');
    }

    // SRS-13: (Penjual) Laporan daftar stock produk yang diurutkan berdasarkan rating secara menurun
    public function sellerStockByRating()
    {
        $user = Auth::user();
        
        if (!$user->isSeller()) {
            abort(403, 'Unauthorized');
        }

        $products = Product::where('user_id', $user->id)
            ->with(['category'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->get();

        $data = array_merge($this->getReportData(), ['products' => $products]);
        $pdf = Pdf::loadView('reports.seller_stock_by_rating', $data);
        return $pdf->stream('laporan-stok-berdasarkan-rating.pdf');
    }

    // SRS-14: (Penjual) Laporan daftar stock barang yang harus segera di pesan (stock < 2)
    public function urgentStock()
    {
        $user = Auth::user();
        
        if (!$user->isSeller()) {
            abort(403, 'Unauthorized');
        }

        $products = Product::where('user_id', $user->id)
            ->where('stock', '<', 2)
            ->with(['category'])
            ->orderBy('category_id') // Sort by category first
            ->orderBy('name')        // Then by product name
            ->get();

        $data = array_merge($this->getReportData(), ['products' => $products]);
        $pdf = Pdf::loadView('reports.urgent_stock', $data);
        return $pdf->stream('laporan-stok-menipis.pdf');
    }
}
