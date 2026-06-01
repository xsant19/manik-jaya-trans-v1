<?php

namespace App\Filament\Resources\TransferBookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class TransferBookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('airport_transfer_id')
                    ->relationship('airportTransfer', 'route_name')
                    ->required(),
                TextInput::make('booking_code')
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                DatePicker::make('booking_date')
                    ->required(),
                TextInput::make('passenger_count')
                    ->required()
                    ->numeric(),
                TextInput::make('flight_number'),
                TimePicker::make('pickup_time'),
                Textarea::make('note')
                    ->columnSpanFull(),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated(),
                Select::make('booking_status')
                    ->options([
            'pending' => 'Pending',
            'approved' => 'Approved',
            'on_trip' => 'On trip',
            'completed' => 'Completed',
            'canceled' => 'Canceled',
        ])
                    ->default('pending')
                    ->required(),
                Select::make('payment_status')
                    ->options([
            'unpaid' => 'Unpaid',
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
            'expired' => 'Expired',
            'refunded' => 'Refunded',
        ])
                    ->default('unpaid')
                    ->required(),
            ]);
    }
}
