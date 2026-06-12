<?php

namespace App\Filament\Resources\ShuttleBookings\Pages;

use App\Filament\Resources\ShuttleBookings\ShuttleBookingResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateShuttleBooking extends CreateRecord
{
    protected static string $resource = ShuttleBookingResource::class;

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->submit(null)
            ->requiresConfirmation()
            ->action(fn () => $this->create())
            ->modalHeading('Buat Pemesanan')
            ->modalDescription('Apakah Anda yakin ingin membuat data pemesanan baru ini?')
            ->modalSubmitActionLabel('Ya, Buat');
    }
}
