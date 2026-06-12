<?php

namespace App\Filament\Widgets;

use App\Models\RentalBooking;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Carbon;

/**
 * Widget Jadwal Hari Ini.
 *
 * Karena 4 tabel terpisah tidak bisa di-UNION langsung di Eloquent,
 * widget ini fokus pada RentalBooking (yang punya relasi driver).
 * Untuk booking wisata/transfer/shuttle, lihat widget masing-masing
 * atau gunakan pendekatan view database.
 *
 * Strategi: tampilkan RentalBooking hari ini (paling operasional karena ada supir).
 */
class TodayScheduleWidget extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('📅 Jadwal Keberangkatan Hari Ini')
            ->description('Pemesanan kendaraan dengan tanggal mulai hari ini')
            ->query(
                RentalBooking::query()
                    ->with(['user', 'vehicle', 'driver'])
                    ->whereDate('start_date', Carbon::today())
                    ->where('booking_status', '!=', 'canceled')
                    ->orderBy('created_at')
            )
            ->columns([
                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->weight('bold')
                    ->copyable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Nama Tamu')
                    ->searchable()
                    ->default('—'),

                TextColumn::make('vehicle.name')
                    ->label('Kendaraan')
                    ->default('—')
                    ->badge()
                    ->searchable()
                    ->color('warning'),

                TextColumn::make('rental_type')
                    ->label('Tipe Sewa')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'full_day' ? 'info' : 'primary')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'full_day' => 'Full Day',
                        'half_day' => 'Half Day',
                        default => $state,
                    }),

                TextColumn::make('pickup_location')
                    ->label('Lokasi Jemput')
                    ->limit(30)
                    ->searchable()
                    ->default('—'),

                TextColumn::make('driver.name')
                    ->label('Supir')
                    ->default('Belum ditugaskan')
                    ->color(fn ($record): string => $record->driver_id ? 'success' : 'warning')
                    ->badge()
                    ->searchable(),

                TextColumn::make('booking_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'info',
                        'on_trip' => 'primary',
                        'completed' => 'success',
                        'canceled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'on_trip' => 'Dalam Perjalanan',
                        'completed' => 'Selesai',
                        'canceled' => 'Dibatalkan',
                        default => $state,
                    }),
            ])
            ->paginated(false)
            ->striped()
            ->emptyStateHeading('Tidak ada jadwal hari ini')
            ->emptyStateDescription('Belum ada pemesanan kendaraan untuk hari ini.')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}
