<?php

namespace App\Filament\Resources\RentalBookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RentalBookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('vehicle_id')
                    ->numeric(),
                TextEntry::make('driver_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('booking_code'),
                TextEntry::make('rental_type')
                    ->badge(),
                TextEntry::make('start_date')
                    ->date(),
                TextEntry::make('end_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('pickup_location'),
                TextEntry::make('note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('total_price')
                    ->money(),
                TextEntry::make('booking_status')
                    ->badge(),
                TextEntry::make('payment_status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
