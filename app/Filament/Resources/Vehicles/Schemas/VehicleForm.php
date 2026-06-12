<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
                RichEditor::make('description')
                    ->toolbarButtons(['bold', 'italic', 'underline', 'strike', 'link', 'h2', 'h3', 'bulletList', 'orderedList', 'undo', 'redo'])
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->multiple()
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxFiles(3)
                    ->reorderable()
                    ->helperText('Upload hingga 3 gambar kendaraan. Gambar pertama akan menjadi gambar utama.'),
                Toggle::make('is_hidden')
                    ->label('Sembunyikan dari Frontend')
                    ->helperText('Jika diaktifkan, kendaraan ini tidak akan tampil di halaman pemesanan bagi pelanggan.')
                    ->default(false),
            ]);
    }
}
