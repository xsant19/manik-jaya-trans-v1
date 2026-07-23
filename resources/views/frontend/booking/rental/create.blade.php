@extends('layouts.app')

@section('content')
<div class="py-12">
    <x-page-container>
        <div class="mb-6">
            <a href="{{ route('vehicles.show', $vehicle) }}" class="text-sm font-medium text-storm-gray hover:text-carbon-black">&larr; Kembali ke Detail Kendaraan</a>
        </div>

        <h1 class="text-3xl font-bold text-carbon-black mb-8">Form Pemesanan Kendaraan</h1>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Form Area -->
            <div class="flex-grow">
                <form action="{{ route('booking.rental.store', $vehicle) }}" method="POST" class="bg-canvas-white p-6 md:p-8 rounded-btn-card border border-soft-divider shadow-sm" onsubmit="disableSubmitButton(this)">
                    @csrf

                    <h3 class="text-xl font-bold text-carbon-black mb-6">Detail Layanan</h3>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-carbon-black mb-2">Tipe Sewa <span class="text-red-500">*</span></label>
                        <select name="rental_type" id="rental_type" required class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black" onchange="toggleEndDate(this.value); resetAvailability();">
                            <option value="full_day" {{ old('rental_type') == 'full_day' ? 'selected' : '' }}>Sehari Penuh (Full Day) - Rp {{ number_format($vehicle->price_full_day, 0, ',', '.') }} / Hari</option>
                            <option value="half_day" {{ old('rental_type') == 'half_day' ? 'selected' : '' }}>Setengah Hari (Half Day) - Rp {{ number_format($vehicle->price_half_day, 0, ',', '.') }} / 12 Jam</option>
                        </select>
                        <x-form-error :messages="$errors->get('rental_type')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-carbon-black mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black" onchange="resetAvailability()">
                            <x-form-error :messages="$errors->get('start_date')" />
                        </div>
                        <div id="endDateContainer">
                            <label class="block text-sm font-medium text-carbon-black mb-2">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black" onchange="resetAvailability()">
                            <span class="text-xs text-storm-gray mt-1 block">Kosongkan jika hanya menyewa 1 hari.</span>
                            <x-form-error :messages="$errors->get('end_date')" />
                        </div>
                    </div>

                    <div class="mb-6 flex flex-col sm:flex-row items-center gap-4">
                        <button type="button" id="btnCheckAvailability" onclick="checkAvailability()" class="px-5 py-2.5 text-sm font-semibold rounded-btn border border-carbon-black text-carbon-black bg-canvas-white hover:bg-faint-gray transition-colors">
                            Cek Ketersediaan
                        </button>
                        <div id="availabilityMessage" class="text-sm font-medium"></div>
                    </div>

                    <h3 class="text-xl font-bold text-carbon-black mb-6 mt-10">Informasi Penjemputan</h3>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-carbon-black mb-2">Lokasi Jemput/Antar <span class="text-red-500">*</span></label>
                        <input type="text" name="pickup_location" value="{{ old('pickup_location') }}" required placeholder="Contoh: Bandara Ngurah Rai atau Hotel Aston Denpasar" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">
                        <x-form-error :messages="$errors->get('pickup_location')" />
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-carbon-black mb-2">Catatan Khusus</label>
                        <textarea name="note" rows="3" placeholder="Contoh: Tolong sediakan kursi bayi" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">{{ old('note') }}</textarea>
                        <x-form-error :messages="$errors->get('note')" />
                    </div>

                    <x-coupon-input
                        :validate-url="route('api.coupons.validate')"
                        :total-price="$vehicle->price_full_day"
                        :old-coupon-code="old('coupon_code', '')"
                    />

                    <div class="border-t border-soft-divider pt-6 mt-6">
                        <x-primary-button type="submit" id="submitBtn" class="w-full opacity-50 cursor-not-allowed" disabled>Lanjutkan &amp; Konfirmasi Pemesanan</x-primary-button>
                        <p class="text-xs text-center text-storm-gray mt-3">Silakan 'Cek Ketersediaan' terlebih dahulu untuk melanjutkan pesanan.</p>
                    </div>
                </form>
            </div>

            <!-- Summary Area -->
            <div class="w-full md:w-96 flex-shrink-0">
                <div class="bg-faint-gray p-6 rounded-btn-card border border-soft-divider sticky top-24">
                    <h3 class="text-lg font-bold text-carbon-black mb-4">Ringkasan Pesanan</h3>

                    <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-soft-divider">
                        <div>
                            <div class="font-bold text-carbon-black">{{ $vehicle->name }}</div>
                            <div class="text-sm text-storm-gray">{{ $vehicle->type }} &bull; Kapasitas {{ $vehicle->capacity }}</div>
                        </div>
                    </div>

                    <ul class="space-y-3 text-sm text-carbon-black mb-6 border-b border-soft-divider pb-6">
                        <li class="flex justify-between">
                            <span class="text-storm-gray">Penyewa</span>
                            <span class="font-medium text-right">{{ auth()->user()->name }}<br><span class="text-xs text-storm-gray">{{ auth()->user()->phone }}</span></span>
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
        const rentalType = document.getElementById('rental_type').value;
        const startDateStr = document.getElementById('start_date').value;
        const endDateStr = document.getElementById('end_date').value;

        const priceFullDay = {{ $vehicle->price_full_day }};
        const priceHalfDay = {{ $vehicle->price_half_day }};

        if (rentalType === 'half_day') {
            return priceHalfDay;
        }

        if (startDateStr) {
            const start = new Date(startDateStr);
            start.setHours(0,0,0,0);

            let end = start;
            if (endDateStr) {
                end = new Date(endDateStr);
                end.setHours(0,0,0,0);
            }

            if (end >= start) {
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                return priceFullDay * diffDays;
            }
        }

        return priceFullDay;
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

    // Panggil saat pertama kali load
    document.addEventListener('DOMContentLoaded', function() {
        updateSummaryDisplay();
        
        // Pasang event listener pada input yang mempengaruhi harga
        document.getElementById('rental_type').addEventListener('change', updateSummaryDisplay);
        document.getElementById('start_date').addEventListener('change', updateSummaryDisplay);
        document.getElementById('end_date').addEventListener('change', updateSummaryDisplay);
    });

    function toggleEndDate(val) {
        const container = document.getElementById('endDateContainer');
        const input = document.getElementById('end_date');
        if (val === 'half_day') {
            container.style.opacity = '0.5';
            input.disabled = true;
            input.value = '';
        } else {
            container.style.opacity = '1';
            input.disabled = false;
        }
    }

    function resetAvailability() {
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').classList.add('opacity-50', 'cursor-not-allowed');
        document.getElementById('availabilityMessage').innerHTML = '';
    }

    async function checkAvailability() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const rentalType = document.getElementById('rental_type').value;
        const msgContainer = document.getElementById('availabilityMessage');
        const btn = document.getElementById('btnCheckAvailability');
        const submitBtn = document.getElementById('submitBtn');

        if (!startDate) {
            msgContainer.innerHTML = '<span class="text-red-600">Pilih tanggal mulai terlebih dahulu.</span>';
            return;
        }

        btn.disabled = true;
        btn.innerHTML = 'Mengecek...';
        msgContainer.innerHTML = '';

        try {
            const response = await fetch('{{ route('booking.rental.check-availability', $vehicle) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    start_date: startDate,
                    end_date: endDate,
                    rental_type: rentalType
                })
            });

            const result = await response.json();

            if (result.available) {
                msgContainer.innerHTML = `<span class="text-green-600">${result.message}</span>`;
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                msgContainer.innerHTML = `<span class="text-red-600">${result.message}</span>`;
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        } catch (error) {
            msgContainer.innerHTML = '<span class="text-red-600">Terjadi kesalahan. Silakan coba lagi.</span>';
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Cek Ketersediaan';
        }
    }

    // init on load
    document.addEventListener('DOMContentLoaded', () => {
        toggleEndDate(document.getElementById('rental_type').value);
        // If there are old inputs (validation failed), user has to re-check
        resetAvailability();
    });

    function disableSubmitButton(form) {
        const btn = document.getElementById('submitBtn');
        if (btn) {
            setTimeout(() => {
                btn.disabled = true;
                btn.innerHTML = 'Memproses...';
            }, 10);
        }
    }
</script>
@endsection
