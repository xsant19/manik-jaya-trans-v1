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
    public function store(Request $request, $type, $bookingCode, PaymentService $paymentService)
    {
        $models = [
            'rental' => RentalBooking::class,
            'tour' => TourBooking::class,
            'transfer' => TransferBooking::class,
            'shuttle' => ShuttleBooking::class,
        ];

        if (! array_key_exists($type, $models)) {
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

    public function failed(Request $request)
    {
        return view('frontend.payment.failed');
    }
}
