<?php

namespace App\Filament\Resources\TourBookings\Pages;

use App\Filament\Resources\TourBookings\TourBookingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTourBooking extends CreateRecord
{
    protected static string $resource = TourBookingResource::class;

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
