
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="{{  asset('storage/images/logo.png') }}" type="image/x-icon">
    <title>Seascape Yacht Phuket</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <style>
        .video-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            width: 100%;
        }

        .video-container {
            position: relative;
            width: 100%;
            height: 70vh;
            /* Adjust the height as needed */
            overflow: hidden;
        }
    </style>
</head>

<body class="" >
    <!-- Navigation Header -->
    <x-header />
    <!-- Video Background -->
    <div class="video-container">
        <video autoplay muted loop class="video-bg">
            <source src="{{ asset('videos/yachtclip.mp4') }}" type="video/mp4">
        </video>
        <div class="overlay"></div>
    </div>
    <!-- Content -->
    <div class="container mx-auto ">
        @livewire('package-filter')
        <!-- Slider -->

<!-- End Slider -->
    </div>
    <style>
        @keyframes waggle {
          0%, 100% {
            transform: rotate(0deg);
          }
          25% {
            transform: rotate(-10deg);
          }
          50% {
            transform: rotate(10deg);
          }
        }
        .chaty-animation-waggle {
            
          /* animation: waggle 1s ease-in-out infinite; */
          animation: waggle 1.8s linear infinite;

        }
    </style>
    <a href="https://www.facebook.com/profile.php?id=100088973558471" target="_blank" class="hover:chaty-animation-waggle fixed bottom-4 right-4 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition duration-300" aria-label="Facebook Page">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path d="M22.675 0H1.325C.593 0 0 .594 0 1.326v21.348C0 23.406.593 24 1.325 24h11.495v-9.294H9.69v-3.622h3.13V8.413c0-3.1 1.894-4.788 4.661-4.788 1.325 0 2.463.099 2.794.143v3.24h-1.917c-1.503 0-1.795.715-1.795 1.764v2.314h3.59l-.467 3.622h-3.123V24h6.116C23.406 24 24 23.406 24 22.674V1.326C24 .594 23.406 0 22.675 0z"/>
        </svg>
    </a>
    <div class="py-4"></div>
   
    <x-detailyatch/>
    

    @vite('resources/js/app.js')
    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('alert'))
        <script>
            Swal.fire({
                icon: '{{ session('alert.type') }}',
                title: '{{ session('alert.title') }}',
                text: '{{ session('alert.message') }}',
                confirmButtonText: 'ตกลง'
            });
        </script>
    @endif

</body>
<x-footer />

</html>
