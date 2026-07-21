<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\RentalBooking;
use App\Services\StockManagementService;
use Illuminate\Support\Facades\Log;

class PaymentObserver
{
    protected $stockService;

    public function __construct(StockManagementService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * Handle the Payment "updated" event.
     * Triggered when payment status changes to 'paid'
     */
    public function updated(Payment $payment): void
    {
        // Check if status was changed to 'paid'
        if ($payment->isDirty('status') && $payment->status === 'paid') {
            $booking = $payment->payable;

            if (! $booking) {
                Log::warning("Payment {$payment->id} has no associated booking.");

                return;
            }

            if ($booking instanceof RentalBooking) {
                // RentalBooking: stok sudah dikurangi saat booking dibuat (hold sistem).
                // Saat payment paid, hold menjadi permanen — null-kan reserved_until.
                Log::info("Payment {$payment->id} paid for RentalBooking {$booking->booking_code}. Hold confirmed permanent. Clearing reserved_until.");
                $booking->saveQuietly(['reserved_until' => null]);
            } else {
                // Tour / Transfer / Shuttle: kurangi stok saat payment paid
                // (vehicle_id diisi admin, baru berkurang saat vehicle diassign & paid)
                Log::info("Payment {$payment->id} paid for booking {$booking->booking_code}. Reducing stock.");
                $this->stockService->reduceStockForBooking($booking);
            }
        }
    }
}

