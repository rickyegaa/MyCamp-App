@extends('layouts.app')

@section('title', 'Pengembalian & Denda')

@section('content')
@php
    $dataPengembalian = $pengembalianList ?? $pengembalian ?? collect();
    $dataAktif        = $penyewaanAktif ?? collect();

    $menungguCount    = $dataAktif->count();
    $selesaiCount     = $dataPengembalian->count();
    $totalDenda       = $dataPengembalian->sum(fn($row) => $row->total_denda ?? 0);
    $selectedSewaId   = old('penyewaan_id', request('penyewaan_id'));
@endphp

<!-- Page Header -->
<div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1" style="color: #1F1915;">Pengembalian & Denda</h1>
        <p class="mb-0" style="color: #857B6E; font-size: 0.92rem;">
            Proses pengembalian perlengkapan camping, perhitungan denda keterlambatan, dan pemulihan stok alat.
        </p>
    </div>

    <div class="d-flex flex-wrap align-items-center gap-2">
        <div class="mc-subtabs me-1">
            <a href="{{ url('/penyewaan') }}" class="mc-subtab-link">Penyewaan</a>
            <a href="{{ url('/pengembalian') }}" class="mc-subtab-link active">Pengembalian & Denda</a>
        </div>

        <button type="button" class="btn-mc-primary d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambahPengembalian">
            <i class="bi bi-arrow-return-left"></i>
            <span>Proses Pengembalian</span>
        </button>
    </div>
</div>

<!-- Kotak Notifikasi -->
@if ($errors->any())
    <div class="alert alert-danger border-0 rounded-4 mb-4" style="background-color: #FEE2E2; color: #991B1B;">
        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Gagal Memproses Pengembalian:</div>
        <ul class="mb-0 small">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger border-0 rounded-4 mb-4" style="background-color: #FEE2E2; color: #991B1B;">
        <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert border-0 rounded-4 mb-4" style="background-color: #DCFCE7; color: #166534;">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
    </div>
@endif

<!-- KPI Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="mc-card p-3 px-4 d-flex align-items-center gap-3">
            <div class="mc-kpi-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: #857B6E; font-weight: 500;">Menunggu Dikembalikan</div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h4 fw-bold mb-0">{{ $menungguCount }}</span>
                    <span style="font-size: 0.85rem; color: #857B6E;">Transaksi</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mc-card p-3 px-4 d-flex align-items-center gap-3">
            <div class="mc-kpi-icon">
                <i class="bi bi-check2-circle"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: #857B6E; font-weight: 500;">Total Pengembalian</div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h4 fw-bold mb-0">{{ $selesaiCount }}</span>
                    <span style="font-size: 0.85rem; color: #857B6E;">Transaksi</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mc-card p-3 px-4 d-flex align-items-center gap-3">
            <div class="mc-kpi-icon">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: #857B6E; font-weight: 500;">Total Denda Terkumpul</div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h4 fw-bold mb-0">Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="mc-card overflow-hidden">
    <div class="p-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <h2 class="h6 fw-bold mb-0">Riwayat Pengembalian & Denda</h2>

        <div class="position-relative" style="min-width: 290px;">
            <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3" style="color: #857B6E;"></i>
            <input type="text" id="searchPengembalian" class="form-control mc-input ps-5" placeholder="Cari kode transaksi atau penyewa...">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table mc-table mb-0" id="tablePengembalian">
            <thead>
                <tr>
                    <th style="width: 60px;">NO</th>
                    <th>KODE SEWA</th>
                    <th>NAMA PENYEWA</th>
                    <th>TGL RENCANA & AKTUAL</th>
                    <th>KETERLAMBATAN</th>
                    <th>TOTAL DENDA</th>
                    <th>KONDISI ALAT</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataPengembalian as $index => $kembali)
                    @php
                        $sewa        = $kembali->penyewaan;
                        $kode        = $sewa->kode_transaksi ?? ('TRX-' . str_pad($kembali->penyewaan_id ?? 0, 4, '0', STR_PAD_LEFT));
                        $namaPenyewa = $sewa->penyewa->nama_lengkap ?? $sewa->penyewa->nama_penyewa ?? 'Pelanggan';
                        $tglRencana  = $sewa->tanggal_rencana_kembali ?? $sewa->tanggal_kembali_rencana ?? $sewa->tanggal_kembali ?? '-';
                        $tglAktual   = $kembali->tanggal_aktual_kembali ?? $kembali->tanggal_kembali_aktual ?? $kembali->tanggal_pengembalian ?? '-';
                        $hariTelat   = $kembali->hari_terlambat ?? $kembali->keterlambatan_hari ?? 0;
                        $denda       = $kembali->total_denda ?? 0;
                        $kondisi     = $kembali->keterangan ?? $kembali->kondisi_alat ?? $kembali->catatan ?? 'Baik & Lengkap';
                    @endphp
                    <tr>
                        <td class="fw-medium text-muted">{{ $index + 1 }}</td>
                        <td class="fw-bold" style="color: #3D2C1E;">{{ $kode }}</td>
                        <td>
                            <div class="fw-semibold">{{ $namaPenyewa }}</div>
                            <small class="text-muted">{{ $sewa->penyewa->telepon ?? '' }}</small>
                        </td>
                        <td>
                            <div>Aktual: {{ $tglAktual !== '-' ? \Carbon\Carbon::parse($tglAktual)->format('d M Y') : '-' }}</div>
                            <small class="text-muted">Rencana: {{ $tglRencana !== '-' ? \Carbon\Carbon::parse($tglRencana)->format('d M Y') : '-' }}</small>
                        </td>
                        <td>
                            @if($hariTelat > 0)
                                <span class="badge-mc-terlambat">Telat {{ $hariTelat }} Hari</span>
                            @else
                                <span class="badge-mc-selesai">Tepat Waktu</span>
                            @endif
                        </td>
                        <td class="fw-semibold">Rp {{ number_format($denda, 0, ',', '.') }}</td>
                        <td>{{ $kondisi }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5" style="color: #857B6E;">
                            Belum ada riwayat pengembalian barang. Klik <strong>Proses Pengembalian</strong> untuk mencatat pengembalian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Proses Pengembalian -->
<div class="modal fade" id="modalTambahPengembalian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid #EAE4DC;">
            <div class="modal-header border-bottom" style="border-color: #EAE4DC !important;">
                <h5 class="modal-title fw-bold">Proses Pengembalian Perlengkapan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/pengembalian') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Pilih Transaksi yang Sedang Disewa</label>
                            <select name="penyewaan_id" id="selectPenyewaan" class="form-select mc-input" required>
                                <option value="" data-rencana="">-- Pilih Transaksi Aktif --</option>
                                @foreach($dataAktif as $trx)
                                    @php
                                        $idTrx   = $trx->id_penyewaan ?? $trx->id;
                                        $kodeTrx = $trx->kode_transaksi ?? ('TRX-' . str_pad($idTrx, 4, '0', STR_PAD_LEFT));
                                        $namaP   = $trx->penyewa->nama_lengkap ?? $trx->penyewa->nama_penyewa ?? 'Pelanggan';
                                        $rencana = $trx->tanggal_rencana_kembali ?? $trx->tanggal_kembali_rencana ?? $trx->tanggal_kembali ?? date('Y-m-d');
                                    @endphp
                                    <option value="{{ $idTrx }}" data-rencana="{{ $rencana }}" {{ $selectedSewaId == $idTrx ? 'selected' : '' }}>
                                        {{ $kodeTrx }} – {{ $namaP }} (Rencana Kembali: {{ \Carbon\Carbon::parse($rencana)->format('d M Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tanggal Kembali Aktual</label>
                            <input type="date" name="tanggal_kembali_aktual" id="tglAktual" class="form-control mc-input" value="{{ old('tanggal_kembali_aktual', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Denda Kerusakan / Kehilangan (Rp)</label>
                            <input type="number" name="denda_kerusakan" id="dendaKerusakan" class="form-control mc-input" value="{{ old('denda_kerusakan', 0) }}" min="0" step="1000">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">Catatan Kondisi Alat</label>
                            <input type="text" name="kondisi_alat" class="form-control mc-input" value="{{ old('kondisi_alat', 'Baik & Lengkap') }}" placeholder="Contoh: Tenda lengkap, pasak utuh, bersih">
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3" style="background-color: #F8F5F0; border: 1px solid #EAE4DC;">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Keterlambatan (<span id="labelHariTelat">0</span> Hari × Rp 25.000)</span>
                                    <span id="labelDendaTelat">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: #EAE4DC !important;">
                                    <span class="fw-semibold" style="color: #1F1915;">Estimasi Total Denda</span>
                                    <span class="h5 fw-bold mb-0" style="color: #3D2C1E;" id="labelTotalDenda">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top" style="border-color: #EAE4DC !important;">
                    <button type="button" class="btn-mc-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-mc-primary">Selesaikan Pengembalian</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchPengembalian');
        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                const keyword = this.value.toLowerCase();
                document.querySelectorAll('#tablePengembalian tbody tr').forEach(function (row) {
                    row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
                });
            });
        }

        function hitungDenda() {
            const selectTrx = document.getElementById('selectPenyewaan');
            const selectedOption = selectTrx.options[selectTrx.selectedIndex];
            const rencanaStr = selectedOption?.dataset?.rencana;
            const aktualStr  = document.getElementById('tglAktual').value;
            const dendaRusak = parseFloat(document.getElementById('dendaKerusakan').value) || 0;

            let hariTelat = 0;
            if (rencanaStr && aktualStr) {
                const tglRencana = new Date(rencanaStr + 'T00:00:00');
                const tglAktual  = new Date(aktualStr + 'T00:00:00');
                const selisih    = Math.floor((tglAktual - tglRencana) / (1000 * 60 * 60 * 24));
                if (selisih > 0) hariTelat = selisih;
            }

            const dendaTelat = hariTelat * 25000;
            const totalDenda = dendaTelat + dendaRusak;

            document.getElementById('labelHariTelat').textContent = hariTelat;
            document.getElementById('labelDendaTelat').textContent = 'Rp ' + dendaTelat.toLocaleString('id-ID');
            document.getElementById('labelTotalDenda').textContent = 'Rp ' + totalDenda.toLocaleString('id-ID');
        }

        ['selectPenyewaan', 'tglAktual', 'dendaKerusakan'].forEach(function (id) {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('change', hitungDenda);
                el.addEventListener('keyup', hitungDenda);
            }
        });

        const modalEl = document.getElementById('modalTambahPengembalian');
        if (modalEl) {
            modalEl.addEventListener('shown.bs.modal', hitungDenda);

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('penyewaan_id') && typeof bootstrap !== 'undefined') {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }
    });
</script>
@endpush