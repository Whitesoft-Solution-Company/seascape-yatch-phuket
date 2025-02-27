<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $table = 'bookings';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'booking_code',
        'name',
        'user_id',
        'tel',
        'agent',
        'contact',
        'package_id',
        'seat',
        'extra_seat',
        'private_seat',
        'adult',
        'child',
        'baby',
        'guide_inspect',
        'amount',
        'code_id',
        'aff_id',
        'credit',
        'pledge',
        'arrearage',
        'booking_time',
        'embark',
        'disembark',
        'admin_id',
        'statement_status',
        'booking_status',
        'note',
        'percent_discount',
        'departure_date',
        'return_date'
    ];

    protected $hidden = [];

    protected $dates = ['deleted_at', 'departure_date', 'return_date'];

    protected $attributes = [
        'agent' => 2,
        'baby' => 0,
        'credit' => 0,
        'statement_status' => 'unpaid',
        'booking_status' => 'unpaid',
        'percent_discount' => 0.0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function agents()
    {
        return $this->belongsTo(Agent::class, 'agent', 'agent_id');
    }

    public function code()
    {
        return $this->belongsTo(CodePromotion::class, 'code_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'booking_id', 'id');
    }

    public function booking_option()
    {
        return $this->hasMany(BookingOption::class, 'booking_id', 'id');
    }
}
