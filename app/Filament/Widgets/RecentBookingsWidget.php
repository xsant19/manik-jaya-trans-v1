<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentBookingsWidget extends TableWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('🧾 Pembayaran Terbaru')
            ->description('5 transaksi pembayaran terbaru')
            ->query(
                Payment::query()
                    ->with(['user', 'payable'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('user.name')
                    ->label('Nama Tamu')
                    ->searchable()
                    ->default('—'),

                TextColumn::make('payable_type')
                    ->label('Jenis Layanan')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'RentalBooking')   => 'warning',
                        str_contains($state, 'TourBooking')     => 'success',
                        str_contains($state, 'TransferBooking') => 'info',
                        str_contains($state, 'ShuttleBooking')  => 'primary',
                        default                                 => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match (true) {
                        str_contains($state, 'RentalBooking')   => 'Sewa Kendaraan',
                        str_contains($state, 'TourBooking')     => 'Paket Wisata',
                        str_contains($state, 'TransferBooking') => 'Airport Transfer',
                        str_contains($state, 'ShuttleBooking')  => 'Hotel Shuttle',
                        default                                 => $state,
                    }),

                TextColumn::make('gross_amount')
                    ->label('Total Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'  => 'warning',
                        'paid'     => 'success',
                        'failed'   => 'danger',
                        'expired'  => 'gray',
                        'refunded' => 'info',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'  => 'Menunggu',
                        'paid'     => 'Lunas',
                        'failed'   => 'Gagal',
                        'expired'  => 'Kedaluwarsa',
                        'refunded' => 'Refund',
                        default    => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since(),
            ])
            ->paginated(false)
            ->striped();
    }
}
