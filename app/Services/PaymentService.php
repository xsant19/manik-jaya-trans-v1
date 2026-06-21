<?php

namespace App\Services;

use App\Models\Payment;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentService
{
    /**
     * Create a new payment record for a booking and return Midtrans Snap Token.
     * Used by Snap JS Pop Up mode — only snap_token is needed, not redirect_url.
     */
    public function createPaymentForBooking(Model $booking): string
    {
        // 1. Check if booking belongs to current user
        if ($booking->user_id != auth()->id()) {
            throw new Exception('Unauthorized access to booking.');
        }

        // 2. Check if booking is canceled
        if ($booking->booking_status === 'canceled') {
            throw new Exception('Cannot pay for a canceled booking.');
        }

        // 3. Check if booking is already paid
        if ($booking->payment_status === 'paid') {
            throw new Exception('This booking is already paid.');
        }

        // 4. Re-use existing pending payment token if still available
        $existingPayment = Payment::where('payable_type', get_class($booking))
            ->where('payable_id', $booking->id)
            ->where('status', 'pending')
            ->first();

        if ($existingPayment && ! empty($existingPayment->raw_response['token'] ?? null)) {
            return $existingPayment->raw_response['token'];
        }

        // 5. Configure Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $transactionId = 'TRX-'.time().'-'.strtoupper(Str::random(5));
        $grossAmount = (int) $booking->total_price;

        $params = [
            'transaction_details' => [
                'order_id' => $transactionId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone ?? '',
            ],
        ];

        try {
            // Only call getSnapToken — sufficient for Snap JS Pop Up
            $snapToken = Snap::getSnapToken($params);

            // Create new payment record
            Payment::create([
                'user_id' => $booking->user_id,
                'payable_type' => get_class($booking),
                'payable_id' => $booking->id,
                'booking_code' => $booking->booking_code,
                'payment_method' => 'midtrans',
                'payment_gateway' => 'midtrans',
                'transaction_id' => $transactionId,
                'gross_amount' => $grossAmount,
                'status' => 'pending',
                'raw_response' => [
                    'token' => $snapToken,
                ],
            ]);

            return $snapToken;

        } catch (Exception $e) {
            throw new Exception('Midtrans Error: '.$e->getMessage());
        }
    }
}
