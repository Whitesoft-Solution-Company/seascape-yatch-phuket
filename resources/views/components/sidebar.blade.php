
    <div class="flex h-screen">

        <!-- ปุ่มเปิด/ปิด Sidebar -->
        <button id="toggle-sidebar" class="lg:hidden  p-4 fixed top-0 left-0 z-50">
            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Sidebar -->
        <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0  bg-gray-50 dark:bg-gray-800 shadow-lg">
            <div class="flex items-center justify-center p-4 bg-white dark:bg-gray-900">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-32 h-auto">
            </div>

            <!-- เมนู -->
            <div class="px-3 py-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                  @if (in_array(auth()->user()->class, [1]))
                    <li>
                        <a href="{{ route('package') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 1.5a10.5 10.5 0 100 21 10.5 10.5 0 000-21zM5.25 8.5h13.5v7H5.25v-7z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3">Packages</span>
                        </a>
                    </li>
                    @endif
                    @if (in_array(auth()->user()->class, [1]))
                     <li>
                        <a href="{{ route('admin.agents.index') }}"  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.25 2.25h13.5v3H5.25v-3zM4.5 7.5h15v12h-15v-12z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3">Agents</span>
                        </a>
                    </li>
                     @endif
                    @if (in_array(auth()->user()->class, [1, 2]))
                    <li>
                        <a href="{{ route('calendar') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.25 2.25h13.5v3H5.25v-3zM4.5 7.5h15v12h-15v-12z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3">Calendar</span>
                        </a>
                    </li>
                     @endif
                    @if (in_array(auth()->user()->class, [1, 2]))
                    <li>
                        <a href="{{ route('admin.bookings') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.25 2.25h13.5v3H5.25v-3zM4.5 7.5h15v12h-15v-12z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3">Booking</span>
                        </a>
                    </li>
                     @endif
                    @if (in_array(auth()->user()->class, [1, 2]))
                    <li>
                        <a href="{{ route('report') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.25 2.25h13.5v3H5.25v-3zM4.5 7.5h15v12h-15v-12z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3">Report</span>
                        </a>
                    </li>
                     @endif
                   
                   
                    <!-- เพิ่มเมนูอื่นๆ ที่นี่ -->
                </ul>
            </div>
        </aside>


    <!-- JavaScript -->
    <script>
        const sidebar = document.getElementById('default-sidebar');
        const toggleSidebar = document.getElementById('toggle-sidebar');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>

