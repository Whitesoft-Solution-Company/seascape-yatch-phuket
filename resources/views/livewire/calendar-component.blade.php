<div wire:ignore.self>
    <style>
        @media (max-width: 1400px) {
            .fc-daygrid-event {
                width: 100%;
                /* ทำให้ event กินพื้นที่ทั้งหมดในแถว */
                margin: 0;
                /* ไม่ให้มี margin */
            }
        }

        .modal-content {
            position: relative;
            /* Allow absolute positioning of close button */
        }
        .legend {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.box {
  width: 15px;
  height: 15px;
  display: inline-block;
  border-radius: 3px; /* ให้ดูมนเล็กน้อย */
}

.blue {
  background-color: #007bff; /* สีฟ้า */
}

.purple {
  background-color: purple; /* สีม่วง */
}
.orange {
  background-color: #fd7e14; /* สีส้ม Sunset */
}
.green {
  background-color: green; /* สีส้ม Sunset */
}
.yellow {
  background-color: yellow; /* สีส้ม Sunset */
}

.text {
  font-size: 14px;
  color: #333; /* สีข้อความ */
}
    </style>
    <div class="legend">
  <div class="legend-item">
    <span class="box blue"></span>
    <span class="text">One Day Trip</span>
  </div>
  <div class="legend-item">
    <span class="box purple"></span>
    <span class="text">Overnight</span>
  </div>
    <div class="legend-item">
    <span class="box orange"></span>
    <span class="text">Sunset</span>
  </div>
  <div class="legend-item">
    <span class="box green"></span>
    <span class="text">No Package</span>
  </div>
  <div class="legend-item">
    <span class="box yellow"></span>
    <span class="text">Maintenance</span>
  </div>
</div>

    <div wire:ignore.self class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 w-full" id="calendars-container">
     
            <div wire:ignore.self id="calendar" class="border p-4 rounded-lg shadow-lg"
                style="border-block-color:#25ff30; border-width: 7px; ">
                <h2 class="text-lg font-semibold mb-2" style="color:#25ff30; ">
                   Calendar </h2>
                <!-- แสดง Calendar แรก ที่นี่ -->
                <div class="h-96 bg-gray-100 flex items-center justify-center">
                    <p>Loading . . .</p>
                </div>
            </div>
             <div id="event-details" >
                 <div class=" bg-gray-100 p-4 rounded-md border-gray-300">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4  ">
                        <div class="col-span-1">
                            <label for="input_codebooking"
                                class="block text-sm font-medium text-gray-700">รหัสการจอง</label>
                            <input type="text" id="hvbookingcode" name="hvbookingcode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm readonly">
                        </div>
                         <div class="col-span-1">
                            <label for="hvname" class="block text-sm font-medium text-gray-700">ชื่อลูกค้า</label>
                            <input type="text" id="hvname" name="hvname"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"  readonly
                                >
                        </div>
                        <div class="col-span-1">
                            <label for="hvpackage" class="block text-sm font-medium text-gray-700">แพ็คเก็จ</label>
                            <input type="text" id="hvpackage" name="hvpackage"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"  readonly
                                >
                        </div>
                        <div class="col-span-1">
                            <label for="hvtel" class="block text-sm font-medium text-gray-700">เบอร์โทร</label>
                            <input type="text" id="hvtel" name="hvtel"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"  readonly
                                >
                        </div>
                        <div class="col-span-1">
                            <label for="hvagent" class="block text-sm font-medium text-gray-700">agent</label>
                            <input type="text" id="hvagent" name="hvagent"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"  readonly
                                >
                        </div>
                        <div class="col-span-1">
                            <label for="hvseat" class="block text-sm font-medium text-gray-700">จำนวนที่นั่ง</label>
                            <input type="text" id="hvseat" name="hvseat"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"  readonly
                                >
                        </div>

                       
                        <div class="col-span-1" id="divslip1" hidden>
                            <label for="hvseat" class="block text-sm font-medium text-gray-700">จำนวนที่นั่งs</label>
                             <img  alt="Slip1" id="slip1" class="w-64 h-auto">
                        </div>
                        
                        <div class="col-span-1" id="divslip2" hidden>
                            <label for="hvseat" class="block text-sm font-medium text-gray-700">จำนวนที่นั่งs</label>
                             <img  alt="Slip2"  id="slip2" class="w-64 h-auto">
                        </div>
                      
                        <div class="col-span-1" id="divslip3" hidden>
                            <label for="hvseat" class="block text-sm font-medium text-gray-700">จำนวนที่นั่งs</label>
                             <img  alt="Slip3" id="slip3" class="w-64 h-auto">
                        </div>
                     
                    </div>
                </div>
            </div>
 
</div>
   


    <div wire:ignore.self id="bookingModal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50 ">

        <div class="  bg-white rounded-lg shadow-lg p-6 max-w-4xl w-full overflow-y-auto max-h-[90vh] mt-10 mb-10">
            <button class="close absolute top-2 right-2" onclick="closeModal()"> <svg class="h-6 w-6"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg></button>
            <h2 class="text-lg font-bold mb-4">Booking Details</h2>

            <form action="{{ route('booking.addbooking') }}" method="POST" enctype="multipart/form-data"
                class="px-5">
                @csrf


                <div class=" bg-gray-100 p-4 rounded-md border-gray-300">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4  ">
                        <!-- รหัสการจอง -->

                        <div class="col-span-1">
                            <label for="input_codebooking"
                                class="block text-sm font-medium text-gray-700">รหัสการจอง</label>
                            <input type="text" id="bookingcode" name="bookingcode" wire:model="bookingcode"
                                value="{{ $bookingcode }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>



                        <div class="col-span-1">
                            <label for="nodate" class="block text-sm font-medium text-red-500">*ติ้กเพื่อไม่ระบุวันที่

                            </label>
                            <div class="flex items-center mt-1">
                                <input type="checkbox" id="nodate" name="nodate" onchange="changedate()"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">

                                <input type="date" id="date" name="date" wire:model="date"
                                    class="block w-full rounded-md border-gray-300 shadow-sm" maxlength="10" readonly>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <label for="nodate" class="block text-sm font-medium text-gray-700">วันเดินทางกลับ
                            </label>
                            <div class="flex items-center mt-1">
                                @if ($selectedpackagetypes == 'private')
                                    <input type="date" id="returndate" name="returndate"
                                        class="block w-full px-3 rounded-md border-gray-300 shadow-sm" maxlength="10">
                                @else
                                    <input type="date" id="returndate" name="returndate"
                                        class="block w-full px-3 rounded-md border-gray-300 shadow-sm" maxlength="10"
                                         >
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 mt-3">
                        <!-- ชื่อลูกค้า -->
                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">ชื่อลูกค้า</label>
                            <input type="text" id="name" name="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="ชื่อลูกค้า"
                                required>
                        </div>

                        <!-- เบอร์โทรศัพท์ -->
                        <div class="col-span-1">
                            <label for="inputtel" class="block text-sm font-medium text-red-500">*ไม่มีเบอร์โทรศัพท์

                            </label>
                            <div class="flex items-center mt-1">
                                <input type="checkbox" id="notel" name="notel"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2"
                                    onchange="toggleRequired()">
                                <input type="number" id="inputtel" name="inputtel" wire:model="tel"
                                    class="block w-full rounded-md border-gray-300 shadow-sm" maxlength="10"
                                    placeholder="เบอร์โทร" >
                            </div>
                        </div>

                        <!-- Agents -->
                        <div class="col-span-1">
                            <label for="inputAgent" class="block text-sm font-medium text-gray-700">Agents</label>
                            <select id="agent" name="agent" wire:model.live="inputAgent"
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
                            <input type="text" id="contact" wire:model="inputcontact" name="contact"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>



                        <!-- ประเภท -->
                        <div class="col-span-1">
                            <label for="inputTravel" class="block text-sm font-medium text-gray-700">ประเภท</label>
                            <select id="inputTravel" name="inputTravel"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1"
                                wire:model.change="selectedpackagetypes">
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
                                wire:model.live="selectedpackages" onchange="changepackage()">
                                <option selected value="0">กรุณาเลือก Package</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->name_boat }}
                                     
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @if ($selectedpackagetypes == 'private' or $selectedpackagetypes == '0')
                    <div class=" bg-gray-100 p-4 rounded-md border-gray-300 mt-3">
                        <div class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-5 gap-4">
                            <div class="grid grid-cols-1 gap-4 mt-2">
                                <div class="mt-4">
                                    <span class="font-semibold">จำนวนผู้โดยสาร</span>
                                </div>

                                <div>
                                    <input type="number" class="w-full border-gray-300 rounded-lg p-2 count"
                                        id="count_Private" name="count_Private" required>
                                        <input type="hidden" id="price_private" value="{{ $inputprice_Private }}">

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
                    <div  id="extra_req" class=" bg-blue-200 p-4 rounded-md border-gray-300 mt-3">
                        <input type="hidden" id="totalextra">
                        
                    </div>
                    <div class="flex justify-start mt-4 space-x-2">
                            <button type="button" onclick="addForm()"
                                class="px-2  bg-green-500 text-white rounded">+</button>
                            <button type="button" onclick="removeForm()"
                                class="px-2 bg-red-500 text-white rounded">-</button>
                        </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-6">
                        <div class="grid grid-cols-1">
                            <label for="count_Adult" class="block text-sm font-medium text-gray-700">
                                Adult</label>
                            <input type="number" id="count_Adult" name="count_Adult" wire:model="count_Adult"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" min="0"
                                placeholder="จำนวนที่นั่ง" oninput="calculateTotal()">
                        </div>


                        <div class="grid grid-cols-1">
                            <label for="inputprice_Adult"
                                class="block text-sm font-medium text-gray-700">ราคาต่อท่าน</label>
                            <input type="text" id="inputprice_Adult" name="inputprice_Adult"
                                value="{{ $inputprice_Adult }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                        </div>


                        <div class="grid grid-cols-1">
                            <label for="totalprice_Adult" class="block text-sm font-medium text-gray-700">ราคารวม

                            </label>
                            <input type="text" id="totalprice_Adult" name="totalprice_Adult"
                                wire:model="totalprice_Adult"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-6">
                        <div class="grid grid-cols-1">
                            <label for="count_Child" class="block text-sm font-medium text-gray-700">
                                Child</label>
                            <input type="number" id="count_Child" name="count_Child" wire:model="count_Child"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" min="0"
                                placeholder="จำนวนที่นั่ง" oninput="calculateTotal()">
                        </div>


                        <div class="grid grid-cols-1">
                            <label for="inputprice_Child"
                                class="block text-sm font-medium text-gray-700">ราคาต่อท่าน</label>
                            <input type="text" id="inputprice_Child" name="inputprice_Child"
                                value="{{ $inputprice_Child }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                        </div>


                        <div class="grid grid-cols-1">
                            <label for="totalprice_Child" class="block text-sm font-medium text-gray-700">ราคารวม

                            </label>
                            <input type="text" id="totalprice_Child" name="totalprice_Child"
                                wire:model="totalprice_Child"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                        </div>
                    </div>
                @endif
                @if ($selectedpackagetypes == 'join')
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-6">
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
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-6">
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
                @endif
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
                                <option value="end">Ent</option>
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
                                placeholder="ส่วนลด" onchange="calculatediscountagent()">
                            <input type="hidden" id="amountdiscountagent" name="amountdiscountagent">

                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <div class="form-group">
                            <label for="promocode" class="block text-sm font-medium text-gray-700">โค้ดส่วนลด</label>
                            <input type="text" id="promocode" name="promocode" wire:model.change="promocode"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="กรอกโค้ดโปรโมชั่น">
                        </div>
                    </div>

                    <!-- ส่วนลด -->
                    <div class="grid grid-cols-1">
                        <div class="form-group">
                            <label for="discount" class="block text-sm font-medium text-gray-700">ส่วนลด</label>
                            <input type="hidden" id="realdiscount" name="realdiscount" value="{{ $discount }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="ส่วนลด">
                            <input type="number" id="discount" name="discount" value="{{ $discount }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="ส่วนลด" onchange="calculatediscount()">
                        </div>
                    </div>

                   

                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mt-2">
                    <div class="grid grid-cols-1">
                        <div class="form-group">
                            <label for="totalPage" class="block text-sm font-medium text-gray-700">ราคาแพ็คเกจ</label>
                            <input type="text" id="totalPage" name="totalPage" value="{{ $totalPage }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="ราคาแพ็คเกจ" oninput="changetotalpage()">
                        </div>
                    </div>

                    <!-- รวมสุทธิ -->
                    <div class="grid grid-cols-1">
                        <div class="form-group">
                            <label for="total" class="block text-sm font-medium text-gray-700">รวมสุทธิ</label>
                            <input type="text" id="total" name="total" value="{{ $total }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="รวมสุทธิ" >
                        </div>
                    </div>
                    <!-- ราคาแพ็คเกจ -->


                    <!-- ราคาแพ็คเกจ -->
                    <div class="grid grid-cols-1 depositFields" style="display: none;">
                        <div class="form-group">
                            <label for="deposit" class="block text-sm font-medium text-gray-700">มัดจำ</label>
                            <input type="text" oninput="calculateDeposit()" wire:model="deposit" id="deposit"
                                name="deposit"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="ราคาแพ็คเกจ">
                        </div>
                    </div>

                    <!-- รวมสุทธิ -->
                    <div class="grid grid-cols-1 depositFields" style="display: none;">
                        <div class="form-group">
                            <label for="totaldept" class="block text-sm font-medium text-gray-700">ยอดคงค้าง</label>
                            <input type="text" id="totaldept" name="totaldept" wire:model="totaldept"
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
                            <input type="number"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                maxLength="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="account_number" name="account_number" wire:model="account_number"
                                placeholder="เลขที่บัญชีรับโอน">
                        </div>
                    </div>
                    <div class="grid grid-cols-1" id="tag_date_tranfer">
                        <div class="form-group">
                            <label for="datetime_transfer"
                                class="block text-sm font-medium text-gray-700">วันที่รับโอน</label>
                            <input type="datetime-local" wire:model="datetime_transfer"
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
                            onchange="document.getElementById('Slipimg').src = window.URL.createObjectURL(this.files[0])">
                        @error('slip')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <img src="" id="Slipimg" class="w-full mt-2 slip">
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-1 lg:grid-cols-1 gap-4 mt-2">
                    <label for="note" class="block text-sm font-medium text-gray-700">หมายเหตุ</label>
                    <textarea id="note" name="note" wire:model.defer="note"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-5 gap-4 mt-6">
                    <button type="submit"
                        class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">บันทึก</button>
                    <button onclick="closeModal()" type="button"
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





    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        var totalpage = 0;

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

 function addForm() {
    const extraReqContainer = document.getElementById('extra_req');
    const fragment = document.createDocumentFragment();

    // Create a responsive row with 3 inputs
    const formGroup = document.createElement('div');
    formGroup.className = 'grid grid-cols-3 sm:grid-cols-1 md:grid-cols-3 gap-4 items-center bg-white p-3 rounded-md mt-2';

    // Description input
    const infoDiv = document.createElement('div');
    infoDiv.className = 'flex flex-col';
    infoDiv.innerHTML = `
        <label class="block text-sm font-bold text-blue-700">Description</label>
        <input type="text" name="extra_info[]" class="w-full rounded-md border-gray-300 shadow-sm mt-1">
    `;

    // Price input
    const priceDiv = document.createElement('div');
    priceDiv.className = 'flex flex-col';
    priceDiv.innerHTML = `
        <label class="block text-sm font-bold text-blue-700">Price</label>
        <input type="number" name="extra_price[]" class="w-full rounded-md border-gray-300 shadow-sm mt-1">
    `;

    // Type selection
    const typeDiv = document.createElement('div');
    typeDiv.className = 'flex flex-col';
    typeDiv.innerHTML = `
        <label class="block text-sm font-bold text-blue-700">Type</label>
        <select name="extra_type[]" class="w-full rounded-md border-gray-300 shadow-sm mt-1">
            <option value="increase">เพิ่ม</option>
            <option value="discount">ส่วนลด</option>
        </select>
    `;

    // Append all elements to the form group
    formGroup.appendChild(infoDiv);
    formGroup.appendChild(priceDiv);
    formGroup.appendChild(typeDiv);

    // Append the form group to the fragment and then to the container
    fragment.appendChild(formGroup);
    extraReqContainer.appendChild(fragment);
}


        function calculateextra() {

            const priceInputs = document.querySelectorAll('input[name="extra_price[]"]');

            let total = 0;

            priceInputs.forEach(input => {
                const value = parseFloat(input.value);
                console.log(value);
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



        function changepackage() {
            // ดึงค่าจาก input count_Adult
            const inputTravel = document.getElementById('inputTravel').value;
            if (inputTravel == 'private') {

            } else {
                var seatCountAdult = document.getElementById('count_Adult').value = 0;
                var seatCountChild = document.getElementById('count_Child').value = 0;
                document.getElementById('totalprice_Adult').value = 0;
                document.getElementById('totalprice_Child').value = 0;
            }

        }


        function calculateTotal() {
            const inputTravel = document.getElementById('inputTravel').value;



            if (inputTravel == 'private') {
                private_price = document.getElementById('price_private').value;

                var extraseat = document.getElementById('extraseat').value;
                var priceextraseat = document.getElementById('priceextraseat').value;
                var totalPage  = document.getElementById('totalPage').value;
                var extraseat = document.getElementById('extraseat').value*document.getElementById('priceextraseat').value;
                var discountagent = parseFloat(document.getElementById('discountagent').value)
               
                if(private_price != totalPage){
                    total = totalPage - ((totalPage * (discountagent / 100)))+extraseat;
                    document.getElementById('amountdiscountagent').value = totalPage * (discountagent / 100);
                }else{
                     total = (private_price - (private_price * (discountagent / 100)))+extraseat;
                     document.getElementById('amountdiscountagent').value = private_price * (discountagent / 100);
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


                @this.set('totalprice_Adult', totalPriceAdult);
                @this.set('totalprice_Child', totalPriceChild);



                // คำนวณผลรวมทั้งหมด
                total = 0; // เริ่มต้นใหม่ทุกครั้ง
                // คำนวณผลรวมของทุก input
                var inputs = document.querySelectorAll('[id^="totalprice_"]');
                inputs.forEach(function(input) {
                    total += parseFloat(input.value.replace(/,/g, '')) || 0; // บวกค่าทั้งหมด
                });

            }



            // อัปเดตค่าใน Livewire
            document.getElementById('total').value = new Intl.NumberFormat().format(total);
            // @this.set('totalPage', totalpage); // ส่งค่าผลรวมทั้งหมดไปที่ Livewire
            @this.set('total', total);

        }
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('event-details').style.display = 'none';
            var packagetype = @json($this->trip);

            packagetype.forEach(function(trip) {
                var events;

               events = @json($events);
              var userClass = @json(optional(auth()->user())->class);

                //--------------------- 1 ------------------------------
                var calendarEl = document.getElementById('calendar');
                if (calendarEl) {
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                         showNonCurrentDates: false,
                        selectable: true,
                        themeSystem: 'bootstrap',
                        events: events,

                        dateClick: function(info) {
                             if (userClass == 1) {
                                var selectedDate = info.dateStr;

                                // กำหนดวันที่ที่เลือกใน modal
                                document.getElementById('date').value = selectedDate;
                                document.getElementById('returndate').value = selectedDate;

                                @this.set('date', selectedDate, true);
                                @this.set('returndate', selectedDate, true);
                                @this.set('selectedtrip', trip.name_en, true);
                                // เรียกใช้ Modal ของ Tailwind
                                var bookingModal = document.getElementById('bookingModal');
                                bookingModal.classList.remove('hidden');
                            }

                        },
                        eventDidMount: function(info) {
                            // จัดข้อความให้อยู่ตรงกลาง

                            info.el.style.textAlign = 'center';


                        },
                         eventMouseEnter: function(info) {
                            var event = info.event;
                            var bookingId = event.id;
                                // ใช้ fetch เพื่อดึงข้อมูลจากเซิร์ฟเวอร์
                                fetch('/get-booking-details/' + bookingId) // URL ที่จะดึงข้อมูล
                                    .then(response => response.json())
                                    .then(data => {
                                        // console.log(data);
                                        // แสดงข้อมูลที่ได้จาก AJAX ไปที่ฟอร์ม
                                        document.getElementById('hvbookingcode').value = data.booking_code;
                                         document.getElementById('hvname').value = data.name;
                                        document.getElementById('hvpackage').value = data.package;
                                        document.getElementById('hvagent').value = data.agent;
                                        document.getElementById('hvtel').value = data.tel;
                                        document.getElementById('hvseat').value = data.seat;
                                        let slip1 = document.getElementById('slip1');
                                        let slip2 = document.getElementById('slip2');
                                        let slip3 = document.getElementById('slip3');
                                        slip1.src = "";
                                        slip2.src = "";
                                        slip3.src = "";
                                        if (data.slip1 && data.slip1.trim() !== "") {
                                            document.getElementById('slip1').setAttribute('src', data.slip1);
                                            let slip1Div = document.getElementById('divslip1');
                                             slip1Div.hidden = false; // แสดง div
                                        }
                                        if (data.slip2 && data.slip2.trim() !== "") {
                                            document.getElementById('slip2').setAttribute('src', data.slip2);
                                            let slip2Div = document.getElementById('divslip2');
                                             slip2Div.hidden = false; // แสดง div
                                        }
                                        if (data.slip3 && data.slip3.trim() !== "") {
                                            document.getElementById('slip3').setAttribute('src', data.slip3);
                                            let slip3Div = document.getElementById('divslip3');
                                             slip3Div.hidden = false; // แสดง div
                                        }

                                       

                                        
                                        document.getElementById('event-details').style.display = 'block'; 
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });
                            },
                            eventMouseLeave: function(info) {
                                // Hide the event details container when mouse leaves
                                document.getElementById('event-details').style.display = 'none';
                            }

                    });

                    calendar.render();
                }
                //--------------------- end 1 ------------------------------
            });
        });

        function calculateDeposit() {
            var depositAmount = parseFloat(document.getElementById('deposit').value.replace(/,/g, '') || 0);
            var totalpage = parseFloat(document.getElementById('total').value.replace(/,/g, '') || 0);
            var outstandingAmount = totalpage - depositAmount;
            document.getElementById('totaldept').value = new Intl.NumberFormat().format(outstandingAmount); // แสดงยอดคงค้าง

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

          
            totaldiscount = totalPage * (discountagent / 100) + parseFloat(realdiscount);

            // document.getElementById('totalPage').value = total > 0 ? total.toFixed(2) : 0;
             document.getElementById('total').value = total > 0 ? total.toFixed(2) : 0;
             document.getElementById('discount').value =   totaldiscount;
          
        }

        function changetotalpage() {

            const totalPage = parseFloat(document.getElementById('totalPage').value) || 0;

            document.getElementById('total').value = totalPage;
        }


        function closeModal() {
            var bookingModal = document.getElementById('bookingModal');
            bookingModal.classList.add('hidden');
            location.reload();
        }
    </script>

    <script></script>

</div>
