<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyCamp') — Sistem Penyewaan Perlengkapan Camping</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f7f3ee] text-[#1f1a16] antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    <!-- Top Navbar -->
    <nav class="bg-white border-b border-[#e6dfd5] sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Brand & Navigasi -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('penyewa.index') }}" class="flex items-center gap-3">
                        <div class="h-10 px-2.5 rounded-xl bg-[#f7f3ee] border border-[#e6dfd5] flex items-center justify-center">
                            <img src="{{ asset('images/logo-mycamp.png') }}" alt="Logo MyCamp" class="h-6 w-auto object-contain">
                        </div>
                        <div>
                            <span class="font-bold text-lg tracking-tight text-[#4a3519] block leading-none">MyCamp</span>
                            <span class="text-[10px] font-semibold tracking-wider uppercase text-[#8c7a6b]">Outdoor Rental</span>
                        </div>
                    </a>

                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ route('penyewa.index') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('penyewa.*') ? 'bg-[#f2ece4] text-[#4a3519]' : 'text-[#78716c] hover:text-[#1f1a16]' }}">
                            Data Penyewa
                        </a>
                        <!-- Slot menu modul rekan tim -->
                        <span class="px-3.5 py-2 rounded-lg text-sm font-medium text-[#b5ada5] cursor-not-allowed">
                            Peralatan
                        </span>
                        <span class="px-3.5 py-2 rounded-lg text-sm font-medium text-[#b5ada5] cursor-not-allowed">
                            Transaksi
                        </span>
                    </div>
                </div>

                <!-- Info Petugas & Logout -->
                @auth
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2.5 bg-[#f7f3ee] border border-[#e6dfd5] px-3 py-1.5 rounded-full">
                        <div class="w-6 h-6 rounded-full bg-[#4a3519] text-white text-xs font-bold flex items-center justify-center">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
                        </div>
                        <span class="text-xs font-semibold text-[#1f1a16]">{{ auth()->user()->nama_lengkap }}</span>
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-white text-[#4a3519] border border-[#e6dfd5]">
                            {{ auth()->user()->role->nama_role }}
                        </span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold border border-[#e6dfd5] bg-white text-[#6e655f] hover:bg-[#f2ece4] hover:text-[#1f1a16] transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')
</body>
</html>