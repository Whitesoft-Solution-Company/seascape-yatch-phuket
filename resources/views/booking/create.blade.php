<x-header />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<div class="flex flex-col min-h-screen mt-6">
 
    <div class="flex-grow">
        
        <div class="max-w-2xl mx-auto ">
            <a href="/"
                class=" top-4 left-4 flex items-center text-blue-500 hover:text-blue-700 transition-colors">
                <img src="https://img.icons8.com/ios-filled/50/000000/left.png" alt="Back Icon" class="h-6 w-6 mr-2">
                กลับ
            </a>
        </div>
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <strong class="font-bold">เกิดข้อผิดพลาด:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="max-w-2xl mx-auto py-8 px-6 bg-white shadow-lg rounded-lg">
            

            <h1 class="text-3xl font-bold mb-6 text-gray-800">Booking for {{ $package->yachts->name }}</h1>

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div class="mt-4">
                        <span class="font-semibold">วันที่</span>
                    </div>

                    <div>
                        <input type="date" class="w-full border-gray-300 rounded-lg p-2" id ="date_booking" name="date_booking" readonly
                            value="<?= $date ?>">
                    </div>
                </div>
                @if($package->packagetype->name_en == 'over_night')
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div class="mt-4">
                        <span class="font-semibold">ถึงวันที่</span>
                    </div>

                    <div>
                        <input type="date" class="w-full border-gray-300 rounded-lg p-2" id ="date_return" name="date_return" readonly
                            value="<?= $datereturn ?>">
                    </div>
                </div>
                @endif

                <input type="hidden" id="package_id" name="package_id"
                value="<?= $package->id ?>">

                @foreach ($package->prices as $value)
                    @if ($package->packageType->trip_type == 'private')
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div class="mt-4">
                                <span class="font-semibold">จำนวนผู้โดยสาร</span>
                            </div>

                            <div>
                                <input type="number" onchange="toggleInsuranceFields()"
                                    class="w-full border-gray-300 rounded-lg p-2 count" id="count_Private" name="count_Private"
                                    required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-1">
                            <div class="mt-4">
                                <span
                                    class="font-semibold">{{ $value->person_type . ' Trip ' . $package->min . ' - ' . $package->max . ' person' }}
                                    :</span>

                            </div>
                            <div>

                                <div class="flex items-center mt-2">
                                    <input type="price" class="w-full border-gray-300 rounded-lg p-2" name="price"
                                        readonly value=" <?= number_format($value->regular) ?> Baht">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-4 mt-1">
                            <div class="mt-4">
                                <span class="font-semibold">{{ $value->person_type }} :</span>
                                <?= number_format($value->regular) ?> Baht
                            </div>
                            <div>
                               
                            
                                <div class="flex items-center mt-4">
                                    <button type="button" onclick="decreaseCount('{{ $value->person_type }}')"
                                        class="btn btn-minus bg-gray-200 text-gray-700 px-3 py-1 rounded-l">-</button>
                                    <input class="text-center w-12 border-t border-b border-gray-300 count calcu"
                                        type="text" value="0" id="count_{{ $value->person_type }}"
                                        name="count_{{ $value->person_type }}">
                                    <button type="button" onclick="increaseCount('{{ $value->person_type }}')"
                                        class="btn btn-plus bg-gray-200 text-gray-700 px-3 py-1 rounded-r">+</button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if ($package->packageType->trip_type == 'join')
                <div class="grid grid-cols-2 gap-4 mt-1">
                    <div class="mt-4">
                        <span class="font-semibold">เด็กเล็ก :</span>
                        0 - 3 ปี FREE
                    </div>
                    <div>
                       
                      
                        <div class="flex items-center mt-4">
                            <button type="button" onclick="decreaseCount('baby')"
                                class="btn btn-minus bg-gray-200 text-gray-700 px-3 py-1 rounded-l">-</button>
                            <input class="text-center w-12 border-t border-b border-gray-300 count calcu"
                                type="text" value="0" id="count_baby"
                                name="count_baby">
                            <button type="button" onclick="increaseCount('baby')"
                                class="btn btn-plus bg-gray-200 text-gray-700 px-3 py-1 rounded-r">+</button>
                        </div>
                    </div>
                </div>
                @endif
                <div class="mt-4">
                    <input type="checkbox" id="insuranceCheckbox" class="form-checkbox h-5 w-5 text-blue-600"
                        onclick="toggleInsuranceFields()">
                    <label for="insuranceCheckbox" class="ml-2 text-gray-700 font-semibold">
                        ประสงค์ที่จะทำประกันการท่องเที่ยว
                    </label>
                </div>
                <!-- Container for ID Card Inputs -->
                <div id="insuranceFieldsContainer" class="mt-4"></div>
                <div class="mt-2 w-full">
                    <label for="txt_note" class="block text-sm font-semibold">Additional information</label>
                    <textarea class="form-textarea mt-1 w-full border-gray-300 rounded-lg p-2" id="txt_note" rows="3"
                        name="txt_note"></textarea>
                </div>
                <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-6 text-center">ช่องทางการชำระเงินผ่าน 2C2P</h2>

                    <!-- 2C2P Payment Methods -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Credit/Debit Card -->
                        <div class="flex items-center p-4 border border-gray-300 rounded-lg">
                            <img src="https://img.icons8.com/?size=100&id=JrEEtw25Fn6S&format=png&color=000000"
                                alt="Credit Card" class="w-12 h-12 mr-4">
                            <div>
                                <h3 class="text-lg font-semibold">บัตรเครดิต/เดบิต</h3>
                                <p class="text-gray-600">Visa, MasterCard, JCB, UnionPay</p>
                            </div>
                        </div>

                        <!-- Internet Banking -->
                        <div class="flex items-center p-4 border border-gray-300 rounded-lg">
                            <img src="https://img.icons8.com/color/48/000000/online-money-transfer.png"
                                alt="Internet Banking" class="w-12 h-12 mr-4">
                            <div>
                                <h3 class="text-lg font-semibold">อินเทอร์เน็ตแบงก์กิ้ง</h3>
                                <p class="text-gray-600">กรุงไทย, กสิกรไทย, ไทยพาณิชย์, กรุงเทพ</p>
                            </div>
                        </div>

                        <!-- Over-the-Counter -->
                        <div class="flex items-center p-4 border border-gray-300 rounded-lg">
                            <img src="https://img.icons8.com/color/48/000000/cash-in-hand.png" alt="Over the Counter"
                                class="w-12 h-12 mr-4">
                            <div>
                                <h3 class="text-lg font-semibold">ชำระผ่านเคาน์เตอร์</h3>
                                <p class="text-gray-600">7-Eleven, Tesco Lotus, BigC, ไปรษณีย์ไทย</p>
                            </div>
                        </div>

                        <!-- e-Wallet -->
                        <div class="flex items-center p-4 border border-gray-300 rounded-lg">
                            <img src="https://img.icons8.com/color/48/000000/wallet.png" alt="e-Wallet"
                                class="w-12 h-12 mr-4">
                            <div>
                                <h3 class="text-lg font-semibold">e-Wallet</h3>
                                <p class="text-gray-600">TrueMoney, AirPay, mPay</p>
                            </div>
                        </div>

                        <!-- QR Payment -->
                        <div class="flex items-center p-4 border border-gray-300 rounded-lg">
                            <img src="https://img.icons8.com/color/48/000000/qr-code.png" alt="QR Payment"
                                class="w-12 h-12 mr-4">
                            <div>
                                <h3 class="text-lg font-semibold">QR Payment</h3>
                                <p class="text-gray-600">สแกน QR Code ผ่าน Mobile Banking</p>
                            </div>
                        </div>

                        <!-- Additional Method -->
                        <div class="flex items-center p-4 border border-gray-300 rounded-lg">
                            <img src="https://img.icons8.com/color/48/000000/mobile-payment.png" alt="Mobile Payment"
                                class="w-12 h-12 mr-4">
                            <div>
                                <h3 class="text-lg font-semibold">Mobile Payment</h3>
                                <p class="text-gray-600">แอปพลิเคชันชำระเงินต่างๆ</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 w-full">
                    <button type="submit"
                        class="w-full bg-green-500 text-white font-semibold py-3 rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center">
                        <img src="https://img.icons8.com/?size=100&id=66087&format=png&color=000000"
                            alt="Payment Icon" class="h-6 w-6 mr-2">
                        ชำระเงิน
                    </button>


                </div>


            </form>
         
        </div>
    </div>
    <x-footer />
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('alert'))
    <script>
        Swal.fire({
            icon: '{{ session('alert.type') }}',
            title: '{{ session('alert.title') }}',
            text: '{{ session('alert.message') }}',
            confirmButtonText: 'ตกลง'
        });
    </script>
@endif


<script>
    function increaseCount(person) {
        console.log('count_' + person);
        const countInput = document.getElementById('count_' + person);
        let count = parseInt(countInput.value);
        count += 1;
        countInput.value = count;
        if (document.getElementById('insuranceCheckbox').checked) {
            toggleInsuranceFields();
        }
    }

    function decreaseCount(person) {
        const countInput = document.getElementById('count_' + person);
        let count = parseInt(countInput.value);
        if (count > 0) {
            count -= 1;
            countInput.value = count;
        }
        if (document.getElementById('insuranceCheckbox').checked) {
            toggleInsuranceFields();
        }
    }

    function calculateAge(dob) {
        const today = new Date();
        const birthDate = new Date(dob);
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();

        // Adjust age if the birthdate has not yet occurred this year
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        return age;
    }

    function toggleInsuranceFields() {
        const countElement = document.getElementById('count_Private');
        const countAdultElement = document.getElementById('count_Adult');
        const countChildElement = document.getElementById('count_Child');
        const countBabyElement = document.getElementById('count_baby');
        const container = document.getElementById('insuranceFieldsContainer');
        container.innerHTML = ''; // Clear any existing input fields

        let count = 0;

        if (countElement && countElement.value) {
            count += parseInt(countElement.value);
        }

        if (countAdultElement && countAdultElement.value) {
            count += parseInt(countAdultElement.value);
        }

        if (countChildElement && countChildElement.value) {
            count += parseInt(countChildElement.value);
        }
        if (countBabyElement && countBabyElement.value) {
            count += parseInt(countBabyElement.value);
        }


        if (isNaN(count) || count <= 0) {
            // แจ้งเตือนผู้ใช้กรอกข้อมูลที่ถูกต้อง
            Swal.fire({
                icon: 'error',
                title: 'ข้อมูลไม่ครบ',
                text: 'กรุณากรอกจำนวนผู้โดยสารให้ครบถ้วน',
                confirmButtonText: 'OK'
            }).then(() => {
                // Uncheck the checkbox
                const insuranceCheckbox = document.getElementById('insuranceCheckbox');
                if (insuranceCheckbox) {
                    insuranceCheckbox.checked = false;
                }
            });
            return;
        }

        if (document.getElementById('insuranceCheckbox').checked) {
            for (let i = 0; i < count; i++) {
                const personDiv = document.createElement('div');
                personDiv.className =
                    'mt-4 p-4 border border-gray-300 rounded-lg flex flex-row space-x-2'; // เพิ่มระยะห่างที่นี่

                // ID Card input
                const idCardInput = document.createElement('input');
                idCardInput.type = 'text';
                idCardInput.name = `id_card_${i + 1}`;
                idCardInput.placeholder = `ID Card Number for Person ${i + 1}`;
                idCardInput.className = 'flex-1 border-gray-300 rounded-lg p-2 mb-2';

                // Name input
                const nameInput = document.createElement('input');
                nameInput.type = 'text';
                nameInput.name = `name_${i + 1}`;
                nameInput.placeholder = `Name for Person ${i + 1}`;
                nameInput.className = 'flex-1 border-gray-300 rounded-lg p-2 mb-2';

                // Date of Birth input
                const dobInput = document.createElement('input');
                dobInput.type = 'date';
                dobInput.name = `dob_${i + 1}`;
                dobInput.placeholder = `Date of Birth for Person ${i + 1}`;
                dobInput.className = 'flex-1 border-gray-300 rounded-lg p-2 mb-2';

                // Hidden Age input
                const ageInput = document.createElement('input');
                ageInput.type = 'hidden';
                ageInput.name = `age_${i + 1}`;

                // Event listener to update age when dob changes
                dobInput.addEventListener('change', (event) => {
                    const dobValue = event.target.value;
                    if (dobValue) {
                        const age = calculateAge(dobValue);
                        ageInput.value = age;
                    } else {
                        ageInput.value = '';
                    }
                });

                // Append inputs to personDiv
                personDiv.appendChild(idCardInput);
                personDiv.appendChild(nameInput);
                personDiv.appendChild(dobInput);
                personDiv.appendChild(ageInput); // เพิ่ม ageInput ที่นี่

                // Append personDiv to container
                container.appendChild(personDiv);
            }
        } else {
            // Clear inputs if checkbox is unchecked
            const personDivs = container.querySelectorAll('div');
            personDivs.forEach(div => {
                div.querySelectorAll('input').forEach(input => {
                    input.value = ''; // Clear value of all inputs
                });
            });
        }
    }
</script>
@vite('resources/css/app.css')
