<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments'; // ชื่อตารางที่กำหนดเอง

    protected $fillable = [
        'user_id',
        'amount',
        'account',
        'name',
        'type',
        'payment_token',
        'bank',
        'transfer_time',
        'slip',
        'admin_id',
        'booking_id',
        'iteration',
        'status',
    ];

    // ตัวอย่างการกำหนด relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
