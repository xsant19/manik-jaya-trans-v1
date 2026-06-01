<?php

namespace App\Filament\Resources\HotelShuttles;

use App\Filament\Resources\HotelShuttles\Pages\CreateHotelShuttle;
use App\Filament\Resources\HotelShuttles\Pages\EditHotelShuttle;
use App\Filament\Resources\HotelShuttles\Pages\ListHotelShuttles;
use App\Filament\Resources\HotelShuttles\Schemas\HotelShuttleForm;
use App\Filament\Resources\HotelShuttles\Tables\HotelShuttlesTable;
use App\Models\HotelShuttle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HotelShuttleResource extends Resource
{
    protected static ?string $model = HotelShuttle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'hotel_name';

    public static function form(Schema $schema): Schema
    {
        return HotelShuttleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HotelShuttlesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHotelShuttles::route('/'),
            'create' => CreateHotelShuttle::route('/create'),
            'edit' => EditHotelShuttle::route('/{record}/edit'),
        ];
    }
}
