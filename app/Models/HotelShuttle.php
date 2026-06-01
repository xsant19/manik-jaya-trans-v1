<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelShuttle extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_name',
        'pickup_location',
        'dropoff_location',
        'price',
        'schedule',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function shuttleBookings()
    {
        return $this->hasMany(ShuttleBooking::class);
    }
}
