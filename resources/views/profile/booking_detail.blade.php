<x-header />

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <title>Payment Success</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-800 to-blue-400">
        <div id="captureArea" class="relative bg-white rounded-lg shadow-lg p-6 sm:p-8 max-w-md mx-auto text-center">
            <!-- ปุ่มกลับ -->
            <a href="/"
                class="absolute top-4 left-4 flex items-center text-blue-500 hover:text-blue-700 transition-colors">
                <img src="https://img.icons8.com/ios-filled/50/000000/left.png" alt="Back Icon" class="h-6 w-6 mr-2">
                กลับ
            </a>

            <!-- ติ๊กถูกสีเขียว -->
            <div class="flex justify-center mb-6 mt-2">
                <!-- เพิ่ม mt-12 เพื่อให้เว้นที่ว่างระหว่างปุ่มกลับกับเนื้อหา -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-green-500 mb-4">การชำระเงินสำเร็จ!</h2>
            <p class="text-gray-600 mb-6 text-sm sm:text-base">ขอบคุณสำหรับการชำระเงิน กรุณาบันทึก QR Code
                ด้านล่างเพื่อแสดงหลักฐานแก่เจ้าหน้าที่ก่อนเดินทาง
            </p>
            <p class="text-gray-600 mb-2 text-sm sm:text-base">
                ทริป : <span class="bg-blue-300 text-black px-1 pt-0.2 pb-1 rounded">
                    {{ $booking->package->packageType->trip_type }}</span>
                {{ $booking->package->name_boat }}
            </p>
            <p class="text-gray-600 mb-2 text-sm sm:text-base">
                วันที่เดินทาง
                @if ($booking->departure_date)
                    {{ $booking->departure_date }} เดินทางกลับ {{ $booking->return_date }}
                @else
                    {{ $booking->booking_time }}
                @endif
            </p>
            <p class="text-gray-600 mb-6 text-sm sm:text-base">
                จำนวนผู้โดยสาร
                {{ $booking->seat }}
                ท่าน
            </p>

            <!-- QR Code -->
            <div class="flex justify-center mb-6">
                <div>{!! $qrcode !!}</div>
            </div>

            <!-- ปุ่มย้อนกลับหรือดำเนินการต่อ -->
            <div class="mt-6">
                <button id="downloadButton"
                    class="text-white bg-green-500 hover:bg-green-600 font-bold py-2 px-4 rounded-full shadow-lg">
                    บันทึก
                </button>
                <div class="mt-6">
                    <a href="{{route('home')}}"
                        class="text-white bg-blue-500 hover:bg-blue-600 font-bold py-2 px-4 rounded-full shadow-lg">
                        กลับสู่หน้าหลัก
                    </a>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
<script>
    document.getElementById('downloadButton').addEventListener('click', function() {
        
        // แคปเจอร์เฉพาะส่วนที่มี id เป็น captureArea
        html2canvas(document.getElementById('captureArea')).then(function(canvas) {
            // แปลง canvas เป็นรูปภาพ
            var link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = 'capture_area.png';
            link.click();
        });
    });
</script>

</html>
