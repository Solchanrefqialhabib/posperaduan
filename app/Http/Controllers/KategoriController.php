<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:255',
            'nama_kategori' => 'required|string|max:255',
        ]);

        try {
            Kategori::create([
                'kode_kategori' => $request->kode_kategori,
                'nama_kategori' => $request->nama_kategori,
            ]);
            return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:255',
            'nama_kategori' => 'required|string|max:255',
        ]);

        try {
            $category = Kategori::findOrFail($id);
            $category->update([
                'kode_kategori' => $request->kode_kategori,
                'nama_kategori' => $request->nama_kategori,
            ]);
            return redirect()->back()->with('success', 'Kategori berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate kategori: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $category = Kategori::findOrFail($id);
            $category->delete();
            return redirect()->back()->with('success', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}
