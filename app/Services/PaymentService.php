<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Exception;

class PaymentService
{
    /**
     * Create a new payment record for a booking and return Midtrans Snap URL.
     */
    public function createPaymentForBooking(Model $booking)
    {
        // 1. Check if booking belongs to current user
        if ($booking->user_id !== auth()->id()) {
            throw new Exception("Unauthorized access to booking.");
        }

        // 2. Check if booking is canceled
        if ($booking->booking_status === 'canceled') {
            throw new Exception("Cannot pay for a canceled booking.");
        }

        // 3. Check if booking is already paid
        if ($booking->payment_status === 'paid') {
            throw new Exception("This booking is already paid.");
        }

        // 4. Check if there's already a pending payment with a valid snap URL
        $existingPayment = Payment::where('payable_type', get_class($booking))
            ->where('payable_id', $booking->id)
            ->whereIn('status', ['pending'])
            ->first();

        if ($existingPayment && !empty($existingPayment->raw_response['redirect_url'] ?? null)) {
            return $existingPayment->raw_response['redirect_url'];
        }

        // Configure Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $transactionId = 'TRX-' . time() . '-' . strtoupper(Str::random(5));
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
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            // Midtrans PHP library actually doesn't return redirect_url from getSnapToken by default,
            // we should use createTransaction() to get redirect_url
            $snapTransaction = \Midtrans\Snap::createTransaction($params);
            
            $redirectUrl = $snapTransaction->redirect_url;
            
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
                    'token' => $snapTransaction->token,
                    'redirect_url' => $redirectUrl,
                ],
            ]);

            return $redirectUrl;

        } catch (Exception $e) {
            throw new Exception("Midtrans Error: " . $e->getMessage());
        }
    }
}

