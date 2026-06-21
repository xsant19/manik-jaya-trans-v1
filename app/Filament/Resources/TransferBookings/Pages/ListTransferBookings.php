<?php

namespace App\Filament\Resources\TransferBookings\Pages;

use App\Filament\Resources\TransferBookings\TransferBookingResource;
use App\Models\TransferBooking;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTransferBookings extends ListRecords
{
    protected static string $resource = TransferBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->badge(TransferBooking::query()->count())
                ->badgeColor('gray'),

            'pending' => Tab::make('⏳ Menunggu')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'pending'))
                ->badge(TransferBooking::query()->where('booking_status', 'pending')->count())
                ->badgeColor('warning'),

            'approved' => Tab::make('✅ Disetujui')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'approved'))
                ->badge(TransferBooking::query()->where('booking_status', 'approved')->count())
                ->badgeColor('info'),

            'on_trip' => Tab::make('✈ Dalam Perjalanan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'on_trip'))
                ->badge(TransferBooking::query()->where('booking_status', 'on_trip')->count())
                ->badgeColor('primary'),

            'completed' => Tab::make('✔ Selesai')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'completed'))
                ->badge(TransferBooking::query()->where('booking_status', 'completed')->count())
                ->badgeColor('success'),

            'canceled' => Tab::make('❌ Dibatalkan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'canceled'))
                ->badge(TransferBooking::query()->where('booking_status', 'canceled')->count())
                ->badgeColor('danger'),
        ];
    }
}
