<?php

namespace App\Filament\Resources\Coupons\Pages;

use App\Filament\Resources\CouponResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCoupon extends EditRecord
{
    protected static string $resource = CouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Kupon Diskon')
                ->modalDescription('Kupon yang sudah digunakan dalam booking tidak akan terpengaruh. Data booking akan tetap menyimpan kode kupon yang digunakan.')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Kupon berhasil diperbarui';
    }
}
