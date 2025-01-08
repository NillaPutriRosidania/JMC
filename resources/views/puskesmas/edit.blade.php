@extends('layouts.app')

@section('title', 'Edit Puskesmas')

@section('content')

    <div class="bg-white p-2 mb-4 border-2 border-white rounded-lg">
        <div class="flex justify-center items-center rounded-lg border-gray-300 h-4">
            <h2 class="flex items-center justify-center text-sm text-center lg:text-lg font-bold uppercase text-red-600">
                Edit Puskesmas
            </h2>
        </div>
    </div>

    <section class="bg-white py-4 rounded-lg mb-4 antialiased md:py-8">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-5xl">
                <form action="{{ route('puskesmas.update', $puskesmas->id_puskesmas) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="nama_puskesmas" class="block text-sm font-medium text-gray-700">Nama Puskesmas</label>
                        <input type="text" id="nama_puskesmas" name="nama_puskesmas"
                            value="{{ old('nama_puskesmas', $puskesmas->nama_puskesmas) }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        @error('nama_puskesmas')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="id_kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <select id="id_kecamatan" name="id_kecamatan"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            @foreach ($kecamatan as $kec)
                                <option value="{{ $kec->id_kecamatan }}"
                                    {{ old('id_kecamatan', $puskesmas->id_kecamatan) == $kec->id_kecamatan ? 'selected' : '' }}>
                                    {{ $kec->nama_kecamatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kecamatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="alamat_puskesmas" class="block text-sm font-medium text-gray-700">Alamat
                            Puskesmas</label>
                        <input type="text" id="alamat_puskesmas" name="alamat_puskesmas"
                            value="{{ old('alamat_puskesmas', $puskesmas->alamat_puskesmas) }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        @error('alamat_puskesmas')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="lat" class="block text-sm font-medium text-gray-700">Latitude</label>
                        <input type="text" id="lat" name="lat" value="{{ old('lat', $puskesmas->lat) }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        @error('lat')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="long" class="block text-sm font-medium text-gray-700">Longitude</label>
                        <input type="text" id="long" name="long" value="{{ old('long', $puskesmas->long) }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        @error('long')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('puskesmas.index') }}"
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
