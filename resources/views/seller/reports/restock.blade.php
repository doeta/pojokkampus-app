@extends('layouts.seller')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Laporan Daftar Produk Segera Dipesan</h1>
        <p class="text-gray-600 mt-1">SRS-MartPlace-14 - Produk dengan stock < 2 unit</p>
    </div>
    <a href="{{ route('seller.reports.restock.pdf') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Download PDF
    </a>
</div>

<!-- Alert Banner -->
@if($products->isNotEmpty())
<div class="bg-red-50 border-l-4 border-red-600 p-6 mb-8">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <div class="ml-3">
            <h3 class="text-lg font-bold text-red-800">Peringatan Stok Menipis!</h3>
            <p class="text-red-700 mt-1">{{ $products->count() }} produk membutuhkan restock segera. Segera lakukan pemesanan atau produksi ulang untuk menghindari kehabisan stok.</p>
        </div>
    </div>
</div>
@endif

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-r from-red-500 to-pink-600 rounded-lg p-6 text-white">
        <p class="text-red-100 text-sm font-medium">Stok Habis (0)</p>
        <p class="text-4xl font-bold mt-2">{{ $products->where('stock', 0)->count() }}</p>
    </div>
    <div class="bg-gradient-to-r from-orange-500 to-amber-600 rounded-lg p-6 text-white">
        <p class="text-orange-100 text-sm font-medium">Stok Kritis (1)</p>
        <p class="text-4xl font-bold mt-2">{{ $products->where('stock', 1)->count() }}</p>
    </div>
    <div class="bg-gradient-to-r from-yellow-500 to-orange-400 rounded-lg p-6 text-white">
        <p class="text-yellow-100 text-sm font-medium">Total Butuh Restock</p>
        <p class="text-4xl font-bold mt-2">{{ $products->count() }}</p>
    </div>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">Daftar Produk Butuh Restock</h2>
        <p class="text-sm text-gray-600 mt-1">Produk dengan stok < 2 unit</p>
    </div>
    
    @if($products->isEmpty())
    <div class="p-8 text-center text-gray-500">
        <svg class="w-16 h-16 mx-auto text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-lg font-medium text-green-600 mb-2">Stok Aman!</p>
        <p class="text-sm">Tidak ada produk yang membutuhkan restock saat ini.</p>
        <a href="{{ route('seller.reports.stock') }}" class="inline-block mt-4 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium">
            Lihat Laporan Stok Lengkap
        </a>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $index => $product)
                <tr class="hover:bg-gray-50 {{ $product->stock == 0 ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center">
                                <span class="text-white font-bold text-lg">{{ substr($product->name, 0, 1) }}</span>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">SKU: {{ $product->sku ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">
                            {{ $product->category->name ?? 'Tanpa Kategori' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-sm font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center">
                            <span class="text-yellow-500">★</span>
                            <span class="ml-1 text-sm font-medium text-gray-900">{{ number_format($product->avg_rating, 1) }}</span>
                            <span class="ml-1 text-xs text-gray-500">({{ $product->total_reviews }})</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col items-center gap-1">
                            <span class="text-2xl font-bold {{ $product->stock == 0 ? 'text-red-600' : 'text-orange-600' }}">
                                {{ $product->stock }}
                            </span>
                            @if($product->stock == 0)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 text-red-700 text-xs font-bold rounded">
                                ❌ HABIS
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-orange-100 text-orange-700 text-xs font-bold rounded">
                                ⚠️ KRITIS
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Action Footer -->
    <div class="p-6 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                <p class="font-medium">Rekomendasi Tindakan:</p>
                <ul class="mt-2 space-y-1 list-disc list-inside">
                    <li>Segera lakukan pemesanan stok untuk produk yang habis</li>
                    <li>Perhatikan produk dengan rating tinggi yang stoknya menipis</li>
                    <li>Pertimbangkan untuk menonaktifkan produk yang habis sementara</li>
                </ul>
            </div>
            <a href="{{ route('seller.products.index') }}" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium transition-colors">
                Kelola Produk
            </a>
        </div>
    </div>
    @endif
</div>

<div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <div class="flex gap-3">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="text-sm text-blue-800">
            <p class="font-medium mb-1">Catatan Penting:</p>
            <p>***) Laporan ini menampilkan produk dengan stok kurang dari 2 unit. Segera lakukan restock untuk menghindari kehilangan penjualan.</p>
        </div>
    </div>
</div>
@endsection
