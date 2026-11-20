@props(['title' => null])
@inject('cart', 'App\Services\CartService')
@php($cartCount = $cart->count())
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title.' · ' : '' }}{{ config('app.name', 'Web Coffee') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=bricolage-grotesque:400,500,600,700,800&display=swap" rel="stylesheet">
    <style>[x-cloak] { display: none !important; } body { font-family: 'Bricolage Grotesque', ui-sans-serif, system-ui, sans-serif; }</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-stone-50 text-stone-800 antialiased">
    <a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:left-2 focus:top-2 focus:z-50 focus:rounded-md focus:bg-white focus:px-3 focus:py-2">Lewati ke konten</a>

    <header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-stone-200 bg-white">
        <div class="mx-auto flex h-16 max-w-6xl items-center gap-4 px-4">
            <a href="{{ route('home') }}" class="text-xl font-extrabold tracking-tight text-stone-900">
                {{ config('app.name', 'Web Coffee') }}
            </a>

            <nav :class="open ? 'block' : 'hidden'"
                 class="absolute inset-x-0 top-16 border-b border-stone-200 bg-white px-4 py-3 md:static md:ml-auto md:flex md:items-center md:gap-6 md:border-0 md:p-0"
                 aria-label="Navigasi utama">
                <a href="{{ route('home') }}#menu" class="block py-2 text-sm font-medium text-stone-600 hover:text-stone-900 md:py-0">Menu</a>
               <a href="{{ route('feedback.index') }}" class="block py-2 text-sm font-medium text-stone-600 hover:text-stone-900 md:py-0">Ulasan</a>

                @auth
                    <a href="{{ route('orders.index') }}" class="block py-2 text-sm font-medium text-stone-600 hover:text-stone-900 md:py-0">Pesanan saya</a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 text-sm font-medium text-amber-800 hover:text-amber-900 md:py-0">Panel admin</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block py-2 text-sm font-medium text-stone-600 hover:text-stone-900 md:py-0">{{ auth()->user()->name }}</a>
                    <form method="POST" action="{{ route('logout') }}" class="py-2 md:py-0">
                        @csrf
                        <button class="text-sm font-medium text-stone-600 hover:text-stone-900">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-sm font-medium text-stone-600 hover:text-stone-900 md:py-0">Masuk</a>
                    <x-button :href="route('register')" class="mt-1 md:mt-0">Daftar</x-button>
                @endauth
            </nav>

            <div class="ml-auto flex items-center gap-2 md:ml-0">
                <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 rounded-md border border-stone-300 px-3 py-1.5 text-sm font-semibold text-stone-800 hover:bg-stone-100">
                    Keranjang
                    @if ($cartCount > 0)
                        <span class="rounded-full bg-amber-700 px-2 text-xs text-white">{{ $cartCount }}</span>
                    @endif
                </a>
                <button type="button" @click="open = !open" :aria-expanded="open" aria-label="Buka menu"
                        class="rounded-md border border-stone-300 p-2 md:hidden">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>
    </header>

    @isset($hero)
        {{ $hero }}
    @endisset

    <main id="konten" class="mx-auto w-full max-w-6xl flex-1 px-4 py-10">
        <x-flash />
        {{ $slot }}
    </main>

  <footer class="bg-stone-900 text-stone-400">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-12 md:grid-cols-3">
        {{-- Brand --}}
        <div>
            <p class="text-lg font-extrabold text-white">Web Coffee</p>
            <p class="mt-3 max-w-xs text-sm leading-relaxed">Kopi diseduh fresh setiap pesanan. Pesan online, ambil di toko saat masih hangat.</p>
        </div>

        {{-- Jelajahi --}}
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-stone-200">Jelajahi</p>
            <ul class="mt-4 space-y-2 text-sm">
                <li><a href="{{ route('home') }}#menu" class="hover:text-white">Semua Menu</a></li>
                <li><a href="{{ route('feedback.index') }}" class="hover:text-white">Ulasan Pelanggan</a></li>
                <li><a href="{{ route('cart.index') }}" class="hover:text-white">Keranjang</a></li>
                <li><a href="{{ route('orders.index') }}" class="hover:text-white">Pesanan Saya</a></li>
            </ul>
        </div>

        {{-- Toko --}}
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-stone-200">Toko Kami</p>
            <ul class="mt-4 space-y-2 text-sm">
                <li>Jl. Kopi No. 12, Jakarta</li>
                <li>Senin - Jumat · 08.00 - 21.00</li>
                <li>Sabtu - Minggu · 09.00 - 22.00</li>
                <li>(021) 555-0199</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-6xl flex-col gap-1 px-4 py-5 text-sm sm:flex-row sm:items-center sm:justify-between">
            <p class="font-semibold text-stone-200">Web Coffee</p>
            <p>Pesan online, ambil di toko. &copy; {{ date('Y') }}</p>
        </div>
    </div>
</footer>
</body>
</html>
