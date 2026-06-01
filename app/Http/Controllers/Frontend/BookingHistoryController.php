<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use Illuminate\Http\Request;

class BookingHistoryController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $rentals = RentalBooking::where('user_id', $userId)->get()->map(function($i) { $i->type_label = 'Sewa Kendaraan'; $i->detail_route = route('customer.rental.show', $i->booking_code); return $i; });
        $tours = TourBooking::where('user_id', $userId)->get()->map(function($i) { $i->type_label = 'Paket Wisata'; $i->detail_route = route('customer.tours.show', $i->booking_code); return $i; });
        $transfers = TransferBooking::where('user_id', $userId)->get()->map(function($i) { $i->type_label = 'Airport Transfer'; $i->detail_route = route('customer.transfers.show', $i->booking_code); return $i; });
        $shuttles = ShuttleBooking::where('user_id', $userId)->get()->map(function($i) { $i->type_label = 'Hotel Shuttle'; $i->detail_route = route('customer.shuttles.show', $i->booking_code); return $i; });

        $bookings = $rentals->concat($tours)->concat($transfers)->concat($shuttles)->sortByDesc('created_at');

        return view('frontend.dashboard.history', compact('bookings'));
    }
}
