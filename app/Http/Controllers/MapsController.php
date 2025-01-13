<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MapsController extends Controller
{
    public function getKecamatanData($type = 'aki')
    {
        // Pilih tabel berdasarkan jenis (aki atau akb)
        $kmeansTable = $type === 'akb' ? 'kmeans_akb' : 'kmeans_aki';

        // Join antara tb_kecamatan dan tabel kmeans yang sesuai berdasarkan id_kecamatan
        $kecamatan = DB::table('tb_kecamatan')
            ->join($kmeansTable, 'tb_kecamatan.id_kecamatan', '=', "$kmeansTable.id_kecamatan")
            ->select(
                'tb_kecamatan.id_kecamatan',
                'tb_kecamatan.nama_kecamatan',
                'tb_kecamatan.geojson',
                'tb_kecamatan.latitude',
                'tb_kecamatan.longitude',
                "$kmeansTable.id_cluster" // Ambil id_cluster dari tabel yang sesuai
            )
            ->get();

        return response()->json($kecamatan);
    }
}
