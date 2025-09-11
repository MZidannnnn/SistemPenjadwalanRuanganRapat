<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .bg-custom-gradient {
            background: linear-gradient(to right, #1540AA, #0646E7);
        }

        .calendar-day {
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .selected-date {
            background-color: #5B8DEF;
            color: white;
            border-radius: 8px;
        }

        .today-date {
            background-color: #EF4444;
            color: white;
            border-radius: 8px;
            font-weight: bold;
        }

        .detail-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="bg-gray-100">

    {{-- Topbar Navigation --}}
    <nav class="bg-custom-gradient text-white shadow-md">
        <div class="container mx-auto px-6 py-2 flex justify-between items-center">

            {{-- Logo dan Judul Kiri --}}
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo-pemkot.png') }}" alt="Logo" class="h-12 w-12">
                <a href="/dashboard" class="text-3xl font-bold">Dashboard</a>
            </div>

            {{-- Menu Tengah --}}
            <div class="hidden md:flex items-center space-x-10">
                <a href="#"
                    class="flex flex-col items-center hover:text-gray-300 transition duration-150 text-xs">
                    <img src="{{ asset('images/icons8-scheduling-32 (1).png') }}" alt="Pemesanan" class="h-6 w-6 mb-1">
                    <span>Pemesanan</span>
                </a>
                <a href="#"
                    class="flex flex-col items-center hover:text-gray-300 transition duration-150 text-xs">
                    <img src="{{ asset('images/icons8-meeting-room-50.png') }}" alt="Ruangan" class="h-6 w-6 mb-1">
                    <span>Ruangan</span>
                </a>
                <a href="#"
                    class="flex flex-col items-center hover:text-gray-300 transition duration-150 text-xs">
                    <img src="{{ asset('images/icons8-user-24.png') }}" alt="User" class="h-6 w-6 mb-1">
                    <span>User</span>
                </a>
            </div>

            {{-- Tombol Keluar Kanan --}}
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center space-x-2 hover:text-gray-300 transition duration-150">

                        <img src="{{ asset('images/icons8-logout-24.png') }}" alt="Keluar" class="h-5 w-5">
                        <span>Keluar</span>
                    </a>
                </form>
            </div>

        </div>
    </nav>



    {{-- Main Content Area --}}
    <main class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

        {{-- Calendar Container --}}
        <div class="flex justify-center">
            <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-2xl">

                {{-- Calendar Header with Navigation --}}
                <div class="flex items-center justify-between mb-6">
                    <button onclick="previousMonth()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>

                    <h2 id="currentMonthYear" class="text-lg font-semibold text-gray-800">January 2023</h2>

                    <button onclick="nextMonth()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>

                {{-- Days of Week Header --}}
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div class="text-center text-gray-400 text-sm py-2">Sen</div>
                    <div class="text-center text-gray-400 text-sm py-2">Sel</div>
                    <div class="text-center text-gray-400 text-sm py-2">Rab</div>
                    <div class="text-center text-gray-400 text-sm py-2">Kam</div>
                    <div class="text-center text-gray-400 text-sm py-2">Jum</div>
                    <div class="text-center text-gray-400 text-sm py-2">Sab</div>
                    <div class="text-center text-gray-400 text-sm py-2">Min</div>
                </div>

                {{-- Calendar Grid --}}
                <div id="calendarGrid" class="grid grid-cols-7 gap-1">
                    <!-- Calendar days will be generated here by JavaScript -->
                </div>

                {{-- Detail Button --}}
                <div class="flex justify-end mt-6">
                    <button onclick="showDetails()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors shadow-md">
                        Detail
                    </button>
                </div>
            </div>
        </div>

        {{-- BAGIAN JADWAL RUANGAN HARI INI --}}
        <div class="mt-12">

            {{-- Header Jadwal --}}
            <div>
                <h2 class="text-xl font-bold text-gray-800">Jadwal Ruangan Hari Ini</h2>
                <p id="currentDate" class="text-gray-500 mt-1">Loading...</p>
            </div>

            {{-- Kolom Pencarian --}}
            <div class="mt-6 mb-4">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Cari jadwal..."
                        class="w-full md:w-1/3 pl-10 pr-4 py-2 border bg-white border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- Tabel Jadwal --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ruangan</th>
                                <th
                                    class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lokasi</th>
                                <th
                                    class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu Mulai</th>
                                <th
                                    class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu Selesai</th>
                                <th
                                    class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 text-sm font-medium text-gray-900">Command Center</td>
                                <td class="py-4 px-6 text-sm text-gray-500">Blok A</td>
                                <td class="py-4 px-6 text-sm text-gray-500">08:00</td>
                                <td class="py-4 px-6 text-sm text-gray-500">12:00</td>
                                <td class="py-4 px-6 text-sm">
                                    <span
                                        class="bg-green-100 text-green-800 px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        Selesai
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 text-sm font-medium text-gray-900">Command Center</td>
                                <td class="py-4 px-6 text-sm text-gray-500">Blok A</td>
                                <td class="py-4 px-6 text-sm text-gray-500">12:00</td>
                                <td class="py-4 px-6 text-sm text-gray-500">16:00</td>
                                <td class="py-4 px-6 text-sm">
                                    <span
                                        class="bg-yellow-100 text-yellow-800 px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        Terjadwal
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    {{-- Modal for Meeting Details --}}
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl p-6 m-4 max-w-lg w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Detail Rapat</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div id="meetingContent" class="space-y-4">
                <!-- Meeting details will be inserted here -->
            </div>

            <div class="mt-6 flex justify-end">
                <button onclick="closeModal()"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // Calendar variables - menggunakan tanggal hari ini
        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();
        let selectedDate = today.getDate();

        // Sample meeting data (this will come from database later)
        const meetingData = {
            // Data untuk hari ini
            [`${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`]: [{
                    title: 'Rapat Koordinasi Tim',
                    time: '09:00 - 11:00',
                    room: 'Ruang Rapat A',
                    attendees: 15,
                    description: 'Pembahasan progress project bulan ini'
                },
                {
                    title: 'Meeting dengan Vendor',
                    time: '14:00 - 16:00',
                    room: 'Ruang Rapat B',
                    attendees: 8,
                    description: 'Diskusi kerjasama pengadaan'
                }
            ]
        };

        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        const dayNames = [
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        ];

        function initCalendar() {
            // Update tanggal hari ini
            updateCurrentDate();
            renderCalendar();
        }

        function updateCurrentDate() {
            const today = new Date();
            const dayName = dayNames[today.getDay()];
            const monthName = monthNames[today.getMonth()];
            const formattedDate = `${dayName}, ${today.getDate()} ${monthName} ${today.getFullYear()}`;
            document.getElementById('currentDate').textContent = formattedDate;
        }

        function renderCalendar() {
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();

            // Adjust for Monday as first day (0 = Monday, 6 = Sunday)
            const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;

            // Update month/year display
            document.getElementById('currentMonthYear').textContent =
                `${monthNames[currentMonth]} ${currentYear}`;

            let calendarHTML = '';

            // Previous month's trailing days
            for (let i = adjustedFirstDay - 1; i >= 0; i--) {
                const day = daysInPrevMonth - i;
                calendarHTML += `
                    <div class="calendar-day text-gray-300 cursor-not-allowed">
                        ${day}
                    </div>
                `;
            }

            // Current month's days
            for (let day = 1; day <= daysInMonth; day++) {
                const dateStr =
                    `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const hasMeeting = meetingData[dateStr];
                const isSelected = (currentMonth === today.getMonth() && currentYear === today.getFullYear() && day ===
                    selectedDate);
                const isToday = (currentMonth === today.getMonth() && currentYear === today.getFullYear() && day === today
                    .getDate());

                let dayClasses = 'calendar-day cursor-pointer hover:bg-gray-100 rounded-lg transition-all';

                if (isToday && !isSelected) {
                    dayClasses += ' today-date';
                } else if (isSelected) {
                    dayClasses += ' selected-date';
                }

                if (hasMeeting) {
                    dayClasses += ' font-semibold';
                }

                calendarHTML += `
                    <div onclick="selectDate(${day})" 
                         class="${dayClasses}">
                        ${day}
                        ${hasMeeting ? '<div class="text-xs text-blue-300">•</div>' : ''}
                    </div>
                `;
            }

            // Next month's leading days
            const totalCells = adjustedFirstDay + daysInMonth;
            const remainingCells = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
            for (let day = 1; day <= remainingCells; day++) {
                calendarHTML += `
                    <div class="calendar-day text-gray-300 cursor-not-allowed">
                        ${day}
                    </div>
                `;
            }

            document.getElementById('calendarGrid').innerHTML = calendarHTML;
        }

        function selectDate(day) {
            selectedDate = day;
            renderCalendar();
        }

        function previousMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        }

        function showDetails() {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('meetingContent');

            // Check if there are meetings for selected date
            const dateStr =
                `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(selectedDate).padStart(2, '0')}`;
            const meetings = meetingData[dateStr];

            if (meetings && meetings.length > 0) {
                let html = `
                    <div class="text-sm text-gray-600 mb-3">
                        <span class="font-semibold">Tanggal: ${selectedDate} ${monthNames[currentMonth]} ${currentYear}</span>
                    </div>
                `;

                meetings.forEach((meeting, index) => {
                    html += `
                        <div class="border-l-4 border-blue-500 pl-4 py-3 ${index > 0 ? 'mt-4' : ''}">
                            <h4 class="font-semibold text-gray-800 mb-2">${meeting.title}</h4>
                            <div class="space-y-1 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <span class="mr-2">⏰</span>
                                    <span>Waktu: ${meeting.time}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="mr-2">📍</span>
                                    <span>Ruangan: ${meeting.room}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="mr-2">👥</span>
                                    <span>Peserta: ${meeting.attendees} orang</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="mr-2">📝</span>
                                    <span>${meeting.description}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });

                content.innerHTML = html;
            } else {
                content.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2z"></path>
                        </svg>
                        <p>Tidak ada rapat pada tanggal ${selectedDate} ${monthNames[currentMonth]} ${currentYear}</p>
                    </div>
                `;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Initialize calendar when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initCalendar();
        });
    </script>

</body>

</html>
