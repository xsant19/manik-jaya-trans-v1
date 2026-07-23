<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'driver_id',
        'booking_code',
        'rental_type',
        'start_date',
        'end_date',
        'pickup_location',
        'note',
        'total_price',
        'booking_status',
        'payment_status',
        'completed_at',
        'reserved_until',
        'coupon_id',
        'coupon_code',
        'discount_amount',
        'original_price',
    ];

    protected function casts(): array
    {
        return [
            'start_date'      => 'date',
            'end_date'        => 'date',
            'total_price'     => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'original_price'  => 'decimal:2',
            'completed_at'    => 'datetime',
            'reserved_until'  => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Apakah booking masih dalam masa hold aktif (belum bayar & belum expired)?
     */
    public function isOnHold(): bool
    {
        return $this->reserved_until !== null
            && $this->reserved_until->isFuture()
            && $this->payment_status === 'unpaid';
    }

    /**
     * Apakah hold sudah kadaluarsa (belum bayar & waktu hold sudah lewat)?
     */
    public function isHoldExpired(): bool
    {
        return $this->reserved_until !== null
            && $this->reserved_until->isPast()
            && $this->payment_status === 'unpaid';
    }
}
