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
                    <button onclick="showKTPModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg transition-colors font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat File KTP
                    </button>
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

<!-- KTP Preview Modal -->
@if($seller->seller && $seller->seller->file_ktp_pic)
<div id="ktpModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4" onclick="hideKTPModal()">
    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-900">Preview File KTP</h3>
            <div class="flex gap-2">
                <a href="{{ Storage::url($seller->seller->file_ktp_pic) }}" download class="px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg font-medium transition-colors inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download
                </a>
                <button onclick="hideKTPModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Modal Content -->
        <div class="p-4 overflow-auto max-h-[calc(90vh-80px)]">
            @php
                $fileExtension = strtolower(pathinfo($seller->seller->file_ktp_pic, PATHINFO_EXTENSION));
                $fileUrl = Storage::url($seller->seller->file_ktp_pic);
            @endphp
            
            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <!-- Image Preview -->
                <div class="flex justify-center">
                    <img src="{{ $fileUrl }}" alt="KTP Preview" class="max-w-full h-auto rounded-lg shadow-lg">
                </div>
            @elseif($fileExtension === 'pdf')
                <!-- PDF Preview -->
                <iframe src="{{ $fileUrl }}" class="w-full h-[70vh] rounded-lg border border-gray-300"></iframe>
            @else
                <!-- Unsupported File Type -->
                <div class="text-center py-12">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-600 mb-4">Preview tidak tersedia untuk tipe file ini</p>
                    <a href="{{ $fileUrl }}" download class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download File
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endif

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
function showKTPModal() {
    document.getElementById('ktpModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent body scroll
}

function hideKTPModal() {
    document.getElementById('ktpModal').classList.add('hidden');
    document.body.style.overflow = 'auto'; // Restore body scroll
}

function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideKTPModal();
        hideRejectModal();
    }
});
</script>
@endsection
