@extends('layouts.app')

@section('title', 'AKB')

@section('content')
    <div class="bg-white p-4 mb-6 border-2 border-white rounded-lg shadow">
        <div class="text-center">
            <h2 class="text-lg lg:text-xl font-bold uppercase text-red-600">
                Tambah AKB
            </h2>
        </div>
    </div>
    <div class="flex items-center w-full md:w-auto mb-6">
        <form method="POST" action="{{ route('akb.store') }}" id="tahunAkbForm">
            @csrf
            <label for="tahun_akb" class="mr-2 text-sm font-semibold">Pilih Tahun:</label>
            <select name="tahun_akb" id="tahun_akb" class="p-2 border border-gray-300 rounded-lg">
                <option value="">Pilih Tahun</option>
                @foreach ($tahunAkb as $tahun)
                    <option value="{{ $tahun->id_tahun }}">{{ $tahun->tahun }}</option>
                @endforeach
            </select>

            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Pilih
            </button>
        </form>
    </div>
    <form method="POST" action="{{ route('akb.store') }}">
        @csrf
        <input type="hidden" name="id_tahun" id="hidden_tahun">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 border border-gray-300 rounded-lg">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Nama Puskesmas</th>
                        <th class="px-4 py-2 border">Jumlah AKB</th>
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
                                <input type="number" name="akb[{{ $item->id_puskesmas }}]"
                                    class="w-full p-2 border border-gray-300 rounded-lg" min="0"
                                    placeholder="Masukkan jumlah AKB">
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-gray-100 font-bold">
                        <td colspan="2" class="px-4 py-2 text-right">Total AKB:</td>
                        <td class="px-4 py-2 border">
                            <input type="text" id="total_akb" readonly
                                class="w-full p-2 bg-gray-200 border border-gray-300 rounded-lg">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between items-center pt-8">
            <a href="{{ route('akb.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Kembali
            </a>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Simpan
            </button>
        </div>
    </form>
    <script>
        const akbInputs = document.querySelectorAll('input[name^="akb"]');
        const totalAkbInput = document.getElementById('total_akb');
        const tahunAkbSelect = document.getElementById('tahun_akb');
        const hiddenTahunInput = document.getElementById('hidden_tahun');

        akbInputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        function calculateTotal() {
            let total = 0;
            akbInputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            totalAkbInput.value = total;
        }
        tahunAkbSelect.addEventListener('change', function() {
            hiddenTahunInput.value = tahunAkbSelect.value;
        });
    </script>
@endsection
