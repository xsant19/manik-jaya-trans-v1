<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Ambil semua booking user
        $rentals = RentalBooking::where('user_id', $userId)->get()->map(function ($i) {
            $i->type_label = 'Sewa Kendaraan';
            $i->detail_route = route('customer.rental.show', $i);

            return $i;
        });
        $tours = TourBooking::where('user_id', $userId)->get()->map(function ($i) {
            $i->type_label = 'Paket Wisata';
            $i->detail_route = route('customer.tours.show', $i);

            return $i;
        });
        $transfers = TransferBooking::where('user_id', $userId)->get()->map(function ($i) {
            $i->type_label = 'Airport Transfer';
            $i->detail_route = route('customer.transfers.show', $i);

            return $i;
        });
        $shuttles = ShuttleBooking::where('user_id', $userId)->get()->map(function ($i) {
            $i->type_label = 'Hotel Shuttle';
            $i->detail_route = route('customer.shuttles.show', $i);

            return $i;
        });

        $allBookings = $rentals->concat($tours)->concat($transfers)->concat($shuttles)->sortByDesc('created_at');

        $totalBookings = $allBookings->count();
        $pendingBookings = $allBookings->where('booking_status', 'pending')->count();
        $unpaidBookings = $allBookings->where('payment_status', 'unpaid')->count();

        $recentBookings = $allBookings->take(5);

        return view('frontend.dashboard.index', compact('totalBookings', 'pendingBookings', 'unpaidBookings', 'recentBookings'));
    }
}
