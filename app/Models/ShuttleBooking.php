<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShuttleBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hotel_shuttle_id',
        'booking_code',
        'booking_date',
        'passenger_count',
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

    public function hotelShuttle()
    {
        return $this->belongsTo(HotelShuttle::class);
    }

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }
}
