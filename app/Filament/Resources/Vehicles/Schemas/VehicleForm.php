<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('capacity')
                    ->required()
                    ->numeric(),
                TextInput::make('price_full_day')
                    ->required()
                    ->numeric(),
                TextInput::make('price_half_day')
                    ->required()
                    ->numeric(),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                Select::make('status')
                    ->options(['available' => 'Available', 'maintenance' => 'Maintenance', 'inactive' => 'Inactive'])
                    ->default('available')
                    ->required(),
            ]);
    }
}
