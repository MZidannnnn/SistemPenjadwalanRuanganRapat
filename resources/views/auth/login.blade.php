<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penjadwalan Ruangan</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

</head>

<body class="bg-gray-200">

    <div class="min-h-screen bg-cover bg-center flex items-center justify-center relative"
        style="background-image: url('{{ asset('images/pemkot-bg.jpeg') }}');">
        {{-- Dark Overlay --}}
        <div class="absolute inset-0 bg-black opacity-50"></div>

        {{-- Login Card --}}
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md z-10 overflow-hidden">

            {{-- BAGIAN ATAS KARTU (TANPA PADDING) --}}
            <div class="pt-8">
                {{-- Logo --}}
                <div class="flex justify-center">
                    <img src="{{ asset('images/logo-pemkot.png') }}" alt="Logo Pemko Banjarmasin" class="h-20">
                </div>

                {{-- Garis Pemisah --}}
                <div class="mt-6">
                    <div class="w-full h-px bg-gray-600"></div>
                </div>
            </div>

            {{-- BAGIAN BAWAH KARTU (DENGAN PADDING) --}}
            <div class="p-8 md:p-10">
                <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Login Ke akun anda</h2>

                {{-- Form Login --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Input Username --}}
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input type="text" placeholder="Masukkan Username" name="username" id="username"
                                value="{{ old('username') }}" required autofocus
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- Input Password dengan Fitur Show/Hide --}}
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                {{-- Ikon Gembok --}}
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                        clip-rule="evenodd" />
                                </svg>

                            </span>

                            <input type="password" name="password" id="passwordInput" required
                                placeholder="********************"
                                class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                            {{-- Tombol Show/Hide --}}
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none">
                                {{-- Container untuk ikon mata terbuka (default) --}}
                                <div id="eyeOpenContainer">
                                    <svg class="h-5 w-5 text-gray-500 hover:text-gray-700 transition-colors"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10c1.272-4.057 5.52-7 9.542-7s8.728 2.943 9.542 7c-.814 4.057-5.08 7-9.542 7s-8.728-2.943-9.542-7zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>

                                {{-- Container untuk ikon mata tertutup (hidden by default) --}}
                                <div id="eyeClosedContainer" class="hidden">
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


                    @error('username')
                        <p class="text-red-500 text-xs italic mb-4">{{ $message }}</p>
                    @enderror

                    {{-- Tombol Masuk --}}
                    <div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>

{{-- SCRIPT JAVASCRIPT --}}
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');
    const eyeOpenContainer = document.getElementById('eyeOpenContainer');
    const eyeClosedContainer = document.getElementById('eyeClosedContainer');

    togglePassword.addEventListener('click', function() {
        // Toggle the type attribute of the password input
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle the visibility of the icon containers
        eyeOpenContainer.classList.toggle('hidden');
        eyeClosedContainer.classList.toggle('hidden');
    });
</script>

</html>
