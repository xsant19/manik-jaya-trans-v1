<?php

namespace App\Providers;

use App\Models\Payment;
use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use App\Observers\BookingObserver;
use App\Observers\BookingStockObserver;
use App\Observers\PaymentObserver;
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
        RentalBooking::observe(BookingObserver::class);
        TourBooking::observe(BookingObserver::class);
        TransferBooking::observe(BookingObserver::class);
        ShuttleBooking::observe(BookingObserver::class);

        // NEW: Stock management observers
        Payment::observe(PaymentObserver::class);

        RentalBooking::observe(BookingStockObserver::class);
        TourBooking::observe(BookingStockObserver::class);
        TransferBooking::observe(BookingStockObserver::class);
        ShuttleBooking::observe(BookingStockObserver::class);
    }
}
