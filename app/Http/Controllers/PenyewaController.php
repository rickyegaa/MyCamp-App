<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function index()
    {
        $penyewas = Penyewa::orderBy('id_penyewa', 'desc')->get();
        return view('penyewa.index', compact('penyewas'));
    }

    public function create()
    {
        return view('penyewa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik_ktm' => 'required|string|max:20|unique:penyewa,nik_ktm',
            'nama_lengkap' => 'required|string|max:64',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ], [
            'nik_ktm.unique' => 'NIK / KTM sudah terdaftar di sistem.',
        ]);

        Penyewa::create($validated);

        return redirect()->route('penyewa.index')
            ->with('success', 'Data penyewa berhasil ditambahkan.');
    }

    public function edit(Penyewa $penyewa)
    {
        return view('penyewa.edit', compact('penyewa'));
    }

    public function update(Request $request, Penyewa $penyewa)
    {
        $validated = $request->validate([
            'nik_ktm' => 'required|string|max:20|unique:penyewa,nik_ktm,' . $penyewa->id_penyewa . ',id_penyewa',
            'nama_lengkap' => 'required|string|max:64',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $penyewa->update($validated);

        return redirect()->route('penyewa.index')
            ->with('success', 'Data penyewa berhasil diperbarui.');
    }

    public function destroy(Penyewa $penyewa)
    {
        $penyewa->delete();

        return redirect()->route('penyewa.index')
            ->with('success', 'Data penyewa berhasil dihapus.');
    }
}