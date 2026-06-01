@extends('layouts.app')

@section('content')
<div class="py-12">
    <x-page-container>
        <div class="mb-6">
            <a href="{{ route('transfers.show', $transfer) }}" class="text-sm font-medium text-storm-gray hover:text-carbon-black">&larr; Kembali ke Detail Rute</a>
        </div>

        <h1 class="text-3xl font-bold text-carbon-black mb-8">Form Pemesanan Airport Transfer</h1>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Form Area -->
            <div class="flex-grow">
                <form action="{{ route('booking.transfers.store', $transfer) }}" method="POST" class="bg-canvas-white p-6 md:p-8 rounded-btn-card border border-soft-divider shadow-sm">
                    @csrf
                    
                    <h3 class="text-xl font-bold text-carbon-black mb-6">Detail Penjemputan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-carbon-black mb-2">Tanggal Layanan <span class="text-red-500">*</span></label>
                            <input type="date" name="booking_date" value="{{ old('booking_date') }}" required min="{{ date('Y-m-d') }}" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">
                            <x-form-error :messages="$errors->get('booking_date')" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-carbon-black mb-2">Waktu Jemput (Opsional)</label>
                            <input type="time" name="pickup_time" value="{{ old('pickup_time') }}" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">
                            <x-form-error :messages="$errors->get('pickup_time')" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-carbon-black mb-2">Jumlah Penumpang <span class="text-red-500">*</span></label>
                            <input type="number" name="passenger_count" value="{{ old('passenger_count', 1) }}" min="1" required class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">
                            <x-form-error :messages="$errors->get('passenger_count')" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-carbon-black mb-2">Nomor Penerbangan (Opsional)</label>
                            <input type="text" name="flight_number" value="{{ old('flight_number') }}" placeholder="Misal: GA-412" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">
                            <span class="text-xs text-storm-gray mt-1 block">Bantu kami melacak keterlambatan pesawat Anda.</span>
                            <x-form-error :messages="$errors->get('flight_number')" />
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-carbon-black mb-2">Catatan Khusus</label>
                        <textarea name="note" rows="3" placeholder="Contoh: Bawa 2 koper besar" class="w-full border border-soft-divider rounded-btn p-3 focus:outline-none focus:border-carbon-black">{{ old('note') }}</textarea>
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
                    <h3 class="text-lg font-bold text-carbon-black mb-4">Ringkasan Rute</h3>
                    
                    <div class="flex items-start space-x-4 mb-6 pb-6 border-b border-soft-divider">
                        <div class="flex flex-col items-center mt-1">
                            <div class="w-2 h-2 rounded-btn-full bg-carbon-black"></div>
                            <div class="w-px h-8 bg-carbon-black"></div>
                            <div class="w-2 h-2 border-2 border-carbon-black rounded-btn-full bg-canvas-white"></div>
                        </div>
                        <div class="flex flex-col space-y-4">
                            <div>
                                <div class="text-xs text-storm-gray">Penjemputan</div>
                                <div class="font-bold text-carbon-black text-sm">{{ $transfer->pickup_location }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-storm-gray">Tujuan</div>
                                <div class="font-bold text-carbon-black text-sm">{{ $transfer->dropoff_location }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <ul class="space-y-3 text-sm text-carbon-black mb-6">
                        <li class="flex justify-between">
                            <span class="text-storm-gray">Penyewa</span>
                            <span class="font-medium text-right">{{ auth()->user()->name }}<br><span class="text-xs text-storm-gray">{{ auth()->user()->phone }}</span></span>
                        </li>
                    </ul>

                    <div class="p-4 bg-yellow-50 text-yellow-800 rounded-btn text-sm mb-4">
                        <div class="flex justify-between items-center font-bold">
                            <span>Total Harga:</span>
                            <span class="text-lg">Rp {{ number_format($transfer->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-xs mt-1 font-normal opacity-80">Harga tetap per kendaraan untuk rute ini.</div>
                    </div>
                </div>
            </div>
        </div>
    </x-page-container>
</div>
@endsection
