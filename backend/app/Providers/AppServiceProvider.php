<?php

namespace App\Providers;

use App\Interfaces\FlightBookingInterface;
use App\Interfaces\FlightDataImportInterface;
use App\Services\FlightBookingService;
use App\Services\FlightDataImportAmadeusService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FlightDataImportInterface::class, FlightDataImportAmadeusService::class);
		$this->app->bind(FlightBookingInterface::class, FlightBookingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
