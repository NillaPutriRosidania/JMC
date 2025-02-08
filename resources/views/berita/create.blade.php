@extends('layouts.app')

@section('title', 'Tambah Berita')

@section('content')
<div class="bg-white p-2 mb-4 border-2 border-white rounded-lg">
    <div class="flex justify-center items-center rounded-lg border-gray-300 h-4">
        <h2 class="flex items-center justify-center text-sm text-center lg:text-lg font-bold uppercase text-red-600">
            Tambah Berita
        </h2>
    </div>
</div>

<section class="bg-white py-4 rounded-lg mb-4 antialiased md:py-8">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mx-auto max-w-5xl">
            <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Judul -->
                <div class="mb-4">
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    @error('judul')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Isi Berita -->
                <div class="mb-4">
                    <label for="isi" class="block text-sm font-medium text-gray-700">Isi Berita</label>
                    <textarea id="isi" name="isi" rows="5"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ old('isi') }}</textarea>
                    @error('isi')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div class="mb-4">
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Berita</label>
                    <input type="file" id="gambar" name="gambar"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    @error('gambar')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-4">
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <input type="text" id="kategori" name="kategori" value="{{ old('kategori') }}"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    @error('kategori')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kata Kunci -->
                <div class="mb-4">
                    <label for="kata_kunci" class="block text-sm font-medium text-gray-700">Kata Kunci (Opsional)</label>
                    <textarea id="kata_kunci" name="kata_kunci" rows="3"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ old('kata_kunci') }}</textarea>
                    @error('kata_kunci')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('berita.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Kembali
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>

@endsection