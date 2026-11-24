@extends('layouts.app')

@section('title', 'Manajemen Transaksi Sewa')

@section('content')
@php
    $dataPenyewaan   = $penyewaanList ?? $penyewaan ?? collect();
    $dataPenyewa     = $penyewaList ?? $penyewa ?? collect();
    $dataPeralatan   = $peralatanList ?? $peralatan ?? collect();

    $aktifCount      = $dataPenyewaan->filter(fn($r) => in_array(strtolower($r->status ?? $r->status_penyewaan ?? ''), ['disewa', 'aktif', 'terlambat']))->count();
    $selesaiCount    = $dataPenyewaan->filter(fn($r) => in_array(strtolower($r->status ?? $r->status_penyewaan ?? ''), ['selesai', 'dikembalikan']))->count();
    $totalPendapatan = $dataPenyewaan->sum(fn($row) => $row->total_biaya ?? $row->total_harga ?? 0);
@endphp

<!-- Page Header -->
<div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1" style="color: #1F1915;">Manajemen Transaksi Sewa</h1>
        <p class="mb-0" style="color: #857B6E; font-size: 0.92rem;">
            Kelola penyewaan perlengkapan camping, durasi sewa, dan rincian tagihan pelanggan.
        </p>
    </div>

    <div class="d-flex flex-wrap align-items-center gap-2">
        <div class="mc-subtabs me-1">
            <a href="{{ url('/penyewaan') }}" class="mc-subtab-link active">Penyewaan</a>
            <a href="{{ url('/pengembalian') }}" class="mc-subtab-link">Pengembalian & Denda</a>
        </div>

        <button type="button" class="btn-mc-primary d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambahSewa">
            <i class="bi bi-plus-lg"></i>
            <span>Transaksi Sewa Baru</span>
        </button>
    </div>
</div>

<!-- Kotak Notifikasi -->
@if ($errors->any())
    <div class="alert alert-danger border-0 rounded-4 mb-4" style="background-color: #FEE2E2; color: #991B1B;">
        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Gagal Menyimpan Transaksi:</div>
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
                <i class="bi bi-bag-check"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: #857B6E; font-weight: 500;">Sedang Disewa</div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h4 fw-bold mb-0">{{ $aktifCount }}</span>
                    <span style="font-size: 0.85rem; color: #857B6E;">Transaksi</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mc-card p-3 px-4 d-flex align-items-center gap-3">
            <div class="mc-kpi-icon">
                <i class="bi bi-arrow-return-left"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: #857B6E; font-weight: 500;">Sudah Dikembalikan</div>
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
                <i class="bi bi-wallet2"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: #857B6E; font-weight: 500;">Total Nilai Sewa</div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h4 fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="mc-card overflow-hidden">
    <div class="p-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <h2 class="h6 fw-bold mb-0">Daftar Transaksi Penyewaan</h2>

        <div class="position-relative" style="min-width: 290px;">
            <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3" style="color: #857B6E;"></i>
            <input type="text" id="searchTransaksi" class="form-control mc-input ps-5" placeholder="Cari kode transaksi atau nama penyewa...">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table mc-table mb-0" id="tableTransaksi">
            <thead>
                <tr>
                    <th style="width: 60px;">NO</th>
                    <th>KODE SEWA</th>
                    <th>NAMA PENYEWA</th>
                    <th>TGL SEWA & RENCANA KEMBALI</th>
                    <th>TOTAL BIAYA</th>
                    <th>STATUS</th>
                    <th class="text-end">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataPenyewaan as $index => $item)
                    @php
                        $idTrx       = $item->id_penyewaan ?? $item->id;
                        $kode        = $item->kode_transaksi ?? ('TRX-' . str_pad($idTrx, 4, '0', STR_PAD_LEFT));
                        $namaPenyewa = $item->penyewa->nama_lengkap ?? $item->penyewa->nama_penyewa ?? 'Pelanggan #' . ($item->penyewa_id ?? '-');
                        $tglSewa     = $item->tanggal_sewa ?? '-';
                        $tglKembali  = $item->tanggal_rencana_kembali ?? $item->tanggal_kembali_rencana ?? $item->tanggal_kembali ?? '-';
                        $total       = $item->total_biaya ?? $item->total_harga ?? 0;
                        $status      = strtolower($item->status ?? $item->status_penyewaan ?? 'disewa');
                    @endphp
                    <tr>
                        <td class="fw-medium text-muted">{{ $index + 1 }}</td>
                        <td class="fw-bold" style="color: #3D2C1E;">{{ $kode }}</td>
                        <td>
                            <div class="fw-semibold">{{ $namaPenyewa }}</div>
                            <small class="text-muted">{{ $item->penyewa->telepon ?? $item->penyewa->no_telepon ?? '' }}</small>
                        </td>
                        <td>
                            <div>{{ $tglSewa !== '-' ? \Carbon\Carbon::parse($tglSewa)->format('d M Y') : '-' }}</div>
                            <small class="text-muted">s/d {{ $tglKembali !== '-' ? \Carbon\Carbon::parse($tglKembali)->format('d M Y') : '-' }}</small>
                        </td>
                        <td class="fw-semibold">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td>
                            @if(in_array($status, ['selesai', 'dikembalikan']))
                                <span class="badge-mc-selesai">Selesai</span>
                            @elseif($status === 'terlambat')
                                <span class="badge-mc-terlambat">Terlambat</span>
                            @else
                                <span class="badge-mc-disewa">Sedang Disewa</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if(!in_array($status, ['selesai', 'dikembalikan']))
                                <a href="{{ url('/pengembalian?penyewaan_id=' . $idTrx) }}" class="btn btn-sm btn-mc-outline">
                                    <i class="bi bi-arrow-return-left me-1"></i>Kembalikan
                                </a>
                            @else
                                <span class="text-muted small">Tuntas</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5" style="color: #857B6E;">
                            Belum ada data transaksi penyewaan. Klik <strong>+ Transaksi Sewa Baru</strong> untuk memulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Transaksi Sewa -->
<div class="modal fade" id="modalTambahSewa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid #EAE4DC;">
            <div class="modal-header border-bottom" style="border-color: #EAE4DC !important;">
                <h5 class="modal-title fw-bold">Buat Transaksi Penyewaan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/penyewaan') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Pilih Pelanggan Penyewa</label>
                            <select name="penyewa_id" class="form-select mc-input" required>
                                <option value="">-- Pilih Penyewa --</option>
                                @foreach($dataPenyewa as $p)
                                    @php $idP = $p->id_penyewa ?? $p->id; @endphp
                                    <option value="{{ $idP }}" {{ old('penyewa_id') == $idP ? 'selected' : '' }}>
                                        {{ $p->nama_lengkap ?? $p->nama_penyewa }} ({{ $p->nik_ktm ?? $p->nik ?? 'NIK' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Tanggal Sewa</label>
                            <input type="date" name="tanggal_sewa" id="tglSewa" class="form-control mc-input" value="{{ old('tanggal_sewa', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Rencana Kembali</label>
                            <input type="date" name="tanggal_kembali_rencana" id="tglKembali" class="form-control mc-input" value="{{ old('tanggal_kembali_rencana', date('Y-m-d', strtotime('+2 days'))) }}" required>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Pilih Perlengkapan Camping</label>
                            <select name="peralatan_id" id="selectAlat" class="form-select mc-input" required>
                                <option value="" data-harga="0">-- Pilih Alat --</option>
                                @foreach($dataPeralatan as $alat)
                                    @php
                                        $idA   = $alat->id_peralatan ?? $alat->id;
                                        $harga = $alat->harga_sewa_per_hari ?? $alat->harga_sewa ?? 0;
                                    @endphp
                                    <option value="{{ $idA }}" data-harga="{{ $harga }}" {{ old('peralatan_id') == $idA ? 'selected' : '' }}>
                                        {{ $alat->nama_alat }} – Rp {{ number_format($harga, 0, ',', '.') }}/hari (Stok: {{ $alat->stok_tersedia ?? $alat->stok ?? 0 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Jumlah Unit</label>
                            <input type="number" name="jumlah" id="jumlahUnit" class="form-control mc-input" value="{{ old('jumlah', 1) }}" min="1" required>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3 d-flex justify-content-between align-items-center" style="background-color: #F8F5F0; border: 1px solid #EAE4DC;">
                                <div>
                                    <div class="small text-muted">Estimasi Total Biaya Sewa (<span id="labelDurasi">2</span> Hari)</div>
                                    <div class="h5 fw-bold mb-0" style="color: #3D2C1E;" id="labelTotalBiaya">Rp 0</div>
                                </div>
                                <input type="hidden" name="total_biaya" id="inputTotalBiaya" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top" style="border-color: #EAE4DC !important;">
                    <button type="button" class="btn-mc-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-mc-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchTransaksi');
        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                const keyword = this.value.toLowerCase();
                document.querySelectorAll('#tableTransaksi tbody tr').forEach(function (row) {
                    row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
                });
            });
        }

        function hitungTotalSewa() {
            const selectAlat = document.getElementById('selectAlat');
            const selectedOption = selectAlat.options[selectAlat.selectedIndex];
            const harga = parseFloat(selectedOption?.dataset?.harga) || 0;
            const qty   = parseInt(document.getElementById('jumlahUnit').value) || 1;
            const start = new Date(document.getElementById('tglSewa').value);
            const end   = new Date(document.getElementById('tglKembali').value);
            let hari    = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            if (isNaN(hari) || hari < 1) hari = 1;

            const total = harga * qty * hari;
            document.getElementById('labelDurasi').textContent = hari;
            document.getElementById('labelTotalBiaya').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('inputTotalBiaya').value = total;
        }

        ['selectAlat', 'jumlahUnit', 'tglSewa', 'tglKembali'].forEach(function (id) {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('change', hitungTotalSewa);
                el.addEventListener('keyup', hitungTotalSewa);
            }
        });

        const modalEl = document.getElementById('modalTambahSewa');
        if (modalEl) {
            modalEl.addEventListener('shown.bs.modal', hitungTotalSewa);
        }
    });
</script>
@endpush