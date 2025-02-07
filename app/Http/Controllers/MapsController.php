<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MapsController extends Controller
{
    public function getKecamatanData($type = 'aki')
    {
        if ($type === 'akb') {
            $kmeansTable = 'kmeans_akb';
            $grandTotalColumn = 'grand_total_akb';
        } else {
            $kmeansTable = 'kmeans_aki';
            $grandTotalColumn = 'grand_total_aki';
        }
        $kecamatan = DB::table('tb_kecamatan')
            ->join($kmeansTable, 'tb_kecamatan.id_kecamatan', '=', "$kmeansTable.id_kecamatan")
            ->select(
                'tb_kecamatan.id_kecamatan',
                'tb_kecamatan.nama_kecamatan',
                'tb_kecamatan.geojson',
                'tb_kecamatan.latitude',
                'tb_kecamatan.longitude',
                "$kmeansTable.id_cluster",
                "$kmeansTable.id_cluster_3",
                "$kmeansTable.id_cluster_4",
                "$kmeansTable.$grandTotalColumn"
            )
            ->get();
        return response()->json($kecamatan);
    }
}
