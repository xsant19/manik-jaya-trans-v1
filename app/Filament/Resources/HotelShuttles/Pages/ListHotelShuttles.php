<?php

namespace App\Filament\Resources\HotelShuttles\Pages;

use App\Filament\Resources\HotelShuttles\HotelShuttleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHotelShuttles extends ListRecords
{
    protected static string $resource = HotelShuttleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
