<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShuttleBookingRequest;
use App\Mail\AdminBookingNotification;
use App\Mail\BookingCreatedMail;
use App\Models\HotelShuttle;
use App\Models\ShuttleBooking;
use App\Services\BookingCodeService;
use App\Services\CouponService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ShuttleBookingController extends Controller
{
    protected $bookingCodeService;
    protected $couponService;

    public function __construct(BookingCodeService $bookingCodeService, CouponService $couponService)
    {
        $this->bookingCodeService = $bookingCodeService;
        $this->couponService = $couponService;
    }

    public function create(HotelShuttle $shuttle)
    {
        abort_if($shuttle->status !== 'active', 404);

        return view('frontend.booking.shuttles.create', compact('shuttle'));
    }

    public function store(StoreShuttleBookingRequest $request, HotelShuttle $shuttle)
    {
        abort_if($shuttle->status !== 'active', 404);

        $validated = $request->validated();

        $totalPrice = $shuttle->price * $validated['passenger_count'];

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

        $bookingCode = $this->bookingCodeService->generate('SHT', ShuttleBooking::class);

        $shuttleBooking = ShuttleBooking::create([
            'user_id'          => auth()->id(),
            'hotel_shuttle_id' => $shuttle->id,
            'booking_code'     => $bookingCode,
            'booking_date'     => Carbon::parse($validated['booking_date'])->format('Y-m-d'),
            'passenger_count'  => $validated['passenger_count'],
            'pickup_time'      => $validated['pickup_time'] ?? null,
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
            Mail::to(auth()->user()->email)->send(new BookingCreatedMail($shuttleBooking));
        } catch (\Exception $e) {
            Log::error('Failed to send booking created email to customer: '.$e->getMessage());
        }

        // Send email notification to admin
        try {
            $adminEmail = config('mail.admin_email');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new AdminBookingNotification($shuttleBooking, 'shuttle'));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send booking notification email to admin: '.$e->getMessage());
        }

        return redirect()->route('customer.shuttles.show', $shuttleBooking)->with('success', 'Booking Hotel Shuttle berhasil dibuat!');
    }

    public function show(ShuttleBooking $shuttleBooking)
    {
        abort_if($shuttleBooking->user_id != auth()->id(), 403, 'Unauthorized access to this booking.');

        return view('frontend.booking.shuttles.show', compact('shuttleBooking'));
    }
}
