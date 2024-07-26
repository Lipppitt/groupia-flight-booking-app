<?php

namespace App\Models;

use Carbon\CarbonInterval;
use DateInterval;
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

    protected $appends = [
        'departs',
        'arrives',
        'total_duration'
    ];

    public function segments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FlightSegment::class, 'flight_id', 'uuid');
    }

    public function fees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FlightFee::class, 'flight_id', 'uuid');
    }

    public function aircraft(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AirCraft::class);
    }

    public function getDepartsAttribute()
    {
        $segment = $this->segments()
            ->with('departureLocation')
            ->orderBy('departure_time', 'desc')
            ->first();

        if ($segment) {
            return [
                'time' => $segment->departure_time,
                'country_code' => $segment->departureLocation->country_code ?? null,
                'city_code' => $segment->departureLocation->city_code ?? null
            ];
        }

        return null;
    }

    public function getArrivesAttribute()
    {
        $segment = $this->segments()
            ->with('arrivalLocation')
            ->orderBy('arrival_time', 'desc')
            ->first();

        if ($segment) {
            return [
                'time' => $segment->arrival_time,
                'country_code' => $segment->arrivalLocation->country_code ?? null,
                'city_code' => $segment->arrivalLocation->city_code ?? null,
            ];
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function getTotalDurationAttribute()
    {
        $totalTimeSeconds = 0;

        $segmentDurations = $this->segments()->pluck('duration');
        foreach($segmentDurations as $segmentDuration) {
            $interval = new DateInterval($segmentDuration);
            $totalTimeSeconds += $this->convertIntervalToSeconds($interval);
        }

        return CarbonInterval::seconds($totalTimeSeconds)->cascade()->forHumans();
    }

    function convertIntervalToSeconds(DateInterval $interval): int
    {
        $seconds = 0;
        $years = $interval->y * 365 * 24 * 60 * 60;
        $months = $interval->m * 30 * 24 * 60 * 60;
        $days = $interval->d * 24 * 60 * 60;
        $hours = $interval->h * 60 * 60;
        $minutes = $interval->i * 60;
        $seconds += $interval->s;
        $seconds += $years + $months + $days + $hours + $minutes;
        return $seconds;
    }
}
