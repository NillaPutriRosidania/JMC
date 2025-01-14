@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Puskesmas -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-semibold">Total Puskesmas</h3>
                <p class="text-3xl font-bold">{{ $totalPuskesmas }}</p>
            </div>

            {{-- Total Kecamatan --}}
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-semibold">Total Kecamatan</h3>
                <p class="text-3xl font-bold">{{ $totalKecamatan }}</p>
            </div>

            <!-- AKI Tertinggi -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-semibold">AKI Tertinggi</h3>
                <p class="text-2xl font-bold">{{ $akiTertinggi['value'] }}</p>
                <p class="text-sm text-gray-500">{{ $akiTertinggi['nama_kecamatan'] }}</p>
            </div>

            <!-- AKB Tertinggi -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-semibold">AKB Tertinggi</h3>
                <p class="text-2xl font-bold">{{ $akbTertinggi['value'] }}</p>
                <p class="text-sm text-gray-500">{{ $akbTertinggi['nama_kecamatan'] }}</p>
            </div>
        </div>

        <!-- Grafik Kenaikan AKI -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold mb-4">Grafik Kenaikan AKI</h3>
            <div class="flex items-center mb-4">
                <label for="puskesmas-aki" class="mr-2">Pilih Puskesmas:</label>
                <select id="puskesmasDropdownAKI" class="form-select" onchange="updateChart('aki', this.value)">
                    @foreach ($puskesmasList as $puskesmas)
                        <option value="{{ $puskesmas->id_puskesmas }}"
                            {{ $puskesmas->id_puskesmas == $selectedPuskesmas->id_puskesmas ? 'selected' : '' }}>
                            {{ $puskesmas->nama_puskesmas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <canvas id="chart-aki" width="400" height="100"></canvas>
        </div>

        <!-- Grafik Kenaikan AKB -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold mb-4">Grafik Kenaikan AKB</h3>
            <div class="flex items-center mb-4">
                <label for="puskesmas-akb" class="mr-2">Pilih Puskesmas:</label>
                <select id="puskesmasDropdownAKB" class="form-select" onchange="updateChart('akb', this.value)">
                    @foreach ($puskesmasList as $puskesmas)
                        <option value="{{ $puskesmas->id_puskesmas }}"
                            {{ $puskesmas->id_puskesmas == $selectedPuskesmas->id_puskesmas ? 'selected' : '' }}>
                            {{ $puskesmas->nama_puskesmas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <canvas id="chart-akb" width="400" height="100"></canvas>
        </div>

        <!-- Tabel Hasil Clustering AKI -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold mb-4">Hasil Clustering AKI</h3>
            <table class="table-auto w-full text-left border">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Kecamatan</th>
                        <th class="px-4 py-2">Cluster</th>
                        <th class="px-4 py-2">Grand Total AKI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clusteringAki as $row)
                        <tr>
                            <td class="border px-4 py-2">{{ $row->kecamatan->nama_kecamatan }}</td>
                            <td class="border px-4 py-2">C{{ $row->id_cluster }}</td>
                            <td class="border px-4 py-2">{{ $row->grand_total_aki }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tabel Hasil Clustering AKB -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Hasil Clustering AKB</h3>
            <table class="table-auto w-full text-left border">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Kecamatan</th>
                        <th class="px-4 py-2">Cluster</th>
                        <th class="px-4 py-2">Grand Total AKB</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clusteringAkb as $row)
                        <tr>
                            <td class="border px-4 py-2">{{ $row->kecamatan->nama_kecamatan }}</td>
                            <td class="border px-4 py-2">C{{ $row->id_cluster }}</td>
                            <td class="border px-4 py-2">{{ $row->grand_total_akb }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let akiChart, akbChart;

        function updateChart(type, puskesmasId) {
            console.log(`Type: ${type}, Puskesmas ID: ${puskesmasId}`);
            if (!puskesmasId) {
                console.error('Puskesmas ID tidak valid:', puskesmasId);
                return;
            }

            const url = `/api/charts/${type}/${puskesmasId}`;
            console.log(`Fetching data from: ${url}`);

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const labels = data.map(item => item.year);
                    const values = data.map(item => item.value);

                    if (type === 'aki') {
                        akiChart.data.labels = labels;
                        akiChart.data.datasets[0].data = values;
                        akiChart.update();
                    } else {
                        akbChart.data.labels = labels;
                        akbChart.data.datasets[0].data = values;
                        akbChart.update();
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        }

        // Pastikan canvas ada dan chart diinisialisasi setelah DOM siap
        document.addEventListener('DOMContentLoaded', () => {
            const akiCanvas = document.getElementById('chart-aki');
            const akbCanvas = document.getElementById('chart-akb');

            // Pastikan canvas ada di halaman
            if (!akiCanvas || !akbCanvas) {
                console.error("Canvas elements not found in DOM.");
                return;
            }

            const ctxAki = akiCanvas.getContext('2d');
            const ctxAkb = akbCanvas.getContext('2d');

            // Ambil ID Puskesmas pertama dari PHP
            const selectedPuskesmasId = {{ $selectedPuskesmas->id_puskesmas }};

            // Inisialisasi chart untuk AKI dan AKB
            akiChart = new Chart(ctxAki, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Kenaikan AKI',
                        data: [],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            akbChart = new Chart(ctxAkb, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Kenaikan AKB',
                        data: [],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Panggil updateChart untuk AKI dan AKB
            updateChart('aki', selectedPuskesmasId);
            updateChart('akb', selectedPuskesmasId);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
