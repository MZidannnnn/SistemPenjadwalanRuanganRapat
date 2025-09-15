@extends('layouts.app')

@section('title', 'Manajemen Ruangan')

{{--  komponen Navbar --}}
<x-navbar />
{{-- //komponen Navbar --}}
@section('content')
    <div id="main-content">
        {{-- Header Halaman --}}
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Ruangan</h1>
        </div>

        {{-- Kontrol Aksi (Search dan Tombol Tambah) --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">

            {{-- Kolom Pencarian --}}
            <div class="relative w-full md:w-1/3">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                <input type="text" placeholder="Search"
                    class="w-full pl-11 pr-4 py-2.5 border bg-white border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Tombol Tambah Ruangan (diubah untuk memicu JavaScript) --}}
            <button onclick="openModal()"
                class="bg-blue-600 text-white font-semibold py-2 px-5 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center space-x-2">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                        clip-rule="evenodd" />
                </svg>
                <span>Tambah Ruangan</span>
            </button>
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
                                Lokasi</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Fasilitas</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Kapasitas</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    {{-- Ganti bagian <tbody> lama Anda dengan yang ini --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($ruangans as $ruangan)
                            {{-- Menambahkan onclick dan atribut data-* --}}
                            <tr class="hover:bg-gray-50 cursor-pointer"
                                onclick="openDetailModal({{ json_encode($ruangan) }})">
                                <td class="py-4 px-6 text-sm font-medium text-gray-800">{{ $ruangan->nama_ruangan }}</td>
                                <td class="py-4 px-6 text-sm text-gray-600">{{ $ruangan->lokasi }}</td>
                                <td class="py-4 px-6 text-sm text-gray-600">{{ $ruangan->fasilitas }}</td>
                                <td class="py-4 px-6 text-sm text-gray-600">{{ $ruangan->kapasitas }} Orang</td>
                                <td class="py-4 px-6 text-sm">
                                    <span
                                        class="{{ $ruangan->status == 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        {{ ucfirst($ruangan->status) }}
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
    </div>

    {{-- ====================================================== --}}
    {{-- ======== TAMBAHKAN BLOK KODE MODAL DI BAWAH INI ======== --}}
    {{-- ====================================================== --}}

    <div id="addRoomModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-4 max-w-lg w-full">

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
            <form action="#" method="POST">
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
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Pilih Status</option>
                            <option value="tersedia">Tersedia</option>
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


    {{-- ====================================================== --}}
    {{-- ======== TAMBAHKAN BLOK KODE MODAL DETAIL DI SINI ======== --}}
    {{-- ====================================================== --}}

    <div id="detailRoomModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-4 max-w-lg w-full">
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
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Ruangan</label>
                    <input type="text" id="detail_nama_ruangan"
                        class="w-full mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Lokasi</label>
                    <input type="text" id="detail_lokasi"
                        class="w-full mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Kapasitas</label>
                    <input type="text" id="detail_kapasitas"
                        class="w-full mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Fasilitas</label>
                    <input type="text" id="detail_fasilitas"
                        class="w-full mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Status</label>
                    <input type="text" id="detail_status"
                        class="w-full mt-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg" readonly>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-3">

                {{-- Tombol Edit --}}
                <button type="button"
                    class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-150">
                    Edit
                </button>

                {{-- Form untuk Tombol Hapus --}}
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-700 transition duration-150">
                        Hapus
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // --- Kode untuk Modal Tambah Ruangan (tetap sama) ---
        const addModal = document.getElementById('addRoomModal');
        const mainContent = document.getElementById('main-content');
        const navbar = document.getElementById('navbar');

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
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/ruangan/${ruangan.id_ruangan}`;


            // Mengisi data ke dalam form modal detail
            document.getElementById('detail_nama_ruangan').value = ruangan.nama_ruangan;
            document.getElementById('detail_lokasi').value = ruangan.lokasi;
            document.getElementById('detail_kapasitas').value = ruangan.kapasitas + ' Orang';
            document.getElementById('detail_fasilitas').value = ruangan.fasilitas;
            document.getElementById('detail_status').value = ruangan.status.charAt(0).toUpperCase() + ruangan.status.slice(
                1);

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
