<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class VehicleInventory extends Model
{
    protected $fillable = [
        'vehicle_id',
        'date',
        'stock',
    ];

    protected $casts = [
        'date' => 'date',
        'stock' => 'integer',
    ];

    /**
     * Relationship: belongs to vehicle
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Scope: filter by date
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope: filter by vehicle
     */
    public function scopeForVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    /**
     * Scope: filter by date range
     */
    public function scopeForDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Get available stock (considering active bookings with paid status)
     */
    public function getAvailableStock(): int
    {
        $activeBookings = $this->vehicle->countPaidBookingsOnDate($this->date);
        return max(0, $this->stock - $activeBookings);
    }

    /**
     * Check if stock is available
     */
    public function isAvailable(): bool
    {
        return $this->getAvailableStock() > 0;
    }
}
