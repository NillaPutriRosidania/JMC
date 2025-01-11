@extends('layouts.app')

@section('title', 'AKI')

@section('content')
    <div class="bg-white p-4 mb-6 border-2 border-white rounded-lg shadow">
        <div class="text-center">
            <h2 class="text-lg lg:text-xl font-bold uppercase text-red-600">
                Tambah AKI
            </h2>
        </div>
    </div>
    <div class="flex items-center w-full md:w-auto mb-6">
        <form method="POST" action="{{ route('aki.store') }}" id="tahunAkiForm">
            @csrf
            <label for="tahun_aki" class="mr-2 text-sm font-semibold">Pilih Tahun:</label>
            <select name="tahun_aki" id="tahun_aki" class="p-2 border border-gray-300 rounded-lg">
                <option value="">Pilih Tahun</option>
                @foreach ($tahunAki as $tahun)
                    <option value="{{ $tahun->id_tahun }}">{{ $tahun->tahun }}</option>
                @endforeach
            </select>

            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Pilih
            </button>
        </form>
    </div>
    <form method="POST" action="{{ route('aki.store') }}">
        @csrf
        <input type="hidden" name="id_tahun" id="hidden_tahun">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 border border-gray-300 rounded-lg">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Nama Puskesmas</th>
                        <th class="px-4 py-2 border">Jumlah AKI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($puskesmas as $index => $item)
                        <tr class="bg-white border-b">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $item->nama_puskesmas }}</td>
                            <td class="px-4 py-2 border">
                                <input type="hidden" name="id_puskesmas[]" value="{{ $item->id_puskesmas }}">
                                <input type="hidden" name="id_kecamatan[]" value="{{ $item->id_kecamatan }}">
                                <input type="number" name="aki[{{ $item->id_puskesmas }}]"
                                    class="w-full p-2 border border-gray-300 rounded-lg" min="0"
                                    placeholder="Masukkan jumlah AKI">
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-gray-100 font-bold">
                        <td colspan="2" class="px-4 py-2 text-right">Total AKI:</td>
                        <td class="px-4 py-2 border">
                            <input type="text" id="total_aki" readonly
                                class="w-full p-2 bg-gray-200 border border-gray-300 rounded-lg">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between items-center pt-8">
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

    {{-- Script untuk menghitung total AKI --}}
    <script>
        const akiInputs = document.querySelectorAll('input[name^="aki"]');
        const totalAkiInput = document.getElementById('total_aki');
        const tahunAkiSelect = document.getElementById('tahun_aki');
        const hiddenTahunInput = document.getElementById('hidden_tahun');

        akiInputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        function calculateTotal() {
            let total = 0;
            akiInputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            totalAkiInput.value = total;
        }
        tahunAkiSelect.addEventListener('change', function() {
            hiddenTahunInput.value = tahunAkiSelect.value;
        });
    </script>
@endsection
