<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirportTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_name',
        'pickup_location',
        'dropoff_location',
        'price',
        'estimated_duration',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function transferBookings()
    {
        return $this->hasMany(TransferBooking::class);
    }
}
