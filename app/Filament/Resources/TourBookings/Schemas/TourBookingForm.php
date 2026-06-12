<?php

namespace App\Filament\Resources\TourBookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TourBookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pelanggan & Pemesanan')
                    ->schema([
                        TextInput::make('booking_code')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required(),
                        Select::make('tour_package_id')
                            ->relationship('tourPackage', 'name')
                            ->required(),
                        DatePicker::make('booking_date')
                            ->required(),
                        TextInput::make('participant_count')
                            ->required()
                            ->numeric(),
                        Textarea::make('note')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Penugasan & Operasional')
                    ->description('⚠️ Pastikan kendaraan, supir, dan status sudah benar.')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->schema([
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
                        Select::make('vehicle_id')
                            ->relationship(
                                'vehicle',
                                'name',
                                fn ($query, \Filament\Forms\Get $get) => $query->whereHas('inventories', function ($q) use ($get) {
                                    $bookingDate = $get('booking_date');
                                    if ($bookingDate) {
                                        $q->whereDate('date', $bookingDate)->where('stock', '>', 0);
                                    }
                                })
                            )
                            ->searchable()
                            ->preload()
                            ->helperText('Kendaraan untuk tour.'),
                        Select::make('driver_id')
                            ->relationship('driver', 'name', fn ($query) => $query->where('status', '!=', 'inactive'))
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->name.' - '.ucfirst(str_replace('_', ' ', $record->status)))
                            ->searchable()
                            ->preload()
                            ->helperText('Supir yang ditugaskan.'),
                        DateTimePicker::make('completed_at')
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(2),

                Section::make('Informasi Pembayaran')
                    ->schema([
                        TextInput::make('total_price')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(),
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
                    ])->columns(2),
            ]);
    }
}
