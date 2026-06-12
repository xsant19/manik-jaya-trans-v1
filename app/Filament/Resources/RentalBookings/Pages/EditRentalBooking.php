<?php

namespace App\Filament\Resources\RentalBookings\Pages;

use App\Filament\Resources\RentalBookings\RentalBookingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRentalBooking extends EditRecord
{
    protected static string $resource = RentalBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getSaveFormAction(): \Filament\Actions\Action
    {
        return parent::getSaveFormAction()
            ->submit(null)
            ->requiresConfirmation()
            ->action(fn () => $this->save())
            ->modalHeading('Simpan Perubahan')
            ->modalDescription('Apakah Anda yakin ingin menyimpan perubahan pada data pemesanan ini?')
            ->modalSubmitActionLabel('Ya, Simpan');
    }
}
