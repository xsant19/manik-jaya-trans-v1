<?php

namespace App\Filament\Resources\TourPackages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TourPackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('itinerary')
                    ->columnSpanFull(),
                TextInput::make('duration')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                FileUpload::make('image')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->default('active')
                    ->required(),
            ]);
    }
}
