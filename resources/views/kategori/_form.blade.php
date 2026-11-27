<div class="mb-3">
    <label class="form-label">Nama Kategori</label>
    <input type="text" name="nama_kategori" maxlength="50"
           class="form-control @error('nama_kategori') is-invalid @enderror"
           value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" required>
    @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
<button class="btn btn-success">Simpan</button>
