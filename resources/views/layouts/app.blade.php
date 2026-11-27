{{-- Layout sementara untuk fitur katalog alat. Ganti/gabungkan jika tim sudah punya layout bersama. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MyCamp')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand navbar-dark bg-success mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">MyCamp</a>
        <div class="navbar-nav">
            <a class="nav-link" href="{{ route('peralatan.index') }}">Peralatan</a>
            <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
        </div>
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
