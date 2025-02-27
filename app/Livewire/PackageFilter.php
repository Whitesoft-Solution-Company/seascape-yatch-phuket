<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\PackageType;
use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PackageFilter extends Component
{
    public $date;
    public $returndate;
    public $packages = [];
    public $packageTypes = 'oneday_trip';
    public $tripType = 'private';
    public $selectedPackageType; // ใช้สำหรับเก็บค่าที่เลือก
    public $check;

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->returndate = Carbon::now()->addDay()->format('Y-m-d');
        
        $this->loadPackages();
    }

    public function updatedDate()
    {
       
        $this->loadPackages();
    }
    public function updatedtripType()
    {
        $this->loadPackages();
    }
    public function updatedpackageTypes()
    {
        $this->loadPackages();
    }

    public function updatedreturndate()
    {
        $this->loadPackages();
    }

    public function loadPackages()
    {
  
        $this->check = 'front';
        if ($this->tripType == 'join') {

            $this->packages =  $this->joinPackage();
        } else {

            $this->packages =   $this->PrivatePackage();
        }
        // ถ้าไม่มีแพ็คเกจที่ตรงกับวันที่เลือก รีเซ็ต $packages เป็นค่าว่าง
        if ($this->packages->isEmpty()) {
            $this->packages = [];
        }
    }
 

    public function getAvailablePackages($package,$date,$datereturn){
        $this->tripType = $package->packagetype->trip_type;
        $this->packageTypes = $package->packagetype->name_en;
        $this->date = $date;
        $this->returndate = $datereturn;
       
       
      
        if ($package->packagetype->trip_type == 'join') {
            
            return $this->joinPackage();
        } else {
           
            return $this->PrivatePackage();
        }
    }

    public function getAvailablePackagesBackend($trip_type,$name_en,$date,$datereturn){
        $this->tripType = $trip_type;
        $this->packageTypes = $name_en;
        $this->date = $date;
        $this->returndate = $datereturn;
        $this->check = 'backend';
        
        if ($trip_type == 'join') {
            
            return $this->joinPackage();
        } else {
         
            return $this->PrivatePackage();
        }
    }

    public function joinPackage()
    {
        $packages = Package::select('package.*', 'package_types.*', 'yachts.*', 'package.id as id')
            ->leftJoin('package_types', 'package.type', '=', 'package_types.id')
            ->leftJoin('yachts', 'package.yacht', '=', 'yachts.id')
            ->where('package_types.trip_type', $this->tripType)
            ->where('package_types.name_en', $this->packageTypes)
            ->where('package.status', 1)
            ->where('package.id', '!=', 1)
            ->where('package_types.status', 1)
            ->where('package.start_time', '<=', $this->date)
            ->where('package.end_time', '>=', $this->returndate)
            ->whereNotIn('package.id', function ($query)  {
                $query->select('bookings.package_id')
                    ->from('bookings')
                    ->leftJoin('package', 'package.id', '=', 'bookings.package_id')
                    ->whereBetween('bookings.booking_time', [$this->date, $this->returndate])
                    ->groupBy('bookings.package_id')
                    ->havingRaw('SUM(ifnull(bookings.seat, 0)) >= package.max_guest');
            })
            ->get();
            return $packages;
    }
    public function PrivatePackage()
    {
         $getpackage = Booking::with('package.packageType') 
        ->whereDate('booking_time', $this->date) 
        ->get();
    
        $packages = Package::select('package.*', 'package_types.*', 'yachts.*', 'package.id as id','package.image as image')
            ->leftJoin('package_types', 'package.type', '=', 'package_types.id')
            ->leftJoin('yachts', 'package.yacht', '=', 'yachts.id')
            ->where('package_types.trip_type',  $this->tripType)
           
            ->where('package.status', 1)
            ->where('package_types.status', 1)
            ->where('package.start_time', '<=', $this->date)
            ->where('package.end_time', '>=', $this->returndate)
            ->whereNotNull('package.start_time')
            ->whereNotNull('package.end_time');

            if ($this->check === 'front') {

                $packages->where('package_types.name_en', $this->packageTypes);
                $packages->where('package.id', '!=', 1);
                $packages->where('package.id', '!=', 2);
            } 
                 
                if(!$getpackage->isEmpty()){
                    if ($getpackage[0]->package->packagetype->name_en === 'oneday_trip') {
                        $packages->whereNotIn('package_types.name_en', ['oneday_trip', 'over_night']);
                    } else if($getpackage[0]->package->packagetype->name_en === 'sunset') {
                        $packages->whereNotIn('package_types.name_en',  ['sunset', 'over_night']);
                    }else{
                         $packages->whereNotIn('package_types.name_en',  ['oneday_trip', 'over_night','sunset']);
                    }
                }
            
        
           $packagess = $packages->get();

            return $packagess;
    }

    public function render()
    {
        $this->selectedPackageType = PackageType::select('name_en')->where('status', 1)->groupBy('name_en')->get();
      
        return view('livewire.package-filter');
    }
}
