<x-header />
<x-guest-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-center mb-4">กรอกเบอร์โทรศัพท์</h2>

                <form method="POST" action="{{ route('phone.update') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">เบอร์โทรศัพท์:</label>
                        <input id="phone" type="text" name="phone"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}" required autofocus>

                        @error('phone')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            บันทึกเบอร์โทร
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'บันทึกสำเร็จ!',
                text: 'ข้อมูลของคุณถูกบันทึกเรียบร้อยแล้ว',
                icon: 'success',
                confirmButtonText: 'ตกลง'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/') }}"; // เปลี่ยนลิงก์เป็นหน้า index
                }
            });
        </script>
    @endif
</x-guest-layout>
@vite('resources/css/app.css')