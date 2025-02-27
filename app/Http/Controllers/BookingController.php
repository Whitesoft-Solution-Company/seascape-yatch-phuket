<?php

namespace App\Http\Controllers;

use App\Livewire\PackageFilter;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\BookingOption;
use App\Models\CodePromotion;
use App\Models\Insurance;
use App\Models\Package;
use App\Models\Payment;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class BookingController extends Controller
{
    public function index()
    {
        // ดึงข้อมูล Package ทั้งหมดพร้อมกับข้อมูลที่เกี่ยวข้อง
        $packages = Package::with(['packageType', 'yachts', 'prices'])->get();
        // dd(session()->all());
        // ส่งข้อมูลไปยังวิว
        return view('webpage.index', compact('packages'));
    }

    public static function getStatusColor($bookingStatus)
    {
        switch ($bookingStatus) {
            case 'deleted':
                return 'background-color: #ff5452; color: white;';
            case 'confirmed':
                return 'background-color: #8aff95; color: black;';
            case 'checked_in':
                return 'background-color: #6efff3; color: black;';
            case 'maintenance':
                return 'background-color: #d3d3d3; color: black;';
            case 'unpaid':
                return 'background-color: #ababab; color: black;';
            default:
                return 'background-color: white; color: black;';
        }
    }

    public function destroy($id)
    {
        $bookingOption = Booking::findOrFail($id);
        $bookingOption->delete(); // Soft delete
        return response()->json(['message' => 'Booking option deleted successfully.']);
    }

    public function BookingDetail($bid = null)
    {

        if ($bid) {

            $Booking = Booking::with(['package.packageType', 'package.prices'])->where('id', $bid)->orderBy('id', 'desc')->first();
        } else {

            $Booking = Booking::with(['package.packageType', 'package.prices'])->where('user_id', auth()->id())->orderBy('id', 'desc')->first();
        }

        $url = 'https://www.seascapeyachtlipe.com/';

        $qrCode = QrCode::size(100)->generate($url);
        return view('profile/booking_detail', ['booking' => $Booking, 'qrcode' => $qrCode]);
    }


    public function getBookingDetails($id)
    {
        // ดึงข้อมูลการจองจากฐานข้อมูล
        $booking = Booking::with(['package.packageType','agents','payments'])->find($id);
        
        $slips = [];
        foreach ($booking->payments->take(3) as $index => $payment) {
              $slips["slip" . ($index + 1)] = asset('storage/slip/' .  $payment->slip);
        }
       
        
        return response()->json(array_merge([
            'booking_code' => $booking->booking_code,
            'name' => $booking->name,
            'package' => $booking->package->name_boat,
            'tel' => $booking->tel,
            'agent' => $booking->agents->agent_name,
            'seat' => $booking->seat,
        ], $slips));
    }


    public function Checkin($booking_id)
    {

        $Booking = Booking::where('statement_status', 'paid')->where('id', $booking_id)->first();

        dd($Booking);
    }



    public function calendar()
    {


       
        // return response()->json($data);
        return view('admin.calendar');
    }

    public function calendarview()
    {

        $package = Package::with(['packageType', 'prices'])
                ->where('status', 1)
                ->where('id', '!=', 1)
                ->where('start_time', '<=', now())  // start_time ก่อนหรือเท่ากับตอนนี้
                ->where('end_time', '>=', now())   // end_time หลังหรือเท่ากับตอนนี้
                ->get();
        $duration = Package::select('start_time', DB::raw('MAX(id) as id'))
            ->where('status', 1)
            ->groupBy('start_time')
            ->get();


        // return response()->json($data);
        return view('admin.calendarview', compact('package', 'duration'));
    }


    public function BookingForm($package_id)
    {
        if (empty($pack_id)) {
            return redirect()->back()->with('alert', [
                'type' => 'warning',
                'title' => 'เกิดข้อผิดพลาด!',
                'message' => 'กรุณาเลือกแพ็กเกจหรือวันที่ให้ถูกต้อง',
            ]);
        }



        return view('booking', compact('detailyacht', 'date', 'totalSeats', 'maxGuest', 'chkPrivate'));
    }

    public function create(Request $request, $package_id)
    {

        $date = $request->query('date');
        $datereturn = $request->query('datereturn');
        $package = Package::with('packageType', 'prices')->findOrFail($package_id);

        // dd($package);
        return view('booking.create', compact('package', 'date', 'datereturn'));
    }
    public function addbooking(Request $request)
    {


 
        $code_id = 0;
        //sum seat
        $count_Private = $request->input('count_Private') ?? 0;
        $count_Adult =  $request->input('count_Adult') ?? 0;
        $count_Child = $request->input('count_Child') ?? 0;
        $count_baby = $request->input('count_baby') ?? 0;
        $extraseat = $request->input('extraseat') ?? 0;
        $seat = $count_Private + $count_Adult + $count_Child + $count_baby + $extraseat;
        if ($request->input('promocode')) {
            $promo = CodePromotion::where('promotion_code', $request->input('promocode'))->first();
            $code_id = $promo->id;
        }


      
      
        $booking = Booking::find($request->input('booking_id'));
        if($booking){
            $bookingCode = $request->input('booking_code');
        }else{
            $bookingCode = $this->generateBookingCode();
            $booking = new Booking();
        }
        
      
        if(!$request->input('booking_id')){
             if (!$request->input('overticket') ) {
                    if (!$this->checkSeatAvailability($request->input('package'), $seat,$request->input('date'))) {
                    // ถ้าจำนวนที่นั่งเกิน max_guest
                    return redirect()->back()->with('alert',[
                        'status' => 'error',
                        'type' => 'warning',
                        'message' => 'ที่นั่งเกิน กรุณาเลือกวันที่ใหม่!'
                    ]);
                }
            }
        }
           


        //save booking
       
        $booking->booking_code = $bookingCode;
        $booking->name = $request->input('name');
        $booking->user_id = 0; // ใช้ id ของผู้ใช้ที่ล็อกอิน
        $booking->tel = $request->input('inputtel') ?? '-';
        $booking->agent =  $request->input('agent');
        $booking->contact = $request->input('contact') ?? '-';
        $booking->package_id = $request->input('package');
        $booking->seat = $seat;
        $booking->extra_seat = $extraseat;
        $booking->private_seat = $count_Private;
        $booking->adult = $count_Adult;
        $booking->child = $count_Child;
        $booking->baby = $count_baby;
        $booking->guide_inspect = $request->input('count_guide') ?? 0;
        $booking->manual_amount = $request->input('totalPage');
        $booking->amount = str_replace(',', '', $request->input('total') );
        $booking->code_id = $code_id;
        $booking->aff_id = $request->input('affiliate_id') ?? 0;
        $booking->credit = $request->input('credit') ?? 0;
        $booking->pledge = (int) str_replace(',', '', $request->input('deposit')) ?? 0;
        $booking->arrearage = (int) str_replace(',', '', $request->input('totaldept')) ?? 0;
        $booking->booking_time = $request->input('date');
        $booking->embark = $request->input('embark') ?? '-';
        $booking->disembark = $request->input('disembark') ?? '-';
        $booking->departure_date = $request->input('date');
        $booking->return_date = $request->input('returndate') ?? $request->input('date');
        $booking->vat = $request->input('vat') ?? 'false';
        $booking->tax = $request->input('tax') ?? 'false';
        $booking->admin_id = auth()->user()->id ?? 0;
        $booking->statement_status = $request->input('inputpay') ?? 'unpaid';
        $booking->booking_status = $request->input('package') == 2 ? 'maintenance' : 'confirmed';
        $booking->note = $request->input('note');
        $booking->percent_discount = $request->input('discount');
        $booking->save();

        //get book 
        $latestBooking = Booking::where('booking_code', $bookingCode)->first();


    
       $looppay = 0;
        $fileNames = []; 

         if ($request->hasFile('slip')) {
            $looppay = 1;
           
            $fileExtension = $request->file('slip')->getClientOriginalExtension();
            $fileName[1] = $bookingCode . '-1.' . $fileExtension;


           
            $imagePath = $request->file('slip')->storeAs('slip', $fileName[1], 'public');
        } else {

            $fileName[1] = $request->input('oldimg') ?? '-';
       
        }

        if ($request->hasFile('slip2')) {
            $looppay = 2;
          
            $fileExtension = $request->file('slip2')->getClientOriginalExtension();
            $fileName[2] = $bookingCode . '-2.' . $fileExtension;
           
            $imagePath = $request->file('slip2')->storeAs('slip', $fileName[2], 'public');
        } else {

            $fileName[2] = $request->input('oldimg2') ?? '-';
       
        }

        if ($request->hasFile('slip3')) {
            $looppay = 3;
         
           
            $fileExtension = $request->file('slip3')->getClientOriginalExtension();
            $fileName[3] = $bookingCode . '-3.' . $fileExtension;
           
            $imagePath = $request->file('slip3')->storeAs('slip', $fileName[3], 'public');
        } else {

            $fileName[3] = $request->input('oldimg3') ?? '-';
       
        }

    
        


        $extra_info = $request->input('extra_info');
        $extra_price = $request->input('extra_price');
        $extra_type = $request->input('extra_type');
        BookingOption::where('booking_id', $latestBooking->id)->delete();
        if (!empty($extra_info)) {
            foreach ($extra_info as $index => $info) {
                // เพิ่มข้อมูลใหม่ทั้งหมด
                BookingOption::create([
                    'booking_id' => $latestBooking->id, // การเชื่อมโยงกับการจอง
                    'detail' => $info,
                    'amount' => $extra_price[$index],
                    'typeoption' => $extra_type[$index],
                    'iteration'=>$index+1
                ]);
            }
        }

        if (str_replace(',', '', $request->input('totaldept')) > 0) {
            if ($request->input('deposit') > 0) {
                $amounts = str_replace(',', '', $request->input('deposit'));
            } else {
                $amounts = str_replace(',', '', $request->input('totaldept'));
            }
        } else {
            $amounts = str_replace(',', '', $request->input('total'));
        }


        
        if($request->input('datetime_transfer')){
            for($i=1;$i<=$looppay;$i++){
                $payment = Payment::updateOrCreate(
                    [
                        'booking_id' => $latestBooking->id,
                         'iteration' => $i,
                    ],
                    [
                        'user_id' => 0,
                        'account' => $request->input('account_number') ?? 0,
                        'type' => 'backend',
                        'name' =>  $request->input('name'),
                        'payment_token' => '-',
                        'amount' => $amounts,
                        'bank' => '-',
                        'transfer_time' => $request->input('datetime_transfer'),
                        'slip' => $fileName[$i],
                        'admin_id' =>  auth()->user()->id ?? 0,
                        'status' => 'success',
                    ]

                );
            }
        }

        return redirect()->back()->with('alert',[
            'status' => 'success',
            'type' => 'success',
            'message' => 'บันทึกสำเร็จ'
        ]);
    }

    public function store(Request $request)
    {



        // ตรวจสอบข้อมูลที่ได้รับจากฟอร์ม
        $validated = $request->validate([
            'date_booking' => 'required|date',
            'count_*' => 'required|integer|min:0',

            'txt_note' => 'nullable|string',
            'id_card_*' => 'nullable|string',
            'name_*' => 'nullable|string',
            'dob_*' => 'nullable|date',
            'age_*' => 'nullable|integer',
        ]);
        $agents =  0;
        //sum seat
        $count_Private = $request->input('count_Private') ?? 0;
        $count_Adult =  $request->input('count_Adult') ?? 0;
        $count_Child = $request->input('count_Child') ?? 0;
        $count_baby = $request->input('count_baby') ?? 0;
        $seat = $count_Private + $count_Adult + $count_Child + $count_baby;
        $amount = 0;
        if ($request->input('agent')) {
            $agents = Agent::find($request->input('agent'));
        }
        // sum amount
        $package = Package::with('prices', 'packagetype')->find($request->input('package_id'));

        foreach ($package->prices as $value) {
            if ($agents) {
                if ($agents->type_user == 2) {
                    $price =  $value->subordinate;
                } else if ($agents->type_user == 1 or $agents->type_user == 4) {
                    $price =  $value->agent;
                } else {
                    $price =  $value->regular;
                }
            } else {
                $price =  $value->regular;
            }


            if ($value->person_type == 'Adult') {

                $amount += $count_Adult * $price;
            } else if ($value->person_type == 'Child') {

                $amount += $count_Child * $price;
            } else {
                $amount +=  $price;
            }
        }

        // check avaliable package 
        $packagefilter = new PackageFilter();
        $check_available = $packagefilter->getAvailablePackages($package, $request->input('date_booking'), $request->input('date_return') ?? $request->input('date_booking'));

        if ($check_available->isEmpty()) {

            return redirect()->back()->with('alert', [
                'type' => 'warning',
                'title' => 'ที่นั่งเต็ม',
                'message' => 'ขออภัย, ที่นั่งในช่วงเวลานี้เต็มแล้ว กรุณาลองเลือกช่วงเวลาอื่นหรือแพ็กเกจอื่น.',
            ]);
        }

        //get booking code
        $bookingCode = $this->generateBookingCode();

        //save booking
        $booking = new Booking();
        $booking->booking_code = $bookingCode;
        $booking->name = $request->input('name') ?? auth()->user()->name;
        $booking->user_id = auth()->id() ?? 0; // ใช้ id ของผู้ใช้ที่ล็อกอิน
        $booking->tel = $request->input('inputtel') ?? auth()->user()->phone;
        $booking->agent =  $request->input('agent') ?? 0;
        $booking->contact = $request->input('contact') ?? '-';
        $booking->package_id = $request->input('package') ?? $package->id;
        $booking->seat = $seat;
        $booking->extra_seat = 0;
        $booking->private_seat = $count_Private;
        $booking->adult = $count_Adult;
        $booking->child = $count_Child;
        $booking->baby = $count_baby;
        $booking->guide_inspect = $request->input('guide_inspect') ?? 0;
        $booking->amount = $amount;
        $booking->code_id = $request->input('code') ?? 0;
        $booking->aff_id = $request->input('affiliate_id') ?? 0;
        $booking->credit = $request->input('credit') ?? 0;
        $booking->pledge = $request->input('pledge') ?? 0;
        $booking->arrearage =  $request->input('arrearage') ?? 0;
        $booking->booking_time = $request->input('date_booking');
        $booking->departure_date = $request->input('date_booking');
        $booking->return_date = $request->input('date_return');
        $booking->admin_id = $request->input('admin_id') ?? 0;
        $booking->statement_status = $request->input('statement_status') ?? 'unpaid';
        $booking->booking_status = $request->input('booking_status') ?? 'unpaid';
        $booking->note = $request->input('txt_note');
        $booking->percent_discount = $request->input('discount') ?? 0;
        $booking->save();

        //get book 
        $latestBooking = Booking::where('user_id', auth()->id())->orderBy('id', 'desc')->first();

        if ($latestBooking) {
            $latestBookingId = $latestBooking->id;
        } else {
            // ไม่มี booking อยู่ในระบบ
            $latestBookingId = null;
        }

        if ($request->input('insuranceCheckbox') == 'on') {
            for ($i = 1; $i <= $seat; $i++) {
                $dob = $request->input("dob_{$i}");

                // Calculate age using Carbon
                $age = Carbon::parse($dob)->age;


                // สร้างอินสแตนซ์ของ Insurant
                $insurant = new Insurance();
                $insurant->booking_id = $latestBookingId;
                $insurant->id_card = $request->input("id_card_{$i}");
                $insurant->name = $request->input("name_{$i}");
                $insurant->dob = $dob;
                $insurant->age = $age;

                // บันทึกข้อมูลลงในฐานข้อมูล
                $insurant->save();
            }
        }

        return redirect()->route('payment');
    }

    public function findprice(Request $request)
    {
        $booking = Booking::find($request->input('booking_id'));
        $package = Package::with('prices', 'packagetype')->find($request->input('package_id'));
        $agents = Agent::find($booking->agent);

        $response = [];

        if ($agents) {
            if ($agents->type_user == 2) {
                if ($package->packageType->trip_type == 'join') {
                    $response['inputprice_Adult'] = $package->prices[0]->subordinate;
                    $response['inputprice_Child'] = $package->prices[1]->subordinate;
                } else {
                    $response['inputprice_Private'] = $package->prices[0]->subordinate;
                }
            } elseif (in_array($agents->type_user, [1, 4])) {
                if ($package->packageType->trip_type == 'join') {
                    $response['inputprice_Adult'] = $package->prices[0]->agent;
                    $response['inputprice_Child'] = $package->prices[1]->agent;
                } else {
                    $response['inputprice_Private'] = $package->prices[0]->agent;
                }
            } else {
                if ($package->packageType->trip_type == 'join') {
                    $response['inputprice_Adult'] = $package->prices[0]->regular;
                    $response['inputprice_Child'] = $package->prices[1]->regular;
                } else {
                    $response['inputprice_Private'] = $package->prices[0]->regular;
                }
            }
        } else {
            if ($package->packageType->trip_type == 'join') {
                $response['inputprice_Adult'] = $package->prices[0]->regular;
                $response['inputprice_Child'] = $package->prices[1]->regular;
            } else {
                $response['inputprice_Private'] = $package->prices[0]->regular;
            }
        }

        return response()->json($response);
    }





    public function generateBookingCode()
    {
        // กำหนดค่าคงที่
        $prefix = 'P';
        $suffix = '-' . (date('y') + 43); // ปีแบบ 2 ตัวสุดท้าย

        // หารหัสการจองล่าสุด
        $lastBooking = Booking::whereNull('deleted_at')->orderBy('created_at', 'desc')->first();

        // เก็บปีปัจจุบัน
        $currentYear = date('y')+43; 

        if ($lastBooking) {
            // Extract the code and number from the last booking code
            $lastCode = $lastBooking->booking_code;
            $lastYear = substr($lastCode, -2); // ปีจาก booking_code (ตัวสุดท้าย เช่น P1125-67 -> 67)
            $lastNumber = intval(substr($lastCode, 1, 4)); // หมายเลขการจองล่าสุด (เช่น P1125-67 -> 1125)

            // ถ้าปีปัจจุบันไม่ตรงกับปีในรหัส booking_code ให้รีเซ็ตหมายเลขใหม่เป็น 0001
            if ($lastYear != $currentYear) {
                $newNumber = '0001';
            } else {
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            }
        } else {
            // ถ้ายังไม่มีการจอง ให้เริ่มต้นที่ P0001
            $newNumber = '0001';
        }

        // สร้างรหัสการจองใหม่
        return $prefix . $newNumber . $suffix;
    }


    public function checkSeatAvailability($packageId, $requestedSeats,$date)
    {
        $package = Package::with('packageType')->find($packageId);
      
        if (!$package) {
            return false;
        }

        if($package->packageType->name_en == 'oneday_trip'){
             $ct = Package::with('packageType')
                    ->whereHas('packageType', function ($query) {
                        $query->whereIn('name_en', ['oneday_trip', 'over_night']);
                    })
                    ->whereHas('bookings', function ($query) use ($date) {
                        $query->whereDate('booking_time',$date);
                    })
                    ->get();

        }else if($package->packageType->name_en == 'sunset'){
             $ct = Package::with('packageType')
                    ->whereHas('packageType', function ($query) {
                        $query->whereIn('name_en',  ['sunset', 'over_night']);
                    })
                    ->whereHas('bookings', function ($query) use ($date) {
                        $query->whereDate('booking_time',$date);
                    })
                    ->get();
        }else if($package->packageType->name_en == 'over_night') {
            $ct = Package::with('packageType')
                    ->whereHas('packageType', function ($query) {
                        $query->whereIn('name_en',  ['oneday_trip', 'over_night','sunset']);
                    })
                    ->whereHas('bookings', function ($query) use ($date) {
                        $query->whereDate('booking_time',$date);
                    })
                    ->get();
        }

      
        
        if(!$ct->isEmpty()){
             return false;
        }
         
        $packageTypeName = optional($package->packageType)->name_en;
        $bookedSeats = Booking::with('package.packageType')
                    ->where('booking_time', $date)
                    ->whereHas('package', function ($query) use ($packageTypeName) {
                        $query->whereHas('packageType', function ($q) use ($packageTypeName) {
                            $q->where('name_en', $packageTypeName);
                        });
                    })
                    ->sum('seat');
       
        
   

        if (($bookedSeats + $requestedSeats) <= $package->max) {
            return true;
        }
        return false;
    }

    public function sendNotification()
    {
        $lineNotify = new LineNotifyService();

        $message = "มีการแจ้งเตือนใหม่จากระบบ!";
        $status = $lineNotify->sendMessage($message);

        if ($status) {
            return response()->json(['message' => 'Notification sent successfully']);
        }

        return response()->json(['message' => 'Failed to send notification'], 500);
    }

    public function sendLineNotify(Request $request)
    {
        // Access Token สำหรับ LINE Notify
        $lineToken = env('LINE_NOTIFY_TOKEN');

        // ตรวจสอบว่า Access Token ถูกตั้งค่าไว้หรือไม่
        if (!$lineToken) {
            return response()->json(['error' => 'LINE_NOTIFY_TOKEN is not set'], 500);
        }

        // ข้อความที่ต้องการส่ง
        $message = $request->input('message', 'ทดสอบระบบ Line notify');

        try {
            // สร้าง HTTP Client
            $client = new Client();

            // URL ของ LINE Notify API
            $url = 'https://notify-api.line.me/api/notify';

            // ส่ง HTTP POST Request
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $lineToken,
                ],
                'form_params' => [
                    'message' => $message,
                ],
            ]);

            // ตรวจสอบสถานะการส่ง
            if ($response->getStatusCode() === 200) {
                return response()->json(['message' => 'แจ้งเตือนสำเร็จ']);
            }

            return response()->json(['error' => 'Failed to send notification'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
