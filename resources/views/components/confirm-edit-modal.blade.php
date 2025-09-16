<div>
    <div id="confirmEditModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-8 m-4 max-w-sm w-full text-center">

            {{-- Ikon Warning --}}
            <div class="mx-auto flex items-center justify-center h-16 w-16 bg-blue-100 rounded-full mb-4">
                {{-- KODE SVG UNTUK IKON WARNING --}}
                <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-800">Warning</h3>
            <p class="text-gray-500 mt-2 mb-6">Are you sure about this action?</p>

            <div class="flex justify-center space-x-4">
                <button type="button" onclick="closeConfirmEditModal()"
                    class="bg-white text-gray-800 font-semibold px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                    Cancel
                </button>
                <button type="button" onclick="document.getElementById('editForm').submit()"
                    class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Confirm
                </button>
            </div>
        </div>
    </div>

</div>
    <script>
        const confirmEditModal = document.getElementById('confirmEditModal');

        function openConfirmEditModal() {
            confirmEditModal.classList.remove('hidden');
            confirmEditModal.classList.add('flex');
        }

        function closeConfirmEditModal() {
            confirmEditModal.classList.add('hidden');
            confirmEditModal.classList.remove('flex');
        }
    </script>
