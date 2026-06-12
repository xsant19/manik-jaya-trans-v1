<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class BookingStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // ─── Pemesanan Hari Ini ───────────────────────────────────────────
        $todayRental = RentalBooking::whereDate('created_at', $today)->count();
        $todayTour = TourBooking::whereDate('created_at', $today)->count();
        $todayTransfer = TransferBooking::whereDate('created_at', $today)->count();
        $todayShuttle = ShuttleBooking::whereDate('created_at', $today)->count();
        $todayTotal = $todayRental + $todayTour + $todayTransfer + $todayShuttle;

        // ─── Total Pemesanan Keseluruhan ──────────────────────────────────
        $allRental = RentalBooking::count();
        $allTour = TourBooking::count();
        $allTransfer = TransferBooking::count();
        $allShuttle = ShuttleBooking::count();
        $allTotal = $allRental + $allTour + $allTransfer + $allShuttle;

        // ─── Pemesanan Pending (menunggu persetujuan) ─────────────────────
        $pendingRental = RentalBooking::where('booking_status', 'pending')->count();
        $pendingTour = TourBooking::where('booking_status', 'pending')->count();
        $pendingTransfer = TransferBooking::where('booking_status', 'pending')->count();
        $pendingShuttle = ShuttleBooking::where('booking_status', 'pending')->count();
        $pendingTotal = $pendingRental + $pendingTour + $pendingTransfer + $pendingShuttle;

        // ─── Pendapatan Bulan Ini (dari payment berstatus paid) ───────────
        $revenueThisMonth = Payment::where('status', 'paid')
            ->whereBetween('paid_at', [$startOfMonth, $endOfMonth])
            ->sum('gross_amount');

        // ─── Trend 7 hari terakhir untuk chart ───────────────────────────
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = RentalBooking::whereDate('created_at', $date)->count()
                   + TourBooking::whereDate('created_at', $date)->count()
                   + TransferBooking::whereDate('created_at', $date)->count()
                   + ShuttleBooking::whereDate('created_at', $date)->count();
            $last7Days->push($count);
        }

        return [
            Stat::make('Pemesanan Hari Ini', $todayTotal)
                ->description('Seluruh jenis layanan')
                ->descriptionIcon(Heroicon::OutlinedCalendarDays)
                ->color('primary')
                ->chart($last7Days->toArray()),

            Stat::make('Menunggu Konfirmasi', $pendingTotal)
                ->description('Perlu tindakan admin')
                ->descriptionIcon(Heroicon::OutlinedClock)
                ->color($pendingTotal > 0 ? 'warning' : 'success'),

            Stat::make('Total Semua Pemesanan', $allTotal)
                ->description('Sepanjang waktu')
                ->descriptionIcon(Heroicon::OutlinedClipboardDocumentList)
                ->color('info'),

            Stat::make(
                'Pendapatan Bulan Ini',
                'Rp '.number_format((float) $revenueThisMonth, 0, ',', '.')
            )
                ->description(Carbon::now()->translatedFormat('F Y'))
                ->descriptionIcon(Heroicon::OutlinedBanknotes)
                ->color('success'),
        ];
    }
}
