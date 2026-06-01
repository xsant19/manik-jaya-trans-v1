<?php

namespace Database\Seeders;

use App\Models\HotelShuttle;
use Illuminate\Database\Seeder;

class HotelShuttleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shuttles = [
            [
                'hotel_name' => 'The Westin Resort Nusa Dua',
                'pickup_location' => 'Lobby Westin',
                'dropoff_location' => 'Bali Collection Nusa Dua',
                'price' => 50000,
                'schedule' => 'Setiap 2 jam sekali (08:00 - 20:00)',
                'status' => 'active',
            ],
            [
                'hotel_name' => 'Padma Resort Legian',
                'pickup_location' => 'Lobby Padma',
                'dropoff_location' => 'Beachwalk Shopping Center',
                'price' => 40000,
                'schedule' => 'Sesuai permintaan (On Demand)',
                'status' => 'active',
            ],
            [
                'hotel_name' => 'Hard Rock Hotel Bali',
                'pickup_location' => 'Lobby Hard Rock',
                'dropoff_location' => 'Discovery Shopping Mall',
                'price' => 30000,
                'schedule' => 'Setiap jam (10:00 - 22:00)',
                'status' => 'active',
            ],
            [
                'hotel_name' => 'AYANA Resort Jimbaran',
                'pickup_location' => 'Lobby AYANA',
                'dropoff_location' => 'Jimbaran Seafood Cafes',
                'price' => 60000,
                'schedule' => 'Setiap sore (15:00 - 21:00)',
                'status' => 'active',
            ],
            [
                'hotel_name' => 'The Apurva Kempinski',
                'pickup_location' => 'Lobby Kempinski',
                'dropoff_location' => 'Nusa Dua Beach',
                'price' => 55000,
                'schedule' => 'Sesuai permintaan (On Demand)',
                'status' => 'inactive',
            ],
        ];

        foreach ($shuttles as $shuttle) {
            HotelShuttle::create($shuttle);
        }
    }
}
