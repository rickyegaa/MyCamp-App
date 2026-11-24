@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Tambah Data Penyewa Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('penyewa.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nik_ktm" class="form-label">NIK / KTM (Identitas Jaminan)</label>
                        <input type="text" name="nik_ktm" id="nik_ktm" maxlength="20" value="{{ old('nik_ktm') }}"
                            class="form-control @error('nik_ktm') is-invalid @enderror" required>
                        @error('nik_ktm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" maxlength="64" value="{{ old('nama_lengkap') }}"
                            class="form-control @error('nama_lengkap') is-invalid @enderror" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="telepon" id="telepon" maxlength="15" value="{{ old('telepon') }}"
                            class="form-control @error('telepon') is-invalid @enderror" required>
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label">Alamat Domisili</label>
                        <textarea name="alamat" id="alamat" rows="3"
                            class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('penyewa.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan Penyewa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection