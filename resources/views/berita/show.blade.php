@extends(Auth::check() ? 'layouts.app' : 'layouts.dashboardguest')

@section('title', 'Detail Berita')

@section('content')
<div class="max-w-4xl mx-auto my-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800">{{ $berita->judul }}</h1>
        <p class="text-gray-600 text-sm mb-4">Kategori: {{ $berita->kategori }}</p>

        @if($berita->gambar)
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" class="mb-4 rounded-md">
        @endif

        <p class="text-gray-700">{{ $berita->isi }}</p>

        <div class="mt-4">
            <a  href="/" class="text-blue-600 hover:text-blue-800">Kembali</a>
        </div>        
    </div>
</div>
@endsection