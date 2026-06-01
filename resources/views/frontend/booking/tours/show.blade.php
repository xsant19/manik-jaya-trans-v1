@extends('layouts.app')

@section('content')
<div class="py-12">
    <x-page-container>
        <div class="mb-6">
            <a href="{{ route('customer.dashboard') }}" class="text-sm font-medium text-storm-gray hover:text-carbon-black">&larr; Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-green-50 text-green-800 border border-green-200 rounded-btn-card">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-bold text-carbon-black mb-2">Detail Pemesanan Wisata</h1>
                <div class="text-storm-gray">Kode Booking: <strong class="text-carbon-black uppercase">{{ $tourBooking->booking_code }}</strong></div>
            </div>
            <div class="flex space-x-2">
                <x-status-badge :status="$tourBooking->booking_status" />
                <x-status-badge :status="$tourBooking->payment_status" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-8">
                <!-- Rincian Layanan -->
                <div class="bg-canvas-white p-6 rounded-btn-card border border-soft-divider">
                    <h3 class="text-xl font-bold text-carbon-black mb-6">Rincian Paket Wisata</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <div class="text-sm text-storm-gray mb-1">Nama Paket</div>
                            <div class="font-medium text-carbon-black">{{ $tourBooking->tourPackage->name }} ({{ $tourBooking->tourPackage->duration }})</div>
                        </div>
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Tanggal Keberangkatan</div>
                            <div class="font-medium text-carbon-black">{{ \Carbon\Carbon::parse($tourBooking->booking_date)->translatedFormat('d F Y') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Jumlah Peserta</div>
                            <div class="font-medium text-carbon-black">{{ $tourBooking->participant_count }} Orang</div>
                        </div>
                        @if($tourBooking->note)
                        <div class="sm:col-span-2">
                            <div class="text-sm text-storm-gray mb-1">Catatan Khusus</div>
                            <div class="p-3 bg-faint-gray rounded-btn border border-soft-divider text-carbon-black text-sm">{{ $tourBooking->note }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Total Harga -->
            <div>
                <div class="bg-faint-gray p-6 rounded-btn-card border border-soft-divider sticky top-24">
                    <h3 class="text-lg font-bold text-carbon-black mb-4">Total Biaya</h3>
                    
                    <div class="flex justify-between items-center mb-6 pb-6 border-b border-soft-divider">
                        <span class="text-storm-gray">Total Harus Dibayar</span>
                        <span class="text-2xl font-bold text-carbon-black">Rp {{ number_format($tourBooking->total_price, 0, ',', '.') }}</span>
                    </div>

                    @if($tourBooking->payment_status === 'unpaid')
                        <p class="text-sm text-storm-gray mb-6">Silakan lakukan pembayaran agar pesanan Anda dapat segera kami proses.</p>
                        <form action="{{ route('payment.store', ['type' => 'tour', 'booking_code' => $tourBooking->booking_code]) }}" method="POST" class="w-full">
                            @csrf
                            <x-primary-button type="submit" class="w-full">Bayar Sekarang</x-primary-button>
                        </form>
                    @else
                        <div class="p-4 bg-green-50 text-green-800 rounded-btn text-center font-medium">
                            Pembayaran Lunas
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-page-container>
</div>
@endsection
