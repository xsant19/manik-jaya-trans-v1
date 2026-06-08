<?php

namespace Database\Factories;

use App\Models\TourPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourPackage>
 */
class TourPackageFactory extends Factory
{
    protected $model = TourPackage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tourNames = [
            'Ubud Cultural Tour',
            'Tanah Lot Sunset Tour',
            'Kintamani Volcano Tour',
            'Nusa Penida Day Trip',
            'Uluwatu Temple & Kecak Dance',
            'East Bali Hidden Gems',
            'North Bali Waterfalls Tour',
            'Bali Instagram Tour',
            'Tirta Empul & Tegalalang Rice Terrace',
            'Bedugul & Jatiluwih Tour',
            'Bali Adventure Combo',
            'Sacred Monkey Forest & Ubud',
            'Lempuyang Temple & East Bali',
            'Seminyak Beach Club Hopping',
            'Bali Countryside Cycling Tour',
        ];

        $name = fake()->randomElement($tourNames);
        $duration = fake()->randomElement(['Full Day (8-10 jam)', 'Half Day (4-5 jam)', '2 Days 1 Night', 'Full Day (10-12 jam)']);

        // Price based on duration
        $price = match(true) {
            str_contains($duration, 'Half Day') => fake()->numberBetween(300000, 500000),
            str_contains($duration, '2 Days') => fake()->numberBetween(1500000, 2500000),
            str_contains($duration, '10-12 jam') => fake()->numberBetween(700000, 1000000),
            default => fake()->numberBetween(500000, 800000),
        };

        return [
            'name' => $name,
            'description' => $this->generateDescription($name),
            'itinerary' => $this->generateItinerary($name, $duration),
            'duration' => $duration,
            'price' => $price,
            'image' => json_encode([]), // Empty array for images
            'status' => fake()->randomElement(['active', 'active', 'active', 'inactive']), // 75% active
        ];
    }

    /**
     * Generate realistic tour description
     */
    private function generateDescription(string $name): string
    {
        $descriptions = [
            'Ubud Cultural Tour' => 'Jelajahi keindahan dan budaya Ubud dengan mengunjungi berbagai tempat ikonik seperti sawah terasering, pura suci, dan pasar tradisional. Nikmati pemandangan alam yang menakjubkan dan pelajari tradisi Bali yang kaya.',

            'Tanah Lot Sunset Tour' => 'Saksikan matahari terbenam yang memukau di Pura Tanah Lot, salah satu ikon Bali yang paling terkenal. Tour ini mencakup kunjungan ke pura yang berada di atas batu karang di tepi laut.',

            'Kintamani Volcano Tour' => 'Kunjungi kawasan Kintamani dengan pemandangan Gunung Batur yang spektakuler. Nikmati udara sejuk pegunungan dan pemandangan danau vulkanik yang indah.',

            'Nusa Penida Day Trip' => 'Petualangan seru ke Pulau Nusa Penida dengan fast boat. Kunjungi pantai-pantai eksotis seperti Kelingking Beach, Angel Billabong, dan Broken Beach yang instagramable.',
        ];

        return $descriptions[$name] ?? 'Nikmati pengalaman wisata yang tak terlupakan di Bali. Tour ini dirancang khusus untuk memberikan Anda pengalaman terbaik dengan mengunjungi destinasi populer dan tersembunyi di Bali. Dipandu oleh guide berpengalaman yang ramah dan profesional.';
    }

    /**
     * Generate realistic itinerary
     */
    private function generateItinerary(string $name, string $duration): string
    {
        if (str_contains($duration, 'Half Day')) {
            return "08:00 - Penjemputan di hotel\n" .
                   "09:00 - Destinasi pertama\n" .
                   "11:00 - Destinasi kedua\n" .
                   "12:30 - Kembali ke hotel";
        }

        if (str_contains($duration, '2 Days')) {
            return "Hari 1:\n" .
                   "08:00 - Penjemputan di hotel\n" .
                   "10:00 - Destinasi pertama\n" .
                   "12:30 - Makan siang\n" .
                   "14:00 - Destinasi kedua\n" .
                   "17:00 - Check-in hotel\n\n" .
                   "Hari 2:\n" .
                   "08:00 - Sarapan & check-out\n" .
                   "09:00 - Destinasi ketiga\n" .
                   "12:00 - Makan siang\n" .
                   "14:00 - Destinasi keempat\n" .
                   "17:00 - Kembali ke hotel asal";
        }

        return "08:00 - Penjemputan di hotel\n" .
               "09:00 - Destinasi pertama\n" .
               "11:00 - Destinasi kedua\n" .
               "13:00 - Makan siang (included)\n" .
               "14:30 - Destinasi ketiga\n" .
               "16:30 - Destinasi keempat\n" .
               "18:00 - Kembali ke hotel";
    }

    /**
     * Indicate that the tour package is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the tour package is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
