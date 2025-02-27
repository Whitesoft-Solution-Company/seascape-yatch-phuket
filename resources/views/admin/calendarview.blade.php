<x-guest-layout>
    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calendar View</title>
        @livewireStyles

        <style>
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
                overflow: auto;

            }

        </style>
    </head>
    <body >

   
       
       <div class="container mx-auto mt-5 p-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Livewire Calendar -->
                    <div>
                        <livewire:calendar-view />
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <style>
                            /* Dark Mode Styles for Table */
                            .dark table {
                                border-color: #4a5568;
                                background-color: #2d3748; /* พื้นหลังของตาราง */
                                color: #f7fafc; /* สีข้อความ */
                            }

                            .dark th {
                                background-color: #1a202c; /* พื้นหลังของหัวตาราง */
                                color: #f7fafc; /* สีข้อความหัวตาราง */
                            }

                            .dark td {
                                background-color: #2d3748; /* พื้นหลังของเซลล์ */
                                color: #f7fafc; /* สีข้อความในเซลล์ */
                            }

                            .dark tr:nth-child(even) td {
                                background-color: #3a3f4b; /* พื้นหลังแถวคู่ */
                            }
                        </style>

                        <table class="min-w-full border-collapse border border-gray-600">
                             @if($package)
                                  <td colspan="2" class="border border-gray-300 px-4 py-2 text-center">
                                    ไม่มีข้อมูลแพ็คเก็จในขณะนี้
                                  </td>
                            @else
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 bg-blue-900 px-4 py-2 text-center text-white">Destination</th>
                                    @foreach ($duration as $durations)
                                        <th class="border border-gray-300 bg-blue-900 px-4 py-2 text-center text-white">
                                            {{ \Carbon\Carbon::parse($durations->start_time)->locale('th')->isoFormat('D MMMM YYYY') }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               


                                @foreach ($package as $packages)
                                    <tr>
                                        <th class="border border-gray-300 bg-blue-50 px-4 py-2 text-left" width="35%">
                                            {{ $packages->name_boat }}
                                        </th>
                                        @foreach ($duration as $durations)
                                            <td class="border border-gray-300 px-4 py-2 text-center">
                                                @if ($durations->start_time == $packages->start_time)
                                                   {{ number_format($packages->prices[0]->regular )}} THB 
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>

                            @endif
                        </table>
                    </div>
                </div>
            </div>


        </div>
  


        @livewireScripts

        @if (session('status'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: "{{ session('status') === 'success' ? 'สำเร็จ!' : 'ข้อผิดพลาด!' }}",
                        text: "{{ session('message') }}",
                        icon: "{{ session('status') }}",
                        confirmButtonText: 'ตกลง'
                    });
                });
            </script>
        @endif

        <!-- FullCalendar CSS -->
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css' rel='stylesheet' />

        <!-- FullCalendar JS -->
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    </body>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
</script>
    </html>
</x-guest-layout>
