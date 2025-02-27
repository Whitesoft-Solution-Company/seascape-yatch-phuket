<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // เปลี่ยนจาก Model ธรรมดาเป็น Authenticatable

class Admin extends Authenticatable // ใช้ Authenticatable
{
    use HasFactory;
    protected $table = 'admin';
    protected $fillable = [
        'username',
        'password',
        'name',
        'class',
        // เพิ่มฟิลด์อื่นๆ ตามต้องการ
    ];

    protected $hidden = [
        'password', // ปิดบังรหัสผ่าน
    ];
}
