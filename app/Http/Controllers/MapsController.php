<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MapsController  extends Controller
{

    public function getKecamatanData()
    {
        $kecamatan = DB::table('tb_kecamatan')->select(
            'id_kecamatan',
            'nama_kecamatan',
            'geojson',
            'latitude',
            'longitude'
        )->get();
        return response()->json($kecamatan);
    }
}
