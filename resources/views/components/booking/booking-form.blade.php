<div>
    <div wire:ignore.self id="calendar"></div>


    <div wire:ignore.self id="bookingModal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl w-full overflow-y-auto max-h-[90vh] mt-10 mb-10">
            <h2 class="text-lg font-bold mb-4">Booking Details</h2>

            <form action="{{ route('booking.addbooking') }}" method="POST" enctype="multipart/form-data" class="px-5">
                @csrf


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <!-- รหัสการจอง -->
                    <div class="col-span-1">
                        <label for="input_codebooking"
                            class="block text-sm font-medium text-gray-700">รหัสการจอง</label>
                        <input type="text" id="bookingcode" name="bookingcode" wire:model="bookingcode"
                            value="{{ $bookingcode }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>



                    <div class="col-span-1">
                        <label for="nodate" class="block text-sm font-medium text-gray-700">ไม่ระบุวันที่
                            <span class="text-red-500 text-xs">*ติ๊กช่องด้านหน้าหากไม่ต้องการระบุวันที่การจอง</span>
                        </label>
                        <div class="flex items-center mt-1">
                            <input type="checkbox" id="nodate" name="nodate" wire:model="nodate"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">

                            <input type="date" id="date" name="date" wire:model="date"
                                class="block w-full rounded-md border-gray-300 shadow-sm" maxlength="10"
                                readonly>
                            @if ($selectedpackages->packageType->name_en == 'over_night')
                            <input type="date" id="returndate" name="returndate" wire:model="returndate"
                                class="block w-full px-3 rounded-md border-gray-300 shadow-sm" maxlength="10">
                            @endif

                        </div>
                    </div>

                    <!-- ชื่อลูกค้า -->
                    <div class="col-span-1">
                        <label for="name" class="block text-sm font-medium text-gray-700">ชื่อลูกค้า</label>
                        <input type="text" id="name" name="name" wire:model="name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="ชื่อลูกค้า">
                    </div>

                    <!-- เบอร์โทรศัพท์ -->
                    <div class="col-span-1">
                        <label for="inputtel" class="block text-sm font-medium text-gray-700">เบอร์โทรศัพท์
                            <span class="text-red-500 text-xs">*ติ๊กช่องด้านหน้าหากไม่มีเบอร์โทรศัพท์</span>
                        </label>
                        <div class="flex items-center mt-1">
                            <input type="checkbox" id="notel" name="notel" wire:model="notel"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                            <input type="number" id="inputtel" name="inputtel" wire:model="tel"
                                class="block w-full rounded-md border-gray-300 shadow-sm" maxlength="10"
                                placeholder="เบอร์โทร">
                        </div>
                    </div>

                    <!-- Agents -->
                    <div class="col-span-1">
                        <label for="inputAgent" class="block text-sm font-medium text-gray-700">Agents</label>
                        <select id="agent" name="agent" wire:model="inputAgent"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1">
                            <option selected disabled>กรุณาเลือก Agent</option>
                            @foreach ($agents as $agent)
                            <option value="{{ $agent->agent_id }}">{{ $agent->agent_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- จองผ่านช่องทาง -->
                    <div class="col-span-1">
                        <label for="inputcontact" class="block text-sm font-medium text-gray-700">จองผ่านช่องทาง</label>
                        <input type="text" id="contact" wire:model="inputcontact" name="contact"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>



                    <!-- ประเภท -->
                    <div class="col-span-1">
                        <label for="inputTravel" class="block text-sm font-medium text-gray-700">ประเภท</label>
                        <select id="inputTravel" name="inputTravel"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1"
                            wire:model.change="selectedpackagetypes">
                            <option selected disabled>กรุณาเลือกประเภท</option>
                            @foreach ($types as $type)
                            <option value="{{ $type->name_en }}">{{ str_replace('_', ' ', $type->name_en) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">

                        <label for="package" class="block text-sm font-medium text-gray-700">Package</label>
                        <select id="package" name="package"
                            class="block w-full rounded-md border-gray-300 shadow-sm mt-1"
                            wire:model.change="selectedpackages">
                            <option selected disabled>กรุณาเลือก Package</option>
                            @foreach ($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->name_boat }}</option>
                            @endforeach
                        </select>
                    </div>

                    @foreach ($selectedpackages->prices as $index => $value)
                    @if ($selectedpackages->packageType->trip_type == 'private')
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <div class="mt-4">
                            <span class="font-semibold">จำนวนผู้โดยสาร</span>
                        </div>

                        <div>
                            <input type="number" class="w-full border-gray-300 rounded-lg p-2 count"
                                id="count_Private" wire:model="count_Private"
                                oninput="calculateTotal('{{ $value->person_type }}')" name="count_Private"
                                required>
                            <input type="hidden" id="price_private"
                                value="{{ number_format($value->regular) }}">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-1">
                        <div class="mt-4">
                            <span
                                class="font-semibold">{{ $value->person_type . ' Trip ' . $package->min . ' - ' . $package->max . ' person' }}
                            </span>

                        </div>
                        <div>


                        </div>
                    </div>
                    @else
                    <div class="flex col-span-2 items-center  space-x-4">
                        <div class="flex-1">
                            <label for="count_{{ $value->person_type }}"
                                class="block text-sm font-medium text-gray-700"> {{ $value->person_type }}</label>
                            <input type="number" id="count_{{ $value->person_type }}"
                                name="count_{{ $value->person_type }}"
                                wire:model="count_{{ $value->person_type }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" min="0"
                                placeholder="จำนวนที่นั่ง"
                                oninput="calculateTotal('{{ $value->person_type }}')"
                                data-index="{{ $index }}">
                        </div>


                        <div class="flex-1">
                            <label for="inputprice_{{ $value->person_type }}"
                                class="block text-sm font-medium text-gray-700">ราคาต่อท่าน</label>
                            <input type="text" id="inputprice_{{ $value->person_type }}"
                                name="inputprice_{{ $value->person_type }}"
                                value="{{ number_format($value->regular) }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                        </div>


                        <div class="flex-1">
                            <label for="totalprice_{{ $value->person_type }}"
                                class="block text-sm font-medium text-gray-700">ราคารวม

                            </label>
                            <input type="text" id="totalprice_{{ $value->person_type }}"
                                name="totalprice_{{ $value->person_type }}"
                                wire:model="totalprice_{{ $value->person_type }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @if ($selectedpackages->packageType->trip_type == 'join')
                    <div class="flex col-span-2 items-center  space-x-4">
                        <div class="flex-1">
                            <label for="count_baby"
                                class="block text-sm font-medium text-gray-700">เด็กเล็ก</label>
                            <input type="number" id="count_baby"
                                name="count_baby"
                                value="0"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" min="0"
                                placeholder="จำนวนที่นั่ง">
                        </div>


                        <div class="flex-1">
                            <label for="inputprice_baby"
                                class="block text-sm font-medium text-gray-700">ราคาต่อท่าน</label>
                            <input type="text" id="inputprice_baby"
                                name="inputprice_baby"
                                value="0"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                        </div>


                        <div class="flex-1">
                            <label for="totalprice_baby"
                                class="block text-sm font-medium text-gray-700">ราคารวม

                            </label>
                            <input type="text" id="totalprice_baby"
                                name="totalprice_baby"
                                value="0"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                        </div>
                    </div>
                    <div class="flex col-span-2 items-center  space-x-4">
                        <div class="flex-1">
                            <label for="count_guide"
                                class="block text-sm font-medium text-gray-700">ไกด์</label>
                            <input type="number" id="count_guide"
                                name="count_guide"
                                value="0"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" min="0"
                                placeholder="จำนวนที่นั่ง">
                        </div>


                        <div class="flex-1">
                            <label for="inputprice_guide"
                                class="block text-sm font-medium text-gray-700">ราคาต่อท่าน</label>
                            <input type="text" id="inputprice_guide"
                                name="inputprice_guide"
                                value="0"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                        </div>


                        <div class="flex-1">
                            <label for="totalprice_guide"
                                class="block text-sm font-medium text-gray-700">ราคารวม

                            </label>
                            <input type="text" id="totalprice_guide"
                                name="totalprice_guide"
                                value="0"
                                class="block w-full rounded-md border-gray-300 shadow-sm mt-1" readonly>
                        </div>
                    </div>
                    @endif
                    <div class="flex col-span-2 items-center  space-x-2">
                        <!-- ตั๋วเกิน -->
                        <div class="flex col-span-5">
                            <div class="flex-1">
                                <div class="form-group">
                                    <label for="overticket" class="block text-sm font-medium text-gray-700">
                                        ตั๋วเกิน</label>
                                    <div class="flex items-center mt-2">
                                        <!-- จัดการ checkbox กับ label ให้อยู่ใกล้กันมากขึ้น -->
                                        <input type="checkbox" wire:model="overticket" id="overticket" name="overticket"
                                            value="1"
                                            class="form-check-input h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">

                                    </div>
                                </div>
                            </div>
                            <div class="flex-3">
                                <div class="form-group px-2">
                                    <label for="inputpay" class="block text-sm font-medium text-gray-700">
                                        การชำระเงิน</label>
                                    <select id="inputpay" name="inputpay" wire:model.change="payment"
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
                        </div>


                        <!-- โค้ดส่วนลด -->
                        <div class="flex-1">
                            <div class="form-group">
                                <label for="promocode"
                                    class="block text-sm font-medium text-gray-700">โค้ดส่วนลด</label>
                                <input type="text" id="promocode" name="promocode" wire:model.change="promocode"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="กรอกโค้ดโปรโมชั่น">
                            </div>
                        </div>

                        <!-- ส่วนลด -->
                        <div class="flex-1">
                            <div class="form-group">
                                <label for="discount" class="block text-sm font-medium text-gray-700">ส่วนลด</label>
                                <input type="number" id="discount" name="discount" value="{{ $discount }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="ส่วนลด">
                            </div>
                        </div>


                    </div>
                    <div class="flex col-span-2 items-center  space-x-2">

                        <!-- ราคาแพ็คเกจ -->
                        <div class="flex-1">
                            <div class="form-group">
                                <label for="totalPage"
                                    class="block text-sm font-medium text-gray-700">ราคาแพ็คเกจ</label>
                                <input type="text" id="totalPage" name="totalPage" wire:model="totalPage"
                                    value="{{ $totalPage }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="ราคาแพ็คเกจ" readonly>
                            </div>
                        </div>

                        <!-- รวมสุทธิ -->
                        <div class="flex-1">
                            <div class="form-group">
                                <label for="total" class="block text-sm font-medium text-gray-700">รวมสุทธิ</label>
                                <input type="text" id="total" name="total" value="{{ $total }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="รวมสุทธิ" readonly>
                            </div>
                        </div>
                        @if ($payment == 'deposit')
                        <!-- ราคาแพ็คเกจ -->
                        <div class="flex-1">
                            <div class="form-group">
                                <label for="deposit"
                                    class="block text-sm font-medium text-gray-700">มัดจำ</label>
                                <input type="text" oninput="calculateDeposit()" wire:model="deposit"
                                    id="deposit"
                                    name="deposit"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="ราคาแพ็คเกจ">
                            </div>
                        </div>

                        <!-- รวมสุทธิ -->
                        <div class="flex-1">
                            <div class="form-group">
                                <label for="totaldept"
                                    class="block text-sm font-medium text-gray-700">ยอดคงค้าง</label>
                                <input type="text" id="totaldept" name="totaldept" wire:model="totaldept"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="รวมสุทธิ" readonly>
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="col-4 col-md-5 mtnclass" id="tag_account_num">
                        <div class="form-group">
                            <label for="account_number"
                                class="block text-sm font-medium text-gray-700">เลขที่บัญชีรับโอน(4 ตัวหลัง)</label>
                            <input type="number"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                maxLength="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="account_number" name="account_number" wire:model="account_number" placeholder="เลขที่บัญชีรับโอน">
                        </div>
                    </div>
                    <div class="col-4 col-md-5 mtnclass" id="tag_date_tranfer">
                        <div class="form-group">
                            <label for="datetime_transfer"
                                class="block text-sm font-medium text-gray-700">วันที่รับโอน</label>
                            <input type="datetime-local" wire:model="datetime_transfer"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="datetime_transfer" name="datetime_transfer">
                        </div>
                    </div>
                    <div class="col-10 col-md-6 col-lg-10 mtnclass" id="tag_slip">
                        <div class="form-group">
                            <label for="inputslip" id="labelslip"
                                class="block text-sm font-medium text-gray-700">สลิปโอนเงิน</label>
                            <input type="file" name="slip" id="slip" wire:model="slip"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                onchange="document.getElementById('Slipimg').src = window.URL.createObjectURL(this.files[0])">
                            @error('slip')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            <img src="" id="Slipimg" class="w-full mt-2 slip">
                        </div>
                    </div>





                </div>
                <div class="col-span-1">
                    <label for="note" class="block text-sm font-medium text-gray-700">หมายเหตุ</label>
                    <textarea id="note" name="note" wire:model.defer="note"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
                <div class="mt-6">
                    <button type="submit"
                        class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">บันทึก</button>
                    <button onclick="closeModal()" type="button"
                        class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                        ยกเลิก
                    </button>

                </div>

            </form>

            @if (session()->has('message'))
            <div class="mt-4 text-green-600">{{ session('message') }}</div>
            @endif
        </div>
    </div>


    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        var totalpage = 0;

        function calculateTotal(index) {

            if (index == 'Private') {
                totalpage = document.getElementById('price_private').value;
            } else {
                var seatCount = document.getElementById('count_' + index).value || 0;
                var pricePerPerson = document.getElementById('inputprice_' + index).value.replace(/,/g, '') || 0;
                var totalPrice = seatCount * pricePerPerson;
                console.log(totalPrice);
                // แสดงราคาที่คำนวณได้
                document.getElementById('totalprice_' + index).value = new Intl.NumberFormat().format(totalPrice);

                // คำนวณผลรวมทั้งหมด
                totalpage = 0; // เริ่มต้นใหม่ทุกครั้ง
                // คำนวณผลรวมของทุก input
                var inputs = document.querySelectorAll('[id^="totalprice_"]');
                inputs.forEach(function(input) {
                    totalpage += parseFloat(input.value.replace(/,/g, '')) || 0; // บวกค่าทั้งหมด
                });

            }



            // อัปเดตค่าใน Livewire
            document.getElementById('totalPage').value = new Intl.NumberFormat().format(totalpage);
            @this.set('totalPage', totalpage); // ส่งค่าผลรวมทั้งหมดไปที่ Livewire
            @this.set('total', totalpage);
        }
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    selectable: true,
                    events: @json($events),
                    dateClick: function(info) {
                        var selectedDate = info.dateStr;

                        // กำหนดวันที่ที่เลือกใน modal
                        document.getElementById('date').value = selectedDate;
                        document.getElementById('returndate').value = selectedDate;
                        @this.set('date', selectedDate);
                        @this.set('returndate', selectedDate);
                        // เรียกใช้ Modal ของ Tailwind
                        var bookingModal = document.getElementById('bookingModal');
                        bookingModal.classList.remove('hidden');
                    },
                    eventDidMount: function(info) {
                        // จัดข้อความให้อยู่ตรงกลาง
                        info.el.style.textAlign = 'center';
                    }
                });

                calendar.render();
            }
        });

        function calculateDeposit() {
            var depositAmount = parseFloat(document.getElementById('deposit').value.replace(/,/g, '') || 0);
            var totalpage = parseFloat(document.getElementById('total').value.replace(/,/g, '') || 0);
            var outstandingAmount = totalpage - depositAmount;
            document.getElementById('totaldept').value = new Intl.NumberFormat().format(outstandingAmount); // แสดงยอดคงค้าง

        }


        function closeModal() {
            var bookingModal = document.getElementById('bookingModal');
            bookingModal.classList.add('hidden');
            location.reload();
        }
    </script>
</div>