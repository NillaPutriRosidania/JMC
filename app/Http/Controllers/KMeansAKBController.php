<?php

namespace App\Http\Controllers;

use App\Exports\GeneralExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Cluster;
use App\Models\KMeansAKB;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KMeansAKBController extends Controller
{
    public function index()
    {
        $kmeansAkb = KMeansAKB::with('kecamatan')->get();
        $clusters = Cluster::all();
        $sortedData = $kmeansAkb->sortBy('grand_total_akb');


        $randomCentroids = [
            $sortedData->values()[0]->grand_total_akb,
            $sortedData->values()[5]->grand_total_akb,
            $sortedData->values()[11]->grand_total_akb,
            $sortedData->values()[17]->grand_total_akb,
            $sortedData->values()[29]->grand_total_akb,
        ];

        $iterations = [];
        $previousClusters = [];
        $stable = false;
        $iterationIndex = 1;

        while (!$stable) {
            $clusters = [];

            foreach ($kmeansAkb as $data) {

                $distances = array_map(fn($centroid) => sqrt(pow($data->grand_total_akb - $centroid, 2)), $randomCentroids);
                $minDistance = min($distances);
                $cluster = array_search($minDistance, $distances) + 1;

                $clusters[] = [
                    'id' => $data->id_kmeans_akb,
                    'id_kecamatan' => $data->kecamatan->nama_kecamatan,
                    'grand_total_akb' => $data->grand_total_akb,
                    'distances' => $distances,
                    'min' => $minDistance,
                    'cluster' => $cluster,
                ];
            }

            $iterations[] = [
                'iteration' => $iterationIndex,
                'clusters' => $clusters,
                'centroids' => $randomCentroids,
            ];

            $newCentroids = [];
            for ($i = 1; $i <= 5; $i++) {
                $clusterData = array_filter($clusters, fn($c) => $c['cluster'] == $i);
                $newCentroids[] = count($clusterData) > 0
                    ? array_sum(array_column($clusterData, 'grand_total_akb')) / count($clusterData)
                    : $randomCentroids[$i - 1];
            }

            $currentClusters = array_column($clusters, 'cluster');
            $stable = $previousClusters == $currentClusters;
            $previousClusters = $currentClusters;
            $randomCentroids = $newCentroids;

            $iterationIndex++;
        }

        DB::transaction(function () use ($clusters) {
            foreach ($clusters as $cluster) {
                KMeansAKB::where('id_kmeans_akb', $cluster['id'])->update([
                    'id_cluster' => $cluster['cluster'],
                    'grand_total_akb' => $cluster['grand_total_akb'],
                ]);
            }
        });

        $finalClusters = $kmeansAkb->groupBy('id_cluster');

        $finalClusters = [
            'C1' => $finalClusters->get(1, collect([])),
            'C2' => $finalClusters->get(2, collect([])),
            'C3' => $finalClusters->get(3, collect([])),
            'C4' => $finalClusters->get(4, collect([])),
            'C5' => $finalClusters->get(5, collect([])),
        ];

        return view('kmeans_akb.index', compact('kmeansAkb', 'iterations', 'finalClusters', 'clusters'));
    }
    public function exportData()
    {
        $data = KMeansAKB::with(['kecamatan', 'cluster'])->get()->map(function ($item) {
            $namaKecamatan = $item->kecamatan->nama_kecamatan ?? 'N/A';
            $namaCluster5 = $item->cluster->where('id_cluster', $item->id_cluster)->first()->nama_cluster ?? 'N/A';
            $grandTotalAkb = $item->grand_total_akb ?? 'N/A';

            return [
                'nama_kecamatan' => $namaKecamatan,
                'nama_cluster_5' => $namaCluster5,
                'grand_total_akb' => $grandTotalAkb,
            ];
        });

        $headings = ['Nama Kecamatan', 'Cluster', 'Grand Total AKB'];
        return Excel::download(new GeneralExport($data, $headings), 'data_export.xlsx');
    }
}
