<?php

namespace App\Http\Controllers;

use App\Models\Puskesmas;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class PuskesmasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $puskesmas = Puskesmas::with('kecamatan')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_puskesmas', 'like', "%$search%")
                    ->orWhereHas('kecamatan', function ($query) use ($search) {
                        $query->where('nama_kecamatan', 'like', "%$search%");
                    });
            })
            ->paginate(10);

        return view('puskesmas.index', compact('puskesmas'));
    }

    public function create()
    {
        $kecamatan = Kecamatan::all();
        return view('puskesmas.create', compact('kecamatan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_puskesmas' => 'required|string|max:255',
            'id_kecamatan' => 'required|exists:tb_kecamatan,id_kecamatan',
            'alamat_puskesmas' => 'nullable|string',
            'lat' => 'required|regex:/^-?[\d\.]+$/',
            'long' => 'required|regex:/^-?[\d\.]+$/',
        ]);


        Puskesmas::create($validated);

        return redirect()->route('puskesmas.index')
            ->with('success', 'Puskesmas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $puskesmas = Puskesmas::findOrFail($id);
        $kecamatan = Kecamatan::all();
        return view('puskesmas.edit', compact('puskesmas', 'kecamatan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_puskesmas' => 'required|string|max:255',
            'id_kecamatan' => 'required|exists:tb_kecamatan,id_kecamatan',
            'alamat_puskesmas' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'long' => 'nullable|numeric',
        ]);

        $puskesmas = Puskesmas::findOrFail($id);
        $puskesmas->update($validated);

        return redirect()->route('puskesmas.index')
            ->with('success', 'Puskesmas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $puskesmas = Puskesmas::findOrFail($id);
        $puskesmas->delete();

        return redirect()->route('puskesmas.index')
            ->with('success', 'Puskesmas berhasil dihapus.');
    }
}