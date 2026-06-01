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
                <h1 class="text-3xl font-bold text-carbon-black mb-2">Detail Pemesanan</h1>
                <div class="text-storm-gray">Kode Booking: <strong class="text-carbon-black uppercase">{{ $rental->booking_code }}</strong></div>
            </div>
            <div class="flex space-x-2">
                <x-status-badge :status="$rental->booking_status" />
                <x-status-badge :status="$rental->payment_status" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-8">
                <!-- Rincian Layanan -->
                <div class="bg-canvas-white p-6 rounded-btn-card border border-soft-divider">
                    <h3 class="text-xl font-bold text-carbon-black mb-6">Rincian Layanan</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Kendaraan</div>
                            <div class="font-medium text-carbon-black">{{ $rental->vehicle->name }} ({{ $rental->vehicle->type }})</div>
                        </div>
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Tipe Sewa</div>
                            <div class="font-medium text-carbon-black">{{ $rental->rental_type == 'full_day' ? 'Sehari Penuh (Full Day)' : 'Setengah Hari (Half Day)' }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Tanggal Mulai</div>
                            <div class="font-medium text-carbon-black">{{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d F Y') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Tanggal Selesai</div>
                            <div class="font-medium text-carbon-black">{{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d F Y') }}</div>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="text-sm text-storm-gray mb-1">Lokasi Jemput/Antar</div>
                            <div class="font-medium text-carbon-black">{{ $rental->pickup_location }}</div>
                        </div>
                        @if($rental->driver)
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Supir</div>
                            <div class="font-medium text-carbon-black">{{ $rental->driver->name }} ({{ $rental->driver->phone }})</div>
                        </div>
                        @endif
                        @if($rental->note)
                        <div class="sm:col-span-2">
                            <div class="text-sm text-storm-gray mb-1">Catatan Khusus</div>
                            <div class="p-3 bg-faint-gray rounded-btn border border-soft-divider text-carbon-black text-sm">{{ $rental->note }}</div>
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
                        <span class="text-2xl font-bold text-carbon-black">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                    </div>

                    @if($rental->payment_status === 'unpaid')
                        <p class="text-sm text-storm-gray mb-6">Silakan lakukan pembayaran agar pesanan Anda dapat segera kami proses.</p>
                        <form action="{{ route('payment.store', ['type' => 'rental', 'booking_code' => $rental->booking_code]) }}" method="POST" class="w-full">
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
