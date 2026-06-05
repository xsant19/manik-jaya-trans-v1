<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShuttleBookingRequest;
use App\Models\HotelShuttle;
use App\Models\ShuttleBooking;
use App\Services\BookingCodeService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShuttleBookingController extends Controller
{
    protected $bookingCodeService;

    public function __construct(BookingCodeService $bookingCodeService)
    {
        $this->bookingCodeService = $bookingCodeService;
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
        $bookingCode = $this->bookingCodeService->generate('SHT', ShuttleBooking::class);

        $shuttleBooking = ShuttleBooking::create([
            'user_id' => auth()->id(),
            'hotel_shuttle_id' => $shuttle->id,
            'booking_code' => $bookingCode,
            'booking_date' => Carbon::parse($validated['booking_date'])->format('Y-m-d'),
            'passenger_count' => $validated['passenger_count'],
            'pickup_time' => $validated['pickup_time'] ?? null,
            'note' => $validated['note'] ?? null,
            'total_price' => $totalPrice,
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\BookingCreatedMail($shuttleBooking));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send email: ' . $e->getMessage());
        }

        return redirect()->route('customer.shuttles.show', $shuttleBooking)->with('success', 'Booking Hotel Shuttle berhasil dibuat!');
    }

    public function show(ShuttleBooking $shuttleBooking)
    {
        abort_if($shuttleBooking->user_id != auth()->id(), 403, 'Unauthorized access to this booking.');

        return view('frontend.booking.shuttles.show', compact('shuttleBooking'));
    }
}
