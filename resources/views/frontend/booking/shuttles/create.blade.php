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
                <form action="{{ route('booking.shuttles.store', $shuttle) }}" method="POST" class="bg-canvas-white p-6 md:p-8 rounded-btn-card border border-soft-divider shadow-sm" id="bookingForm">
                    @csrf
                    
                    <h3 class="text-xl font-bold text-carbon-black mb-6">Detail Pemesanan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-carbon-black mb-2">Tanggal Layanan <span class="text-red-500">*</span></label>
                            <input type="date" name="booking_date" value="{{ old('booking_date') }}" required min="{{ date('Y-m-d') }}" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">
                            <x-form-error :messages="$errors->get('booking_date')" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-carbon-black mb-2">Waktu Penjemputan (Opsional)</label>
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
                        <textarea name="note" rows="3" placeholder="Contoh: Kami menunggu di lobby bagian timur" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">{{ old('note') }}</textarea>
                        <x-form-error :messages="$errors->get('note')" />
                    </div>

                    <div class="border-t border-soft-divider pt-6">
                        <x-primary-button type="submit" class="w-full">Lanjutkan & Konfirmasi Pemesanan</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Summary Area -->
            <div class="w-full md:w-96 flex-shrink-0">
                <div class="bg-faint-gray p-6 rounded-btn-card border border-soft-divider sticky top-24">
                    <h3 class="text-lg font-bold text-carbon-black mb-4">Ringkasan Shuttle</h3>
                    
                    <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-soft-divider">
                        <div>
                            <div class="font-bold text-carbon-black">{{ $shuttle->hotel_name }}</div>
                            <div class="text-sm text-storm-gray">Jadwal: {{ $shuttle->schedule }}</div>
                        </div>
                    </div>
                    
                    <ul class="space-y-3 text-sm text-carbon-black mb-6">
                        <li class="flex justify-between">
                            <span class="text-storm-gray">Penyewa</span>
                            <span class="font-medium text-right">{{ auth()->user()->name }}<br><span class="text-xs text-storm-gray">{{ auth()->user()->phone }}</span></span>
                        </li>
                        <li class="flex justify-between pt-3 border-t border-soft-divider">
                            <span class="text-storm-gray">Harga per Penumpang</span>
                            <span class="font-medium" id="basePrice" data-price="{{ $shuttle->price }}">Rp {{ number_format($shuttle->price, 0, ',', '.') }}</span>
                        </li>
                    </ul>

                    <div class="p-4 bg-yellow-50 text-yellow-800 rounded-btn text-sm mb-4">
                        <div class="flex justify-between items-center font-bold">
                            <span>Estimasi Total:</span>
                            <span class="text-lg" id="estimatedTotal">Rp {{ number_format($shuttle->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-page-container>
</div>

<script>
    function calculateTotal() {
        const basePrice = parseInt(document.getElementById('basePrice').getAttribute('data-price'));
        let count = parseInt(document.getElementById('passenger_count').value);
        if(isNaN(count) || count < 1) count = 1;
        
        const total = basePrice * count;
        document.getElementById('estimatedTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
@endsection
