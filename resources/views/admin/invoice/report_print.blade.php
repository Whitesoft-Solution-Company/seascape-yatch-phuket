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
   

   
    .page-break-before {
        page-break-before: always;
    }
</style>

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
            
        </div>
      
        <div class="row mt-0  ">
            <div class="col-12">
                <table class="invoice table table-sm table-bordered text-center">
                    <thead class="table-secondary ">
                        <tr>
                            <th >No</th>
                            <th >รหัส</th>
                            <th >ลูกค้า</th>
                            <th >แพ็คเก็จ</th>
                           
                            <th >วันที่เดินทาง</th>
                            <th >agent</th>
                            <th >ยอดเงิน</th>

                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                    @php
                        $totalQuantity = 0;
                        $totalPayment = 0;
                        $sumboption = 0;
                        $sumboptioninc = 0;
                        $index = 1;
                        function truncateText($text, $maxLength) {
                            return strlen($text) > $maxLength ? substr($text, 0, $maxLength) . '...' : $text;
                        }
                    @endphp
                          @foreach ($data as  $booking)
                            @php
                                $totalQuantity += intval($booking->seat ?? 0);
                                $totalPayment += floatval($booking->amount ?? 0);
                             
                            @endphp
                            <tr>
                                <td >{{ $index }}</td>
                                <td >{{ $booking->booking_code }}</td>
                                <td >{{ $booking->name }}</td>
                                <td >{{ $booking->package->name_boat }}</td>
                                <td >{{ $booking->seat }}</td>
                                <td >{{ $booking->booking_time }}</td>
                                <td >{{  truncateText($booking->agents->agent_name, 500)}}</td>
                                <td >
                                    ฿{{ number_format($booking->amount, 2) }}</td>
                            </tr>
                            @php
                                $index++;
                               
                            @endphp
                        @endforeach
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;">รวม</td>
                         <td colspan="2" style="text-align: right;"> </td>
                        <td colspan="1" style="text-align: right;">{{ $totalQuantity}}</td>
                        <td colspan="2" style="text-align: right;"> </td>
                        <td colspan="1" style="text-align: right;">{{ number_format($totalPayment, 2)}}</td>
                    </tr>
                                  
                
                    </tbody>
                </table>
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