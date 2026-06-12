<?php

namespace App\Observers;

use App\Services\StockManagementService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Observer for all booking models to handle stock return
 * Applies to: RentalBooking, TourBooking, TransferBooking, ShuttleBooking
 */
class BookingStockObserver
{
    protected $stockService;

    public function __construct(StockManagementService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * Handle booking "updated" event
     * Monitors booking_status changes for stock return
     */
    public function updated(Model $booking): void
    {
        // Check if booking_status was changed
        if ($booking->isDirty('booking_status')) {
            $oldStatus = $booking->getOriginal('booking_status');
            $newStatus = $booking->booking_status;

            Log::info("Booking {$booking->booking_code} status changed from {$oldStatus} to {$newStatus}");

            // Handle cancellation: return stock if payment was paid
            if ($newStatus === 'canceled') {
                Log::info("Booking {$booking->booking_code} canceled. Checking stock return.");
                $this->stockService->returnStockForCancellation($booking);
            }

            // Handle completion: return stock for same-day short duration bookings
            if ($newStatus === 'completed') {
                Log::info("Booking {$booking->booking_code} completed. Checking same-day stock return.");

                // Set completed_at if not already set
                if (! $booking->completed_at) {
                    $booking->completed_at = now();
                    $booking->saveQuietly(); // Save without triggering observer again
                }

                $this->stockService->returnStockForSameDayCompletion($booking);
            }

            // Handle reopening: if status changed FROM completed to something else
            if ($oldStatus === 'completed' && $newStatus !== 'completed') {
                Log::info("Booking {$booking->booking_code} reverted from completed. Nullifying completed_at.");
                $booking->completed_at = null;
                $booking->saveQuietly();
            }
        }
    }
}
