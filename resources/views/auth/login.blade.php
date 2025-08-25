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

                    {{-- Input Password --}}
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input type="password" name="password" id="password" required
                                placeholder="Masukkan password"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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

</html>
