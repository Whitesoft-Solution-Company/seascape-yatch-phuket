<?php

namespace App\Http\Controllers;

use App\Models\Admin as ModelsAdmin;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\BookingOption;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class Admin extends Controller
{
    //

    public function dashboard()
    {

        return view('dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);


        // $admin = ModelsAdmin::create([
        //             'username' => $credentials['username'],
        //             'name'=>'momo',
        //             'class'=>'1',
        //             'password' => Hash::make($credentials['password']), // แฮชรหัสผ่าน
        // ]);

        // return true;

        // ถ้าผู้ใช้ admin มีอยู่แล้ว ให้ล็อกอิน
        if (Auth::guard('admin')->attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {

            session(['role' => 'admin']);
            // dd(Auth());
            return redirect('/admin/calendar');
        } else {

            return redirect()->route('login');
        }
    }
    public function getPackagesByType($tripType)
    {
        $packages = Package::with('packageType')
            ->whereHas('packageType', function ($query) use ($tripType) {
                $query->where('trip_type', $tripType);
            })
            ->get();

        return response()->json($packages);
    }
    public function getBooking($bookingId)
    {
        $paymentSlipUrl = [];
        $paymentExists = Payment::where('booking_id', $bookingId)->exists();
        $bookingQuery = Booking::with([
            'package',
            'package.packageType',
            'package.prices',
            'agents',
            'payments',
            'booking_option','code'
        ])->where('id', $bookingId)->first();

        if (!$bookingQuery) {
            return response()->json(['message' => 'Booking not found'], 404);
        }
       
        $tripType = $bookingQuery->package->packageType->trip_type;
        // กำหนดสถานะการชำระเงิน
        $checkPayment = $paymentExists ? 1 : 0;
        $packages = Package::with('packageType')
            ->where('start_time', '<=', $bookingQuery->booking_time)
            ->where('end_time', '>=', $bookingQuery->return_date)
            ->whereHas('packageType', function ($query) use ($tripType) {
                $query->where('trip_type', $tripType);
            })
            ->get();
          
            if (!empty($bookingQuery->payments) && isset($bookingQuery->payments[0]->slip)) {
                $paymentSlipUrl1 = asset('storage/slip/' . $bookingQuery->payments[0]->slip);
              
                 
            } else {
                $paymentSlipUrl1 = asset('storage/slip/noslip.jpg');
            }

            if (!empty($bookingQuery->payments) && isset($bookingQuery->payments[1]->slip)) {
                 $paymentSlipUrl2 = asset('storage/slip/' . $bookingQuery->payments[1]->slip);
                
            } else {
                $paymentSlipUrl2 = asset('storage/slip/noslip.jpg');
            }

            if (!empty($bookingQuery->payments) && isset($bookingQuery->payments[2]->slip)) {
                  $paymentSlipUrl3 = asset('storage/slip/' . $bookingQuery->payments[2]->slip);
                  
            } else {
                $paymentSlipUrl3 = asset('storage/slip/noslip.jpg');
            }


          
        return response()->json([
            'booking' => $bookingQuery,
            'check_payment' => $checkPayment,
            'paymentSlipUrl1' => $paymentSlipUrl1,
            'paymentSlipUrl2' => $paymentSlipUrl2,
            'paymentSlipUrl3' => $paymentSlipUrl3,
            'packages' => $packages
        ]);
    }
    public function booking(Request $request)
    {
       $query = Booking::with([
        'package.packageType',
        'package.prices',
        'agents',
        'payments'
    ]);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('booking_code', 'like', '%' . $request->search . '%')
                  ->orWhere('tel', 'like', '%' . $request->search . '%')
                  ->orWhere('booking_time', 'like', '%' . $request->search . '%')
                  ->orWhereHas('agents', function ($q) use ($request) {
                      $q->where('agent_name', 'like', '%' . $request->search . '%');
                  });
        }
        $query->orderBy('id', 'desc');
        $bookings = $query->paginate(10);
        
        $agents = Agent::all();
        $types = PackageType::selectRaw('MIN(id) as id, trip_type, MIN(name_en) as name_en')
            ->groupBy('trip_type')
            ->get();
        return view('admin.booking', compact('bookings', 'agents', 'types'));
    }

    private function getStatusColor($tripType, $bookingStatus)
    {
        if ($tripType === 'join') {
            return 'green';
        } elseif ($tripType === 'private') {
            return 'blue';
        }

        if (in_array($bookingStatus, ['cancel', 'delete'])) {
            return 'red';
        } elseif ($bookingStatus === 'internal') {
            return 'blue';
        }

        return '#378006';
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function invoice1($booking_id = null)
    {
        $data = Booking::with('package.packageType', 'package.prices', 'agents', 'payments')->where('id', $booking_id)->first();
        $packageTypes = PackageType::select('name_en', DB::raw('MIN(id) as id'))
            ->where('status', 1)
            ->groupBy('name_en')
            ->get();
        $bookingoption = BookingOption::where('booking_id', $booking_id)->orderBy('iteration', 'asc')->get();



        return view('admin.invoice.invoice1', compact('data', 'packageTypes', 'bookingoption'));
    }
    public function invoice2($booking_id = null)
    {
        $data = Booking::with('package.packageType', 'package.prices', 'agents', 'payments')->where('id', $booking_id)->first();
        $packageTypes = PackageType::select('name_en', DB::raw('MIN(id) as id'))
            ->where('status', 1)
            ->groupBy('name_en')
            ->get();

        $bookingoption = BookingOption::where('booking_id', $booking_id)->get();

        return view('admin.invoice.invoice2', compact('data', 'packageTypes', 'bookingoption'));
    }
    public function invoice3($booking_id = null)
    {
        $data = Booking::with('package.packageType', 'package.prices', 'agents', 'payments')->where('id', $booking_id)->first();
        $packageTypes = PackageType::select('name_en', DB::raw('MIN(id) as id'))
            ->where('status', 1)
            ->groupBy('name_en')
            ->get();
        if (!empty($data->payments) && isset($data->payments[0]->slip)) {
                $paymentSlipUrl1 =$data->payments[0]->slip;
              
                 
            } else {
                $paymentSlipUrl1 = '-';
            }

            if (!empty($data->payments) && isset($data->payments[1]->slip)) {
                 $paymentSlipUrl2 =$data->payments[1]->slip;
                
            } else {
                $paymentSlipUrl2 = '-';
            }

            if (!empty($data->payments) && isset($data->payments[2]->slip)) {
                  $paymentSlipUrl3 =$data->payments[2]->slip;
                  
            } else {
                $paymentSlipUrl3 = '-';
            }


 

        return view('admin.invoice.invoice3', compact('data', 'packageTypes','paymentSlipUrl1','paymentSlipUrl2','paymentSlipUrl3'));
    }
}
