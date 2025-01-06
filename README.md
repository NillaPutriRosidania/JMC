# Jember Maternal Cluster (JMC)

**Jember Maternal Cluster (JMC)** adalah aplikasi berbasis web yang dirancang untuk memetakan daerah dengan angka kematian ibu dan bayi yang tinggi di Kabupaten Jember menggunakan metode K-Means Clustering. Aplikasi ini bertujuan untuk memudahkan pemerintah dan masyarakat dalam memantau, menganalisis, dan memvisualisasikan data terkait kesehatan ibu dan bayi.

## Fitur Utama

1. **Clustering Daerah Tinggi Kematian Ibu dan Bayi**
   - Menggunakan metode K-Means Clustering untuk mengelompokkan daerah berdasarkan angka kematian ibu dan bayi.
   - Terdapat 2 pilihan jumlah klaster: 3 dan 5 klaster.
     - **3 Klaster**: Tinggi, Sedang, Rendah.
     - **5 Klaster**: Sangat Tinggi, Tinggi, Sedang, Rendah, Sangat Rendah.

2. **Pemetaan dan Visualisasi Data**
   - Memvisualisasikan hasil clustering pada peta menggunakan Sistem Informasi Geografis (SIG).
   - Setiap klaster ditampilkan dengan warna berbeda untuk memudahkan identifikasi area dengan risiko kematian ibu dan bayi tinggi.

3. **Dashboard Interaktif**
   - Menyajikan analisis dan data terkait kematian ibu dan bayi secara interaktif.
   - Menampilkan grafik dan tabel yang mempermudah pemahaman data untuk pengambil keputusan.

4. **Manajemen Data Puskesmas**
   - Pengguna dapat mengelola data puskesmas, termasuk menambah, mengedit, dan menghapus data puskesmas yang digunakan dalam analisis.

5. **Export Data**
   - Menyediakan fitur untuk mengekspor data clustering dan peta dalam format CSV dan PDF.

## Tampilan Website

Aplikasi ini dirancang dengan antarmuka pengguna (UI) yang sederhana namun informatif. Berikut adalah tampilan yang disediakan:

### 1. **Halaman Utama**
   - **Peta Interaktif**: Menampilkan peta Kabupaten Jember dengan tanda lokasi puskesmas dan area dengan angka kematian ibu dan bayi tinggi berdasarkan klaster.
   - **Tabel Data**: Menampilkan tabel yang berisi data puskesmas dan klaster daerah kematian ibu dan bayi, lengkap dengan informasi terkait.

### 2. **Halaman Clustering**
   - **Form Pilihan Klaster**: Pengguna dapat memilih jumlah klaster (3 atau 5) untuk menganalisis data.
   - **Proses Clustering**: Setelah pemilihan, aplikasi akan menjalankan algoritma K-Means untuk mengelompokkan daerah-daerah sesuai dengan data kematian ibu dan bayi.

### 3. **Halaman Visualisasi**
   - **Grafik**: Menyediakan grafik batang atau pie chart untuk menunjukkan distribusi klaster di daerah-daerah Kabupaten Jember.
   - **Peta**: Peta interaktif yang menunjukkan lokasi puskesmas dan klaster warna yang menunjukkan tingkat kematian ibu dan bayi.

### 4. **Halaman Manajemen Puskesmas**
   - **Tambah/Edit Hapus Data Puskesmas**: Pengguna dapat menambah, mengedit, atau menghapus data puskesmas yang digunakan dalam analisis clustering.
   - **Data Input**: Formulir untuk memasukkan data terkait kematian ibu dan bayi pada setiap puskesmas.

### 5. **Export dan Cetak**
   - Pengguna dapat mengekspor hasil analisis dan peta ke dalam format CSV untuk data dan PDF untuk laporan visualisasi.

## Cara Menjalankan Aplikasi

1. **Clone Repository**
    ```bash
    git clone https://github.com/username/repository.git
    ```

2. **Masuk ke Folder Proyek**
    ```bash
    cd jmc
    ```

3. **Install Dependensi**
    ```bash
    composer install
    ```

4. **Salin dan Sesuaikan File .env**
    ```bash
    cp .env.example .env
    ```
    Sesuaikan konfigurasi database pada file `.env`.

5. **Generate Kunci Aplikasi**
    ```bash
    php artisan key:generate
    ```

6. **Migrasi dan Seeder Database**
    ```bash
    php artisan migrate --seed
    ```

7. **Jalankan Server Lokal**
    ```bash
    php artisan serve
    ```

Akses aplikasi melalui browser di `http://localhost:8000`.

## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan ikuti pedoman kontribusi dalam [Panduan Kontribusi Laravel](https://laravel.com/docs/contributions).

## Lisensi

Aplikasi ini dilisensikan di bawah [lisensi MIT](https://opensource.org/licenses/MIT).

## Kerentan Keamanan

Jika Anda menemukan kerentan keamanan pada aplikasi ini, silakan kirimkan email kepada [taylor@laravel.com](mailto:taylor@laravel.com). Semua kerentan akan ditangani dengan cepat.

## Kode Etik

Pastikan untuk mengikuti [Kode Etik](https://laravel.com/docs/contributions#code-of-conduct) saat berkontribusi pada proyek ini agar komunitas tetap inklusif dan ramah.