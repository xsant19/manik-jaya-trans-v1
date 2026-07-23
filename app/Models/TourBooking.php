<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tour_package_id',
        'vehicle_id',
        'driver_id',
        'booking_code',
        'booking_date',
        'participant_count',
        'note',
        'total_price',
        'booking_status',
        'payment_status',
        'completed_at',
        'coupon_id',
        'coupon_code',
        'discount_amount',
        'original_price',
    ];

    protected function casts(): array
    {
        return [
            'booking_date'    => 'date',
            'total_price'     => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'original_price'  => 'decimal:2',
            'completed_at'    => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
