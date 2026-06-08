<?php

namespace Database\Factories;

use App\Models\AirportTransfer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AirportTransfer>
 */
class AirportTransferFactory extends Factory
{
    protected $model = AirportTransfer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $routes = [
            [
                'route_name' => 'Bandara Ngurah Rai - Kuta',
                'pickup_location' => 'Bandara Internasional Ngurah Rai',
                'dropoff_location' => 'Area Kuta',
                'price' => 75000,
                'estimated_duration' => '20 menit',
            ],
            [
                'route_name' => 'Bandara Ngurah Rai - Seminyak',
                'pickup_location' => 'Bandara Internasional Ngurah Rai',
                'dropoff_location' => 'Area Seminyak',
                'price' => 100000,
                'estimated_duration' => '30 menit',
            ],
            [
                'route_name' => 'Bandara Ngurah Rai - Sanur',
                'pickup_location' => 'Bandara Internasional Ngurah Rai',
                'dropoff_location' => 'Area Sanur',
                'price' => 125000,
                'estimated_duration' => '40 menit',
            ],
            [
                'route_name' => 'Bandara Ngurah Rai - Ubud',
                'pickup_location' => 'Bandara Internasional Ngurah Rai',
                'dropoff_location' => 'Area Ubud',
                'price' => 250000,
                'estimated_duration' => '1 jam 30 menit',
            ],
            [
                'route_name' => 'Bandara Ngurah Rai - Denpasar',
                'pickup_location' => 'Bandara Internasional Ngurah Rai',
                'dropoff_location' => 'Area Denpasar',
                'price' => 100000,
                'estimated_duration' => '35 menit',
            ],
            [
                'route_name' => 'Bandara Ngurah Rai - Nusa Dua',
                'pickup_location' => 'Bandara Internasional Ngurah Rai',
                'dropoff_location' => 'Area Nusa Dua',
                'price' => 150000,
                'estimated_duration' => '45 menit',
            ],
            [
                'route_name' => 'Bandara Ngurah Rai - Jimbaran',
                'pickup_location' => 'Bandara Internasional Ngurah Rai',
                'dropoff_location' => 'Area Jimbaran',
                'price' => 90000,
                'estimated_duration' => '25 menit',
            ],
            [
                'route_name' => 'Bandara Ngurah Rai - Canggu',
                'pickup_location' => 'Bandara Internasional Ngurah Rai',
                'dropoff_location' => 'Area Canggu',
                'price' => 150000,
                'estimated_duration' => '50 menit',
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
     * Indicate that the airport transfer is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the airport transfer is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
