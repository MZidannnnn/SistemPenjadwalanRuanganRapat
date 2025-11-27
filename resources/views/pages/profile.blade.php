@extends('layouts.app')

@section('title', 'Edit Profile')

<x-navbar />

{{--  komponen Navbar --}}
<x-notification-gagal-dan-berhasil />
{{-- //komponen Navbar --}}
@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-0.5 pb-8">
        <div class="max-w-2xl mx-auto">
            {{-- Header Halaman --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Edit Profile</h1>
                <p class="text-gray-500 mt-1">Perbarui informasi akun Anda di sini.</p>
            </div>

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Card Form --}}
            <div class="bg-white rounded-xl shadow-md p-6 sm:p-8">

                {{-- Ganti 'profile.update' dengan nama route Anda yang sesuai --}}
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Tampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="mb-4 p-3 rounded-md bg-red-100 text-red-700 text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-4">
                        {{-- Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                            {{-- Ambil data nama dari user yang sedang login --}}
                            <input type="text" name="name" id="name"
                                value="{{ old('name', auth()->user()->name) }}" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" id="username"
                                value="{{ old('username', auth()->user()->username) }}" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('username') border-red-500 @enderror">
                            @error('username')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan"
                                value="{{ old('jabatan', auth()->user()->jabatan) }}" readonly
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('jabatan') border-red-500 @enderror">
                            @error('jabatan')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru
                                (Opsional)</label>

                            {{-- DIUBAH: Tambahkan div dengan class "relative" --}}
                            <div class="relative mt-1">
                                <input type="password" name="password" id="passwordInput"
                                    placeholder="Isi hanya jika ingin mengubah password"
                                    class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('password') border-red-500 @enderror">

                                {{-- Tombol Show/Hide --}}
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <div id="eyeOpenContainer">
                                        <svg class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10c1.272-4.057 5.52-7 9.542-7s8.728 2.943 9.542 7c-.814 4.057-5.08 7-9.542 7S1.272 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div id="eyeClosedContainer" class="hidden">
                                        <svg class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                                clip-rule="evenodd" />
                                            <path
                                                d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                        </svg>
                                    </div>
                                </button>
                            </div>

                            @error('password')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    // Jalankan skrip setelah seluruh halaman HTML dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const eyeOpenContainer = document.getElementById('eyeOpenContainer');
        const eyeClosedContainer = document.getElementById('eyeClosedContainer');

        // Pastikan semua elemen ada sebelum menambahkan event listener
        if (togglePassword && passwordInput && eyeOpenContainer && eyeClosedContainer) {
            togglePassword.addEventListener('click', function() {
                // Toggle tipe atribut dari input password
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle ikon mata yang terlihat
                eyeOpenContainer.classList.toggle('hidden');
                eyeClosedContainer.classList.toggle('hidden');
            });
        }
    });
</script>
@endpush