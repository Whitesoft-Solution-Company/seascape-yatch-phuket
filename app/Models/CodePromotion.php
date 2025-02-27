<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodePromotion extends Model
{
    use HasFactory;

    // ชื่อตารางในฐานข้อมูล
    protected $table = 'code_promotion';

    // กำหนดคอลัมน์ที่สามารถกรอกข้อมูลได้
    protected $fillable = [
        'promotion_code',
        'type',
        'traget', // หากชื่อผิดพิมพ์ให้แก้ไขเป็น target ในฐานข้อมูลและ model
        'trip_type',
        'amount',
        'date_start',
        'date_end',
        'status',
    ];

    // ถ้าคุณใช้ created_at และ updated_at ให้แน่ใจว่า timestamps ถูกเปิดใช้งาน
    public $timestamps = true; // ถ้าคุณไม่ได้ใช้ timestamps ให้ตั้งเป็น false

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id', 'code_id');
    }
}
