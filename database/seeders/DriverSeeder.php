<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = [
            [
                'name' => 'Wayan Sudiana',
                'phone' => '081112223334',
                'license_number' => 'B1-12345678',
                'status' => 'available',
            ],
            [
                'name' => 'Made Artawan',
                'phone' => '082223334445',
                'license_number' => 'A-87654321',
                'status' => 'available',
            ],
            [
                'name' => 'Nyoman Parta',
                'phone' => '083334445556',
                'license_number' => 'B1-11223344',
                'status' => 'available',
            ],
            [
                'name' => 'Ketut Suardika',
                'phone' => '084445556667',
                'license_number' => 'A-55667788',
                'status' => 'on_trip',
            ],
            [
                'name' => 'Gede Mahardika',
                'phone' => '085556667778',
                'license_number' => 'B1-99887766',
                'status' => 'inactive',
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }
    }
}
