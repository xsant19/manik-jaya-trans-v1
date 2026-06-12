<?php

namespace App\Filament\Resources\RentalBookings\Pages;

use App\Filament\Resources\RentalBookings\RentalBookingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRentalBooking extends CreateRecord
{
    protected static string $resource = RentalBookingResource::class;

    protected function getCreateFormAction(): \Filament\Actions\Action
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
