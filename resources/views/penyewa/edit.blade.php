@extends('layouts.app')

@section('title', 'Edit Penyewa')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('penyewa.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-[#78716c] hover:text-[#1f1a16] mb-4 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
        </svg>
        <span>Kembali ke Daftar Penyewa</span>
    </a>

    <div class="bg-white border border-[#e6dfd5] rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(74,53,25,0.03)]">
        <div class="px-6 py-5 border-b border-[#e6dfd5]">
            <h1 class="text-lg font-bold text-[#1f1a16]">Perbarui Biodata Penyewa</h1>
            <p class="text-xs text-[#78716c] mt-0.5">Ubah data identitas atau nomor kontak penyewa yang terdaftar.</p>
        </div>

        <form action="{{ route('penyewa.update', $penyewa->id_penyewa) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nik_ktm" class="block text-sm font-semibold text-[#1f1a16] mb-1.5">NIK / KTM (Jaminan)</label>
                    <input type="text" name="nik_ktm" id="nik_ktm" maxlength="20"
                        value="{{ old('nik_ktm', $penyewa->nik_ktm) }}" required
                        class="w-full rounded-xl border border-[#e6dfd5] px-4 py-2.5 text-sm text-[#1f1a16] focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none @error('nik_ktm') border-red-500 @enderror">
                    @error('nik_ktm')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telepon" class="block text-sm font-semibold text-[#1f1a16] mb-1.5">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="telepon" id="telepon" maxlength="15"
                        value="{{ old('telepon', $penyewa->telepon) }}" required
                        class="w-full rounded-xl border border-[#e6dfd5] px-4 py-2.5 text-sm text-[#1f1a16] focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none @error('telepon') border-red-500 @enderror">
                    @error('telepon')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="nama_lengkap" class="block text-sm font-semibold text-[#1f1a16] mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" maxlength="64"
                    value="{{ old('nama_lengkap', $penyewa->nama_lengkap) }}" required
                    class="w-full rounded-xl border border-[#e6dfd5] px-4 py-2.5 text-sm text-[#1f1a16] focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none @error('nama_lengkap') border-red-500 @enderror">
                @error('nama_lengkap')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="alamat" class="block text-sm font-semibold text-[#1f1a16] mb-1.5">Alamat Domisili</label>
                <textarea name="alamat" id="alamat" rows="3" required
                    class="w-full rounded-xl border border-[#e6dfd5] px-4 py-2.5 text-sm text-[#1f1a16] focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none @error('alamat') border-red-500 @enderror">{{ old('alamat', $penyewa->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-[#f0ebe3]">
                <a href="{{ route('penyewa.index') }}"
                   class="px-4 py-2.5 rounded-xl text-sm font-semibold border border-[#e6dfd5] text-[#6e655f] hover:bg-[#f7f3ee] transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-[#4a3519] hover:bg-[#362611] text-white transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection