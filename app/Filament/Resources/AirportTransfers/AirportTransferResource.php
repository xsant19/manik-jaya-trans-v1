<?php

namespace App\Filament\Resources\AirportTransfers;

use App\Filament\Resources\AirportTransfers\Pages\CreateAirportTransfer;
use App\Filament\Resources\AirportTransfers\Pages\EditAirportTransfer;
use App\Filament\Resources\AirportTransfers\Pages\ListAirportTransfers;
use App\Filament\Resources\AirportTransfers\Schemas\AirportTransferForm;
use App\Filament\Resources\AirportTransfers\Tables\AirportTransfersTable;
use App\Models\AirportTransfer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AirportTransferResource extends Resource
{
    protected static ?string $model = AirportTransfer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaperAirplane;

    protected static string|\UnitEnum|null $navigationGroup = 'Data Layanan';

    protected static ?string $navigationLabel = 'Airport Transfer';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'route_name';

    public static function form(Schema $schema): Schema
    {
        return AirportTransferForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AirportTransfersTable::configure($table);
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
            'index' => ListAirportTransfers::route('/'),
            'create' => CreateAirportTransfer::route('/create'),
            'edit' => EditAirportTransfer::route('/{record}/edit'),
        ];
    }
}
