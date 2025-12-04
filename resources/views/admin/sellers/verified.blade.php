@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Riwayat Verifikasi</h1>
    <p class="text-gray-600 mt-1">Daftar penjual yang telah diverifikasi (disetujui/ditolak)</p>
</div>

@if($sellers->isEmpty())
<div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
    </svg>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada riwayat verifikasi</h3>
    <p class="text-gray-500">Belum ada penjual yang diverifikasi</p>
</div>
@else
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penjual</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Toko</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diverifikasi Oleh</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($sellers as $seller)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="bg-teal-100 w-10 h-10 rounded-full flex items-center justify-center">
                            <span class="text-teal-600 font-bold">{{ substr($seller->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $seller->name }}</div>
                            <div class="text-sm text-gray-500">{{ $seller->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ $seller->seller->nama_toko ?? '-' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($seller->seller->verification_status === 'approved')
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Disetujui
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Ditolak
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ $seller->seller->verifier->name ?? '-' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($seller->seller->verified_at)
                        <div class="text-sm text-gray-900">{{ $seller->seller->verified_at->format('d/m/Y H:i') }}</div>
                        <div class="text-sm text-gray-500">{{ $seller->seller->verified_at->diffForHumans() }}</div>
                    @else
                        <div class="text-sm text-gray-500">-</div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.sellers.show', $seller) }}" class="text-teal-600 hover:text-teal-700 font-medium">
                        Lihat Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $sellers->links() }}
</div>
@endif
@endsection
