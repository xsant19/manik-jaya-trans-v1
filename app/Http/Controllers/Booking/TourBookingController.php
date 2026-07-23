<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourBookingRequest;
use App\Mail\AdminBookingNotification;
use App\Mail\BookingCreatedMail;
use App\Models\TourBooking;
use App\Models\TourPackage;
use App\Services\BookingCodeService;
use App\Services\CouponService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TourBookingController extends Controller
{
    protected $bookingCodeService;
    protected $couponService;

    public function __construct(BookingCodeService $bookingCodeService, CouponService $couponService)
    {
        $this->bookingCodeService = $bookingCodeService;
        $this->couponService = $couponService;
    }

    public function create(TourPackage $tour)
    {
        abort_if($tour->status !== 'active', 404);

        return view('frontend.booking.tours.create', compact('tour'));
    }

    public function store(StoreTourBookingRequest $request, TourPackage $tour)
    {
        abort_if($tour->status !== 'active', 404);

        $validated = $request->validated();

        $totalPrice = $tour->price * $validated['participant_count'];

        // ─── Logika Kupon Diskon ──────────────────────────────────────────────
        $originalPrice     = (float) $totalPrice;
        $discountAmount    = 0.0;
        $couponId          = null;
        $appliedCouponCode = null;
        $coupon            = null;

        if (! empty($validated['coupon_code'])) {
            $couponResult = $this->couponService->validate(
                $validated['coupon_code'],
                (float) $totalPrice,
            );

            if ($couponResult['valid']) {
                $coupon            = $couponResult['coupon'];
                $discountAmount    = $couponResult['discount'];
                $totalPrice        = $originalPrice - $discountAmount;
                $couponId          = $coupon->id;
                $appliedCouponCode = $coupon->code;
            } else {
                return back()->withErrors(['coupon_code' => $couponResult['message']])->withInput();
            }
        }
        // ─────────────────────────────────────────────────────────────────────

        $bookingCode = $this->bookingCodeService->generate('TOUR', TourBooking::class);

        $tourBooking = TourBooking::create([
            'user_id'          => auth()->id(),
            'tour_package_id'  => $tour->id,
            'booking_code'     => $bookingCode,
            'booking_date'     => Carbon::parse($validated['booking_date'])->format('Y-m-d'),
            'participant_count'=> $validated['participant_count'],
            'note'             => $validated['note'] ?? null,
            'total_price'      => $totalPrice,
            'booking_status'   => 'pending',
            'payment_status'   => 'unpaid',
            'coupon_id'        => $couponId,
            'coupon_code'      => $appliedCouponCode,
            'discount_amount'  => $discountAmount,
            'original_price'   => $discountAmount > 0 ? $originalPrice : null,
        ]);

        // Tandai kupon sebagai terpakai SETELAH booking berhasil disimpan
        if ($coupon) {
            $this->couponService->apply($coupon);
        }

        // Send email to customer
        try {
            Mail::to(auth()->user()->email)->send(new BookingCreatedMail($tourBooking));
        } catch (\Exception $e) {
            Log::error('Failed to send booking created email to customer: '.$e->getMessage());
        }

        // Send email notification to admin
        try {
            $adminEmail = config('mail.admin_email');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new AdminBookingNotification($tourBooking, 'tour'));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send booking notification email to admin: '.$e->getMessage());
        }

        return redirect()->route('customer.tours.show', $tourBooking)->with('success', 'Booking Paket Wisata berhasil dibuat!');
    }

    public function show(TourBooking $tourBooking)
    {
        abort_if($tourBooking->user_id != auth()->id(), 403, 'Unauthorized access to this booking.');

        return view('frontend.booking.tours.show', compact('tourBooking'));
    }
}
