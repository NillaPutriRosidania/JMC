<?php

namespace App\Http\Controllers;

use App\Models\AKB;
use App\Models\AKI;
use App\Models\Berita;
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
        $berita = Berita::latest()->paginate(5);
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

        $clusteringAkiKecamatan = KMeansAKI::select(
            DB::raw('COALESCE(cluster.nama_cluster, "Tidak Diketahui") as nama_cluster'),
            'kmeans_aki.id_kecamatan',
            DB::raw('SUM(kmeans_aki.grand_total_aki) as total_aki'),
            'tb_kecamatan.nama_kecamatan'
        )
            ->leftJoin('cluster', 'cluster.id_cluster', '=', 'kmeans_aki.id_cluster')
            ->leftJoin('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'kmeans_aki.id_kecamatan')
            ->groupBy('cluster.nama_cluster', 'kmeans_aki.id_kecamatan', 'tb_kecamatan.nama_kecamatan')
            ->get();

        $clusteringAkbKecamatan = KMeansAKB::select(
            DB::raw('cluster.nama_cluster as cluster_name'),
            'kmeans_akb.id_kecamatan',
            DB::raw('SUM(kmeans_akb.grand_total_akb) as total_akb')
        )
            ->join('cluster', 'cluster.id_cluster', '=', 'kmeans_akb.id_cluster')
            ->groupBy('cluster.nama_cluster', 'kmeans_akb.id_kecamatan')
            ->get();


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
            'clusteringAkbKecamatan',
            'berita'
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
