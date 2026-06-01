<?php

namespace App\Filament\Resources\TransferBookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransferBookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('airport_transfer_id')
                    ->numeric(),
                TextEntry::make('booking_code'),
                TextEntry::make('booking_date')
                    ->date(),
                TextEntry::make('passenger_count')
                    ->numeric(),
                TextEntry::make('flight_number')
                    ->placeholder('-'),
                TextEntry::make('pickup_time')
                    ->time()
                    ->placeholder('-'),
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
