<?php

namespace App\Filament\Resources\AirportTransfers\Pages;

use App\Filament\Resources\AirportTransfers\AirportTransferResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAirportTransfers extends ListRecords
{
    protected static string $resource = AirportTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
