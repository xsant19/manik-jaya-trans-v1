<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AirportTransfer;
use Illuminate\Http\Request;

class AirportTransferController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $transfers = AirportTransfer::where('status', 'active')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('route_name', 'like', "%{$search}%")
                        ->orWhere('pickup_location', 'like', "%{$search}%")
                        ->orWhere('dropoff_location', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('frontend.transfers.index', compact('transfers', 'search'));
    }

    public function show(AirportTransfer $transfer)
    {
        abort_if($transfer->status !== 'active', 404);

        return view('frontend.transfers.show', compact('transfer'));
    }
}
