<?php

namespace Database\Seeders;

use App\Models\HotelShuttle;
use Illuminate\Database\Seeder;

class HotelShuttleSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate dulu agar tidak ada data lama yang konflik
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        HotelShuttle::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $shuttles = [
            [
                'route_name'         => 'Kuta / Legian ke Bandara',
                'pickup_location'    => 'Kuta / Legian Area',
                'dropoff_location'   => 'Bandara Ngurah Rai (DPS)',
                'price'              => 150000,
                'estimated_duration' => '30 Menit',
                'status'             => 'active',
            ],
            [
                'route_name'         => 'Seminyak ke Bandara',
                'pickup_location'    => 'Seminyak Area',
                'dropoff_location'   => 'Bandara Ngurah Rai (DPS)',
                'price'              => 200000,
                'estimated_duration' => '45 Menit',
                'status'             => 'active',
            ],
            [
                'route_name'         => 'Canggu ke Bandara',
                'pickup_location'    => 'Canggu Area',
                'dropoff_location'   => 'Bandara Ngurah Rai (DPS)',
                'price'              => 250000,
                'estimated_duration' => '60 Menit',
                'status'             => 'active',
            ],
            [
                'route_name'         => 'Ubud ke Bandara',
                'pickup_location'    => 'Ubud Center',
                'dropoff_location'   => 'Bandara Ngurah Rai (DPS)',
                'price'              => 350000,
                'estimated_duration' => '90 Menit',
                'status'             => 'active',
            ],
            [
                'route_name'         => 'Nusa Dua ke Bandara',
                'pickup_location'    => 'Nusa Dua Area',
                'dropoff_location'   => 'Bandara Ngurah Rai (DPS)',
                'price'              => 180000,
                'estimated_duration' => '40 Menit',
                'status'             => 'active',
            ],
        ];

        foreach ($shuttles as $shuttle) {
            HotelShuttle::create($shuttle);
        }
    }
}
