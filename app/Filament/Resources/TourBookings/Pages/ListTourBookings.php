<?php

namespace App\Filament\Resources\TourBookings\Pages;

use App\Filament\Resources\TourBookings\TourBookingResource;
use App\Models\TourBooking;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTourBookings extends ListRecords
{
    protected static string $resource = TourBookingResource::class;

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
                ->badge(TourBooking::query()->count())
                ->badgeColor('gray'),

            'pending' => Tab::make('⏳ Menunggu')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'pending'))
                ->badge(TourBooking::query()->where('booking_status', 'pending')->count())
                ->badgeColor('warning'),

            'approved' => Tab::make('✅ Disetujui')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'approved'))
                ->badge(TourBooking::query()->where('booking_status', 'approved')->count())
                ->badgeColor('info'),

            'on_trip' => Tab::make('🗺 Dalam Perjalanan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'on_trip'))
                ->badge(TourBooking::query()->where('booking_status', 'on_trip')->count())
                ->badgeColor('primary'),

            'completed' => Tab::make('✔ Selesai')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'completed'))
                ->badge(TourBooking::query()->where('booking_status', 'completed')->count())
                ->badgeColor('success'),

            'canceled' => Tab::make('❌ Dibatalkan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('booking_status', 'canceled'))
                ->badge(TourBooking::query()->where('booking_status', 'canceled')->count())
                ->badgeColor('danger'),
        ];
    }
}
