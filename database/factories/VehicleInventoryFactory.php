<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Models\VehicleInventory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class VehicleInventoryFactory extends Factory
{
    protected $model = VehicleInventory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'date' => Carbon::today()->addDays(fake()->numberBetween(0, 60)),
            'stock' => fake()->numberBetween(1, 5),
        ];
    }

    /**
     * State for specific date
     */
    public function forDate(Carbon $date): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => $date,
        ]);
    }

    /**
     * State for specific vehicle
     */
    public function forVehicle(int $vehicleId): static
    {
        return $this->state(fn (array $attributes) => [
            'vehicle_id' => $vehicleId,
        ]);
    }

    /**
     * State for high stock
     */
    public function highStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 5,
        ]);
    }

    /**
     * State for low stock
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 1,
        ]);
    }
}
