<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    protected $model = Driver::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstNameMale();
        $lastName = fake()->lastName();
        $fullName = $firstName . ' ' . $lastName;

        return [
            'name' => $fullName,
            'phone' => fake()->numerify('08##########'), // Indonesian phone format
            'license_number' => $this->generateLicenseNumber(),
            'status' => fake()->randomElement(['available', 'available', 'available', 'on_trip']), // 75% available
        ];
    }

    /**
     * Generate realistic Indonesian driver license number
     */
    private function generateLicenseNumber(): string
    {
        // Format: XXXX-XXXX-XXXXXX (Indonesian SIM format)
        return fake()->numerify('####-####-######');
    }

    /**
     * Indicate that the driver is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }

    /**
     * Indicate that the driver is on a trip.
     */
    public function onTrip(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'on_trip',
        ]);
    }

    /**
     * Indicate that the driver is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
