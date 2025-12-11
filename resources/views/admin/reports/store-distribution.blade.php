@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <!-- Header & Stats -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Sebaran Toko</h1>
            <p class="text-sm text-gray-500">Distribusi toko penjual berdasarkan provinsi</p>
        </div>
        
        <!-- Compact Stats -->
        @php
            $storesByProvince = $stores->groupBy('provinsi');
            $totalStores = $stores->count();
            $provinceWithMostStores = $storesByProvince->sortByDesc(fn($sellers) => $sellers->count())->keys()->first();
            $mostStoresCount = $storesByProvince->sortByDesc(fn($sellers) => $sellers->count())->first()?->count() ?? 0;
        @endphp
        <div class="flex flex-wrap gap-3">
            <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Total Toko</p>
                    <p class="text-lg font-bold text-gray-900 leading-none">{{ $totalStores }}</p>
                </div>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-cyan-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Provinsi</p>
                    <p class="text-lg font-bold text-gray-900 leading-none">{{ $storesByProvince->count() }}</p>
                </div>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Terbanyak</p>
                    <p class="text-lg font-bold text-gray-900 leading-none truncate max-w-[100px]" title="{{ $provinceWithMostStores ?? '-' }}">{{ $provinceWithMostStores ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Toolbar -->
        <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row gap-4 justify-between items-center bg-gray-50/50 rounded-t-xl">
            <!-- Filter Dropdown -->
            <form method="GET" action="{{ route('admin.reports.store-distribution') }}" class="flex items-center gap-2 w-full sm:w-auto">
                <label for="provinsi" class="text-sm font-medium text-gray-700 whitespace-nowrap">Filter:</label>
                <select name="provinsi" id="provinsi" onchange="this.form.submit()" class="block w-full sm:w-64 pl-3 pr-10 py-1.5 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="all" {{ $provinsi === 'all' ? 'selected' : '' }}>Semua Provinsi</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province }}" {{ $provinsi === $province ? 'selected' : '' }}>{{ $province }}</option>
                    @endforeach
                </select>
            </form>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.reports.store-distribution.pdf', ['provinsi' => $provinsi]) }}" target="_blank" 
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
                        <th class="px-6 py-3 font-medium">Nama Toko</th>
                        <th class="px-6 py-3 font-medium">Nama PIC</th>
                        <th class="px-6 py-3 font-medium">Provinsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($stores as $index => $store)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500">{{ ($stores->currentPage() - 1) * $stores->perPage() + $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $store->nama_toko }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $store->nama_pic }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $store->provinsi }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Tidak ada data ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span>Show</span>
                <select onchange="window.location.href='{{ route('admin.reports.store-distribution') }}?provinsi={{ $provinsi }}&per_page=' + this.value" class="border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                </select>
                <span>entries</span>
            </div>
            <div>
                {{ $stores->appends(['per_page' => $perPage, 'provinsi' => $provinsi])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
