<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourBookingRequest;
use App\Models\TourBooking;
use App\Models\TourPackage;
use App\Services\BookingCodeService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TourBookingController extends Controller
{
    protected $bookingCodeService;

    public function __construct(BookingCodeService $bookingCodeService)
    {
        $this->bookingCodeService = $bookingCodeService;
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
        $bookingCode = $this->bookingCodeService->generate('TOUR', TourBooking::class);

        $tourBooking = TourBooking::create([
            'user_id' => auth()->id(),
            'tour_package_id' => $tour->id,
            'booking_code' => $bookingCode,
            'booking_date' => Carbon::parse($validated['booking_date'])->format('Y-m-d'),
            'participant_count' => $validated['participant_count'],
            'note' => $validated['note'] ?? null,
            'total_price' => $totalPrice,
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\BookingCreatedMail($tourBooking));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send email: ' . $e->getMessage());
        }

        return redirect()->route('customer.tours.show', $tourBooking)->with('success', 'Booking Paket Wisata berhasil dibuat!');
    }

    public function show(TourBooking $tourBooking)
    {
        abort_if($tourBooking->user_id !== auth()->id(), 403, 'Unauthorized access to this booking.');
        
        return view('frontend.booking.tours.show', compact('tourBooking'));
    }
}
