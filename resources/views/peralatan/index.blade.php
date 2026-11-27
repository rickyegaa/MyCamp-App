@extends('layouts.app')
@section('title', 'Katalog Peralatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Katalog Peralatan</h4>
    <a href="{{ route('peralatan.create') }}" class="btn btn-success">+ Tambah Alat</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama / kode alat">
    </div>
    <div class="col-md-3">
        <select name="kategori" class="form-select">
            <option value="">Semua kategori</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id_kategori }}" @selected(request('kategori') == $k->id_kategori)>{{ $k->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="kondisi" class="form-select">
            <option value="">Semua kondisi</option>
            <option value="baik" @selected(request('kondisi') == 'baik')>Baik</option>
            <option value="perlu_perbaikan" @selected(request('kondisi') == 'perlu_perbaikan')>Perlu perbaikan</option>
        </select>
    </div>
    <div class="col-md-2 d-grid"><button class="btn btn-outline-success">Filter</button></div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Foto</th><th>Kode</th><th>Nama Alat</th><th>Kategori</th>
                    <th>Harga/Hari</th><th>Stok (tersedia/total)</th><th>Kondisi</th><th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($peralatan as $p)
                <tr>
                    <td>
                        @if ($p->foto)
                            <img src="{{ asset('storage/'.$p->foto) }}" alt="{{ $p->nama_alat }}" width="56" height="56" class="rounded object-fit-cover">
                        @else
                            <div class="bg-secondary-subtle rounded d-flex align-items-center justify-content-center text-muted small" style="width:56px;height:56px">N/A</div>
                        @endif
                    </td>
                    <td>{{ $p->kode_alat }}</td>
                    <td>{{ $p->nama_alat }}</td>
                    <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                    <td>Rp {{ number_format($p->harga_sewa_per_hari, 0, ',', '.') }}</td>
                    <td>
                        <span class="{{ $p->stok_tersedia == 0 ? 'text-danger fw-bold' : '' }}">{{ $p->stok_tersedia }}</span> / {{ $p->stok_total }}
                    </td>
                    <td>
                        @if ($p->status_kondisi === 'baik')
                            <span class="badge text-bg-success">Baik</span>
                        @else
                            <span class="badge text-bg-warning">Perlu perbaikan</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('peralatan.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('peralatan.destroy', $p) }}" method="POST" class="d-inline form-hapus">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data peralatan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $peralatan->links('pagination::bootstrap-5') }}</div>
@endsection
