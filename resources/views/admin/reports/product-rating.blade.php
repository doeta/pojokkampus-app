@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <!-- Header & Stats -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Rating Produk</h1>
            <p class="text-sm text-gray-500">Daftar produk berdasarkan rating tertinggi</p>
        </div>
        
        <!-- Compact Stats -->
        <div class="flex flex-wrap gap-3">
            <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Total Produk</p>
                    <p class="text-lg font-bold text-gray-900 leading-none">{{ $totalProducts ?? $products->total() }}</p>
                </div>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-yellow-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Tertinggi</p>
                    <p class="text-lg font-bold text-gray-900 leading-none">{{ number_format($maxRating ?? 0, 1) }}</p>
                </div>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Rata-rata</p>
                    <p class="text-lg font-bold text-gray-900 leading-none">{{ number_format($averageRating ?? 0, 1) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Toolbar -->
        <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row gap-4 justify-between items-center bg-gray-50/50 rounded-t-xl">
            <!-- Left Side (Title/Info) -->
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Data Produk</span>
                <span class="px-2 py-0.5 rounded-full bg-gray-200 text-xs text-gray-600">{{ $products->total() }} items</span>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.reports.rating.pdf') }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 font-medium">No</th>
                        <th class="px-6 py-3 font-medium">Produk</th>
                        <th class="px-6 py-3 font-medium">Kategori</th>
                        <th class="px-6 py-3 font-medium text-right">Harga</th>
                        <th class="px-6 py-3 font-medium text-center">Rating</th>
                        <th class="px-6 py-3 font-medium">Toko</th>
                        <th class="px-6 py-3 font-medium">Lokasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($products as $index => $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500">{{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-900 text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-yellow-50 text-yellow-700 font-bold text-xs">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                {{ number_format($product->avg_rating, 1) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $product->seller->seller->nama_toko ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $product->seller->seller->provinsi ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada data ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span>Show</span>
                <select onchange="window.location.href='{{ route('admin.reports.rating') }}?per_page=' + this.value" class="border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                </select>
                <span>entries</span>
            </div>
            <div>
                {{ $products->appends(['per_page' => $perPage])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
