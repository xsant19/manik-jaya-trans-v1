<?php

namespace App\Filament\Resources\Coupons\Pages;

use App\Filament\Resources\CouponResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCoupons extends ListRecords
{
    protected static string $resource = CouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat Kupon Baru')
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Pembuatan Kupon')
                ->modalDescription('Pastikan semua informasi kupon sudah benar sebelum dibuat.')
                ->modalSubmitActionLabel('Ya, Buat Kupon'),
        ];
    }
}
