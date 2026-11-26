@extends('layouts.app')

@section('title', 'Data Penyewa')

@section('content')
<div class="flex items-center justify-between gap-4 mb-4">
    <div class="flex items-baseline gap-2">
        <h1 class="text-lg font-bold text-[#1f1b16]">Data Penyewa</h1>
        <span class="text-xs text-[#6e655c]">({{ $penyewas->count() }} orang)</span>
    </div>

    <a href="{{ route('penyewa.create') }}"
       class="btn-tactile group inline-flex items-center gap-1.5 bg-[#4a3519] hover:bg-[#382712] text-white text-[13px] font-medium px-3.5 py-2 rounded">
        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        <span>Tambah Penyewa</span>
    </a>
</div>

@if (session('success'))
    <div id="alertSuccess" class="animate-alert-in flex items-center justify-between bg-emerald-50 border border-emerald-300 text-emerald-900 px-3.5 py-2 rounded mb-4 text-[13px]">
        <span>{{ session('success') }}</span>
        <button type="button" id="btnCloseAlert" class="text-emerald-700 hover:text-emerald-950 font-bold px-1.5 py-0.5 rounded hover:bg-emerald-100 active:scale-90 transition cursor-pointer">
            &times;
        </button>
    </div>
@endif

<div class="bg-white border border-[#dfd6c5] rounded overflow-hidden">
    <div class="px-4 py-2.5 bg-[#faf7f2] border-b border-[#dfd6c5] flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <div class="relative w-full sm:w-80">
            <input type="text" id="searchPenyewa"
                placeholder="Cari nama, NIK/KTM, atau no. WhatsApp..."
                class="w-full rounded border border-[#d4cab8] bg-white pl-3 pr-8 py-1.5 text-[13px] text-[#1f1b16] placeholder-[#999084] transition-shadow duration-150 focus:border-[#4a3519] focus:ring-2 focus:ring-[#4a3519]/15 focus:outline-none">
            <button type="button" id="clearSearch" title="Hapus pencarian"
                class="hidden absolute right-2 top-1/2 -translate-y-1/2 text-[#857b70] hover:text-[#1f1b16] text-sm px-1 rounded hover:bg-[#efe8da] active:scale-90 transition cursor-pointer">
                &times;
            </button>
        </div>

        <span class="text-xs text-[#6e655c] hidden sm:inline">
            Menampilkan <span id="jumlahTampil">{{ $penyewas->count() }}</span> data
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#f3ede2] border-b border-[#dfd6c5] text-xs font-semibold text-[#4a3519]">
                    <th class="py-2.5 px-4 w-12">No</th>
                    <th class="py-2.5 px-4">Nama Penyewa</th>
                    <th class="py-2.5 px-4">NIK / KTM</th>
                    <th class="py-2.5 px-4">No. Telepon / WA</th>
                    <th class="py-2.5 px-4">Alamat</th>
                    <th class="py-2.5 px-4 text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody id="tabelPenyewa" class="divide-y divide-[#ece5d8] text-[13px]">
                @forelse ($penyewas as $index => $penyewa)
                    <tr class="baris-penyewa transition-colors duration-100 hover:bg-[#fcfaf6]">
                        <td class="py-2.5 px-4 text-[#857b70] tabular-nums">{{ $index + 1 }}</td>
                        <td class="py-2.5 px-4 font-semibold text-[#1f1b16]">{{ $penyewa->nama_lengkap }}</td>
                        <td class="py-2.5 px-4 font-mono text-xs text-[#4a3519]">{{ $penyewa->nik_ktm }}</td>
                        <td class="py-2.5 px-4 tabular-nums text-[#1f1b16]">{{ $penyewa->telepon }}</td>
                        <td class="py-2.5 px-4 text-[#595147] max-w-xs truncate" title="{{ $penyewa->alamat }}">{{ $penyewa->alamat }}</td>
                        <td class="py-2.5 px-4 text-right whitespace-nowrap">
                            <a href="{{ route('penyewa.edit', $penyewa->id_penyewa) }}"
                               class="inline-block text-xs font-medium text-[#4a3519] px-1.5 py-0.5 rounded hover:bg-[#efe8da] active:scale-95 transition">
                                Edit
                            </a>
                            <span class="text-[#d4cab8] mx-0.5">|</span>
                            <form action="{{ route('penyewa.destroy', $penyewa->id_penyewa) }}" method="POST" class="inline"
                                onsubmit="return confirm('Hapus data penyewa {{ $penyewa->nama_lengkap }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-block text-xs font-medium text-red-600 px-1.5 py-0.5 rounded hover:bg-red-50 active:scale-95 transition cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-[13px] text-[#6e655c]">
                            Belum ada data penyewa.
                        </td>
                    </tr>
                @endforelse
                <tr id="emptySearchRow" style="display: none;">
                    <td colspan="6" class="py-8 text-center text-[13px] text-[#6e655c]">
                        Data tidak ditemukan.
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
        $('#btnCloseAlert').on('click', function () {
            $('#alertSuccess').fadeOut(150, function () {
                $(this).remove();
            });
        });

        $('#searchPenyewa').on('keyup', function () {
            let rawVal = $(this).val();
            let keyword = rawVal.toLowerCase();
            let jumlahCocok = 0;

            $('#clearSearch').toggleClass('hidden', rawVal.length === 0);

            $('.baris-penyewa').each(function () {
                let teksBaris = $(this).text().toLowerCase();
                let cocok = teksBaris.indexOf(keyword) > -1;
                $(this).toggle(cocok);
                if (cocok) jumlahCocok++;
            });

            $('#jumlahTampil').text(jumlahCocok);

            if ($('.baris-penyewa').length > 0 && jumlahCocok === 0) {
                $('#emptySearchRow').show();
            } else {
                $('#emptySearchRow').hide();
            }
        });

        $('#clearSearch').on('click', function () {
            $('#searchPenyewa').val('').trigger('keyup').focus();
        });
    });
</script>
@endpush