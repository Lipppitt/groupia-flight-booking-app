<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightSegment extends Model
{
    use HasFactory, hasUuIds;

    protected $primaryKey = 'uuid';


    protected $fillable = [
        'external_id',
        'flight_id',
        'departure_time',
        'arrival_time',
        'arrival_location_id',
        'departure_location_id',
        'duration',
        'number_of_stops',
        'carrier_id',
        'aircraft_id'
    ];

    public function flight(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Flight::class, 'flight_id', 'uuid');
    }

    public function arrivalLocation(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Location::class, 'id', 'arrival_location_id');
    }

    public function departureLocation(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Location::class, 'id', 'departure_location_id');
    }

    public function carrier(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Carrier::class, 'id', 'carrier_id');
    }

    public function aircraft(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AirCraft::class, 'id', 'aircraft_id');
    }
}


