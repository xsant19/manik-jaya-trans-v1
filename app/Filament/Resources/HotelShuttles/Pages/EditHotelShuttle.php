<?php

namespace App\Filament\Resources\HotelShuttles\Pages;

use App\Filament\Resources\HotelShuttles\HotelShuttleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHotelShuttle extends EditRecord
{
    protected static string $resource = HotelShuttleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
