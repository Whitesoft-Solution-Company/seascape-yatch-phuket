<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

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

    div.container {
        border-radius: 15px;
        background: white;
    }

    div.invoice-letter {
        width: auto;
        position: relative;
    }


    table tbody tr {
        vertical-align: middle !important;
    }

    .item {
        text-align: left;
    }

    .eng {
        font-size: 10px;
    }

    .eng1 {
        font-size: 8px;
        font-weight: normal;
    }
</style>
<?php

    if($data->manual_amount != $data->package->prices[0]->regular){
        $inputprice_reg = $data->manual_amount;
    }else{
        $inputprice_reg = $data->package->prices[0]->regular;
    }
// if ($data->agents) {
//     if ($data->agents->type_user == 2) {
//         if ($data->package->packageType->trip_type == 'join') {
//             $inputprice_Adult = $data->package->prices[0]->subordinate;
//             $inputprice_Child = $data->package->prices[1]->subordinate;
//         } else {
//             $inputprice_Private = $data->package->prices[0]->subordinate;
//             $inputprice_reg = $data->package->prices[0]->regular;
//         }
//     } elseif ($data->agents->type_user == 1 || $data->agents->type_user == 4) {
//         if ($data->package->packageType->trip_type == 'join') {
//             $inputprice_Adult = $data->package->prices[0]->agent;
//             $inputprice_Child = $data->package->prices[1]->agent;
//         } else {
//             $inputprice_Private = $data->package->prices[0]->agent;
//             $inputprice_reg = $data->package->prices[0]->regular;
//         }
//     } else {
//         if ($data->package->packageType->trip_type == 'join') {
//             $inputprice_Adult = $data->package->prices[0]->regular;
//             $inputprice_Child = $data->package->prices[1]->regular;
//         } else {
//             $inputprice_Private = $data->package->prices[0]->regular;
//             $inputprice_reg = $data->package->prices[0]->regular;
//         }
//     }
// } else {
//     if ($data->packageType->trip_type == 'join') {
//         $inputprice_Adult = $data->package->prices[0]->regular;
//         $inputprice_Child = $data->package->prices[1]->regular;
//     } else {
//         $inputprice_Private = $data->package->prices[0]->regular;
//         $inputprice_reg = $data->package->prices[0]->regular;
//     }
// }
// if ($data->private_seat > 0) {
//     $total = $inputprice_Private;
// } else {
//     $totaladult = $inputprice_Adult * $data->adult;
//     $totalchild = $inputprice_Child * $data->child;
//     $total = $totaladult + $totalchild;
// }

?>

<body>

    <div class=" px-2 py-1 center ">
        <!-- ส่วน หัวข้อใบเสนอราคา -->
        <div class="row">
            <div class="col-3">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" width="100px"
                    class="rounded float-start">


            </div>
            <div class="col-7">
                <h6>SEASCAPE YACHT PHUKET <span class="eng"><em>by Khemtis Itinerary Co.,Ltd.</em></span></h6>
                <p class="mb-0">1168 หมู่ที่ 2 ตำบลปากน้ำ อำเภอละงู จังหวัดสตูล 91110</em></p>
                <p class="mb-0">Office : 090-310-3019</em></p>
                <p class="mb-0">E-mail : seascapephuket@khemtistravel.com</em></p>
                <p class="mb-0">Website : seascapeyachtphuket.com/</em></p>
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
                <div class="col-7">
                    <table class="table table-sm table-borderless d-print-table">
                        <tbody>
                            <tr>
                                <th scope="row">Agent : </th>
                                <td class="item ">{{ $data->agents->agent_name }}</td>
                            </tr>
                            <tr style="font-size: 14px;">
                                <th scope="row">Address : </th>
                                @if (isset($data->agents->address))
                                    <td class="item">{{ $data->agents->address }}</td>
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
                                <td class="item">{{ $data->created_at->format('Y-m-d') }}</td>

                            </tr>
                             <tr>
                                <th scope="row">Name : </th>
                                <td class="item">{{ $data->name }}</td>

                            </tr>
                            

                        </tbody>
                    </table>
                </div>
                <div class="col-5">
                    <table class="table table-sm table-borderless d-print-table">
                        <tbody>
                            <tr>
                                <th scope="row">SERVICE DATE : </th>
                                <td class="item ">{{ $data->booking_time }}</td>
                            </tr>
                            <tr style="font-size: 14px;">
                                <th scope="row"> TOTAL GUEST : </th>

                                <td class="item">{{ $data->seat }}</td>

                            </tr>
                            <tr>
                                <th scope="row" style="font-size: 12px;"> EMBARK & DISEMBARK : </th>

                                <td class="item">{{ $data->embark }} & {{ $data->disembark }}</td>

                            </tr>
                            <tr>
                                <th scope="row">ROUTE : </th>
                                <td class="item">{{ $data->package->name_boat }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Booking : </th>
                                <td class="item">{{ $data->booking_code }}</td>

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

                    <tbody>
                        <tr>
                            <td scope="row"> CHARTER PRICE :</td>
                            <td class="text-center">฿ {{ number_format($inputprice_reg, 2) }}</td>
                        </tr>
                        <tr>
                            <td scope="row"> SALE DISCOUNT {{ $inputprice_reg != 0 ? ($data->percent_discount / $inputprice_reg) * 100 : '0' }} %

                                :</td>
                            <td class="text-center"> ฿ {{ number_format($data->percent_discount, 2) }}</td>
                        </tr>
                        @if($data->extra_seat > 0)
                        <tr>
                            <td scope="row"> EXTRA SEAT X {{$data->extra_seat}}</td>
                            <td class="text-center"> ฿ {{ number_format(((($data->amount+$data->percent_discount)-$inputprice_reg)/$data->extra_seat)*$data->extra_seat, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td scope="row"> TOTAL CHARTER PRICE :</td>
                            <td class="text-center"> ฿ {{ number_format($data->amount, 2) }}</td>
                        </tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-0 ">
            <div class="col-12">
                <table class="invoice table table-sm table-bordered text-center">
                    @php
                        $sumboption = 0;
                        $sumboptioninc = 0;
                        $index = 2;
                    @endphp
                    <tbody>
                        <tr>
                            <td colspan="1" scope="row" width="10%">1</td>
                            <td colspan="7" class="text-start" width="50%"> CHARTER PRICE</td>
                            <td colspan="2" class="text-center" width="40%">
                                ฿{{ number_format($data->amount, 2) }}</td>
                        </tr>
                        @foreach ($bookingoption as  $boption)
                            @php
                                if($boption->typeoption == 'discount'){
                                    $sumboption += $boption->amount; // สะสมค่า amount
                                    $sign = '-';
                                }else{
                                    $sumboptioninc += $boption->amount;
                                     $sign = '+';
                                }
                            @endphp
                            <tr>
                                <td colspan="1" scope="row" width="10%">{{ $index }}</td>
                                <td colspan="7" class="text-start" width="50%">{{ $boption->detail }}</td>
                                <td colspan="2" class="text-center" width="40%">
                                    {{$sign}} ฿{{ number_format($boption->amount, 2) }}</td>
                            </tr>
                            @php
                                $index++;
                               
                            @endphp
                        @endforeach
                        @php
                        $total = $data->amount - ($sumboption-$sumboptioninc);
                        $vat7 = (($data->amount - ($sumboption-$sumboptioninc))*7)/107;
                        if($data->vat == 'false'){
                            $vat7 = 0;
                        }
                        $subtotal =  $total - $vat7;
                        $tax3 = ($subtotal*3)/100;
                        if($data->tax == 'false'){
                            $tax3 = 0;
                        }
                        $paid = $subtotal+($vat7-$tax3);
                        @endphp
                        <tr style="border: none;  ">
                            <td width="50%" scope="row" style="border: none;  " colspan="6"></td>
                            <td width="25%" colspan="2" class="text-center " style="border: 2px solid #dee2e6; ">
                                TOTAL PAYMENT</td>
                            <td width="25%" colspan="2" class="text-center " style="border: 2px solid #dee2e6; ">
                                ฿{{ number_format($total , 2) }}</td>
                        </tr>
                        <tr style="border: none;  ">
                            <td width="50%" scope="row" style="border: none;  " colspan="6"></td>
                            <td width="25%" colspan="2" class="text-center " style="border: 2px solid #dee2e6; ">
                                VAT 7%</td>
                            <td width="25%" colspan="2" class="text-center " style="border: 2px solid #dee2e6; ">
                                ฿{{ number_format($vat7, 2) }}</td>
                        </tr>
                        <tr style="border: none;  ">
                            <td width="50%" scope="row" style="border: none;  " colspan="6"></td>
                            <td width="25%" colspan="2" class="text-center "
                                style="border: 2px solid #dee2e6; ">SUB TOTAL</td>
                            <td width="25%" colspan="2" class="text-center "
                                style="border: 2px solid #dee2e6; ">฿{{ number_format($subtotal , 2) }}</td>
                        </tr>
                        <tr style="border: none;  ">
                            <td width="50%" scope="row" style="border: none;  " colspan="6"></td>
                            <td width="25%" colspan="2" class="text-center "
                                style="border: 2px solid #dee2e6; "> WITHOLDING TAX 3%</td>
                            <td width="25%" colspan="2" class="text-center "
                                style="border: 2px solid #dee2e6; ">฿{{ number_format($tax3 , 2) }}</td>
                        </tr>
                        <tr style="border: none;  ">
                            <td width="50%" scope="row" style="border: none;  " colspan="6"></td>
                            <td width="25%" colspan="2" class="text-center "
                                style="border: 2px solid #dee2e6; ">PAID</td>
                            <td width="25%" colspan="2" class="text-center "
                                style="border: 2px solid #dee2e6; ">฿{{ number_format($paid , 2) }}</td>
                        </tr>
                        <tr style="border: none;  ">
                            <td width="50%" scope="row" style="border: none;  " colspan="6"></td>
                            <td width="50%" colspan="4" class="text-center "
                                style="border: none; color:red; ">{{ $data->note }}</td>
                          
                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
       
        <div class="">
            <p class="fw-bold text-start">Booking Conditions</p>
            <p class="lh-1">
                <span class="fw-light text-start eng">- A deposit of 50% of the total amount is required to confirm the booking.</span>
             
            </p>
            <p class="lh-1">
                <span class="fw-light text-start eng">- The remaining balance must be paid in full 7 days before the departure date. </span>
              
            </p>
            <p class="lh-1">
                <span class="fw-light text-start eng">- For agents making a booking within 7 days of the departure date, a 50% deposit is required at the time of booking to secure the date, and the remaining 50% must be paid by 6:00 PM on the booking date.</span>
           
            </p>
        </div>
        <div class="mt-2">
            <p class="fw-bold text-start ">CANCELLATION POLICY</p>
            <p class="fw-light text-start eng lh-1">- Cancellations made at least 30 days prior to departure will receive a full refund (100%) of the amount paid.</p>
            <p class="fw-light text-start eng lh-1">-  Cancellations made less than 7 days before the departure date, the company reserves the right to withhold any refund.</p>
            <p class="fw-light text-start eng lh-2">- Lipeyachtcharter reserves the right to cancel or postpone a tour
                due to unforeseen cireumstances (such as weather conditions) By agreement tour can be rescheduled to
                another day or company will make full refiund.</p>
            <p class="fw-light text-start eng lh-1">***In the event that the Marine Department issues a weather warning preventing the ship from sailing, the company will provide a full refund.***</p>
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
            <p class="fw-light text-start mt-1">Thank you very much for your kindly email your remittance advise us and
                co-operation We look forward to welcome you at Lipe yacht charter by Khemtis travel
            </p>

            <p class="fw-light text-start mt-1"> <strong>With Best regards,</strong> 
            </p>
            <p class="fw-light text-start "> {{Auth()->user()->name;}}
            </p>
        </div>


    </div>
</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        var isClosed = false;
        window.print();
        window.onafterprint = window.close;
    });
</script>

</html>
