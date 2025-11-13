<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Seller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sellers' => User::where('role', 'seller')->count(),
            'pending_sellers' => User::where('role', 'seller')->where('status', 'pending')->count(),
            'active_sellers' => User::where('role', 'seller')->where('status', 'active')->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total'),
        ];

        $recent_sellers = User::where('role', 'seller')
            ->with('seller')
            ->latest()
            ->take(5)
            ->get();

        $recent_orders = Order::with(['user', 'seller', 'product'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_sellers', 'recent_orders'));
    }
}
