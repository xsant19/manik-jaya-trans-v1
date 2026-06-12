<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $packages = TourPackage::where('status', 'active')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('frontend.tours.index', compact('packages', 'search'));
    }

    public function show(TourPackage $tour)
    {
        abort_if($tour->status !== 'active', 404);

        return view('frontend.tours.show', compact('tour'));
    }
}
