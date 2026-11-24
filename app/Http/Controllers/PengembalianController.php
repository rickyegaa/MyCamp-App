<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Pengembalian;
use App\Models\Peralatan;
use App\Models\Penyewaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalianList = Pengembalian::with('penyewaan.penyewa')
            ->orderByDesc('id_pengembalian')
            ->get();

        $colStatus = Schema::hasColumn('penyewaan', 'status_penyewaan') ? 'status_penyewaan' : 'status';

        $penyewaanAktif = Penyewaan::with('penyewa')
            ->whereIn($colStatus, ['disewa', 'terlambat'])
            ->orderByDesc('id_penyewaan')
            ->get();

        return view('pengembalian.index', compact('pengembalianList', 'penyewaanAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penyewaan_id'           => 'required|exists:penyewaan,id_penyewaan',
            'tanggal_kembali_aktual' => 'required|date',
            'denda_kerusakan'        => 'nullable|numeric|min:0',
            'kondisi_alat'           => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $penyewaan = Penyewaan::with('details')->lockForUpdate()->findOrFail($request->penyewaan_id);

                $statusSaatIni = strtolower($penyewaan->status_penyewaan ?? $penyewaan->status ?? 'disewa');
                if ($statusSaatIni === 'selesai') {
                    throw new \Exception('Transaksi ini sudah pernah dikembalikan sebelumnya.');
                }

                $tglRencanaRaw = $penyewaan->tanggal_rencana_kembali
                    ?? $penyewaan->tanggal_kembali_rencana
                    ?? $penyewaan->tanggal_kembali;

                $tglRencana = Carbon::parse($tglRencanaRaw)->startOfDay();
                $tglAktual  = Carbon::parse($request->tanggal_kembali_aktual)->startOfDay();

                $hariTelat = $tglAktual->greaterThan($tglRencana)
                    ? $tglRencana->diffInDays($tglAktual)
                    : 0;

                $dendaTelat = $hariTelat * 25000;
                $dendaRusak = (float) ($request->denda_kerusakan ?? 0);
                $totalDenda = $dendaTelat + $dendaRusak;
                $akunId     = Auth::id() ?? Akun::value('id_akun') ?? 1;

                $kolomKembali = Schema::getColumnListing('pengembalian');
                $dataKembali = array_intersect_key([
                    'penyewaan_id'           => $penyewaan->id_penyewaan,
                    'akun_id'                => $akunId,
                    'tanggal_aktual_kembali' => $request->tanggal_kembali_aktual,
                    'tanggal_kembali_aktual' => $request->tanggal_kembali_aktual,
                    'tanggal_pengembalian'   => $request->tanggal_kembali_aktual,
                    'tanggal_kembali'        => $request->tanggal_kembali_aktual,
                    'hari_terlambat'         => $hariTelat,
                    'keterlambatan_hari'     => $hariTelat,
                    'terlambat_hari'         => $hariTelat,
                    'durasi_terlambat'       => $hariTelat,
                    'denda_terlambat'        => $dendaTelat,
                    'denda_keterlambatan'    => $dendaTelat,
                    'denda_telat'            => $dendaTelat,
                    'denda_kerusakan'        => $dendaRusak,
                    'total_denda'            => $totalDenda,
                    'denda'                  => $totalDenda,
                    'keterangan'             => $request->kondisi_alat ?? 'Baik & Lengkap',
                    'kondisi_alat'           => $request->kondisi_alat ?? 'Baik & Lengkap',
                    'kondisi_kembali'        => $request->kondisi_alat ?? 'Baik & Lengkap',
                    'kondisi'                => 'Baik',
                    'catatan'                => $request->kondisi_alat ?? 'Baik & Lengkap',
                    'status_pembayaran'      => 'lunas',
                    'status_denda'           => 'lunas',
                    'status'                 => 'selesai',
                ], array_flip($kolomKembali));

                Pengembalian::create($dataKembali);

                $kolomPenyewaan = Schema::getColumnListing('penyewaan');
                $dataUpdateSewa = array_intersect_key([
                    'status'           => 'selesai',
                    'status_penyewaan' => 'selesai',
                ], array_flip($kolomPenyewaan));

                $penyewaan->update($dataUpdateSewa);

                foreach ($penyewaan->details as $detail) {
                    $qty = $detail->jumlah ?? $detail->jumlah_sewa ?? $detail->qty ?? 1;
                    Peralatan::where('id_peralatan', $detail->peralatan_id)
                        ->increment('stok_tersedia', $qty);
                }
            });

            return redirect()->route('pengembalian.index')
                ->with('success', 'Pengembalian berhasil diproses dan stok alat telah dikembalikan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }
}