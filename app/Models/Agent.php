<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $table = 'tb_agent';
    protected $primaryKey = 'agent_id';
    public $timestamps = true; // มีการใช้ timestamps ในตาราง

    protected $fillable = [
        'agent_name',
        'agent_phone',
        'agent_web',
        'address',
        'token',
        'tex_number',
        'create_date',
        'password_ch',
        'salt',
        'type_user',
        'credit',
        'username',
        'img_certificate',
        'agent_status',
    ];
}
