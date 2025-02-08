@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('puskesmas.index') }}" class="bg-white shadow-md rounded-lg p-4 flex items-center cursor-pointer hover:bg-gray-100 transition">
                <i class="fa-solid fa-hospital text-blue-500 text-4xl"></i>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Total Puskesmas</h3>
                    <p class="text-3xl font-bold">{{ $totalPuskesmas }}</p>
                </div>
            </a>            
            <a href="{{ route('kecamatan.index') }}" class="bg-white shadow-md rounded-lg p-4 flex items-center cursor-pointer hover:bg-gray-100 transition">
                <i class="fa-solid fa-map-marker-alt text-green-500 text-4xl"></i>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Total Kecamatan</h3>
                    <p class="text-3xl font-bold">{{ $totalKecamatan }}</p>
                </div>
            </a>
            <a href="{{ route('aki.index') }}" class="bg-white shadow-md rounded-lg p-4 flex items-center cursor-pointer hover:bg-gray-100 transition">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-4xl"></i>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">AKI Tertinggi</h3>
                    <p class="text-2xl font-bold">{{ $akiTertinggi['value'] }}</p>
                    <p class="text-sm text-gray-500">{{ $akiTertinggi['nama_kecamatan'] }}</p>
                </div>
            </a>
            <a href="{{ route('akb.index') }}" class="bg-white shadow-md rounded-lg p-4 flex items-center cursor-pointer hover:bg-gray-100 transition">
                <i class="fa-solid fa-heartbeat text-pink-500 text-4xl"></i>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">AKB Tertinggi</h3>
                    <p class="text-2xl font-bold">{{ $akbTertinggi['value'] }}</p>
                    <p class="text-sm text-gray-500">{{ $akbTertinggi['nama_kecamatan'] }}</p>
                </div>
            </a>
        </div>      
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <div class="flex items-center relative">
                <h3 class="text-lg font-semibold mb-4">Grafik  Angka Kematian Ibu (AKI)</h3>
                <button onclick="toggleTooltip('tooltipAKI')" class="ml-2 -mt-5 text-blue-500 hover:text-blue-700 relative">
                    <i class="fa-solid fa-circle-info text-lg"></i>
                </button>
                <div id="tooltipAKI" class="absolute left-[35%] transform -translate-x-1/2 mt-2 bg-white p-3 shadow-lg rounded-lg w-64 hidden">
                    <p class="text-gray-700 text-sm">
                        Angka Kematian Ibu (AKI) adalah jumlah kematian ibu selama kehamilan, persalinan, dan 42 hari setelah melahirkan per 100.000 kelahiran hidup.
                    </p>
                    <div class="absolute top-0 left-[90%] transform -translate-x-1/2 -translate-y-full border-8 border-transparent border-b-white"></div>
                </div>
            </div>            
            <div class="flex items-center mb-4">
                <label for="puskesmas-aki" class="mr-2">Pilih Puskesmas:</label>
                <select id="puskesmasDropdownAKI" class="p-2 border border-gray-300 rounded-lg" onchange="updateChart('aki', this.value)">
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
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <div class="flex items-center relative">
                <h3 class="text-lg font-semibold mb-4">Grafik Angka Kematian Bayi (AKI)</h3>
                <button onclick="toggleTooltip('tooltipAKB')" class="ml-2 -mt-5 text-blue-500 hover:text-blue-700 relative">
                    <i class="fa-solid fa-circle-info text-lg"></i>
                </button>
                <div id="tooltipAKB" class="absolute left-[35%] transform -translate-x-1/2 mt-2 bg-white p-3 shadow-lg rounded-lg w-64 hidden">
                    <p class="text-gray-700 text-sm">
                        AKB (Angka Kematian Bayi) adalah jumlah kematian bayi sebelum mencapai usia 1 tahun per 1.000 kelahiran hidup dalam satu tahun tertentu.
                    </p>
                    <div class="absolute top-0 left-[90%] transform -translate-x-1/2 -translate-y-full border-8 border-transparent border-b-white"></div>
                </div>
            </div>  
            <div class="flex items-center mb-4">
                <label for="puskesmas-akb" class="mr-2">Pilih Puskesmas:</label>
                <select id="puskesmasDropdownAKB" class="p-2 border border-gray-300 rounded-lg" onchange="updateChart('akb', this.value)">
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
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold mb-4">Hasil Clustering AKI</h3>
            <table class="table-auto w-full text-left border">
                <thead class="bg-red-600 text-white">
                    <tr>
                        <th class="px-4 py-2 border border-red-700">Kecamatan</th>
                        <th class="px-4 py-2 border border-red-700">Cluster</th>
                        <th class="px-4 py-2 border border-red-700">Grand Total AKI (Ibu)</th>
                    </tr>
                </thead>                
                <tbody>
                    @foreach ($clusteringAki as $row)
                        <tr>
                            <td class="border px-4 py-2">{{ $row->kecamatan->nama_kecamatan }}</td>
                            <td class="border px-4 py-2">{{ $row->cluster->nama_cluster ?? 'Tidak Diketahui' }}</td>
                            <td class="border px-4 py-2">{{ $row->grand_total_aki }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Hasil Clustering AKB</h3>
            <table class="table-auto w-full text-left border">
                <thead class="bg-red-600 text-white">
                    <tr>
                        <th class="px-4 py-2 border border-red-700">Kecamatan</th>
                        <th class="px-4 py-2 border border-red-700">Cluster</th>
                        <th class="px-4 py-2 border border-red-700">Grand Total AKB (Bayi)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clusteringAkb as $row)
                        <tr>
                            <td class="border px-4 py-2">{{ $row->kecamatan->nama_kecamatan }}</td>
                            <td class="border px-4 py-2">{{ $row->cluster->nama_cluster ?? 'Tidak Diketahui' }}</td>
                            <td class="border px-4 py-2">{{ $row->grand_total_akb }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
{{-- <script>
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

    document.addEventListener('DOMContentLoaded', () => {
        const akiCanvas = document.getElementById('chart-aki');
        const akbCanvas = document.getElementById('chart-akb');

        if (!akiCanvas || !akbCanvas) {
            console.error("Canvas elements not found in DOM.");
            return;
        }
        const ctxAki = akiCanvas.getContext('2d');
        const ctxAkb = akbCanvas.getContext('2d');
        const selectedPuskesmasId = {{ $selectedPuskesmas->id_puskesmas }};

        akiChart = new Chart(ctxAki, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Nilai AKI',
                    data: [],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: tooltipItem => `Nilai AKI: ${tooltipItem.raw} Ibu`
                        }
                    }
                },
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
                    label: 'Nilai AKB',
                    data: [],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: tooltipItem => `Nilai AKB: ${tooltipItem.raw} Bayi`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        updateChart('aki', selectedPuskesmasId);
        updateChart('akb', selectedPuskesmasId);
    });
</script> --}}
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
            const previousValues = [0, ...values.slice(0, -1)]; // Data tahun sebelumnya
            const increases = values.map((val, index) => val - previousValues[index]);

            if (type === 'aki') {
                akiChart.data.labels = labels;
                akiChart.data.datasets[0].data = values;
                akiChart.options.plugins.tooltip.callbacks.label = function (tooltipItem) {
                    let value = tooltipItem.raw;
                    let increase = increases[tooltipItem.dataIndex];
                    let message = `Nilai AKI: ${value} Ibu`;
                    if (increase > 10) {
                        message += ` \n⚠️ Lonjakan: +${increase} dari tahun sebelumnya!`;
                    }
                    return message;
                };
                akiChart.update();
            } else {
                akbChart.data.labels = labels;
                akbChart.data.datasets[0].data = values;
                akbChart.options.plugins.tooltip.callbacks.label = function (tooltipItem) {
                    let value = tooltipItem.raw;
                    let increase = increases[tooltipItem.dataIndex];
                    let message = `Nilai AKB: ${value} Bayi`;
                    if (increase > 10) {
                        message += ` \n⚠️ Lonjakan: +${increase} dari tahun sebelumnya!`;
                    }
                    return message;
                };
                akbChart.update();
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
}

document.addEventListener('DOMContentLoaded', () => {
    const akiCanvas = document.getElementById('chart-aki');
    const akbCanvas = document.getElementById('chart-akb');
    if (!akiCanvas || !akbCanvas) {
        console.error("Canvas elements not found in DOM.");
        return;
    }
    const ctxAki = akiCanvas.getContext('2d');
    const ctxAkb = akbCanvas.getContext('2d');
    const selectedPuskesmasId = {{ $selectedPuskesmas->id_puskesmas }};

    akiChart = new Chart(ctxAki, {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Nilai AKI', data: [], borderColor: 'rgba(75, 192, 192, 1)', backgroundColor: 'rgba(75, 192, 192, 0.2)' }] },
        options: {
            responsive: true,
            plugins: {
                tooltip: { enabled: true }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    akbChart = new Chart(ctxAkb, {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Nilai AKB', data: [], borderColor: 'rgba(255, 99, 132, 1)', backgroundColor: 'rgba(255, 99, 132, 0.2)' }] },
        options: {
            responsive: true,
            plugins: {
                tooltip: { enabled: true }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    updateChart('aki', selectedPuskesmasId);
    updateChart('akb', selectedPuskesmasId);
});
</script>
<script>
    function toggleTooltip(id) {
        const tooltip = document.getElementById(id);
        tooltip.classList.toggle("hidden");
        document.querySelectorAll("[id^='tooltip']").forEach(el => {
            if (el.id !== id) el.classList.add("hidden");
        });
    }
</script>
@endsection
