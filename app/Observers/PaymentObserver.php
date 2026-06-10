<?php

namespace App\Observers;

use App\Models\Payment;
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
            Log::info("Payment {$payment->id} status changed to 'paid'. Reducing stock for booking.");

            // Get the booking (polymorphic relationship)
            $booking = $payment->payable;

            if (!$booking) {
                Log::warning("Payment {$payment->id} has no associated booking.");
                return;
            }

            // Reduce stock for the booking
            $this->stockService->reduceStockForBooking($booking);
        }
    }
}
