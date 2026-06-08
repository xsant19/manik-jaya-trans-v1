<?php

namespace App\Filament\Resources\ShuttleBookings;

use App\Filament\Resources\ShuttleBookings\Pages\CreateShuttleBooking;
use App\Filament\Resources\ShuttleBookings\Pages\EditShuttleBooking;
use App\Filament\Resources\ShuttleBookings\Pages\ListShuttleBookings;
use App\Filament\Resources\ShuttleBookings\Pages\ViewShuttleBooking;
use App\Filament\Resources\ShuttleBookings\Schemas\ShuttleBookingForm;
use App\Filament\Resources\ShuttleBookings\Schemas\ShuttleBookingInfolist;
use App\Filament\Resources\ShuttleBookings\Tables\ShuttleBookingsTable;
use App\Models\ShuttleBooking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ShuttleBookingResource extends Resource
{
    protected static ?string $model = ShuttleBooking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Booking';

    protected static ?string $navigationLabel = 'Booking Shuttle';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'booking_code';

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('booking_status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return ShuttleBookingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ShuttleBookingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShuttleBookingsTable::configure($table);
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
            'index' => ListShuttleBookings::route('/'),
            'create' => CreateShuttleBooking::route('/create'),
            'view' => ViewShuttleBooking::route('/{record}'),
            'edit' => EditShuttleBooking::route('/{record}/edit'),
        ];
    }
}
