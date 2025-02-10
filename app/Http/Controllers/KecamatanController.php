<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use App\Exports\GeneralExport;
use Maatwebsite\Excel\Facades\Excel;


class KecamatanController extends Controller
{

    public function index(Request $request)
    {
        $query = Kecamatan::query();
        if ($request->has('search') && !empty($request->search)) {

            $query->where('nama_kecamatan', 'like', '%' . $request->search . '%');
        }
        $kecamatan = $query->get();

        return view('kecamatan.index', compact('kecamatan'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kecamatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'geojson' => 'nullable|json',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Kecamatan::create($request->all());

        return redirect()->route('kecamatan.index')
            ->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kecamatan $kecamatan)
    {
        return view('kecamatan.show', compact('kecamatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kecamatan $kecamatan)
    {
        return view('kecamatan.edit', compact('kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'geojson' => 'nullable|json',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $kecamatan->update($request->all());

        return redirect()->route('kecamatan.index')
            ->with('success', 'Kecamatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect()->route('kecamatan.index')
            ->with('success', 'Kecamatan berhasil dihapus.');
    }

    public function export()
{
    $data = Kecamatan::select('nama_kecamatan', 'latitude', 'longitude')->get();
    
    $headings = ['Nama Kecamatan', 'Latitude', 'Longitude'];

    return Excel::download(new GeneralExport($data, $headings), 'master_kecamatan.xlsx');
}
}