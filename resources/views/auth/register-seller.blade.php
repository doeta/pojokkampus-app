<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Penjual - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <a href="{{ route('welcome') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 mb-6 font-medium text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
                
                <div class="inline-block bg-indigo-600 p-4 rounded-xl shadow-lg mb-4">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold mb-2 text-gray-900">
                    Daftar Sebagai Penjual
                </h1>
                <p class="text-gray-600 text-base md:text-lg">
                    Bergabunglah dengan ribuan penjual sukses lainnya 🚀
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <form method="POST" action="{{ route('seller.register') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Progress Header -->
                    <div class="bg-gray-50 px-6 md:px-8 py-6 border-b border-gray-200">
                        <div class="flex items-center justify-between text-xs md:text-sm">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mb-2 shadow-md">1</div>
                                <span class="font-medium hidden sm:inline text-gray-900">Akun</span>
                            </div>
                            <div class="h-0.5 flex-1 bg-gray-300 mx-2 md:mx-4"></div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-bold mb-2">2</div>
                                <span class="font-medium hidden sm:inline text-gray-500">Toko</span>
                            </div>
                            <div class="h-0.5 flex-1 bg-gray-300 mx-2 md:mx-4"></div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-bold mb-2">3</div>
                                <span class="font-medium hidden sm:inline text-gray-500">Dokumen</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 md:p-8 space-y-8">
                        <!-- Section 1: Account Info -->
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <div class="flex items-center mb-6">
                                <div class="bg-indigo-600 w-12 h-12 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900">Informasi Akun</h3>
                                    <p class="text-sm text-gray-600">Data untuk login ke sistem</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="email@example.com">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input id="password" type="password" name="password" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="Minimal 8 karakter">
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Konfirmasi Password <span class="text-red-500">*</span>
                                    </label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="Ulangi password">
                                    @error('password_confirmation')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Store Info -->
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <div class="flex items-center mb-6">
                                <div class="bg-indigo-600 w-12 h-12 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900">Informasi Toko</h3>
                                    <p class="text-sm text-gray-600">Detail toko dan lokasi</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="nama_toko" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nama Toko <span class="text-red-500">*</span>
                                    </label>
                                    <input id="nama_toko" type="text" name="nama_toko" value="{{ old('nama_toko') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="Nama toko Anda">
                                    @error('nama_toko')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="deskripsi_singkat" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Deskripsi Toko (Optional)
                                    </label>
                                    <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="Jelaskan tentang toko Anda...">{{ old('deskripsi_singkat') }}</textarea>
                                    @error('deskripsi_singkat')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nama_pic" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nama Penanggung Jawab <span class="text-red-500">*</span>
                                        </label>
                                        <input id="nama_pic" type="text" name="nama_pic" value="{{ old('nama_pic') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                        @error('nama_pic')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="email_pic" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Email PIC <span class="text-red-500">*</span>
                                        </label>
                                        <input id="email_pic" type="email" name="email_pic" value="{{ old('email_pic') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                        @error('email_pic')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Alamat Lengkap Toko <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="alamat" name="alamat" rows="2" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="Jalan, nomor, RT/RW...">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nama_kelurahan" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Kelurahan <span class="text-red-500">*</span>
                                        </label>
                                        <input id="nama_kelurahan" type="text" name="nama_kelurahan" value="{{ old('nama_kelurahan') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                        @error('nama_kelurahan')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="kecamatan" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Kecamatan <span class="text-red-500">*</span>
                                        </label>
                                        <input id="kecamatan" type="text" name="kecamatan" value="{{ old('kecamatan') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                        @error('kecamatan')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="kabupaten_kota" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Kabupaten/Kota <span class="text-red-500">*</span>
                                        </label>
                                        <input id="kabupaten_kota" type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                        @error('kabupaten_kota')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="provinsi" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Provinsi <span class="text-red-500">*</span>
                                        </label>
                                        <input id="provinsi" type="text" name="provinsi" value="{{ old('provinsi') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                        @error('provinsi')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Documents -->
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <div class="flex items-center mb-6">
                                <div class="bg-indigo-600 w-12 h-12 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900">Dokumen Verifikasi</h3>
                                    <p class="text-sm text-gray-600">Upload dokumen KTP untuk verifikasi</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="no_ktp_pic" class="block text-sm font-semibold text-gray-700 mb-2">
                                        No. KTP (16 digit) <span class="text-red-500">*</span>
                                    </label>
                                    <input id="no_ktp_pic" type="text" name="no_ktp_pic" value="{{ old('no_ktp_pic') }}" required
                                        maxlength="16" pattern="[0-9]{16}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="1234567890123456">
                                    @error('no_ktp_pic')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="alamat_ktp_pic" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Alamat sesuai KTP <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="alamat_ktp_pic" name="alamat_ktp_pic" rows="2" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="Alamat lengkap sesuai KTP...">{{ old('alamat_ktp_pic') }}</textarea>
                                    @error('alamat_ktp_pic')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="file_ktp_pic" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Upload File KTP <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input id="file_ktp_pic" type="file" name="file_ktp_pic" required
                                            accept=".jpg,.jpeg,.png,.pdf"
                                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                        <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG, atau PDF. Maksimal 2MB</p>
                                    </div>
                                    @error('file_ktp_pic')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors">
                                Sudah punya akun? Login di sini
                            </a>
                            <button type="submit"
                                class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold text-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Daftar Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Real-time validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            
            // Validation rules
            const validationRules = {
                name: {
                    pattern: /^[a-zA-Z\s]+$/,
                    minLength: 3,
                    message: 'Nama hanya boleh berisi huruf dan spasi (minimal 3 karakter)'
                },
                email: {
                    pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                    message: 'Format email tidak valid'
                },
                password: {
                    minLength: 8,
                    pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/,
                    message: 'Password minimal 8 karakter, harus mengandung huruf besar, huruf kecil, angka, dan simbol'
                },
                nama_toko: {
                    pattern: /^[a-zA-Z0-9\s\-\.]+$/,
                    minLength: 3,
                    message: 'Nama toko hanya boleh berisi huruf, angka, spasi, strip, dan titik (minimal 3 karakter)'
                },
                nama_pic: {
                    pattern: /^[a-zA-Z\s]+$/,
                    minLength: 3,
                    message: 'Nama PIC hanya boleh berisi huruf dan spasi (minimal 3 karakter)'
                },
                no_ktp_pic: {
                    pattern: /^[0-9]{16}$/,
                    message: 'Nomor KTP harus 16 digit angka'
                },
                email_pic: {
                    pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                    message: 'Format email tidak valid'
                },
                alamat: {
                    minLength: 10,
                    message: 'Alamat minimal 10 karakter'
                },
                alamat_ktp_pic: {
                    minLength: 10,
                    message: 'Alamat minimal 10 karakter'
                },
                nama_kelurahan: {
                    pattern: /^[a-zA-Z\s]+$/,
                    minLength: 3,
                    message: 'Kelurahan hanya boleh berisi huruf dan spasi (minimal 3 karakter)'
                },
                kecamatan: {
                    pattern: /^[a-zA-Z\s]+$/,
                    minLength: 3,
                    message: 'Kecamatan hanya boleh berisi huruf dan spasi (minimal 3 karakter)'
                },
                kabupaten_kota: {
                    pattern: /^[a-zA-Z\s]+$/,
                    minLength: 3,
                    message: 'Kabupaten/Kota hanya boleh berisi huruf dan spasi (minimal 3 karakter)'
                },
                provinsi: {
                    pattern: /^[a-zA-Z\s]+$/,
                    minLength: 3,
                    message: 'Provinsi hanya boleh berisi huruf dan spasi (minimal 3 karakter)'
                },
                file_ktp_pic: {
                    fileTypes: ['image/jpeg', 'image/png', 'application/pdf'],
                    maxSize: 2 * 1024 * 1024, // 2MB
                    message: 'File harus JPG, PNG, atau PDF dengan ukuran maksimal 2MB'
                }
            };

            // Function to show error
            function showError(input, message) {
                removeError(input);
                
                input.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                input.classList.remove('border-gray-300', 'focus:ring-indigo-500', 'focus:border-indigo-500');
                
                const errorDiv = document.createElement('p');
                errorDiv.className = 'mt-2 text-sm text-red-600 error-message';
                errorDiv.textContent = message;
                input.parentElement.appendChild(errorDiv);
            }

            // Function to remove error
            function removeError(input) {
                input.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                input.classList.add('border-gray-300', 'focus:ring-indigo-500', 'focus:border-indigo-500');
                
                const existingError = input.parentElement.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }
            }

            // Function to show success
            function showSuccess(input) {
                removeError(input);
                input.classList.add('border-green-500');
                input.classList.remove('border-red-500');
            }

            // Validate field
            function validateField(input) {
                const name = input.name;
                const value = input.value.trim();
                const rule = validationRules[name];

                if (!rule) return true;

                // Check if field is required and empty
                if (input.required && !value) {
                    showError(input, 'Field ini wajib diisi');
                    return false;
                }

                // Skip validation if field is empty and not required
                if (!value && !input.required) {
                    removeError(input);
                    return true;
                }

                // Check minimum length
                if (rule.minLength && value.length < rule.minLength) {
                    showError(input, rule.message);
                    return false;
                }

                // Check pattern
                if (rule.pattern && !rule.pattern.test(value)) {
                    showError(input, rule.message);
                    return false;
                }

                // File validation
                if (name === 'file_ktp_pic' && input.files.length > 0) {
                    const file = input.files[0];
                    
                    if (!rule.fileTypes.includes(file.type)) {
                        showError(input, 'Format file tidak valid. Gunakan JPG, PNG, atau PDF');
                        return false;
                    }
                    
                    if (file.size > rule.maxSize) {
                        showError(input, 'Ukuran file maksimal 2MB');
                        return false;
                    }
                }

                showSuccess(input);
                return true;
            }

            // Validate password confirmation
            function validatePasswordConfirmation() {
                const password = document.getElementById('password');
                const confirmation = document.getElementById('password_confirmation');
                
                if (confirmation.value && password.value !== confirmation.value) {
                    showError(confirmation, 'Password tidak sama');
                    return false;
                } else if (confirmation.value) {
                    showSuccess(confirmation);
                }
                return true;
            }

            // Validate email PIC different from account email
            function validateEmailPIC() {
                const email = document.getElementById('email');
                const emailPIC = document.getElementById('email_pic');
                
                if (emailPIC.value && email.value === emailPIC.value) {
                    showError(emailPIC, 'Email PIC harus berbeda dengan email akun');
                    return false;
                } else if (emailPIC.value && validateField(emailPIC)) {
                    showSuccess(emailPIC);
                }
                return true;
            }

            // Add real-time validation to all inputs
            const inputs = form.querySelectorAll('input:not([type="submit"]), textarea');
            
            inputs.forEach(input => {
                // Validate on blur
                input.addEventListener('blur', function() {
                    validateField(this);
                    
                    if (this.id === 'password_confirmation') {
                        validatePasswordConfirmation();
                    }
                    
                    if (this.id === 'email_pic') {
                        validateEmailPIC();
                    }
                });

                // Validate on input (for real-time feedback)
                input.addEventListener('input', function() {
                    // Remove error as user types
                    if (this.value.trim()) {
                        const existingError = this.parentElement.querySelector('.error-message');
                        if (existingError) {
                            validateField(this);
                        }
                    }
                    
                    if (this.id === 'password_confirmation') {
                        validatePasswordConfirmation();
                    }
                    
                    if (this.id === 'email_pic') {
                        validateEmailPIC();
                    }
                });

                // Special validation for no_ktp_pic (only allow numbers)
                if (input.id === 'no_ktp_pic') {
                    input.addEventListener('keypress', function(e) {
                        if (!/[0-9]/.test(e.key)) {
                            e.preventDefault();
                        }
                    });
                }
            });

            // Validate form before submit
            form.addEventListener('submit', function(e) {
                let isValid = true;

                inputs.forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });

                if (!validatePasswordConfirmation()) {
                    isValid = false;
                }

                if (!validateEmailPIC()) {
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    
                    // Scroll to first error
                    const firstError = form.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                    
                    // Show alert
                    alert('Mohon perbaiki field yang tidak valid sebelum submit');
                }
            });
        });
    </script>
</body>
</html>
