<?php

namespace App\Filament\Resources\ShuttleBookings\Pages;

use App\Filament\Resources\ShuttleBookings\ShuttleBookingResource;
use App\Models\ShuttleBooking;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListShuttleBookings extends ListRecords
{
    protected static string $resource = ShuttleBookingResource::class;

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
                ->badge(ShuttleBooking::query()->count())
                ->badgeColor('gray'),

            'pending' => Tab::make('⏳ Menunggu')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'pending'))
                ->badge(ShuttleBooking::query()->where('booking_status', 'pending')->count())
                ->badgeColor('warning'),

            'approved' => Tab::make('✅ Disetujui')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'approved'))
                ->badge(ShuttleBooking::query()->where('booking_status', 'approved')->count())
                ->badgeColor('info'),

            'on_trip' => Tab::make('🏨 Dalam Perjalanan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'on_trip'))
                ->badge(ShuttleBooking::query()->where('booking_status', 'on_trip')->count())
                ->badgeColor('primary'),

            'completed' => Tab::make('✔ Selesai')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'completed'))
                ->badge(ShuttleBooking::query()->where('booking_status', 'completed')->count())
                ->badgeColor('success'),

            'canceled' => Tab::make('❌ Dibatalkan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'canceled'))
                ->badge(ShuttleBooking::query()->where('booking_status', 'canceled')->count())
                ->badgeColor('danger'),
        ];
    }
}
