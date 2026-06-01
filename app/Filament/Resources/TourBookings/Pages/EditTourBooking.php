<?php

namespace App\Filament\Resources\TourBookings\Pages;

use App\Filament\Resources\TourBookings\TourBookingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTourBooking extends EditRecord
{
    protected static string $resource = TourBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
