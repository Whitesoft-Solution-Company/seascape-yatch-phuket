<div>
    <style>
        /* Custom Dark Mode Styles for FullCalendar */
        .dark .fc {
            background-color: #1a202c; /* พื้นหลัง */
            color: #f7fafc; /* ข้อความ */
        }

        .dark .fc .fc-daygrid-day {
            background-color: #2d3748; /* พื้นหลังของวัน */
            border-color: #4a5568; /* เส้นขอบ */
        }

        .dark .fc-event {
            background-color: #3182ce; /* พื้นหลังของอีเวนต์ */
            color: #f7fafc; /* ข้อความในอีเวนต์ */
        }
    </style>

    <div wire:ignore.self class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 w-full" id="calendars-container">
        <div wire:ignore.self id="calendar_oneday_trip" class="border p-4 rounded-lg shadow-lg"
            style="border-block-color:blue; border-width: 7px;">
           
            <!-- Calendar Placeholder -->
            <div class="h-96 bg-gray-100 flex items-center justify-center">
                <p>Loading . . .</p>
            </div>
        </div>
    </div>

    <!-- FullCalendar Script -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var events = @json($events); // ดึงข้อมูลอีเวนต์
            var calendarEl = document.getElementById('calendar_oneday_trip');

            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    showNonCurrentDates: false,
                    selectable: true,
                    events: events,
                    eventDidMount: function(info) {
                        info.el.style.textAlign = 'center';
                    }
                });

                // ตรวจจับโหมด Dark Mode
                const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

                function updateDarkMode() {
                    if (darkModeMediaQuery.matches) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }

                darkModeMediaQuery.addEventListener('change', updateDarkMode);
                updateDarkMode();

                calendar.render();
            }
        });
    </script>
</div>
