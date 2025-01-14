<?php

namespace App\Http\Controllers;

use App\Models\AKB;
use App\Models\AKI;
use App\Models\ClusteringAki;
use App\Models\ClusteringAkb;
use App\Models\Puskesmas;
use App\Models\Kecamatan;
use App\Models\KMeansAKB;
use App\Models\KMeansAKI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPuskesmas = Puskesmas::count();
        $totalKecamatan = Kecamatan::count();
        $akiTertinggi = KMeansAKI::select('kmeans_aki.grand_total_aki as value', 'kmeans_aki.id_kecamatan', DB::raw('tb_kecamatan.nama_kecamatan'))
            ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'kmeans_aki.id_kecamatan')
            ->orderBy('kmeans_aki.grand_total_aki', 'desc')
            ->first();
        $akbTertinggi = KMeansAKB::select('kmeans_akb.grand_total_akb as value', 'kmeans_akb.id_kecamatan', DB::raw('tb_kecamatan.nama_kecamatan'))
            ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'kmeans_akb.id_kecamatan')
            ->orderBy('kmeans_akb.grand_total_akb', 'desc')
            ->first();
        $clusteringAki = KMeansAKI::with('kecamatan')->get();
        $clusteringAkb = KMeansAKB::with('kecamatan')->get();

        $puskesmasList = Puskesmas::all();
        $selectedPuskesmas = Puskesmas::first();

        $clusteringAkiKecamatan = KMeansAKI::select('id_cluster', 'id_kecamatan', DB::raw('SUM(grand_total_aki) as total_aki'))
            ->groupBy('id_cluster', 'id_kecamatan')
            ->get();

        $clusteringAkbKecamatan = KMeansAKB::select('id_cluster', 'id_kecamatan', DB::raw('SUM(grand_total_akb) as total_akb'))
            ->groupBy('id_cluster', 'id_kecamatan')
            ->get();

        // dd($puskesmasList);
        return view('pages.dashboard.index', compact(
            'totalPuskesmas',
            'totalKecamatan',
            'akiTertinggi',
            'akbTertinggi',
            'clusteringAki',
            'clusteringAkb',
            'puskesmasList',
            'selectedPuskesmas',
            'clusteringAkiKecamatan',
            'clusteringAkbKecamatan'
        ));
    }

    public function getChartData($type, $puskesmasId)
    {
        if ($type === 'aki') {
            $data = AKI::where('id_puskesmas', $puskesmasId)
                ->join('tahun', 'tahun.id_tahun', '=', 'data_aki.id_tahun')
                ->select('tahun.tahun as year', 'data_aki.aki as value')
                ->get();
        } elseif ($type === 'akb') {
            $data = AKB::where('id_puskesmas', $puskesmasId)
                ->join('tahun', 'tahun.id_tahun', '=', 'data_akb.id_tahun')
                ->select('tahun.tahun as year', 'data_akb.akb as value')
                ->get();
        } else {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        return response()->json($data);
    }
}
