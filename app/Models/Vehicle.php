<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isArray;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'capacity',
        'price_full_day',
        'price_half_day',
        'description',
        'image',
        'is_hidden',
        // 'status' removed - availability determined from inventory
    ];

    protected function casts(): array
    {
        return [
            'price_full_day' => 'decimal:2',
            'price_half_day' => 'decimal:2',
            'image' => 'array',
        ];
    }

    protected function imageUrls(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Access the raw array directly from the attributes
                $images = json_decode($this->attributes['image'] ?? '[]', true);
                if (empty($images)) {
                    return [];
                }

                return array_map(function ($path) {
                    return Storage::url($path);
                }, $images);
            },
        );
    }

    public function rentalBookings()
    {
        return $this->hasMany(RentalBooking::class);
    }

    public function tourBookings()
    {
        return $this->hasMany(TourBooking::class);
    }

    public function transferBookings()
    {
        return $this->hasMany(TransferBooking::class);
    }

    public function shuttleBookings()
    {
        return $this->hasMany(ShuttleBooking::class);
    }

    public function inventories()
    {
        return $this->hasMany(VehicleInventory::class);
    }

    /**
     * Get inventory for specific date
     * Returns null if no inventory record exists
     */
    public function getInventoryForDate(\Carbon\Carbon $date): ?VehicleInventory
    {
        return $this->inventories()->forDate($date)->first();
    }

    /**
     * Get or create inventory for specific date
     */
    public function getOrCreateInventoryForDate(\Carbon\Carbon $date, int $defaultStock = 1): VehicleInventory
    {
        return $this->inventories()->firstOrCreate(
            ['date' => $date->format('Y-m-d')],
            ['stock' => $defaultStock]
        );
    }

    /**
     * Count bookings with PAID payment status on specific date
     * Only paid bookings reduce stock
     */
    public function countPaidBookingsOnDate(\Carbon\Carbon $date): int
    {
        $count = 0;

        // Rental bookings (date range) - only count if payment paid
        $count += $this->rentalBookings()
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->whereIn('booking_status', ['pending', 'approved', 'on_trip'])
            ->whereHas('payment', function ($q) {
                $q->where('status', 'paid');
            })
            ->count();

        // Tour bookings (single date) - only count if payment paid
        $count += $this->tourBookings()
            ->whereDate('booking_date', $date)
            ->whereIn('booking_status', ['pending', 'approved', 'on_trip'])
            ->whereHas('payment', function ($q) {
                $q->where('status', 'paid');
            })
            ->count();

        // Transfer bookings (single date) - only count if payment paid
        $count += $this->transferBookings()
            ->whereDate('booking_date', $date)
            ->whereIn('booking_status', ['pending', 'approved', 'on_trip'])
            ->whereHas('payment', function ($q) {
                $q->where('status', 'paid');
            })
            ->count();

        // Shuttle bookings (single date) - only count if payment paid
        $count += $this->shuttleBookings()
            ->whereDate('booking_date', $date)
            ->whereIn('booking_status', ['pending', 'approved', 'on_trip'])
            ->whereHas('payment', function ($q) {
                $q->where('status', 'paid');
            })
            ->count();

        return $count;
    }

    /**
     * Get available stock for specific date
     * Returns 0 if no inventory record exists
     */
    public function getAvailableStockForDate(\Carbon\Carbon $date): int
    {
        $inventory = $this->getInventoryForDate($date);

        if (!$inventory) {
            return 0; // No inventory = not available
        }

        return $inventory->getAvailableStock();
    }

    /**
     * Check if vehicle is available for specific date
     */
    public function isAvailableForDate(\Carbon\Carbon $date): bool
    {
        return $this->getAvailableStockForDate($date) > 0;
    }

    /**
     * Check if vehicle has inventory for specific date
     */
    public function hasInventoryForDate(\Carbon\Carbon $date): bool
    {
        return $this->inventories()->forDate($date)->exists();
    }

    /**
     * Check if vehicle is available for date range
     */
    public function isAvailableForDateRange(\Carbon\Carbon $startDate, \Carbon\Carbon $endDate): bool
    {
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            if (!$this->isAvailableForDate($currentDate)) {
                return false;
            }
            $currentDate->addDay();
        }

        return true;
    }

    /**
     * Get minimum available stock across date range
     */
    public function getMinAvailableStockForDateRange(\Carbon\Carbon $startDate, \Carbon\Carbon $endDate): int
    {
        $minStock = PHP_INT_MAX;
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $availableStock = $this->getAvailableStockForDate($currentDate);
            $minStock = min($minStock, $availableStock);

            if ($minStock === 0) {
                return 0; // Early exit if any date has 0 stock
            }

            $currentDate->addDay();
        }

        return $minStock === PHP_INT_MAX ? 0 : $minStock;
    }

    /**
     * Set stock for specific date
     */
    public function setStockForDate(\Carbon\Carbon $date, int $stock): VehicleInventory
    {
        return $this->inventories()->updateOrCreate(
            ['date' => $date->format('Y-m-d')],
            ['stock' => $stock]
        );
    }

    /**
     * Set stock for date range (bulk operation)
     */
    public function setStockForDateRange(\Carbon\Carbon $startDate, \Carbon\Carbon $endDate, int $stock): void
    {
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $this->setStockForDate($currentDate, $stock);
            $currentDate->addDay();
        }
    }
}
