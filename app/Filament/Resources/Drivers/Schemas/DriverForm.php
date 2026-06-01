<?php

namespace App\Filament\Resources\Drivers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('license_number'),
                Select::make('status')
                    ->options(['available' => 'Available', 'on_trip' => 'On trip', 'inactive' => 'Inactive'])
                    ->default('available')
                    ->required(),
            ]);
    }
}
