@push('styles')
    <style>
        .bg-custom-gradient {
            background: linear-gradient(to right, #1540AA, #0646E7);
        }
    </style>
@endpush

<div>
    {{-- Topbar Navigation --}}
    <nav id="navbar" class="bg-custom-gradient text-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">

            {{-- Logo dan Judul Kiri --}}
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo-pemkot.png') }}" alt="Logo" class="h-12 w-12">
                <a href="/dashboard" class="text-3xl font-bold">Dashboard</a>
            </div>

            {{-- Menu Tengah --}}
            <div class="hidden md:flex items-center space-x-10">
                <a href="/pemesanan"
                    class="relative flex flex-col items-center hover:text-gray-300 transition duration-150 text-xs px-2">
                    <img src="{{ asset('images/icons8-scheduling-32 (1).png') }}" alt="Pemesanan" class="h-6 w-6 mb-1">
                    <span>Pemesanan</span>
                    {{-- Logika untuk menampilkan garis bawah --}}
                    @if (request()->is('pemesanan*'))
                        <span class="absolute -bottom-4 h-0.5 w-full bg-white rounded-full"></span>
                    @endif
                </a>
                <a href="/ruangan"
                    class="relative flex flex-col items-center hover:text-gray-300 transition duration-150 text-xs px-2">
                    <img src="{{ asset('images/icons8-meeting-room-50.png') }}" alt="Ruangan" class="h-6 w-6 mb-1">
                    <span>Ruangan</span>
                    {{-- Logika untuk menampilkan garis bawah --}}
                    @if (request()->is('ruangan*'))
                        <span class="absolute -bottom-4 h-0.5 w-full bg-white rounded-full"></span>
                    @endif
                </a>
                <a href="/user"
                    class="relative flex flex-col items-center hover:text-gray-300 transition duration-150 text-xs px-2">
                    <img src="{{ asset('images/icons8-user-24.png') }}" alt="User" class="h-6 w-6 mb-1">
                    <span>User</span>
                    {{-- Logika untuk menampilkan garis bawah --}}
                    @if (request()->is('user*'))
                        <span class="absolute -bottom-4 h-0.5 w-full bg-white rounded-full"></span>
                    @endif
                </a>
            </div>

            {{-- Tombol Keluar Kanan --}}
            <div class="ml-8">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center space-x-2 hover:text-gray-300 transition duration-150 px-4 py-2 rounded-lg">
                        <img src="{{ asset('images/icons8-logout-24.png') }}" alt="Keluar" class="h-5 w-5">
                        <span>Keluar</span>
                    </a>
                </form>
            </div>

        </div>
    </nav>
</div>
