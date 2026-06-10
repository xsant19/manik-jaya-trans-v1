<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRentalBookingRequest;
use App\Models\Driver;
use App\Models\RentalBooking;
use App\Models\Vehicle;
use App\Services\BookingCodeService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalBookingController extends Controller
{
    protected $bookingCodeService;

    public function __construct(BookingCodeService $bookingCodeService)
    {
        $this->bookingCodeService = $bookingCodeService;
    }

    public function create(Vehicle $vehicle)
    {
        return view('frontend.booking.rental.create', compact('vehicle'));
    }

    public function checkAvailability(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'rental_type' => 'required|in:full_day,half_day',
        ]);

        $startDate = Carbon::parse($request->start_date);
        
        if ($request->rental_type === 'half_day') {
            $endDate = $startDate->copy();
        } else {
            $endDate = $request->end_date ? Carbon::parse($request->end_date) : $startDate->copy();
        }

        if ($vehicle->isAvailableForDateRange($startDate, $endDate)) {
            return response()->json([
                'available' => true,
                'message' => '✅ Kendaraan tersedia untuk tanggal tersebut!',
            ]);
        }

        return response()->json([
            'available' => false,
            'message' => '❌ Maaf, kendaraan tidak tersedia/habis pada rentang tanggal tersebut.',
        ]);
    }

    public function store(StoreRentalBookingRequest $request, Vehicle $vehicle)
    {
        $validated = $request->validated();

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = isset($validated['end_date']) ? Carbon::parse($validated['end_date']) : $startDate->copy();

        if (!$vehicle->isAvailableForDateRange($startDate, $endDate)) {
            return back()->withErrors(['start_date' => 'Kendaraan tidak tersedia untuk tanggal tersebut.'])->withInput();
        }

        if ($validated['rental_type'] === 'half_day') {
            $totalPrice = $vehicle->price_half_day;
            $endDate = $startDate->copy(); // Half day is always same day
        } else {
            // Calculate days inclusive (e.g. 1st to 1st = 1 day, 1st to 2nd = 2 days)
            $days = $startDate->diffInDays($endDate) + 1;
            $totalPrice = $vehicle->price_full_day * $days;
        }

        $bookingCode = $this->bookingCodeService->generate('RNT', RentalBooking::class);

        $rentalBooking = RentalBooking::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $vehicle->id,
            'driver_id' => null, // Driver will be assigned by admin
            'booking_code' => $bookingCode,
            'rental_type' => $validated['rental_type'],
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'pickup_location' => $validated['pickup_location'],
            'note' => $validated['note'] ?? null,
            'total_price' => $totalPrice,
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        // Send email to customer
        try {
            \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\BookingCreatedMail($rentalBooking));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send customer email: ' . $e->getMessage());
        }

        // Send notification to admin/company
        try {
            $adminEmail = config('mail.admin_email', env('MAIL_ADMIN_ADDRESS', 'manikjayatrans@gmail.com'));
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\AdminBookingNotification($rentalBooking, 'rental'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send admin notification email: ' . $e->getMessage());
        }

        return redirect()->route('customer.rental.show', $rentalBooking)->with('success', 'Booking berhasil dibuat!');
    }

    public function show(RentalBooking $rental)
    {
        abort_if($rental->user_id != auth()->id(), 403, 'Unauthorized access to this booking.');

        return view('frontend.booking.rental.show', compact('rental'));
    }
}
