<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tahun;

class TahunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tahun = Tahun::query()
            ->when($search, function ($query, $search) {
                return $query->where('tahun', 'like', "%$search%");
            })
            ->orderBy('tahun', 'asc')
            ->get();

        return view('tahun.index', compact('tahun'));
    }
    public function create()
    {
        return view('tahun.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|unique:tahun,tahun',
        ]);

        Tahun::create($validated);

        return redirect()->route('tahun.index')->with('success', 'Data tahun berhasil ditambahkan.');
    }
    public function edit($id_tahun)
    {
        $tahun = Tahun::findOrFail($id_tahun);

        return view('tahun.edit', compact('tahun'));
    }

    public function update(Request $request, $id_tahun)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|unique:tahun,tahun,' . $id_tahun . ',id_tahun',
        ]);

        $tahun = Tahun::findOrFail($id_tahun);
        $tahun->update($validated);

        return redirect()->route('tahun.index')->with('success', 'Data tahun berhasil diperbarui.');
    }

    public function destroy($id_tahun)
    {
        $tahun = Tahun::findOrFail($id_tahun);
        $tahun->delete();

        return redirect()->route('tahun.index')->with('success', 'Data tahun berhasil dihapus.');
    }
}
