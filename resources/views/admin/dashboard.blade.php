{{-- Misalkan Anda punya layout utama --}}
{{-- @extends('layouts.app') --}}

@section('content')
    <div class="container">
        
        {{-- Judul ini akan dilihat oleh SEMUA role --}}
        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

        {{-- Pesan sambutan ini juga dilihat oleh SEMUA role --}}
        <p class="mb-6">Selamat Datang, {{ auth()->user()->name }}!</p>

        {{-- ====================================================== --}}
        
        {{-- KONTEN KHUSUS UNTUK ADMIN --}}
        @if(auth()->user()->role == 'admin')
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                <p class="font-bold">Panel Admin</p>
                <p>Anda login sebagai Admin. Anda bisa mengelola User dan Ruangan.</p>
            </div>
            
            {{-- Tambahkan widget atau kartu khusus admin di sini --}}
            {{-- Contoh: Kartu Statistik Jumlah Pengguna --}}

        @endif

        {{-- ====================================================== --}}
        
        {{-- KONTEN KHUSUS UNTUK SKPD --}}
        @if(auth()->user()->role == 'skpd')
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">Panel SKPD</p>
                <p>Anda bisa memulai pemesanan ruangan dari sini.</p>
            </div>
            
            {{-- Tambahkan widget atau kartu khusus SKPD di sini --}}
            {{-- Contoh: Tombol "Buat Peminjaman Baru" --}}

        @endif
        
        {{-- ====================================================== --}}

        {{-- KONTEN BERSAMA (dilihat oleh Admin dan SKPD) --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">Jadwal Ruangan Hari Ini</h2>
            {{-- Tabel atau kalender jadwal bisa ditampilkan di sini --}}
        </div>
        
    </div>
@endsection