<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Price;
use App\Models\Booking;
use App\Models\PackageType;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('packageType','prices')->paginate(10);
        $packageTypes = PackageType::selectRaw('MIN(id) as id, name_th')
        ->where('status', '!=', 0)
        ->groupBy('name_th')
        ->get();
        
        return view('admin.package', compact('packages', 'packageTypes'));
    }

    public function store(Request $request)
    {
        

        // Handle file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileExtension = $request->file('image')->getClientOriginalExtension();
             $imageName = time() . '.' . $image->extension();


            // บันทึกรูปภาพในโฟลเดอร์ public/slip โดยใช้ชื่อไฟล์ที่กำหนด
            $imagePath = $request->file('image')->storeAs('package',  $imageName, 'public');
        }

        // Save package data to the database
        $package = new Package();
        $package->name_boat = $request->input('name_boat');
        $package->max_guest = $request->input('max_guest');
        $package->type = $request->input('type');
        $package->yacht = $request->input('yacht') ?? '1';
        $package->note = $request->input('note') ?? '-';
        $package->image = $imageName ?? 'default.png'; // Save image filename
        $package->min = $request->input('min');
        $package->max = $request->input('max');
        $package->start_time = $request->input('start_time');
        $package->end_time = $request->input('end_time');
        $package->status = 1;
        $package->hiding = 0;
        $package->save();

        $data = Booking::latest()->first();

        if ($data) {

            $price = new Price();
            $price->package_id = $package->id; 
            $price->person_type = 'Private';
            $price->agent = $request->input('price_agent');
            $price->regular = $request->input('price_regular');
            $price->subordinate = $request->input('price_sub');
            $price->status = 1;
            $price->save(); 
        } else {
            return back()->with('error', 'ไม่พบข้อมูล Booking ล่าสุด');
        }



        return redirect()->route('package')->with('success', 'Package created successfully.');
    }
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name_boat' => 'required',
            'max_guest' => 'required|integer',
            // Add other fields validation
        ]);

        $package->update($request->all());
        return redirect()->route('package')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('package')->with('success', 'Package deleted successfully.');
    }
}
