@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
    <p class="text-gray-600 mt-1">Statistik dan Monitoring Platform PojokKampus</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
    <!-- Total Sellers -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Penjual</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_sellers']) }}</p>
            </div>
            <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2">
            <span class="text-sm text-yellow-600 font-medium">{{ $stats['pending_sellers'] }} Pending</span>
            <span class="text-gray-300">•</span>
            <span class="text-sm text-green-600 font-medium">{{ $stats['active_sellers'] }} Active</span>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Produk</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_products']) }}</p>
            </div>
            <div class="bg-purple-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-sm text-green-600 font-medium">{{ $stats['active_products'] }} Produk Aktif</span>
        </div>
    </div>
</div>

<!-- Reports Section -->
<div class="mb-8">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Laporan</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- SRS-09 -->
        <a href="{{ route('admin.reports.seller-accounts') }}" class="block bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Laporan Akun Penjual</h3>
            </div>
            <p class="text-sm text-gray-600">Daftar akun penjual berdasarkan status (Aktif/Tidak Aktif).</p>
            <div class="mt-4 text-blue-600 text-sm font-medium">Lihat Laporan →</div>
        </a>

        <!-- SRS-10 -->
        <a href="{{ route('admin.reports.store-distribution') }}" class="block bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Laporan Lokasi Toko</h3>
            </div>
            <p class="text-sm text-gray-600">Daftar toko berdasarkan lokasi provinsi.</p>
            <div class="mt-4 text-green-600 text-sm font-medium">Lihat Laporan →</div>
        </a>

        <!-- SRS-11 -->
        <a href="{{ route('admin.reports.rating') }}" class="block bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-yellow-100 p-3 rounded-full mr-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Laporan Rating Produk</h3>
            </div>
            <p class="text-sm text-gray-600">Daftar produk berdasarkan rating tertinggi.</p>
            <div class="mt-4 text-yellow-600 text-sm font-medium">Lihat Laporan →</div>
        </a>
    </div>
</div>

<!-- Recent Sellers -->
<div class="mb-8">
    <div class="bg-white rounded-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">Penjual Terbaru</h2>
                <a href="{{ route('admin.sellers.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recent_sellers as $seller)
            <div class="p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-indigo-100 w-10 h-10 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 font-bold">{{ substr($seller->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $seller->name }}</p>
                            <p class="text-sm text-gray-500">{{ $seller->seller->nama_toko ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($seller->status === 'pending')
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Pending</span>
                        @elseif($seller->status === 'active')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                        @else
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Suspended</span>
                        @endif
                        <p class="text-xs text-gray-500 mt-1">{{ $seller->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                Belum ada penjual terdaftar
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Charts Section (SRS-MartPlace-07) -->
<div class="mt-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Grafik & Statistik</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Product Distribution by Category -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Sebaran Produk per Kategori</h3>
            <canvas id="productsByCategoryChart" style="max-height: 300px;"></canvas>
        </div>

        <!-- Store Distribution by Province -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Sebaran Toko per Provinsi (Top 10)</h3>
            <canvas id="storesByProvinceChart" style="max-height: 300px;"></canvas>
        </div>

        <!-- Seller Status Statistics -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Status Penjual</h3>
            <canvas id="sellerStatusChart" style="max-height: 300px;"></canvas>
        </div>

        <!-- Review Statistics (SRS-06) -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik Review</h3>
            <canvas id="participationChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- Chart Data -->
<div id="chartData" style="display:none;"
     data-product-category-names="{{ json_encode($productsByCategory->pluck('name')) }}"
     data-product-category-totals="{{ json_encode($productsByCategory->pluck('total')) }}"
     data-province-names="{{ json_encode($storesByProvince->pluck('provinsi')) }}"
     data-province-totals="{{ json_encode($storesByProvince->pluck('total')) }}"
     data-seller-active="{{ $sellerStats['active'] }}"
     data-seller-inactive="{{ $sellerStats['inactive'] }}"
     data-total-reviews="{{ $participationStats['total_reviews'] }}"
     data-unique-reviewers="{{ $participationStats['unique_reviewers'] }}">
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/admin-charts.js') }}"></script>
@endsection
