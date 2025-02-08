<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::all();
        return view('berita.index', compact('berita'));
    }
    public function create()
    {
        return view('berita.create');
    }
    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('berita.show', compact('berita'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'kategori' => 'required|string|max:100',
            'kata_kunci' => 'nullable|string',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('images', 'public'); // 'public' adalah disk storage di Laravel
        }
        Berita::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
            'kategori' => $request->kategori,
            'kata_kunci' => $request->kata_kunci,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan');
    }
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('berita.edit', compact('berita'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validasi gambar
            'kategori' => 'required|string|max:100',
            'kata_kunci' => 'nullable|string',
        ]);

        $berita = Berita::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar && file_exists(storage_path('app/public/' . $berita->gambar))) {
                unlink(storage_path('app/public/' . $berita->gambar));
            }

            $gambarPath = $request->file('gambar')->store('images', 'public'); // Menyimpan di folder storage 'public/images'
        } else {
            $gambarPath = $berita->gambar;
        }
        $berita->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
            'kategori' => $request->kategori,
            'kata_kunci' => $request->kata_kunci,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus');
    }
}