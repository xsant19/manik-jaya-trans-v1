<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Document Routes (Admin)
|--------------------------------------------------------------------------
| SPK / Surat Jalan, Invoice, E-Voucher, Laporan Keuangan
*/

Route::middleware(['auth'])->prefix('admin/documents')->name('documents.')->group(function () {
    Route::get('/spk/{type}/{id}', [DocumentController::class, 'spk'])
        ->name('spk')
        ->where('type', 'rental|tour|transfer|shuttle');

    Route::get('/invoice/{id}', [DocumentController::class, 'invoice'])
        ->name('invoice');

    Route::get('/evoucher/{type}/{id}', [DocumentController::class, 'evoucher'])
        ->name('evoucher')
        ->where('type', 'rental|tour|transfer|shuttle');

    Route::get('/laporan-keuangan', [DocumentController::class, 'laporanKeuanganPdf'])
        ->name('laporan-keuangan');

    Route::get('/laporan-keuangan-excel', [DocumentController::class, 'laporanKeuanganExcel'])
        ->name('laporan-keuangan-excel');
});
