<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yacht extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'capacity', 'image'];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
