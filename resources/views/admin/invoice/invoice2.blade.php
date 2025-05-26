

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.debug.js"></script> -->

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/polyfills.umd.js"></script> -->

</head>

<style>
       html {
        /* background-color: #eee; */
        margin: 0px;
        /* bleed: 1cm; */
        size: A4 portrait;
        size: auto;
        margin-left: 0mm;
        margin-bottom: 0mm;
        margin-top: 0mm;
        zoom: 90%;
        font-size: 14px;

        }


    /* * {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    }

    .main-page {
       width: 210mm;
       min-height: 297mm;
       margin: 10mm auto;
       background: white;
       box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
     }
     .sub-page {
       padding: 1cm;
       height: 296mm;
     }
     @page {
       size: A4;
       margin: 0;
     }
     @media print {
       html, body {
     	width: 210mm;
     	height: 297mm;
       }
       .main-page {
     	margin: 0;
     	border: initial;
     	border-radius: initial;
     	width: initial;
     	min-height: initial;
     	box-shadow: initial;
     	background: initial;
     	page-break-after: always;
       }
     } */

    div.container {
        border-radius: 15px;
        background: white;
        /* box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2); */
    }

    div.invoice-letter {
        width: auto;
        position: relative;
        /* background-color: rgba(0, 0, 0, 0.2); */
        /* margin-right: -20px;
        margin-left: -20px; */
        /* box-shadow: 0 4px 3px rgba(0, 0, 0, 0.4); */
    }


    table tbody tr {
        vertical-align: middle !important;
    }

    .item {
        text-align: left;
    }

    .eng {
        font-size: 10px;
        /* font-weight: normal; */
    }
    .eng1 {
        font-size: 8px;
        font-weight: normal;
    }


</style>

<body>

    <div class=" px-2 py-1 center" >
        <!-- <div class="sub-page" id="toPDF"> -->


        <!-- <div class="html2pdf__page-break"></div> -->
        <div class="row">

            <div class="col-3">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" width="100px" class="rounded float-start">
            </div>
            <div class="col-7">
                <h6>SEASCAPE YACHT PHUKET <span class="eng"><em>by Khemtis Itinerary Co.,Ltd.</em></span></h6>
                <p class="mb-0">1168 หมู่ที่ 2 ตำบลปากน้ำ อำเภอละงู จังหวัดสตูล 91110</em></p>
                <p class="mb-0">Office : 090-310-3019</em></p>
                <p class="mb-0">E-mail : lipeyachtcharter@gmail.com</em></p>
                <p class="mb-0">Website : www.khemtis.com</em></p>
                <h6>ใบอนุญาตประกอบธุรกิจนำเที่ยว : <span class="fw-bold"> 42/00299</span></h6>
            </div>

            <div class="col-2 text-center">
                <h4>ใบแจ้งหนี้</h4>
                <h5 class="text-danger">INVOICE</h5>
            </div>

        </div>

         <!-- ส่วน ข้อมูลบริษัท -->
         <div class="container-fluid invoice-letter mt-3">
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-borderless d-print-table">
                        <tbody>
                            <tr>
                                <th scope="row">Agent : </th>
                                <td class="item">{{ $data->agents->agent_name }}</td>
                            </tr>
                            <tr style="font-size: 14px;">
                                <th scope="row">Address : </th>
                                @if (isset($data->agents->agent_address))
                                    <td class="item">{{ $data->agents->agent_addres }}</td>
                                @else
                                    <td class="item">-</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">Texpayer number : </th>
                                @if (isset($data->agents->tex_number))
                                    <td class="item">{{ $data->agents->tex_number }}</td>
                                @else
                                    <td class="item">-</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">Day : </th>
                                <td class="item">{{ $data->created_at }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- ถ้า name_yacht เป็น MANHATTAN  -->


        <div class="row mt-0 ">
            <div class="col-12">
                <table class="invoice table table-sm table-bordered text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th>ลำดับ</th>
                            <th>เลขที่เอกสาร</th>
                            <th>ชื่อลูกค้า</th>
                            <th colspan="{{ count($packageTypes) }}">การเดินทาง</th>


                            <th colspan="{{ $data->private_seat > 0 ? 1 : 3 }}">จำนวนลูกค้า(Pax)</th>
                            <th colspan="{{ $data->private_seat > 0 ? 1 : 2 }}">ราคา(Price)</th>
                            <th>ผลรวม</th>
                        </tr>
                        <tr>
                            <th><span class="eng">NO.</span></th>
                            <th><span class="eng">Booking No.</span></th>
                            <th><span class="eng">Guest Name</span></th>

                            @foreach ($packageTypes as $type)
                                <th><span class="eng">{{ $type->name_en }}</span></th>
                            @endforeach
                            @if ($data->private_seat > 0)
                                <th colspan="1"><span class="eng">Private</span></th>
                                <th colspan="1"><span class="eng">Private</span></th>
                            @else
                                <th><span class="eng">ผู้ใหญ่(Ad)</span></th>
                                <th><span class="eng">เด็ก(Ch)</span></th>
                                <th><span class="eng">เด็กเล็ก(Bb)</span></th>
                                <th><span class="eng">ผู้ใหญ่(Ad)</span></th>
                                <th><span class="eng">เด็ก(Ch)</span></th>
                            @endif
                            <th><span class="eng">Total</span></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">{{ $data->id }}</th>
                            <td> {{ $data->booking_code }}</td>
                            <td scope="row" class="text-start">

                                {{ $data->name }}
                                <br>วันเดินทาง : {{ $data->departure_date }}
                                @if ($data->tel > 0)
                                    <br> เบอร์โทร : {{ $data->tel }}
                                @else
                                    echo ' <br> เบอร์โทร : -';
                                @endif
                                <br><strong style="color: red;">{{ $data->package->packageType->name_en }}</strong>
                            </td>
                            @foreach ($packageTypes as $type)
                                @if ($data->package->packageType->name_en == $type->name_en)
                                    <td><i class="fas fa-check-square"></i></td>
                                @else
                                    <td><i class="fa-regular fa-square"></i></i></td>
                                @endif
                            @endforeach






                            @if ($data->private_seat > 0)
                                <td colspan="" class="text-end text-center">{{ $data->private_seat }}</td>
                            @else
                                <td class="text-end text-center">{{ $data->adult }}</td>
                                <td class="text-end text-center">{{ $data->child }}</td>
                                <td class="text-end text-center">{{ $data->baby }}</td>
                            @endif
                            <?php
                            if ($data->agents) {
                                if ($data->agents->type_user == 2) {
                                    if ($data->package->packageType->trip_type == 'join') {
                                        $inputprice_Adult = $data->package->prices[0]->subordinate;
                                        $inputprice_Child = $data->package->prices[1]->subordinate;
                                    } else {
                                        $inputprice_Private = $data->package->prices[0]->subordinate;
                                    }
                                } elseif ($data->agents->type_user == 1 || $data->agents->type_user == 4) {
                                    if ($data->package->packageType->trip_type == 'join') {
                                        $inputprice_Adult = $data->package->prices[0]->agent;
                                        $inputprice_Child = $data->package->prices[1]->agent;
                                    } else {
                                        $inputprice_Private = $data->package->prices[0]->agent;
                                    }
                                } else {
                                    if ($data->package->packageType->trip_type == 'join') {
                                        $inputprice_Adult = $data->package->prices[0]->regular;
                                        $inputprice_Child = $data->package->prices[1]->regular;
                                    } else {
                                        $inputprice_Private = $data->package->prices[0]->regular;
                                    }
                                }
                            } else {
                                if ($data->packageType->trip_type == 'join') {
                                    $inputprice_Adult = $data->package->prices[0]->regular;
                                    $inputprice_Child = $data->package->prices[1]->regular;
                                } else {
                                    $inputprice_Private = $data->package->prices[0]->regular;
                                }
                            }
                            if ($data->private_seat > 0) {
                                $total = $inputprice_Private;
                            } else {
                                $totaladult = $inputprice_Adult * $data->adult;
                                $totalchild = $inputprice_Child * $data->child;
                                $total = $totaladult + $totalchild;
                            }

                            ?>

                            @if ($data->private_seat > 0)
                                <td class="text-center">{{ $inputprice_Private }}</td>
                            @else
                                <td class="text-end">{{ $inputprice_Adult ?? 0 }}</td>
                                <td class="text-end">{{ $inputprice_Child ?? 0 }}</td>
                            @endif

                            <td class="text-end">{{ $total }}</td>


                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="">
            <div class="row">
                   <div class="col-2"></div>
                <div class="col-10">
                    <table class="invoice table table-sm table-borderless">
                        <tbody>

                            <tr>
                                <th scope="row">จำนวนเงินทั้งหมด : <br> <span class="eng1">Total amount : </span></th>
                                <td class="text-end text-danger fw-bold fs-5"> {{number_format($data->amount);}}</td>
                            </tr>
                            <tr>
                                <th scope="row">มัดจำ : <br> <span class="eng1">Dep : </span></th>
                                <td class="text-end text-danger fw-bold fs-5"> {{number_format($data->pledge);}} </td>
                            </tr>
                            <tr>
                                <th scope="row">ค้างชำระ : <br> <span class="eng1">Remain : </span></th>
                                <td class="text-end text-danger fw-bold fs-5"> {{number_format($data->arrearage);}} </td>
                            </tr>
                            <tr>
                            <?php
                                if($data->arrearage == 0 ){
                                    $percen = 100;
                                }else if ($data->pledge == 0 or $data->arrearage == $data->amount){
                                	$percen = 0;
                                }else{
                                    $percen =  ($data->arrearage / $data->pledge)*100;
                                }

                            ?>
                                <th></th>
                                <td class="text-start text-danger eng">
                                    ชำระครบ {{$percen;}}% <br>
                                      <strong style="color:red;">หมายเหตุ : {{ $data->note;}} </strong>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>




        <!-- <p class="text-start text-decoration-underline mt-3 mb-0"><em>ข้อกำหนดและเงื่อนไข</em></p>
        <p class="text-start m-0">1. คุณลูกค้าต้องสำรองที่นั่งก่อนเดินทาง 6 ชั่วโมง</p>
        <p class="text-start m-0">2. หากคุณลูกค้าต้องการเปลี่ยนแปลง หรือเลื่อนวันเดินทาง ต้องแจ้งล่วงหน้าอย่างน้อย 14 วัน ก่อนวันเดินทาง</p>
        <p class="text-start m-0">3. โปรแกรมการเดินทางอาจมีการเปลี่ยนแปลงตามความเหมาะสมของสภาพอากาศ</p>
        <p class="text-start m-0">4. หากไม่สามารถเดินทางได้ เนื่องจากสภาพอากาศ ทางบริษัทจะแจ้งยกเลิกก่อนการเดินทาง 2 ชั่วโมง</p>
        <p class="text-start m-0">   ทั้งนี้ลูกค้าสามารถเลื่อนวันเดินทางได้ไม่เกิน 3 วัน หรือสามารถขอเงินคืนได้เต็มจำนวน</p>
        <p class="text-start m-0">5. ในกรณีลูกค้าต้องการยกเลิกการเดินทางด้วยตนเอง บริษัทขอสงวนสิทธิ์ในการคืนเงินแก่ลูกค้า</p>
        <p class="text-start m-0">6. กรณียังไม่มีกำหนดวันเดินทาง กรุณาโทรเช็คที่นั่งก่อนวันเดินทาง</p>
        <p class="text-start m-0">7. บริษัทจะรับผิดชอบตามรายละเอียด Voucher เท่านั้น</p> -->
        <div class="">
            <p class="fw-bold text-start">TERM & CONDITION</p>
            <p class="lh-1">
                <span class="fw-light text-start eng">Charge bill to : </span>
                <span class="fw-light text-start eng"> {{$data->agent_name;}} </span>
            </p>
            <p class="lh-1">
                <span class="fw-light text-start eng">Sunset : </span>
                <span class="fw-light text-start eng">Departure time : 16.00 PM. Return time : 18.30 PM.</span>
            </p>
            <p class="lh-1">
                <span class="fw-light text-start eng">Day Trip : </span>
                <span class="fw-light text-start eng">Departure time : 09.00 AM. Return time : 14.30 PM.</span>
            </p>

        </div>

        <div class="mt-2">
            <p class="fw-bold text-start ">CANCELLATION POLICY</p>
            <p class="fw-light text-start eng lh-1">- If cancelled or modified up to 14 days before date of arrival, no fee will be charged. If cancelled or modified later or case of no-show, the total price of the reservation will be charged.</p>
            <p class="fw-light text-start eng lh-1">- Payment must be made within 3 days after reservation date.</p>
            <p class="fw-light text-start eng lh-2">- Lipeyachtcharter reserves the right to cancel or postpone a tour due to unforeseen cireumstances (such as weather conditions) By agreement tour can be rescheduled to another day or company will make full refiund.</p>
            <p class="fw-light text-start eng lh-1">- Service provider reserves the right to change the trip itinerary andior destination if weather (wind, waves) does not allow to execute the trip itinerary.</p>
        </div>

        <div class="mt-2">
            <p class="fw-bold text-start ">BILLING INSTRUCTIONS</p>
            <div class="border border-secondary text-center row gx-0">
                <div class="col-3 mt-3">
                    <p class="lh-1">BANK NAME</p>
                    <p class="lh-1">Bangkok Bank</p>
                </div>
                <div class="col-3  mt-3">
                    <p class="lh-1">ACCOUNT NAME</p>
                    <p class="lh-1"> บจ.เข็มทิศ ไอทินเนอระรี</p>
                </div>
                <div class="col-3  mt-3">
                    <p class="lh-1">ACCOUNT NO</p>
                    <p class="lh-1"> 259-5-39455-8</p>
                </div>
                <div class="col-3  mt-3">
                    <p class="lh-1">SWIFT CODE</p>
                    <p class="lh-1">BKKBTHBK</p>

                </div>
            </div>
            <p class="fw-light text-start mt-3">Thank you very much for your kindly email your remittance advise us and co-operation We look forward to welcome you at Lipe yacht charter by Khemtis travel
            </p>

        </div>
        <!-- </div> -->

    </div>



</body>
<script>
        $(document).ready(function () {
            var isClosed = false;
            window.print();
            window.onafterprint = window.close;
        });








    </script>
</html>
