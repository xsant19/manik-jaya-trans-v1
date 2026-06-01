@extends('layouts.app')

@section('content')
<div class="py-12">
    <x-page-container>
        <div class="flex justify-between items-end mb-8 border-b border-soft-divider pb-4">
            <div>
                <h1 class="text-3xl font-bold text-carbon-black mb-1">Dashboard</h1>
                <p class="text-storm-gray">Selamat datang kembali, {{ auth()->user()->name }}!</p>
            </div>
            <a href="{{ route('customer.bookings.index') }}" class="text-sm font-medium text-carbon-black hover:underline hidden md:inline-block">Lihat Semua Riwayat</a>
        </div>

        <!-- Summary Cards (Max 3) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <x-service-card class="bg-faint-gray !border-none">
                <div class="text-sm text-storm-gray mb-2">Total Pemesanan</div>
                <div class="text-4xl font-bold text-carbon-black">{{ $totalBookings }}</div>
            </x-service-card>
            <x-service-card class="bg-faint-gray !border-none">
                <div class="text-sm text-storm-gray mb-2">Menunggu Konfirmasi</div>
                <div class="text-4xl font-bold text-yellow-600">{{ $pendingBookings }}</div>
            </x-service-card>
            <x-service-card class="bg-faint-gray !border-none">
                <div class="text-sm text-storm-gray mb-2">Belum Dibayar</div>
                <div class="text-4xl font-bold text-red-600">{{ $unpaidBookings }}</div>
            </x-service-card>
        </div>

        <div class="flex justify-between items-end mb-6">
            <h3 class="text-xl font-bold text-carbon-black">Booking Terbaru</h3>
            <a href="{{ route('customer.bookings.index') }}" class="text-sm font-medium text-carbon-black hover:underline md:hidden">Lihat Semua</a>
        </div>

        @if($recentBookings->isEmpty())
            <div class="text-center py-16 bg-faint-gray rounded-btn-card border border-soft-divider">
                <p class="text-storm-gray mb-4">Anda belum memiliki riwayat pemesanan.</p>
                <a href="{{ route('vehicles.index') }}">
                    <x-primary-button>Mulai Eksplorasi</x-primary-button>
                </a>
            </div>
        @else
            <!-- Desktop Table -->
            <div class="hidden md:block bg-canvas-white rounded-btn-card border border-soft-divider overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-faint-gray border-b border-soft-divider text-xs uppercase tracking-wider text-storm-gray">
                            <th class="p-4 font-medium">Kode Booking</th>
                            <th class="p-4 font-medium">Layanan</th>
                            <th class="p-4 font-medium">Tanggal Dibuat</th>
                            <th class="p-4 font-medium text-right">Total Tagihan</th>
                            <th class="p-4 font-medium">Status</th>
                            <th class="p-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-carbon-black">
                        @foreach($recentBookings as $booking)
                        <tr class="border-b border-soft-divider hover:bg-faint-gray">
                            <td class="p-4 font-bold">{{ $booking->booking_code }}</td>
                            <td class="p-4">{{ $booking->type_label }}</td>
                            <td class="p-4 text-storm-gray">{{ $booking->created_at->format('d M Y') }}</td>
                            <td class="p-4 text-right font-medium">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <x-status-badge :status="$booking->payment_status" />
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ $booking->detail_route }}" class="text-carbon-black hover:underline font-medium">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-4">
                @foreach($recentBookings as $booking)
                    <div class="bg-canvas-white border border-soft-divider p-4 rounded-btn-card">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-bold text-carbon-black">{{ $booking->booking_code }}</div>
                            <x-status-badge :status="$booking->payment_status" />
                        </div>
                        <div class="text-sm text-storm-gray mb-4">{{ $booking->type_label }} &bull; {{ $booking->created_at->format('d M Y') }}</div>
                        <div class="flex justify-between items-center border-t border-soft-divider pt-4">
                            <div class="font-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                            <a href="{{ $booking->detail_route }}" class="text-sm font-medium text-carbon-black hover:underline">Detail &rarr;</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-page-container>
</div>
@endsection
