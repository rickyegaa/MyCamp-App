{{-- resources/views/layouts/app.blade.php : tema cokelat & krem (MyCamp) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MyCamp')</title>

    {{-- Font (perkiraan; hapus 2 baris ini + baris font-family di bawah kalau tidak mau) --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ====== PALET WARNA: ubah di sini saja ====== */
        :root {
            --mc-bg:        #F6F2E9;  /* latar halaman */
            --mc-nav:       #FEFDF9;  /* latar navbar */
            --mc-brown:     #483619;  /* tombol utama & garis menu aktif */
            --mc-brown-hov: #5E4724;  /* tombol saat disorot */
            --mc-head:      #F7ECDC;  /* header tabel */
            --mc-border:    #E5E1DC;  /* garis & border */
            --mc-text:      #2B2217;  /* teks utama */
            --mc-muted:     #8C8270;  /* teks menu tidak aktif */
            --mc-ok:        #5F7A3D;  /* badge kondisi baik */
        }

        body { background: var(--mc-bg); color: var(--mc-text); font-family: 'Outfit', system-ui, sans-serif; }

        /* Navbar */
        .mc-nav { background: var(--mc-nav); border-bottom: 1px solid var(--mc-border); margin-bottom: 1.75rem; }
        .mc-nav .container { display: flex; align-items: center; gap: 2rem; height: 68px; }
        .mc-brand { font-weight: 600; font-size: 1.15rem; color: var(--mc-text); text-decoration: none; }
        .mc-link { color: var(--mc-muted); text-decoration: none; height: 68px; display: flex; align-items: center;
                   border-bottom: 3px solid transparent; padding: 0 .1rem; }
        .mc-link:hover { color: var(--mc-text); }
        .mc-link.active { color: var(--mc-text); font-weight: 500; border-bottom-color: var(--mc-brown); }

        /* Tombol hijau bawaan -> cokelat */
        .btn-success {
            --bs-btn-bg: var(--mc-brown); --bs-btn-border-color: var(--mc-brown); --bs-btn-color: #fff;
            --bs-btn-hover-bg: var(--mc-brown-hov); --bs-btn-hover-border-color: var(--mc-brown-hov); --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: var(--mc-brown-hov); --bs-btn-active-border-color: var(--mc-brown-hov); --bs-btn-active-color: #fff;
        }
        .btn-outline-success {
            --bs-btn-color: var(--mc-brown); --bs-btn-border-color: var(--mc-brown);
            --bs-btn-hover-bg: var(--mc-brown); --bs-btn-hover-border-color: var(--mc-brown); --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: var(--mc-brown); --bs-btn-active-border-color: var(--mc-brown); --bs-btn-active-color: #fff;
        }

        /* Kartu, tabel, form */
        .card { background: #fff; border: 1px solid var(--mc-border); border-radius: 10px; box-shadow: none !important; }
        .table-light { --bs-table-bg: var(--mc-head); --bs-table-color: var(--mc-text); --bs-table-border-color: var(--mc-border); }
        .table { --bs-table-hover-bg: #FBF6EC; }
        .form-control, .form-select { background-color: #FFFBEC; border-color: var(--mc-border); }
        .form-control:focus, .form-select:focus {
            border-color: var(--mc-brown); box-shadow: 0 0 0 .2rem rgba(72, 54, 25, .15); background-color: #fff;
        }
        .text-bg-success { background-color: var(--mc-ok) !important; }
        .page-link { color: var(--mc-brown); }
        .page-item.active .page-link { background: var(--mc-brown); border-color: var(--mc-brown); color: #fff; }
    </style>
</head>
<body>
<nav class="mc-nav">
    <div class="container">
        {{-- Kalau punya logo: taruh di public/images/logo.png lalu aktifkan baris di bawah --}}
        {{-- <img src="{{ asset('images/logo.png') }}" alt="MyCamp" height="32"> --}}
        <a class="mc-brand" href="{{ route('peralatan.index') }}">MyCamp</a>

        <a class="mc-link {{ request()->routeIs('peralatan.*') ? 'active' : '' }}" href="{{ route('peralatan.index') }}">Peralatan</a>
        <a class="mc-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">Kategori</a>
    </div>
</nav>

<main class="container pb-5">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    @yield('content')
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Konfirmasi sebelum menghapus
    $(document).on('submit', 'form.form-hapus', function (e) {
        if (!confirm('Yakin ingin menghapus data ini?')) e.preventDefault();
    });
</script>
@stack('scripts')
</body>
</html>