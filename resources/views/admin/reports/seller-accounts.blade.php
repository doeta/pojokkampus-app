@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Laporan Status Akun Penjual</h1>
        <p class="text-gray-600 mt-1">Daftar penjual berdasarkan status (Aktif & Tidak Aktif) - SRS-MartPlace-09</p>
    </div>
    <a href="{{ route('admin.reports.seller-accounts.pdf') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Download PDF
    </a>
</div>

<!-- Active Sellers -->
<div class="bg-white rounded-lg border border-gray-200 mb-8">
    <div class="p-6 border-b border-gray-200 bg-green-50">
        <div class="flex items-center gap-3">
            <div class="bg-green-600 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Penjual Aktif</h2>
                <p class="text-sm text-gray-600">Total: {{ $activeSellers->count() }} penjual</p>
            </div>
        </div>
    </div>
    
    @if($activeSellers->isEmpty())
    <div class="p-8 text-center text-gray-500">
        Tidak ada penjual aktif
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penjual</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Toko</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Bergabung</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($activeSellers as $index => $seller)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $seller->name }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $seller->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $seller->seller->nama_toko ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $seller->seller->kabupaten_kota ?? '-' }}</div>
                        <div class="text-sm text-gray-500">{{ $seller->seller->provinsi ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $seller->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<!-- Inactive Sellers -->
<div class="bg-white rounded-lg border border-gray-200">
    <div class="p-6 border-b border-gray-200 bg-red-50">
        <div class="flex items-center gap-3">
            <div class="bg-red-600 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Penjual Tidak Aktif</h2>
                <p class="text-sm text-gray-600">Total: {{ $inactiveSellers->count() }} penjual (Pending & Suspended)</p>
            </div>
        </div>
    </div>
    
    @if($inactiveSellers->isEmpty())
    <div class="p-8 text-center text-gray-500">
        Tidak ada penjual tidak aktif
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penjual</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Toko</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($inactiveSellers as $index => $seller)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $seller->name }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $seller->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $seller->seller->nama_toko ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($seller->status === 'pending')
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Pending</span>
                        @else
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Suspended</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $seller->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
