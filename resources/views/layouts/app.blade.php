<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Penjadwalan Ruangan')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100">




    {{-- Area Konten Utama --}}
    <main class="container mx-auto p-6">
        {{-- Di sinilah konten dari halaman lain (seperti dashboard) akan dimasukkan --}}
        @yield('content')
    </main>

    {{-- Slot untuk script tambahan dari halaman lain --}}
    @stack('scripts')
</body>

</html>
