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

table {
        border-collapse: collapse; /* รวมขอบระหว่างเซลล์ */
        width: 100%;
    }
    th, td {
        border: 1px solid #d6d6d6; /* เส้นขอบสีเทาอ่อน */
        padding: 8px;
    }
    tr:nth-child(even) {
        background-color: #f9fafb; /* สีพื้นเทาอ่อนสำหรับแถวคู่ */
    }
    tr:hover {
        background-color: #f3f4f6; /* สีพื้นเมื่อเลื่อนเมาส์ไปที่แถว */
    }
    </style>
   <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <div class="container mx-auto mt-5 xl:ml-64 lg:ml-64  " style="margin-bottom: 50px;">
         <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Report</h1>
         
           
        </div>
         <form action="{{ route('report') }}" method="GET">
        <div class="flex justify-between items-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-5 gap-4 mb-4">
               
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">วันเริ่ม</label>
                <input type="date" id="start_date" name="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">วันสิ้นสุด</label>
                <input type="date" id="end_date" name="end_date"  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="package" class="block text-sm font-medium text-gray-700">แพ็คเกจ</label>
                <select id="package" name="package" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="x" selected>ทุกแพ็คเกจ</option>
                    @foreach ($packages as $package)
                    <option value="{{ $package->id }}">{{ $package->name_en }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="agent" class="block text-sm font-medium text-gray-700">เอเย่นต์</label>
                <select id="agent" name="agent" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="x" selected>ทุกเอเย่นต์</option>
                    @foreach ($agents as $agent)
                    <option value="{{ $agent->agent_id }}">{{ $agent->agent_name }}</option>
                    @endforeach
                </select>
            </div>
           <div class="flex items-end">
                <button type="submit" 
                    class="h-10 mt-6 px-3 bg-blue-500 text-white text-sm rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fa fa-search"></i> ค้นหา
                </button>
            </div>
            </form>
            <div class="flex items-end">
                <button id="print-btn"
                    class="h-10 mt-6 px-3 bg-blue-500 text-white text-sm rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fa fa-print"></i> Print
                </button>
            </div>
            <div class="flex items-end">
                <form method="GET" action="{{ route('report') }}">
                <button id="clear-filters"

                    class="h-10 mt-6 px-3 bg-green-500 text-white text-sm rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fa fa-eraser"></i> Clear
                </button>
                </form>
            </div>

        </div>

         
        </div>
         <div class="flex justify-between items-center"  >

@php
    $totalQuantity = 0;
    $totalPayment = 0;
    $totalPledge = 0;
    $totalArrearage = 0;

    function formatDate($date) {
        return \Carbon\Carbon::parse($date)->format('d/m/Y');
    }

    function truncateText($text, $maxLength) {
        return strlen($text) > $maxLength ? substr($text, 0, $maxLength) . '...' : $text;
    }
@endphp
          <table class="table-auto w-full mt-4" id="myTable">
              <thead >
                <tr>
                <th><input type="checkbox" id="select-all"></th>
                  <th>#</th>
                  <th>สถานะการเดินทาง</th>
                  <th width="8%">รหัสบุ๊ค</th>
                  <th width="12%">เบอร์โทรลูกค้า</th>
                  <th width="8%">ชื่อลูกค้า</th>
                  <th>แพ็คเกจ</th>

                  <th>วันที่ Check In</th>
                  <th>Option</th>
                  <th>จำนวน</th>
                  <th>Agent</th>
                  <th>ยอดชำระ</th>
                  <th>มัดจำ</th>
                  <th>ยอดค้างชำระ</th>
                </tr>
              </thead>
                
              <tbody id="bodyhistory">
                   @foreach ($data as $index => $row)
                        @php
                            $totalQuantity += intval($row->seat ?? 0);
                            $totalPayment += floatval($row->amount ?? 0);
                            $totalPledge += floatval($row->pledge ?? 0);
                            $totalArrearage += floatval($row->arrearage ?? 0);

                            $rowClass = $index % 2 === 0 ? 'bg-white' : 'bg-gray-100';
                            $formattedDate = formatDate($row->departure_date);
                        @endphp
                        <tr style="
    @if ($row->booking_status === 'deleted') 
        background-color: #ff5452; color: white;
    @elseif ($row->booking_status === 'confirmed') 
        background-color: #bdffbd; color: black;
    @elseif ($row->booking_status === 'checked_in') 
        background-color: #6efff3; color: black;
    @elseif ($row->booking_status === 'maintenance') 
        background-color: #d3d3d3; color: black;
    @elseif ($row->booking_status === 'unpaid') 
        background-color: #ababab; color: black;
    @else 
        background-color: white; color: black;
    @endif">
                            <td>
                                <input type="checkbox" class="select-item" value="{{ $row->id }}">
                            </td>
                            <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2 text-center" style="
                                @if (in_array($row->statement_status, ['deposit', 'paid', 'full_payment', 'internal']))
                                    color: green;
                                @elseif (in_array($row->statement_status, ['unpaid']))
                                    color: red;
                                @elseif (in_array($row->statement_status, ['ent']))
                                    color: black;
                                @elseif (in_array($row->statement_status, ['deposit']))
                                 color: orange;
                                @else
                                     color: black;
                                @endif
                            ">{{ $row->booking_status }}</td>
                            <td class="border px-4 py-2 text-center">{{ $row->booking_code }}</td>
                            <td class="border px-4 py-2 text-center">{{ $row->tel }}</td>
                            <td class="border px-4 py-2 text-center">{{ truncateText($row->name, 13) }}</td>
                            <td class="border px-4 py-2 text-center">{{ $row->package->name_boat ?? '-' }}</td>
                            <td class="border px-4 py-2 text-center">{{ $formattedDate }}</td>
                            <td class="border px-4 py-2 text-center">
                                @if ($row->booking_option && $row->booking_option->count())
                                    <ul>
                                        @foreach ($row->booking_option as $option)
                                            <li>- {{ $option->detail }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <li>-</li>
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center" style="color: #b91c1c;">{{ $row->seat }}</td>
                            <td class="border px-4 py-2 text-center">{{ truncateText($row->agents->agent_name ?? '-', 15) }}</td>
                            <td class="border px-4 py-2 text-center" style="color: #047857;">
                                {{ number_format($row->amount ?? 0, 2, '.', ',') }}
                            </td>
                            <td class="border px-4 py-2 text-center text-indigo-700">
                                {{ number_format($row->pledge ?? 0, 2, '.', ',') }}
                            </td>
                            <td class="border px-4 py-2 text-center" style="color: #eab308;">
                                {{ number_format($row->arrearage ?? 0, 2, '.', ',') }}
                            </td>
                        </tr>
                    @endforeach

              </tbody>
            </table>
         </div>


     </div>


 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
if (typeof DataTable !== "undefined" && typeof jQuery !== "undefined") {
    $(document).ready(function() {
         const selectedIds = new Set();
        const table =  $('#myTable').DataTable({
            "paging": true,      
            "searching": true,   
            "info": true,         
            "ordering": true,
             "stateSave": true,     
            "order": [[0, "asc"]], 
          
        });

        $('#myTable').on('change', '.select-item', function () {
            const id = $(this).val();
            if (this.checked) {
                selectedIds.add(id); 
            } else {
                selectedIds.delete(id); 
            }
        });

        table.on('draw', function () {
            $('.select-item').each(function () {
                const id = $(this).val();
                if (selectedIds.has(id)) {
                    $(this).prop('checked', true); 
                }
            });
        });

        $('#print-btn').on('click', function () {
            const idsArray = Array.from(selectedIds);

          if (idsArray.length > 0) {
                // เข้ารหัส Array เป็นรูปแบบที่เหมาะสม (เช่น เชื่อมด้วยคอมม่า)
                const ids = idsArray.join(',');

                // สร้าง URL และเปิดในหน้าต่างใหม่
                const url = `/report/${ids}`;
                window.open(url, '_blank'); // เปิดในแท็บใหม่
            } else {
                alert('กรุณาเลือกข้อมูลอย่างน้อยหนึ่งรายการ'); // แสดงข้อความแจ้งเตือน
            }

        })
    });
}
    document.getElementById('searchButton').addEventListener('click', function() {
        // ดึงค่าจาก input และ select
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const packageId = document.getElementById('package').value;
        const agentId = document.getElementById('agent').value;
        console.log(packageId);
        // ทำการยิง AJAX ด้วย Fetch API
        fetch('/get-history', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF Token
            },
            body: JSON.stringify({
                start_date: startDate,
                end_date: endDate,
                package_id: packageId,
                agent_id: agentId
            })
        })
        .then(response => response.json())
        .then(data => {
            // เคลียร์ข้อมูลใน table ก่อน
            const tableBody = document.getElementById('bodyhistory');
            tableBody.innerHTML = '';

            // เช็คว่ามีข้อมูลหรือไม่
            if (data.length > 0) {
                let totalQuantity = 0;
                let totalPayment = 0;
                let totalpledge = 0;
                let totalarrearage = 0;
                data.forEach((row, index) => {

                    totalQuantity += parseInt(row.seat || 0, 10);
                    totalPayment += parseFloat(row.amount || 0);
                    totalarrearage += parseFloat(row.arrearage || 0);
                   
                    const rowClass = index % 2 === 0 ? 'bg-white' : 'bg-gray-100';
                    const originalDate = row.departure_date; // วันที่ในฟอร์แมต y/m/d
                    const formattedDate = formatDate(originalDate);
                    const truncateText = (text, maxLength) => {
                        return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                    };
                    console.log(row.booking_option);
                    const newRow = `
                         <tr class="${rowClass}" style="${row.color}">
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${row.booking_status}</td>
                            <td class="text-center">${row.booking_code}</td>
                            <td class="text-center">${row.tel}</td>
                             <td class="text-center">${truncateText(row.name, 13)}</td>
                            <td class="text-center">${row.package.name_boat}</td>
                            <td class="text-center">${formattedDate}</td>
                            <td>
                                <ul>
                                    ${row.booking_option && row.booking_option.length
                                        ? row.booking_option.map(item => `<li>- ${item.detail}</li>`).join('')
                                        : '<li>-</li>'}
                                </ul>
                            </td>
                            <td class="text-center" style="color: #b91c1c;">${row.seat}</td>
                            <td class="text-center">${truncateText(row.agents.agent_name, 15)}</td>
                            <td class="text-center" style="color: #047857;">${Number(row.amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                            <td class="text-center text-indigo-700">${Number(row.pledge).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                            <td class="text-center" style="color: #eab308;">${Number(row.arrearage).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>

                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', newRow);
                });
                const summaryRow = `
                    <tr class="bg-gray-200 font-bold">
                        <td colspan="7" class="text-right">Summary</td>
                        <td class="text-center" style="color: #b91c1c;">${Number(totalQuantity).toLocaleString()}</td>

                        <td colspan="2" class="text-right" style="color: #047857;">${Number(totalPayment).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td class="text-center text-indigo-700">${Number(totalpledge).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td class="text-center " style="color: #eab308;">${Number(totalarrearage).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td colspan="2"></td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', summaryRow);
            } else {
                // แสดงข้อความว่าไม่มีข้อมูล
                tableBody.innerHTML = '<tr><td colspan="12" class="text-center">ไม่พบข้อมูล</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('เกิดข้อผิดพลาดในการดึงข้อมูล');
        });
    });





    function formatDate(dateString) {
    // แยกส่วนของวันที่
    const [year, month, day] = dateString.split('-');
    // รวมใหม่เป็น d/m/y
    return `${day}/${month}/${year}`;
}
</script>


           
</x-app-layout>
