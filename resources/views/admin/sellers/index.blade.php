@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Kelola Penjual</h1>
    <p class="text-gray-600 mt-1">Approve, reject, atau kelola penjual yang terdaftar</p>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-lg border border-gray-200 mb-6">
    <div class="flex border-b border-gray-200">
        <a href="{{ route('admin.sellers.index') }}?status=all" class="px-6 py-4 {{ request('status', 'all') === 'all' ? 'border-b-2 border-indigo-600 text-indigo-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
            Semua ({{ $sellers->total() }})
        </a>
        <a href="{{ route('admin.sellers.index') }}?status=pending" class="px-6 py-4 {{ request('status') === 'pending' ? 'border-b-2 border-indigo-600 text-indigo-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
            Pending
        </a>
        <a href="{{ route('admin.sellers.index') }}?status=active" class="px-6 py-4 {{ request('status') === 'active' ? 'border-b-2 border-indigo-600 text-indigo-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
            Active
        </a>
        <a href="{{ route('admin.sellers.index') }}?status=suspended" class="px-6 py-4 {{ request('status') === 'suspended' ? 'border-b-2 border-indigo-600 text-indigo-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
            Suspended
        </a>
    </div>
</div>

<!-- Sellers Table -->
<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penjual</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Toko</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($sellers as $seller)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-indigo-600 font-bold">{{ substr($seller->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $seller->name }}</div>
                            <div class="text-sm text-gray-500">{{ $seller->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ $seller->seller->nama_toko ?? '-' }}</div>
                    <div class="text-sm text-gray-500">{{ $seller->seller->nama_kelurahan ?? '-' }}, {{ $seller->seller->kabupaten_kota ?? '-' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($seller->status === 'pending')
                        <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    @elseif($seller->status === 'active')
                        <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                            Suspended
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $seller->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.sellers.show', $seller) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    Tidak ada data penjual
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($sellers->hasPages())
<div class="mt-6">
    {{ $sellers->links() }}
</div>
@endif
@endsection
