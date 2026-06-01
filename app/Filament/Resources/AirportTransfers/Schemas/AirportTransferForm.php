<?php

namespace App\Filament\Resources\AirportTransfers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AirportTransferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('route_name')
                    ->required(),
                TextInput::make('pickup_location')
                    ->required(),
                TextInput::make('dropoff_location')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('estimated_duration'),
                Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->default('active')
                    ->required(),
            ]);
    }
}
