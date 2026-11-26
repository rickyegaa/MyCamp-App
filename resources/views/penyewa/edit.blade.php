@extends('layouts.app')

@section('title', 'Edit Penyewa')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-3">
        <a href="{{ route('penyewa.index') }}" class="group inline-flex items-center gap-1.5 text-xs font-medium text-[#6e655c] hover:text-[#1f1b16] transition-colors">
            <span class="inline-block transition-transform duration-150 group-hover:-translate-x-0.5">&larr;</span>
            <span>Kembali ke Data Penyewa</span>
        </a>
    </div>

    <div class="bg-white border border-[#dfd6c5] rounded overflow-hidden">
        <div class="px-5 py-3.5 bg-[#faf7f2] border-b border-[#dfd6c5]">
            <h1 class="text-[15px] font-bold text-[#1f1b16]">Edit Data Penyewa</h1>
        </div>

        <form id="formPenyewa" action="{{ route('penyewa.update', $penyewa->id_penyewa) }}" method="POST" class="p-5 space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nik_ktm" class="block text-xs font-semibold text-[#1f1b16] mb-1">NIK / KTM (Identitas Jaminan)</label>
                    <input type="text" name="nik_ktm" id="nik_ktm" maxlength="20"
                        value="{{ old('nik_ktm', $penyewa->nik_ktm) }}" required
                        class="w-full rounded border border-[#d4cab8] bg-white px-3 py-2 text-[13px] text-[#1f1b16] transition-shadow duration-150 focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none @error('nik_ktm') border-red-500 @enderror">
                    @error('nik_ktm')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telepon" class="block text-xs font-semibold text-[#1f1b16] mb-1">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="telepon" id="telepon" maxlength="15"
                        value="{{ old('telepon', $penyewa->telepon) }}" required
                        class="w-full rounded border border-[#d4cab8] bg-white px-3 py-2 text-[13px] text-[#1f1b16] transition-shadow duration-150 focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none @error('telepon') border-red-500 @enderror">
                    @error('telepon')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="nama_lengkap" class="block text-xs font-semibold text-[#1f1b16] mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" maxlength="64"
                    value="{{ old('nama_lengkap', $penyewa->nama_lengkap) }}" required
                    class="w-full rounded border border-[#d4cab8] bg-white px-3 py-2 text-[13px] text-[#1f1b16] transition-shadow duration-150 focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none @error('nama_lengkap') border-red-500 @enderror">
                @error('nama_lengkap')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="alamat" class="block text-xs font-semibold text-[#1f1b16] mb-1">Alamat Domisili</label>
                <textarea name="alamat" id="alamat" rows="3" required
                    class="w-full rounded border border-[#d4cab8] bg-white px-3 py-2 text-[13px] text-[#1f1b16] transition-shadow duration-150 focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none @error('alamat') border-red-500 @enderror">{{ old('alamat', $penyewa->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ece5d8]">
                <a href="{{ route('penyewa.index') }}"
                   class="btn-tactile px-3.5 py-2 rounded text-xs font-medium border border-[#d4cab8] bg-white text-[#6e655c] hover:bg-[#f6f2ea] hover:text-[#1f1b16]">
                    Batal
                </a>
                <button type="submit" id="btnSubmit"
                    class="btn-tactile inline-flex items-center gap-2 px-4 py-2 rounded text-xs font-medium bg-[#4a3519] hover:bg-[#382712] text-white cursor-pointer">
                    <svg id="spinnerSubmit" class="hidden w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span id="labelSubmit">Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#formPenyewa').on('submit', function () {
            $('#btnSubmit').prop('disabled', true);
            $('#spinnerSubmit').removeClass('hidden');
            $('#labelSubmit').text('Menyimpan...');
        });
    });
</script>
@endpush