@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Kategori Peralatan</h4>
    <a href="{{ route('kategori.create') }}" class="btn btn-success">+ Tambah Kategori</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Nama Kategori</th><th>Deskripsi</th><th>Jumlah Alat</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
            @forelse ($kategori as $k)
                <tr>
                    <td>{{ $kategori->firstItem() + $loop->index }}</td>
                    <td>{{ $k->nama_kategori }}</td>
                    <td>{{ $k->deskripsi ?? '-' }}</td>
                    <td>{{ $k->peralatan_count }}</td>
                    <td class="text-end">
                        <a href="{{ route('kategori.edit', $k) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('kategori.destroy', $k) }}" method="POST" class="d-inline form-hapus">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $kategori->links('pagination::bootstrap-5') }}</div>
@endsection
