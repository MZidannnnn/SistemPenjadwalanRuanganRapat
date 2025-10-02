@extends('layouts.app')

@section('title', 'Dashboard Admin')


{{--  komponen Navbar --}}
<x-navbar />
{{-- //komponen Navbar --}}

@section('content')

    @push('styles')
        <style>
            .calendar-day {
                min-height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
            }

            .selected-date {
                background-color: #5B8DEF;
                color: white;
                border-radius: 8px;
            }

            .today-date {
                background-color: #EF4444;
                color: white;
                border-radius: 8px;
                font-weight: bold;
            }

            .detail-button {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
        </style>
    @endpush
    <div class="text-center">
        <h1 class="text-3xl font-semibold text-gray-700">Selamat Datang Di Sistem Penjadwalan Ruangan Rapat</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">

        {{-- Card 1 --}}
        <div class="flex items-center justify-between bg-[#0CAADC] text-white rounded-xl p-6 shadow-md">
            <div class="flex flex-col items-center justify-center">
                <h2 class="text-5xl font-bold">31</h2>
                <p class="text-base mt-1">Ruangan Tersedia</p>
            </div>
            <img src="{{ asset('images/icons8-interior-64.png') }}" alt="Ruangan" class="w-20 h-20">
        </div>

        {{-- Card 2 --}}
        <div class="flex items-center justify-between bg-[#1481BA] text-white rounded-xl p-6 shadow-md">
            <div class="flex flex-col items-center justify-center">
                <h2 class="text-5xl font-bold">8</h2>
                <p class="text-base mt-1">Pemesanan Hari Ini</p>
            </div>
            <img src="{{ asset('images/icons8-clock-64.png') }}" alt="Clock" class="w-20 h-20">
        </div>

        {{-- Card 3 --}}
        <div class="flex items-center justify-between bg-[#77B28C] text-white rounded-xl p-6 shadow-md">
            <div class="flex flex-col items-center justify-center">
                <h2 class="text-5xl font-bold">100</h2>
                <p class="text-base mt-1">Total Pemesanan</p>
            </div>
            <img src="{{ asset('images/icons8-calender-64 (1).png') }}" alt="Calendar" class="w-20 h-20">
        </div>

    </div>


    {{-- >> TAMBAHKAN GARIS PEMISAH DI SINI << --}}
    <hr class="my-6 bg-black h-0.5">


    {{-- BAGIAN JADWAL RUANGAN HARI INI --}}
    <div class="mt-8">

       {{-- Ganti seluruh blok header Anda dengan ini --}}
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
    
    {{-- BAGIAN KIRI: Judul dan Tanggal --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Jadwal Ruangan Hari Ini</h2>
        <p id="currentDate" class="text-gray-500 mt-1">Rabu, 1 Oktober 2025</p>
    </div>

    {{-- BAGIAN KANAN: Search dan Tombol --}}
    <div class="w-full sm:w-auto flex flex-col sm:flex-row items-center gap-4">
        
        {{-- Kolom Pencarian --}}
        <div class="relative w-full sm:w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.817-4.817A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </span>
            <input type="text" id="searchInput" placeholder="Cari jadwal..." class="w-full pl-10 pr-4 py-2 border bg-white border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        {{-- Tombol Pesan Ruang Rapat --}}
        <a href="{{ route('pemesanan.index') }}" class="w-full sm:w-auto flex items-center justify-center gap-3 bg-blue-600 text-white font-semibold py-2 pl-2 pr-5 rounded-full hover:bg-blue-700 transition duration-300 shadow-sm">
            <div class="bg-white rounded-full w-6 h-6 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <span>Pesan Ruang Rapat</span>
        </a>

    </div>
</div>


        {{-- Tabel Jadwal --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ruangan</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Lokasi</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waktu Mulai</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waktu Selesai</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-sm font-medium text-gray-900">Command Center</td>
                            <td class="py-4 px-6 text-sm text-gray-500">Blok A</td>
                            <td class="py-4 px-6 text-sm text-gray-500">08:00</td>
                            <td class="py-4 px-6 text-sm text-gray-500">12:00</td>
                            <td class="py-4 px-6 text-sm">
                                <span
                                    class="bg-green-100 text-green-800 px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                    Selesai
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-sm font-medium text-gray-900">Command Center</td>
                            <td class="py-4 px-6 text-sm text-gray-500">Blok A</td>
                            <td class="py-4 px-6 text-sm text-gray-500">12:00</td>
                            <td class="py-4 px-6 text-sm text-gray-500">16:00</td>
                            <td class="py-4 px-6 text-sm">
                                <span
                                    class="bg-yellow-100 text-yellow-800 px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                    Terjadwal
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection

{{-- Script Kalender --}}
@push('scripts')
    <script>
        // 1. Ambil elemen <p> dengan id 'currentDate'
        const dateElement = document.getElementById('currentDate');

        // 2. Buat objek tanggal untuk hari ini
        const today = new Date();

        // 3. Tentukan opsi format yang diinginkan
        const options = {
            weekday: 'long', // Hasil: Rabu
            day: 'numeric', // Hasil: 1
            month: 'long', // Hasil: Oktober
            year: 'numeric' // Hasil: 2025
        };

        // 4. Format tanggal ke dalam string Bahasa Indonesia dan tampilkan
        dateElement.textContent = today.toLocaleDateString('id-ID', options);
    </script>
@endpush
