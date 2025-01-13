<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puskesmas;
use Illuminate\Support\Facades\DB;
use App\Models\AKB;
use App\Models\Tahun;
use Illuminate\Support\Facades\Log;

class AKBController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request->input('filter_kecamatan');
        $search = $request->input('search');
        $filter_tahun = $request->input('filter_tahun', date('Y'));
        $tahunOptions = Tahun::pluck('tahun', 'id_tahun')->toArray();
        $AKB = AKB::with('puskesmas.kecamatan')
            ->when($filter_tahun, function ($query, $filter_tahun) {
                $query->where('id_tahun', $filter_tahun);
            })
            ->when($filter === 'Puskesmas', function ($query) use ($search) {
                $query->when($search, function ($query, $search) {
                    $query->whereHas('puskesmas', function ($query) use ($search) {
                        $query->where('nama_puskesmas', 'like', "%$search%");
                    });
                })
                    ->select('data_akb.*')
                    ->join('puskesmas', 'data_akb.id_puskesmas', '=', 'puskesmas.id_puskesmas');
            })
            ->when($filter === 'Kecamatan', function ($query) use ($search) {
                $query->join('puskesmas', 'data_akb.id_puskesmas', '=', 'puskesmas.id_puskesmas')
                    ->join('tb_kecamatan', 'puskesmas.id_kecamatan', '=', 'tb_kecamatan.id_kecamatan')
                    ->when($search, function ($query, $search) {
                        $query->where('tb_kecamatan.nama_kecamatan', 'like', "%$search%");
                    })
                    ->groupBy('tb_kecamatan.id_kecamatan', 'tb_kecamatan.nama_kecamatan', 'data_akb.id_tahun')
                    ->select(
                        'tb_kecamatan.id_kecamatan',
                        'tb_kecamatan.nama_kecamatan',
                        'data_akb.id_tahun',
                        DB::raw('SUM(data_akb.akb) as total_akb')
                    );
            })

            ->get();
        return view('AKB.index', compact('AKB', 'tahunOptions'));
    }

    public function create(Request $request)
    {
        $tahunAkb = Tahun::whereDoesntHave('akb')->get();
        $puskesmas = Puskesmas::all();

        return view('akb.create', compact('tahunAkb', 'puskesmas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_tahun' => 'required|exists:tahun,id_tahun',
            'id_puskesmas.*' => 'required|exists:puskesmas,id_puskesmas',
            'id_kecamatan.*' => 'required|exists:tb_kecamatan,id_kecamatan',
            'akb.*' => 'required|numeric|min:0',
        ]);

        try {
            $akbData = [];

            foreach ($request->id_puskesmas as $index => $puskesmasId) {
                $puskesmas = Puskesmas::find($puskesmasId);
                if (!$puskesmas) {
                    continue;
                }

                $akbValue = $request->akb[$puskesmasId] ?? null;
                if ($akbValue === null) {
                    Log::error('Nilai AKB tidak ditemukan atau tidak valid', [
                        'id_puskesmas' => $puskesmas->id_puskesmas,
                        'id_kecamatan' => $request->id_kecamatan[$index],
                        'id_tahun' => $request->id_tahun,
                    ]);
                    continue;
                }

                AKB::create([
                    'id_puskesmas' => $puskesmas->id_puskesmas,
                    'id_kecamatan' => $request->id_kecamatan[$index],
                    'id_tahun' => $request->id_tahun,
                    'akb' => $akbValue,
                ]);

                $idKecamatan = $request->id_kecamatan[$index];
                if (!isset($akbData[$idKecamatan])) {
                    $akbData[$idKecamatan] = 0;
                }
                $akbData[$idKecamatan] += $akbValue;
            }

            foreach ($akbData as $idKecamatan => $grandTotalAkb) {
                DB::table('kmeans_akb')->updateOrInsert(
                    ['id_kecamatan' => $idKecamatan],
                    [
                        'grand_total_akb' => $grandTotalAkb,
                        'id_cluster' => null,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            return redirect()->route('akb.index')->with('success', 'Data AKB berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan saat menyimpan data AKB: " . $e->getMessage());
            return redirect()->route('akb.create')->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }


    public function edit($id_data_akb)
    {
        $AKB = AKB::findOrFail($id_data_akb);

        return view('akb.edit', compact('AKB'));
    }
    public function update(Request $request, $id_data_akb)
    {
        $request->validate([
            'akb' => 'required|numeric|min:0',
        ]);

        try {
            $AKB = AKB::findOrFail($id_data_akb);

            $AKB->update([
                'akb' => $request->akb,
            ]);

            Log::info('Data AKB berhasil diperbarui:', [
                'id_data_akb' => $id_data_akb,
                'akb' => $request->akb,
            ]);

            return redirect()->route('akb.index')->with('success', 'Data AKB berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat memperbarui data AKB:', ['message' => $e->getMessage()]);

            return redirect()->route('akb.edit', $id_data_akb)->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }
}
