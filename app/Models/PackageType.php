<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageType extends Model
{
    use HasFactory;

    // กำหนดชื่อของตาราง (ถ้าไม่กำหนด Laravel จะใช้ชื่อแบบ snake_case ของ model)
    protected $table = 'package_types';

    // กำหนด fillable attributes
    protected $fillable = [
        'name_th',
        'name_en',
        'trip_type',
        'color_title',
        'status'
    ];

    // กำหนดว่า timestamps ให้ Laravel จัดการเอง
    public $timestamps = true;

    // ความสัมพันธ์กับโมเดลอื่นๆ (ตัวอย่าง)
    public function package()
    {
        return $this->hasMany(Package::class, 'type');
    }

}
