<?php

namespace App\Filament\Resources\TourBookings\Pages;

use App\Filament\Resources\TourBookings\TourBookingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTourBooking extends ViewRecord
{
    protected static string $resource = TourBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
