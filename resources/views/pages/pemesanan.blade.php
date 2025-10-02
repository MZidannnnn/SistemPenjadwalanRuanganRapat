@extends('layouts.app')

@section('title', 'Manajemen Pemesanan')

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
        </style>
    @endpush

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Pengelola Pemesanan</h1>

    {{-- Calendar Container --}}
    <div class="flex justify-center">
        <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-2xl">

            {{-- Calendar Header --}}
            <div class="flex items-center justify-between mb-6">
                <button onclick="previousMonth()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <h2 id="currentMonthYear" class="text-lg font-semibold text-gray-800">Januari 2023</h2>

                <button onclick="nextMonth()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            {{-- Days of Week Header --}}
            <div class="grid grid-cols-7 gap-1 mb-2">
                @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $hari)
                    <div class="text-center text-gray-400 text-sm py-2">{{ $hari }}</div>
                @endforeach
            </div>

            {{-- Calendar Grid --}}
            <div id="calendarGrid" class="grid grid-cols-7 gap-1"></div>
        </div>
    </div>

    {{-- Daftar Pemesanan --}}
    <div class="mt-12">
        <h2 class="text-xl font-bold text-gray-800">Daftar Pemesanan</h2>

        {{-- Kolom Pencarian --}}
        <div class="mt-6 mb-4">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                <input type="text" placeholder="Cari jadwal..."
                    class="w-full md:w-1/3 pl-10 pr-4 py-2 border bg-white border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Tabel Jadwal --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach (['Ruangan', 'Lokasi', 'Waktu Mulai', 'Waktu Selesai', 'Status'] as $head)
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $head }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($pemesanan as $p)
                            <tr class="hover:bg-gray-50">
                                {{-- PERBAIKAN: Akses properti 'nama_ruangan' dari relasi 'ruangan' --}}
                                <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ $p->ruangan->nama_ruangan }}</td>

                                {{-- PERBAIKAN: Akses properti 'lokasi' dari relasi 'ruangan' --}}
                                <td class="py-4 px-6 text-sm text-gray-500">{{ $p->ruangan->lokasi }}</td>

                                {{-- PERBAIKAN: Format waktu agar lebih mudah dibaca --}}
                                <td class="py-4 px-6 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($p->waktu_mulai)->format('d M Y, H:i') }}</td>
                                <td class="py-4 px-6 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($p->waktu_selesai)->format('d M Y, H:i') }}</td>

                                <td class="py-4 px-6 text-sm">
                                    @php
                                        // PERBAIKAN: Sesuaikan key dengan nilai dari database
                                        $statusColors = [
                                            'dijadwalkan' => 'bg-yellow-100 text-yellow-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'dibatalkan' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span
                                        class="{{ $statusColors[$p->status] ?? 'bg-gray-100 text-gray-800' }} px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 px-6 text-center text-sm text-gray-500">
                                    Belum ada data pemesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modal: Detail & Form Pemesanan --}}
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl p-6 m-4 max-w-lg w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Detail Rapat</h3>
                <button onclick="toggleModal('detailModal', false)"
                    class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <div id="meetingContent" class="space-y-4"></div>
            <div class="mt-6 border-t pt-4 flex flex-col gap-3">
                <button type="button"
                    class="w-full inline-flex justify-center items-center gap-3 bg-blue-600 text-white font-semibold py-2 pl-2 pr-5 rounded-full hover:bg-blue-700 transition"
                    onclick="showPemesananForm()">
                    <div class="bg-white rounded-full w-6 h-6 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span>Pesan Ruang Rapat</span>
                </button>
            </div>
        </div>
    </div>

    <div id="formPemesananModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl m-4 max-w-lg w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Pesan Ruang Rapat</h3>
                    <button onclick="toggleModal('formPemesananModal', false)"
                        class="text-gray-400 hover:text-gray-600">&times;</button>
                </div>

                <form action="{{ route('pemesanan.store') }}" method="POST">
                    @csrf

                    {{-- Tampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="mb-4 p-3 rounded-md bg-red-100 border border-red-300 text-red-700 text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        {{-- Auto-buka modal lagi kalau error --}}
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                toggleModal('formPemesananModal', true);
                            });
                        </script>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label for="ruangan_id" class="block text-sm font-medium text-gray-700">Pilih Ruangan</label>
                            <select name="ruangan_id" id="ruangan_id"
                                class="mt-1 block w-full py-2 px-3 border rounded-md shadow-sm @error('ruangan_id') border-red-500 @enderror">
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach ($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}"
                                        {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                        {{ $ruangan->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ruangan_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan"
                                value="{{ old('nama_kegiatan') }}"
                                class="mt-1 block w-full py-2 px-3 border rounded-md shadow-sm @error('nama_kegiatan') border-red-500 @enderror"
                                placeholder="Contoh: Rapat Koordinasi Bulanan">
                            @error('nama_kegiatan')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                                class="mt-1 block w-full py-2 px-3 border rounded-md shadow-sm @error('tanggal') border-red-500 @enderror"
                                readonly>
                            @error('tanggal')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu
                                    Mulai</label>
                                <input type="time" name="waktu_mulai" id="waktu_mulai"
                                    value="{{ old('waktu_mulai') }}"
                                    class="mt-1 block w-full py-2 px-3 border rounded-md shadow-sm @error('waktu_mulai') border-red-500 @enderror">
                                @error('waktu_mulai')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="waktu_selesai" class="block text-sm font-medium text-gray-700">Waktu
                                    Selesai</label>
                                <input type="time" name="waktu_selesai" id="waktu_selesai"
                                    value="{{ old('waktu_selesai') }}"
                                    class="mt-1 block w-full py-2 px-3 border rounded-md shadow-sm @error('waktu_selesai') border-red-500 @enderror">
                                @error('waktu_selesai')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="toggleModal('formPemesananModal', false)"
                            class="bg-gray-200 text-gray-800 font-semibold px-4 py-2 rounded-full">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-full">Pesan
                            Sekarang</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

{{-- Script Kalender --}}
@push('scripts')
    <script>
        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();
        let selectedDate = today.getDate();

        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
            'Oktober', 'November', 'Desember'
        ];

        const meetingData = {
            [`${currentYear}-${String(currentMonth+1).padStart(2,'0')}-${String(today.getDate()).padStart(2,'0')}`]: [{
                    title: 'Rapat Koordinasi Tim',
                    time: '09:00 - 11:00',
                    room: 'Ruang Rapat A',
                    attendees: 15,
                    description: 'Pembahasan progress project bulan ini'
                },
                {
                    title: 'Meeting dengan Vendor',
                    time: '14:00 - 16:00',
                    room: 'Ruang Rapat B',
                    attendees: 8,
                    description: 'Diskusi kerjasama pengadaan'
                }
            ]
        };

        function formatDate(y, m, d) {
            return `${y}-${String(m+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        }

        function toggleModal(id, show = true) {
            const modal = document.getElementById(id);
            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function renderCalendar() {
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();
            const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;

            document.getElementById('currentMonthYear').textContent = `${monthNames[currentMonth]} ${currentYear}`;

            let calendarHTML = '';
            for (let i = adjustedFirstDay - 1; i >= 0; i--) {
                calendarHTML += `<div class="calendar-day text-gray-300 cursor-not-allowed">${daysInPrevMonth-i}</div>`;
            }
            for (let d = 1; d <= daysInMonth; d++) {
                const dateStr = formatDate(currentYear, currentMonth, d);
                const hasMeeting = meetingData[dateStr];
                const isToday = currentMonth === today.getMonth() && currentYear === today.getFullYear() && d === today
                    .getDate();
                const isSelected = d === selectedDate;

                let dayClasses = 'calendar-day cursor-pointer hover:bg-gray-100 rounded-lg transition-all';
                if (isToday && !isSelected) dayClasses += ' today-date';
                else if (isSelected) dayClasses += ' selected-date';
                if (hasMeeting) dayClasses += ' font-semibold';

                calendarHTML +=
                    `<div onclick="selectDate(${d},${currentMonth},${currentYear})" class="${dayClasses}">${d}${hasMeeting?'<div class="text-xs text-blue-300">•</div>':''}</div>`;
            }
            const totalCells = adjustedFirstDay + daysInMonth;
            const remainingCells = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
            for (let d = 1; d <= remainingCells; d++) {
                calendarHTML += `<div class="calendar-day text-gray-300 cursor-not-allowed">${d}</div>`;
            }
            document.getElementById('calendarGrid').innerHTML = calendarHTML;
        }

        function selectDate(d, m, y) {
            selectedDate = d;
            currentMonth = m;
            currentYear = y;
            renderCalendar();
            showDetails();
        }

        function previousMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        }

        function showDetails() {
            const dateStr = formatDate(currentYear, currentMonth, selectedDate);
            const meetings = meetingData[dateStr];
            const content = document.getElementById('meetingContent');

            if (meetings && meetings.length > 0) {
                let html =
                    `<div class="text-sm text-gray-600 mb-3"><span class="font-semibold">Tanggal: ${selectedDate} ${monthNames[currentMonth]} ${currentYear}</span></div>`;
                meetings.forEach((m, i) => {
                    html += `<div class="border-l-4 border-blue-500 pl-4 py-3 ${i>0?'mt-4':''}">
                    <h4 class="font-semibold text-gray-800 mb-2">${m.title}</h4>
                    <div class="space-y-1 text-sm text-gray-600">
                        <div class="flex items-center"><span class="mr-2">⏰</span><span>Waktu: ${m.time}</span></div>
                        <div class="flex items-center"><span class="mr-2">📍</span><span>Ruangan: ${m.room}</span></div>
                        <div class="flex items-center"><span class="mr-2">👥</span><span>Peserta: ${m.attendees} orang</span></div>
                        <div class="flex items-start"><span class="mr-2">📝</span><span>${m.description}</span></div>
                    </div>
                </div>`;
                });
                content.innerHTML = html;
            } else {
                content.innerHTML =
                    `<div class="text-center py-8 text-gray-500"><p>Tidak ada rapat pada tanggal ${selectedDate} ${monthNames[currentMonth]} ${currentYear}</p></div>`;
            }
            toggleModal('detailModal', true);
        }

        function showPemesananForm() {
            document.getElementById('tanggal').value = formatDate(currentYear, currentMonth, selectedDate);
            toggleModal('detailModal', false);
            setTimeout(() => toggleModal('formPemesananModal', true), 150);
        }

        document.addEventListener('DOMContentLoaded', renderCalendar);
    </script>
@endpush
