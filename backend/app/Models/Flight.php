<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'external_id',
        'instant_ticket_required',
        'no_homogenous',
        'one_way',
        'last_ticketing_date',
        'aircraft_id',
        'base_price',
        'total_price',
        'currency'
    ];

    public function segments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FlightSegment::class);
    }

    public function fees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FlightFee::class);
    }

    public function aircraft(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AirCraft::class);
    }
}
