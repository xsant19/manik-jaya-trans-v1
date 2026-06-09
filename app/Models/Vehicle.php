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
        'status',
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
}
