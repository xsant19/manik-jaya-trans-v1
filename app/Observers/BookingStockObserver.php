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
     * Handle booking "created" event.
     * Untuk RentalBooking: stok langsung dikurangi sebagai hold sementara (30 menit).
     * Hold akan menjadi permanen jika payment berhasil, atau dikembalikan jika expired/dibatalkan.
     */
    public function created(Model $booking): void
    {
        // For RentalBooking, stock is immediately reduced as a temporary hold
        if ($booking instanceof \App\Models\RentalBooking) {
            Log::info("RentalBooking {$booking->booking_code} created. Holding stock for 30 minutes (reserved_until: {$booking->reserved_until}).");
            $this->stockService->reduceStockForBooking($booking);
        }
    }

    /**
     * Handle booking "updated" event
     * Monitors booking_status changes for stock return
     */
    public function updated(Model $booking): void
    {
        // Handle vehicle assignment (for Tour, Shuttle, Transfer)
        if ($booking->isDirty('vehicle_id')) {
            $oldVehicleId = $booking->getOriginal('vehicle_id');
            $newVehicleId = $booking->vehicle_id;

            if ($oldVehicleId && $newVehicleId && $oldVehicleId !== $newVehicleId) {
                // Reassigned to a different vehicle
                Log::info("Booking {$booking->booking_code} reassigned from vehicle {$oldVehicleId} to {$newVehicleId}");
                $this->stockService->returnStockForVehicle($booking, $oldVehicleId);
                $this->stockService->reduceStockForBooking($booking);
            } elseif (! $oldVehicleId && $newVehicleId) {
                // Assigned for the first time
                Log::info("Booking {$booking->booking_code} assigned to vehicle {$newVehicleId}");
                $this->stockService->reduceStockForBooking($booking);
            } elseif ($oldVehicleId && ! $newVehicleId) {
                // Unassigned
                Log::info("Booking {$booking->booking_code} unassigned from vehicle {$oldVehicleId}");
                $this->stockService->returnStockForVehicle($booking, $oldVehicleId);
            }
        }

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
