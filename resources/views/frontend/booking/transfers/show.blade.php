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
                <h1 class="text-3xl font-bold text-carbon-black mb-2">Detail Airport Transfer</h1>
                <div class="text-storm-gray">Kode Booking: <strong class="text-carbon-black uppercase">{{ $transferBooking->booking_code }}</strong></div>
            </div>
            <div class="flex space-x-2">
                <x-status-badge :status="$transferBooking->booking_status" />
                <x-status-badge :status="$transferBooking->payment_status" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-8">
                <!-- Rincian Layanan -->
                <div class="bg-canvas-white p-6 rounded-btn-card border border-soft-divider">
                    <h3 class="text-xl font-bold text-carbon-black mb-6">Informasi Perjalanan</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <div class="text-sm text-storm-gray mb-1">Rute</div>
                            <div class="font-medium text-carbon-black">
                                {{ $transferBooking->airportTransfer->pickup_location }} &rarr; {{ $transferBooking->airportTransfer->dropoff_location }}
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Tanggal Layanan</div>
                            <div class="font-medium text-carbon-black">{{ \Carbon\Carbon::parse($transferBooking->booking_date)->translatedFormat('d F Y') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Waktu Jemput</div>
                            <div class="font-medium text-carbon-black">{{ $transferBooking->pickup_time ? \Carbon\Carbon::parse($transferBooking->pickup_time)->format('H:i') : 'Menyesuaikan' }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Jumlah Penumpang</div>
                            <div class="font-medium text-carbon-black">{{ $transferBooking->passenger_count }} Orang</div>
                        </div>
                        <div>
                            <div class="text-sm text-storm-gray mb-1">Nomor Penerbangan</div>
                            <div class="font-medium text-carbon-black">{{ $transferBooking->flight_number ?? '-' }}</div>
                        </div>
                        @if($transferBooking->note)
                        <div class="sm:col-span-2">
                            <div class="text-sm text-storm-gray mb-1">Catatan Khusus</div>
                            <div class="p-3 bg-faint-gray rounded-btn border border-soft-divider text-carbon-black text-sm">{{ $transferBooking->note }}</div>
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
                        <span class="text-storm-gray">Harga Rute Tetap</span>
                        <span class="text-2xl font-bold text-carbon-black">Rp {{ number_format($transferBooking->total_price, 0, ',', '.') }}</span>
                    </div>

                    @if($transferBooking->payment_status === 'unpaid')
                        <p class="text-sm text-storm-gray mb-6">Silakan lakukan pembayaran agar sopir kami dapat dijadwalkan.</p>
                        <button
                            id="pay-button"
                            type="button"
                            class="w-full flex items-center justify-center gap-2 bg-carbon-black text-canvas-white px-8 py-4 rounded-lg font-medium hover:bg-black transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
                        >
                            <span id="pay-button-text">Bayar Sekarang</span>
                        </button>
                    @else
                        <div class="p-4 bg-green-50 text-green-800 rounded-btn text-center font-medium mb-3">
                            ✓ Pembayaran Lunas
                        </div>
                        <a href="{{ route('customer.invoice.download', ['type' => 'transfer', 'booking_code' => $transferBooking->booking_code]) }}"
                           target="_blank"
                           class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-carbon-black text-canvas-white text-sm font-medium rounded-btn hover:bg-opacity-80 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9v10a2 2 0 01-2 2z"/>
                            </svg>
                            Unduh Invoice PDF
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </x-page-container>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var payButton = document.getElementById('pay-button');
    if (!payButton) return;

    payButton.addEventListener('click', function () {
        payButton.disabled = true;
        document.getElementById('pay-button-text').textContent = 'Memproses...';

        fetch('{{ route('payment.store', ['type' => 'transfer', 'booking_code' => $transferBooking->booking_code]) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(function (response) { return response.json(); })
        .then(function (data) {
            if (data.error) {
                alert('Gagal memulai pembayaran: ' + data.error);
                payButton.disabled = false;
                document.getElementById('pay-button-text').textContent = 'Bayar Sekarang';
                return;
            }

            window.snap.pay(data.snap_token, {
                language: 'id',
                onSuccess: function (result) {
                    window.location.href = '{{ route('customer.dashboard') }}';
                },
                onPending: function (result) {
                    window.location.href = '{{ route('customer.dashboard') }}';
                },
                onError: function (result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    payButton.disabled = false;
                    document.getElementById('pay-button-text').textContent = 'Bayar Sekarang';
                },
                onClose: function () {
                    payButton.disabled = false;
                    document.getElementById('pay-button-text').textContent = 'Bayar Sekarang';
                },
            });
        })
        .catch(function () {
            alert('Terjadi kesalahan. Silakan coba lagi.');
            payButton.disabled = false;
            document.getElementById('pay-button-text').textContent = 'Bayar Sekarang';
        });
    });
});
</script>
@endpush
