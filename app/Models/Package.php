<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'package';

    protected $fillable = [
        'name_boat',
        'max_guest',
        'type',
        'yacht_type',
        'note',
        'image',
        'price',
        'min',
        'max',
        'start_time',
        'end_time',
        'create_time',
        'status',
        
        'hiding'
    ];

    // Define the relationship with Price
    public function prices()
    {
        return $this->hasMany(Price::class, 'package_id');
    }

    public function packageType()
    {
        return $this->belongsTo(PackageType::class, 'type');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'package_id');
    }
    
    public function yachts()
    {
        return $this->belongsTo(Yacht::class, 'yacht');
    }
}
