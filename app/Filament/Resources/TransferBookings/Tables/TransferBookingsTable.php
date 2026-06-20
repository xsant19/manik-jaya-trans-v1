<?php

namespace App\Filament\Resources\TransferBookings\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransferBookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('booking_code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('airportTransfer.route_name')
                    ->label('Rute')
                    ->searchable(),
                TextColumn::make('booking_date')
                    ->label('Tgl Transfer')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('pickup_time')
                    ->label('Waktu Jemput')
                    ->time('H:i')
                    ->placeholder('—'),
                TextColumn::make('passenger_count')
                    ->label('Penumpang')
                    ->alignCenter(),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('booking_status')
                    ->label('Status Booking')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'   => 'Menunggu',
                        'approved'  => 'Disetujui',
                        'on_trip'   => 'Dalam Perjalanan',
                        'completed' => 'Selesai',
                        'canceled'  => 'Dibatalkan',
                        default     => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending'   => 'warning',
                        'approved'  => 'info',
                        'on_trip'   => 'primary',
                        'completed' => 'success',
                        'canceled'  => 'danger',
                        default     => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending'   => 'heroicon-o-clock',
                        'approved'  => 'heroicon-o-check-circle',
                        'on_trip'   => 'heroicon-o-paper-airplane',
                        'completed' => 'heroicon-o-check-badge',
                        'canceled'  => 'heroicon-o-x-circle',
                        default     => 'heroicon-o-question-mark-circle',
                    }),
                TextColumn::make('payment_status')
                    ->label('Status Bayar')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'unpaid'   => 'Belum Bayar',
                        'pending'  => 'Menunggu',
                        'paid'     => 'Lunas',
                        'failed'   => 'Gagal',
                        'expired'  => 'Kedaluwarsa',
                        'refunded' => 'Refund',
                        default    => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'paid'     => 'success',
                        'pending'  => 'warning',
                        'unpaid'   => 'gray',
                        'failed', 'expired', 'refunded' => 'danger',
                        default    => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('booking_status')
                    ->label('Status Booking')
                    ->options([
                        'pending'   => 'Menunggu',
                        'approved'  => 'Disetujui',
                        'on_trip'   => 'Dalam Perjalanan',
                        'completed' => 'Selesai',
                        'canceled'  => 'Dibatalkan',
                    ]),
                SelectFilter::make('payment_status')
                    ->label('Status Bayar')
                    ->options([
                        'unpaid'   => 'Belum Bayar',
                        'pending'  => 'Menunggu',
                        'paid'     => 'Lunas',
                        'failed'   => 'Gagal',
                        'expired'  => 'Kedaluwarsa',
                        'refunded' => 'Refund',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label(''),
                EditAction::make()
                    ->label(''),
                Action::make('approve')
                    ->label('Approve')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Booking?')
                    ->modalDescription(fn ($record) => "Booking {$record->booking_code} akan disetujui.")
                    ->modalSubmitActionLabel('Ya, Setujui')
                    ->action(fn ($record) => $record->update(['booking_status' => 'approved']))
                    ->visible(fn ($record) => $record->booking_status === 'pending'),
                Action::make('on_trip')
                    ->label('On Trip')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Set Dalam Perjalanan?')
                    ->modalDescription(fn ($record) => "Booking {$record->booking_code} akan ditandai Dalam Perjalanan.")
                    ->modalSubmitActionLabel('Ya, Set On Trip')
                    ->action(fn ($record) => $record->update(['booking_status' => 'on_trip']))
                    ->visible(fn ($record) => $record->booking_status === 'approved'),
                Action::make('selesai')
                    ->label('Selesai')
                    ->icon(Heroicon::OutlinedCheckBadge)
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Tandai Selesai?')
                    ->modalDescription(fn ($record) => "Booking {$record->booking_code} akan ditandai Selesai.")
                    ->modalSubmitActionLabel('Ya, Selesai')
                    ->action(fn ($record) => $record->update(['booking_status' => 'completed']))
                    ->visible(fn ($record) => $record->booking_status === 'on_trip'),
                Action::make('batalkan')
                    ->label('Batalkan')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Booking?')
                    ->modalDescription(fn ($record) => "Booking {$record->booking_code} akan dibatalkan. Tindakan ini tidak dapat diurungkan.")
                    ->modalSubmitActionLabel('Ya, Batalkan')
                    ->action(fn ($record) => $record->update(['booking_status' => 'canceled']))
                    ->visible(fn ($record) => in_array($record->booking_status, ['pending', 'approved'])),
                Action::make('spk')
                    ->label('SPK')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->color('info')
                    ->url(fn ($record) => route('documents.spk', ['type' => 'transfer', 'id' => $record->id]))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => in_array($record->booking_status, ['approved', 'on_trip', 'completed'])),
                Action::make('evoucher')
                    ->label('E-Voucher')
                    ->icon(Heroicon::OutlinedTicket)
                    ->color('success')
                    ->url(fn ($record) => route('documents.evoucher', ['type' => 'transfer', 'id' => $record->id]))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => in_array($record->booking_status, ['approved', 'on_trip', 'completed']) && $record->payment_status === 'paid'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
