<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Create Midtrans payment and return snap_token as JSON.
     * Used by Snap JS Pop Up mode on the booking detail pages.
     */
    public function store(Request $request, $type, $bookingCode, PaymentService $paymentService)
    {
        $models = [
            'rental'   => RentalBooking::class,
            'tour'     => TourBooking::class,
            'transfer' => TransferBooking::class,
            'shuttle'  => ShuttleBooking::class,
        ];

        if (! array_key_exists($type, $models)) {
            abort(404);
        }

        $modelClass = $models[$type];
        $booking = $modelClass::where('booking_code', $bookingCode)->firstOrFail();

        try {
            $snapToken = $paymentService->createPaymentForBooking($booking);

            return response()->json([
                'snap_token' => $snapToken,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    public function failed(Request $request)
    {
        return view('frontend.payment.failed');
    }
}
