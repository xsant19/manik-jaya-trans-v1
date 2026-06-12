@extends('layouts.app')

@section('content')
<x-page-container class="py-16">
    <div class="max-w-xl mx-auto text-center">
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>
        
        <x-section-heading class="mb-4 text-carbon-black">Pembayaran Gagal</x-section-heading>
        
        <p class="text-storm-gray mb-8">
            Maaf, pembayaran Anda tidak dapat diproses atau dibatalkan. Silakan coba lagi atau gunakan metode pembayaran yang berbeda.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('customer.bookings.index') }}" class="inline-flex items-center justify-center bg-carbon-black text-canvas-white px-8 py-4 rounded-lg font-medium hover:bg-black transition-colors">
                Kembali ke Riwayat Booking
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center bg-transparent border border-soft-divider text-carbon-black px-8 py-4 rounded-lg font-medium hover:bg-faint-gray transition-colors">
                Ke Halaman Utama
            </a>
        </div>
    </div>
</x-page-container>
@endsection
