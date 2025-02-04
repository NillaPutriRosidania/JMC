<?php

namespace App\Http\Controllers;

use App\Models\KMeansAKI; // Tetap menggunakan model KMeansAKI
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KMeansAKI4Controller extends Controller
{
    public function index()
    {
        $kmeansAki = KMeansAKI::with('kecamatan')->get();
        $sortedData = $kmeansAki->sortBy('grand_total_aki');
        $randomCentroids = [
            $sortedData->values()[0]->grand_total_aki,
            $sortedData->values()[5]->grand_total_aki,
            $sortedData->values()[10]->grand_total_aki,
            $sortedData->values()[15]->grand_total_aki,
        ];

        $iterations = [];
        $previousClusters = [];
        $stable = false;
        $iterationIndex = 1;
        while (!$stable) {
            $clusters = [];
            foreach ($kmeansAki as $data) {
                $distances = array_map(fn($centroid) => sqrt(pow($data->grand_total_aki - $centroid, 2)), $randomCentroids);
                $minDistance = min($distances);
                $cluster = array_search($minDistance, $distances) + 1;
                $clusters[] = [
                    'id' => $data->id_kmeans_aki,
                    'id_kecamatan' => $data->kecamatan->nama_kecamatan,
                    'grand_total_aki' => $data->grand_total_aki,
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
                    ? array_sum(array_column($clusterData, 'grand_total_aki')) / count($clusterData)
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
                KMeansAKI::where('id_kmeans_aki', $cluster['id'])->update([
                    'id_cluster_4' => $cluster['cluster'] + 1,
                    'grand_total_aki' => $cluster['grand_total_aki'],
                ]);
            }
        });

        $finalClusters = $kmeansAki->groupBy('id_cluster_4');
        $finalClusters = [
            'C1' => $finalClusters->get(2, collect([])),  // Cluster 1
            'C2' => $finalClusters->get(3, collect([])),  // Cluster 2
            'C3' => $finalClusters->get(4, collect([])),  // Cluster 4
            'C4' => $finalClusters->get(5, collect([])),  // Cluster 5
        ];

        return view('kmeans_aki4.index', compact('kmeansAki', 'iterations', 'finalClusters'));
    }
}