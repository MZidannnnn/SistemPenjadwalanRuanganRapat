<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Custom gradient color based on your screenshot */
        .bg-custom-gradient {
            background: linear-gradient(to right, #1540AA, #0646E7);
        }
    </style>
</head>
<body class="bg-gray-100">

    {{-- Topbar Navigation --}}
    <nav class="bg-custom-gradient text-white shadow-md">
        <div class="container mx-auto px-6 py-2 flex justify-between items-center">
            
            {{-- Logo dan Judul Kiri --}}
            <div class="flex items-center space-x-4">
                {{-- Ukuran logo diperbesar --}}
                <img src="{{ asset('images/logo-pemkot.png') }}" alt="Logo" class="h-12 w-12">
                <a href="/dashboard" class="text-3xl font-bold">Dashboard</a>
            </div>

            {{-- Menu Tengah --}}
            <div class="hidden md:flex items-center space-x-10">
                {{-- Teks menu dipindah ke bawah ikon --}}
                <a href="#" class="flex flex-col items-center hover:text-gray-300 transition duration-150 text-xs">
                    <img src="{{ asset('images/icons8-scheduling-32 (1).png') }}" alt="Pemesanan" class="h-6 w-6 mb-1">
                    <span>Pemesanan</span>
                </a>
                <a href="#" class="flex flex-col items-center hover:text-gray-300 transition duration-150 text-xs">
                    <img src="{{ asset('images/icons8-meeting-room-50.png') }}" alt="Ruangan" class="h-6 w-6 mb-1">
                    <span>Ruangan</span>
                </a>
                <a href="#" class="flex flex-col items-center hover:text-gray-300 transition duration-150 text-xs">
                    <img src="{{ asset('images/icons8-user-24.png') }}" alt="User" class="h-6 w-6 mb-1">
                    <span>User</span>
                </a>
            </div>

            {{-- Tombol Keluar Kanan --}}
            <div>
                {{-- Kotak border pada tombol Keluar dihilangkan --}}
                <a href="#" class="flex items-center space-x-2 hover:text-gray-300 transition duration-150">
                    <img src="{{ asset('images/icons8-logout-24.png') }}" alt="Keluar" class="h-5 w-5">
                    <span>Keluar</span>
                </a>
            </div>

        </div>
    </nav>

    {{-- Main Content Area --}}
    <main class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        {{-- Tempat untuk konten Anda selanjutnya, seperti kalender, tabel, dll. --}}
    </main>

</body>
</html>