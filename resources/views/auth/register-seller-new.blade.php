<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-indigo-950 dark:to-purple-950 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <a href="{{ route('welcome') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 mb-4 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
                <div class="inline-block bg-gradient-to-br from-indigo-600 to-purple-600 p-4 rounded-2xl shadow-2xl mb-4">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold mb-2">
                    <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Daftar Sebagai Penjual
                    </span>
                </h1>
                <p class="text-gray-600 dark:text-gray-300 text-lg">
                    Bergabunglah dengan ribuan penjual sukses lainnya 🚀
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('seller.register') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Progress Header -->
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                        <div class="flex items-center justify-between text-white text-sm">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-white text-indigo-600 rounded-full flex items-center justify-center font-bold mb-2">✓</div>
                                <span class="font-medium hidden sm:inline">Akun</span>
                            </div>
                            <div class="h-1 flex-1 bg-white/30 mx-4"></div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold mb-2">2</div>
                                <span class="font-medium hidden sm:inline">Toko</span>
                            </div>
                            <div class="h-1 flex-1 bg-white/30 mx-4"></div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold mb-2">3</div>
                                <span class="font-medium hidden sm:inline">Dokumen</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">
                        <!-- Section 1: Account Info -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="bg-gradient-to-br from-indigo-600 to-purple-600 w-12 h-12 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informasi Akun</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Data untuk login ke sistem</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                        placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                        placeholder="email@example.com">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input id="password" type="password" name="password" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                        placeholder="Minimal 8 karakter">
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Konfirmasi Password <span class="text-red-500">*</span>
                                    </label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                        placeholder="Ulangi password">
                                    @error('password_confirmation')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Store Info -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="bg-gradient-to-br from-purple-600 to-pink-600 w-12 h-12 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informasi Toko</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Detail toko dan lokasi</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="nama_toko" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Toko <span class="text-red-500">*</span>
                                    </label>
                                    <input id="nama_toko" type="text" name="nama_toko" value="{{ old('nama_toko') }}" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                        placeholder="Nama toko Anda">
                                    @error('nama_toko')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="deskripsi_singkat" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Deskripsi Toko (Optional)
                                    </label>
                                    <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="3"
                                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                        placeholder="Jelaskan tentang toko Anda...">{{ old('deskripsi_singkat') }}</textarea>
                                    @error('deskripsi_singkat')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nama_pic" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Nama Penanggung Jawab <span class="text-red-500">*</span>
                                        </label>
                                        <input id="nama_pic" type="text" name="nama_pic" value="{{ old('nama_pic') }}" required
                                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        @error('nama_pic')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="email_pic" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Email PIC <span class="text-red-500">*</span>
                                        </label>
                                        <input id="email_pic" type="email" name="email_pic" value="{{ old('email_pic') }}" required
                                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        @error('email_pic')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="alamat" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Alamat Lengkap Toko <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="alamat" name="alamat" rows="2" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                        placeholder="Jalan, nomor, RT/RW...">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nama_kelurahan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Kelurahan <span class="text-red-500">*</span>
                                        </label>
                                        <input id="nama_kelurahan" type="text" name="nama_kelurahan" value="{{ old('nama_kelurahan') }}" required
                                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        @error('nama_kelurahan')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="kecamatan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Kecamatan <span class="text-red-500">*</span>
                                        </label>
                                        <input id="kecamatan" type="text" name="kecamatan" value="{{ old('kecamatan') }}" required
                                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        @error('kecamatan')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="kabupaten_kota" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Kabupaten/Kota <span class="text-red-500">*</span>
                                        </label>
                                        <input id="kabupaten_kota" type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}" required
                                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        @error('kabupaten_kota')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="provinsi" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Provinsi <span class="text-red-500">*</span>
                                        </label>
                                        <input id="provinsi" type="text" name="provinsi" value="{{ old('provinsi') }}" required
                                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        @error('provinsi')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Documents -->
                        <div class="bg-gradient-to-br from-pink-50 to-red-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="bg-gradient-to-br from-pink-600 to-red-600 w-12 h-12 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Dokumen Verifikasi</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Upload dokumen KTP untuk verifikasi</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="no_ktp_pic" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        No. KTP (16 digit) <span class="text-red-500">*</span>
                                    </label>
                                    <input id="no_ktp_pic" type="text" name="no_ktp_pic" value="{{ old('no_ktp_pic') }}" required
                                        maxlength="16" pattern="[0-9]{16}"
                                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-pink-600 focus:ring-4 focus:ring-pink-100 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                        placeholder="1234567890123456">
                                    @error('no_ktp_pic')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="alamat_ktp_pic" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Alamat sesuai KTP <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="alamat_ktp_pic" name="alamat_ktp_pic" rows="2" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-pink-600 focus:ring-4 focus:ring-pink-100 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                        placeholder="Alamat lengkap sesuai KTP...">{{ old('alamat_ktp_pic') }}</textarea>
                                    @error('alamat_ktp_pic')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="file_ktp_pic" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Upload File KTP <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input id="file_ktp_pic" type="file" name="file_ktp_pic" required
                                            accept=".jpg,.jpeg,.png,.pdf"
                                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl focus:border-pink-600 focus:ring-4 focus:ring-pink-100 dark:bg-gray-700 dark:text-white transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                        <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG, atau PDF. Maksimal 2MB</p>
                                    </div>
                                    @error('file_ktp_pic')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t-2 border-gray-200 dark:border-gray-700">
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">
                                Sudah punya akun? Login di sini
                            </a>
                            <button type="submit"
                                class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:from-indigo-700 hover:to-purple-700 transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-3">
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
</x-guest-layout>
