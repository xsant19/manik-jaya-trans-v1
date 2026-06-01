<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled()
                    ->required(),
                TextInput::make('payable_type')
                    ->disabled()
                    ->required(),
                TextInput::make('booking_code')
                    ->disabled()
                    ->required(),
                TextInput::make('payment_method')
                    ->disabled(),
                TextInput::make('transaction_id')
                    ->disabled(),
                TextInput::make('gross_amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'expired' => 'Expired',
                        'refunded' => 'Refunded',
                    ])
                    ->default('pending')
                    ->required(),
                DateTimePicker::make('paid_at')
                    ->disabled(),
            ]);
    }
}
