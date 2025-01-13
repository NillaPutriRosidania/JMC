<?php

namespace App\Http\Controllers;

use App\Models\KMeansAKI;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KMeansAKIController extends Controller
{
    public function index()
    {
        // Ambil data kmeans aki dan kecamatan
        $kmeansAki = KMeansAKI::with('kecamatan')->get();

        // Urutkan berdasarkan grand_total_aki
        $sortedData = $kmeansAki->sortBy('grand_total_aki');

        // Tentukan nilai centroid acak untuk k-means
        $randomCentroids = [
            $sortedData->values()[0]->grand_total_aki,   // Total AKI terkecil ke-1
            $sortedData->values()[5]->grand_total_aki,   // Total AKI terkecil ke-6
            $sortedData->values()[11]->grand_total_aki,  // Total AKI terkecil ke-12
            $sortedData->values()[17]->grand_total_aki,  // Total AKI terkecil ke-18
            $sortedData->values()[29]->grand_total_aki,  // Total AKI terkecil ke-30
        ];

        $iterations = [];
        $previousClusters = [];
        $stable = false;
        $iterationIndex = 1;

        while (!$stable) {
            $clusters = [];

            foreach ($kmeansAki as $data) {
                // Hitung jarak antara titik data dan setiap centroid
                $distances = array_map(fn($centroid) => sqrt(pow($data->grand_total_aki - $centroid, 2)), $randomCentroids);
                $minDistance = min($distances);
                $cluster = array_search($minDistance, $distances) + 1; // Cluster C1, C2, ...

                $clusters[] = [
                    'id' => $data->id_kmeans_aki,
                    'id_kecamatan' => $data->kecamatan->nama_kecamatan,
                    'grand_total_aki' => $data->grand_total_aki,
                    'distances' => $distances,
                    'min' => $minDistance,
                    'cluster' => $cluster,
                ];
            }

            // Simpan hasil iterasi
            $iterations[] = [
                'iteration' => $iterationIndex,
                'clusters' => $clusters,
                'centroids' => $randomCentroids,
            ];

            // Update centroid berdasarkan rata-rata cluster
            $newCentroids = [];
            for ($i = 1; $i <= 5; $i++) {
                $clusterData = array_filter($clusters, fn($c) => $c['cluster'] == $i);
                $newCentroids[] = count($clusterData) > 0
                    ? array_sum(array_column($clusterData, 'grand_total_aki')) / count($clusterData)
                    : $randomCentroids[$i - 1];
            }

            // Periksa apakah cluster tidak berubah
            $currentClusters = array_column($clusters, 'cluster');
            $stable = $previousClusters == $currentClusters;
            $previousClusters = $currentClusters;
            $randomCentroids = $newCentroids;

            $iterationIndex++;
        }

        // Pembaruan data cluster ke database
        DB::transaction(function () use ($clusters) {
            foreach ($clusters as $cluster) {
                // Update id_cluster dan grand_total_aki untuk setiap data
                KMeansAKI::where('id_kmeans_aki', $cluster['id'])->update([
                    'id_cluster' => $cluster['cluster'],
                    'grand_total_aki' => $cluster['grand_total_aki'], // Memastikan nilai AKI tetap diperbarui
                ]);
            }
        });

        // Kelompokkan hasil akhir berdasarkan id_cluster
        $finalClusters = $kmeansAki->groupBy('id_cluster');

        // Jika ingin tetap memisahkan berdasarkan C1, C2, C3, C4, C5
        $finalClusters = [
            'C1' => $finalClusters->get(1, collect([])),
            'C2' => $finalClusters->get(2, collect([])),
            'C3' => $finalClusters->get(3, collect([])),
            'C4' => $finalClusters->get(4, collect([])),
            'C5' => $finalClusters->get(5, collect([])),
        ];

        // Kembalikan view dengan data iterasi dan hasil final
        return view('kmeans_aki.index', compact('kmeansAki', 'iterations', 'finalClusters'));
    }
}
