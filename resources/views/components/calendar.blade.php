    <style>
        .calendar-grid-item {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .calendar-grid-item:hover {
            background-color: #f3f4f6;
        }

        .selected {
            background-color: #3B82F6;
            color: white;
        }

        .today {
            background-color: #EF4444;
            color: white;
        }

        .disabled {
            color: #d1d5db;
            cursor: not-allowed;
        }
    </style>
<div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Pengelola Pemesanan</h1>

        {{-- Calendar Container --}}
        <div class="flex justify-center">
            <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-xl">

                {{-- Calendar Header --}}
                <div class="flex items-center justify-between mb-4">
                    <button id="prevButton" class="p-2 rounded-full hover:bg-gray-100">&larr;</button>
                    <button id="modeButton"
                        class="text-lg font-semibold text-gray-800 hover:bg-gray-100 px-3 py-1 rounded-md"></button>
                    <button id="nextButton" class="p-2 rounded-full hover:bg-gray-100">&rarr;</button>
                </div>

                {{-- Container untuk semua view kalender --}}
                <div id="calendarViews">
                    {{-- View 1: Tampilan Hari (Default) --}}
                    <div id="dayView">
                        <div class="grid grid-cols-7 gap-1 mb-2 text-center text-gray-400 text-sm">
                            <div>Sen</div>
                            <div>Sel</div>
                            <div>Rab</div>
                            <div>Kam</div>
                            <div>Jum</div>
                            <div>Sab</div>
                            <div>Min</div>
                        </div>
                        <div id="calendarGrid" class="grid grid-cols-7 gap-1"></div>
                    </div>

                    {{-- View 2: Tampilan Bulan (Hidden) --}}
                    <div id="monthView" class="hidden grid grid-cols-4 gap-2"></div>

                    {{-- View 3: Tampilan Tahun (Hidden) --}}
                    <div id="yearView" class="hidden grid grid-cols-4 gap-2"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();
        let selectedDate = today;
        let currentView = 'day'; // 'day', 'month', 'year'

        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
            'Oktober', 'November', 'Desember'
        ];

        // --- ELEMEN UTAMA ---
        const modeButton = document.getElementById('modeButton');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        const dayView = document.getElementById('dayView');
        const monthView = document.getElementById('monthView');
        const yearView = document.getElementById('yearView');

        // --- FUNGSI NAVIGASI ---
        function navigate(direction) {
            if (currentView === 'day') {
                currentMonth += direction;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
            } else if (currentView === 'month') {
                currentYear += direction;
            } else if (currentView === 'year') {
                currentYear += direction * 10;
            }
            render();
        }

        // --- FUNGSI GANTI VIEW ---
        function switchView() {
            if (currentView === 'day') {
                currentView = 'month';
            } else if (currentView === 'month') {
                currentView = 'year';
            }
            render();
        }

        // --- FUNGSI RENDER UTAMA ---
        function render() {
            dayView.classList.add('hidden');
            monthView.classList.add('hidden');
            yearView.classList.add('hidden');

            if (currentView === 'day') {
                dayView.classList.remove('hidden');
                renderDayView();
            } else if (currentView === 'month') {
                monthView.classList.remove('hidden');
                renderMonthView();
            } else if (currentView === 'year') {
                yearView.classList.remove('hidden');
                renderYearView();
            }
        }

        // --- FUNGSI RENDER VIEW SPESIFIK ---
        function renderDayView() {
            modeButton.textContent = `${monthNames[currentMonth]} ${currentYear}`;
            // (Isi dengan kode render kalender harian Anda yang sudah ada)
            // ... pastikan onclick pada tanggal memanggil fungsi untuk menampilkan detail
        }

        function renderMonthView() {
            modeButton.textContent = currentYear;
            monthView.innerHTML = '';
            monthNames.forEach((name, index) => {
                let classes = "calendar-grid-item";
                if (index === today.getMonth() && currentYear === today.getFullYear()) classes += ' today';

                const monthEl = document.createElement('div');
                monthEl.className = classes;
                monthEl.textContent = name.substring(0, 3);
                monthEl.onclick = () => {
                    currentMonth = index;
                    currentView = 'day';
                    render();
                };
                monthView.appendChild(monthEl);
            });
        }

        function renderYearView() {
            const startYear = Math.floor(currentYear / 10) * 10;
            modeButton.textContent = `${startYear} - ${startYear + 9}`;
            yearView.innerHTML = '';
            for (let i = -2; i < 10; i++) {
                const year = startYear + i;
                let classes = "calendar-grid-item";
                if (year < startYear || year > startYear + 9) classes += ' disabled';
                if (year === today.getFullYear()) classes += ' today';

                const yearEl = document.createElement('div');
                yearEl.className = classes;
                yearEl.textContent = year;
                yearEl.onclick = () => {
                    currentYear = year;
                    currentView = 'month';
                    render();
                };
                yearView.appendChild(yearEl);
            }
        }

        // --- EVENT LISTENERS ---
        modeButton.onclick = switchView;
        prevButton.onclick = () => navigate(-1);
        nextButton.onclick = () => navigate(1);

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', render);
    </script>
@endpush
</div>
