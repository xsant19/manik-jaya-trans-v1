<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelShuttle extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_name',           // UBAH: dari hotel_name
        'pickup_location',      // Area daerah (Kuta, Seminyak, dll)
        'dropoff_location',     // Bandara tujuan
        'price',
        'estimated_duration',   // UBAH: dari schedule
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
