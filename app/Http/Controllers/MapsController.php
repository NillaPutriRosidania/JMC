<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MapsController  extends Controller
{

    public function getKecamatanData()
    {
        // Join antara tb_kecamatan dan kmeans_aki berdasarkan id_kecamatan
        $kecamatan = DB::table('tb_kecamatan')
            ->join('kmeans_aki', 'tb_kecamatan.id_kecamatan', '=', 'kmeans_aki.id_kecamatan')
            ->select(
                'tb_kecamatan.id_kecamatan',
                'tb_kecamatan.nama_kecamatan',
                'tb_kecamatan.geojson',
                'tb_kecamatan.latitude',
                'tb_kecamatan.longitude',
                'kmeans_aki.id_cluster' // Ambil id_cluster dari tabel kmeans_aki
            )
            ->get();

        return response()->json($kecamatan);
    }
}
