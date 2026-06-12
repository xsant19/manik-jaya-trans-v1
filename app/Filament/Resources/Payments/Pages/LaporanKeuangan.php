<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use BackedEnum;
use Filament\Resources\Pages\Page;
use Filament\Support\Icons\Heroicon;

class LaporanKeuangan extends Page
{
    protected static string $resource = PaymentResource::class;

    protected static ?string $title = 'Laporan Keuangan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;

    protected static ?string $navigationLabel = 'Laporan Keuangan';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.laporan-keuangan';

    public ?string $from = null;

    public ?string $to = null;

    public function mount(): void
    {
        $this->from = now()->startOfMonth()->toDateString();
        $this->to = now()->toDateString();
    }
}
