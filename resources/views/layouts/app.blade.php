<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyCamp') - Sistem Kasir Rental</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f6f2ea] text-[#1f1b16] antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    @php
        $roleName = auth()->check() ? strtolower(auth()->user()->role->nama_role ?? '') : '';
        $isAdmin = $roleName === 'admin';
    @endphp

    <header class="bg-[#fffdf9] border-b border-[#dfd6c5] sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex justify-between items-stretch h-14">
            <div class="flex items-stretch gap-6">
                <a href="{{ route('penyewa.index') }}" class="group flex items-center gap-2.5 py-2">
                    <img src="{{ asset('images/logo-mycamp.png') }}" alt="MyCamp" class="h-7 w-auto object-contain transition-transform duration-150 group-hover:scale-105">
                    <span class="font-bold text-[15px] tracking-tight text-[#4a3519]">MyCamp</span>
                </a>

                @auth
                <nav class="hidden md:flex items-stretch gap-5 text-[13px]">
                    <a href="{{ route('penyewa.index') }}"
                       class="inline-flex items-center border-b-2 px-0.5 transition-colors duration-150 active:translate-y-px {{ request()->routeIs('penyewa.*') ? 'border-[#4a3519] text-[#4a3519] font-semibold' : 'border-transparent text-[#6e655c] hover:text-[#1f1b16]' }}">
                        Data Penyewa
                    </a>

                    @if ($isAdmin)
                        @if (Route::has('peralatan.index'))
                            <a href="{{ route('peralatan.index') }}"
                               class="inline-flex items-center border-b-2 px-0.5 transition-colors duration-150 active:translate-y-px {{ request()->routeIs('peralatan.*') ? 'border-[#4a3519] text-[#4a3519] font-semibold' : 'border-transparent text-[#6e655c] hover:text-[#1f1b16]' }}">
                                Peralatan
                            </a>
                        @else
                            <span class="inline-flex items-center border-b-2 border-transparent px-0.5 text-[#a39a8e] cursor-not-allowed">
                                Peralatan
                            </span>
                        @endif
                    @endif

                    @if (Route::has('penyewaan.index'))
                        <a href="{{ route('penyewaan.index') }}"
                           class="inline-flex items-center border-b-2 px-0.5 transition-colors duration-150 active:translate-y-px {{ request()->routeIs('penyewaan.*') ? 'border-[#4a3519] text-[#4a3519] font-semibold' : 'border-transparent text-[#6e655c] hover:text-[#1f1b16]' }}">
                            Transaksi
                        </a>
                    @else
                        <span class="inline-flex items-center border-b-2 border-transparent px-0.5 text-[#a39a8e] cursor-not-allowed">
                            Transaksi
                        </span>
                    @endif

                    @if (Route::has('pengembalian.index'))
                        <a href="{{ route('pengembalian.index') }}"
                           class="inline-flex items-center border-b-2 px-0.5 transition-colors duration-150 active:translate-y-px {{ request()->routeIs('pengembalian.*') ? 'border-[#4a3519] text-[#4a3519] font-semibold' : 'border-transparent text-[#6e655c] hover:text-[#1f1b16]' }}">
                            Pengembalian
                        </a>
                    @else
                        <span class="inline-flex items-center border-b-2 border-transparent px-0.5 text-[#a39a8e] cursor-not-allowed">
                            Pengembalian
                        </span>
                    @endif

                    @if ($isAdmin)
                        @if (Route::has('laporan.index'))
                            <a href="{{ route('laporan.index') }}"
                               class="inline-flex items-center border-b-2 px-0.5 transition-colors duration-150 active:translate-y-px {{ request()->routeIs('laporan.*') ? 'border-[#4a3519] text-[#4a3519] font-semibold' : 'border-transparent text-[#6e655c] hover:text-[#1f1b16]' }}">
                                Laporan
                            </a>
                        @else
                            <span class="inline-flex items-center border-b-2 border-transparent px-0.5 text-[#a39a8e] cursor-not-allowed">
                                Laporan
                            </span>
                        @endif
                    @endif
                </nav>
                @endauth
            </div>

            @auth
            <div class="flex items-center gap-3 text-[13px]">
                <div class="hidden sm:flex items-center gap-2">
                    <span class="font-medium text-[#1f1b16]">{{ auth()->user()->nama_lengkap }}</span>
                    <span class="text-[11px] font-semibold uppercase tracking-wider px-1.5 py-0.5 rounded bg-[#efe8da] text-[#4a3519]">
                        {{ auth()->user()->role->nama_role }}
                    </span>
                </div>

                <span class="hidden sm:block h-4 w-px bg-[#dfd6c5]"></span>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                        class="text-xs font-medium text-[#6e655c] hover:text-red-700 px-2.5 py-1 rounded hover:bg-red-50 active:scale-95 transition-all duration-150 cursor-pointer">
                        Keluar
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')
</body>
</html>