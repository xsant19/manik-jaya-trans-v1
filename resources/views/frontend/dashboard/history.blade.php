@extends('layouts.app')

@section('content')
<div class="py-12">
    <x-page-container>
        <div class="mb-6">
            <a href="{{ route('customer.dashboard') }}" class="text-sm font-medium text-storm-gray hover:text-carbon-black">&larr; Kembali ke Dashboard</a>
        </div>

        <h1 class="text-3xl font-bold text-carbon-black mb-8 border-b border-soft-divider pb-4">Semua Riwayat Booking</h1>

        @if($bookings->isEmpty())
            <div class="text-center py-16 bg-faint-gray rounded-btn-card border border-soft-divider">
                <p class="text-storm-gray mb-4">Anda belum memiliki riwayat pemesanan.</p>
            </div>
        @else
            <!-- Desktop Table -->
            <div class="hidden md:block bg-canvas-white rounded-btn-card border border-soft-divider overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-faint-gray border-b border-soft-divider text-xs uppercase tracking-wider text-storm-gray">
                            <th class="p-4 font-medium">Kode Booking</th>
                            <th class="p-4 font-medium">Layanan</th>
                            <th class="p-4 font-medium">Tgl Pemesanan</th>
                            <th class="p-4 font-medium">Tgl Dibuat</th>
                            <th class="p-4 font-medium text-right">Total Tagihan</th>
                            <th class="p-4 font-medium">Status Pemesanan</th>
                            <th class="p-4 font-medium">Pembayaran</th>
                            <th class="p-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-carbon-black">
                        @foreach($bookings as $booking)
                        <tr class="border-b border-soft-divider hover:bg-faint-gray">
                            <td class="p-4 font-bold">{{ $booking->booking_code }}</td>
                            <td class="p-4">{{ $booking->type_label }}</td>
                            <td class="p-4 text-storm-gray">{{ \Carbon\Carbon::parse($booking->booking_date ?? $booking->start_date)->format('d M Y') }}</td>
                            <td class="p-4 text-storm-gray">{{ $booking->created_at->format('d M Y') }}</td>
                            <td class="p-4 text-right font-medium">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="p-4"><x-status-badge :status="$booking->booking_status" /></td>
                            <td class="p-4"><x-status-badge :status="$booking->payment_status" /></td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <a href="{{ $booking->detail_route }}" class="text-carbon-black hover:underline font-medium">Detail</a>
                                    @if(in_array($booking->payment_status, ['unpaid', 'pending']) && $booking->booking_status !== 'canceled')
                                        <form id="cancel-form-{{ $booking->booking_code }}" action="{{ route('customer.bookings.cancel', ['type' => $booking->type, 'booking_code' => $booking->booking_code]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="button" onclick="openCancelModal('cancel-form-{{ $booking->booking_code }}')" class="text-red-600 hover:underline font-medium">Batal</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-4">
                @foreach($bookings as $booking)
                    <div class="bg-canvas-white border border-soft-divider p-4 rounded-btn-card">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-bold text-carbon-black">{{ $booking->booking_code }}</div>
                            <x-status-badge :status="$booking->payment_status" />
                        </div>
                        <div class="text-sm text-storm-gray mb-1">{{ $booking->type_label }}</div>
                        <div class="text-xs text-dust-bunny mb-4">Untuk tgl: {{ \Carbon\Carbon::parse($booking->booking_date ?? $booking->start_date)->format('d M Y') }}</div>
                        <div class="flex justify-between items-center border-t border-soft-divider pt-4">
                            <div class="font-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                            <div class="flex items-center gap-4">
                                @if(in_array($booking->payment_status, ['unpaid', 'pending']) && $booking->booking_status !== 'canceled')
                                    <form id="cancel-form-mobile-{{ $booking->booking_code }}" action="{{ route('customer.bookings.cancel', ['type' => $booking->type, 'booking_code' => $booking->booking_code]) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="button" onclick="openCancelModal('cancel-form-mobile-{{ $booking->booking_code }}')" class="text-red-600 hover:underline font-medium text-sm">Batal</button>
                                    </form>
                                @endif
                                <a href="{{ $booking->detail_route }}" class="text-sm font-medium text-carbon-black hover:underline">Detail &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-page-container>
</div>

<x-cancel-modal />
@endsection
