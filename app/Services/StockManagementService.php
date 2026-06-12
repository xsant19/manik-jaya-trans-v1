<?php

namespace App\Services;

use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use App\Models\VehicleInventory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StockManagementService
{
    /**
     * Reduce stock physically in database
     */
    public function reduceStockForBooking($booking): void
    {
        $vehicle = $booking->vehicle;

        if (! $vehicle) {
            Log::warning("Booking {$booking->booking_code} has no vehicle assigned. Stock not reduced.");

            return;
        }

        $dates = $this->getBookingDates($booking);

        foreach ($dates as $date) {
            $inventory = $vehicle->getInventoryForDate($date);

            if (! $inventory) {
                Log::warning("No inventory found for vehicle {$vehicle->id} on {$date->toDateString()}. Stock not reduced.");

                continue;
            }

            if ($inventory->stock > 0) {
                $inventory->decrement('stock');
                Log::info("Stock physically reduced for vehicle {$vehicle->id} on {$date->toDateString()} due to booking {$booking->booking_code}");
            } else {
                Log::warning("Failed to reduce stock for vehicle {$vehicle->id} on {$date->toDateString()}: stock is already 0.");
            }
        }
    }

    /**
     * Return stock physically in database when booking is canceled
     */
    public function returnStockForCancellation($booking): void
    {
        $vehicle = $booking->vehicle;

        if (! $vehicle) {
            return;
        }

        $dates = $this->getBookingDates($booking);

        foreach ($dates as $date) {
            $inventory = $vehicle->getInventoryForDate($date);
            if ($inventory) {
                $inventory->increment('stock');
                Log::info("Stock physically returned for vehicle {$vehicle->id} on {$date->toDateString()} due to cancellation of booking {$booking->booking_code}");
            }
        }
    }

    /**
     * Return stock physically in database for a specific vehicle (e.g. when reassigned)
     */
    public function returnStockForVehicle($booking, $vehicleId): void
    {
        $vehicle = \App\Models\Vehicle::find($vehicleId);

        if (! $vehicle) {
            return;
        }

        $dates = $this->getBookingDates($booking);

        foreach ($dates as $date) {
            $inventory = $vehicle->getInventoryForDate($date);
            if ($inventory) {
                $inventory->increment('stock');
                Log::info("Stock physically returned for old vehicle {$vehicle->id} on {$date->toDateString()} due to reassignment of booking {$booking->booking_code}");
            }
        }
    }

    /**
     * Return stock for same-day completed bookings (shuttle/transfer)
     */
    public function returnStockForSameDayCompletion($booking): void
    {
        $vehicle = $booking->vehicle;

        if (! $vehicle || ! $booking->completed_at) {
            return;
        }

        // Only for short-duration bookings (shuttle/transfer)
        $isShortDuration = $this->isShortDurationBooking($booking);

        if (! $isShortDuration) {
            Log::info("Booking {$booking->booking_code} is multi-day, no same-day stock return.");

            return;
        }

        // Check if completed on the same day as booking date
        $bookingDate = $this->getBookingStartDate($booking);
        $completedDate = Carbon::parse($booking->completed_at);

        if ($bookingDate->isSameDay($completedDate)) {
            $inventory = $vehicle->getInventoryForDate($bookingDate);
            if ($inventory) {
                $inventory->increment('stock');
                Log::info("Stock physically returned for vehicle {$vehicle->id} on {$bookingDate->toDateString()} due to same-day completion of booking {$booking->booking_code}");
            }
        }
    }

    /**
     * Get all dates affected by a booking
     */
    private function getBookingDates($booking): array
    {
        $dates = [];

        if ($booking instanceof RentalBooking) {
            // Rental: multiple days from start to end
            $currentDate = Carbon::parse($booking->start_date);
            $endDate = Carbon::parse($booking->end_date);

            while ($currentDate->lte($endDate)) {
                $dates[] = $currentDate->copy();
                $currentDate->addDay();
            }
        } elseif ($booking instanceof TourBooking) {
            // Tour: could be single or multiple days (use booking_date)
            $dates[] = Carbon::parse($booking->booking_date);
        } elseif ($booking instanceof TransferBooking) {
            // Transfer: single day (booking_date)
            $dates[] = Carbon::parse($booking->booking_date);
        } elseif ($booking instanceof ShuttleBooking) {
            // Shuttle: single day (booking_date)
            $dates[] = Carbon::parse($booking->booking_date);
        }

        return $dates;
    }

    /**
     * Get booking start date
     */
    private function getBookingStartDate($booking): Carbon
    {
        if ($booking instanceof RentalBooking) {
            return Carbon::parse($booking->start_date);
        } elseif ($booking instanceof TourBooking) {
            return Carbon::parse($booking->booking_date);
        } elseif ($booking instanceof TransferBooking) {
            return Carbon::parse($booking->booking_date);
        } elseif ($booking instanceof ShuttleBooking) {
            return Carbon::parse($booking->booking_date);
        }

        return now();
    }

    /**
     * Check if booking is short duration (shuttle/transfer typically 1-3 hours)
     */
    private function isShortDurationBooking($booking): bool
    {
        return $booking instanceof ShuttleBooking || $booking instanceof TransferBooking;
    }
}
