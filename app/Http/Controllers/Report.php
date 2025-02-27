<?php

namespace App\Http\Controllers;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\BookingOption;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\Payment;
use App\Models\User;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;

class Report extends Controller
{
     public function index(Request $request)
    {

     
        $agents = Agent::all();
        $packages = PackageType::selectRaw('MIN(id) as id, name_en')
                    ->where('status', '!=', 0)
                    ->groupBy('name_en')
                    ->get();
         $startDate = $request->start_date;
         $endDate = $request->end_date;
         $packageId = $request->package;
         $agentId = $request->agent;
         
         // สร้าง query เพื่อดึงข้อมูล
         $query = Booking::query();

         if ($startDate) {

             $query->whereDate('departure_date', '>=', $startDate);
         }

         if ($endDate) {
             $query->whereDate('return_date', '<=', $endDate);
         }

         if ($packageId !== 'x' && $packageId) {

            $query->whereHas('package', function ($q) use ($packageId) {
                $q->where('type', $packageId);
            });
        }

         if ($agentId !== 'x' && $agentId) {
             $query->where('agent', $agentId);
         }

         $data = $query->with(['package', 'agents','booking_option']) ->orderBy('id', 'desc')->get()
                    ->map(function ($booking) {
                        $color = BookingController::getStatusColor($booking->booking_status);
                        $booking->color = $color;
                        return $booking;
                    });


                   
        

        return view('admin.report', compact('agents', 'packages','data'));
    }
    public function generateReport($ids)
    {

        $idsArray = explode(',', $ids);

        $data = Booking::with('package.packageType', 'package.prices', 'agents', 'payments')->whereIn('id', $idsArray)->get();
            // dd($data);
        return view('admin.invoice.report_print', compact('data'));

    }

    public function getHistory(Request $request)
     {
         $startDate = $request->start_date;
         $endDate = $request->end_date;
         $packageId = $request->package_id;
         $agentId = $request->agent_id;
        
         // สร้าง query เพื่อดึงข้อมูล
         $query = Booking::query();

         if ($startDate) {
             $query->whereDate('departure_date', '>=', $startDate);
         }

         if ($endDate) {
             $query->whereDate('return_date', '<=', $endDate);
         }

         if ($packageId !== 'x') {
            $query->whereHas('package', function ($q) use ($packageId) {
                $q->where('type', $packageId);
            });
        }

         if ($agentId !== 'x') {
             $query->where('agent', $agentId);
         }

         $data = $query->with(['package', 'agents','booking_option'])->get()
                    ->map(function ($booking) {
                        $color = BookingController::getStatusColor($booking->booking_status);
                        $booking->color = $color;
                        return $booking;
                    });

        

         return response()->json($data);
     }
}
