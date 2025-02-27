<?php

namespace App\Livewire;

use App\Http\Controllers\BookingController;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\CodePromotion;
use App\Models\Package;
use App\Models\PackageType;
use Livewire\Component;
use Livewire\WithFileUploads; // Add this line

class CalendarComponent extends Component
{
    use WithFileUploads;
    public $events = [];
    public $agents = [];
    public $onedayEvents;
    public $sunsetEvents;
    public $overnightEvents;

    public $selectedpackagetypes = '0';
    public $selectedpackages;
    public $bookingcode;
    public $packages;
    public $types;
    public $trip;
    public $selectedtrip;
    public $payment = 'paid';
    public $promocode = '';
    public $totalPage = 0;
    public $discount = 0;
    public $deposit = 0;
    public $totaldept = 0;
    public $total = 0;



    public $tel;
    public $inputAgent = 2;
    public $inputcontact;


    public $nodate = false;
    public $date;
    public $returndate;
    public $name;
    public $notel = false;
    public $count_Adult;
    public $count_Child;
    public $inputprice_Adult = 0;
    public $inputprice_Child = 0;
    public $totalprice_Adult;
    public $totalprice_Child;
    public $overticket;
    public $account_number;
    public $datetime_transfer;
    public $slip;
    public $note;
    public $count_Private;
    public $inputprice_Private = 0;




    public function mount()
    {

        $this->loadEvents();
        $this->loadtrip();
        $this->loadAgents();
        $this->loadPackages();
        $this->loadtype();
        $controller = new BookingController();
        $this->bookingcode = $controller->generateBookingCode();

        // if (empty($this->selectedpackages)) {
        //     $this->selectedpackages = $this->packages->where('id', 2)->first();
        // }
    }

    public function loadAgents()
    {
        $this->agents = Agent::all();
    }

    public function loadtrip()
    {
        $this->trip = PackageType::selectRaw('MIN(id) as id, name_en ,  MIN(color_title) as color_title ')
            ->where('status',1)
            ->groupBy('name_en')
            ->get();
    }

    public function loadtype()
    {
        $this->types = PackageType::selectRaw('MIN(id) as id, trip_type, MIN(name_en) as name_en')
            ->where('status',1)
            ->groupBy('trip_type')
            ->get();
    }

    public function loadPackages()
    {

        $this->packages = Package::with(['packageType', 'prices'])
            ->whereHas('packageType', function ($query) {
                $query->where('trip_type', $this->selectedpackagetypes);
            })
            ->get();
           
    }

    public function updatedselectedpackagetypes()
    {
    
        $Packagefilter = new PackageFilter();
        $this->packages = $Packagefilter->getAvailablePackagesBackend($this->selectedpackagetypes,$this->selectedtrip,$this->date,$this->returndate);
        if ($this->packages->isNotEmpty()) {
            $this->selectedpackages = $this->packages->first()->id;
        } else {
            $this->selectedpackages = null; // หรือจัดการอย่างอื่นเมื่อไม่มีข้อมูล
        }
    }
    public function updatedinputAgent()
    {
        if ($this->selectedpackages) {
            $this->updatedselectedpackages();
        }

        $this->updatedPromocode();
    }
    public function updatedselectedpackages()
    {
        $filteredPackages = $this->packages->where('id', $this->selectedpackages);
        foreach ($filteredPackages as $package) {
            $data = $package;
            $data['prices'] = $package->prices; // เข้าถึง relationship ที่มีอยู่แล้ว
            $data['packageType'] = $package->packageType;
        }
        $agents = Agent::find($this->inputAgent);

        if ($agents) {

            if ($agents->type_user == 2) {

                if ($data->packageType->trip_type == 'join') {

                    $this->inputprice_Adult = $data->prices[0]->subordinate;
                    $this->inputprice_Child = $data->prices[1]->subordinate;
                    $this->totalprice_Adult = 0;
                    $this->totalprice_Child = 0;
                } else {

                    $this->inputprice_Private = $data->prices[0]->subordinate;
                    $this->totalPage = $data->prices[0]->subordinate;
                    $this->total = $data->prices[0]->subordinate;
                }
            } else if ($agents->type_user == 1 or $agents->type_user == 4) {
                if ($data->packageType->trip_type == 'join') {
                    $this->inputprice_Adult = $data->prices[0]->agent;
                    $this->inputprice_Child = $data->prices[1]->agent;
                    $this->totalprice_Adult = 0;
                    $this->totalprice_Child = 0;
                } else {

                    $this->inputprice_Private = $data->prices[0]->agent;
                    $this->totalPage = $data->prices[0]->agent;
                    $this->total = $data->prices[0]->agent;
                }
            } else {

                if ($data->packageType->trip_type == 'join') {
                    $this->inputprice_Adult = $data->prices[0]->regular;
                    $this->inputprice_Child = $data->prices[1]->regular;
                    $this->totalprice_Adult = 0;
                    $this->totalprice_Child = 0;
                } else {

                    $this->inputprice_Private = $data->prices[0]->regular;
                    $this->totalPage = $data->prices[0]->regular;
                    $this->total = $data->prices[0]->regular;
                }
            }
        } else {
            if ($data->packageType->trip_type == 'join') {
                $this->inputprice_Adult = $data->prices[0]->regular;
                $this->inputprice_Child = $data->prices[1]->regular;
                $this->totalprice_Adult = 0;
                $this->totalprice_Child = 0;
            } else {

                $this->inputprice_Private = $data->prices[0]->regular;
                $this->totalPage = $data->prices[0]->regular;
                $this->total = $data->prices[0]->regular;
            }
        }
    }






    public function loadEvents()
    {

        $this->events = Booking::join('package', 'bookings.package_id', '=', 'package.id')
            ->join('package_types', 'package.type', '=', 'package_types.id')
            ->selectRaw('
             bookings.id as bid,
           bookings.booking_time as start,
            bookings.return_date, 
            bookings.departure_date,
            bookings.booking_code,
           SUM(bookings.seat) as passenger_count, 
           bookings.booking_status,
            package_types.trip_type,
            package.id,
            package_types.name_en,
            package.max_guest
       ')
            ->groupBy('bookings.booking_time',
             'bookings.booking_status',
               'bookings.departure_date',
             'bookings.return_date',
              'package_types.trip_type',
               'package.max_guest',
                'package.id',
                'package_types.name_en',
                 'bid',
                  'bookings.booking_code')
            ->get()
            ->map(function ($booking) {
                $isFull = $booking->passenger_count > $booking->max_guest;
                // $color = $isFull ? 'gray' : $this->getStatusColor($booking->trip_type, $booking->booking_status);
                // $title = $isFull ? 'FULL' : $booking->passenger_count . '/' . $booking->max_guest;

                $color = $this->getStatusColor($booking->trip_type,$booking->name_en, $booking->booking_status);
                $title = $booking->booking_code;
                $endDate = $booking->departure_date != $booking->return_date 
                            ? date('Y-m-d', strtotime($booking->return_date . ' +1 day')) 
                            : $booking->return_date;
                $textColor = 'white'; 
                if($booking->id == 1){
                    $color = 'green';
                }
                if($booking->booking_status == 'maintenance'){
                    $title = 'Mainternance';
                    $color = 'yellow';
                    $textColor = 'black'; 

                }
                   
                return [
                    'title' =>  $title,
                    'start' => $booking->start,
                    'end' => $endDate,
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'textColor' => $textColor,
                    'status' => $booking->status,
                    'trip_type' => $booking->name_en,
                    'id' => $booking->bid
                ];
            })
            ->toArray();

        $this->onedayEvents = array_values(array_filter($this->events, function ($event) {
            return $event['trip_type'] === 'oneday_trip';
        }));

        $this->sunsetEvents = array_values(array_filter($this->events, function ($event) {
            return $event['trip_type'] === 'sunset';
        }));

        $this->overnightEvents = array_values(array_filter($this->events, function ($event) {
            return $event['trip_type'] === 'over_night';
        }));
    }


    public function getStatusColor($tripType,$name_en, $bookingStatus)
    {
        if ($tripType === 'join') {
            return 'green';
        } elseif ($tripType === 'private') {

            if ($name_en === 'oneday_trip') {
                return 'blue';
            } elseif ($name_en === 'over_night') {
                return 'purple';
            } elseif ($name_en === 'sunset') {
                return '#ff6f1b';
            }
        }

        if (in_array($bookingStatus, ['cancel', 'delete'])) {
            return 'red';
        } elseif ($bookingStatus === 'internal') {
            return 'blue';
        }

        return '#378006';
    }

    public function updatedPromocode()
    {

        if (!empty($this->promocode)) {
            $promo = CodePromotion::where('promotion_code', $this->promocode)->first();

            if ($promo) {
                if ($promo->type == 'percent') {
                    $this->discount = $this->totalPage * ($promo->amount / 100);
                } else {
                    if ($promo->target == 'person') {
                        $seat_adult = 1; // ดึงจาก Livewire state หรือจัดการผ่าน front-end
                        $this->discount = $seat_adult * $promo->amount;
                    } else {
                        $this->discount = $promo->amount;
                    }
                }

                $this->total = $this->totalPage - $this->discount;
                $this->promocode = $promo->id;
            } else {
                $this->discount = 0;
                $this->total = $this->totalPage;
            }
        }
    }



    public function render()
    {
        return view('livewire.calendar-component');
    }
}
