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
        // Filter data berdasarkan pencarian
        $search = $request->input('search');
        $tahun = Tahun::query()
            ->when($search, function ($query, $search) {
                return $query->where('tahun', 'like', "%$search%");
            })
            ->orderBy('tahun', 'asc')
            ->get();

        return view('tahun.index', compact('tahun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tahun.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|unique:tahun,tahun',
        ]);

        Tahun::create($validated);

        return redirect()->route('tahun.index')->with('success', 'Data tahun berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_tahun)
    {
        $tahun = Tahun::findOrFail($id_tahun);

        return view('tahun.edit', compact('tahun'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_tahun)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|unique:tahun,tahun,' . $id_tahun . ',id_tahun',
        ]);

        $tahun = Tahun::findOrFail($id_tahun);
        $tahun->update($validated);

        return redirect()->route('tahun.index')->with('success', 'Data tahun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_tahun)
    {
        $tahun = Tahun::findOrFail($id_tahun);
        $tahun->delete();

        return redirect()->route('tahun.index')->with('success', 'Data tahun berhasil dihapus.');
    }
}