<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, $type, $bookingCode, \App\Services\PaymentService $paymentService)
    {
        $models = [
            'rental' => \App\Models\RentalBooking::class,
            'tour' => \App\Models\TourBooking::class,
            'transfer' => \App\Models\TransferBooking::class,
            'shuttle' => \App\Models\ShuttleBooking::class,
        ];

        if (!array_key_exists($type, $models)) {
            abort(404);
        }

        $modelClass = $models[$type];
        $booking = $modelClass::where('booking_code', $bookingCode)->firstOrFail();

        try {
            $redirectUrl = $paymentService->createPaymentForBooking($booking);
            return redirect($redirectUrl);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
