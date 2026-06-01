<?php

namespace App\Filament\Resources\ShuttleBookings\Pages;

use App\Filament\Resources\ShuttleBookings\ShuttleBookingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewShuttleBooking extends ViewRecord
{
    protected static string $resource = ShuttleBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
