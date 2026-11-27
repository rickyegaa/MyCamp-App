@php $edit = isset($peralatan); @endphp

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Kode Alat</label>
        <input type="text" name="kode_alat" maxlength="20" class="form-control @error('kode_alat') is-invalid @enderror"
               value="{{ old('kode_alat', $peralatan->kode_alat ?? '') }}" required>
        @error('kode_alat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-8">
        <label class="form-label">Nama Alat</label>
        <input type="text" name="nama_alat" maxlength="100" class="form-control @error('nama_alat') is-invalid @enderror"
               value="{{ old('nama_alat', $peralatan->nama_alat ?? '') }}" required>
        @error('nama_alat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Kategori</label>
        <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
            <option value="">-- Pilih kategori --</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id_kategori }}" @selected(old('kategori_id', $peralatan->kategori_id ?? '') == $k->id_kategori)>{{ $k->nama_kategori }}</option>
            @endforeach
        </select>
        @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Harga Sewa per Hari (Rp)</label>
        <input type="number" name="harga_sewa_per_hari" min="0" step="500"
               class="form-control @error('harga_sewa_per_hari') is-invalid @enderror"
               value="{{ old('harga_sewa_per_hari', isset($peralatan) ? (int) $peralatan->harga_sewa_per_hari : '') }}" required>
        @error('harga_sewa_per_hari') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Stok Total</label>
        <input type="number" name="stok_total" min="0" class="form-control @error('stok_total') is-invalid @enderror"
               value="{{ old('stok_total', $peralatan->stok_total ?? '') }}" required>
        @error('stok_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if ($edit)
            <div class="form-text">Tersedia: {{ $peralatan->stok_tersedia }}, sedang disewa: {{ $peralatan->stok_disewa }}. Stok tersedia dihitung otomatis.</div>
        @else
            <div class="form-text">Stok tersedia otomatis sama dengan stok total untuk alat baru.</div>
        @endif
    </div>
    <div class="col-md-6">
        <label class="form-label">Kondisi</label>
        <select name="status_kondisi" class="form-select @error('status_kondisi') is-invalid @enderror" required>
            <option value="baik" @selected(old('status_kondisi', $peralatan->status_kondisi ?? 'baik') == 'baik')>Baik</option>
            <option value="perlu_perbaikan" @selected(old('status_kondisi', $peralatan->status_kondisi ?? '') == 'perlu_perbaikan')>Perlu perbaikan</option>
        </select>
        @error('status_kondisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Foto (opsional, maks 2 MB)</label>
        <input type="file" name="foto" id="foto" accept="image/*" class="form-control @error('foto') is-invalid @enderror">
        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <img id="preview" class="mt-2 rounded {{ $edit && $peralatan->foto ? '' : 'd-none' }}" width="120"
             src="{{ $edit && $peralatan->foto ? asset('storage/'.$peralatan->foto) : '' }}" alt="Pratinjau foto">
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('peralatan.index') }}" class="btn btn-secondary">Batal</a>
    <button class="btn btn-success">Simpan</button>
</div>

@push('scripts')
<script>
    // Pratinjau foto sebelum diunggah
    $('#foto').on('change', function () {
        const file = this.files[0];
        if (file) $('#preview').attr('src', URL.createObjectURL(file)).removeClass('d-none');
    });
</script>
@endpush
