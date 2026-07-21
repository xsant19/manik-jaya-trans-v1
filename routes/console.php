<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jalankan setiap 5 menit untuk memproses hold kendaraan yang expired (window 30 menit)
// dan membatalkan booking lama yang belum dibayar (> 24 jam)
Schedule::command('booking:cancel-expired')->everyFiveMinutes();

