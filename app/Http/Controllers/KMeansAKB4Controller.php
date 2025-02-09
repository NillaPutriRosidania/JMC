<?php

namespace App\Http\Controllers;

use App\Models\KMeansAKB;
use App\Exports\GeneralExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class KMeansAKB4Controller extends Controller
{
    public function index()
    {
        $kmeansAkb = KMeansAKB::with('kecamatan')->get();

        $sortedData = $kmeansAkb->sortBy('grand_total_akb');

        $randomCentroids = [
            $sortedData->values()[0]->grand_total_akb,
            $sortedData->values()[5]->grand_total_akb,
            $sortedData->values()[10]->grand_total_akb,
            $sortedData->values()[15]->grand_total_akb,
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
            for ($i = 1; $i <= 4; $i++) {
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
                    'id_cluster_4' => $cluster['cluster'] + 1,
                    'grand_total_akb' => $cluster['grand_total_akb'],
                ]);
            }
        });

        $finalClusters = $kmeansAkb->groupBy('id_cluster_4');
        $finalClusters = [
            'C1' => $finalClusters->get(2, collect([])),
            'C2' => $finalClusters->get(3, collect([])),
            'C3' => $finalClusters->get(4, collect([])),
            'C4' => $finalClusters->get(5, collect([])),
        ];

        return view('kmeans_akb4.index', compact('kmeansAkb', 'iterations', 'finalClusters'));
    }
    public function exportData()
    {
        $data = KMeansAKB::with(['kecamatan', 'cluster'])->get()->map(function ($item) {
            $namaKecamatan = $item->kecamatan->nama_kecamatan ?? 'N/A';
            $namaCluster4 = $item->cluster->where('id_cluster', $item->id_cluster_4)->first()->nama_cluster ?? 'N/A';
            $grandTotalAkb = $item->grand_total_akb ?? 'N/A';

            return [
                'nama_kecamatan' => $namaKecamatan,
                'nama_cluster_4' => $namaCluster4,
                'grand_total_akb' => $grandTotalAkb,
            ];
        });

        $headings = ['Nama Kecamatan', 'Cluster', 'Grand Total AKB'];
        return Excel::download(new GeneralExport($data, $headings), 'data_export_cluster4.xlsx');
    }
}