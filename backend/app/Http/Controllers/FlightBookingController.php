<?php

namespace App\Http\Controllers;

use App\Enums\FlightBookingStatus;
use App\Http\Requests\StoreFlightBookingRequest;
use App\Interfaces\FlightBookingInterface;
use App\Models\FlightBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FlightBookingController extends Controller
{
	public function __construct(protected FlightBookingInterface $bookingService) {}

	public function index(Request $request)
	{
		$usersBookings = $this->bookingService->getUsersBookings();

		return response()->json($usersBookings);
	}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlightBookingRequest $request): \Illuminate\Http\JsonResponse
	{
		$flightId = $request->validated('flight_id');

		$userExistingBooking = $this->bookingService->getBookingByFlightId($flightId);
		if (!$userExistingBooking) {
			$booking = $this->bookingService->book($flightId);
		} else {
			$booking = $userExistingBooking;
		}

		return response()->json($booking);
    }

    /**
     * Display the specified resource.
     */
    public function show(FlightBooking $flightBooking): \Illuminate\Http\JsonResponse
	{
		$response = Gate::inspect('view', $flightBooking);

		if (!$response->allowed()) {
			return response()->json(['message' => $response->message()], 403);
		}

		return response()->json($flightBooking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function cancel(FlightBooking $flightBooking): \Illuminate\Http\JsonResponse
	{
		$response = Gate::inspect('cancel', $flightBooking);

		if (!$response->allowed()) {
			return response()->json(['message' => $response->message()], 403);
		}

		$booking = $this->bookingService->update($flightBooking->uuid, [
			'status' => FlightBookingStatus::Cancelled->value
		]);

		return response()->json($booking);
	}
}
