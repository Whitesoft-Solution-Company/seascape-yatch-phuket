<div>
   <!-- resources/views/components/header.blade.php -->
<header class="bg-gray-800 text-white">
    <div class="container mx-auto flex justify-between items-center p-4">
        <!-- Logo -->
        <div class="text-2xl font-bold ">
            <a href="{{route('home')}}" class="hover:text-yellow-500 text-white">Seascape Yacht Lipe</a>
        </div>
        <!-- Navigation Menu -->
        <nav class="space-x-4">
            <a href="{{route('home')}}" class="hover:text-yellow-500  text-white">Home</a>

            @if (Auth::check())
            <!-- ถ้าผู้ใช้ล็อกอินอยู่ ให้แสดงปุ่ม Logout -->
            <a href="{{ route('logout') }}" class="btn btn-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <!-- ถ้าผู้ใช้ยังไม่ล็อกอิน ให้แสดงปุ่ม Login with Google -->
            <a href="{{ route('google.login') }}" class="btn  flex items-center text-black  rounded-lg px-2 py-2 whitespace-nowrap">
                <img src="{{ asset('storage/images/google.png') }}" alt="Google Logo" class="w-5 h-5  ">
            
            </a>
            
            
            
            
        @endif
        
            
        </nav>
    </div>
</header>

</div>