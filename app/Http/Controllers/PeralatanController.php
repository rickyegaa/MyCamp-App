<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Peralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PeralatanController extends Controller
{
    public function index(Request $request)
    {
        $peralatan = Peralatan::with('kategori')
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama_alat', 'like', '%'.$request->q.'%')
                      ->orWhere('kode_alat', 'like', '%'.$request->q.'%');
                });
            })
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->kategori))
            ->when($request->filled('kondisi'), fn ($q) => $q->where('status_kondisi', $request->kondisi))
            ->orderBy('nama_alat')
            ->paginate(10)
            ->withQueryString();

        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('peralatan.index', compact('peralatan', 'kategori'));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('peralatan.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        // Alat baru: semua unit tersedia.
        $data['stok_tersedia'] = $data['stok_total'];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('peralatan', 'public');
        }

        Peralatan::create($data);

        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil ditambahkan.');
    }

    public function edit(Peralatan $peralatan)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('peralatan.edit', compact('peralatan', 'kategori'));
    }

    public function update(Request $request, Peralatan $peralatan)
    {
        $data = $this->validated($request, $peralatan);

        // Unit yang sedang disewa tidak boleh hilang dari hitungan stok.
        $disewa = $peralatan->stok_disewa;

        if ($data['stok_total'] < $disewa) {
            return back()->withInput()->withErrors([
                'stok_total' => "Stok total tidak boleh kurang dari jumlah yang sedang disewa ($disewa unit).",
            ]);
        }

        $data['stok_tersedia'] = $data['stok_total'] - $disewa;

        if ($request->hasFile('foto')) {
            if ($peralatan->foto) {
                Storage::disk('public')->delete($peralatan->foto);
            }
            $data['foto'] = $request->file('foto')->store('peralatan', 'public');
        }

        $peralatan->update($data);

        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil diperbarui.');
    }

    public function destroy(Peralatan $peralatan)
    {
        // Relasi detail_penyewaan memakai cascade; jangan hapus riwayat transaksi.
        $dipakai = DB::table('detail_penyewaan')->where('peralatan_id', $peralatan->id_peralatan)->exists();

        if ($dipakai) {
            return back()->with('error', 'Peralatan tidak bisa dihapus karena sudah tercatat di transaksi penyewaan.');
        }

        if ($peralatan->foto) {
            Storage::disk('public')->delete($peralatan->foto);
        }

        $peralatan->delete();

        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil dihapus.');
    }

    private function validated(Request $request, ?Peralatan $peralatan = null): array
    {
        return $request->validate([
            'kategori_id' => ['required', 'exists:kategori,id_kategori'],
            'kode_alat' => [
                'required', 'string', 'max:20',
                Rule::unique('peralatan', 'kode_alat')->ignore($peralatan?->id_peralatan, 'id_peralatan'),
            ],
            'nama_alat' => ['required', 'string', 'max:100'],
            'harga_sewa_per_hari' => ['required', 'numeric', 'min:0'],
            'stok_total' => ['required', 'integer', 'min:0'],
            'status_kondisi' => ['required', Rule::in(['baik', 'perlu_perbaikan'])],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}
