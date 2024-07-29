<?php

use App\Http\Controllers\FlightBookingController;
use App\Http\Controllers\FlightController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/user', function (Request $request) {
        if (auth('sanctum')->check()) {
            return auth('sanctum')->user();
        }
        return null;
    });

    Route::get('/flights', [FlightController::class, 'index']);

	Route::middleware(['auth:sanctum'])->group(function () {
		Route::get('/users-flight-bookings', [FlightBookingController::class, 'index']);
		Route::post('/flight-bookings', [FlightBookingController::class, 'store']);
		Route::get('/flight-bookings/{flightBooking}', [FlightBookingController::class, 'show']);
		Route::patch('/flight-bookings/{flightBooking}/cancel', [FlightBookingController::class, 'cancel']);
	});
});
