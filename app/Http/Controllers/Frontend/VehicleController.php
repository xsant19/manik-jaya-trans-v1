<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('is_hidden', false)->get();
        return view('frontend.vehicles.index', compact('vehicles'));
    }

    public function show(Vehicle $vehicle)
    {
        abort_if($vehicle->is_hidden, 404);
        return view('frontend.vehicles.show', compact('vehicle'));
    }
}
