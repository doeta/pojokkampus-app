<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 to-gray-100">
            <!-- Logo & Brand -->
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center">
                    <div class="bg-indigo-600 p-4 rounded-xl shadow-lg mb-3">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">PojokKampus</h1>
                    <p class="text-sm text-gray-500">Marketplace Terpercaya</p>
                </a>
            </div>

            <!-- Content Card -->
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg overflow-hidden rounded-xl border border-gray-200">
                {{ $slot }}
            </div>

            <!-- Back to Home Link -->
            <div class="mt-6">
                <a href="{{ route('welcome') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-indigo-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </body>
</html>
