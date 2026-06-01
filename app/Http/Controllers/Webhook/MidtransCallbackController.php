<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $payload = $request->all();
            $serverKey = config('midtrans.server_key');
            
            $orderId = $payload['order_id'] ?? '';
            $statusCode = $payload['status_code'] ?? '';
            $grossAmount = $payload['gross_amount'] ?? '';
            $signatureKey = $payload['signature_key'] ?? '';

            // Validate Signature Key
            $mySignatureKey = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signatureKey !== $mySignatureKey) {
                return response()->json(['message' => 'Invalid signature'], 400);
            }

            $payment = \App\Models\Payment::where('transaction_id', $orderId)->first();
            if (!$payment) {
                return response()->json(['message' => 'Payment not found'], 404);
            }

            // Validate gross_amount match
            if ((float) $grossAmount !== (float) $payment->gross_amount) {
                return response()->json(['message' => 'Invalid amount'], 400);
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
                $payment->payable->update([
                    'payment_status' => $newStatus,
                ]);

                if ($newStatus === 'paid') {
                    try {
                        \Illuminate\Support\Facades\Mail::to($payment->payable->user->email)->send(new \App\Mail\PaymentSuccessMail($payment->payable));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Failed to send payment success email: ' . $e->getMessage());
                    }
                }
            }

            return response()->json(['message' => 'Success']);
            
        } catch (\Exception $e) {
            // Don't expose error details
            return response()->json(['message' => 'Server error'], 500);
        }
    }
}
