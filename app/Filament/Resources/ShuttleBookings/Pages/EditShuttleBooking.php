<?php

namespace App\Filament\Resources\ShuttleBookings\Pages;

use App\Filament\Resources\ShuttleBookings\ShuttleBookingResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditShuttleBooking extends EditRecord
{
    protected static string $resource = ShuttleBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getSaveFormAction(): Action
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
