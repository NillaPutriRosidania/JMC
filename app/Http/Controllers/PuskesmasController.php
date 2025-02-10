<?php

namespace App\Http\Controllers;

use App\Models\Puskesmas;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use App\Exports\GeneralExport;
use Maatwebsite\Excel\Facades\Excel;


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

    public function export()
    {
        $data = Puskesmas::with('kecamatan')->get()->map(function ($puskesmas) {
            return [
                'nama_puskesmas' => $puskesmas->nama_puskesmas,
                'alamat_puskesmas' => $puskesmas->alamat_puskesmas,
                'nama_kecamatan' => $puskesmas->kecamatan->nama_kecamatan,
                'lat' => $puskesmas->lat,
                'long' => $puskesmas->long,
            ];
        });
        $headings = [
            'Nama Puskesmas',
            'Alamat Puskesmas',
            'Nama Kecamatan',
            'Latitude',
            'Longitude',
        ];

        return Excel::download(new GeneralExport($data, $headings), 'puskesmas.xlsx');
    }
}