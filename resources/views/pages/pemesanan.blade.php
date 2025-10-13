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
        <form action="{{ route('pemesanan.index') }}" method="GET" class="mt-6 mb-4">

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
                    <input type="text" placeholder="Cari jadwal..." name="search"
                        class="w-full md:w-1/3 pl-10 pr-4 py-2 border bg-white border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </form>

        {{-- Tabel Pemesanan (Style Baru) --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">

                    {{-- DIUBAH: Menggunakan style header dari tabel ruangan --}}
                    <thead class="bg-white border-b-2 border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Ruangan</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Lokasi</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Waktu Mulai</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Waktu Selesai</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>

                    {{-- DIUBAH: Menggunakan style body dari tabel ruangan --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pemesanan as $p)
                            {{-- DIUBAH: Menambahkan atribut data-* dan onclick --}}
                            <tr class="hover:bg-gray-50 cursor-pointer" data-pemesanan='{{ json_encode($p) }}'
                                onclick="openPemesananDetail(this)">

                                <td class="py-4 px-6 text-sm font-medium text-gray-800">{{ $p->ruangan->nama_ruangan }}</td>
                                <td class="py-4 px-6 text-sm text-gray-600">{{ $p->ruangan->lokasi }}</td>
                                <td class="py-4 px-6 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($p->waktu_mulai)->format('d M Y, H:i') }}</td>
                                <td class="py-4 px-6 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($p->waktu_selesai)->format('d M Y, H:i') }}</td>
                                <td class="py-4 px-6 text-sm">
                                    @php
                                        $statusColors = [
                                            'Dijadwalkan' => 'bg-yellow-100 text-yellow-800',
                                            'Berlangsung' => 'bg-blue-100 text-blue-800',
                                            'Selesai' => 'bg-green-100 text-green-800',
                                            'Dibatalkan' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span
                                        class="{{ $statusColors[$p->status] ?? 'bg-gray-100 text-gray-800' }} px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        {{ $p->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-gray-500">
                                    Belum ada data pemesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
        <div class="mt-6">
            {{-- withQueryString() penting agar filter pencarian tidak hilang saat pindah halaman --}}
            {{ $pemesanan->withQueryString()->links() }}
        </div>


        {{-- MODAL UNTUK MENAMPILKAN DETAIL Tabel PEMESANAN --}}
        {{-- GANTI SELURUH MODAL DETAIL ANDA DENGAN INI --}}
        <div id="pemesananDetailModal"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl m-4 max-w-lg w-full">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Detail Pemesanan</h3>
                        <button onclick="toggleModal('pemesananDetailModal', false)"
                            class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                    </div>

                    @if ($errors->update->any())
                        <div class="mb-4 p-3 rounded-md bg-red-100 border border-red-300 text-red-700 text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->update->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    {{-- FORM EDIT PEMESANAN --}}
                    <form id="editForm" action="" method="POST">
                        @csrf
                        @method('PUT')



                        <div class="space-y-4">

                            <div>
                                <label for="edit_ruangan_id" class="block text-sm font-medium text-gray-700">Pilih
                                    Ruangan</label>
                                <select name="ruangan_id" id="edit_ruangan_id" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md">
                                    @foreach ($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="edit_nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama
                                    Kegiatan</label>
                                <input type="text" name="nama_kegiatan" id="edit_nama_kegiatan" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="edit_tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" name="tanggal" id="edit_tanggal" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu
                                        Mulai</label>
                                    <input type="time" name="waktu_mulai" id="edit_waktu_mulai" required
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="edit_waktu_selesai" class="block text-sm font-medium text-gray-700">Waktu
                                        Selesai</label>
                                    <input type="time" name="waktu_selesai" id="edit_waktu_selesai" required
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div>
                                <label for="edit_status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="edit_status" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md">
                                    <option value="dijadwalkan">Dijadwalkan</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="dibatalkan">Dibatalkan</option>
                                </select>
                            </div>

                        </div>
                        {{-- Perbaikan untuk tombol Edit dan Hapus --}}
                        <div class="mt-8 flex justify-end items-center space-x-3">

                            {{-- Tombol Edit --}}
                            <button type="button" onclick="openConfirmEditModal()"
                                class="inline-flex items-center justify-center bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Edit
                            </button>

                            <button type="button" onclick="openConfirmDeleteModal('/pemesanan/' + currentPemesananId)"
                                class="inline-flex items-center justify-center bg-red-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-red-700 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal: Detail Rapat & Form Pemesanan --}}
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl p-6 m-4 max-w-lg w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Detail Rapat</h3>
                <button onclick="toggleModal('detailModal', false)"
                    class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <div id="meetingContent" class="space-y-4 max-h-72 overflow-y-auto pr-2"></div>
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

                @if ($errors->create->any())
                    <div class="mb-4 p-3 rounded-md bg-red-100 border border-red-300 text-red-700 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->create->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('pemesanan.store') }}" method="POST">
                    @csrf

                    {{-- Tampilkan Error Validasi --}}

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
                            <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama
                                Kegiatan</label>
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
    <x-confirm-delete-modal />
    <x-confirm-edit-modal />
@endsection

{{-- Script Kalender --}}
@push('scripts')
    <script>
        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();
        let selectedDate = today.getDate();
        let currentPemesananId = null;

        document.addEventListener("DOMContentLoaded", function() {

            // KONDISI 1: JIKA ADA ERROR SAAT MEMBUAT PESANAN BARU
            @if ($errors->create->any())
                // Buka modal untuk 'tambah pesanan'
                toggleModal('formPemesananModal', true);
            @endif

            // KONDISI 2: JIKA ADA ERROR SAAT MENGEDIT PESANAN
            @if (session('failed_update_id'))
                // Ambil ID pemesanan yang gagal dari session
                const failedId = {{ session('failed_update_id') }};

                // Cari baris tabel <tr> yang memiliki data pemesanan dengan ID tersebut
                const targetRow = document.querySelector(`tr[data-pemesanan*='"id":${failedId}']`);

                // Jika barisnya ditemukan
                if (targetRow) {
                    // Panggil fungsi openPemesananDetail untuk membuka kembali modal edit yang benar
                    openPemesananDetail(targetRow);
                }
            @endif
        });


        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
            'Oktober', 'November', 'Desember'
        ];




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

            document.getElementById('currentMonthYear').textContent =
                `${monthNames[currentMonth]} ${currentYear}`;

            let calendarHTML = '';
            for (let i = adjustedFirstDay - 1; i >= 0; i--) {
                calendarHTML += `<div class="calendar-day text-gray-300 cursor-not-allowed">${daysInPrevMonth-i}</div>`;
            }
            for (let d = 1; d <= daysInMonth; d++) {
                const dateStr = formatDate(currentYear, currentMonth, d);
                const isToday = currentMonth === today.getMonth() && currentYear === today.getFullYear() && d === today
                    .getDate();
                const isSelected = d === selectedDate;

                let dayClasses = 'calendar-day cursor-pointer hover:bg-gray-100 rounded-lg transition-all';
                if (isToday && !isSelected) dayClasses += ' today-date';
                else if (isSelected) dayClasses += ' selected-date';

                calendarHTML +=
                    `<div onclick="selectDate(${d},${currentMonth},${currentYear})" class="${dayClasses}">${d}</div>`;
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

        async function showDetails() {
            const dateStr = formatDate(currentYear, currentMonth, selectedDate);
            const content = document.getElementById('meetingContent');

            try {
                const res = await fetch(`/pemesanan/by-date/${dateStr}`);
                const data = await res.json();

                if (data.length > 0) {
                    let html = `<div class="text-sm text-gray-600 mb-3">
                        <span class="font-semibold">Tanggal: ${selectedDate} ${monthNames[currentMonth]} ${currentYear}</span>
                    </div>`;
                    data.forEach((m, i) => {
                        html += `<div class="border-l-4 border-blue-500 pl-4 py-3 ${i>0?'mt-4':''}">
                        <h4 class="font-semibold text-gray-800 mb-2">${m.nama_kegiatan}</h4>
                        <div class="space-y-1 text-sm text-gray-600">
                            <div class="flex items-center"><span class="mr-2">⏰</span><span>Waktu: ${m.waktu_mulai} - ${m.waktu_selesai}</span></div>
                            <div class="flex items-center"><span class="mr-2">📍</span><span>Ruangan: ${m.ruangan.nama_ruangan}</span></div>
                            <div class="flex items-center"><span class="mr-2">👤</span><span>Oleh: ${m.user.name}</span></div>
                            <div class="flex items-start"><span class="mr-2">📝</span><span>Status: ${m.status}</span></div>
                        </div>
                    </div>`;
                    });
                    content.innerHTML = html;
                } else {
                    content.innerHTML = `<div class="text-center py-8 text-gray-500">
                        <p>Tidak ada rapat pada tanggal ${selectedDate} ${monthNames[currentMonth]} ${currentYear}</p>
                    </div>`;
                }
                toggleModal('detailModal', true);
            } catch (err) {
                content.innerHTML = `<p class="text-red-500">Gagal mengambil data.</p>`;
                toggleModal('detailModal', true);
            }
        }

        function showPemesananForm() {
            document.getElementById('tanggal').value = formatDate(currentYear, currentMonth, selectedDate);
            toggleModal('detailModal', false);
            setTimeout(() => toggleModal('formPemesananModal', true), 150);
        }

        // GANTI FUNGSI LAMA ANDA DENGAN INI
        function openPemesananDetail(element) {
            // 1. Ambil dan parse data dari atribut data-pemesanan
            const pemesanan = JSON.parse(element.getAttribute('data-pemesanan'));

            // 2. Atur action untuk form edit
            currentPemesananId = pemesanan.id;
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/pemesanan/${pemesanan.id}`;
            const editForm = document.getElementById('editForm');
            editForm.action = `/pemesanan/${pemesanan.id}`;

            // 3. Pecah 'waktu_mulai' dari database (YYYY-MM-DD HH:MM:SS) menjadi tanggal dan waktu
            const dateTimeMulai = new Date(pemesanan.waktu_mulai);
            const tanggal = dateTimeMulai.toISOString().split('T')[0]; // Hasil: "YYYY-MM-DD"
            const waktuMulai = dateTimeMulai.toTimeString().substring(0, 5); // Hasil: "HH:MM"

            // 4. Pecah 'waktu_selesai' untuk mendapatkan waktunya saja
            const waktuSelesai = new Date(pemesanan.waktu_selesai).toTimeString().substring(0, 5); // Hasil: "HH:MM"

            // 5. Isi semua field di dalam form modal
            document.getElementById('edit_ruangan_id').value = pemesanan.ruangan_id;
            document.getElementById('edit_nama_kegiatan').value = pemesanan.nama_kegiatan;
            document.getElementById('edit_tanggal').value = tanggal;
            document.getElementById('edit_waktu_mulai').value = waktuMulai;
            document.getElementById('edit_waktu_selesai').value = waktuSelesai;
            document.getElementById('edit_status').value = pemesanan.status_raw;

            // 6. Tampilkan modal
            toggleModal('pemesananDetailModal', true);
        }

        document.addEventListener('DOMContentLoaded', renderCalendar);
    </script>
@endpush
