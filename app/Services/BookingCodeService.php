<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingCodeService
{
    /**
     * Generate a unique booking code.
     *
     * @param string $prefix Prefix for the booking type (e.g., RNT, TOUR, TRF, SHT)
     * @param string $modelClass The fully qualified class name of the Eloquent Model
     * @param string $column The column name where the booking code is stored
     * @return string
     */
    public function generate(string $prefix, string $modelClass, string $column = 'booking_code'): string
    {
        $dateStr = Carbon::now()->format('Ymd');
        $baseFormat = "{$prefix}-{$dateStr}-";

        // Cari record terakhir pada hari ini berdasarkan prefix dan tanggal
        $lastRecord = $modelClass::where($column, 'LIKE', $baseFormat . '%')
            ->orderBy($column, 'desc')
            ->first();

        if (! $lastRecord) {
            // Jika belum ada pada hari ini, mulai dari 0001
            $sequence = 1;
        } else {
            // Jika ada, ekstrak 4 digit terakhir dan tambahkan 1
            $lastCode = $lastRecord->{$column};
            // Asumsi format: PREFIX-YYYYMMDD-0001
            // Kita ambil 4 karakter terakhir
            $lastSequence = (int) Str::substr($lastCode, -4);
            $sequence = $lastSequence + 1;
        }

        // Format angka menjadi 4 digit (e.g., 0001, 0012, 0123)
        $paddedSequence = sprintf('%04d', $sequence);

        return $baseFormat . $paddedSequence;
    }
}
