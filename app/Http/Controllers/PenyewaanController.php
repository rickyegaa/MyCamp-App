<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\DetailPenyewaan;
use App\Models\Peralatan;
use App\Models\Penyewa;
use App\Models\Penyewaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PenyewaanController extends Controller
{
    public function index()
    {
        $penyewaanList = Penyewaan::with(['penyewa', 'details.peralatan'])
            ->orderByDesc('id_penyewaan')
            ->get();

        $penyewaList = Penyewa::orderBy('nama_lengkap')->get();
        $peralatanList = Peralatan::where('stok_tersedia', '>', 0)
            ->orderBy('nama_alat')
            ->get();

        return view('penyewaan.index', compact('penyewaanList', 'penyewaList', 'peralatanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penyewa_id'              => 'required|exists:penyewa,id_penyewa',
            'peralatan_id'            => 'required|exists:peralatan,id_peralatan',
            'tanggal_sewa'            => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_sewa',
            'jumlah'                  => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $alat = Peralatan::lockForUpdate()->findOrFail($request->peralatan_id);

                if ($alat->stok_tersedia < $request->jumlah) {
                    throw new \Exception("Stok {$alat->nama_alat} tidak mencukupi (tersisa {$alat->stok_tersedia} unit).");
                }

                $tglSewa    = Carbon::parse($request->tanggal_sewa);
                $tglKembali = Carbon::parse($request->tanggal_kembali_rencana);
                $durasiHari = max(1, $tglSewa->diffInDays($tglKembali));

                $hargaSatuan = $alat->harga_sewa_per_hari ?? 0;
                $totalBiaya  = $hargaSatuan * $request->jumlah * $durasiHari;

                $akunId  = Auth::id() ?? Akun::value('id_akun') ?? 1;
                $kodeTrx = 'TRX-' . date('Ymd') . '-' . str_pad(Penyewaan::count() + 1, 3, '0', STR_PAD_LEFT);

                $kolomPenyewaan = Schema::getColumnListing('penyewaan');
                $dataHeader = array_intersect_key([
                    'kode_transaksi'          => $kodeTrx,
                    'penyewa_id'              => $request->penyewa_id,
                    'akun_id'                 => $akunId,
                    'tanggal_sewa'            => $request->tanggal_sewa,
                    'tanggal_rencana_kembali' => $request->tanggal_kembali_rencana,
                    'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                    'tanggal_kembali'         => $request->tanggal_kembali_rencana,
                    'durasi_hari'             => $durasiHari,
                    'durasi'                  => $durasiHari,
                    'jumlah_hari'             => $durasiHari,
                    'lama_sewa'               => $durasiHari,
                    'total_biaya'             => $totalBiaya,
                    'total_harga'             => $totalBiaya,
                    'total_bayar'             => $totalBiaya,
                    'status'                  => 'disewa',
                    'status_penyewaan'        => 'disewa',
                    'jaminan'                 => 'KTP/KTM',
                    'catatan'                 => '-',
                    'keterangan'              => '-',
                ], array_flip($kolomPenyewaan));

                $penyewaan = Penyewaan::create($dataHeader);

                $kolomDetail = Schema::getColumnListing('detail_penyewaan');
                $dataDetail = array_intersect_key([
                    'penyewaan_id'        => $penyewaan->id_penyewaan,
                    'peralatan_id'        => $alat->id_peralatan,
                    'jumlah'              => $request->jumlah,
                    'jumlah_sewa'         => $request->jumlah,
                    'qty'                 => $request->jumlah,
                    'harga_satuan'        => $hargaSatuan,
                    'harga_sewa'          => $hargaSatuan,
                    'harga_sewa_per_hari' => $hargaSatuan,
                    'durasi_hari'         => $durasiHari,
                    'subtotal'            => $totalBiaya,
                    'sub_total'           => $totalBiaya,
                    'total_harga'         => $totalBiaya,
                ], array_flip($kolomDetail));

                DetailPenyewaan::create($dataDetail);

                $alat->decrement('stok_tersedia', $request->jumlah);
            });

            return redirect()->route('penyewaan.index')
                ->with('success', 'Transaksi penyewaan berhasil disimpan dan stok alat diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}