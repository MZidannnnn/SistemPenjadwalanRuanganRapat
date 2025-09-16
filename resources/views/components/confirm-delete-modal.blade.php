{{-- Komponen Modal Konfirmasi Hapus --}}
<div id="confirmDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 m-4 max-w-sm w-full text-center">
        
        {{-- Ikon Tong Sampah --}}
        <div class="mx-auto flex items-center justify-center h-16 w-16 bg-red-100 rounded-full mb-4">
            {{-- KODE SVG UNTUK IKON TONG SAMPAH --}}
            <svg class="h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.872 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
        </div>

        <h3 class="text-xl font-bold text-gray-800">Delete</h3>
        <p class="text-gray-500 mt-2 mb-6">Are you sure you want to delete?</p>

        {{-- Form ini akan di-submit saat tombol Confirm ditekan --}}
        <form id="deleteForm" action="" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="flex justify-center space-x-4">
                <button type="button" onclick="closeConfirmModal()" class="bg-gray-200 text-gray-800 font-semibold px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="submit" class="bg-red-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-red-700 transition">
                    Confirm
                </button>
            </div>
        </form>

    </div>
</div>
<script>
    const confirmDeleteModal = document.getElementById('confirmDeleteModal');
    const deleteForm = document.getElementById('deleteForm');

    function openConfirmModal(id) {
        // Atur action form sesuai dengan ID yang dikirim
        deleteForm.action = `/ruangan/${id}`;
        
        // Tampilkan modal konfirmasi
        confirmDeleteModal.classList.remove('hidden');
        confirmDeleteModal.classList.add('flex');
    }

    function closeConfirmModal() {
        confirmDeleteModal.classList.add('hidden');
        confirmDeleteModal.classList.remove('flex');
    }
</script>
