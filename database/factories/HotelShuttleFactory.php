<?php

namespace Database\Factories;

use App\Models\HotelShuttle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HotelShuttle>
 */
class HotelShuttleFactory extends Factory
{
    protected $model = HotelShuttle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $routes = [
            [
                'route_name' => 'Shuttle Kuta - Bandara Ngurah Rai',
                'pickup_location' => 'Area Kuta',
                'dropoff_location' => 'Bandara Internasional Ngurah Rai',
                'price' => 50000,
                'estimated_duration' => '20 menit',
            ],
            [
                'route_name' => 'Shuttle Seminyak - Bandara Ngurah Rai',
                'pickup_location' => 'Area Seminyak',
                'dropoff_location' => 'Bandara Internasional Ngurah Rai',
                'price' => 75000,
                'estimated_duration' => '30 menit',
            ],
            [
                'route_name' => 'Shuttle Sanur - Bandara Ngurah Rai',
                'pickup_location' => 'Area Sanur',
                'dropoff_location' => 'Bandara Internasional Ngurah Rai',
                'price' => 100000,
                'estimated_duration' => '40 menit',
            ],
            [
                'route_name' => 'Shuttle Ubud - Bandara Ngurah Rai',
                'pickup_location' => 'Area Ubud',
                'dropoff_location' => 'Bandara Internasional Ngurah Rai',
                'price' => 200000,
                'estimated_duration' => '1 jam 30 menit',
            ],
            [
                'route_name' => 'Shuttle Denpasar - Bandara Ngurah Rai',
                'pickup_location' => 'Area Denpasar',
                'dropoff_location' => 'Bandara Internasional Ngurah Rai',
                'price' => 75000,
                'estimated_duration' => '35 menit',
            ],
            [
                'route_name' => 'Shuttle Nusa Dua - Bandara Ngurah Rai',
                'pickup_location' => 'Area Nusa Dua',
                'dropoff_location' => 'Bandara Internasional Ngurah Rai',
                'price' => 125000,
                'estimated_duration' => '45 menit',
            ],
            [
                'route_name' => 'Shuttle Jimbaran - Bandara Ngurah Rai',
                'pickup_location' => 'Area Jimbaran',
                'dropoff_location' => 'Bandara Internasional Ngurah Rai',
                'price' => 65000,
                'estimated_duration' => '25 menit',
            ],
            [
                'route_name' => 'Shuttle Canggu - Bandara Ngurah Rai',
                'pickup_location' => 'Area Canggu',
                'dropoff_location' => 'Bandara Internasional Ngurah Rai',
                'price' => 125000,
                'estimated_duration' => '50 menit',
            ],
            [
                'route_name' => 'Shuttle Uluwatu - Bandara Ngurah Rai',
                'pickup_location' => 'Area Uluwatu',
                'dropoff_location' => 'Bandara Internasional Ngurah Rai',
                'price' => 150000,
                'estimated_duration' => '55 menit',
            ],
            [
                'route_name' => 'Shuttle Legian - Bandara Ngurah Rai',
                'pickup_location' => 'Area Legian',
                'dropoff_location' => 'Bandara Internasional Ngurah Rai',
                'price' => 60000,
                'estimated_duration' => '25 menit',
            ],
        ];

        static $index = 0;
        $route = $routes[$index % count($routes)];
        $index++;

        return [
            'route_name' => $route['route_name'],
            'pickup_location' => $route['pickup_location'],
            'dropoff_location' => $route['dropoff_location'],
            'price' => $route['price'],
            'estimated_duration' => $route['estimated_duration'],
            'status' => fake()->randomElement(['active', 'active', 'active', 'inactive']), // 75% active
        ];
    }

    /**
     * Indicate that the hotel shuttle is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the hotel shuttle is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
