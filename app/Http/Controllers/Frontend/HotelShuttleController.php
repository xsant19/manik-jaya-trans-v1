<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HotelShuttle;
use Illuminate\Http\Request;

class HotelShuttleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $shuttles = HotelShuttle::where('status', 'active')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('route_name', 'like', "%{$search}%")
                        ->orWhere('pickup_location', 'like', "%{$search}%")
                        ->orWhere('dropoff_location', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('frontend.shuttles.index', compact('shuttles', 'search'));
    }

    public function show(HotelShuttle $shuttle)
    {
        abort_if($shuttle->status !== 'active', 404);

        return view('frontend.shuttles.show', compact('shuttle'));
    }
}
