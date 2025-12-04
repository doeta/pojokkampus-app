<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PojokKampus') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Instrument Sans', 'sans-serif'],
                        },
                        colors: {
                            indigo: { 50: '#eef2ff', 100: '#e0e7ff', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 900: '#312e81' },
                            teal: { 50: '#f0fdfa', 100: '#ccfbf1', 500: '#14b8a6', 600: '#0d9488' },
                        },
                        animation: {
                            'float': 'float 6s ease-in-out infinite',
                            'float-delayed': 'float 6s ease-in-out 3s infinite',
                            'blob': 'blob 7s infinite',
                        },
                        keyframes: {
                            float: {
                                '0%, 100%': { transform: 'translateY(0)' },
                                '50%': { transform: 'translateY(-20px)' },
                            },
                            blob: {
                                '0%': { transform: 'translate(0px, 0px) scale(1)' },
                                '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                                '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                                '100%': { transform: 'translate(0px, 0px) scale(1)' },
                            }
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        /* Custom Utilities for Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Hero Search Transition */
        #heroSearch {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #navbarSearch.visible {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800 overflow-x-hidden">

    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Header / Navigation -->
    <header id="mainHeader" class="fixed w-full top-0 z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logo.png') }}" alt="PojokKampus Logo" class="h-10 w-auto transition-transform group-hover:rotate-6">
                </a>

                <!-- Navbar Search Bar (Hidden on scroll up) -->
                <div id="navbarSearch" class="hidden md:flex flex-1 max-w-lg mx-8 relative group opacity-0 invisible transition-all duration-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <form action="{{ route('catalog.index') }}" method="GET" class="w-full">
                        <input type="text" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-full leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm" placeholder="Cari produk mahasiswa...">
                    </form>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex items-center gap-4">
                    <a href="{{ route('catalog.index') }}" class="hidden md:block text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">Katalog</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-full bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">Masuk</a>
                        <a href="{{ route('seller.register.form') }}" class="hidden sm:block px-5 py-2.5 rounded-full bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">Jadi Penjual</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-20">
        <!-- Hero Section -->
        <div class="relative pt-10 pb-20 lg:pt-20 lg:pb-28 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Hero Text Content -->
                    <div class="text-center lg:text-left z-10 reveal active">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-semibold mb-6 animate-pulse">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            Platform Jual Beli Mahasiswa #1
                        </div>
                        <h1 class="text-5xl lg:text-7xl font-bold text-gray-900 leading-tight mb-6">
                            Belanja Hemat <br>
                            <span class="bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 bg-clip-text text-transparent">Ala Mahasiswa</span>
                        </h1>

                        <!-- Hero Search Bar -->
                        <div id="heroSearch" class="mb-8 max-w-xl mx-auto lg:mx-0">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <form action="{{ route('catalog.index') }}" method="GET" class="w-full">
                                    <input type="text" name="search" class="block w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-full leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl" placeholder="Cari produk mahasiswa, buku, jasa, dan lainnya...">
                                </form>
                            </div>
                        </div>

                        <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            Temukan kebutuhan kuliah, buku bekas, jasa, hingga makanan dengan harga bersahabat. Dari mahasiswa, untuk mahasiswa.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('catalog.index') }}" class="px-8 py-4 rounded-full bg-indigo-600 text-white font-semibold shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                Mulai Belanja
                            </a>
                            <a href="#categories" class="px-8 py-4 rounded-full bg-white text-gray-700 font-semibold border-2 border-gray-200 hover:border-indigo-300 hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                                Jelajahi Kategori
                            </a>
                        </div>
                    </div>

                    <!-- Hero Image/Slider -->
                    <div class="relative lg:h-[500px] w-full reveal delay-200">
                        <div class="absolute -top-10 -right-10 w-24 h-24 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float"></div>
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float-delayed"></div>

                        <div class="relative w-full h-full rounded-3xl overflow-hidden shadow-2xl border-4 border-white/50 backdrop-blur-sm transform rotate-1 hover:rotate-0 transition-transform duration-500">
                            <div id="heroSlider" class="relative w-full h-full bg-gray-100">
                                <div class="slider-item absolute inset-0 transition-opacity duration-700 opacity-100">
                                    <img src="{{ asset('images/slider/slide1.jpg') }}" class="w-full h-full object-cover" alt="Slide 1">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-8">
                                        <p class="text-white font-medium text-lg">Perlengkapan Kuliah Lengkap</p>
                                    </div>
                                </div>
                                <div class="slider-item absolute inset-0 transition-opacity duration-700 opacity-0">
                                    <img src="{{ asset('images/slider/slide2.jpg') }}" class="w-full h-full object-cover" alt="Slide 2">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-8">
                                        <p class="text-white font-medium text-lg">Jajanan & Katering Murah</p>
                                    </div>
                                </div>
                                <div class="slider-item absolute inset-0 transition-opacity duration-700 opacity-0">
                                    <img src="{{ asset('images/slider/slide3.jpg') }}" class="w-full h-full object-cover" alt="Slide 3">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-8">
                                        <p class="text-white font-medium text-lg">Elektronik & Gadget</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="absolute bottom-4 right-4 flex gap-2">
                                <button onclick="prevSlide()" class="p-2 rounded-full bg-white/20 backdrop-blur-md hover:bg-white/40 text-white transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
                                <button onclick="nextSlide()" class="p-2 rounded-full bg-white/20 backdrop-blur-md hover:bg-white/40 text-white transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="bg-white py-12 border-y border-gray-100 reveal">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <!-- Benefit 1: Verified -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Terverifikasi</h3>
                        <p class="text-sm text-gray-500">Penjual Mahasiswa Asli</p>
                    </div>
                    <!-- Benefit 2: Cheap Price -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Harga Teman</h3>
                        <p class="text-sm text-gray-500">Pas di Kantong</p>
                    </div>
                    <!-- Benefit 3: Fast Transaction -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Transaksi Cepat</h3>
                        <p class="text-sm text-gray-500">COD di Kampus</p>
                    </div>
                    <!-- Benefit 4: Support 24/7 -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Support 24/7</h3>
                        <p class="text-sm text-gray-500">Bantuan Admin</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div id="categories" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 reveal">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Kategori Pilihan</h2>
                    <p class="text-gray-500">Cari barang berdasarkan kebutuhanmu</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="hidden sm:flex items-center gap-1 text-indigo-600 font-semibold hover:gap-2 transition-all">
                    Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @forelse($categories as $category)
                    <a href="{{ route('catalog.index', ['category' => $category->id]) }}" class="group relative overflow-hidden rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="p-6 flex flex-col items-center justify-center text-center h-full">
                            <div class="w-14 h-14 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                {!! $category->icon ?? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>' !!}
                            </div>
                            <h3 class="font-bold text-gray-900 text-sm group-hover:text-indigo-600 transition-colors">{{ $category->name }}</h3>
                            <p class="text-xs text-gray-400 mt-1">{{ $category->products_count }} Produk</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                        <p class="text-gray-500">Kategori belum tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Featured Products Section -->
        <div class="bg-gray-50 py-20 reveal">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-indigo-600 font-semibold tracking-wider uppercase text-xs">Rekomendasi Kami</span>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2">Produk Terbaru</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($featuredProducts as $product)
                        <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex flex-col h-full border border-gray-100">
                            <div class="relative aspect-square overflow-hidden bg-gray-100">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                
                                @if($product->stock < 5)
                                    <div class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-md animate-pulse">
                                        Stok Menipis
                                    </div>
                                @endif

                                <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-gradient-to-t from-black/50 to-transparent">
                                    <a href="{{ route('catalog.show', $product) }}" class="block w-full py-2 bg-white text-indigo-600 text-center font-bold text-sm rounded-lg shadow-lg hover:bg-indigo-50">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>

                            <div class="p-5 flex-1 flex flex-col">
                                <div class="mb-2 flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-600 uppercase tracking-wide">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-gray-900 text-base mb-1 line-clamp-2 hover:text-indigo-600 transition-colors">
                                    <a href="{{ route('catalog.show', $product) }}">{{ $product->name }}</a>
                                </h3>
                                <div class="flex items-center gap-1 mb-3">
                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <span class="text-sm font-medium text-gray-700">{{ number_format($product->averageRating(), 1) }}</span>
                                    <span class="text-xs text-gray-400">({{ $product->totalReviews() }})</span>
                                </div>
                                <div class="mt-auto flex items-center justify-between">
                                    <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <div class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ Str::limit($product->user->seller->city ?? 'Kampus', 10) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500">Belum ada produk</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="relative bg-indigo-900 py-20 overflow-hidden reveal">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-white">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-indigo-800">
                    <div class="p-4">
                        <div class="text-5xl font-bold mb-2 counter" data-target="{{ $stats['total_sellers'] ?? 0 }}">0</div>
                        <div class="text-indigo-200">Penjual Terdaftar</div>
                    </div>
                    <div class="p-4">
                        <div class="text-5xl font-bold mb-2 counter" data-target="{{ $stats['total_products'] ?? 0 }}">0</div>
                        <div class="text-indigo-200">Produk Tersedia</div>
                    </div>
                    <div class="p-4">
                        <div class="text-5xl font-bold mb-2 flex justify-center gap-1">
                            <span class="counter" data-target="{{ $stats['average_rating'] ?? 0 }}">0</span>
                            <span class="text-yellow-400 text-3xl mt-1">★</span>
                        </div>
                        <div class="text-indigo-200">Kepuasan Pelanggan</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20 reveal">
            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-2xl border border-gray-100 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Punya Barang Bekas Berkualitas?</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Jual barangmu sekarang di PojokKampus. Gratis, mudah, dan langsung terhubung dengan ribuan mahasiswa lainnya.</p>
                <a href="{{ route('seller.register.form') }}" class="inline-block px-10 py-4 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all transform hover:scale-105">Buka Toko Gratis</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 pt-20 pb-10 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                        <span class="text-lg font-bold text-gray-900">Pojok<span class="text-indigo-600">Kampus</span></span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Platform jual beli khusus mahasiswa yang aman, nyaman, dan terpercaya. Temukan segala kebutuhanmu di sini.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-indigo-600 transition-colors">Beranda</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition-colors">Katalog</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-indigo-600 transition-colors">Cara Belanja</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition-colors">Cara Berjualan</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition-colors">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Hubungi Kami</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 text-center">
                <p class="text-sm text-gray-400">&copy; 2025 PojokKampus. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Slider Logic
            const slider = document.getElementById('heroSlider');
            const slides = slider.querySelectorAll('.slider-item');
            let currentSlide = 0;

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.style.opacity = i === index ? '1' : '0';
                });
            }

            window.nextSlide = () => {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }

            window.prevSlide = () => {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            }

            setInterval(window.nextSlide, 5000); // Auto play every 5s

            // 2. Scroll Animation (Fade Up)
            const observerOptions = {
                threshold: 0.1,
                rootMargin: "0px 0px -50px 0px"
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        
                        // Trigger counter if it's the stats section
                        if(entry.target.querySelector('.counter')) {
                            startCounters(entry.target);
                        }
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            // 3. Counter Animation
            function startCounters(section) {
                const counters = section.querySelectorAll('.counter');
                counters.forEach(counter => {
                    const target = parseFloat(counter.getAttribute('data-target'));
                    const duration = 2000; // 2 seconds
                    const start = 0;
                    const startTime = performance.now();

                    function update(currentTime) {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        
                        // Ease out quart
                        const ease = 1 - Math.pow(1 - progress, 4);
                        
                        const current = Math.floor(ease * target);
                        
                        // Format number based on if it's integer or float (for rating)
                        if (target % 1 !== 0) {
                             counter.innerText = (ease * target).toFixed(1);
                        } else {
                             counter.innerText = new Intl.NumberFormat('id-ID').format(current);
                        }

                        if (progress < 1) {
                            requestAnimationFrame(update);
                        } else {
                            // Ensure final value is exact
                            counter.innerText = target % 1 !== 0 ? target.toFixed(1) : new Intl.NumberFormat('id-ID').format(target);
                        }
                    }
                    requestAnimationFrame(update);
                });
            }

            // 4. Navbar Glass Effect on Scroll + Search Bar Toggle
            const header = document.getElementById('mainHeader');
            const heroSearch = document.getElementById('heroSearch');
            const navbarSearch = document.getElementById('navbarSearch');
            
            window.addEventListener('scroll', () => {
                const scrollY = window.scrollY;
                
                // Header styling
                if (scrollY > 50) {
                    header.classList.add('shadow-md', 'bg-white/90');
                    header.classList.remove('bg-white/80', 'border-white/20');
                } else {
                    header.classList.remove('shadow-md', 'bg-white/90');
                    header.classList.add('bg-white/80', 'border-white/20');
                }
                
                // Search bar toggle - show in navbar when scrolled past hero search
                if (scrollY > 400) { // Adjust this value based on hero search position
                    heroSearch.style.opacity = '0';
                    heroSearch.style.transform = 'translateY(20px)';
                    navbarSearch.classList.remove('opacity-0', 'invisible');
                    navbarSearch.classList.add('opacity-100', 'visible');
                } else {
                    heroSearch.style.opacity = '1';
                    heroSearch.style.transform = 'translateY(0)';
                    navbarSearch.classList.add('opacity-0', 'invisible');
                    navbarSearch.classList.remove('opacity-100', 'visible');
                }
            });
        });
    </script>
</body>
</html>