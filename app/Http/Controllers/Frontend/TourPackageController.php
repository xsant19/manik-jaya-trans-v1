<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class TourPackageController extends Controller
{
    public function index()
    {
        $packages = TourPackage::where('status', 'active')->get();
        return view('frontend.tours.index', compact('packages'));
    }

    public function show(TourPackage $tour)
    {
        abort_if($tour->status !== 'active', 404);
        return view('frontend.tours.show', compact('tour'));
    }
}
