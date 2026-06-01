<?php

namespace App\Filament\Resources\TourBookings;

use App\Filament\Resources\TourBookings\Pages\CreateTourBooking;
use App\Filament\Resources\TourBookings\Pages\EditTourBooking;
use App\Filament\Resources\TourBookings\Pages\ListTourBookings;
use App\Filament\Resources\TourBookings\Pages\ViewTourBooking;
use App\Filament\Resources\TourBookings\Schemas\TourBookingForm;
use App\Filament\Resources\TourBookings\Schemas\TourBookingInfolist;
use App\Filament\Resources\TourBookings\Tables\TourBookingsTable;
use App\Models\TourBooking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TourBookingResource extends Resource
{
    protected static ?string $model = TourBooking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'booking_code';

    public static function form(Schema $schema): Schema
    {
        return TourBookingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TourBookingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TourBookingsTable::configure($table);
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
            'index' => ListTourBookings::route('/'),
            'create' => CreateTourBooking::route('/create'),
            'view' => ViewTourBooking::route('/{record}'),
            'edit' => EditTourBooking::route('/{record}/edit'),
        ];
    }
}
