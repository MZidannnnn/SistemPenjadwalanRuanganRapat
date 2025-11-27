@extends('layouts.app')

@section('title', 'Manajemen Ruangan')

{{--  komponen Navbar --}}
<x-navbar />
{{-- //komponen Navbar --}}

{{--  komponen Navbar --}}
<x-notification-gagal-dan-berhasil />
{{-- //komponen Navbar --}}
@section('content')
    <div id="main-content">
        {{-- Header Halaman --}}
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Ruangan</h1>
        </div>

        {{-- Kontrol Aksi (Search dan Tombol Tambah) --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">

            {{-- Form Pencarian --}}
            <form action="{{ route('ruangan.index') }}" method="GET" class="w-full md:w-1/3">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input type="text" name="search" placeholder="Cari berdasarkan nama, lokasi, dll..."
                        value="{{ request('search') }}"
                        class="w-full pl-11 pr-4 py-2.5 border bg-white border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </form>

            {{-- Tombol Tambah Ruangan (diubah untuk memicu JavaScript) --}}
            @if (Auth::user()->role == 'admin')
                <button onclick="openModal()"
                    class="bg-blue-600 text-white font-semibold py-2 px-5 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center space-x-2">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Tambah Ruangan</span>
                </button>
            @endif
        </div>

        {{-- Tabel Daftar Ruangan --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-white border-b-2 border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Ruangan</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Kapasitas</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Kondisi Ruangan</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Ketersediaan Saat Ini</th>
                        </tr>
                    </thead>
                    {{-- Ganti bagian <tbody> lama Anda dengan yang ini --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($ruangans as $ruangan)
                            {{-- Menambahkan onclick dan atribut data-* --}}
                            <tr class="hover:bg-gray-50 cursor-pointer"
                                onclick="openDetailModal({{ json_encode($ruangan) }})">
                                <td class="py-4 px-6 text-sm font-medium text-gray-800">{{ $ruangan->nama_ruangan }}</td>
                                {{-- <td class="py-4 px-6 text-sm text-gray-600">{{ $ruangan->lokasi }}</td> --}}
                                {{-- <td class="py-4 px-6 text-sm text-gray-600">{{ $ruangan->fasilitas }}</td> --}}
                                <td class="py-4 px-6 text-sm text-gray-600">{{ $ruangan->kapasitas }} Orang</td>
                                <td class="py-4 px-6 text-sm">

                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $ruangan->kondisi_ruangan == 'aktif' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($ruangan->kondisi_ruangan) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    {{-- Kolom Status Ketersediaan (dihitung otomatis dari accessor) --}}
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $ruangan->status == 'Tersedia' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $ruangan->status }}
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-gray-500">
                                    Belum ada data ruangan yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">
            {{-- {{ $ruangans->links() }} --}}
            {{ $ruangans->withQueryString()->links() }}
        </div>

    </div>



    <div id="addRoomModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="closeModal()">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-4 max-w-lg w-full" onclick="event.stopPropagation()">

            {{-- Modal Header --}}
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Tambah Ruangan</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body (Form) --}}
            <form action="{{ route('ruangan.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="nama_ruangan" class="block text-sm font-medium text-gray-700 mb-1">Ruangan</label>
                        <input type="text" name="nama_ruangan" id="nama_ruangan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                        <input type="number" name="kapasitas" id="kapasitas"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="fasilitas" class="block text-sm font-medium text-gray-700 mb-1">Fasilitas</label>
                        <input type="text" name="fasilitas" id="fasilitas"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="kondisi_ruangan" class="block text-sm font-medium text-gray-700 mb-1">Kondisi
                            Ruangan</label>
                        <select name="kondisi_ruangan" id="kondisi_ruangan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Pilih Kondisi Ruangan</option>
                            <option value="aktif">Aktif</option>
                            <option value="dalam perbaikan">Dalam Perbaikan</option>
                        </select>
                    </div>
                </div>

                {{-- Modal Footer (Tombol) --}}
                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-200 text-gray-800 font-semibold px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-150">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-green-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-600 transition duration-150">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>

    <div id="detailRoomModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="closeDetailModal()">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-4 max-w-lg w-full" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Detail Ruangan</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Konten detail akan diisi oleh JavaScript --}}
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')

                @php
                    $isReadOnly = Auth::user()->role != 'admin' ? 'readonly' : '';
                    $isDisabled = Auth::user()->role != 'admin' ? 'disabled' : '';
                @endphp


                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Ruangan</label>
                        <input type="text" name="nama_ruangan" id="detail_nama_ruangan"
                            class="w-full mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg" {{ $isReadOnly }}>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Lokasi</label>
                        <input type="text" name="lokasi" id="detail_lokasi"
                            class="w-full mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg" {{ $isReadOnly }}>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Kapasitas</label>
                        <input type="text" name="kapasitas" id="detail_kapasitas"
                            class="w-full mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg" {{ $isReadOnly }}>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Fasilitas</label>
                        <input type="text" name="fasilitas" id="detail_fasilitas"
                            class="w-full mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg" {{ $isReadOnly }}>
                    </div>
                    <div>

                        <label for="kondisi_ruangan" class="block text-sm font-medium text-gray-700 mb-1">Kondisi
                            Ruangan</label>
                        <select name="kondisi_ruangan" id="edit_kondisi_ruangan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" {{ $isDisabled }}>
                            <option>Pilih Kondisi Ruangan</option>
                            <option value="aktif">Aktif</option>
                            <option value="dalam perbaikan">Dalam Perbaikan</option>
                        </select>


                    </div>
                </div>

                {{-- Perbaikan untuk tombol Edit dan Hapus --}}
                @if (Auth::user()->role == 'admin')
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

                        <button type="button" onclick="openConfirmDeleteModal('/ruangan/' + currentRuanganId)"
                            class="inline-flex items-center justify-center bg-red-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-red-700 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Hapus
                        </button>
                    </div>
                @endif
            </form>

        </div>
    </div>
    <x-confirm-delete-modal />
    <x-confirm-edit-modal />
@endsection

@push('scripts')
    <script>
        // --- Kode untuk Modal Tambah Ruangan (tetap sama) ---
        const addModal = document.getElementById('addRoomModal');
        const mainContent = document.getElementById('main-content');
        const navbar = document.getElementById('navbar');
        let currentRuanganId = null;
        const editModal = document.getElementById('detailRoomModal');


        function openModal() {
            addModal.classList.remove('hidden');
            addModal.classList.add('flex');
            mainContent.classList.add('blur-sm');
            navbar.classList.add('blur-sm');
        }

        function closeModal() {
            addModal.classList.add('hidden');
            addModal.classList.remove('flex');
            mainContent.classList.remove('blur-sm');
            navbar.classList.remove('blur-sm');
        }

        // --- KODE BARU UNTUK MODAL DETAIL ---
        const detailModal = document.getElementById('detailRoomModal');

        function openDetailModal(ruangan) {
            currentRuanganId = ruangan.id;
            const deleteForm = document.getElementById('deleteForm');
            const editForm = document.getElementById('editForm');
            deleteForm.action = `/ruangan/${ruangan.id}`;
            editForm.action = `/ruangan/${ruangan.id}`;

            // Mengisi data ke dalam form modal detail
            document.getElementById('detail_nama_ruangan').value = ruangan.nama_ruangan;
            document.getElementById('detail_lokasi').value = ruangan.lokasi;
            document.getElementById('detail_kapasitas').value = ruangan.kapasitas;
            document.getElementById('detail_fasilitas').value = ruangan.fasilitas;
            document.getElementById('edit_kondisi_ruangan').value = ruangan.kondisi_ruangan;


            // Menampilkan modal
            detailModal.classList.remove('hidden');
            detailModal.classList.add('flex');
            mainContent.classList.add('blur-sm');
            navbar.classList.add('blur-sm');
        }

        function closeDetailModal() {
            detailModal.classList.add('hidden');
            detailModal.classList.remove('flex');
            mainContent.classList.remove('blur-sm');
            navbar.classList.remove('blur-sm');
        }
    </script>
@endpush
