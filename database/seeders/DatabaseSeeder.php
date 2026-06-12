<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Admin User only
        $this->call([
            AdminSeeder::class,
        ]);

        // Generate data using factories
        Vehicle::factory()->count(15)->create();
        Driver::factory()->count(12)->create();
        TourPackage::factory()->count(10)->create();
        AirportTransfer::factory()->count(8)->create();
        HotelShuttle::factory()->count(10)->create();
    }
}
