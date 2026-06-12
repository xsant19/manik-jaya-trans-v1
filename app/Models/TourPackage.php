<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'itinerary',
        'duration',
        'price',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
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

    public function tourBookings()
    {
        return $this->hasMany(TourBooking::class);
    }
}
