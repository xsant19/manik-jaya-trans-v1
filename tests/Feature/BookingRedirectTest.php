<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vehicle;

class BookingRedirectTest extends TestCase
{
    public function test_booking_redirect()
    {
        $user = User::where("role", "customer")->first();
        $vehicle = Vehicle::first();
        
        $response = $this->actingAs($user)->post("/booking/vehicles/" . $vehicle->id, [
            "rental_type" => "full_day",
            "start_date" => date("Y-m-d", strtotime("+1 day")),
            "end_date" => date("Y-m-d", strtotime("+1 day")),
            "pickup_location" => "Bali",
        ]);
        
        $response->dump();
    }
}

