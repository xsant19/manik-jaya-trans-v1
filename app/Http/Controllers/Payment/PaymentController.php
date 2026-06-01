<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pembayaran.
     */
    public function index()
    {
        return view('payment.index');
    }

    /**
     * Memproses pembayaran.
     */
    public function process(string $bookingCode)
    {
        // Logic akan dipindahkan ke PaymentService
    }

    /**
     * Menampilkan status/konfirmasi pembayaran.
     */
    public function status(string $bookingCode)
    {
        return view('payment.status', compact('bookingCode'));
    }
}
