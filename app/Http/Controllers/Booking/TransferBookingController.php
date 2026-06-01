<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransferBookingRequest;
use App\Models\AirportTransfer;
use App\Models\TransferBooking;
use App\Services\BookingCodeService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransferBookingController extends Controller
{
    protected $bookingCodeService;

    public function __construct(BookingCodeService $bookingCodeService)
    {
        $this->bookingCodeService = $bookingCodeService;
    }

    public function create(AirportTransfer $transfer)
    {
        abort_if($transfer->status !== 'active', 404);
        
        return view('frontend.booking.transfers.create', compact('transfer'));
    }

    public function store(StoreTransferBookingRequest $request, AirportTransfer $transfer)
    {
        abort_if($transfer->status !== 'active', 404);

        $validated = $request->validated();
        
        $totalPrice = $transfer->price;
        $bookingCode = $this->bookingCodeService->generate('TRF', TransferBooking::class);

        $transferBooking = TransferBooking::create([
            'user_id' => auth()->id(),
            'airport_transfer_id' => $transfer->id,
            'booking_code' => $bookingCode,
            'booking_date' => Carbon::parse($validated['booking_date'])->format('Y-m-d'),
            'passenger_count' => $validated['passenger_count'],
            'flight_number' => $validated['flight_number'] ?? null,
            'pickup_time' => $validated['pickup_time'] ?? null,
            'note' => $validated['note'] ?? null,
            'total_price' => $totalPrice,
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\BookingCreatedMail($transferBooking));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send email: ' . $e->getMessage());
        }

        return redirect()->route('customer.transfers.show', $transferBooking)->with('success', 'Booking Airport Transfer berhasil dibuat!');
    }

    public function show(TransferBooking $transferBooking)
    {
        abort_if($transferBooking->user_id !== auth()->id(), 403, 'Unauthorized access to this booking.');
        
        return view('frontend.booking.transfers.show', compact('transferBooking'));
    }
}
