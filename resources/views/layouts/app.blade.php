<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'JMC')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Masukkan CSS yang ada di sini */
        </style>
    @endif
</head>

<body>
    <div class="antialiased  dark:bg-white">
        <main class="p-4 md:ml-64 h-auto pt-20">
            @include('partials.app.navbar')
            @include('partials.app.sidebar')
            @yield('content')
            {{-- @include('partials.app.footer') --}}
        </main>
    </div>
    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts') <!-- For pushing additional scripts if needed -->

    <!-- SweetAlert Trigger Script -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                timer: 2500
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                timer: 2500
            });
        </script>
    @elseif(session('confirm'))
        <script>
            Swal.fire({
                icon: 'question',
                title: 'Yakin?',
                text: '{{ session('confirm') }}',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan aksi yang diinginkan jika yakin
                    window.location.href = '{{ session('confirm_route') }}';
                }
            });
        </script>
    @endif
</body>

</html>
