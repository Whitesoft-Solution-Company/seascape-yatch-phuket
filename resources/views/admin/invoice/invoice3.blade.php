<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

</head>

<style>
    html {
        margin: 0px;
        size: A4 portrait;
        size: auto;
        margin-left: 0mm;
        margin-bottom: 0mm;
        margin-top: 0mm;
        zoom: 90%;
        font-size: 14px;

    }

    body {
        /* background: #eee; */
        /* border: solid 1px #eee; */

    }

    div.container {
        border-radius: 15px;
        background: white;
    }

    div.invoice-letter {
        width: auto;
        position: relative;
        background-color: rgba(0, 0, 0, 0.2);
    }

    table tbody tr {
        vertical-align: middle !important;
    }

    .item {
        text-align: left;
    }

    .eng {
        font-size: 12px;
        font-weight: normal;
    }
</style>

<body>

    <div class=" px-2 py-1 center" id="toPDF">

        <!-- ส่วน หัวข้อใบเสนอราคา -->
        <div class="row">
            <div class="col-3">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" width="100px" class="rounded float-start">
            </div>
            <div class="col-6">
                <h5>SEASCAPE YACHT PHUKET <span class="eng"><em>by Khemtis Itinerary Co.,Ltd.</em></span></h5>
                <p class="mb-0">1168 หมู่ที่ 2 ตำบลปากน้ำ อำเภอละงู จังหวัดสตูล 90110</em></p>
                <p class="mb-0">Office : 090-310-3019</em></p>
                <p class="mb-0">E-mail : lipeyachtcharter@gmail.com</em></p>
                <p class="mb-0">Website : www.khemtis.com</em></p>

                <h6>ใบอนุญาตประกอบธุรกิจนำเที่ยว : <span class="fw-bold"> 42/00299</span></h6>
            </div>

            <div class="col-2 text-center">
                <h4>Booking</h4>
                <h5 class="text-danger">CONFIRMATION</h5>
                <?php
                $qrcode = route('booking_detail', ['bid' => $data->id]);

                $url = 'https://api.qrserver.com/v1/create-qr-code/?data=' . $qrcode . '&amp;size=100x100';
                ?>
                <img src="<?= $url ?>" class="img-qr-code mb-1 border p-2" alt="...">
            </div>

        </div>
        <!-- ส่วน วันที่จอง - วันหมดอายุ -->
        <div class="container-fluid invoice-letter mt-3">
            <div class="row">
                <div class="col-6 mt-2">
                    <p class="m-0 p-0">วันที่จอง :{{ $data->booking_time }} <span class="fw-bold m-3"></span> </p>

                    <p class="eng">Booking Date :{{ $data->booking_time }}</p>
                </div>
                <div class="col-6 mt-2">

                    <p class="m-0 p-0">วันหมดอายุ :
                        {{ \Carbon\Carbon::parse($data->booking_time)->addYear()->format('Y-m-d') }}<span
                            class="fw-bold m-3"></span> </p>
                    <p class="eng">Expiration Date
                        :{{ \Carbon\Carbon::parse($data->booking_time)->addYear()->format('Y-m-d') }}</p>
                </div>
            </div>
        </div>

        <!-- ตารางแสดงข้อมูล -->
        <div class="row mt-3">
            <div class="col-6">
                <table class="invoice table">
                    <tbody>
                        <tr>
                            <td scope="row">เลขที่ใบจอง : <br> <span class="eng">Booking ID : </span></td>
                            <th class="item">{{ $data->booking_code }}</th>
                        </tr>
                        <tr>
                            <td scope="row">ชื่อลูกค้า : <br> <span class="eng">Client : </span></td>
                            <th class="item">{{ $data->name }}</td>
                        </tr>
                        <tr>
                            <td scope="row">ช่องทางการติดต่อ : <br> <span class="eng">social Media : </span></td>
                            <th class="item">{{ $data->contact }}</td>
                        </tr>
                        <tr>
                            <td scope="row">เบอร์โทรศัพท์ : <br> <span class="eng">Phone Number : </span></td>
                            <th class="item">{{ $data->tel }}</td>
                        </tr>
                        <tr>
                            <?php if ($data->private_seat > 0) {
                                $adult = $data->private_seat;
                                $kid = 0;
                                $baby = 0;
                            } else {
                                $adult = $data->adult;
                                $kid = $data->child;
                                $baby = $data->baby;
                            } ?>
                            <td scope="row">จำนวนผู้ใหญ่ : <br> <span class="eng">Number of Adults : </span></td>
                            <th class="item">{{ $adult }}</td>
                        </tr>
                        <tr>
                            <td scope="row">จำนวนเด็ก : <br> <span class="eng">Number of children : </span></td>
                            <th class="item">{{ $kid }}</td>

                        </tr>
                        <tr>
                            <td scope="row">จำนวนเด็กเล็ก : <br> <span class="eng">Number of baby : </span></td>
                            <th class="item">{{ $baby }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-6">
                <table class="invoice table">
                    <tbody>
                        <tr>
                            <td scope="row">ช่องทางการจอง : <br> <span class="eng">Channel : </span></td>
                            <th class="item">{{ $data->agents->agent_name }} </th>

                        </tr>
                        <tr>
                            <td scope="row">วันเดินทาง : <br> <span class="eng">Arrival Date : </span></td>
                            <th class="item"> {{ $data->departure_date }}</td>
                        </tr>
                        <tr>
                            <td scope="row">วันเดินทางกลับ : <br> <span class="eng">Departure Date : </span></td>
                            <th class="item">{{ $data->return_date }}</td>
                        </tr>
                        <tr>
                            <td scope="row">ทริปเที่ยว : <br> <span class="eng">Trip : </span></td>
                            <th class="item">{{ $data->package->name_boat }}</td>
                        </tr>
                        <tr>
                            <td scope="row">เวลา : <br> <span class="eng">Time : </span></td>
                            <?php if ($data->package->packageType->name_en == "oneday_trip") : ?>
                            <th class="item">09.00 AM. - 14.30 PM.</td>
                                <?php elseif ($data->package->packageType->name_en == "sunset") : ?>
                            <th class="item">16.00 PM. - 18.30 PM.</td>
                                <?php endif ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- สิทธิประโยชน์ที่ได้รับ -->
        <div class="container-fluid invoice-letter mt-3">
            <div class="row">
                <div class="col-3 mt-2">
                    <p>สิทธิประโยชน์ที่ได้รับ : </p>
                </div>
                <div class="col-9 mt-2">
                    <p class="fw-bold">{{ $data->package->note }}</p>
                </div>

            </div>
        </div>

        <!-- รายละเอียดการชำระเงิน -->
        <div class="row">
            <h6 class="fw-bold my-2">รายละเอียดการชำระเงิน (Payment Detail :)</h6>
            <div class="col-4 mt-2">
                <p class="m-0 p-0">มัดจำ : <span class="fw-bold m-3"> {{ number_format($data->pledge) }} </span> </p>
                <p class="eng">Dep :</p>
            </div>
            <div class="col-4 mt-2">
                <p class="m-0 p-0">ราคาสุทธิ : <span class="fw-bold m-3"> {{ number_format($data->amount) }} </span>
                </p>
                <p class="eng">Price :</p>
            </div>
            <div class="col-4 mt-2">
                <p class="m-0 p-0">ค้างชำระ : <span class="fw-bold m-3"> {{ number_format($data->arrearage) }} </span>
                </p>
                <p class="eng">Remain :</p>
            </div>
        </div>
        <hr>
        <p class="text-start text-decoration-underline mt-3 mb-0"><em>ข้อกำหนดและเงื่อนไข</em></p>
        <p class="text-start m-0">2. หากคุณลูกค้าต้องการเปลี่ยนแปลงหรือเลื่อนวันเดินทาง ต้องแจ้งล่วงหน้าอย่างน้อย 14
            วันก่อนวันเดินทาง</p>
        <span class="eng m-4">Customers must notify changes or reschedule at least 14 days prior to
            departure.</span><br>

        <p class="text-start m-0">3. โปรแกรมการเดินทางอาจมีการเปลี่ยนแปลงตามสภาพอากาศ</p>
        <span class="eng m-4">Travel programs may be subject to changes based on weather conditions.</span><br>

        <p class="text-start m-0">4. หากไม่สามารถเดินทางได้เนื่องจากสภาพอากาศ บริษัทจะแจ้งยกเลิกก่อนการเดินทางอย่างน้อย
            2 ชั่วโมง</p>
        <span class="eng m-4">In case travel is not possible due to weather conditions, the company will notify
            cancellation at least 2 hours before departure.</span><br>

        <p class="text-start m-0">5. ลูกค้าสามารถเลื่อนวันเดินทางได้ไม่เกิน 3 วันหรือขอเงินคืนเต็มจำนวน</p>
        <span class="eng m-4">Customers can reschedule travel up to 3 days or request full refund.</span><br>

        <p class="text-start m-0">6. ในกรณีที่ยังไม่มีกำหนดวันเดินทาง กรุณาโทรเพื่อเช็คที่นั่งก่อนวันเดินทาง</p>
        <span class="eng m-4">In case travel date is not yet scheduled, please call to check for seat availability
            before departure.</span><br>

        <p class="text-start m-0">7. บริษัทจะรับผิดชอบตามรายละเอียดใน Voucher เท่านั้น</p>
        <span class="eng m-4">The company will be responsible according to the details in the voucher.</span><br>
    </div>
    <br><br><br><br>
    <div class="row">
        <h4 style="color:red; padding-left: 10%;">หมายเหตุ :{{ $data->note }}</h4>
    </div>
   @if (!empty($data->payments[0]->slip))


         <div style="display: flex; justify-content: center; align-items: center;">
            @if($paymentSlipUrl1 != '-')
                <img src="{{ asset('storage/slip/' . $paymentSlipUrl1) }}" style="width: 50% !important; margin: 0 10px;" />
            @endif
            @if($paymentSlipUrl2 != '-')
                <img src="{{ asset('storage/slip/' . $paymentSlipUrl2) }}" style="width: 50% !important; margin: 0 10px;" />
            @endif






        </div>
          @if($paymentSlipUrl3 != '-')
                <img src="{{ asset('storage/slip/' . $paymentSlipUrl3) }}" style="width: 50% !important; margin: 0 10px;" />
            @endif
@endif


</body>

<script>
    $(document).ready(function() {
        var isClosed = false;
        window.print();
        window.onafterprint = window.close;
    });
</script>

</html>
