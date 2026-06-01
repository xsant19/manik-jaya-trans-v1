@extends('layouts.app')

@section('content')
<div class="py-12 bg-faint-gray border-b border-soft-divider">
    <x-page-container>
        <h1 class="text-4xl font-bold text-carbon-black mb-4">Hotel Shuttle</h1>
        <p class="text-storm-gray text-lg max-w-2xl">Layanan shuttle hotel yang nyaman dan terjadwal. Perjalanan aman dari dan ke hotel pilihan Anda.</p>
    </x-page-container>
</div>

<div class="py-16">
    <x-page-container>
        @if($shuttles->isEmpty())
            <div class="text-center py-16">
                <p class="text-storm-gray text-lg">Belum ada layanan hotel shuttle tersedia saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($shuttles as $shuttle)
                    <a href="{{ route('shuttles.show', $shuttle) }}" class="block group">
                        <x-service-card>
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-carbon-black group-hover:underline mb-3">{{ $shuttle->hotel_name }}</h3>
                                
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 text-storm-gray flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <div>
                                            <div class="text-storm-gray">Dari</div>
                                            <div class="text-carbon-black font-medium">{{ $shuttle->pickup_location }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 text-storm-gray flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <div>
                                            <div class="text-storm-gray">Ke</div>
                                            <div class="text-carbon-black font-medium">{{ $shuttle->dropoff_location }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($shuttle->schedule)
                                    <div class="mt-3 text-xs text-storm-gray flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $shuttle->schedule }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex justify-between items-center mt-auto pt-4 border-t border-soft-divider">
                                <span class="text-sm text-dust-bunny">Harga</span>
                                <span class="font-bold text-carbon-black">Rp {{ number_format($shuttle->price, 0, ',', '.') }}</span>
                            </div>
                        </x-service-card>
                    </a>
                @endforeach
            </div>
        @endif
    </x-page-container>
</div>
@endsection
