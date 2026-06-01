<?php

namespace App\Filament\Resources\ShuttleBookings\Pages;

use App\Filament\Resources\ShuttleBookings\ShuttleBookingResource;
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
}
