<?php

namespace App\Filament\Resources\RentalBookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RentalBookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('vehicle_id')
                    ->relationship('vehicle', 'name')
                    ->required(),
                Select::make('driver_id')
                    ->relationship('driver', 'name'),
                TextInput::make('booking_code')
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                Select::make('rental_type')
                    ->options(['full_day' => 'Full day', 'half_day' => 'Half day'])
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                TextInput::make('pickup_location')
                    ->required(),
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
