@extends('layouts.app')

@section('content')
<div class="py-12">
    <x-page-container>
        <div class="mb-6">
            <a href="{{ route('shuttles.show', $shuttle) }}" class="text-sm font-medium text-storm-gray hover:text-carbon-black">&larr; Kembali ke Detail Shuttle</a>
        </div>

        <h1 class="text-3xl font-bold text-carbon-black mb-8">Form Pemesanan Hotel Shuttle</h1>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Form Area -->
            <div class="flex-grow">
                <form action="{{ route('booking.shuttles.store', $shuttle) }}" method="POST" class="bg-canvas-white p-6 md:p-8 rounded-btn-card border border-soft-divider shadow-sm" id="bookingForm" onsubmit="disableSubmitButton(this)">
                    @csrf

                    <h3 class="text-xl font-bold text-carbon-black mb-6">Detail Pemesanan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-carbon-black mb-2">Tanggal Layanan <span class="text-red-500">*</span></label>
                            <input type="date" name="booking_date" value="{{ old('booking_date') }}" required min="{{ date('Y-m-d') }}" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">
                            <x-form-error :messages="$errors->get('booking_date')" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-carbon-black mb-2">Waktu Penjemputan di Area Hotel (Opsional)</label>
                            <input type="time" name="pickup_time" value="{{ old('pickup_time') }}" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">
                            <x-form-error :messages="$errors->get('pickup_time')" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-carbon-black mb-2">Jumlah Penumpang <span class="text-red-500">*</span></label>
                        <input type="number" name="passenger_count" id="passenger_count" value="{{ old('passenger_count', 1) }}" min="1" required class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black" oninput="calculateTotal()">
                        <x-form-error :messages="$errors->get('passenger_count')" />
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-carbon-black mb-2">Catatan Khusus</label>
                        <textarea name="note" rows="3" placeholder="Contoh: Penjemputan di depan hotel XXX, Jl. Pantai Kuta No. 1" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">{{ old('note') }}</textarea>
                        <x-form-error :messages="$errors->get('note')" />
                    </div>

                    <x-coupon-input
                        :validate-url="route('api.coupons.validate')"
                        :total-price="$shuttle->price"
                        :old-coupon-code="old('coupon_code', '')"
                    />

                    <div class="border-t border-soft-divider pt-6 mt-6">
                        <x-primary-button type="submit" class="w-full">Lanjutkan &amp; Konfirmasi Pemesanan</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Summary Area -->
            <div class="w-full md:w-96 flex-shrink-0">
                <div class="bg-faint-gray p-6 rounded-btn-card border border-soft-divider sticky top-24">
                    <h3 class="text-lg font-bold text-carbon-black mb-4">Ringkasan Shuttle</h3>

                    <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-soft-divider">
                        <div>
                            <div class="font-bold text-carbon-black">{{ $shuttle->route_name }}</div>
                            <div class="text-sm text-storm-gray">Estimasi: {{ $shuttle->estimated_duration ?? '-' }}</div>
                        </div>
                    </div>

                    <ul class="space-y-3 text-sm text-carbon-black mb-6">
                        <li class="flex justify-between">
                            <span class="text-storm-gray">Penyewa</span>
                            <span class="font-medium text-right">{{ auth()->user()->name }}<br><span class="text-xs text-storm-gray">{{ auth()->user()->phone }}</span></span>
                        </li>
                        <li class="flex justify-between pt-3 border-t border-soft-divider pb-6">
                            <span class="text-storm-gray">Harga per Penumpang</span>
                            <span class="font-medium">Rp {{ number_format($shuttle->price, 0, ',', '.') }}</span>
                        </li>
                    </ul>

                    <div class="space-y-3 text-sm text-carbon-black mb-6">
                        <div class="flex justify-between items-center" id="summarySubtotalRow">
                            <span class="text-storm-gray">Subtotal</span>
                            <span class="font-medium" id="summarySubtotal">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center text-green-600 hidden" id="summaryDiscountRow">
                            <span>Diskon Kupon</span>
                            <span class="font-medium" id="summaryDiscount">- Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-soft-divider mt-3">
                            <span class="font-bold text-carbon-black">Total Akhir</span>
                            <span class="font-bold text-xl text-carbon-black" id="summaryTotal">Rp 0</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-2.5 p-4 bg-faint-gray rounded-btn text-sm text-storm-gray border border-soft-divider">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Selesaikan pembayaran dalam <strong class="text-carbon-black">24 jam</strong> setelah pemesanan dibuat, atau pesanan akan otomatis dibatalkan.</span>
                    </div>
                </div>
            </div>
        </div>
    </x-page-container>
</div>

<script>
    window.getCurrentTotalPrice = function() {
        const passengerCount = document.getElementById('passenger_count').value || 1;
        const pricePerPassenger = {{ $shuttle->price }};
        return pricePerPassenger * passengerCount;
    };

    let currentDiscount = 0;

    window.applyDiscountToSummary = function(discount) {
        currentDiscount = discount;
        updateSummaryDisplay();
    };

    function updateSummaryDisplay() {
        const subtotal = window.getCurrentTotalPrice();
        let total = subtotal - currentDiscount;
        if (total < 0) total = 0;

        const subtotalEl = document.getElementById('summarySubtotal');
        const totalEl = document.getElementById('summaryTotal');
        const discountRow = document.getElementById('summaryDiscountRow');
        const discountEl = document.getElementById('summaryDiscount');

        if (subtotalEl) subtotalEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        if (totalEl) totalEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);

        if (discountRow && discountEl) {
            if (currentDiscount > 0) {
                discountEl.innerText = '- Rp ' + new Intl.NumberFormat('id-ID').format(currentDiscount);
                discountRow.classList.remove('hidden');
            } else {
                discountRow.classList.add('hidden');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateSummaryDisplay();
        
        const passengerInput = document.getElementById('passenger_count');
        if (passengerInput) {
            passengerInput.addEventListener('input', updateSummaryDisplay);
        }
    });
    
    function disableSubmitButton(form) {
        const btn = form.querySelector('button[type="submit"]');
        if (btn) {
            setTimeout(() => {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
                btn.innerHTML = 'Memproses...';
            }, 10);
        }
    }
    
    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
@endsection
