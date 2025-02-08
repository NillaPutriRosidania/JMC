@extends('layouts.main')

@section('title', 'JMC')

@section('content')
    <section class="pt-36 pb-36 land" id="home" class="section_home">
        <div class="container">
            <div class="flex flex-wrap">
                <div class="w-full self-center px-4 lg:w-1/2">
                    <h1 class="font-bold text-slate-50 px-4 py-6 text-3xl top-56 md:-top-10 md:text-6xl md:px-10">
                        Jember Maternal Cluster</h1>
                    <p class="font-normal text-slate-50 text-sm px-4 py-4 mb-12 md:text-lg md:px-10 md:mt-15 md:mb-10">
                        Sebuah inovasi untuk mendukung pengambilan keputusan berbasis data dan meningkatkan layanan
                        kesehatan masyarakat
                    </p>
                    <a href="{{ route('kmeans_akb.index') }}"
                        class="font-normal text-sm py-2 px-7 md:text-base md:py-3 md:px-10 bg-slate-50 text-dark border-collapse rounded-lg md:ml-11 ml-4 hover:bg-transparent hover:text-white hover:border hover:border-white duration-500">Analisis
                        Sekarang</a>
                </div>
                <div class="w-full self-end px-4 lg:w-1/2">
                    <div class="relative mt-10 lg:mt-10 lg:right-0">
                        <div class="image">
                            <img src="{{ asset('assets//img/grafismaternal1.png') }}" alt="JMC"
                                class="animate-wiggle" />
                        </div>
                    </div>
                    <span class="absolute -bottom-0 -z-10 -top-1 left-1/2 -translate-x-1/2 items-center justify-center">
                        <svg width="1500" height="900" viewBox="0 0 1682 739" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 96.575C0 51.3202 0 28.6928 14.0589 14.6339C28.1177 0.575012 50.7452 0.575012 96 0.575012H1586C1631.25 0.575012 1653.88 0.575012 1667.94 14.6339C1682 28.6928 1682 51.3202 1682 96.575V138.575C1682 421.418 1682 562.839 1594.13 650.707C1506.26 738.575 1364.84 738.575 1082 738.575H96C50.7452 738.575 28.1177 738.575 14.0589 724.516C0 710.457 0 687.83 0 642.575V96.575Z"
                                fill="url(#paint0_linear_21_19)" />
                            <defs>
                                <linearGradient id="paint0_linear_21_19" x1="119" y1="105.125" x2="740.637"
                                    y2="1427.47" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FF0000" />
                                    <stop offset="1" stop-color="#FF7878" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </section>
    <section class="lg:pt-36 pb-32 land" id="tentang">
        <div class="container">
            <div class="flex flex-wrap lg:flex-nowrap">
                <div class="w-full px-4 lg:w-1/2 lg:mr-10">
                    <div class="mx-auto text-center mb-16">
                        <h3 class="font-bold text-center text-dark text-3xl mb-3 lg:text-start">Tentang Kami</h3>
                        <p class="text-center mb-5 lg:text-start">
                            Proyek ini bertujuan untuk memetakan angka kematian ibu dan bayi di Kabupaten Jember dengan
                            memanfaatkan metode K-Means Clustering yang diterapkan pada Sistem Informasi Geografis (SIG).
                            Dengan pendekatan ini, data kesehatan dapat divisualisasikan secara interaktif, memungkinkan
                            identifikasi wilayah dengan risiko tinggi secara lebih efektif
                        </p>
                    </div>
                </div>
                <div class="w-full px-4">
                    <div class="flex flex-wrap items-center justify-center lg:flex-nowrap lg:-mt-20">
                        <!-- Card 1 -->
                        <div
                            class="group relative flex justify-center items-center bg-white drop-shadow-2xl w-2/3 h-[300px] py-10 mb-20 rounded-3xl lg:w-1/4 lg:mr-12 perspective">
                            <div class="flip-card relative w-full h-full transition-transform duration-700">
                                <!-- Front Side -->
                                <div class="absolute inset-0 backface-hidden flex flex-col items-center justify-center">
                                    <img src="{{ asset('assets/img/card1.png') }}" alt="card1" height="200px"
                                        width="180px" class="flex items-center justify-center" />
                                    <h5 class="text-center text-lg mt-4 text-dark font-bold w-9/12">Analisis Spasial</h5>
                                </div>
                                <!-- Back Side -->
                                <div
                                    class="absolute inset-0 backface-hidden rotate-y-180 flex items-center justify-center bg-white px-6">
                                    <p class="text-center text-sm text-gray-700">Mengidentifikasi pola kematian ibu dan bayi
                                        berdasarkan wilayah.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div
                            class="group relative flex justify-center items-center bg-white drop-shadow-2xl w-2/3 h-[300px] py-10 mb-20 rounded-3xl lg:w-1/4 lg:mr-12 lg:mt-48 perspective">
                            <div class="flip-card relative w-full h-full transition-transform duration-700">
                                <!-- Front Side -->
                                <div class="absolute inset-0 backface-hidden flex flex-col items-center justify-center">
                                    <img src="{{ asset('assets/img/card2.png') }}" alt="card2" height="200px"
                                        width="150px" class="flex items-center justify-center" />
                                    <h5 class="text-center text-lg mt-4 mx-3 text-dark font-bold">Tindakan Berbasis Data
                                    </h5>
                                </div>
                                <!-- Back Side -->
                                <div
                                    class="absolute inset-0 backface-hidden rotate-y-180 flex items-center justify-center bg-white px-6">
                                    <p class="text-center text-sm text-gray-700">Mendukung pengambilan keputusan yang lebih
                                        tepat bagi pemerintah dan tenaga kesehatan.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div
                            class="group relative flex justify-center items-center bg-white drop-shadow-2xl w-2/3 h-[300px] py-10 mb-20 rounded-3xl lg:w-1/4 perspective">
                            <div class="flip-card relative w-full h-full transition-transform duration-700">
                                <!-- Front Side -->
                                <div class="absolute inset-0 backface-hidden flex flex-col items-center justify-center">
                                    <img src="{{ asset('assets/img/card3.png') }}" alt="card3" height="200px"
                                        width="200px" class="flex items-center justify-center" />
                                    <h5 class="text-center text-lg mt-4 mx-3 text-dark font-bold">Akses Mudah</h5>
                                </div>
                                <!-- Back Side -->
                                <div
                                    class="absolute inset-0 backface-hidden rotate-y-180 flex items-center justify-center bg-white px-6">
                                    <p class="text-center text-sm text-gray-700">Informasi yang dapat diakses oleh
                                        masyarakat dan pihak terkait.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-36 pb-32 land bg-secondary" id="layanan">
        <div class="container">
            <div class="w-full px-4">
                <div class="mx-auto text-center mb-16">
                    <h4 class="font-semibold text-lg text-primary mb-2">Pilihan</h4>
                    <h3 class="font-bold text-dark text-3xl mb-4">FITUR</h3>
                    <p class="font-medium text-md text-gray-50 md:text-lg">Jember Maternal Cluster memiliki dua fitur utama
                        yang
                        berfungsi
                    <p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center">
                <!-- Menu Visualisasi dengan GIS -->
                <div class="w-full px-4 lg:w-1/2 xl:w-1/3">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-10">
                        <div class="pt-4 px-16">
                            <img width="360" height="200" src="{{ asset('assets/img/logo_pemetaan.png') }}"
                                alt="Visualisasi GIS" class="w-full" />
                        </div>
                        <div class="py-8 px-6">
                            <h5>
                                <a href="#layanan"
                                    class="block mb-3 font-semibold text-xl text-dark hover:text-primary truncate">
                                    VISUALISASI DENGAN GIS
                                </a>
                            </h5>
                            <p class="font-medium text-base text-secondary mb-6">
                                Aplikasi "Jember Maternal Cluster" menyediakan fitur visualisasi berbasis Sistem Informasi Geografis (SIG)
                                untuk membantu pengguna memahami pola distribusi angka kematian ibu dan bayi di Kabupaten Jember.
                                <span class="hidden-text">
                                    Dengan teknologi GIS, data yang diperoleh dapat divisualisasikan dalam bentuk peta interaktif,
                                    sehingga mempermudah analisis dan pengambilan keputusan yang lebih efektif.
                                </span>
                            </p>
                            <span class="read-more-btn">Baca Selengkapnya</span>
                        </div>
                    </div>
                </div>

                <!-- Menu Pemetaan Angka Kematian -->
                <div class="w-full px-4 lg:w-1/2 xl:w-1/3">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-10">
                        <div class="pt-4">
                            <img width="360" height="200" src="{{ asset('assets/img/analisis.png') }}"
                                alt="Pemetaan" class="w-full" />
                        </div>
                        <div class="py-8 px-6">
                            <h5>
                                <a href="#layanan"
                                    class="block mb-3 font-semibold text-xl text-dark hover:text-primary truncate">
                                    PEMETAAN ANGKA KEMATIAN
                                </a>
                            </h5>
                            <p class="font-medium text-base text-secondary mb-6">
                                Aplikasi ini menggunakan metode K-Means Clustering untuk menganalisis dan mengidentifikasi
                                area dengan tingkat risiko tinggi di Kabupaten Jember.
                                <span class="hidden-text">
                                    Data yang diolah meliputi lokasi geografis dan jumlah kematian.
                                    Dengan visualisasi berbasis GIS, pengguna dapat memahami pola dan tren
                                    yang membantu pengambilan keputusan dalam meningkatkan kesehatan maternal dan neonatal.
                                </span>
                            </p>
                            <span class="read-more-btn">Baca Selengkapnya</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="pt-36 pb-32 land" id="carakerja">
        <div class="container">
            <div
                class="flex flex-wrap flex-col bg-white w-full rounded-xl drop-shadow-2xl overflow-hidden mb-10 px-4 py-8">
                <h3 class="font-bold text-dark text-3xl mb-7 lg:text-5xl lg:mt-10 lg:-mb-30 lg:ml-12">Cara Kerja K-Means
                    Clustering</h3>
                <div class="lg:flex lg:flex-row lg:justify-between lg:-mt-16">
                    <div
                        class="w-full flex items-start lg:w-1/2 lg:flex-nowrap lg:justify-center lg:items-center lg:mt-20">
                        <div class="w-full h-full flex flex-col lg:ml-12">
                            <div class="flex flex-wrap flex-row w-full justify-between mb-10">
                                <div class="flex items-center justify-between w-full h-12">
                                    <p class="w-3/4 lg:text-xl">1. Tentukan jumlah cluster (k) yang diinginkan.</p>
                                    <div
                                        class="justify-end -right-1/4 self-end text-center border-4 bg-primary drop-shadow-xl border-primary h-full w-12 justify-items-center items-center">
                                        <span class="text-center font-bold text-3xl text-white">01</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap flex-row w-full justify-between mb-10">
                                <div class="flex items-center justify-between w-full h-12">
                                    <p class="w-3/4 lg:text-xl">2. Inisialisasi centroid secara acak untuk masing-masing
                                        cluster.</p>
                                    <div
                                        class="justify-end -right-1/4 self-end text-center border-2 bg-white drop-shadow-xl border-primary h-full w-12 justify-items-center items-center">
                                        <span class="text-center font-bold text-3xl text-primary items-center">02</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap flex-row w-full justify-between mb-10">
                                <div class="flex items-center justify-between w-full h-12">
                                    <p class="w-3/4 lg:text-xl">3. Hitung jarak setiap data ke centroid terdekat
                                        menggunakan rumus Euclidean Distance.</p>
                                    <div
                                        class="justify-end -right-1/4 self-end text-center border-2 bg-white drop-shadow-xl border-primary h-full w-12 justify-items-center items-center">
                                        <span class="text-center font-bold text-3xl text-primary items-center">03</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap flex-row w-full justify-between mb-10">
                                <div class="flex items-center justify-between w-full h-12">
                                    <p class="w-3/4 lg:text-xl">4. Kelompokkan data ke dalam cluster berdasarkan jarak
                                        terdekat.</p>
                                    <div
                                        class="justify-end -right-1/4 self-end text-center border-2 bg-white drop-shadow-xl border-primary h-full w-12 justify-items-center items-center">
                                        <span class="text-center font-bold text-3xl text-primary items-center">04</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap flex-row w-full justify-between mb-10">
                                <div class="flex items-center justify-between w-full h-12">
                                    <p class="w-3/4 lg:text-xl">5. Perbarui posisi centroid dengan menghitung rata-rata
                                        posisi data dalam setiap cluster.</p>
                                    <div
                                        class="justify-end -right-1/4 self-end text-center border-2 bg-white drop-shadow-xl border-primary h-full w-12 justify-items-center items-center">
                                        <span class="text-center font-bold text-3xl text-primary items-center">05</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap flex-row w-full justify-between mb-10">
                                <div class="flex items-center justify-between w-full h-12">
                                    <p class="w-3/4 lg:text-xl">6. Ulangi langkah 3 hingga 5 sampai centroid tidak berubah
                                        atau jumlah iterasi maksimum tercapai.</p>
                                    <div
                                        class="justify-end -right-1/4 self-end text-center border-2 bg-white drop-shadow-xl border-primary h-full w-12 justify-items-center items-center">
                                        <span class="text-center font-bold text-3xl text-primary items-center">06</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex flex-wrap w-full justify-end mb-10 lg:w-1/2 lg:items-end lg:flex-nowrap lg:-mt-10 px-10">
                        <img src="{{ asset('assets/img/logo_kmeans.png') }}" alt="cara-kerja-kmeans" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="bg-white p-4 mb-4 border-2 border-gray-200 rounded-lg">
        <div class="relative z-0">
            <div id="map"></div>
        </div>        
    </div>
    <div id="chat-icon" class="fixed bottom-5 right-5 bg-red-500 text-white p-5 text-4xl rounded-full shadow-lg cursor-pointer z-10">
        💬
    </div>    
    <div id="chat-container" class="fixed bottom-16 right-5 w-80 h-96 hidden z-20">
        <iframe width="350" height="430" allow="microphone;" src="https://console.dialogflow.com/api-client/demo/embedded/74ef3aa5-da2f-458a-82bf-da699b3d8ab5"></iframe>
    </div>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Berita Terbaru</h2>
    
        @foreach ($latestNews as $item)
            <!-- Bungkus dengan tag <a> untuk membuatnya jadi link ke detail berita -->
            <a href="{{ route('berita.show', $item->id) }}" class="flex items-start bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="News Image" class="w-40 h-40 object-cover">
    
                <div class="p-4 flex-1">
                    <p class="text-red-600 font-semibold text-sm">
                        {{ $item->kategori }} <span class="text-gray-500 ml-2">{{ $item->created_at->format('d M Y') }}</span>
                    </p>
    
                    <h3 class="text-lg font-bold mt-1">{{ $item->judul }}</h3>
                    <p class="text-sm text-gray-700 mt-1">
                        {{ Str::limit($item->isi, 150) }}
                    </p>
    
                    <div class="mt-3 flex flex-wrap">
                        @foreach (explode(',', $item->keyword) as $keyword)
                            <span class="bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-1 rounded-full mr-2 mb-2">{{ $keyword }}</span>
                        @endforeach
                    </div>
                </div>
            </a>
        @endforeach
    
        <!-- Pagination -->
        <div class="mt-4 flex justify-center">
            {{ $latestNews->links() }}
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const readMoreButtons = document.querySelectorAll('.read-more-btn');

        readMoreButtons.forEach(button => {
            button.addEventListener('click', function() {
                const hiddenText = this.previousElementSibling.querySelector('.hidden-text');
                hiddenText.style.display = hiddenText.style.display === 'none' ? 'inline' :
                    'none';
                this.textContent = hiddenText.style.display === 'none' ? 'Baca Selengkapnya' :
                    'Tutup';
            });
        });
    });

    function toggleFlip(card) {
        const cardContent = card.querySelector('.relative');
        cardContent.classList.toggle('rotate-y-180');
    }

    document.addEventListener("DOMContentLoaded", function() {

        var map = L.map('map').setView([-8.1845, 113.6681], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        function generateColor(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 5) - hash);
            }
            let color = '#';
            for (let i = 0; i < 3; i++) {
                color += ('00' + ((hash >> (i * 8)) & 0xFF).toString(16)).slice(-2);
            }
            return color;
        }

        fetch('/api/kecamatan')
            .then(response => response.json())
            .then(data => {
                data.forEach(kecamatan => {
                    try {
                        L.geoJSON(JSON.parse(kecamatan.geojson), {
                            style: function() {
                                return {
                                    color: generateColor(kecamatan.nama_kecamatan),
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chatIcon = document.getElementById("chat-icon");
            const chatContainer = document.getElementById("chat-container");
            const chatFrame = document.getElementById("chat-frame");
            chatIcon.addEventListener("click", function () {
                chatContainer.classList.toggle("hidden");
                if (!chatFrame.src) {
                    chatFrame.src = "https://console.dialogflow.com/api-client/demo/embedded/74ef3aa5-da2f-458a-82bf-da699b3d8ab5";
                }
            });
            document.addEventListener("click", function (event) {
                if (!chatContainer.contains(event.target) && !chatIcon.contains(event.target)) {
                    chatContainer.classList.add("hidden");
                }
            });
        });
    </script>
