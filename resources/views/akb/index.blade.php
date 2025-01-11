@extends('layouts.app')

@section('title', 'AKB')

@section('content')

    <div class="bg-white p-4 mb-6 border-2 border-white rounded-lg shadow">
        <div class="text-center">
            <h2 class="text-lg lg:text-xl font-bold uppercase text-red-600">
                Daftar AKB
            </h2>
        </div>
    </div>
    <div class="mt-6">
        <form method="GET" action="{{ route('akb.index') }}">
            <div class="flex flex-wrap justify-between items-center gap-4 px-4 md:px-6">
                <a href="{{ route('akb.create') }}" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Tambah AKB
                </a>
                <div class="flex items-center w-full md:w-auto">
                    <input type="text" name="search" class="flex-1 w-full p-2 border border-gray-300 rounded-lg"
                        placeholder="Cari berdasarkan nama puskesmas..." value="{{ request('search') }}">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 ml-2">
                        Cari
                    </button>
                </div>

                <div class="flex items-center w-full md:w-auto">
                    <form method="GET" action="{{ route('akb.index') }}">
                        <select name="filter_kecamatan" class="p-2 border border-gray-300 rounded-lg">
                            <option value="Puskesmas" {{ request('filter_kecamatan') === 'Puskesmas' ? 'selected' : '' }}>
                                Puskesmas</option>
                            <option value="Kecamatan" {{ request('filter_kecamatan') === 'Kecamatan' ? 'selected' : '' }}>
                                Kecamatan</option>
                        </select>
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 ml-2">Filter</button>
                    </form>
                </div>

                <div class="flex items-center w-full md:w-auto">
                    <select name="filter_tahun" class="p-2 border border-gray-300 rounded-lg">
                        @php
                            $currentYear = date('Y');
                        @endphp
                        @foreach ($tahunOptions as $id_tahun => $tahun)
                            <option value="{{ $id_tahun }}"
                                {{ request('filter_tahun', $currentYear) == $id_tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    <section class="bg-white py-6 rounded-lg shadow mt-6">
        <div class="mx-auto max-w-screen-xl px-4">
            <div class="overflow-x-auto">
                @if ($AKB->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-red-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No
                                </th>
                                @if (request('filter_kecamatan') !== 'Kecamatan')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Puskesmas</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Kecamatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">AKB
                                </th>
                                @if (request('filter_kecamatan') !== 'Kecamatan')
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                        Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($AKB as $item)
                                <tr class="border-b border-gray-200">
                                    <td class="px-6 py-4 text-gray-900">{{ $loop->iteration }}</td>
                                    @if (request('filter_kecamatan') !== 'Kecamatan')
                                        <td class="px-6 py-4 text-gray-900">{{ $item->puskesmas->nama_puskesmas ?? 'N/A' }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 text-gray-900">
                                        @if (request('filter_kecamatan') === 'Kecamatan')
                                            {{ $item->nama_kecamatan }}
                                        @else
                                            {{ $item->puskesmas->kecamatan->nama_kecamatan }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        @if (request('filter_kecamatan') === 'Kecamatan')
                                            {{ $item->total_akb }}
                                        @else
                                            {{ $item->akb }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            @if (request('filter_kecamatan') === 'Puskesmas')
                                                <a href="{{ route('akb.edit', $item->id_data_akb) }}"
                                                    class="rounded-lg border border-blue-700 px-3 py-2 text-sm font-medium text-blue-700 hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-blue-300">
                                                    Edit
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-6">
                        <h1 class="text-red-600 font-bold">Data AKB masih kosong</h1>
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection
