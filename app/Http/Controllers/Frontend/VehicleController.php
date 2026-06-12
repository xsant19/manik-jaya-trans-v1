<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $vehicles = Vehicle::where('is_hidden', false)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('frontend.vehicles.index', compact('vehicles', 'search'));
    }

    public function show(Vehicle $vehicle)
    {
        abort_if($vehicle->is_hidden, 404);

        return view('frontend.vehicles.show', compact('vehicle'));
    }
}
