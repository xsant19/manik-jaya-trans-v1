<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Mail\PaymentSuccessMail;
use App\Models\Payment;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        Log::info($request->all());
        try {
            $payload = $request->all();
            $serverKey = config('midtrans.server_key');

            $orderId = $payload['order_id'] ?? '';
            $statusCode = $payload['status_code'] ?? '';
            $grossAmount = $payload['gross_amount'] ?? '';
            $signatureKey = $payload['signature_key'] ?? '';

            // Validate Signature Key
            $mySignatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

            if ($signatureKey !== $mySignatureKey) {
                throw new Error('Invalid signature');
            }

            $payment = Payment::where('transaction_id', $orderId)->first();
            if (! $payment) {
                throw new Error('Payment not found');
            }

            // Validate gross_amount match
            if ((float) $grossAmount !== (float) $payment->gross_amount) {
                throw new Error('Invalid amount');
            }

            $transactionStatus = $payload['transaction_status'] ?? '';

            $statusMap = [
                'settlement' => 'paid',
                'capture' => 'paid',
                'pending' => 'pending',
                'expire' => 'expired',
                'cancel' => 'failed',
                'deny' => 'failed',
                'failure' => 'failed',
                'refund' => 'refunded',
            ];

            $newStatus = $statusMap[$transactionStatus] ?? 'pending';

            // Idempotent check
            if ($payment->status === $newStatus) {
                return response()->json(['message' => 'Already processed']);
            }

            // Update payment record
            $payment->update([
                'status' => $newStatus,
                'raw_response' => array_merge($payment->raw_response ?? [], ['callback' => $payload]),
                'paid_at' => $newStatus === 'paid' ? now() : $payment->paid_at,
            ]);

            // Update booking status
            if ($payment->payable) {
                $updateData = [
                    'payment_status' => $newStatus,
                ];

                if (in_array($newStatus, ['failed', 'expired', 'refunded'])) {
                    $updateData['booking_status'] = 'canceled';
                }

                $payment->payable->update($updateData);

                if ($newStatus === 'paid') {
                    try {
                        Mail::to($payment->payable->user->email)->send(new PaymentSuccessMail($payment->payable));
                    } catch (\Exception $e) {
                        Log::error('Failed to send payment success email: '.$e->getMessage());
                    }
                }
            }

            return response()->json(['message' => 'Success']);

        } catch (\Exception $e) {
            // Don't expose error details
            Log::error($e);

            return response()->json(['message' => 'Server error'], 500);
        }
    }
}
