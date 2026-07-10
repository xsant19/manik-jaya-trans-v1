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

                    @if($rental->booking_status === 'canceled')
                        <div class="p-4 bg-red-50 text-red-800 rounded-btn text-center font-medium mb-3">
                            Pesanan Dibatalkan
                        </div>
                    @elseif($rental->payment_status === 'paid')
                        <div class="p-4 bg-green-50 text-green-800 rounded-btn text-center font-medium mb-3">
                            ✓ Pembayaran Lunas
                        </div>

                        <a href="{{ route('customer.invoice.download', ['type' => 'rental', 'booking_code' => $rental->booking_code]) }}"
                           target="_blank"
                           class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-carbon-black text-canvas-white text-sm font-medium rounded-btn hover:bg-opacity-80 transition mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9v10a2 2 0 01-2 2z"/>
                            </svg>
                            Unduh Invoice PDF
                        </a>

                        @if($rental->booking_status === 'approved' && $rental->driver_id !== null)
                            <a href="{{ route('customer.rental.voucher', $rental->booking_code) }}"
                               target="_blank"
                               class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-green-600 text-white text-sm font-medium rounded-btn hover:bg-green-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                                Unduh E-Voucher
                            </a>
                        @else
                            <p class="p-3 bg-yellow-50 border border-yellow-200 rounded-btn text-yellow-800 text-xs text-center">
                                ⏳ Menunggu konfirmasi & penugasan driver dari admin. Voucher akan tersedia setelah dikonfirmasi.
                            </p>
                        @endif
                    @elseif(in_array($rental->payment_status, ['unpaid', 'pending']))
                        <p class="text-sm text-storm-gray mb-4">Silakan lakukan pembayaran agar pesanan Anda dapat segera kami proses.</p>
                        <div class="flex items-start gap-2.5 p-3 bg-yellow-50 rounded-btn text-sm text-yellow-800 mb-4">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Batas waktu pembayaran <strong>24 jam</strong> sejak pesanan dibuat.</span>
                        </div>
                        <button
                            id="pay-button"
                            type="button"
                            class="w-full flex items-center justify-center gap-2 bg-carbon-black text-canvas-white px-8 py-4 rounded-lg font-medium hover:bg-black transition-colors disabled:opacity-60 disabled:cursor-not-allowed mb-3"
                        >
                            <span id="pay-button-text">Bayar Sekarang</span>
                        </button>
                        <form id="cancel-form-{{ $rental->booking_code }}" action="{{ route('customer.bookings.cancel', ['type' => 'rental', 'booking_code' => $rental->booking_code]) }}" method="POST">
                            @csrf
                            <button type="button" onclick="openCancelModal('cancel-form-{{ $rental->booking_code }}')" class="w-full flex items-center justify-center gap-2 bg-transparent text-carbon-black border border-soft-divider px-8 py-3 rounded-lg font-medium hover:bg-faint-gray transition-colors">
                                Batalkan Pesanan
                            </button>
                        </form>
                    @else
                        <div class="p-4 bg-red-50 text-red-800 rounded-btn text-center font-medium mb-3">
                            Pembayaran {{ ucfirst($rental->payment_status) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-page-container>
</div>

<x-cancel-modal />
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var payButton = document.getElementById('pay-button');
    if (!payButton) return;

    payButton.addEventListener('click', function () {
        payButton.disabled = true;
        document.getElementById('pay-button-text').textContent = 'Memproses...';

        fetch('{{ route('payment.store', ['type' => 'rental', 'booking_code' => $rental->booking_code]) }}', {
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
