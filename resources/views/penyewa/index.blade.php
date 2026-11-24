@extends('layouts.app')

@section('title', 'Data Penyewa')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-[#1f1a16]">Manajemen Data Penyewa</h1>
        <p class="text-sm text-[#78716c] mt-0.5">Kelola identitas jaminan (NIK/KTM) dan kontak pelanggan penyewa perlengkapan camping.</p>
    </div>

    <a href="{{ route('penyewa.create') }}"
       class="inline-flex items-center justify-center gap-2 bg-[#4a3519] hover:bg-[#362611] text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        <span>Tambah Penyewa Baru</span>
    </a>
</div>

<!-- Notifikasi Sukses -->
@if (session('success'))
    <div id="alertSuccess" class="flex items-center justify-between bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-sm">
        <div class="flex items-center gap-2 font-medium">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="document.getElementById('alertSuccess').remove()" class="text-emerald-600 hover:text-emerald-900 cursor-pointer">
            &times;
        </button>
    </div>
@endif

<!-- Kartu Statistik Ringkas -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white border border-[#e6dfd5] rounded-2xl p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-[#f2ece4] text-[#4a3519] flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-medium text-[#78716c]">Total Penyewa Terdaftar</p>
            <p class="text-2xl font-bold text-[#1f1a16]">{{ $penyewas->count() }} <span class="text-xs font-normal text-[#78716c]">Pelanggan</span></p>
        </div>
    </div>
</div>

<!-- Kartu Tabel Data Penyewa -->
<div class="bg-white border border-[#e6dfd5] rounded-2xl overflow-hidden shadow-[0_4px_20px_rgba(74,53,25,0.03)]">
    <div class="p-4 sm:px-6 border-b border-[#e6dfd5] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h2 class="font-bold text-base text-[#1f1a16]">Daftar Pelanggan Penyewa</h2>

        <div class="relative w-full sm:w-80">
            <svg class="w-4 h-4 text-[#8c857e] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
            </svg>
            <input type="text" id="searchPenyewa"
                placeholder="Cari NIK/KTM, nama, atau telepon..."
                class="w-full rounded-xl border border-[#e6dfd5] bg-[#f7f3ee]/60 pl-10 pr-4 py-2 text-sm text-[#1f1a16] placeholder-[#a8a29e] focus:bg-white focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none transition">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#faf8f5] border-b border-[#e6dfd5] text-[11px] font-bold uppercase tracking-wider text-[#78716c]">
                    <th class="py-3.5 px-6 w-14">No</th>
                    <th class="py-3.5 px-4">Nama Penyewa</th>
                    <th class="py-3.5 px-4">NIK / KTM</th>
                    <th class="py-3.5 px-4">No. Telepon / WA</th>
                    <th class="py-3.5 px-4">Alamat Domisili</th>
                    <th class="py-3.5 px-6 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody id="tabelPenyewa" class="divide-y divide-[#f0ebe3] text-sm">
                @forelse ($penyewas as $index => $penyewa)
                    <tr class="baris-penyewa hover:bg-[#faf8f5] transition">
                        <td class="py-3.5 px-6 text-[#78716c]">{{ $index + 1 }}</td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#f2ece4] text-[#4a3519] font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($penyewa->nama_lengkap, 0, 1)) }}
                                </div>
                                <span class="font-semibold text-[#1f1a16]">{{ $penyewa->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-block font-mono text-xs bg-[#f7f3ee] border border-[#e6dfd5] text-[#4a3519] px-2.5 py-1 rounded-lg">
                                {{ $penyewa->nik_ktm }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-medium text-[#1f1a16]">{{ $penyewa->telepon }}</td>
                        <td class="py-3.5 px-4 text-[#6e655f]">{{ $penyewa->alamat }}</td>
                        <td class="py-3.5 px-6 text-center">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('penyewa.edit', $penyewa->id_penyewa) }}" title="Edit Data"
                                   class="p-2 rounded-lg border border-[#e6dfd5] text-amber-700 hover:bg-amber-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                    </svg>
                                </a>

                                <form action="{{ route('penyewa.destroy', $penyewa->id_penyewa) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data penyewa {{ $penyewa->nama_lengkap }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Data"
                                        class="p-2 rounded-lg border border-[#e6dfd5] text-red-600 hover:bg-red-50 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-sm text-[#78716c]">
                            Belum ada data penyewa terdaftar. Klik <strong>Tambah Penyewa Baru</strong> untuk memulai.
                        </td>
                    </tr>
                @endforelse
                <tr id="emptySearchRow" style="display: none;">
                    <td colspan="6" class="py-10 text-center text-sm text-[#78716c]">
                        Data penyewa yang dicari tidak ditemukan.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#searchPenyewa').on('keyup', function () {
            let keyword = $(this).val().toLowerCase();
            let jumlahCocok = 0;

            $('.baris-penyewa').each(function () {
                let teksBaris = $(this).text().toLowerCase();
                let cocok = teksBaris.indexOf(keyword) > -1;
                $(this).toggle(cocok);
                if (cocok) jumlahCocok++;
            });

            if ($('.baris-penyewa').length > 0 && jumlahCocok === 0) {
                $('#emptySearchRow').show();
            } else {
                $('#emptySearchRow').hide();
            }
        });
    });
</script>
@endpush