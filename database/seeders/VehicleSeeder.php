<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'name' => 'Toyota Hiace Commuter',
                'type' => 'Minibus',
                'capacity' => 14,
                'price_full_day' => 1200000,
                'price_half_day' => 800000,
                'description' => 'Minibus nyaman dengan kapasitas hingga 14 penumpang, cocok untuk rombongan wisata menengah.',
            ],
            [
                'name' => 'Toyota Innova Zenix Hybrid',
                'type' => 'MPV',
                'capacity' => 6,
                'price_full_day' => 1000000,
                'price_half_day' => 650000,
                'description' => 'Mobil keluarga premium yang sangat nyaman dan tangguh, irit bahan bakar dengan teknologi hybrid.',
            ],
            [
                'name' => 'Isuzu Elf Long',
                'type' => 'Minibus',
                'capacity' => 19,
                'price_full_day' => 1500000,
                'price_half_day' => 1000000,
                'description' => 'Kapasitas lebih besar untuk rombongan wisata. AC dingin dan kursi yang nyaman.',
            ],
            [
                'name' => 'Toyota Avanza',
                'type' => 'MPV',
                'capacity' => 6,
                'price_full_day' => 500000,
                'price_half_day' => 350000,
                'description' => 'Pilihan ekonomis untuk perjalanan keluarga kecil. Sangat praktis untuk di Bali.',
            ],
            [
                'name' => 'Toyota Alphard Transformer',
                'type' => 'Luxury MPV',
                'capacity' => 5,
                'price_full_day' => 2500000,
                'price_half_day' => 1500000,
                'description' => 'Kendaraan mewah untuk perjalanan VIP atau bisnis. Ekstra nyaman dengan captain seat.',
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}
