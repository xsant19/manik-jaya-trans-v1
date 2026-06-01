<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    /**
     * Menampilkan form pemesanan tiket.
     */
    public function index()
    {
        return view('booking.index');
    }

    /**
     * Menyimpan data pemesanan baru.
     */
    public function store()
    {
        // Logic akan dipindahkan ke BookingService
    }

    /**
     * Menampilkan detail pemesanan.
     */
    public function show(string $id)
    {
        return view('booking.show', compact('id'));
    }
}
