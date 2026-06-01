<?php

namespace Database\Seeders;

use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class TourPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Ubud Cultural Tour',
                'description' => 'Eksplorasi budaya dan keindahan alam Ubud, termasuk Monkey Forest, Tegalalang Rice Terrace, dan Pura Tirta Empul.',
                'itinerary' => "08:00 - Penjemputan di hotel\n09:30 - Tegalalang Rice Terrace\n11:30 - Kintamani Volcano View (Makan Siang)\n14:00 - Pura Tirta Empul\n16:00 - Ubud Monkey Forest\n18:00 - Kembali ke hotel",
                'duration' => '10 Jam',
                'price' => 650000,
                'status' => 'active',
            ],
            [
                'name' => 'Uluwatu Sunset Tour',
                'description' => 'Perjalanan ke selatan Bali menikmati sunset di Pura Uluwatu, pertunjukan Tari Kecak, dan makan malam seafood di Jimbaran.',
                'itinerary' => "14:00 - Penjemputan di hotel\n15:30 - Pantai Pandawa / Melasti\n17:00 - Pura Uluwatu\n18:00 - Pertunjukan Tari Kecak\n19:30 - Jimbaran Seafood Dinner\n21:30 - Kembali ke hotel",
                'duration' => '8 Jam',
                'price' => 550000,
                'status' => 'active',
            ],
            [
                'name' => 'Bedugul & Tanah Lot Tour',
                'description' => 'Kunjungi ikon wisata Bali: Pura Ulun Danu Beratan di Bedugul dan sunset magis di Pura Tanah Lot.',
                'itinerary' => "09:00 - Penjemputan di hotel\n10:30 - Pura Taman Ayun\n12:30 - Pura Ulun Danu Beratan (Makan Siang)\n15:00 - Alas Kedaton Monkey Forest\n17:00 - Pura Tanah Lot (Sunset)\n19:00 - Kembali ke hotel",
                'duration' => '10 Jam',
                'price' => 600000,
                'status' => 'active',
            ],
            [
                'name' => 'Nusa Penida West Trip (One Day)',
                'description' => 'Jelajahi pulau Nusa Penida bagian barat: Kelingking Beach, Broken Beach, Angel Billabong, dan Crystal Bay.',
                'itinerary' => "06:30 - Penjemputan di hotel\n07:30 - Menyeberang dari Sanur\n09:00 - Tiba di Nusa Penida & Tour dimulai\n15:00 - Kembali ke pelabuhan\n17:00 - Tiba kembali di hotel",
                'duration' => '11 Jam',
                'price' => 850000,
                'status' => 'inactive',
            ],
            [
                'name' => 'Lempuyang & East Bali Tour',
                'description' => 'Berkunjung ke Gerbang Surga (Pura Lempuyang), Tirta Gangga, dan Taman Ujung Water Palace.',
                'itinerary' => "06:00 - Penjemputan di hotel (pagi buta)\n08:30 - Pura Lempuyang\n11:30 - Tirta Gangga\n13:30 - Makan Siang\n15:00 - Taman Ujung\n18:00 - Kembali ke hotel",
                'duration' => '12 Jam',
                'price' => 700000,
                'status' => 'active',
            ],
        ];

        foreach ($packages as $package) {
            TourPackage::create($package);
        }
    }
}
