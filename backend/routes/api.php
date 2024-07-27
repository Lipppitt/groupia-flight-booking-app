<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/user', function (Request $request) {
        if (auth('sanctum')->check()) {
            return auth('sanctum')->user();
        }
        return null;
    });

    Route::get('/flights', [\App\Http\Controllers\FlightController::class, 'index']);
});
