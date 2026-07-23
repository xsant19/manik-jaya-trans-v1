<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'min_booking_amount',
        'max_discount_amount',
        'usage_limit',
        'usage_count',
        'started_at',
        'expired_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value'              => 'decimal:2',
            'min_booking_amount' => 'decimal:2',
            'max_discount_amount'=> 'decimal:2',
            'usage_limit'        => 'integer',
            'usage_count'        => 'integer',
            'started_at'         => 'datetime',
            'expired_at'         => 'datetime',
            'is_active'          => 'boolean',
        ];
    }

    // ─── Accessor ──────────────────────────────────────────────────────────────

    /**
     * Cek apakah kupon valid untuk digunakan saat ini.
     */
    public function isValid(): bool
    {
        // Harus aktif
        if (! $this->is_active) {
            return false;
        }

        // Cek batas penggunaan
        if ($this->usage_limit !== null && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        // Cek tanggal mulai berlaku
        if ($this->started_at !== null && now()->lt($this->started_at)) {
            return false;
        }

        // Cek tanggal kedaluwarsa
        if ($this->expired_at !== null && now()->gt($this->expired_at)) {
            return false;
        }

        return true;
    }

    /**
     * Hitung nominal diskon berdasarkan total harga.
     */
    public function calculateDiscount(float $totalPrice): float
    {
        if ($this->type === 'percentage') {
            $discount = $totalPrice * ((float) $this->value / 100);

            // Batasi dengan max_discount_amount jika ada
            if ($this->max_discount_amount !== null) {
                $discount = min($discount, (float) $this->max_discount_amount);
            }
        } else {
            // Fixed
            $discount = (float) $this->value;
        }

        // Diskon tidak boleh melebihi total harga
        return min($discount, $totalPrice);
    }

    /**
     * Label tipe diskon yang mudah dibaca.
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'percentage' ? 'Persentase (%)' : 'Nominal (Rp)';
    }

    /**
     * Status kupon dalam bentuk label.
     */
    public function getStatusLabelAttribute(): string
    {
        if (! $this->is_active) {
            return 'Nonaktif';
        }

        if ($this->started_at && now()->lt($this->started_at)) {
            return 'Belum Berlaku';
        }

        if ($this->expired_at && now()->gt($this->expired_at)) {
            return 'Kedaluwarsa';
        }

        if ($this->usage_limit !== null && $this->usage_count >= $this->usage_limit) {
            return 'Habis';
        }

        return 'Aktif';
    }
}
