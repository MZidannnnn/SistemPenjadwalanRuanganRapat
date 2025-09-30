@extends('layouts.app')

@section('title', 'Manajemen User')

{{--  komponen Navbar --}}
<x-navbar />
{{-- //komponen Navbar --}}
@section('content')
    <div id="main-content">
        {{-- Header Halaman --}}
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar User</h1>
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

            {{-- Tombol Tambah user (diubah untuk memicu JavaScript) --}}
            <button onclick="openModal()"
                class="bg-blue-600 text-white font-semibold py-2 px-5 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center space-x-2">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                        clip-rule="evenodd" />
                </svg>
                <span>Tambah User</span>
            </button>
        </div>

        {{-- Tabel Daftar user --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-white border-b-2 border-gray-200">
                        <tr>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Nama</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Username</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Role</th>
                        </tr>
                    </thead>
                    {{-- Ganti bagian <tbody> lama Anda dengan yang ini --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            {{-- Menambahkan onclick dan atribut data-* --}}
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="openDetailModal({{ json_encode($user) }})">
                                <td class="py-4 px-6 text-sm font-medium text-gray-800">{{ $user->name }}</td>
                                <td class="py-4 px-6 text-sm text-gray-600">{{ $user->username }}</td>
                                <td class="py-4 px-6 text-sm">
                                    <span
                                        class="{{ $user->role == 'admin' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-gray-500">
                                    Belum ada data user yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-4 max-w-lg w-full">

            {{-- Modal Header --}}
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Tambah User</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body (Form) --}}

            <form action="{{ route('user.store') }}" method="POST">
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <strong class="font-bold">Oops! Terjadi kesalahan:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="name" id="name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" id="username"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">


                            <input type="password" name="password" id="add_passwordInput" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            {{-- Tombol Show/Hide --}}
                            <button type="button" id="add_togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none">
                                {{-- Container untuk ikon mata terbuka (default) --}}
                                <div id="add_eyeOpenContainer">
                                    <svg class="h-5 w-5 text-gray-500 hover:text-gray-700 transition-colors"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10c1.272-4.057 5.52-7 9.542-7s8.728 2.943 9.542 7c-.814 4.057-5.08 7-9.542 7s-8.728-2.943-9.542-7zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                                {{-- Container untuk ikon mata tertutup (hidden by default) --}}
                                <div id="add_eyeClosedContainer" class="hidden">
                                    <svg class="h-5 w-5 text-gray-500 hover:text-gray-700 transition-colors"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" id="role"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Pilih Role</option>
                            <option value="SKPD">SKPD</option>
                            <option value="admin">Admin</option>
                            <option value="pegawai">Pegawai</option>
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

    <div id="detailUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 m-4 max-w-lg w-full">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Detail User</h3>
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

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="name" id="detail_name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" id="detail_username"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">


                            <input type="password" name="password" id="edit_passwordInput" required
                                placeholder="Isi jika ingin mengubah password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            {{-- Tombol Show/Hide --}}
                            <button type="button" id="edit_togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none">
                                {{-- Container untuk ikon mata terbuka (default) --}}
                                <div id="edit_eyeOpenContainer">
                                    <svg class="h-5 w-5 text-gray-500 hover:text-gray-700 transition-colors"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10c1.272-4.057 5.52-7 9.542-7s8.728 2.943 9.542 7c-.814 4.057-5.08 7-9.542 7s-8.728-2.943-9.542-7zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                                {{-- Container untuk ikon mata tertutup (hidden by default) --}}
                                <div id="edit_eyeClosedContainer" class="hidden">
                                    <svg class="h-5 w-5 text-gray-500 hover:text-gray-700 transition-colors"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" id="detail_role"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Pilih Role</option>
                            <option value="SKPD">SKPD</option>
                            <option value="admin">Admin</option>
                            <option value="pegawai">Pegawai</option>
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

                    <button type="button" onclick="openConfirmDeleteModal('/user/' + currentUserId)"
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
    <x-confirm-delete-modal />
    <x-confirm-edit-modal />
@endsection

@push('scripts')
    <script>
        function setupPasswordToggle(inputId, toggleId, eyeOpenId, eyeClosedId) {
            const passwordInput = document.getElementById(inputId);
            const toggleButton = document.getElementById(toggleId);
            const eyeOpen = document.getElementById(eyeOpenId);
            const eyeClosed = document.getElementById(eyeClosedId);

            if (passwordInput && toggleButton && eyeOpen && eyeClosed) {
                toggleButton.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    eyeOpen.classList.toggle('hidden');
                    eyeClosed.classList.toggle('hidden');
                });
            }
        }

        // Panggil fungsi ini untuk setiap modal
        setupPasswordToggle('add_passwordInput', 'add_togglePassword', 'add_eyeOpenContainer', 'add_eyeClosedContainer');
        setupPasswordToggle('edit_passwordInput', 'edit_togglePassword', 'edit_eyeOpenContainer',
        'edit_eyeClosedContainer');



        // --- Kode untuk Modal Tambah user (tetap sama) ---
        const addModal = document.getElementById('addUserModal');
        const mainContent = document.getElementById('main-content');
        const navbar = document.getElementById('navbar');
        let currentUserId = null;
        const editModal = document.getElementById('detailUserModal');


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
        const detailModal = document.getElementById('detailUserModal');

        function openDetailModal(user) {
            currentUserId = user.id;
            const deleteForm = document.getElementById('deleteForm');
            const editForm = document.getElementById('editForm');

            editForm.action = `/user/${user.id}`;

            // Mengisi data ke dalam form modal detail
            document.getElementById('detail_name').value = user.name;
            document.getElementById('detail_username').value = user.username;
            document.getElementById('edit_passwordInput').value = ''; // Mengosongkan field password
            document.getElementById('detail_role').value = user.role;


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
        @if ($errors->any())
            openModal();
        @endif
    </script>
@endpush
