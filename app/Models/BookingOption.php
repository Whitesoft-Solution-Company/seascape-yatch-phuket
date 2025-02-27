<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingOption extends Model
{
    use HasFactory;

    protected $table = 'booking_option';

    protected $fillable = [
        'detail',
        'amount',
        'booking_id',
        'typeoption',
        'iteration'
    ];



    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}
