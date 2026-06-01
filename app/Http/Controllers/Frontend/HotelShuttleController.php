<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HotelShuttle;
use Illuminate\Http\Request;

class HotelShuttleController extends Controller
{
    public function index()
    {
        $shuttles = HotelShuttle::where('status', 'active')->get();
        return view('frontend.shuttles.index', compact('shuttles'));
    }

    public function show(HotelShuttle $shuttle)
    {
        abort_if($shuttle->status !== 'active', 404);
        return view('frontend.shuttles.show', compact('shuttle'));
    }
}
