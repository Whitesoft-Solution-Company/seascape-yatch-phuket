<x-app-layout>
    @livewireStyles
    <div class="container mx-auto mt-5 xl:ml-64 lg:ml-64 ">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Calendar</h1>
        </div>

        <!-- Grid สำหรับปฏิทิน -->
        <livewire:calendar-component />
    </div>

    @if (session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: session('status') === 'success' ? 'สำเร็จ!' : 'ข้อผิดพลาด!',
                text: "{{ session('message') }}",
                icon: session('status'), // icon จะเป็น 'success' หรือ 'error' ตาม session
                confirmButtonText: 'ตกลง'
            });
        });
    </script>
    @endif



    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css' rel='stylesheet' />

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>


</x-app-layout>