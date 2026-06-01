<?php

namespace App\Filament\Resources\TourBookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TourBookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('tour_package_id')
                    ->numeric(),
                TextEntry::make('booking_code'),
                TextEntry::make('booking_date')
                    ->date(),
                TextEntry::make('participant_count')
                    ->numeric(),
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
