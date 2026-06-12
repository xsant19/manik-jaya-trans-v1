<?php

namespace App\Filament\Resources\TransferBookings\Pages;

use App\Filament\Resources\TransferBookings\TransferBookingResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateTransferBooking extends CreateRecord
{
    protected static string $resource = TransferBookingResource::class;

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
