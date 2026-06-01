<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'airport_transfer_id',
        'booking_code',
        'booking_date',
        'passenger_count',
        'flight_number',
        'pickup_time',
        'note',
        'total_price',
        'booking_status',
        'payment_status',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'pickup_time' => 'datetime',
            'total_price' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function airportTransfer()
    {
        return $this->belongsTo(AirportTransfer::class);
    }

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }
}
