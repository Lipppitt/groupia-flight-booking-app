<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirCraft extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function flights(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Flight::class, 'aircraft_id');
    }
}
