@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Laporan Sebaran Toko per Wilayah</h1>
        <p class="text-gray-600 mt-1">Distribusi toko penjual berdasarkan provinsi - SRS-MartPlace-10</p>
    </div>
    <a href="{{ route('admin.reports.store-distribution.pdf') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Download PDF
    </a>
</div>

<!-- Summary Cards -->
@php
    $totalStores = $storesByProvince->sum(fn($sellers) => $sellers->count());
    $provinceWithMostStores = $storesByProvince->sortByDesc(fn($sellers) => $sellers->count())->keys()->first();
    $mostStoresCount = $storesByProvince->sortByDesc(fn($sellers) => $sellers->count())->first()?->count() ?? 0;
@endphp
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Toko Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStores }}</p>
            </div>
            <div class="bg-teal-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Jumlah Provinsi</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $storesByProvince->count() }}</p>
            </div>
            <div class="bg-cyan-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Provinsi Terbanyak</p>
                <p class="text-lg font-bold text-gray-900 mt-2">{{ $provinceWithMostStores ?? '-' }}</p>
                <p class="text-sm text-gray-500">{{ $mostStoresCount }} toko</p>
            </div>
            <div class="bg-indigo-100 w-12 h-12 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Distribution Table -->
<div class="bg-white rounded-lg border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">Sebaran Toko per Provinsi</h2>
        <p class="text-sm text-gray-600 mt-1">Daftar lengkap toko diurutkan berdasarkan provinsi</p>
    </div>
    
    @if($storesByProvince->isEmpty())
    <div class="p-8 text-center text-gray-500">
        Tidak ada data toko
    </div>
    @else
    <div class="overflow-x-auto">
        @php $no = 1; @endphp
        @foreach($storesByProvince as $provinsi => $sellers)
        <div class="border-b border-gray-200 last:border-0">
            <div class="bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900">{{ $provinsi }}</h3>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-teal-100 text-teal-800">
                        {{ $sellers->count() }} Toko
                    </span>
                </div>
            </div>
            
            <table class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Toko</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama PIC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kabupaten/Kota</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($sellers as $seller)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $no++ }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($seller->logo_toko)
                                <img src="{{ Storage::url($seller->logo_toko) }}" alt="{{ $seller->nama_toko }}" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">{{ substr($seller->nama_toko, 0, 1) }}</span>
                                </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $seller->nama_toko }}</p>
                                    <p class="text-xs text-gray-500">{{ $seller->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $seller->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $seller->kabupaten_kota }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
