<div>
    {{-- resources/views/components/notification.blade.php --}}

<div id="notification-container" class="fixed top-5 right-5 z-[100] flex flex-col gap-3">

    {{-- 1. NOTIFIKASI SUKSES --}}
    @if (session('success'))
        <div id="toast-success" class="flex items-center w-full max-w-xs p-4 text-white bg-teal-700 rounded-lg shadow-lg transition-opacity duration-500" role="alert">
            {{-- Ikon Check --}}
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 bg-white text-teal-700 rounded-full">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
                <span class="sr-only">Check icon</span>
            </div>
            
            {{-- Teks --}}
            <div class="ml-3 text-sm font-medium pr-4">
                operasi berhasil dilakukan
            </div>
            
            {{-- Tombol Close --}}
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-white hover:text-gray-200 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 border-l border-teal-600" onclick="closeToast('toast-success')">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- 2. NOTIFIKASI ERROR / GAGAL --}}
    {{-- Kita cek session 'error' ATAU jika ada validasi error ($errors->any) --}}
    @if (session('error') || $errors->any() || $errors->create->any() || $errors->update->any())
        <div id="toast-error" class="flex items-center w-full max-w-xs p-4 text-white bg-red-700 rounded-lg shadow-lg transition-opacity duration-500" role="alert">
            {{-- Ikon X --}}
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 bg-white text-red-700 rounded-full">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Error icon</span>
            </div>
            
            {{-- Teks --}}
            <div class="ml-3 text-sm font-medium pr-4">
                    Operasi Gagal Dilakukan
            </div>
            
            {{-- Tombol Close --}}
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-white hover:text-gray-200 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 border-l border-red-600" onclick="closeToast('toast-error')">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

</div>

<script>
    // Fungsi untuk menutup toast manual
    function closeToast(id) {
        const element = document.getElementById(id);
        if (element) {
            element.style.opacity = '0';
            setTimeout(() => {
                element.remove();
            }, 500); // Tunggu animasi fade out selesai
        }
    }

    // Otomatis menutup toast setelah 4 detik
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function() {
            closeToast('toast-success');
            closeToast('toast-error');
        }, 4000); // 4000 ms = 4 detik
    });
</script>
</div>