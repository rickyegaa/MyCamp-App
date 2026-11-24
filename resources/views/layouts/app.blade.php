<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Transaksi & Pengembalian') – MyCamp Outdoor Rental</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        :root {
            --mc-bg: #F8F5F0;
            --mc-surface: #FFFFFF;
            --mc-border: #EAE4DC;
            --mc-border-input: #DFD8CE;
            --mc-primary: #3D2C1E;
            --mc-primary-hover: #2B1F15;
            --mc-pill-bg: #F1ECE4;
            --mc-table-head: #F9F6F1;
            --mc-text-main: #1F1915;
            --mc-text-muted: #857B6E;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--mc-bg);
            color: var(--mc-text-main);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .mc-navbar {
            background-color: var(--mc-surface);
            border-bottom: 1px solid var(--mc-border);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .mc-brand-box {
            width: 44px;
            height: 44px;
            background-color: var(--mc-pill-bg);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--mc-primary);
            font-size: 1.25rem;
        }

        .mc-brand-title {
            font-weight: 700;
            font-size: 1.05rem;
            line-height: 1.15;
            color: var(--mc-text-main);
            margin: 0;
        }

        .mc-brand-sub {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            color: var(--mc-text-muted);
            text-transform: uppercase;
            margin: 0;
        }

        .mc-nav-link {
            color: var(--mc-text-muted);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.5rem 1.1rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.18s ease;
        }

        .mc-nav-link:hover {
            color: var(--mc-primary);
            background-color: #F6F2EC;
        }

        .mc-nav-link.active {
            background-color: var(--mc-pill-bg);
            color: var(--mc-primary);
            font-weight: 600;
        }

        .mc-user-pill {
            background-color: var(--mc-bg);
            border: 1px solid var(--mc-border);
            border-radius: 999px;
            padding: 0.3rem 0.65rem 0.3rem 0.35rem;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .mc-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: var(--mc-primary);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .mc-role-tag {
            background-color: var(--mc-surface);
            border: 1px solid var(--mc-border);
            border-radius: 999px;
            padding: 0.1rem 0.55rem;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--mc-text-main);
        }

        .btn-mc-outline {
            background-color: var(--mc-surface);
            border: 1px solid var(--mc-border-input);
            color: var(--mc-text-main);
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.45rem 0.9rem;
            transition: all 0.18s ease;
            text-decoration: none;
        }

        .btn-mc-outline:hover {
            background-color: var(--mc-pill-bg);
            border-color: var(--mc-primary);
            color: var(--mc-primary);
        }

        .btn-mc-primary {
            background-color: var(--mc-primary);
            border: 1px solid var(--mc-primary);
            color: #FFFFFF;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.62rem 1.2rem;
            box-shadow: 0 2px 6px rgba(61, 44, 30, 0.14);
            transition: all 0.18s ease;
        }

        .btn-mc-primary:hover {
            background-color: var(--mc-primary-hover);
            border-color: var(--mc-primary-hover);
            color: #FFFFFF;
            transform: translateY(-1px);
        }

        .mc-card {
            background-color: var(--mc-surface);
            border: 1px solid var(--mc-border);
            border-radius: 16px;
        }

        .mc-kpi-icon {
            width: 48px;
            height: 48px;
            background-color: var(--mc-pill-bg);
            color: var(--mc-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .mc-subtabs {
            background-color: var(--mc-pill-bg);
            padding: 0.3rem;
            border-radius: 12px;
            display: inline-flex;
            gap: 0.25rem;
        }

        .mc-subtab-link {
            padding: 0.45rem 1rem;
            border-radius: 9px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--mc-text-muted);
            text-decoration: none;
            transition: all 0.18s ease;
        }

        .mc-subtab-link.active {
            background-color: var(--mc-surface);
            color: var(--mc-primary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .mc-input {
            background-color: var(--mc-surface);
            border: 1px solid var(--mc-border-input);
            border-radius: 10px;
            font-size: 0.88rem;
            padding: 0.55rem 0.9rem;
            color: var(--mc-text-main);
        }

        .mc-input:focus {
            border-color: var(--mc-primary);
            box-shadow: 0 0 0 3px rgba(61, 44, 30, 0.1);
            outline: none;
        }

        .mc-table thead th {
            background-color: var(--mc-table-head);
            color: var(--mc-text-muted);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 0.85rem 1.25rem;
            border-top: 1px solid var(--mc-border);
            border-bottom: 1px solid var(--mc-border);
        }

        .mc-table tbody td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--mc-border);
            font-size: 0.88rem;
            vertical-align: middle;
        }

        .mc-table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge-mc-disewa {
            background-color: #FEF3C7;
            color: #92400E;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.76rem;
        }

        .badge-mc-selesai {
            background-color: #DCFCE7;
            color: #166534;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.76rem;
        }

        .badge-mc-terlambat {
            background-color: #FEE2E2;
            color: #991B1B;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.76rem;
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="mc-navbar">
        <div class="container-xl d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-4">
                <a href="{{ url('/penyewaan') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <div class="mc-brand-box">
                        <i class="bi bi-triangle-fill"></i>
                    </div>
                    <div>
                        <p class="mc-brand-title">MyCamp</p>
                        <p class="mc-brand-sub">Outdoor Rental</p>
                    </div>
                </a>

                <div class="d-none d-md-flex align-items-center gap-1 ms-2">
                    <a href="{{ url('/penyewa') }}" class="mc-nav-link {{ request()->is('penyewa*') ? 'active' : '' }}">
                        Data Penyewa
                    </a>
                    <a href="{{ url('/peralatan') }}" class="mc-nav-link {{ request()->is('peralatan*') ? 'active' : '' }}">
                        Peralatan
                    </a>
                    <a href="{{ url('/penyewaan') }}" class="mc-nav-link {{ request()->is('penyewaan*') || request()->is('pengembalian*') ? 'active' : '' }}">
                        Transaksi
                    </a>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <div class="mc-user-pill">
                    <span class="mc-avatar">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'A', 0, 1)) }}
                    </span>
                    <span class="d-none d-sm-inline">{{ auth()->user()->nama_lengkap ?? 'Admin MyCamp' }}</span>
                    <span class="mc-role-tag">{{ (auth()->user()->role_id ?? 1) == 1 ? 'Admin' : 'Kasir' }}</span>
                </div>

                <form action="{{ url('/logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn-mc-outline d-inline-flex align-items-center gap-1">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container-xl py-4 my-1">
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        const successMsg = document.body.dataset.success;
        const errorMsg = document.body.dataset.error;

        if (successMsg) {
            Toastify({
                text: successMsg,
                duration: 3500,
                gravity: "top",
                position: "right",
                style: { background: "#3D2C1E", borderRadius: "10px", fontFamily: "Plus Jakarta Sans, sans-serif" }
            }).showToast();
        }

        if (errorMsg) {
            Toastify({
                text: errorMsg,
                duration: 4000,
                gravity: "top",
                position: "right",
                style: { background: "#991B1B", borderRadius: "10px", fontFamily: "Plus Jakarta Sans, sans-serif" }
            }).showToast();
        }
    </script>
    @stack('scripts')
</body>
</html>