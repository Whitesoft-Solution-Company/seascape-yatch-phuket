<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    protected $table = 'insurances';

    protected $fillable = [
        'booking_id',
        'id_card',
        'name',
        'dob',
        'age',

    ];

    /**
     * Get the booking associated with the insurance.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
