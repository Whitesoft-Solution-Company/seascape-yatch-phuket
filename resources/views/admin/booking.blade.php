<x-app-layout>
    <style>
        .hidden {
            display: none;
            /* หรือใช้ visibility: hidden; */
        }
        .arrow {
    font-size: 0.9rem;
    margin-left: 0.5rem;
    color: gray;
}

.arrow.ascending::after {
    content: "↑";
    color: black;
}

.arrow.descending::after {
    content: "↓";
    color: black;
}
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <div class="container mx-auto mt-5 xl:ml-64 lg:ml-64  ">
         <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Bookings</h1>
            <!-- ปุ่มเปิด modal สำหรับสร้าง package ใหม่ -->

        </div>
        <div class="flex justify-between items-center">

               <form id="searchForm" method="GET" action="{{ route('admin.bookings') }}" class="mb-4">
                <div class="flex flex-wrap gap-4">
                    <!-- Search Input -->
                    <input type="text" name="search" placeholder="ค้นหา..."
                           class="border border-gray-300 rounded px-4 py-2"
                           value="{{ request('search') }}"
                            onchange="document.getElementById('searchForm').submit();">




                    <!-- Submit Button -->
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                        ค้นหา
                    </button>
                    <button  type="button" onclick="window.location='{{ route('admin.bookings') }}';" class="bg-blue-500 text-white px-4 py-2 rounded">
                       ล้างค่า
                    </button>
                </div>
            </form>

        </div>


        <!-- แสดง Package ในตาราง -->
        <table class="table-auto w-full mt-4">

            <thead>
                <tr class="bg-gray-200">
                     <th class="px-4 py-2 cursor-pointer" onclick="sortTable(0, 'asc')" id="sort-id">
                        #
                        <span class="arrow">↑↓</span>
                    </th>
                    <th class="px-4 py-2">รหัสการจอง</th>
                    <th class="px-4 py-2 cursor-pointer" onclick="sortTable(2, 'date')" id="sort-date">
                        วันที่เดินทาง
                        <span class="arrow">↑↓</span>
                    </th>
                    <th class="px-4 py-2">แพ็คเกจ</th>
                    <th class="px-4 py-2">ชื่อลูกค้า</th>
                    <th class="px-4 py-2">จำนวน</th>
                    <th class="px-4 py-2">Agent</th>
                    <th class="px-4 py-2">การชำระเงิน</th>
                    <th class="px-4 py-2">วันที่ทำรายการ</th>
                    <th class="px-4 py-2">วันที่ชำระเงิน</th>
                    <th class="px-4 py-2">จำนวนเงิน</th>
                    <th class="px-4 py-2">ใบวางวิล</th>
                    @if (auth()->user()->class == 1)
                    <th class="px-4 py-2">ชำระเงิน</th>
                    <th class="px-4 py-2">จัดการ</th>
                    @endif

                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr style="
    @if ($booking->booking_status === 'deleted')
        background-color: #ff5452; color: white;
    @elseif ($booking->booking_status === 'confirmed')
        background-color: #bdffbd; color: black;
    @elseif ($booking->booking_status === 'checked_in')
        background-color: #6efff3; color: black;
    @elseif ($booking->booking_status === 'maintenance')
        background-color: #d3d3d3; color: black;
    @elseif ($booking->booking_status === 'unpaid')
        background-color: #ababab; color: black;
    @else
        background-color: white; color: black;
    @endif">
                        <td class="border px-4 py-2">{{ $booking->id }}</td>
                        <td class="border px-4 py-2">{{ $booking->booking_code }}</td>
                        <td class="border px-4 py-2">{{ $booking->departure_date . ' - ' . $booking->return_date }}</td>
                        <td class="border px-4 py-2">{{ $booking->package->name_boat }}</td>
                        <td class="border px-4 py-2">{{ $booking->name }}</td>
                        <td class="border px-4 py-2">{{ $booking->seat }}</td>
                        <td class="border px-4 py-2">{{ $booking->agents->agent_name ?? '' }}</td>
                        <td
                            class="border px-4 py-2 font-bold"
                            style="
                                @if (in_array($booking->statement_status, ['deposit', 'paid', 'full_payment', 'internal']))
                                    color: green;
                                @elseif (in_array($booking->statement_status, ['unpaid']))
                                    color: red;
                                @elseif (in_array($booking->statement_status, ['ent']))
                                    color: black;
                                @elseif (in_array($booking->statement_status, ['deposit']))
                                 color: orange;
                                @else
                                     color: black;
                                @endif
                            ">{{ $booking->statement_status }}</td>
                        <td class="border px-4 py-2">{{ $booking->created_at }}</td>
                        <td class="border px-4 py-2">{{ $booking->payments[0]->transfer_time  ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $booking->amount }}</td>

                        <td class="border px-4 py-2">
                            <button onclick="invoice1('{{ $booking->id }}');" title="ใบเสนอราคา"
                                class="btn btn-bordered-secondary waves-effect waves-light btn-sm" data-toggle="popover"
                                data-trigger="hover" data-content="ใบที่ 1">
                                <img src="https://img.icons8.com/?size=100&id=7996&format=png&color=31BF1A"
                                    alt="Print" class="h-5 w-5"> {{-- ไอคอนพิมพ์จาก Icon8 --}}
                            </button>
                            <button onclick="invoice2('{{ $booking->id }}');" title="ใบเสนอราคา"
                                class="btn btn-bordered-secondary waves-effect waves-light btn-sm" data-toggle="popover"
                                data-trigger="hover" data-content="ใบที่ 2">
                                <img src="https://img.icons8.com/?size=100&id=7996&format=png&color=35dcf2"
                                    alt="Print" class="h-5 w-5"> {{-- ไอคอนพิมพ์จาก Icon8 --}}
                            </button>
                            <button onclick="invoice3('{{ $booking->id }}');" title="ใบเสนอราคา"
                                class="btn btn-bordered-secondary waves-effect waves-light btn-sm" data-toggle="popover"
                                data-trigger="hover" data-content="ใบที่ 3">
                                <img src="https://img.icons8.com/?size=100&id=7996&format=png&color=f0c930"
                                    alt="Print" class="h-5 w-5"> {{-- ไอคอนพิมพ์จาก Icon8 --}}
                            </button>


                        </td>
                    @if (auth()->user()->class == 1)
                        <td class="border px-4 py-2">
                            <div class="flex items-center space-x-2">
                                <!-- Button 1 -->
                                <button
                                    onclick="openModal('{{ $booking->id }}')"
                                    class="btn btn-bordered-secondary waves-effect waves-light btn-sm"
                                    data-toggle="popover" data-trigger="hover">
                                    <img src="{{ asset('storage/images/2c2p.png') }}" alt="2c2p icon" width="250">
                                </button>


                            </div>

                        </td>

                        <td>
                             <div class="flex items-center space-x-2">
                                <!-- Button 1 -->


                                <!-- Button 2 -->
                                <button
                                    onclick="openModal({{ $booking->id }}, '{{ $booking->booking_status }}')"
                                    class="btn btn-bordered-secondary waves-effect waves-light p-2  rounded">
                                       <img src="https://img.icons8.com/?size=100&id=11324&format=png&color=33C11C"
                                                            alt="Print" width="100" >
                                </button>

                                <!-- Button 3 -->
                                <button
                                    onclick="openEditBookingModal('{{ $booking->id }}')"
                                    class="text-indigo-600 hover:text-red-800 p-2">
                                    แก้ไข
                                </button>

                                <button onclick="deleteBookingOption({{ $booking->id }})" class="text-red-600 hover:text-red-800 p-2">ลบ</button>
                            </div>
                        </td>
                    @endif

                    </tr>
                @endforeach
            </tbody>
        </table>
<div class="mt-4 p-12">
    {{ $bookings->links('pagination::tailwind') }}
</div>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

<div class="mt-4 p-12">
  &nbsp;
</div>

    </div>


    <div class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50"
        id="2c2p">
        <div class="bg-white p-6 rounded shadow-lg max-w-2xl mx-auto">


            <div class="flex justify-center mb-6" id="qrCodeContainer">

            </div>
            <div class="flex justify-end">
                <button type="button" class=" bg-red-500 text-white px-8 py-2 rounded mr-2"
                    onclick="closeModal()">ปิด</button>

            </div>
        </div>
    </div>



    <div class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50 "
        id="editBookingModal">

        <div class="  bg-white rounded-lg shadow-lg p-6 max-w-4xl w-full overflow-y-auto max-h-[90vh] mt-10 mb-10">
            <button class="close absolute top-2 right-2" onclick="closeModaledit()"> <svg class="h-6 w-6"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg></button>
            <h2 class="text-lg font-bold mb-4">Booking Details</h2>

            <form action="{{ route('booking.addbooking') }}" method="POST" enctype="multipart/form-data"
                class="px-5">
                @csrf

                <input type="hidden" name="booking_id" id="bookingId">
                <div class=" bg-gray-100 p-4 rounded-md border-gray-300">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4  ">
                        <!-- รหัสการจอง -->

                        <div class="col-span-1">
                            <label for="input_codebooking"
                                class="block text-sm font-medium text-gray-700">รหัสการจอง</label>
                            <input type="text" id="booking_code" name="booking_code"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>



                        <div class="col-span-1">
                            <label for="nodate"
                                class="block text-sm font-medium text-red-500">*ติ้กเพื่อไม่ระบุวันที่

                            </label>
                            <div class="flex items-center mt-1">
                                <input type="checkbox" id="nodate" name="nodate" onchange="changedate()"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">

                                <input type="date" id="date" name="date"
                                    class="block w-full rounded-md border-gray-300 shadow-sm" maxlength="10" >
                            </div>
                        </div>

                        <div class="col-span-1">
                            <label for="nodate" class="block text-sm font-medium text-gray-700">วันเดินทางกลับ
                            </label>
                            <div class="flex items-center mt-1">

                                <input type="date" id="returndate" name="returndate"
                                    class="block w-full px-3 rounded-md border-gray-300 shadow-sm" maxlength="10">


                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 mt-3">
                        <!-- ชื่อลูกค้า -->
                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">ชื่อลูกค้า</label>
                            <input type="text" id="name" name="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="ชื่อลูกค้า" required>
                        </div>

                        <!-- เบอร์โทรศัพท์ -->
                        <div class="col-span-1">
                            <label for="inputtel" class="block text-sm font-medium text-red-500">*ไม่มีเบอร์โทรศัพท์

                            </label>
                            <div class="flex items-center mt-1">
                                <input type="checkbox" id="notel" name="notel"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2"
                                    onchange="toggleRequired()">
                                <input type="number" id="inputtel" name="inputtel"
                                    class="block w-full rounded-md border-gray-300 shadow-sm" maxlength="10"
                                    placeholder="เบอร์โทร" >
                            </div>
                        </div>

                        <!-- Agents -->
                        <div class="col-span-1">
                            <label for="inputAgent" class="block text-sm font-medium text-gray-700">Agents</label>
                            <select id="agent" name="agent"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1">
                                <option selected disabled>กรุณาเลือก Agent</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->agent_id }}">{{ $agent->agent_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 mt-3">
                        <!-- จองผ่านช่องทาง -->
                        <div class="col-span-1">
                            <label for="inputcontact"
                                class="block text-sm font-medium text-gray-700">จองผ่านช่องทาง</label>
                            <input type="text" id="contact"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>



                        <!-- ประเภท -->
                        <div class="col-span-1">
                            <label for="inputTravel" class="block text-sm font-medium text-gray-700">ประเภท</label>
                            <select id="inputTravel" name="inputTravel"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1">
                                <option selected value="0">กรุณาเลือกประเภท</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->trip_type }}">
                                        {{ str_replace('_', ' ', $type->trip_type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-1">

                            <label for="package" class="block text-sm font-medium text-gray-700">Package</label>
                            <select id="package" name="package"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1"
                                onchange="findprice()" required>

                            </select>
                        </div>
                    </div>
                </div>

                <div class=" bg-gray-100 p-4 rounded-md border-gray-300 mt-3  hidden" id="private1">
                         <div class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-5 gap-4">
                        <div class="grid grid-cols-1 gap-4 mt-2">
                            <div class="mt-4">
                                <span class="font-semibold">จำนวนผู้โดยสาร</span>
                            </div>

                            <div>
                                <input type="number" class="w-full border-gray-300 rounded-lg p-2 count"
                                    id="count_Private" oninput="calculateTotal()" name="count_Private" required>
                                <input type="hidden" id="price_private" name="price_private">

                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-2">

                                <div class="mt-4">
                                    <span class="block text-sm font-medium text-red-500">ที่นั่งเพิ่มเติม
                                    </span>
                                </div>
                                <div class="flex items-center ">
                                    <input type="number" id="extraseat" name="extraseat" value="0"
                                        onchange="calculateTotal()"
                                        class="block w-full rounded-md border-gray-300 shadow-sm" maxlength="10">
                                </div>

                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-2">

                                <div class="mt-4">
                                    <span class="block text-sm font-medium text-red-500">ที่นั่งเพิ่มเติม
                                    </span>
                                </div>
                                <div class="flex items-center ">
                                    <input type="number" id="priceextraseat" name="priceextraseat" value="2000"
                                    onchange="calculateTotal()"
                                        class="block w-full rounded-md border-gray-300 shadow-sm" maxlength="10">
                                </div>

                            </div>
                        <div class="grid grid-cols-1 gap-4 mt-2">

                            <div class="mt-4">
                                <span class="block text-sm font-medium text-red-500">embark</span>
                            </div>
                            <div class="flex items-center ">


                                <input type="text" id="embark" name="embark"
                                    class="block w-full rounded-md border-gray-300 shadow-sm">
                            </div>


                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-2">

                            <div class="mt-4">
                                <span class="block text-sm font-medium text-red-500">disembark</span>
                            </div>
                            <div class="flex items-center ">
                                <input type="text" id="disembark" name="disembark"
                                    class="block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="extra_req" class=" bg-blue-200 p-4 rounded-md border-gray-300 mt-3">
                    <input type="hidden" id="totalextra">


                </div>
                <div class="flex justify-start mt-4 space-x-2">
                        <button type="button" onclick="addForm()"
                            class="px-2  bg-green-500 text-white rounded">+</button>
                        <button type="button" onclick="removeForm()"
                            class="px-2 bg-red-500 text-white rounded">-</button>
                    </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-6  hidden" id="join1">
                    <div class="grid grid-cols-1">
                        <label for="count_Adult" class="block text-sm font-medium text-gray-700">
                            Adult</label>
                        <input type="number" id="count_Adult" name="count_Adult"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" min="0"
                            placeholder="จำนวนที่นั่ง" oninput="calculateTotal()">
                    </div>


                    <div class="grid grid-cols-1">
                        <label for="inputprice_Adult"
                            class="block text-sm font-medium text-gray-700">ราคาต่อท่าน</label>
                        <input type="text" id="inputprice_Adult" name="inputprice_Adult"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                    </div>


                    <div class="grid grid-cols-1">
                        <label for="totalprice_Adult" class="block text-sm font-medium text-gray-700">ราคารวม

                        </label>
                        <input type="text" id="totalprice_Adult" name="totalprice_Adult"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-6" id="join4">
                    <div class="grid grid-cols-1">
                        <label for="count_Child" class="block text-sm font-medium text-gray-700">
                            Child</label>
                        <input type="number" id="count_Child" name="count_Child"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" min="0"
                            placeholder="จำนวนที่นั่ง" oninput="calculateTotal()">
                    </div>


                    <div class="grid grid-cols-1">
                        <label for="inputprice_Child"
                            class="block text-sm font-medium text-gray-700">ราคาต่อท่าน</label>
                        <input type="text" id="inputprice_Child" name="inputprice_Child"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                    </div>


                    <div class="grid grid-cols-1">
                        <label for="totalprice_Child" class="block text-sm font-medium text-gray-700">ราคารวม

                        </label>
                        <input type="text" id="totalprice_Child" name="totalprice_Child"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                    </div>
                </div>


                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-6  hidden" id="join2">
                    <div class="grid grid-cols-1">
                        <label for="count_baby" class="block text-sm font-medium text-gray-700">เด็กเล็ก</label>
                        <input type="number" id="count_baby" name="count_baby" value="0"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" min="0"
                            placeholder="จำนวนที่นั่ง">
                    </div>


                    <div class="grid grid-cols-1">
                        <label for="inputprice_baby"
                            class="block text-sm font-medium text-gray-700">ราคาต่อท่าน</label>
                        <input type="text" id="inputprice_baby" name="inputprice_baby" value="0"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                    </div>


                    <div class="grid grid-cols-1">
                        <label for="totalprice_baby" class="block text-sm font-medium text-gray-700">ราคารวม

                        </label>
                        <input type="text" id="totalprice_baby" name="totalprice_baby" value="0"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-6" id="join3">
                    <div class="grid grid-cols-1">
                        <label for="count_guide" class="block text-sm font-medium text-gray-700">ไกด์</label>
                        <input type="number" id="count_guide" name="count_guide" value="0"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" min="0"
                            placeholder="จำนวนที่นั่ง">
                    </div>


                    <div class="grid grid-cols-1">
                        <label for="inputprice_guide"
                            class="block text-sm font-medium text-gray-700">ราคาต่อท่าน</label>
                        <input type="text" id="inputprice_guide" name="inputprice_guide" value="0"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                    </div>


                    <div class="grid grid-cols-1">
                        <label for="totalprice_guide" class="block text-sm font-medium text-gray-700">ราคารวม

                        </label>
                        <input type="text" id="totalprice_guide" name="totalprice_guide" value="0"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-4 mt-2">

                    <div class="grid grid-cols-1 px-2">
                        <div class="form-group">
                            <label for="overticket" class="block text-sm font-medium text-gray-700">
                                ตั๋วเกิน</label>
                            <div class="flex items-center mt-2">
                                <!-- จัดการ checkbox กับ label ให้อยู่ใกล้กันมากขึ้น -->
                                <input type="checkbox" id="overticket" name="overticket" value="1"
                                    class="form-check-input h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-2">
                    <div class="grid grid-cols-1">
                        <div class="form-group ">
                            <label for="inputpay" class="block text-sm font-medium text-gray-700">
                                การชำระเงิน</label>
                            <select id="inputpay" name="inputpay" onchange="toggleDepositFields()"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option selected disabled>กรุณาเลือกรูปแบบการชำระเงิน</option>
                                <option value="paid">ชำระเต็ม</option>
                                <option value="deposit">มัดจำ</option>
                                <option value="2c2p">2C2P</option>
                                <option value="ent">Ent</option>
                                <option value="unpaid">ยังไม่ชำระเงิน</option>
                                <option value="sub">ในเครือ</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <div class="form-group">
                            <label for="discountagent" class="block text-sm font-medium text-gray-700">ส่วนลด Agent
                                %</label>

                            <input type="number" id="discountagent" name="discountagent" value="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="ส่วนลด" oninput="calculatediscountagent()">
                            <input type="hidden" id="amountdiscountagent" name="amountdiscountagent">

                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <div class="form-group">
                            <label for="promocode" class="block text-sm font-medium text-gray-700">โค้ดส่วนลด</label>
                            <input type="text" id="promocode" name="promocode"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="กรอกโค้ดโปรโมชั่น">
                        </div>
                    </div>

                    <!-- ส่วนลด -->
                    <div class="grid grid-cols-1">
                        <div class="form-group">
                            <label for="discount" class="block text-sm font-medium text-gray-700">ส่วนลด</label>
                            <input type="hidden" id="realdiscount" name="realdiscount"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="ส่วนลด">
                            <input type="number" id="discount" name="discount"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="ส่วนลด" oninput="calculatediscount()">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-2">
                    <div class="grid grid-cols-1">
                        <div class="form-group">
                            <label for="totalPage" class="block text-sm font-medium text-gray-700">ราคาแพ็คเกจ</label>
                            <input type="text" id="totalPage" name="totalPage"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="ราคาแพ็คเกจ" oninput="changetotalpage()">
                        </div>
                    </div>

                    <!-- รวมสุทธิ -->
                    <div class="grid grid-cols-1">
                        <div class="form-group">
                            <label for="total" class="block text-sm font-medium text-gray-700">รวมสุทธิ</label>
                            <input type="text" id="total" name="total"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="รวมสุทธิ" >
                        </div>
                    </div>
                    <!-- ราคาแพ็คเกจ -->


                    <!-- ราคาแพ็คเกจ -->
                    <div class="grid grid-cols-1 depositFields" style="display: none;">
                        <div class="form-group">
                            <label for="deposit" class="block text-sm font-medium text-gray-700">มัดจำ</label>
                            <input type="text" oninput="calculateDeposit()" id="deposit" name="deposit"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="ราคาแพ็คเกจ">
                        </div>
                    </div>

                    <!-- รวมสุทธิ -->
                    <div class="grid grid-cols-1 depositFields" style="display: none;">
                        <div class="form-group">
                            <label for="totaldept" class="block text-sm font-medium text-gray-700">ยอดคงค้าง</label>
                            <input type="text" id="totaldept" name="totaldept"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="รวมสุทธิ" readonly>
                        </div>
                    </div>

                </div>
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                    <div class="grid grid-cols-1" id="tag_account_num">
                        <div class="form-group">
                            <label for="account_number" class="block text-sm font-medium text-gray-700">เลขที่บัญชี(4
                                ตัวหลัง)</label>
                            <input type="text"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                maxLength="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="account_number" name="account_number" placeholder="เลขที่บัญชีรับโอน">
                        </div>
                    </div>
                    <div class="grid grid-cols-1" id="tag_date_tranfer">
                        <div class="form-group">
                            <label for="datetime_transfer"
                                class="block text-sm font-medium text-gray-700">วันที่รับโอน</label>
                            <input type="datetime-local"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="datetime_transfer" name="datetime_transfer">
                        </div>
                    </div>
                    <div class="grid grid-cols-1" id="tag_date_tranfer">
                        <div class="form-group flex items-center space-x-2">
                            <input type="checkbox" id="vat" name="vat" value="true"
                                class="form-check-input h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                            <label for="vat" class="text-sm font-medium text-gray-700">
                                Vat 7%
                            </label>
                        </div>
                        <div class="form-group flex items-center space-x-2">
                            <input type="checkbox" id="tax" name="tax" value="true"
                                class="form-check-input h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                            <label for="tax" class="text-sm font-medium text-gray-700">
                                Tax 3%
                            </label>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 mt-2">
                    <div class="form-group">
                        <label for="inputslip" id="labelslip"
                            class="block text-sm font-medium text-gray-700">สลิปโอนเงิน</label>
                        <input type="file" name="slip" id="slip"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            onchange="handleFileChange(this)"
                            accept=".jpg,.png"> <!-- แนะนำให้ใช้ accept เพื่อจำกัดประเภทไฟล์ -->
                        @error('slip')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <input type="hidden" name="oldimg" id="oldimg">
                        <img src="" id="Slipimg" name="Slipimg" class="w-full mt-2 slip">

                    </div>
                    <div class="form-group">
                        <label for="inputslip2" id="labelslip2"
                            class="block text-sm font-medium text-gray-700">สลิปโอนเงิน *ถ้ามี</label>
                        <input type="file" name="slip2" id="slip2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            onchange="handleFileChange(this)"
                            accept=".jpg,.png"> <!-- แนะนำให้ใช้ accept เพื่อจำกัดประเภทไฟล์ -->
                        @error('slip')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <input type="hidden" name="oldimg2" id="oldimg2">

                        <img src="" id="Slipimg2" name="Slipimg2" class="w-full mt-2 slip">
                    </div>
                     <div class="form-group">
                        <label for="inputslip2" id="labelslip3"
                            class="block text-sm font-medium text-gray-700">สลิปโอนเงิน *ถ้ามี</label>
                        <input type="file" name="slip3" id="slip3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            onchange="handleFileChange(this)"
                            accept=".jpg,.png"> <!-- แนะนำให้ใช้ accept เพื่อจำกัดประเภทไฟล์ -->
                        @error('slip')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <input type="hidden" name="oldimg3" id="oldimg3">

                        <img src="" id="Slipimg3" name="Slipimg3" class="w-full mt-2 slip">
                    </div>


                </div>
                <div class="grid grid-cols-2 md:grid-cols-1 lg:grid-cols-1 gap-4 mt-2">
                    <label for="note" class="block text-sm font-medium text-gray-700">หมายเหตุ</label>
                    <textarea id="note" name="note" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-5 gap-4 mt-6">
                    <button type="submit"
                        class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">บันทึก</button>
                    <button onclick="closeModaledit()" type="button"
                        class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                        ยกเลิก
                    </button>

                </div>


            </form>
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
        </div>
    </div>


    <script>

        function deleteBookingOption(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                     fetch(`/admin/bookings/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire(
                            'Deleted!',
                            data.message,
                            'success'
                        ).then(() => {
                            location.reload(); // รีโหลดหน้า หรือ ลบ row แบบไดนามิก
                        });
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            'There was an issue deleting the item.',
                            'error'
                        );
                        console.error('Error:', error);
                    });
                }
            });
        }
    </script>
    <!-- jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Script สำหรับเปิด/ปิด modal -->
    <script>
        let currentSortColumn = null; // เก็บคอลัมน์ที่ถูกเรียงล่าสุด
        function removeRow(button) {


            const extraReqContainer = document.getElementById('extra_req');
            // เลือกทุก formGroup ใน extraReqContainer ที่มีคลาส grid
            const formGroups = extraReqContainer.querySelectorAll('.grid');


            if (formGroups.length > 0) {
                // ลบ formGroup ล่าสุด
                extraReqContainer.removeChild(formGroups[button]);
            }


        }


        function sortTable(columnIndex, defaultOrder) {
            const table = document.querySelector('table tbody');
            const rows = Array.from(table.rows);
            const header = document.querySelectorAll('th')[columnIndex];
            const arrow = header.querySelector('.arrow');

            // Toggle ระหว่าง 'asc' และ 'desc'
            let order = defaultOrder;
            if (currentSortColumn === columnIndex) {
                order = arrow.classList.contains('ascending') ? 'desc' : 'asc';
            }

            // ลบ class ลูกศรจาก header อื่นๆ
            document.querySelectorAll('.arrow').forEach(el => {
                el.classList.remove('ascending', 'descending');
            });

            // เพิ่ม class ลูกศรให้ header ปัจจุบัน
            arrow.classList.add(order === 'asc' ? 'ascending' : 'descending');

            // เรียงลำดับข้อมูล
            rows.sort((a, b) => {
                const aText = a.cells[columnIndex].textContent.trim();
                const bText = b.cells[columnIndex].textContent.trim();

                if (!isNaN(aText) && !isNaN(bText)) {
                    return order === 'asc' ? aText - bText : bText - aText;
                } else {
                    return order === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
                }
            });

            // แทรกข้อมูลที่เรียงกลับไปใน `tbody`
            rows.forEach(row => table.appendChild(row));
            currentSortColumn = columnIndex;
        }
          function handleFileChange(input) {
            const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes

            // ตรวจสอบว่ามีไฟล์ถูกเลือกหรือไม่
            if (input.files.length === 0) {
                return;
            }

            const file = input.files[0];

            // ตรวจสอบขนาดไฟล์
            if (file.size > maxFileSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'ข้อผิดพลาด!',
                    text: 'ขนาดไฟล์ต้องไม่เกิน 2MB'
                });
            } else {
                // ถ้าขนาดไฟล์ถูกต้อง ให้แสดงรูปตัวอย่าง
                const img = document.getElementById('Slipimg');
                img.src = window.URL.createObjectURL(file);
                img.style.display = "block";

                    const fileInput = input;
                    const transferDateField = document.getElementById('datetime_transfer');

                    // ตรวจสอบว่ามีไฟล์ถูกเลือกหรือไม่
                    if (fileInput.files && fileInput.files.length > 0) {
                        // หากมีไฟล์แนบ ให้ตั้งค่าฟิลด์ datetime_transfer เป็น required
                        transferDateField.required = true;
                        transferDateField.classList.add("required-highlight"); // เพิ่มคลาสสำหรับการแสดงผล (ถ้าต้องการ)
                    } else {
                        // หากไม่มีไฟล์แนบ ให้ลบ required
                        transferDateField.required = false;
                        transferDateField.classList.remove("required-highlight");
                    }
            }
        }

        $(document).ready(function() {
            $('#inputTravel').change(function() {
                let tripType = $(this).val();

                if (tripType !== '0') {
                    $.ajax({
                        url: `/packages/${tripType}`,
                        type: 'GET',
                        success: function(response) {
                            // Clear old options
                            $('#package').empty();
                            $('#package').append(
                                '<option selected value="0">กรุณาเลือก Package</option>');

                            // Populate new options
                            response.forEach(function(package) {
                                $('#package').append(
                                    `<option value="${package.id}">${package.name_boat} ${package.id}</option>`
                                );
                            });
                        },
                        error: function() {
                            alert('ไม่สามารถดึงข้อมูล Package ได้');
                        }
                    });
                } else {
                    $('#package').empty().append('<option selected value="0">กรุณาเลือก Package</option>');
                }
            });
        });

        function openEditBookingModal(bookingId) {
            $.ajax({
                url: `/get-booking/${bookingId}`, // URL สำหรับดึงข้อมูล
                type: 'GET',
                success: function(data) {

                    if (data.booking.tel != '-') {
                        document.getElementById("notel").checked = true;
                    }
                    // document.getElementById("booking_code").value = "1";
                    $('#bookingId').val(data.booking.id);
                    $('#booking_code').val(data.booking.booking_code);
                    $('#date').val(data.booking.booking_time);
                    $('#returndate').val(data.booking.return_date);
                    $('#name').val(data.booking.name);
                    $('#tel').val(data.booking.tel);
                    $('#agent').val(data.booking.agent);
                    $('#contact').val(data.booking.contact);
                    $('#inputTravel').val(data.booking.package.package_type.trip_type);

                    data.packages.forEach(function(package) {
                        $('#package').append(
                            `<option value="${package.id}">${package.name_boat} ${package.id}</option>`
                        );
                    });
                    $('#package').val(data.booking.package_id);
                    $('#extra_req').empty();
                    data.booking.booking_option.forEach(function (booking_option, index) {
                        $('#extra_req').append(`
                            <div class="grid grid-cols-3 sm:grid-cols-1 md:grid-cols-3 gap-4 items-center bg-white p-3 rounded-md mt-2">
                                <!-- Description -->
                                <div class="flex flex-col">
                                    <span class="block text-sm font-bold text-blue-700">Description</span>
                                    <input type="text" value="${data.booking.booking_option[index].detail}" id="extra_info[${index}]" name="extra_info[${index}]" class="w-full rounded-md border-gray-300 shadow-sm mt-1">
                                </div>

                                <!-- Price -->
                                <div class="flex flex-col">
                                    <span class="block text-sm font-bold text-blue-700">Price</span>
                                    <input type="number" value="${data.booking.booking_option[index].amount}" id="extra_price[${index}]" name="extra_price[${index}]" class="w-full rounded-md border-gray-300 shadow-sm mt-1">
                                </div>

                                <!-- Type -->
                                <div class="flex flex-col">
                                    <span class="block text-sm font-bold text-blue-700">Type</span>
                                    <select name="extra_type[${index}]" class="w-full rounded-md border-gray-300 shadow-sm mt-1">
                                        <option value="increase" ${data.booking.booking_option[index].typeoption === 'increase' ? 'selected' : ''}>เพิ่ม</option>
                                        <option value="discount" ${data.booking.booking_option[index].typeoption === 'discount' ? 'selected' : ''}>ส่วนลด</option>
                                    </select>

                                </div>

                            </div>
                             <button type="button" class="remove-btn text-red-600 hover:text-red-800 font-bold" onclick="removeRow(${index})">ลบ</button>
                        `);
                    });

                    if (data.booking.package.package_type.trip_type == 'private') {
                        document.getElementById('private1').classList.remove('hidden');
                        document.getElementById('join1').classList.add('hidden');
                        document.getElementById('join2').classList.add('hidden');
                        document.getElementById('join3').classList.add('hidden');
                        document.getElementById('join4').classList.add('hidden');
                        $('#count_Private').val(data.booking.private_seat);
                        $('#extraseat').val(data.booking.extra_seat);
                        $('#embark').val(data.booking.embark);
                        $('#disembark').val(data.booking.disembark);
                        $('#price_private').val(data.booking.package.prices[0].regular);
                    } else if (data.booking.package.package_type.trip_type == 'join') {
                        document.getElementById('join1').classList.remove('hidden');
                        document.getElementById('join2').classList.remove('hidden');
                        document.getElementById('join3').classList.remove('hidden');
                        document.getElementById('join4').classList.remove('hidden');
                        document.getElementById('private1').classList.add('hidden');

                    }
                    if (data.booking.seat > data.booking.package.max_geuse) {
                        document.getElementById("overticket").checked = true;
                    }
                    if(data.booking.vat == 'true'){
                        document.getElementById("vat").checked = true;
                    }else{
                        document.getElementById("vat").checked = false;
                    }
                    if(data.booking.tax == 'true'){
                        document.getElementById("tax").checked = true;
                    }else{
                        document.getElementById("tax").checked = false;
                    }
                    if (data.booking.code && data.booking.code.promotion_code) {
                        $('#promocode').val(data.booking.code.promotion_code);
                    } else {
                        $('#promocode').val('');
                    }

                    $('#inputpay').val(data.booking.statement_status);
                    $('#discount').val(data.booking.percent_discount);



                    if(data.booking.package.prices[0].regular != data.booking.manual_amount){
                        $('#totalPage').val(data.booking.manual_amount);
                        $('#discountagent').val((data.booking.percent_discount / data.booking.manual_amount) * 100);
                    }else{
                        $('#totalPage').val(data.booking.package.prices[0].regular);
                        $('#discountagent').val((data.booking.percent_discount / data.booking.package.prices[0]
                        .regular) * 100);
                    }

                    $('#total').val(data.booking.amount);


                    if(data.booking.payments[0]){
                        $('#datetime_transfer').val(data.booking.payments[0].transfer_time);
                        $('#account_number').val(data.booking.payments[0].account);

                        $('#oldimg').val(data.booking.payments[0].slip);
                        $('#Slipimg').attr('src', data.paymentSlipUrl1);

                    }
                     if(data.booking.payments[1]){
                        $('#oldimg2').val(data.booking.payments[1].slip);
                        $('#Slipimg2').attr('src', data.paymentSlipUrl2);
                    }

                     if(data.booking.payments[2]){
                        $('#oldimg3').val(data.booking.payments[2].slip);
                        $('#Slipimg3').attr('src', data.paymentSlipUrl3);
                    }

                    $('#note').val(data.booking.note);



                    $('#editBookingModal').removeClass('hidden').show();
                },
                error: function(xhr, status, error) {
                    console.error("เกิดข้อผิดพลาดในการดึงข้อมูล:", error);
                }
            });
        }

        function toggleDepositFields() {
            const inputPay = document.getElementById('inputpay').value;
            const depositFields = document.querySelectorAll('.depositFields');

            depositFields.forEach(field => {
                if (inputPay === 'deposit') {
                    field.style.display = 'block';
                } else {
                    field.style.display = 'none';
                }
            });
        }

        function findprice(){
            var booking_id = $('#bookingId').val();
            var package_id = $('#package').val();

            $.ajax({
                url: '/findprice',
                type: 'POST',
                data: {
                    booking_id: booking_id,
                    package_id: package_id,
                    _token: $('meta[name="csrf-token"]').attr('content') // สำหรับ Laravel CSRF
                },
                success: function (response) {


                   $('#totalPage').val(response.inputprice_Private);
                   calculateTotal();

                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function calculateextra() {

            const priceInputs = document.querySelectorAll('input[name="extra_price[]"]');

            let total = 0;

            priceInputs.forEach(input => {
                const value = parseFloat(input.value);

                if (!isNaN(value)) {
                    total += value;
                }
            });
            var totals = document.getElementById('total').value;
            document.getElementById('total').value = totals - total;
        }

        function removeForm() {
            const extraReqContainer = document.getElementById('extra_req');
            // เลือกทุก formGroup ใน extraReqContainer ที่มีคลาส grid
            const formGroups = extraReqContainer.querySelectorAll('.grid');

            // ตรวจสอบว่ามี formGroups ให้ลบ
            if (formGroups.length > 0) {
                // ลบ formGroup ล่าสุด
                extraReqContainer.removeChild(formGroups[formGroups.length - 1]);
            }
        }

        function toggleRequired() {
            const checkbox = document.getElementById('notel');
            const telInput = document.getElementById('inputtel');

            if (checkbox.checked) {
                telInput.removeAttribute('required');
            } else {
                telInput.setAttribute('required', 'required');
            }
        }
        function addForm() {
            const extraReqContainer = document.getElementById('extra_req');
            const fragment = document.createDocumentFragment();

            const formGroup = document.createElement('div');
            formGroup.className = 'grid grid-cols-3 sm:grid-cols-1 md:grid-cols-3 gap-4 items-center bg-white p-3 rounded-md mt-2';

            const infoDiv = document.createElement('div');
            infoDiv.className = 'flex flex-col col-span-1';
            infoDiv.innerHTML = `
                <span class="block text-sm font-bold text-blue-700">Description</span>
                <input type="text" name="extra_info[]" id="extra_info[]" class="w-full rounded-md border-gray-300 shadow-sm mt-1">
            `;

            const priceDiv = document.createElement('div');
            priceDiv.className = 'flex flex-col col-span-1';
            priceDiv.innerHTML = `
                <span class="block text-sm font-bold text-blue-700">Price</span>
                <input type="number" name="extra_price[]"  id="extra_price[]" class="w-full rounded-md border-gray-300 shadow-sm mt-1" >
            `;

             const typeDiv = document.createElement('div');
                typeDiv.className = 'flex flex-col';
                typeDiv.innerHTML = `
                    <label class="block text-sm font-bold text-blue-700">Type</label>
                    <select name="extra_type[]" class="w-full rounded-md border-gray-300 shadow-sm mt-1">
                        <option value="increase">เพิ่ม</option>
                        <option value="discount">ส่วนลด</option>
                    </select>
                `;

            formGroup.appendChild(infoDiv);
            formGroup.appendChild(priceDiv);
            formGroup.appendChild(typeDiv);

            fragment.appendChild(formGroup);
            extraReqContainer.appendChild(fragment);

        }

        function calculateDeposit() {
            var depositAmount = parseFloat(document.getElementById('deposit').value.replace(/,/g, '') || 0);
            var totalpage = parseFloat(document.getElementById('total').value.replace(/,/g, '') || 0);
            var outstandingAmount = totalpage - depositAmount;
            document.getElementById('totaldept').value = new Intl.NumberFormat().format(outstandingAmount); // แสดงยอดคงค้าง

        }

        function calculateTotal() {
            const inputTravel = document.getElementById('inputTravel').value;

            if (inputTravel == 'private') {
                private_price = document.getElementById('price_private').value;

                var extraseat = document.getElementById('extraseat').value;
                var priceextraseat = document.getElementById('priceextraseat').value;
                var totalPage  = document.getElementById('totalPage').value;
                var extraseat = document.getElementById('extraseat').value*document.getElementById('priceextraseat').value;
                var discountagentValue = document.getElementById('discountagent').value;
                var discountagent = isNaN(parseFloat(discountagentValue)) ? 1 : parseFloat(discountagentValue);

                if(private_price != totalPage){
                    total = totalPage - ((totalPage * (discountagent / 100)))+extraseat;
                    document.getElementById('discount').value = totalPage * (discountagent / 100);
                }else{
                     total = (private_price - (private_price * (discountagent / 100)))+extraseat;
                     document.getElementById('discount').value = private_price * (discountagent / 100);
                }

            } else {
                var seatCountAdult = document.getElementById('count_Adult').value || 0;
                var seatCountChild = document.getElementById('count_Child').value || 0;
                var pricePerPersonAdult = document.getElementById('inputprice_Adult').value.replace(/,/g, '') || 0;
                var pricePerPersonChild = document.getElementById('inputprice_Child').value.replace(/,/g, '') || 0;
                var totalPriceAdult = seatCountAdult * pricePerPersonAdult;
                var totalPriceChild = seatCountChild * pricePerPersonChild;

                // แสดงราคาที่คำนวณได้
                document.getElementById('totalprice_Adult').value = new Intl.NumberFormat().format(totalPriceAdult);
                document.getElementById('totalprice_Child').value = new Intl.NumberFormat().format(totalPriceChild);

                // คำนวณผลรวมทั้งหมด
                totalpage = 0; // เริ่มต้นใหม่ทุกครั้ง
                // คำนวณผลรวมของทุก input
                var inputs = document.querySelectorAll('[id^="totalprice_"]');
                inputs.forEach(function(input) {
                    totalpage += parseFloat(input.value.replace(/,/g, '')) || 0; // บวกค่าทั้งหมด
                });

            }
            // อัปเดตค่าใน Livewire
            document.getElementById('total').value = new Intl.NumberFormat().format(total);

        }

        function calculatediscount() {

            const discount = parseFloat(document.getElementById('discount').value) || 0;

            const totalpage = parseFloat(document.getElementById('totalPage').value) || 0;

            const finalPrice = totalpage - discount;

            document.getElementById('total').value = finalPrice > 0 ? finalPrice.toFixed(2) : 0;
        }

        function calculatediscountagent() {
            const inputTravel = document.getElementById('inputTravel').value;
            const totalPage = document.getElementById('totalPage').value;
            const realdiscount = document.getElementById('realdiscount').value;
            var sumprice = 0;
            var extraseat = 0;
            var totaldiscount = 0;


            if (inputTravel == 'private') {
                private_price = document.getElementById('price_private').value;

                extraseat = document.getElementById('extraseat').value*document.getElementById('priceextraseat').value;

                sumprice = Number(private_price);


            } else {
                var seatCountAdult = document.getElementById('count_Adult').value || 0;
                var seatCountChild = document.getElementById('count_Child').value || 0;
                var pricePerPersonAdult = document.getElementById('inputprice_Adult').value.replace(/,/g, '') || 0;
                var pricePerPersonChild = document.getElementById('inputprice_Child').value.replace(/,/g, '') || 0;
                var totalPriceAdult = seatCountAdult * pricePerPersonAdult;
                var totalPriceChild = seatCountChild * pricePerPersonChild;
                sumprice = totalPriceAdult + totalPriceChild;

            }
            // รับค่าจาก input ส่วนลดและราคาแพ็คเกจ
            var total = 0;
            const discountagent = parseFloat(document.getElementById('discountagent').value)

            if (discountagent > 0) {
                if(private_price != totalPage){
                    total = totalPage - ((totalPage * (discountagent / 100)))+extraseat;
                    document.getElementById('amountdiscountagent').value = totalPage * (discountagent / 100);
                }else{
                     total = (sumprice - (sumprice * (discountagent / 100)))+extraseat;
                     document.getElementById('amountdiscountagent').value = sumprice * (discountagent / 100);
                }


            } else {
                total = sumprice;
            }


            totaldiscount = totalPage * (discountagent / 100);

            // document.getElementById('totalPage').value = total > 0 ? total.toFixed(2) : 0;
             document.getElementById('total').value = total > 0 ? total.toFixed(2) : 0;
             document.getElementById('discount').value =   totaldiscount;

        }

        function changetotalpage() {

            const totalPage = parseFloat(document.getElementById('totalPage').value) || 0;

            document.getElementById('total').value = totalPage;
        }

        function openModal(bid) {
            // สร้าง URL สำหรับการชำระเงิน
            let paymentUrl = "{{ route('payment', ['bid' => ':bid']) }}";
            paymentUrl = paymentUrl.replace(':bid', bid); // แทนที่ค่า ':bid' ด้วยค่า bid จริง
            // แสดง QR code ด้วยการสร้าง element ใหม่
            let qrCodeContainer = document.getElementById('qrCodeContainer');
            qrCodeContainer.innerHTML =
                `<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(paymentUrl)}" alt="QR Code">`;

            // แสดง modal
            document.getElementById('2c2p').classList.remove('hidden');
        }


        function closeModal() {
            document.getElementById('2c2p').classList.add('hidden');
        }

        function closeModaledit() {
            document.getElementById('editBookingModal').classList.add('hidden');
        }

        function invoice1(id) {
            // ใช้ URL แบบตรงๆ โดยไม่ต้องเรียก route() ใน Laravel
            window.open("/calendar/invoice1/" + id, '_blank');
        }


        function invoice2(id) {
            // ใช้ URL แบบตรงๆ โดยไม่ต้องเรียก route() ใน Laravel
            window.open("/calendar/invoice2/" + id, '_blank');
        }

        function invoice3(id) {
            // ใช้ URL แบบตรงๆ โดยไม่ต้องเรียก route() ใน Laravel
            window.open("/calendar/invoice3/" + id, '_blank');
        }
    </script>
</x-app-layout>
