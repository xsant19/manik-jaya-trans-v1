<?php

namespace App\Filament\Resources\ShuttleBookings\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShuttleBookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('hotelShuttle.hotel_name')
                    ->label('Hotel')
                    ->searchable(),
                TextColumn::make('booking_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('total_price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('booking_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved', 'completed' => 'success',
                        'pending', 'on_trip' => 'warning',
                        'canceled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending', 'unpaid' => 'warning',
                        'failed', 'expired', 'refunded' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('booking_status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'on_trip' => 'On trip',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'expired' => 'Expired',
                        'refunded' => 'Refunded',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('spk')
                    ->label('SPK')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->color('info')
                    ->url(fn ($record) => route('documents.spk', ['type' => 'shuttle', 'id' => $record->id]))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => in_array($record->booking_status, ['approved', 'on_trip', 'completed'])),
                Action::make('evoucher')
                    ->label('E-Voucher')
                    ->icon(Heroicon::OutlinedTicket)
                    ->color('success')
                    ->url(fn ($record) => route('documents.evoucher', ['type' => 'shuttle', 'id' => $record->id]))
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
