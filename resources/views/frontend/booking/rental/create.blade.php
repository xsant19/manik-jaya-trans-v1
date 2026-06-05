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
                <form action="{{ route('booking.rental.store', $vehicle) }}" method="POST" class="bg-canvas-white p-6 md:p-8 rounded-btn-card border border-soft-divider shadow-sm">
                    @csrf

                    <h3 class="text-xl font-bold text-carbon-black mb-6">Detail Layanan</h3>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-carbon-black mb-2">Tipe Sewa <span class="text-red-500">*</span></label>
                        <select name="rental_type" required class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black" onchange="toggleEndDate(this.value)">
                            <option value="full_day" {{ old('rental_type') == 'full_day' ? 'selected' : '' }}>Sehari Penuh (Full Day) - Rp {{ number_format($vehicle->price_full_day, 0, ',', '.') }} / Hari</option>
                            <option value="half_day" {{ old('rental_type') == 'half_day' ? 'selected' : '' }}>Setengah Hari (Half Day) - Rp {{ number_format($vehicle->price_half_day, 0, ',', '.') }} / 12 Jam</option>
                        </select>
                        <x-form-error :messages="$errors->get('rental_type')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-carbon-black mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">
                            <x-form-error :messages="$errors->get('start_date')" />
                        </div>
                        <div id="endDateContainer">
                            <label class="block text-sm font-medium text-carbon-black mb-2">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">
                            <span class="text-xs text-storm-gray mt-1 block">Kosongkan jika hanya menyewa 1 hari.</span>
                            <x-form-error :messages="$errors->get('end_date')" />
                        </div>
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

                    <div class="border-t border-soft-divider pt-6">
                        <x-primary-button type="submit" class="w-full">Lanjutkan & Konfirmasi Pemesanan</x-primary-button>
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

                    <ul class="space-y-3 text-sm text-carbon-black mb-6">
                        <li class="flex justify-between">
                            <span class="text-storm-gray">Penyewa</span>
                            <span class="font-medium text-right">{{ auth()->user()->name }}<br><span class="text-xs text-storm-gray">{{ auth()->user()->phone }}</span></span>
                        </li>
                    </ul>

                    <div class="p-4 bg-yellow-50 text-yellow-800 rounded-btn text-sm mb-4">
                        <strong>Perhatian:</strong> Total harga final akan dihitung secara otomatis oleh sistem setelah Anda menekan tombol Lanjutkan.
                    </div>
                </div>
            </div>
        </div>
    </x-page-container>
</div>

<script>
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
    // init on load
    document.addEventListener('DOMContentLoaded', () => toggleEndDate(document.querySelector('select[name="rental_type"]').value));
</script>
@endsection
