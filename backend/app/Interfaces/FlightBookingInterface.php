<?php

namespace App\Interfaces;

use App\Models\FlightBooking;

interface FlightBookingInterface
{
	public function book(string $flightId): FlightBooking;

	public function update(string $bookingId, array $dataToUpdate): FlightBooking;

	public function getBookingByFlightId(string $flightId): FlightBooking | null;
}
