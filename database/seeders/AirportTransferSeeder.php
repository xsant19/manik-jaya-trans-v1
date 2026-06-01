<?php

namespace Database\Seeders;

use App\Models\AirportTransfer;
use Illuminate\Database\Seeder;

class AirportTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transfers = [
            [
                'route_name' => 'Bandara ke Kuta / Legian',
                'pickup_location' => 'Bandara Ngurah Rai (DPS)',
                'dropoff_location' => 'Kuta / Legian Area',
                'price' => 150000,
                'estimated_duration' => '30 Menit',
                'status' => 'active',
            ],
            [
                'route_name' => 'Bandara ke Seminyak',
                'pickup_location' => 'Bandara Ngurah Rai (DPS)',
                'dropoff_location' => 'Seminyak Area',
                'price' => 200000,
                'estimated_duration' => '45 Menit',
                'status' => 'active',
            ],
            [
                'route_name' => 'Bandara ke Canggu',
                'pickup_location' => 'Bandara Ngurah Rai (DPS)',
                'dropoff_location' => 'Canggu Area',
                'price' => 250000,
                'estimated_duration' => '60 Menit',
                'status' => 'active',
            ],
            [
                'route_name' => 'Bandara ke Ubud',
                'pickup_location' => 'Bandara Ngurah Rai (DPS)',
                'dropoff_location' => 'Ubud Center',
                'price' => 350000,
                'estimated_duration' => '90 Menit',
                'status' => 'active',
            ],
            [
                'route_name' => 'Ubud ke Bandara',
                'pickup_location' => 'Ubud Center',
                'dropoff_location' => 'Bandara Ngurah Rai (DPS)',
                'price' => 350000,
                'estimated_duration' => '90 Menit',
                'status' => 'inactive',
            ],
        ];

        foreach ($transfers as $transfer) {
            AirportTransfer::create($transfer);
        }
    }
}
