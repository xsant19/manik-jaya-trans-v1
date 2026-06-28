<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;

class BookingHistoryController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $rentals = RentalBooking::where('user_id', $userId)->get()->map(function ($i) {
            $i->type_label = 'Sewa Kendaraan';
            $i->type = 'rental';
            $i->detail_route = route('customer.rental.show', $i->booking_code);

            return $i;
        });
        $tours = TourBooking::where('user_id', $userId)->get()->map(function ($i) {
            $i->type_label = 'Paket Wisata';
            $i->type = 'tour';
            $i->detail_route = route('customer.tours.show', $i->booking_code);

            return $i;
        });
        $transfers = TransferBooking::where('user_id', $userId)->get()->map(function ($i) {
            $i->type_label = 'Airport Transfer';
            $i->type = 'transfer';
            $i->detail_route = route('customer.transfers.show', $i->booking_code);

            return $i;
        });
        $shuttles = ShuttleBooking::where('user_id', $userId)->get()->map(function ($i) {
            $i->type_label = 'Hotel Shuttle';
            $i->type = 'shuttle';
            $i->detail_route = route('customer.shuttles.show', $i->booking_code);

            return $i;
        });

        $bookings = $rentals->concat($tours)->concat($transfers)->concat($shuttles)->sortByDesc('created_at');

        return view('frontend.dashboard.history', compact('bookings'));
    }

    public function cancel($type, $booking_code)
    {
        $userId = auth()->id();
        $model = match ($type) {
            'rental' => RentalBooking::class,
            'tour' => TourBooking::class,
            'transfer' => TransferBooking::class,
            'shuttle' => ShuttleBooking::class,
            default => abort(404),
        };

        $booking = $model::where('booking_code', $booking_code)->firstOrFail();

        if ($booking->user_id !== $userId) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($booking->payment_status, ['unpaid', 'pending'])) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan karena sudah dibayar atau kedaluwarsa.');
        }

        if ($booking->booking_status === 'canceled') {
            return back()->with('error', 'Pesanan ini sudah dibatalkan.');
        }

        $booking->update([
            'booking_status' => 'canceled'
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
