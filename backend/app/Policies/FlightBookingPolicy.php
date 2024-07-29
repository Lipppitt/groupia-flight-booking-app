<?php

namespace App\Policies;

use App\Enums\FlightBookingStatus;
use App\Models\FlightBooking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FlightBookingPolicy
{
	/**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FlightBooking $flightBooking): Response
	{
		return $user->bookings()->where('uuid', '=', $flightBooking->uuid)->exists()
			? Response::allow()
			: Response::deny('You do not own this booking.');
	}

    /**
     * Determine whether the user can update the model.
     */
    public function cancel(User $user, FlightBooking $flightBooking): Response
	{
		if ($flightBooking->status === FlightBookingStatus::Cancelled->value) {
			Response::deny('This booking has already cancelled.');
		}

		return $user->bookings()->where('uuid', '=', $flightBooking->uuid)->exists()
			? Response::allow()
			: Response::deny('You do not own this booking.');
    }
}
