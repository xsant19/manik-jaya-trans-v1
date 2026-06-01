<?php

namespace App\Filament\Resources\ShuttleBookings\Pages;

use App\Filament\Resources\ShuttleBookings\ShuttleBookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShuttleBookings extends ListRecords
{
    protected static string $resource = ShuttleBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
