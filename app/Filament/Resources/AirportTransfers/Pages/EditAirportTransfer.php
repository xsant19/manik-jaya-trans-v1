<?php

namespace App\Filament\Resources\AirportTransfers\Pages;

use App\Filament\Resources\AirportTransfers\AirportTransferResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAirportTransfer extends EditRecord
{
    protected static string $resource = AirportTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
