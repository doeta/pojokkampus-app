@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <!-- Header & Stats -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Status Akun</h1>
            <p class="text-sm text-gray-500">Monitoring status keaktifan penjual</p>
        </div>
        
        <!-- Compact Stats -->
        <div class="flex gap-3">
            <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Aktif</p>
                    <p class="text-lg font-bold text-gray-900 leading-none">{{ $totalActive }}</p>
                </div>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Non-Aktif</p>
                    <p class="text-lg font-bold text-gray-900 leading-none">{{ $totalInactive }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Toolbar -->
        <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row gap-4 justify-between items-center bg-gray-50/50 rounded-t-xl">
            <!-- Filter Tabs -->
            <div class="flex p-1 bg-white border border-gray-200 rounded-lg">
                <a href="{{ route('admin.reports.seller-accounts', ['filter' => 'all']) }}" 
                   class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ (!isset($filter) || $filter === 'all') ? 'bg-gray-900 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                    Semua
                </a>
                <a href="{{ route('admin.reports.seller-accounts', ['filter' => 'active']) }}" 
                   class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ (isset($filter) && $filter === 'active') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                    Aktif
                </a>
                <a href="{{ route('admin.reports.seller-accounts', ['filter' => 'inactive']) }}" 
                   class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ (isset($filter) && $filter === 'inactive') ? 'bg-gray-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                    Non-Aktif
                </a>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.reports.seller-accounts.pdf', ['filter' => $filter ?? 'all']) }}" target="_blank" 
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
                        <th class="px-6 py-3 font-medium">Penjual</th>
                        <th class="px-6 py-3 font-medium">Toko</th>
                        <th class="px-6 py-3 font-medium">Lokasi</th>
                        <th class="px-6 py-3 font-medium">Bergabung</th>
                        <th class="px-6 py-3 font-medium text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($sellers as $index => $seller)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500">{{ ($sellers->currentPage() - 1) * $sellers->perPage() + $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $seller->name }}</div>
                            <div class="text-gray-500 text-xs">{{ $seller->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $seller->seller->nama_toko ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">{{ $seller->seller->kabupaten_kota ?? '-' }}</div>
                            <div class="text-gray-500 text-xs">{{ $seller->seller->provinsi ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $seller->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $seller->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $seller->status === 'active' ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span>Show</span>
                <select onchange="window.location.href='{{ route('admin.reports.seller-accounts', ['filter' => $filter]) }}&per_page=' + this.value" class="border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                </select>
                <span>entries</span>
            </div>
            <div>
                {{ $sellers->appends(['filter' => $filter, 'per_page' => $perPage])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
