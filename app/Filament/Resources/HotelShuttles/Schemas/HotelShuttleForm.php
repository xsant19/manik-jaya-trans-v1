<?php

namespace App\Filament\Resources\HotelShuttles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HotelShuttleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('hotel_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('pickup_location')
                    ->required(),
                TextInput::make('dropoff_location')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('schedule'),
                Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->default('active')
                    ->required(),
            ]);
    }
}
