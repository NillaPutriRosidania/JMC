@extends(Auth::check() ? 'layouts.app' : 'layouts.dashboardguest')
@section('title', 'Data KMeans AKI')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-lg font-bold text-center text-red-600 mb-4">Data KMeans AKI</h2>
        <div class="flex items-center w-full md:w-auto mb-4">
            <label for="cluster" class="mr-2">Pilih Cluster:</label>
            <select id="cluster" class="p-2 border border-gray-300 rounded-lg">
                <option value="kmeans_aki3">3 Cluster</option>
                <option value="kmeans_aki4">4 Cluster</option>
                <option value="kmeans_aki" selected>5 Cluster</option>
            </select>
        </div>
        <div class="flex space-x-2 mb-4">
            <a href="{{ route('export.kmeans.aki') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Export KMeans AKI</a>
        </div>
        <div class="bg-white p-4 mb-4 border-2 border-gray-200 rounded-lg">
            <div class="relative">
                <div id="map"></div>
            </div>            
        </div>
        <div class="bg-white p-4 mb-4 border-2 border-gray-200 rounded-lg">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Tabel Hasil Clustering</h2>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-center text-sm text-white">
                        <th class="border border-gray-300 px-4 py-2" style="background-color: #0000FF;">Sangat Rendah</th>
                        <th class="border border-gray-300 px-4 py-2" style="background-color: #008000;">Rendah</th>
                        <th class="border border-gray-300 px-4 py-2" style="background-color: #FFE31A  ;">Biasa</th>
                        <th class="border border-gray-300 px-4 py-2" style="background-color: #F14A00;">Tinggi</th>
                        <th class="border border-gray-300 px-4 py-2" style="background-color: #FF0000;">Sangat Tinggi</th>
                    </tr>
                </thead>
                <tbody>
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
        <div class="bg-white p-4 mb-4 border-2 border-gray-200 rounded-lg">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-left text-sm">
                        <th class="border border-gray-300 px-4 py-2">NO</th>
                        <th class="border border-gray-300 px-4 py-2">Nama Kecamatan</th>
                        <th class="border border-gray-300 px-4 py-2">Grand Total AKI (Ibu)</th>
                        <th class="border border-gray-300 px-4 py-2">ID Cluster</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kmeansAki as $kmeans)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $kmeans->kecamatan->nama_kecamatan }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $kmeans->grand_total_aki }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $kmeans->id_cluster }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-white p-4 mb-4 border-2 border-gray-200 rounded-lg">
            <div class="tabs m-4">
                <ul class="flex space-x-4 w-full">
                    @foreach ($iterations as $key => $iteration)
                        <li class="inline-block w-full">
                            <button 
                                class="px-4 py-3 rounded-lg text-gray-900 hover:bg-gray-100 dark:hover:bg-red-600 dark:hover:text-white
                                    {{ $loop->first ? 'bg-red-600 text-white' : 'bg-white text-gray-500' }} font-semibold tab-link"
                                onclick="showTabContent('tab-{{ $key }}', {{ $key }})">
                                Iterasi {{ $iteration['iteration'] }}
                            </button>
                        </li>
                    @endforeach
                </ul>
                @foreach ($iterations as $key => $iteration)
                    <div id="tab-{{ $key }}" class="tab-content hidden">
                        <h2 class="text-lg font-bold text-gray-700 mt-6 mb-2">Iterasi {{ $iteration['iteration'] }}</h2>
                        
                        <!-- Centroids Table -->
                        <div class="bg-white p-4 mb-4 border-2 border-gray-200 rounded-lg">
                            <h3 class="text-md font-bold text-gray-700">Centroid</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-200 text-left text-sm">
                                            <th class="border border-gray-300 px-4 py-2">No</th>
                                            <th class="border border-gray-300 px-4 py-2">Cluster</th>
                                            <th class="border border-gray-300 px-4 py-2">Grand Total AKI (Ibu)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($iteration['centroids'] as $index => $centroid)
                                            @if ($index < 10)
                                                <tr>
                                                    <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                                    <td class="border border-gray-300 px-4 py-2">C{{ $index + 1 }}</td>
                                                    <td class="border border-gray-300 px-4 py-2">{{ $centroid }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
        
                        <!-- Cluster Results Table -->
                        <div class="bg-white p-4 mb-4 border-2 border-gray-200 rounded-lg">
                            <h3 class="text-md font-bold text-gray-700">Hasil Iterasi</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-200 text-left text-sm">
                                            <th class="border border-gray-300 px-4 py-2">No</th>
                                            <th class="border border-gray-300 px-4 py-2">Nama Kecamatan</th>
                                            <th class="border border-gray-300 px-4 py-2">C1</th>
                                            <th class="border border-gray-300 px-4 py-2">C2</th>
                                            <th class="border border-gray-300 px-4 py-2">C3</th>
                                            <th class="border border-gray-300 px-4 py-2">C4</th>
                                            <th class="border border-gray-300 px-4 py-2">C5</th>
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
                                                    @if ($loop->index < 5)
                                                        <td class="border border-gray-300 px-4 py-2">{{ number_format($distance, 2) }}</td>
                                                    @endif
                                                @endforeach
                                                <td class="border border-gray-300 px-4 py-2">{{ number_format($cluster['min'], 2) }}</td>
                                                <td class="border border-gray-300 px-4 py-2">C{{ $cluster['cluster'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div> 
    </div>
@endsection
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        document.getElementById('cluster').addEventListener('change', function() {
            var selectedValue = this.value;
            if (selectedValue) {
                window.location.href = '/' + selectedValue;
            }
        });

        var map = L.map('map').setView([-8.1845, 113.6681], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        function generateColor(clusterId) {
            const colors = {
                1: '#0000FF',
                2: '#008000',
                3: '#FFFF00',
                4: '#FFA500',
                5: '#FF0000'
            };
            return colors[clusterId] || '#000000';
        }
        fetch('/api/kecamatan/aki')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                data.forEach(kecamatan => {
                    try {
                        const geojson = JSON.parse(kecamatan.geojson);
                        const layer = L.geoJSON(geojson, {
                            style: function() {
                                return {
                                    color: generateColor(kecamatan
                                        .id_cluster),
                                    weight: 2,
                                    fillOpacity: 0.5
                                };
                            }
                        }).bindPopup(`<b>${kecamatan.nama_kecamatan}</b><br>Grand Total Aki: ${kecamatan.grand_total_aki}`).addTo(map);
                        layer.on('click', function() {
                            if (kecamatan.id_cluster === 5) {
                                Swal.fire({
                                    title: "<strong style='font-size: 24px;'>AKI/AKB TINGGI</strong>", // Judul besar dan bold
                                    icon: "warning",
                                    html: "<p style='font-size: 14px;'>Jika AKI dan AKB tinggi, Dinas Kesehatan (Dinkes) akan meningkatkan kualitas pelayanan kesehatan, melakukan penyuluhan dan edukasi kesehatan, melatih tenaga medis, memperbaiki akses ke fasilitas kesehatan, menangani komplikasi, menyediakan program gizi, serta memantau kesehatan ibu dan bayi pasca persalinan untuk menurunkan angka kematian tersebut.</p>",
                                    confirmButtonText: "OK",
                                    confirmButtonColor: "#3085d6",
                                });
                            }
                        });
                    } catch (error) {
                        console.error(`Error parsing GeoJSON for ${kecamatan.nama_kecamatan}:`,
                            error);
                    }
                });
            })
            .catch(error => console.error('Error fetching GeoJSON:', error));
    });

    document.getElementById('cluster').addEventListener('change', function() {
        var selectedValue = this.value;
        if (selectedValue) {
            window.location.href = '/' + selectedValue;
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        showTabContent('tab-0');
        setActiveTab(0);
    });
    function showTabContent(tabId, activeTabIndex) {
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => {
            content.classList.add('hidden');
        });
        const activeTabContent = document.getElementById(tabId);
        if (activeTabContent) {
            activeTabContent.classList.remove('hidden');
        }
        setActiveTab(activeTabIndex);
    }
    function setActiveTab(activeTabIndex) {
        const allTabs = document.querySelectorAll('button.tab-link');
        allTabs.forEach((tab, index) => {
            if (index === activeTabIndex) {
                tab.classList.add('bg-red-600', 'text-white');
                tab.classList.remove('bg-white', 'text-gray-500');
            } else {
                tab.classList.remove('bg-red-600', 'text-white');
                tab.classList.add('bg-white', 'text-gray-500');
            }
        });
    }
</script>
