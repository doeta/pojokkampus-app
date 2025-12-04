@extends('layouts.seller')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Laporan Daftar Produk Berdasarkan Stock</h1>
        <p class="text-gray-600 mt-1">SRS-MartPlace-12 - Diurutkan berdasarkan stock tertinggi</p>
    </div>
    <a href="{{ route('seller.reports.stock.pdf') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Download PDF
    </a>
</div>

<!-- Summary Card -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg p-6 text-white mb-8">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-purple-100 text-sm font-medium">Total Produk</p>
            <p class="text-4xl font-bold mt-2">{{ $products->count() }}</p>
        </div>
        <div class="text-right">
            <p class="text-purple-100 text-sm font-medium">Total Stok Tersedia</p>
            <p class="text-4xl font-bold mt-2">{{ number_format($products->sum('stock')) }}</p>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">Daftar Produk</h2>
        <p class="text-sm text-gray-600 mt-1">Diurutkan dari stok terbanyak ke terkecil</p>
    </div>
    
    @if($products->isEmpty())
    <div class="p-8 text-center text-gray-500">
        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
        <p class="text-lg font-medium mb-2">Belum Ada Produk</p>
        <p class="text-sm mb-4">Mulai tambahkan produk untuk melihat laporan stok</p>
        <a href="{{ route('seller.products.create') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium">
            Tambah Produk
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
                <tr class="hover:bg-gray-50">
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
                                @if($product->stock < 2)
                                <span class="inline-block mt-1 px-2 py-0.5 bg-red-100 text-red-700 text-xs font-medium rounded">Butuh Restock</span>
                                @elseif($product->stock < 10)
                                <span class="inline-block mt-1 px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-medium rounded">Stok Menipis</span>
                                @endif
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
                        <div class="flex items-center justify-center gap-1">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900">{{ number_format($product->avg_rating, 2) }}</span>
                            <span class="text-xs text-gray-500">({{ $product->total_reviews }})</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-lg font-bold {{ $product->stock == 0 ? 'text-red-600' : ($product->stock < 2 ? 'text-orange-600' : 'text-gray-900') }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <div class="flex gap-3">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="text-sm text-blue-800">
            <p class="font-medium mb-1">Catatan:</p>
            <p>***) Produk diurutkan berdasarkan jumlah stok dari tertinggi ke terendah untuk membantu monitoring ketersediaan barang.</p>
        </div>
    </div>
</div>
@endsection
