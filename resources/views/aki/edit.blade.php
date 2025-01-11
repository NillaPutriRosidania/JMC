@extends('layouts.app')

@section('title', 'Edit AKI')

@section('content')

    <div class="bg-white p-2 mb-4 border-2 border-white rounded-lg">
        <div class="flex justify-center items-center rounded-lg border-gray-300 h-4">
            <h2 class="flex items-center justify-center text-sm text-center lg:text-lg font-bold uppercase text-red-600">
                Edit AKI
            </h2>
        </div>
    </div>

    <section class="bg-white py-4 rounded-lg mb-4 antialiased md:py-8">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-5xl">
                <form action="{{ route('aki.update', $AKI->id_data_aki) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Tahun (readonly) --}}
                    <div class="mb-4">
                        <label for="id_tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                        <input type="text" id="id_tahun" name="id_tahun" value="{{ $AKI->tahun->tahun }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                            readonly>
                    </div>

                    {{-- Nama Puskesmas (readonly) --}}
                    <div class="mb-4">
                        <label for="id_puskesmas" class="block text-sm font-medium text-gray-700">Nama Puskesmas</label>
                        <input type="text" id="id_puskesmas" name="id_puskesmas" value="{{ $AKI->puskesmas->nama_puskesmas }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                            readonly>
                    </div>

                    {{-- Nama Kecamatan (readonly) --}}
                    <div class="mb-4">
                        <label for="id_kecamatan" class="block text-sm font-medium text-gray-700">Nama Kecamatan</label>
                        <input type="text" id="id_kecamatan" name="id_kecamatan" value="{{ $AKI->kecamatan->nama_kecamatan }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                            readonly>
                    </div>

                    {{-- Jumlah AKI --}}
                    <div class="mb-4">
                        <label for="aki" class="block text-sm font-medium text-gray-700">Jumlah AKI</label>
                        <input type="number" id="aki" name="aki" value="{{ old('aki', $AKI->aki) }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        @error('aki')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-between items-center">
                        <a href="{{ route('aki.index') }}"
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
