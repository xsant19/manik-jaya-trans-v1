<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Carbon\Carbon;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LaporanKeuanganStatsWidget extends StatsOverviewWidget
{
    // Widget ini di-embed ke dalam page LaporanKeuangan,
    // bukan ditampilkan di dashboard utama.
    protected static bool $isDiscovered = false;

    public ?string $from = null;

    public ?string $to = null;

    protected function getStats(): array
    {
        $fromDate = $this->from
            ? Carbon::parse($this->from)->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $toDate = $this->to
            ? Carbon::parse($this->to)->endOfDay()
            : now()->endOfDay();

        $payments = Payment::where('status', 'paid')
            ->whereBetween('paid_at', [$fromDate, $toDate])
            ->get();

        $totalRevenue = $payments->sum('gross_amount');
        $totalTransactions = $payments->count();
        $averagePerTx = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        return [
            Stat::make(
                'Total Pendapatan (Lunas)',
                'Rp '.number_format((float) $totalRevenue, 0, ',', '.')
            )
                ->description('Transaksi berstatus Lunas (paid)')
                ->descriptionIcon(Heroicon::OutlinedBanknotes)
                ->color('success'),

            Stat::make(
                'Total Transaksi Berhasil',
                number_format($totalTransactions, 0, ',', '.').' Transaksi'
            )
                ->description('Pembayaran lunas pada periode ini')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->color('primary'),

            Stat::make(
                'Rata-rata Nilai Transaksi',
                'Rp '.number_format((float) $averagePerTx, 0, ',', '.')
            )
                ->description('Rata-rata per transaksi')
                ->descriptionIcon(Heroicon::OutlinedChartPie)
                ->color('warning'),
        ];
    }
}
