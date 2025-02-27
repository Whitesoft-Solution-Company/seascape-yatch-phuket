<x-app-layout>
    <div class="container mx-auto mt-5  xl:ml-64 lg:ml-64 ">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Packages</h1>
            <form method="GET" action="{{ route('packages.index') }}" class="mb-4 flex space-x-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหา Package..."
           class="border px-4 py-2 rounded">
    
    <select name="type" class="w-full border border-gray-300 rounded px-4 py-2">
    @foreach ($packageTypes as $nameTh => $types)
        <option value="{{ $nameTh }}">
            {{ $nameTh }}
        </option>
    @endforeach
</select>


    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">ค้นหา</button>
</form>


            <!-- ปุ่มเปิด modal สำหรับสร้าง package ใหม่ -->
            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="openModal('createModal')">
                สร้าง Package ใหม่
            </button>
        </div>

        <!-- แสดง Package ในตาราง -->
        <table class="table-auto w-full mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">ชื่อ Package</th>
                    <th class="px-4 py-2">จำนวนแขกสูงสุด</th>
                    <th class="px-4 py-2">ชนิดทริป</th>
                    <th class="px-4 py-2">การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                <tr>
                    <td class="border px-4 py-2">{{ $package->name_boat }}</td>
                    <td class="border px-4 py-2">{{ $package->max_guest }}</td>
                    <td class="border px-4 py-2">{{ $package->type }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <!-- ปุ่มเปิด modal แก้ไข -->
                        <button class="bg-yellow-500 text-white px-4 py-2 rounded"
                            onclick="openModal('editModal{{ $package->id }}')">
                            แก้ไข
                        </button>

                        <!-- ปุ่มเปิด modal ลบ -->
                        <button class="bg-red-500 text-white px-4 py-2 rounded"
                            onclick="openModal('deleteModal{{ $package->id }}')">
                            ลบ
                        </button>
                    </td>
                </tr>

                <!-- Modal แก้ไข package -->
                <div class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center"
                    id="editModal{{ $package->id }}">
                    <div class="bg-white p-6 rounded shadow-lg max-w-2xl mx-auto">
                        <h2 class="text-xl font-bold mb-4">แก้ไข Package</h2>
                        <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4">
                                <div class="mb-4">
                                    <label for="name_boat" class="block font-medium">ชื่อ Package</label>
                                    <input type="text" name="name_boat" value="{{ $package->name_boat }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="max_guest" class="block font-medium">จำนวนแขกสูงสุด</label>
                                    <input type="number" name="max_guest" value="{{ $package->max_guest }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="type" class="block font-medium">ชนิดทริป</label>
                                   <select name="type" class="w-full border border-gray-300 rounded px-4 py-2">
                                            @foreach ($packageTypes as $type)
                                                <option value="{{ $type->id }}" {{ $package->type == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name_th }} <!-- เปลี่ยน "name" เป็น property ที่ต้องการแสดง -->
                                                </option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="mb-4">
                                    <label for="price_agent" class="block font-medium">ราคาเอเย่นต์</label>
                                    <input type="number" name="price_agent" value="{{ $package->prices[0]->agent }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="price_regular" class="block font-medium">ราคาปกติ</label>
                                    <input type="number" name="price_regular" value="{{ $package->prices[0]->regular }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="price_sub" class="block font-medium">ราคาในเครือ</label>
                                    <input type="number" name="price_sub" value="{{ $package->prices[0]->subordinate }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="image" class="block font-medium">รูปภาพ</label>
                                    <input type="file" name="image" class="w-full border border-gray-300 rounded px-4 py-2">
                                    @if ($package->image)
                                        <img src="{{ asset('storage/package/' . $package->image) }}" alt="Package Image" class="mt-2 h-20">
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <label for="min" class="block font-medium">จำนวนต่ำสุด</label>
                                    <input type="number" name="min" value="{{ $package->min }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="max" class="block font-medium">จำนวนสูงสุด</label>
                                    <input type="number" name="max" value="{{ $package->max }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="start_time" class="block font-medium">เวลาเริ่มต้น</label>
                                    <input type="date" name="start_time" value="{{ $package->start_time }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_time" class="block font-medium">เวลาสิ้นสุด</label>
                                    <input type="date" name="end_time" value="{{ $package->end_time }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-4">
                                <div class="mb-4">
                                    <label for="note" class="block font-medium">หมายเหตุ</label>
                                    <textarea name="note" class="w-full border border-gray-300 rounded px-4 py-2">{{ $package->note }}</textarea>
                                </div>
                            </div>
                            <div class="justify-end">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2" onclick="closeModal('editModal{{ $package->id }}')">ยกเลิก</button>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">บันทึก</button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Modal ลบ package -->
                <div class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center"
                    id="deleteModal{{ $package->id }}">
                    <div class="bg-white p-6 rounded shadow-lg max-w-2xl mx-auto">
                        <h2 class="text-xl font-bold mb-4">ยืนยันการลบ</h2>
                        <form action="{{ route('packages.destroy', $package->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <p>คุณแน่ใจหรือว่าต้องการลบ Package นี้?</p>
                            <div class="flex justify-end">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2" onclick="closeModal('deleteModal{{ $package->id }}')">ยกเลิก</button>
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">ลบ</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
    {{ $packages->links() }}
</div>
    </div>

    <!-- Modal สร้าง package ใหม่ -->
    <div  class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50 " id="createModal">
        <div class="  bg-white rounded-lg shadow-lg p-6 max-w-4xl w-full overflow-y-auto max-h-[90vh] mt-10 mb-10">
            <h2 class="text-xl font-bold mb-4">สร้าง Package ใหม่</h2>
            <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4  ">
                <div class="mb-4">
                    <label for="name_boat" class="block font-medium">ชื่อ Package</label>
                    <input type="text" name="name_boat" class="w-full border border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="max_guest" class="block font-medium">จำนวนแขกสูงสุด</label>
                    <input type="number" name="max_guest" class="w-full border border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="type" class="block font-medium">ชนิดทริป</label>
                    <select name="type" class="w-full border border-gray-300 rounded px-4 py-2">
                        @foreach ($packageTypes as  $types)
                            <option value="{{ $types->id }}">
                                {{ $types->name_th }} 
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="mb-4">
                    <label for="min" class="block font-medium">ราคาเอเย่นต์</label>
                    <input type="number" name="price_agent" class="w-full border border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="min" class="block font-medium">ราคาปกติ</label>
                    <input type="number" name="price_regular" class="w-full border border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="min" class="block font-medium">ราคาในเครือ</label>
                    <input type="number" name="price_sub" class="w-full border border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="image" class="block font-medium">รูปภาพ</label>
                    <input type="file" name="image" class="w-full border border-gray-300 rounded px-4 py-2">
                </div>

                <div class="mb-4">
                    <label for="min" class="block font-medium">จำนวนต่ำสุด</label>
                    <input type="number" name="min" class="w-full border border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="max" class="block font-medium">จำนวนสูงสุด</label>
                    <input type="number" name="max" class="w-full border border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="start_time" class="block font-medium">เวลาเริ่มต้น</label>
                    <input type="date" name="start_time" class="w-full border border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="end_time" class="block font-medium">เวลาสิ้นสุด</label>
                    <input type="date" name="end_time" class="w-full border border-gray-300 rounded px-4 py-2" required>
                </div>
                
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-4  ">
                <div class="mb-4">
                    <label for="note" class="block font-medium">หมายเหตุ</label>
                    <textarea name="note" class="w-full border border-gray-300 rounded px-4 py-2"></textarea>
                </div>
            </div>
            <div class=" justify-end">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2" onclick="closeModal('createModal')">ยกเลิก</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">สร้าง</button>
            </div>
            </form>
        </div>
    </div>

    <!-- Script สำหรับเปิด/ปิด modal -->
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</x-app-layout>