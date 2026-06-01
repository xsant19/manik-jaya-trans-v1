<?php

namespace App\Filament\Resources\TourBookings\Pages;

use App\Filament\Resources\TourBookings\TourBookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTourBookings extends ListRecords
{
    protected static string $resource = TourBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
