<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $table = 'price';

    protected $fillable = [
        'package_id',
        'person_type',
        'agent',
        'regular',
        'subordinate',
        'status'
    ];

    // Define the relationship with Package
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
