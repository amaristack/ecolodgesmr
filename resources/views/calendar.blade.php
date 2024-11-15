<x-layout>
    <x-navbar/>

    <!-- Calendar Section -->
    <section class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Calendar Header with Month Navigation -->
                <div class="flex justify-between items-center mb-6">
                    <button class="text-gray-500 hover:text-gray-700" onclick="prevMonth()">
                        <i class="fa fa-chevron-left"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-700" id="calendar-month">October 2024</h2>
                    <button class="text-gray-500 hover:text-gray-700" onclick="nextMonth()">
                        <i class="fa fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Day Labels -->
                <div class="grid grid-cols-7 text-center text-gray-600 font-semibold">
                    <div class="py-3">Sun</div>
                    <div class="py-3">Mon</div>
                    <div class="py-3">Tue</div>
                    <div class="py-3">Wed</div>
                    <div class="py-3">Thu</div>
                    <div class="py-3">Fri</div>
                    <div class="py-3">Sat</div>
                </div>

                <!-- Calendar Dates -->
                <div class="grid grid-cols-7 gap-2 text-center" id="calendar-dates">
                    <!-- Dates will be dynamically generated -->
                </div>
            </div>
        </div>
    </section>

    <x-footer/>
</x-layout>

<script>
    // Select elements
    const calendarDates = document.getElementById('calendar-dates');
    const monthDisplay = document.getElementById('calendar-month');
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    // Render the calendar for a specific month and year
    function renderCalendar(month, year) {
        // Clear previous dates
        calendarDates.innerHTML = '';

        // Month and Year display
        monthDisplay.innerText = new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' });

        // Get first and last day of the month
        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        // Get today's date
        const today = new Date();
        const isCurrentMonth = today.getMonth() === month && today.getFullYear() === year;

        // Adding blank days for the first week
        for (let i = 0; i < firstDay; i++) {
            calendarDates.innerHTML += `<div class="py-2 text-gray-400"></div>`;
        }

        // Adding dates with optional activity markers
        for (let date = 1; date <= lastDate; date++) {
            const isToday = isCurrentMonth && date === today.getDate();
            calendarDates.innerHTML += `
            <div class="py-6 rounded-lg transition duration-150 cursor-pointer ${
                isToday ? 'bg-yellow-300' : 'bg-gray-200 hover:bg-yellow-100'
            }">
                <span class="text-gray-700 font-semibold">${date}</span>
                <!-- Optional: Placeholder for activities -->
                <span class="block text-xs text-gray-500 mt-1"></span>
            </div>`;
        }
    }

    // Navigate to the previous month
    function prevMonth() {
        currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
        currentYear = (currentMonth === 11) ? currentYear - 1 : currentYear;
        renderCalendar(currentMonth, currentYear);
    }

    // Navigate to the next month
    function nextMonth() {
        currentMonth = (currentMonth === 11) ? 0 : currentMonth + 1;
        currentYear = (currentMonth === 0) ? currentYear + 1 : currentYear;
        renderCalendar(currentMonth, currentYear);
    }

    // Initial Render
    document.addEventListener('DOMContentLoaded', () => {
        renderCalendar(currentMonth, currentYear);
    });

</script>
