<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('payable_type'),
                TextEntry::make('payable_id')
                    ->numeric(),
                TextEntry::make('booking_code'),
                TextEntry::make('payment_method')
                    ->placeholder('-'),
                TextEntry::make('payment_gateway')
                    ->placeholder('-'),
                TextEntry::make('transaction_id')
                    ->placeholder('-'),
                TextEntry::make('gross_amount')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('paid_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
