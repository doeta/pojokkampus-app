@extends('layouts.seller')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Produk Saya</h1>
            <p class="text-gray-600 mt-2">Kelola semua produk Anda</p>
        </div>
        <a href="{{ route('seller.products.create') }}"
            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
            + Tambah Produk
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-6 rounded-lg border border-gray-200">
            <p class="text-sm text-gray-600">Total Produk</p>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
            <p class="text-sm text-green-700">Aktif</p>
            <p class="text-3xl font-bold text-green-700">{{ $stats['active'] }}</p>
        </div>
        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
            <p class="text-sm text-yellow-700">Draft</p>
            <p class="text-3xl font-bold text-yellow-700">{{ $stats['draft'] }}</p>
        </div>
        <div class="bg-red-50 p-6 rounded-lg border border-red-200">
            <p class="text-sm text-red-700">Stok Habis</p>
            <p class="text-3xl font-bold text-red-700">{{ $stats['out_of_stock'] }}</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
        <form method="GET" class="flex gap-4">
            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('seller.products.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        @if($products->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Rating</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ Storage::url($product->image) }}" 
                                        class="w-16 h-16 object-cover rounded-lg border"
                                        alt="{{ $product->name }}">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                                        @if($product->sku)
                                            <p class="text-xs text-gray-400">SKU: {{ $product->sku }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium {{ $product->stock < 10 ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $product->stock }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->status == 'active')
                                    <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
                                @elseif($product->status == 'draft')
                                    <span class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Draft</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1">
                                    <span class="text-yellow-500">★</span>
                                    <span class="font-medium text-gray-900">{{ number_format($product->averageRating(), 1) }}</span>
                                    <span class="text-gray-400 text-sm">({{ $product->totalReviews() }})</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('seller.products.show', $product) }}"
                                        class="px-3 py-1 text-sm text-indigo-600 hover:bg-indigo-50 rounded">
                                        Lihat
                                    </a>
                                    <a href="{{ route('seller.products.edit', $product) }}"
                                        class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('seller.products.destroy', $product) }}" 
                                        onsubmit="return confirm('Yakin hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 text-sm text-red-600 hover:bg-red-50 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 border-t">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 mb-4">Belum ada produk</p>
                <a href="{{ route('seller.products.create') }}"
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium inline-block">
                    + Tambah Produk Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
