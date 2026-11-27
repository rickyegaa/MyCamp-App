<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('peralatan')->orderBy('nama_kategori')->paginate(10);

        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        Kategori::create($this->validated($request));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $kategori->update($this->validated($request));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        // Relasi di database memakai cascade, jadi cegah penghapusan jika masih punya alat.
        if ($kategori->peralatan()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki peralatan.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama_kategori' => ['required', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
        ]);
    }
}
