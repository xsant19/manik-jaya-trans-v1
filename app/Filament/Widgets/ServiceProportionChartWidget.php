<?php

namespace App\Filament\Widgets;

use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use Filament\Widgets\ChartWidget;

class ServiceProportionChartWidget extends ChartWidget
{
    protected static ?int $sort = 3;

    protected string  $color       = 'warning';
    protected ?string $heading     = 'Proporsi Layanan';
    protected ?string $description = 'Distribusi jenis pemesanan';
    protected ?string $maxHeight   = '280px';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $rental   = RentalBooking::count();
        $tour     = TourBooking::count();
        $transfer = TransferBooking::count();
        $shuttle  = ShuttleBooking::count();

        return [
            'datasets' => [
                [
                    'label'           => 'Jumlah Pemesanan',
                    'data'            => [$rental, $tour, $transfer, $shuttle],
                    'backgroundColor' => [
                        '#f59e0b', // Kendaraan — amber
                        '#10b981', // Wisata    — emerald
                        '#6366f1', // Transfer  — indigo
                        '#ec4899', // Shuttle   — pink
                    ],
                    'borderColor'     => '#ffffff',
                    'borderWidth'     => 2,
                    'hoverOffset'     => 6,
                ],
            ],
            'labels' => [
                'Sewa Kendaraan',
                'Paket Wisata',
                'Airport Transfer',
                'Hotel Shuttle',
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display'  => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(ctx){
                            const total = ctx.chart.data.datasets[0].data.reduce((a,b)=>a+b,0);
                            const pct = total > 0 ? Math.round(ctx.parsed/total*100) : 0;
                            return ' ' + ctx.label + ': ' + ctx.parsed + ' (' + pct + '%)';
                        }",
                    ],
                ],
            ],
            'cutout' => '65%',
        ];
    }
}
