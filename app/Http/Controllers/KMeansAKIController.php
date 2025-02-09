<?php

namespace App\Http\Controllers;

use App\Models\KMeansAKI;
use App\Exports\GeneralExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class KMeansAKIController extends Controller
{
    public function index()
    {
        $kmeansAki = KMeansAKI::with('kecamatan')->get();

        $sortedData = $kmeansAki->sortBy('grand_total_aki');

        $randomCentroids = [
            $sortedData->values()[0]->grand_total_aki,
            $sortedData->values()[5]->grand_total_aki,
            $sortedData->values()[11]->grand_total_aki,
            $sortedData->values()[17]->grand_total_aki,
            $sortedData->values()[29]->grand_total_aki,
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
            for ($i = 1; $i <= 5; $i++) {
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
                    'id_cluster' => $cluster['cluster'],
                    'grand_total_aki' => $cluster['grand_total_aki'],
                ]);
            }
        });

        $finalClusters = $kmeansAki->groupBy('id_cluster');

        $finalClusters = [
            'C1' => $finalClusters->get(1, collect([])),
            'C2' => $finalClusters->get(2, collect([])),
            'C3' => $finalClusters->get(3, collect([])),
            'C4' => $finalClusters->get(4, collect([])),
            'C5' => $finalClusters->get(5, collect([])),
        ];
        return view('kmeans_aki.index', compact('kmeansAki', 'iterations', 'finalClusters'));
    }
    public function exportData()
    {
        $data = KMeansAKI::with(['kecamatan', 'cluster'])->get()->map(function ($item) {
            $namaKecamatan = $item->kecamatan->nama_kecamatan ?? 'N/A';
            $namaCluster = $item->cluster->where('id_cluster', $item->id_cluster)->first()->nama_cluster ?? 'N/A';
            $grandTotalAki = $item->grand_total_aki ?? 'N/A';

            return [
                'nama_kecamatan' => $namaKecamatan,
                'nama_cluster' => $namaCluster,
                'grand_total_aki' => $grandTotalAki,
            ];
        });

        $headings = ['Nama Kecamatan', 'Cluster', 'Grand Total AKI'];
        return Excel::download(new GeneralExport($data, $headings), 'data_export_aki.xlsx');
    }
}