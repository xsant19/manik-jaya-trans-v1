<?php

namespace App\Filament\Resources\ShuttleBookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ShuttleBookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('hotel_shuttle_id')
                    ->relationship('hotelShuttle', 'route_name')  // UBAH: dari hotel_name
                    ->label('Rute Hotel Shuttle')
                    ->required(),
                Select::make('vehicle_id')
                    ->relationship('vehicle', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('driver_id')
                    ->relationship('driver', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('booking_code')
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                DatePicker::make('booking_date')
                    ->required(),
                TextInput::make('passenger_count')
                    ->required()
                    ->numeric(),
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
                \Filament\Forms\Components\DateTimePicker::make('completed_at')
                    ->disabled()
                    ->dehydrated(false),
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
