<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - PojokKampus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Animasi Loading */
        .loading-state {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <header class="bg-white sticky top-0 z-50 border-b border-gray-100 shadow-sm backdrop-blur-md bg-opacity-90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 gap-8">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-2 hover:opacity-80 transition">
                    <img src="{{ asset('images/logo.png') }}" alt="PojokKampus Logo" class="h-10 w-auto">
                </a>
                
                <form method="GET" action="{{ route('catalog.index') }}" class="flex-1 max-w-2xl relative group" id="search-form">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                        placeholder="Cari produk, toko, atau kategori..."
                        autocomplete="off"
                        class="block w-full pl-11 pr-4 py-2.5 bg-gray-100 border-transparent text-gray-900 placeholder-gray-500 rounded-full focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent sm:text-sm transition-all duration-200">
                </form>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-full transition-colors">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Filter
                        </h2>
                        @if(request()->hasAny(['category', 'store', 'province', 'city']))
                            <a href="{{ route('catalog.index') }}" class="text-xs font-medium text-red-500 hover:text-red-700 hover:underline">
                                Reset
                            </a>
                        @endif
                    </div>
                    
                    <form method="GET" id="filterForm">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <div class="mb-8 border-b border-gray-100 pb-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Kategori</h3>
                            <div class="space-y-1">
                                <label class="cursor-pointer group flex items-center justify-between px-3 py-2 rounded-lg transition-all {{ !request('category') ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit()" class="hidden">
                                        <span class="text-sm">Semua Produk</span>
                                    </div>
                                    @if(!request('category'))
                                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-600"></div>
                                    @endif
                                </label>

                                @foreach($categories as $category)
                                    <label class="cursor-pointer group flex items-center justify-between px-3 py-2 rounded-lg transition-all {{ request('category') == $category->id ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="category" value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'checked' : '' }}
                                                onchange="document.getElementById('filterForm').submit()" class="hidden">
                                            <span class="text-lg opacity-80 group-hover:opacity-100">{{ $category->icon }}</span>
                                            <span class="text-sm">{{ $category->name }}</span>
                                        </div>
                                        @if(request('category') == $category->id)
                                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-600"></div>
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3">Toko</h3>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <input type="text" name="store" value="{{ request('store') }}"
                                    placeholder="Nama toko..."
                                    class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3">Lokasi</h3>
                            <div class="space-y-3">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <input type="text" name="province" value="{{ request('province') }}"
                                        placeholder="Provinsi..."
                                        class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <input type="text" name="city" value="{{ request('city') }}"
                                        placeholder="Kota/Kabupaten..."
                                        class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform active:scale-95">
                            Terapkan Filter
                        </button>
                    </form>
                </div>
            </aside> <main class="flex-1" id="main-content-area">
                
                <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 gap-4">
                    <p class="text-sm text-gray-600 font-medium">
                        Menampilkan <span class="text-indigo-600 font-bold">{{ $products->count() }}</span> dari <span class="text-gray-900">{{ $products->total() }}</span> produk
                    </p>
                    
                    <form method="GET" class="flex items-center gap-3">
                        @foreach(request()->except(['sort', 'search']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <label class="text-sm text-gray-500">Urutkan:</label>
                        <div class="relative">
                            <select name="sort" onchange="this.form.submit()"
                                class="appearance-none pl-4 pr-8 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 cursor-pointer hover:border-indigo-300 transition-colors">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="product-grid-container">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                            @foreach($products as $product)
                                <a href="{{ route('catalog.show', $product) }}" class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">
                                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                                        <img src="{{ Storage::url($product->image) }}" 
                                             class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-500" 
                                             alt="{{ $product->name }}">
                                    </div>

                                    <div class="p-4 flex-1 flex flex-col">
                                        <h3 class="text-sm font-medium text-gray-800 leading-snug line-clamp-2 mb-2 group-hover:text-indigo-600 transition-colors min-h-[2.5em]">
                                            {{ $product->name }}
                                        </h3>
                                        
                                        <div class="mt-auto">
                                            <p class="text-base font-bold text-indigo-900 mb-2">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </p>
                                            
                                            <div class="flex items-center justify-between text-xs text-gray-500 border-t border-gray-50 pt-3">
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                    <span class="font-medium text-gray-700">{{ number_format($product->averageRating(), 1) }}</span>
                                                    <span class="text-gray-300">|</span>
                                                    <span>{{ $product->sold ?? 0 }} Terjual</span>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center text-[10px] text-gray-600 font-bold overflow-hidden">
                                                    {{ substr($product->user->name, 0, 1) }}
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-[11px] text-gray-600 truncate max-w-[100px]">{{ $product->user->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center shadow-sm">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Produk tidak ditemukan</h3>
                            <p class="text-gray-500 mb-8 max-w-sm mx-auto">Kami tidak dapat menemukan produk yang sesuai. Coba kata kunci lain.</p>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const mainContent = document.getElementById('main-content-area');
            let timeout = null;

            // Fungsi Debounce (Menunggu user selesai mengetik)
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value;

                // Tampilkan efek loading
                mainContent.classList.add('loading-state');

                // Clear timeout sebelumnya jika user masih mengetik
                clearTimeout(timeout);

                // Set timeout baru (tunggu 500ms setelah ketikan terakhir)
                timeout = setTimeout(() => {
                    performSearch(query);
                }, 500);
            });

            function performSearch(query) {
                // Ambil URL saat ini
                const url = new URL(window.location.href);
                // Set parameter search baru
                url.searchParams.set('search', query);
                // Reset page ke 1 saat searching baru
                url.searchParams.delete('page');

                // Update URL browser tanpa reload (agar kalau di refresh tetap tersimpan)
                window.history.pushState({}, '', url);

                // Fetch data dari server
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Parse HTML string menjadi DOM
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Ambil konten baru dari #main-content-area
                    const newContent = doc.getElementById('main-content-area').innerHTML;
                    
                    // Ganti konten lama dengan yang baru
                    mainContent.innerHTML = newContent;
                    
                    // Matikan efek loading
                    mainContent.classList.remove('loading-state');
                })
                .catch(error => {
                    console.error('Error:', error);
                    mainContent.classList.remove('loading-state');
                });
            }
        });
    </script>

</body>
</html>