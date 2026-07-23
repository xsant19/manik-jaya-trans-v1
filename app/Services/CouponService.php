<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Support\Str;

class CouponService
{
    /**
     * Validasi kode kupon untuk booking tertentu.
     *
     * @param  string $code         Kode kupon yang dimasukkan customer
     * @param  float  $totalPrice   Total harga booking sebelum diskon
     * @return array{valid: bool, coupon: Coupon|null, discount: float, message: string}
     */
    public function validate(string $code, float $totalPrice): array
    {
        $coupon = Coupon::where('code', strtoupper(trim($code)))->first();

        if (! $coupon) {
            return [
                'valid'   => false,
                'coupon'  => null,
                'discount'=> 0.0,
                'message' => 'Kode kupon tidak ditemukan.',
            ];
        }

        if (! $coupon->isValid()) {
            // Beri pesan yang spesifik berdasarkan status kupon
            $message = match ($coupon->status_label) {
                'Nonaktif'       => 'Kupon ini tidak aktif.',
                'Belum Berlaku'  => 'Kupon ini belum berlaku. Berlaku mulai ' . $coupon->started_at->translatedFormat('d F Y'),
                'Kedaluwarsa'    => 'Kupon ini sudah kedaluwarsa.',
                'Habis'          => 'Kupon ini sudah habis digunakan.',
                default          => 'Kupon tidak valid.',
            };

            return [
                'valid'   => false,
                'coupon'  => $coupon,
                'discount'=> 0.0,
                'message' => $message,
            ];
        }

        // Cek minimum booking amount
        if ($coupon->min_booking_amount !== null && $totalPrice < (float) $coupon->min_booking_amount) {
            return [
                'valid'   => false,
                'coupon'  => $coupon,
                'discount'=> 0.0,
                'message' => 'Kupon ini hanya berlaku untuk pemesanan minimal Rp ' . number_format((float) $coupon->min_booking_amount, 0, ',', '.') . '.',
            ];
        }

        $discount = $coupon->calculateDiscount($totalPrice);

        $message = 'Kupon berhasil diterapkan! Anda mendapat potongan Rp ' . number_format($discount, 0, ',', '.') . '.';

        return [
            'valid'        => true,
            'coupon'       => $coupon,
            'discount'     => $discount,
            'message'      => $message,
            'coupon_name'  => $coupon->name,
        ];
    }

    /**
     * Tandai kupon telah digunakan (increment usage_count).
     * Dipanggil SETELAH booking berhasil disimpan.
     */
    public function apply(Coupon $coupon): void
    {
        $coupon->increment('usage_count');
    }

    /**
     * Generate kode kupon unik (uppercase alphanumeric).
     *
     * @param  int $length Panjang kode (default 8)
     */
    public function generateCode(int $length = 8): string
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (Coupon::where('code', $code)->exists());

        return $code;
    }
}
