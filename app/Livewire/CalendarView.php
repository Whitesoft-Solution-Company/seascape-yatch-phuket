<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\PackageType;
use App\Models\Package;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CalendarView extends Component
{
    public $events = [];
    public $agents = [];
    public $onedayEvents;
    public $sunsetEvents;
    public $overnightEvents;

    public $types;
    public $trip;
    public $package;
    public $duration;

    public function mount()
    {

        $this->loadtrip();
        $this->loadEvents();
    
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
            package_types.name_en,
            package.max_guest
       ')
            ->groupBy('bookings.booking_time',
             'bookings.booking_status',
               'bookings.departure_date',
             'bookings.return_date',
              'package_types.trip_type',
               'package.max_guest',
                'package_types.name_en',
                 'bid',
                  'bookings.booking_code')
            ->get()
            ->map(function ($booking) {
                $isFull = $booking->passenger_count > $booking->max_guest;
                // $color = $isFull ? 'gray' : $this->getStatusColor($booking->trip_type, $booking->booking_status);
                // $title = $isFull ? 'เต็ม' : $booking->passenger_count . '/' . $booking->max_guest;
                 $color = $this->getStatusColor($booking->trip_type, $booking->booking_status);
                $title = 'Private';
                 $endDate = $booking->departure_date != $booking->return_date 
                            ? date('Y-m-d', strtotime($booking->return_date . ' +1 day')) 
                            : $booking->return_date;
                  $textColor = 'white'; 
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

        $this->onedayEvents = array_values(array_filter($this->events, function ($event) {
            return $event['trip_type'] === 'sunset';
        }));

        $this->onedayEvents = array_values(array_filter($this->events, function ($event) {
            return $event['trip_type'] === 'over_night';
        }));

         

           

    }
    
    public function loadtrip()
    {
        $this->trip = PackageType::selectRaw('MIN(id) as id, name_en ,  MIN(color_title) as color_title ')
            ->where('status',1)
            ->groupBy('name_en')
            ->get();
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

    public function render()
    {
        return view('livewire.calendar-view');
    }
}
