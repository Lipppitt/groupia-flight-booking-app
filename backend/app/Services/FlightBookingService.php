<?php

namespace App\Services;

use App\Enums\FlightBookingStatus;
use App\Interfaces\FlightBookingInterface;
use App\Models\Flight;
use App\Models\FlightBooking;
use Illuminate\Support\Facades\Auth;

class FlightBookingService implements FlightBookingInterface
{
	public function book($flightId) : FlightBooking
	{
		$flight = Flight::findOrFail($flightId);
		$user 	= Auth::user();

		$flightBooking = new FlightBooking([
			'status' => FlightBookingStatus::Completed->value, // Simulate completed booking
		]);

		$flightBooking->user()->associate($user);
		$flightBooking->flight()->associate($flight);
		$flightBooking->save();

		return $flightBooking;
	}

	public function update($bookingId, $dataToUpdate) : FlightBooking
	{
		$flightBooking = FlightBooking::findOrFail($bookingId);
		$flightBooking->update($dataToUpdate);
		return $flightBooking;
	}

	public function getBookingByFlightId($flightId): FlightBooking | null
	{
		$user = Auth::user();
		$userBooking = $user->bookings->where('flight_id', '=', $flightId)->first();
		return $userBooking;
	}

	public function getUsersBookings()
	{
		$user = Auth::user();

		$bookings = $user->bookings()->with('flight')->get();

		return $bookings->map(function ($booking) {
			return [
				'uuid' => $booking->uuid,
				'status' => $booking->status,
				'arrives' => optional($booking->flight)->arrives,
				'departs' => optional($booking->flight)->departs,
				'created_at' => $booking->created_at
			];
		});
	}
}
