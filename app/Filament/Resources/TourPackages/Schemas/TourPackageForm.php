<?php

namespace App\Filament\Resources\TourPackages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TourPackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                RichEditor::make('description')
                    ->label('Deskripsi Paket')
                    ->toolbarButtons(['bold', 'italic', 'underline', 'strike', 'link', 'h2', 'h3', 'bulletList', 'orderedList', 'undo', 'redo'])
                    ->columnSpanFull(),
                RichEditor::make('itinerary')
                    ->label('Itinerary (Jadwal)')
                    ->toolbarButtons(['bold', 'italic', 'underline', 'strike', 'link', 'h2', 'h3', 'bulletList', 'orderedList', 'undo', 'redo'])
                    ->helperText('Gunakan "Bullet List" (daftar berpoin) dari menu editor. Format: "08:00 - Penjemputan di hotel"')
                    ->columnSpanFull(),
                TextInput::make('duration')
                    ->required()
                    ->helperText('Contoh: "8 Jam" atau "10 Jam"'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                FileUpload::make('image')
                    ->multiple()
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxFiles(5)
                    ->reorderable()
                    ->helperText('Upload hingga 5 gambar paket wisata. Gambar pertama akan menjadi gambar utama.'),
                Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->default('active')
                    ->required(),
            ]);
    }
}
