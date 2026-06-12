<?php

namespace App\Services;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class VehicleAvailabilityService
{
    /**
     * Get all available vehicles for specific date
     */
    public function getAvailableVehiclesForDate(Carbon $date, ?int $capacity = null): Collection
    {
        $query = Vehicle::where('is_hidden', false);

        if ($capacity) {
            $query->where('capacity', '>=', $capacity);
        }

        return $query->get()->filter(function ($vehicle) use ($date) {
            return $vehicle->isAvailableForDate($date);
        });
    }

    /**
     * Get available vehicles for date range
     */
    public function getAvailableVehiclesForDateRange(
        Carbon $startDate,
        Carbon $endDate,
        ?int $capacity = null
    ): Collection {
        $query = Vehicle::where('is_hidden', false);

        if ($capacity) {
            $query->where('capacity', '>=', $capacity);
        }

        return $query->get()->filter(function ($vehicle) use ($startDate, $endDate) {
            return $vehicle->isAvailableForDateRange($startDate, $endDate);
        });
    }

    /**
     * Check if ANY vehicle is available for date
     */
    public function hasAvailableVehiclesForDate(Carbon $date, ?int $capacity = null): bool
    {
        return $this->getAvailableVehiclesForDate($date, $capacity)->isNotEmpty();
    }

    /**
     * Check if ANY vehicle is available for date range
     */
    public function hasAvailableVehiclesForDateRange(
        Carbon $startDate,
        Carbon $endDate,
        ?int $capacity = null
    ): bool {
        return $this->getAvailableVehiclesForDateRange($startDate, $endDate, $capacity)->isNotEmpty();
    }

    /**
     * Get vehicle availability summary for admin dashboard
     */
    public function getVehicleAvailabilitySummary(Carbon $date): array
    {
        $vehicles = Vehicle::all();

        return $vehicles->map(function ($vehicle) use ($date) {
            $inventory = $vehicle->getInventoryForDate($date);

            return [
                'id' => $vehicle->id,
                'name' => $vehicle->name,
                'has_inventory' => $inventory !== null,
                'stock' => $inventory ? $inventory->stock : 0,
                'available_stock' => $inventory ? $inventory->getAvailableStock() : 0,
                'active_bookings' => $vehicle->countActiveBookingsOnDate($date),
                'is_available' => $inventory ? $inventory->getAvailableStock() > 0 : false,
            ];
        })->toArray();
    }
}
