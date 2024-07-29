<?php

namespace App\Models;

use App\Enums\FlightBookingStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightBooking extends Model
{
    use HasFactory, HasUuids;

	protected $primaryKey = 'uuid';

	public function getRouteKeyName(): string
	{
		return 'uuid';
	}

    protected $casts = [
        'status' => FlightBookingStatus::class,
    ];

	protected $fillable = [
		'status',
		'user_id',
		'flight_id'
	];

    public function flight(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Flight::class, 'flight_id', 'uuid');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
