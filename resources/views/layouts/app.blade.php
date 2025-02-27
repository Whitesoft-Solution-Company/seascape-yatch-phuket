<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="icon" href="{{  asset('storage/images/logo.png') }}" type="image/x-icon">

     <title>Seascape Yacht Phuket</title>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.default.min.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @livewireStyles <!-- Livewire Styles -->

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
   
    

    <div class="flex-1 p-6 transition-all duration-300"
    :class="{
        'ml-0': window.innerWidth < 640, 
        'ml-16': window.innerWidth >= 640 && window.innerWidth < 1024, 
        'ml-64': window.innerWidth >= 1024 && window.innerWidth < 1280, 
        'ml-48': window.innerWidth >= 1280 && window.innerWidth < 1536, 
        'ml-64': window.innerWidth >= 1536
    }">
    
          
            <!-- Page Heading -->
            @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
                <x-sidebar />
            </header>
            @endisset

            <!-- Navigation -->
            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                  <x-sidebar />
                {{ $slot }}
            </main>
        </div>
    

    <!-- Footer -->
    @livewireScripts <!-- Livewire Scripts -->
    @vite('resources/js/app.js')
</body>

</html>