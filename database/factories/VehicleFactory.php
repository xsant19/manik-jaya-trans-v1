<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicleTypes = ['sedan', 'suv', 'mpv', 'minibus', 'bus'];
        $vehicleNames = [
            'sedan' => ['Toyota Camry', 'Honda Accord', 'Mercedes E-Class', 'BMW 5 Series'],
            'suv' => ['Toyota Fortuner', 'Mitsubishi Pajero', 'Honda CR-V', 'Mazda CX-5'],
            'mpv' => ['Toyota Avanza', 'Toyota Innova', 'Honda Mobilio', 'Suzuki Ertiga'],
            'minibus' => ['Isuzu Elf', 'Toyota Hiace', 'Mitsubishi Colt Diesel'],
            'bus' => ['Mercedes-Benz OH', 'Hino RK', 'Mitsubishi Fuso'],
        ];

        $type = fake()->randomElement($vehicleTypes);
        $name = fake()->randomElement($vehicleNames[$type]) . ' ' . fake()->year();

        $capacities = [
            'sedan' => [4, 5],
            'suv' => [5, 7],
            'mpv' => [6, 7, 8],
            'minibus' => [12, 14, 16],
            'bus' => [20, 25, 30, 35],
        ];

        $capacity = fake()->randomElement($capacities[$type]);

        // Price based on vehicle type and capacity
        $basePriceFullDay = match($type) {
            'sedan' => fake()->numberBetween(400000, 600000),
            'suv' => fake()->numberBetween(600000, 900000),
            'mpv' => fake()->numberBetween(500000, 800000),
            'minibus' => fake()->numberBetween(900000, 1500000),
            'bus' => fake()->numberBetween(1500000, 2500000),
        };

        $priceHalfDay = $basePriceFullDay * 0.6; // 60% of full day price

        return [
            'name' => $name,
            'type' => $type,
            'capacity' => $capacity,
            'price_full_day' => $basePriceFullDay,
            'price_half_day' => $priceHalfDay,
            'description' => $this->generateVehicleDescription($type, $name, $capacity),
            'image' => json_encode([]), // Empty array for images
            'status' => fake()->randomElement(['available', 'available', 'available', 'maintenance']), // 75% available
        ];
    }

    /**
     * Generate realistic vehicle description
     */
    private function generateVehicleDescription(string $type, string $name, int $capacity): string
    {
        $features = [
            'AC',
            'Audio System',
            'USB Charger',
            'Comfortable Seats',
            'Large Luggage Space',
            'GPS Navigation',
            'Safety Features',
        ];

        $selectedFeatures = fake()->randomElements($features, fake()->numberBetween(3, 5));

        return "{$name} dengan kapasitas {$capacity} penumpang. Dilengkapi dengan " .
               implode(', ', $selectedFeatures) .
               ". Cocok untuk perjalanan keluarga atau group. Kendaraan terawat dan driver berpengalaman.";
    }

    /**
     * Indicate that the vehicle is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }

    /**
     * Indicate that the vehicle is under maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'maintenance',
        ]);
    }

    /**
     * Indicate that the vehicle is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
