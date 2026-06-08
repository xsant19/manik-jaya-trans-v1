@extends('layouts.app')

@section('content')
<div class="py-12">
    <x-page-container>
        <div class="mb-6">
            <a href="{{ route('shuttles.index') }}" class="text-sm font-medium text-storm-gray hover:text-carbon-black">&larr; Kembali ke Hotel Shuttle</a>
        </div>
        
        <div class="flex flex-col md:flex-row gap-12">
            <!-- Details -->
            <div class="flex-grow">
                <h1 class="text-4xl font-bold text-carbon-black mb-8">{{ $shuttle->route_name }}</h1>
                
                <h3 class="text-xl font-bold text-carbon-black mb-4">Detail Rute</h3>
                
                <div class="bg-faint-gray p-6 rounded-card border border-soft-divider mb-8">
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-carbon-black rounded-full flex items-center justify-center text-canvas-white font-bold mr-4">
                                A
                            </div>
                            <div class="flex-grow">
                                <div class="text-sm text-storm-gray mb-1">Lokasi Penjemputan</div>
                                <div class="text-lg font-bold text-carbon-black">{{ $shuttle->pickup_location }}</div>
                            </div>
                        </div>
                        
                        <div class="ml-6 border-l-2 border-soft-divider h-8"></div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-carbon-black rounded-full flex items-center justify-center text-canvas-white font-bold mr-4">
                                B
                            </div>
                            <div class="flex-grow">
                                <div class="text-sm text-storm-gray mb-1">Lokasi Tujuan</div>
                                <div class="text-lg font-bold text-carbon-black">{{ $shuttle->dropoff_location }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($shuttle->estimated_duration)
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-carbon-black mb-4">Estimasi Waktu</h3>
                        <div class="flex items-center text-storm-gray">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-lg">{{ $shuttle->estimated_duration }}</span>
                        </div>
                    </div>
                @endif
                
                <h3 class="text-xl font-bold text-carbon-black mb-4">Harga Shuttle</h3>
                <div class="p-6 border border-soft-divider rounded-card inline-block">
                    <div class="text-sm text-storm-gray mb-1">Per Orang</div>
                    <div class="text-3xl font-bold text-carbon-black">Rp {{ number_format($shuttle->price, 0, ',', '.') }}</div>
                </div>
                
                <div class="mt-8 p-6 bg-faint-gray rounded-card border border-soft-divider">
                    <h4 class="font-bold text-carbon-black mb-3">Layanan Termasuk:</h4>
                    <ul class="space-y-2 text-sm text-storm-gray">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-carbon-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Driver profesional dan berpengalaman
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-carbon-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Kendaraan ber-AC dan nyaman
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-carbon-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Bantuan dengan bagasi
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-carbon-black flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Tepat waktu dan dapat diandalkan
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Booking Card -->
            <div class="w-full md:w-96 flex-shrink-0">
                <div class="sticky top-24 space-y-4">
                    
                    {{-- Booking Card --}}
                    <div class="overflow-hidden rounded-card border border-soft-divider bg-canvas-white">
                        {{-- Price Header --}}
                        <div class="border-b border-soft-divider px-6 py-5">
                            <p class="text-sm text-storm-gray">Harga per orang</p>
                            <p class="mt-1 text-3xl font-bold text-carbon-black">
                                Rp {{ number_format($shuttle->price, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Shuttle Info Summary --}}
                        <div class="divide-y divide-soft-divider px-6">
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Dari</span>
                                <span class="font-medium text-carbon-black text-right">{{ Str::limit($shuttle->pickup_location, 20) }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Ke</span>
                                <span class="font-medium text-carbon-black text-right">{{ Str::limit($shuttle->dropoff_location, 20) }}</span>
                            </div>
                            @if($shuttle->estimated_duration)
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Estimasi Waktu</span>
                                <span class="font-medium text-carbon-black">{{ $shuttle->estimated_duration }}</span>
                            </div>
                            @endif
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Driver & Kendaraan</span>
                                <span class="font-medium text-carbon-black">Termasuk</span>
                            </div>
                        </div>

                        {{-- CTA --}}
                        <div class="px-6 pb-6 pt-4">
                            @auth
                                <a href="{{ route('booking.shuttles.create', $shuttle) }}" class="block w-full">
                                    <button type="button"
                                            class="w-full rounded-btn bg-carbon-black px-6 py-3.5 text-sm font-semibold text-canvas-white transition-opacity hover:opacity-90">
                                        Booking Sekarang
                                    </button>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="block w-full">
                                    <button type="button"
                                            class="w-full rounded-btn bg-carbon-black px-6 py-3.5 text-sm font-semibold text-canvas-white transition-opacity hover:opacity-90">
                                        Masuk untuk Booking
                                    </button>
                                </a>
                                <p class="mt-3 text-center text-xs text-storm-gray">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}" class="font-medium text-carbon-black hover:underline">Daftar gratis</a>
                                </p>
                            @endauth
                        </div>
                    </div>

                    {{-- Help Card --}}
                    <div class="rounded-card border border-soft-divider bg-faint-gray px-5 py-4">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 size-5 shrink-0 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-carbon-black">Butuh bantuan?</p>
                                <p class="mt-1 text-xs leading-relaxed text-storm-gray mb-3">
                                    Hubungi kami via WhatsApp untuk pertanyaan seputar hotel shuttle ini.
                                </p>
                                <a href="https://wa.me/{{ config('company.phone_intl') }}?text=Halo,%20saya%20ingin%20bertanya%20tentang%20{{ urlencode($shuttle->route_name) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 text-xs font-medium text-carbon-black hover:underline">
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                    Chat via WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </x-page-container>
</div>
@endsection
