<?php

namespace App\Http\Controllers;

use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AKI;
use App\Models\Tahun;
use Illuminate\Support\Facades\Log;
use App\Exports\GeneralExport;
use Maatwebsite\Excel\Facades\Excel;

class AKIController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter_kecamatan');
        $search = $request->input('search');
        $filter_tahun = $request->input('filter_tahun', date('Y'));
        $tahunOptions = Tahun::pluck('tahun', 'id_tahun')->toArray();
        $AKI = AKI::with('puskesmas.kecamatan')
            ->when($filter_tahun, function ($query, $filter_tahun) {
                $query->where('id_tahun', $filter_tahun);
            })
            ->when($filter === 'Puskesmas', function ($query) use ($search) {
                $query->when($search, function ($query, $search) {
                    $query->whereHas('puskesmas', function ($query) use ($search) {
                        $query->where('nama_puskesmas', 'like', "%$search%");
                    });
                })
                    ->select('data_aki.*')
                    ->join('puskesmas', 'data_aki.id_puskesmas', '=', 'puskesmas.id_puskesmas');
            })
            ->when($filter === 'Kecamatan', function ($query) use ($search) {
                $query->join('puskesmas', 'data_aki.id_puskesmas', '=', 'puskesmas.id_puskesmas')
                    ->join('tb_kecamatan', 'puskesmas.id_kecamatan', '=', 'tb_kecamatan.id_kecamatan')
                    ->when($search, function ($query, $search) {
                        $query->where('tb_kecamatan.nama_kecamatan', 'like', "%$search%");
                    })
                    ->groupBy('tb_kecamatan.id_kecamatan', 'tb_kecamatan.nama_kecamatan', 'data_aki.id_tahun')
                    ->select(
                        'tb_kecamatan.id_kecamatan',
                        'tb_kecamatan.nama_kecamatan',
                        'data_aki.id_tahun',
                        DB::raw('SUM(data_aki.aki) as total_aki')
                    );
            })

            ->get();
        return view('AKI.index', compact('AKI', 'tahunOptions'));
    }

    public function create(Request $request)
    {
        $tahunAki = Tahun::whereDoesntHave('aki')->get();
        $puskesmas = Puskesmas::all();

        return view('aki.create', compact('tahunAki', 'puskesmas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tahun' => 'required|exists:tahun,id_tahun',
            'id_puskesmas.*' => 'required|exists:puskesmas,id_puskesmas',
            'id_kecamatan.*' => 'required|exists:tb_kecamatan,id_kecamatan',
            'aki.*' => 'required|numeric|min:0',
        ]);

        try {
            foreach ($request->id_puskesmas as $index => $puskesmasId) {
                $puskesmas = Puskesmas::find($puskesmasId);
                if (!$puskesmas) {
                    continue;
                }

                $akiValue = $request->aki[$puskesmasId] ?? null;
                if ($akiValue === null) {
                    Log::error('Nilai AKI tidak ditemukan atau tidak valid', [
                        'id_puskesmas' => $puskesmas->id_puskesmas,
                        'id_kecamatan' => $request->id_kecamatan[$index],
                        'id_tahun' => $request->id_tahun,
                    ]);
                    continue;
                }

                AKI::create([
                    'id_puskesmas' => $puskesmas->id_puskesmas,
                    'id_kecamatan' => $request->id_kecamatan[$index],
                    'id_tahun' => $request->id_tahun,
                    'aki' => $akiValue,
                ]);

                $idKecamatan = $request->id_kecamatan[$index];
                $grandTotalAki = AKI::where('id_kecamatan', $idKecamatan)->sum('aki');

                DB::table('kmeans_aki')->updateOrInsert(
                    ['id_kecamatan' => $idKecamatan],
                    [
                        'grand_total_aki' => $grandTotalAki,
                        'id_cluster' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            return redirect()->route('aki.index')->with('success', 'Data AKI berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan saat menyimpan data AKI: " . $e->getMessage());
            return redirect()->route('aki.create')->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit($id_data_aki)
    {
        $AKI = AKI::findOrFail($id_data_aki);

        return view('aki.edit', compact('AKI'));
    }
    public function update(Request $request, $id_data_aki)
    {
        $request->validate([
            'aki' => 'required|numeric|min:0',
        ]);

        try {
            $AKI = AKI::findOrFail($id_data_aki);

            $AKI->update([
                'aki' => $request->aki,
            ]);

            Log::info('Data AKI berhasil diperbarui:', [
                'id_data_aki' => $id_data_aki,
                'aki' => $request->aki,
            ]);

            return redirect()->route('aki.index')->with('success', 'Data AKI berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat memperbarui data AKI:', ['message' => $e->getMessage()]);

            return redirect()->route('aki.edit', $id_data_aki)->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }
    public function export()
    {
        $sheets = [];
        $tahunData = Tahun::all();

        foreach ($tahunData as $tahun) {
            $akiData = AKI::where('id_tahun', $tahun->id_tahun)
                ->with('puskesmas.kecamatan')
                ->get()
                ->map(function ($aki) {
                    return [
                        'Puskesmas' => $aki->puskesmas->nama_puskesmas,
                        'Kecamatan' => $aki->puskesmas->kecamatan->nama_kecamatan,
                        'Jumlah AKI' => $aki->aki,
                    ];
                });
            $sheets[] = new class($akiData, ['Puskesmas', 'Kecamatan', 'Jumlah AKI'], $tahun->tahun) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle {
                protected $data;
                protected $headings;
                protected $tahun;

                public function __construct($data, $headings, $tahun)
                {
                    $this->data = $data;
                    $this->headings = $headings;
                    $this->tahun = $tahun;
                }

                public function collection()
                {
                    return collect($this->data);
                }

                public function headings(): array
                {
                    return $this->headings;
                }

                public function title(): string
                {
                    return $this->tahun;
                }
            };
        }
        return Excel::download(new class($sheets) implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
            protected $sheets;

            public function __construct($sheets)
            {
                $this->sheets = $sheets;
            }

            public function sheets(): array
            {
                return $this->sheets;
            }
        }, 'aki_data.xlsx');
    }
}