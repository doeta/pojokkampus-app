<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Review;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display seller account status report
     * SRS-MartPlace-09
     */
    public function sellerAccounts()
    {
        $activeSellers = User::where('role', 'seller')
            ->where('status', 'active')
            ->with('seller')
            ->get();

        $inactiveSellers = User::where('role', 'seller')
            ->whereIn('status', ['pending', 'suspended'])
            ->with('seller')
            ->get();

        return view('admin.reports.seller-accounts', compact('activeSellers', 'inactiveSellers'));
    }

    /**
     * Generate PDF for seller account status report
     * SRS-MartPlace-09
     */
    public function sellerAccountsPdf()
    {
        $activeSellers = User::where('role', 'seller')
            ->where('status', 'active')
            ->with('seller')
            ->get();

        $inactiveSellers = User::where('role', 'seller')
            ->whereIn('status', ['pending', 'suspended'])
            ->with('seller')
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf.seller-accounts', compact('activeSellers', 'inactiveSellers'));

        return $pdf->download('laporan-akun-penjual-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Display store distribution by province report
     * SRS-MartPlace-10
     */
    public function storeDistribution()
    {
        $storesByProvince = Seller::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('provinsi')
            ->get()
            ->groupBy('provinsi');

        return view('admin.reports.store-distribution', compact('storesByProvince'));
    }

    /**
     * Generate PDF for store distribution report
     * SRS-MartPlace-10
     */
    public function storeDistributionPdf()
    {
        $storesByProvince = Seller::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('provinsi')
            ->get()
            ->groupBy('provinsi');

        $pdf = Pdf::loadView('admin.reports.pdf.store-distribution', compact('storesByProvince'));

        return $pdf->download('laporan-sebaran-toko-' . date('Y-m-d') . '.pdf');
    }
}
