<?php

namespace App\Filament\Resources\TransferBookings\Pages;

use App\Filament\Resources\TransferBookings\TransferBookingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTransferBooking extends ViewRecord
{
    protected static string $resource = TransferBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
