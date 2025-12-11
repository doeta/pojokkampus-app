@extends('layouts.seller')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Penjual</h1>
    <p class="text-gray-500 mt-1">Ringkasan performa toko dan statistik penjualan</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Total Products -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-purple-100 p-3 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded-full">{{ $stats['active_products'] }} Aktif</span>
        </div>
        <p class="text-sm text-gray-500 font-medium">Total Produk</p>
        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['total_products']) }}</h3>
    </div>

    <!-- Total Stock -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-orange-100 p-3 rounded-lg">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
            </div>
            @if($stats['low_stock'] > 0)
                <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-full">{{ $stats['low_stock'] }} Menipis</span>
            @else
                <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">Stok Aman</span>
            @endif
        </div>
        <p class="text-sm text-gray-500 font-medium">Total Stok Unit</p>
        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['total_stock']) }}</h3>
    </div>
</div>

<!-- Charts Section (SRS-MartPlace-08) -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Stock Distribution Chart -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Sebaran Stok Produk</h3>
        <div class="relative h-80">
            <canvas id="stockByProductChart"></canvas>
        </div>
    </div>

    <!-- Rating Distribution Chart -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Performa Rating Produk</h3>
        <div class="relative h-80">
            <canvas id="ratingByProductChart"></canvas>
        </div>
    </div>

    <!-- Store Rating Distribution Chart -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm lg:col-span-2">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Sebaran Rating Toko (Bintang 1-5)</h3>
        <div class="relative h-80">
            <canvas id="storeRatingChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="mb-8">
    <!-- Recent Products -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Produk Terbaru</h2>
            <a href="{{ route('seller.products.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Lihat Semua</a>
        </div>
        <div class="flex-1 overflow-auto">
            @forelse($recent_products as $product)
            <div class="p-4 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0 flex gap-4">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover bg-gray-100">
                @else
                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</h4>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    <div class="flex items-center gap-2 mt-1.5">
                        <span class="text-xs font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="text-[10px] px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded">Stok: {{ $product->stock }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <p class="text-gray-500 text-sm">Belum ada produk ditambahkan.</p>
            </div>
            @endforelse
        </div>
        <div class="p-4 border-t border-gray-100 bg-gray-50 rounded-b-xl">
            <a href="{{ route('seller.products.create') }}" class="block w-full py-2 px-4 bg-white border border-gray-300 rounded-lg text-center text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-purple-600 transition-colors">
                + Tambah Produk Baru
            </a>
        </div>
    </div>
</div>

<!-- Chart Data -->
<div id="sellerChartData" style="display:none;"
     data-stock-product-names="{{ json_encode($stockByProduct->pluck('name')) }}"
     data-stock-product-values="{{ json_encode($stockByProduct->pluck('stock')) }}"
     data-rating-product-names="{{ json_encode($ratingByProduct->pluck('name')) }}"
     data-rating-product-values="{{ json_encode($ratingByProduct->pluck('rating')) }}"
     data-store-rating-labels="{{ json_encode($storeRatingDistribution->pluck('rating')) }}"
     data-store-rating-values="{{ json_encode($storeRatingDistribution->pluck('total')) }}">
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/seller-charts.js') }}"></script>
@endsection
