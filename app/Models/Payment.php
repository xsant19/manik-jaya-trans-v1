<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payable_type',
        'payable_id',
        'booking_code',
        'payment_method',
        'payment_gateway',
        'transaction_id',
        'gross_amount',
        'status',
        'paid_at',
        'raw_response',
    ];

    protected function casts(): array
    {
        return [
            'gross_amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'raw_response' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payable()
    {
        return $this->morphTo();
    }
}
