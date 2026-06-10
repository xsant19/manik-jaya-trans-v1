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
        // Existing booking observer for email notifications
        \App\Models\RentalBooking::observe(\App\Observers\BookingObserver::class);
        \App\Models\TourBooking::observe(\App\Observers\BookingObserver::class);
        \App\Models\TransferBooking::observe(\App\Observers\BookingObserver::class);
        \App\Models\ShuttleBooking::observe(\App\Observers\BookingObserver::class);

        // NEW: Stock management observers
        \App\Models\Payment::observe(\App\Observers\PaymentObserver::class);

        \App\Models\RentalBooking::observe(\App\Observers\BookingStockObserver::class);
        \App\Models\TourBooking::observe(\App\Observers\BookingStockObserver::class);
        \App\Models\TransferBooking::observe(\App\Observers\BookingStockObserver::class);
        \App\Models\ShuttleBooking::observe(\App\Observers\BookingStockObserver::class);
    }
}
