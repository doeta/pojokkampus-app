@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.sellers.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium mb-4 inline-block">
        ← Kembali ke Daftar Penjual
    </a>
    <h1 class="text-3xl font-bold text-gray-900">Detail Penjual</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Informasi Akun</h2>
                @if($seller->status === 'pending')
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                        Pending Approval
                    </span>
                @elseif($seller->status === 'active')
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                        Active
                    </span>
                @else
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">
                        Suspended
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nama Lengkap</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $seller->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $seller->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal Daftar</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $seller->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status Verifikasi</p>
                    <p class="font-medium text-gray-900 mt-1">{{ ucfirst($seller->seller->verification_status ?? 'pending') }}</p>
                </div>
            </div>
        </div>

        <!-- Store Info -->
        @if($seller->seller)
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Toko</h2>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Nama Toko</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $seller->seller->nama_toko }}</p>
                </div>
                
                @if($seller->seller->deskripsi_singkat)
                <div>
                    <p class="text-sm text-gray-600">Deskripsi</p>
                    <p class="text-gray-900 mt-1">{{ $seller->seller->deskripsi_singkat }}</p>
                </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nama PIC</p>
                        <p class="font-medium text-gray-900 mt-1">{{ $seller->seller->nama_pic }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email PIC</p>
                        <p class="font-medium text-gray-900 mt-1">{{ $seller->seller->email_pic }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">No. KTP</p>
                        <p class="font-medium text-gray-900 mt-1">{{ $seller->seller->no_ktp_pic }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Alamat Toko</p>
                    <p class="text-gray-900 mt-1">
                        {{ $seller->seller->alamat }}<br>
                        Kel. {{ $seller->seller->nama_kelurahan }}, Kec. {{ $seller->seller->kecamatan }}<br>
                        {{ $seller->seller->kabupaten_kota }}, {{ $seller->seller->provinsi }}
                    </p>
                </div>

                @if($seller->seller->file_ktp_pic)
                <div>
                    <p class="text-sm text-gray-600 mb-2">File KTP</p>
                    <a href="{{ Storage::url($seller->seller->file_ktp_pic) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat File KTP
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Products -->
        @if($seller->products->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Produk ({{ $seller->products->count() }})</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($seller->products as $product)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 transition-colors">
                    <div class="flex gap-4">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-20 h-20 rounded-lg object-cover">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-gray-600 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Stock: {{ $product->stock }} • Sold: {{ $product->sold }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Actions Sidebar -->
    <div class="space-y-6">
        <!-- Actions Card -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Aksi</h3>
            
            <div class="space-y-3">
                @if($seller->status === 'pending')
                    <form method="POST" action="{{ route('admin.sellers.approve', $seller) }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                            ✓ Approve Penjual
                        </button>
                    </form>

                    <button onclick="showRejectModal()" class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                        ✗ Reject Penjual
                    </button>
                @elseif($seller->status === 'active')
                    <form method="POST" action="{{ route('admin.sellers.suspend', $seller) }}" onsubmit="return confirm('Yakin ingin suspend penjual ini?')">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                            Suspend Penjual
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.sellers.activate', $seller) }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                            Aktifkan Kembali
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Stats Card -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Statistik</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Total Produk</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $seller->products->count() }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Produk Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $seller->products->where('status', 'active')->count() }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Terjual</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $seller->products->sum('sold') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Penjual</h3>
        
        <form method="POST" action="{{ route('admin.sellers.reject', $seller) }}">
            @csrf
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Penolakan <span class="text-red-500">*</span>
                </label>
                <textarea id="rejection_reason" name="rejection_reason" rows="4" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Jelaskan alasan penolakan..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="hideRejectModal()" 
                    class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    Reject
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection
