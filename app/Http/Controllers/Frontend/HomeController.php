<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda.
     */
    public function index()
    {
        $vehicles = Vehicle::where('status', 'available')->limit(6)->get();
        $packages = TourPackage::where('status', 'active')->limit(6)->get();

        return view('frontend.home', compact('vehicles', 'packages'));
    }

    /**
     * Menampilkan halaman tentang kami.
     */
    public function about()
    {
        return view('frontend.about');
    }
}
