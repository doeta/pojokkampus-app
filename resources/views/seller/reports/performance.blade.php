@extends('layouts.seller')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Laporan Daftar Produk Berdasarkan Rating</h1>
        <p class="text-sm text-gray-500 mt-1">Daftar produk diurutkan dari rating tertinggi</p>
    </div>
    <a href="{{ route('seller.reports.performance.pdf') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded hover:bg-gray-700 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Download PDF
    </a>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded border border-gray-200 p-4">
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wider">Produk Bintang 5</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $products->where('avg_rating', '>=', 4.5)->count() }}</p>
    </div>
    <div class="bg-white rounded border border-gray-200 p-4">
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wider">Rata-rata Rating</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $products->avg('avg_rating') > 0 ? number_format($products->avg('avg_rating'), 2) : '0.00' }}</p>
    </div>
    <div class="bg-white rounded border border-gray-200 p-4">
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wider">Total Review</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($products->sum('total_reviews')) }}</p>
    </div>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">Daftar Produk Berdasarkan Rating</h2>
        <p class="text-sm text-gray-600 mt-1">Diurutkan dari rating tertinggi (★5.0) ke terendah</p>
    </div>
    
    @if($products->isEmpty())
    <div class="p-8 text-center text-gray-500">
        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
        </svg>
        <p class="text-lg font-medium mb-2">Belum Ada Produk</p>
        <p class="text-sm mb-4">Mulai tambahkan produk untuk melihat laporan performa</p>
        <a href="{{ route('seller.products.create') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium">
            Tambah Produk
        </a>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 font-medium">
                <tr>
                    <th class="px-4 py-3 w-16 text-center">No</th>
                    <th class="px-4 py-3">Produk</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3 text-right">Harga</th>
                    <th class="px-4 py-3 text-center">Stock</th>
                    <th class="px-4 py-3 text-center">Rating</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $index => $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-center text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-right text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-center text-gray-600">{{ $product->stock }}</td>
                    <td class="px-4 py-3 text-center font-medium text-gray-900">
                        {{ number_format($product->avg_rating, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $products->links() }}
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
            <p>***) Produk diurutkan berdasarkan rating dari bintang 5 ke bawah. Rating yang tinggi menunjukkan kepuasan pelanggan yang baik.</p>
        </div>
    </div>
</div>
@endsection
