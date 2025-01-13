@extends('layouts.app')

@section('title', 'Data KMeans AKI')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-lg font-bold text-center text-red-600 mb-4">Data KMeans AKI</h2>

        <div class="bg-white p-4 mb-4 border-2 border-gray-200 rounded-lg">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-left text-sm">
                        <th class="border border-gray-300 px-4 py-2">NO</th>
                        <th class="border border-gray-300 px-4 py-2">Nama Kecamatan</th>
                        <th class="border border-gray-300 px-4 py-2">Grand Total AKI</th>
                        <th class="border border-gray-300 px-4 py-2">ID Cluster</th>
                        <th class="border border-gray-300 px-4 py-2">Created At</th>
                        <th class="border border-gray-300 px-4 py-2">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kmeansAki as $kmeans)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $kmeans->kecamatan->nama_kecamatan }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $kmeans->grand_total_aki }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $kmeans->id_cluster }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $kmeans->created_at }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $kmeans->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Iterasi --}}
        @foreach ($iterations as $iteration)
            <h2 class="text-lg font-bold text-gray-700 mt-6 mb-2">Iterasi {{ $iteration['iteration'] }}</h2>

            {{-- Tabel 1: Centroids --}}
            <div class="bg-white p-4 mb-4 border-2 border-gray-200 rounded-lg">
                <h3 class="text-md font-bold text-gray-700">Centroid</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200 text-left text-sm">
                            <th class="border border-gray-300 px-4 py-2">No</th>
                            <th class="border border-gray-300 px-4 py-2">Cluster</th>
                            <th class="border border-gray-300 px-4 py-2">Grand Total AKI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($iteration['centroids'] as $index => $centroid)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-4 py-2">C{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $centroid }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tabel 2: Hasil Iterasi --}}
            <div class="bg-white p-4 mb-4 border-2 border-gray-200 rounded-lg">
                <h3 class="text-md font-bold text-gray-700">Hasil Iterasi</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200 text-left text-sm">
                            <th class="border border-gray-300 px-4 py-2">No</th>
                            <th class="border border-gray-300 px-4 py-2">Nama Kecamatan</th>
                            @for ($i = 1; $i <= 5; $i++)
                                <th class="border border-gray-300 px-4 py-2">C{{ $i }}</th>
                            @endfor
                            <th class="border border-gray-300 px-4 py-2">Min</th>
                            <th class="border border-gray-300 px-4 py-2">Cluster</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($iteration['clusters'] as $index => $cluster)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $cluster['id_kecamatan'] }}</td>
                                @foreach ($cluster['distances'] as $distance)
                                    <td class="border border-gray-300 px-4 py-2">{{ number_format($distance, 2) }}</td>
                                @endforeach
                                <td class="border border-gray-300 px-4 py-2">{{ number_format($cluster['min'], 2) }}</td>
                                <td class="border border-gray-300 px-4 py-2">C{{ $cluster['cluster'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

        {{-- Tabel Hasil Clustering --}}
        <div class="bg-white p-4 mt-6 border-2 border-gray-200 rounded-lg">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Tabel Hasil Clustering</h2>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-left text-sm">
                        <th class="border border-gray-300 px-4 py-2">C1</th>
                        <th class="border border-gray-300 px-4 py-2">C2</th>
                        <th class="border border-gray-300 px-4 py-2">C3</th>
                        <th class="border border-gray-300 px-4 py-2">C4</th>
                        <th class="border border-gray-300 px-4 py-2">C5</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Tentukan jumlah baris berdasarkan cluster dengan jumlah kecamatan terbanyak --}}
                    @php
                        $maxRows = max(
                            count($finalClusters['C1'] ?? []),
                            count($finalClusters['C2'] ?? []),
                            count($finalClusters['C3'] ?? []),
                            count($finalClusters['C4'] ?? []),
                            count($finalClusters['C5'] ?? []),
                        );
                    @endphp
                    @for ($i = 0; $i < $maxRows; $i++)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $finalClusters['C1'][$i]->kecamatan->nama_kecamatan ?? '' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $finalClusters['C2'][$i]->kecamatan->nama_kecamatan ?? '' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $finalClusters['C3'][$i]->kecamatan->nama_kecamatan ?? '' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $finalClusters['C4'][$i]->kecamatan->nama_kecamatan ?? '' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $finalClusters['C5'][$i]->kecamatan->nama_kecamatan ?? '' }}
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="container">
            <div id="map"></div>
        </div>
    </div>
@endsection
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var map = L.map('map').setView([-8.1845, 113.6681], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        function generateColor(clusterId) {
            const colors = {
                1: '#0000FF', // Blue
                2: '#008000', // Green
                3: '#FFFF00', // Yellow
                4: '#FFA500', // Orange
                5: '#FF0000' // Red
            };
            return colors[clusterId] || '#000000'; // Default to black if not found
        }

        fetch('/api/kecamatan/aki')
            .then(response => response.json())
            .then(data => {
                console.log(data); // Pastikan data berhasil diterima
                data.forEach(kecamatan => {
                    try {
                        const geojson = JSON.parse(kecamatan.geojson);

                        L.geoJSON(geojson, {
                            style: function() {
                                return {
                                    color: generateColor(kecamatan
                                        .id_cluster), // Menggunakan id_cluster
                                    weight: 2,
                                    fillOpacity: 0.5
                                };
                            }
                        }).bindPopup(`<b>${kecamatan.nama_kecamatan}</b>`).addTo(map);
                    } catch (error) {
                        console.error(`Error parsing GeoJSON for ${kecamatan.nama_kecamatan}:`,
                            error);
                    }
                });
            })
            .catch(error => console.error('Error fetching GeoJSON:', error));
    });
</script>
