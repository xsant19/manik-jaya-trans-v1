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
                TextInput::make('route_name')                    // UBAH: dari hotel_name
                    ->label('Nama Rute')
                    ->required()
                    ->maxLength(255),
                TextInput::make('pickup_location')
                    ->label('Lokasi Penjemputan (Area/Daerah)')
                    ->helperText('Contoh: Kuta Area, Seminyak Area, Ubud Center')
                    ->required(),
                TextInput::make('dropoff_location')
                    ->label('Tujuan (Bandara)')
                    ->helperText('Contoh: Bandara Ngurah Rai (DPS)')
                    ->required(),
                TextInput::make('price')
                    ->label('Harga per Orang')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('estimated_duration')            // UBAH: dari schedule
                    ->label('Estimasi Durasi')
                    ->helperText('Contoh: 30 Menit, 60 Menit'),
                Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->default('active')
                    ->required(),
            ]);
    }
}
