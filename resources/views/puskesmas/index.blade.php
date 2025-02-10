@extends('layouts.app')

@section('title', 'Puskesmas')

@section('content')

    <div class="bg-white p-2 mb-4 border-2 border-white rounded-lg">
        <div class="flex justify-center items-center rounded-lg border-gray-300 h-4">
            <h2 class="flex items-center justify-center text-sm text-center lg:text-lg font-bold uppercase text-red-600">
                Daftar Puskesmas
            </h2>
        </div>
    </div>

    <div class="mt-4">
        <form method="GET" action="{{ route('puskesmas.index') }}">
            <div class="flex justify-between items-center mx-28">
                <div class="flex gap-2">
                    <a href="{{ route('puskesmas.create') }}" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600">
                        Tambah puskesmas
                    </a>
                    <a href="{{ route('export.puskesmas') }}"
                        class="bg-blue-500 text-white p-2 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-excel text-white"></i>
                    </a>
                </div>
                <div class="flex items-center">
                    <input type="text" name="search" class="w-full p-2 border border-gray-300 rounded-lg mx-4"
                        placeholder="Cari puskesmas..." value="{{ request('search') }}">
                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <section class="bg-white py-4 rounded-lg mb-4 antialiased md:py-8">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-5xl">
                @if ($puskesmas->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-red-600">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Nama puskesmas
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Nama Kecamatan
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Alamat Puskesmas
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Latitude
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Longitude
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($puskesmas as $item)
                                <tr class="border-b border-gray-200">
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $puskesmas->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $item->nama_puskesmas }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $item->kecamatan->nama_kecamatan ?? 'Kecamatan tidak ditemukan' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $item->alamat_puskesmas ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $item->lat ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $item->long ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <form action="{{ route('puskesmas.destroy', $item->id_puskesmas) }}"
                                                method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-lg border border-red-700 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-red-300">
                                                    Hapus
                                                </button>
                                            </form>
                                            <a href="{{ route('puskesmas.edit', $item->id_puskesmas) }}"
                                                class="rounded-lg border border-blue-700 px-3 py-2 text-sm font-medium text-blue-700 hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-blue-300">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-between items-center mt-4">
                        <div>
                            {{ $puskesmas->appends(['search' => request('search')])->links('pagination::tailwind', [
                                'class' => 'flex items-center space-x-2',
                                'next' => 'bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600',
                                'prev' => 'bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600',
                                'active' => 'bg-red-600 text-white px-4 py-2 rounded-lg',
                                'disabled' => 'text-gray-400 cursor-not-allowed',
                            ]) }}
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <h1 class="text-red-600 font-bold">Data puskesmas masih kosong</h1>
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection
