<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price_full_day' => 'decimal:2',
            'price_half_day' => 'decimal:2',
        ];
    }

    public function rentalBookings()
    {
        return $this->hasMany(RentalBooking::class);
    }
}
