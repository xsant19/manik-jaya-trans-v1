<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\TourPackage;
use App\Models\AirportTransfer;
use App\Models\HotelShuttle;
use App\Models\RentalBooking;

class FunctionalTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get('/customer/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_customer_can_login_and_access_dashboard()
    {
        $user = User::factory()->create(['role' => 'customer']);
        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        $response->assertRedirect('/customer/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_customer_cannot_access_admin()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $this->actingAs($user);

        $response = $this->get('/admin');
        // Filament might redirect to login if not admin, or 403.
        // Let's just check it doesn't give 200.
        $this->assertTrue($response->status() !== 200);
    }

    public function test_customer_can_view_services()
    {
        $vehicle = Vehicle::create([
            'name' => 'Avanza',
            'type' => 'Minivan',
            'capacity' => 6,
            'price_full_day' => 500000,
            'price_half_day' => 300000,
            'status' => 'available',
        ]);
        
        $response = $this->get('/vehicles');
        $response->assertStatus(200);

        $response = $this->get('/vehicles/' . $vehicle->id);
        $response->assertStatus(200);
    }

    public function test_customer_can_book_vehicle()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $vehicle = Vehicle::create([
            'name' => 'Avanza',
            'type' => 'Minivan',
            'capacity' => 6,
            'price_full_day' => 500000,
            'price_half_day' => 300000,
            'status' => 'available',
        ]);
        
        $this->actingAs($user);

        $response = $this->post('/booking/vehicles/' . $vehicle->id, [
            'rental_type' => 'full_day',
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(2)->format('Y-m-d'),
            'pickup_location' => 'Airport',
        ]);

        $booking = RentalBooking::first();
        $this->assertNotNull($booking);
        $this->assertEquals($user->id, $booking->user_id);
        $response->assertRedirect(route('customer.rental.show', $booking));
    }

    public function test_customer_can_book_tour()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $tour = TourPackage::create(['name' => 'Bali Tour', 'description' => 'A great tour', 'duration' => '1 Day', 'price' => 200000, 'status' => 'active']);
        
        $this->actingAs($user);
        $response = $this->post('/booking/tours/' . $tour->id, [
            'booking_date' => now()->addDay()->format('Y-m-d'),
            'participant_count' => 2,
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('tour_bookings', ['user_id' => $user->id, 'participant_count' => 2]);
    }

    public function test_customer_can_book_transfer()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $transfer = AirportTransfer::create(['route_name' => 'Ngurah Rai to Kuta', 'pickup_location' => 'Airport', 'dropoff_location' => 'Kuta', 'price' => 150000, 'status' => 'active']);
        
        $this->actingAs($user);
        $response = $this->post('/booking/transfers/' . $transfer->id, [
            'booking_date' => now()->addDay()->format('Y-m-d'),
            'passenger_count' => 3,
            'pickup_time' => '10:00',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('transfer_bookings', ['user_id' => $user->id, 'passenger_count' => 3]);
    }

    public function test_customer_can_book_shuttle()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $shuttle = HotelShuttle::create(['hotel_name' => 'Kuta Hotel', 'pickup_location' => 'Airport', 'dropoff_location' => 'Kuta', 'price' => 50000, 'status' => 'active']);
        
        $this->actingAs($user);
        $response = $this->post('/booking/shuttles/' . $shuttle->id, [
            'booking_date' => now()->addDay()->format('Y-m-d'),
            'passenger_count' => 1,
            'pickup_time' => '10:00',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('shuttle_bookings', ['user_id' => $user->id, 'passenger_count' => 1]);
    }

    public function test_midtrans_callback_updates_status()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $vehicle = Vehicle::create([
            'name' => 'Avanza',
            'type' => 'Minivan',
            'capacity' => 6,
            'price_full_day' => 500000,
            'price_half_day' => 300000,
            'status' => 'available',
        ]);

        $booking = RentalBooking::create([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'booking_code' => 'RNT-TEST',
            'rental_type' => 'full_day',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
            'pickup_location' => 'Bali',
            'total_price' => 100000,
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $payment = \App\Models\Payment::create([
            'user_id' => $user->id,
            'payable_type' => RentalBooking::class,
            'payable_id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'payment_method' => 'midtrans',
            'payment_gateway' => 'midtrans',
            'transaction_id' => 'TRX-TEST',
            'gross_amount' => 100000,
            'status' => 'pending',
            'raw_response' => [],
        ]);

        $serverKey = env('MIDTRANS_SERVER_KEY', config('midtrans.server_key'));
        $signature = hash("sha512", "TRX-TEST" . "200" . "100000.00" . $serverKey);

        $response = $this->postJson('/payments/midtrans/callback', [
            'order_id' => 'TRX-TEST',
            'status_code' => '200',
            'gross_amount' => '100000.00',
            'transaction_status' => 'settlement',
            'signature_key' => $signature,
        ]);

        $response->assertStatus(200);
        $this->assertEquals('paid', $payment->fresh()->status);
        $this->assertEquals('paid', $booking->fresh()->payment_status);
    }
}

