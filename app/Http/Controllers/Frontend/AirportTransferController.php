<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AirportTransfer;
use Illuminate\Http\Request;

class AirportTransferController extends Controller
{
    public function index()
    {
        $transfers = AirportTransfer::where('status', 'active')->get();
        return view('frontend.transfers.index', compact('transfers'));
    }

    public function show(AirportTransfer $transfer)
    {
        abort_if($transfer->status !== 'active', 404);
        return view('frontend.transfers.show', compact('transfer'));
    }
}
