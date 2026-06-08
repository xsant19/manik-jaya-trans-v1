<?php

namespace App\Filament\Widgets;

use App\Models\RentalBooking;
use App\Models\ShuttleBooking;
use App\Models\TourBooking;
use App\Models\TransferBooking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class BookingTrendChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    protected string $color   = 'primary';
    protected ?string $heading = 'Tren Pemesanan';
    protected ?string $description = 'Jumlah pemesanan per hari';
    protected ?string $maxHeight  = '280px';

    // Filter: 7 hari atau 30 hari
    public ?string $filter = '7';

    protected function getFilters(): ?array
    {
        return [
            '7'  => '7 Hari Terakhir',
            '30' => '30 Hari Terakhir',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $days = (int) ($this->filter ?? 7);

        $labels  = [];
        $rental  = [];
        $tour    = [];
        $transfer = [];
        $shuttle = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $labels[]   = $date->format('d/m');
            $rental[]   = RentalBooking::whereDate('created_at', $date)->count();
            $tour[]     = TourBooking::whereDate('created_at', $date)->count();
            $transfer[] = TransferBooking::whereDate('created_at', $date)->count();
            $shuttle[]  = ShuttleBooking::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Kendaraan',
                    'data'            => $rental,
                    'borderColor'     => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.08)',
                    'tension'         => 0.4,
                    'fill'            => true,
                    'pointRadius'     => 3,
                ],
                [
                    'label'           => 'Wisata',
                    'data'            => $tour,
                    'borderColor'     => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.08)',
                    'tension'         => 0.4,
                    'fill'            => true,
                    'pointRadius'     => 3,
                ],
                [
                    'label'           => 'Transfer',
                    'data'            => $transfer,
                    'borderColor'     => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.08)',
                    'tension'         => 0.4,
                    'fill'            => true,
                    'pointRadius'     => 3,
                ],
                [
                    'label'           => 'Shuttle',
                    'data'            => $shuttle,
                    'borderColor'     => '#ec4899',
                    'backgroundColor' => 'rgba(236, 72, 153, 0.08)',
                    'tension'         => 0.4,
                    'fill'            => true,
                    'pointRadius'     => 3,
                ],
            ],
            'labels' => $labels,
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
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks'       => ['stepSize' => 1],
                ],
            ],
        ];
    }
}
