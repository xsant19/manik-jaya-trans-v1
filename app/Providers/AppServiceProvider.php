<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\RentalBooking::observe(\App\Observers\BookingObserver::class);
        \App\Models\TourBooking::observe(\App\Observers\BookingObserver::class);
        \App\Models\TransferBooking::observe(\App\Observers\BookingObserver::class);
        \App\Models\ShuttleBooking::observe(\App\Observers\BookingObserver::class);
    }
}
