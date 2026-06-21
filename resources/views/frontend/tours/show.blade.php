@extends('layouts.app')

@section('content')

{{-- ── Breadcrumb ── --}}
<div class="border-b border-soft-divider bg-canvas-white">
    <x-page-container>
        <div class="py-4">
            <a href="{{ route('tours.index') }}"
               class="inline-flex items-center gap-1.5 text-sm font-medium text-storm-gray transition-colors hover:text-carbon-black">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Kembali ke Paket Wisata
            </a>
        </div>
    </x-page-container>
</div>

{{-- ── Image Grid (Airbnb-style) ── --}}
<div class="bg-canvas-white">
    <x-page-container>
        <div class="py-6">
            @if($tour->imageUrls)
                {{-- Desktop Grid (Hidden on Mobile) --}}
                <div class="hidden md:grid grid-cols-4 grid-rows-2 gap-2 overflow-hidden rounded-card h-[480px]">
                    {{-- Large left cell --}}
                    <div class="relative bg-pale-drift col-span-2 row-span-2 overflow-hidden">
                        <img src="{{ asset($tour->imageUrls[0]) }}"
                             alt="{{ $tour->name }}"
                             class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 hover:scale-105" />
                    </div>
                    {{-- 4 small right cells --}}
                    @for($i = 1; $i <= min(4, count($tour->imageUrls) - 1); $i++)
                        <div class="relative bg-faint-gray overflow-hidden">
                           <img src="{{ asset($tour->imageUrls[$i]) }}"
                                 alt="{{ $tour->name }} - Image {{ $i+1 }}"
                                 class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 hover:scale-105" />
                        </div>
                    @endfor
                </div>

                {{-- Mobile Carousel (Hidden on Desktop) --}}
                <div class="md:hidden flex overflow-x-auto snap-x snap-mandatory rounded-card h-[300px]" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        .md\:hidden::-webkit-scrollbar { display: none; }
                    </style>
                    @foreach($tour->imageUrls as $index => $url)
                        <div class="min-w-full shrink-0 snap-center relative bg-pale-drift">
                            <img src="{{ asset($url) }}" 
                                 alt="{{ $tour->name }} - Slide {{ $index + 1 }}" 
                                 class="absolute inset-0 h-full w-full object-cover" />
                            
                            {{-- Image Counter Badge --}}
                            <div class="absolute bottom-3 right-3 bg-carbon-black/70 text-canvas-white text-xs font-medium px-2 py-1 rounded-md backdrop-blur-sm">
                                {{ $index + 1 }} / {{ count($tour->imageUrls) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- No image: Desktop Placeholder --}}
                <div class="hidden md:grid grid-cols-4 grid-rows-2 gap-2 overflow-hidden rounded-card h-[480px]">
                    <div class="flex items-center justify-center bg-pale-drift col-span-2 row-span-2">
                        <svg class="size-16 text-dust-bunny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    @for($i = 1; $i <= 4; $i++)
                        <div class="flex items-center justify-center bg-faint-gray">
                            <svg class="size-8 text-dust-bunny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                    @endfor
                </div>

                {{-- No image: Mobile Placeholder --}}
                <div class="md:hidden flex h-[300px] items-center justify-center bg-pale-drift rounded-card overflow-hidden">
                    <svg class="size-12 text-dust-bunny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
            @endif
        </div>
    </x-page-container>
</div>

{{-- ── Main Content ── --}}
<div class="bg-canvas-white pb-24">
    <x-page-container>
        <div class="flex flex-col gap-12 lg:flex-row lg:gap-16">

            {{-- ════════════════════════════════════════
                 KOLOM KIRI — Detail Tour (70%)
            ════════════════════════════════════════ --}}
            <div class="min-w-0 flex-1">

                {{-- Title + Meta --}}
                <div class="mb-8 border-b border-soft-divider pb-8">
                    <div class="mb-3 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1 rounded-btn bg-faint-gray px-3 py-1 text-xs font-medium text-storm-gray">
                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 11l19-9-9 19-2-8-8-2z"/>
                            </svg>
                            Private Tour
                        </span>
                        <span class="inline-flex items-center gap-1 rounded-btn bg-faint-gray px-3 py-1 text-xs font-medium text-storm-gray">
                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                            All Inclusive
                        </span>
                        <span class="inline-flex items-center gap-1 rounded-btn bg-faint-gray px-3 py-1 text-xs font-medium text-storm-gray">
                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                            Hotel Pickup
                        </span>
                    </div>
                    <h1 class="mb-4 text-3xl font-bold leading-tight tracking-tight text-carbon-black md:text-4xl">
                        {{ $tour->name }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-5 text-sm text-storm-gray">
                        <span class="flex items-center gap-1.5">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span class="font-medium text-carbon-black">{{ $tour->duration }}</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            <span>Maks. <span class="font-medium text-carbon-black">6 orang</span> (Std. MPV)</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            Bali, Indonesia
                        </span>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-10 border-b border-soft-divider pb-10">
                    <h2 class="mb-4 text-xl font-bold text-carbon-black">Tentang Paket Ini</h2>
                    <div class="fi-prose prose prose-sm max-w-none text-storm-gray">
                        {!! str($tour->description)->sanitizeHtml() !!}
                    </div>
                </div>

                {{-- Itinerary (Timeline) --}}
                @if($tour->itinerary)
                    <div class="mb-10 border-b border-soft-divider pb-10">
                        <h2 class="mb-6 text-xl font-bold text-carbon-black">Itinerary</h2>
                        <ol class="space-y-0">
                            @php
                                $items = array_filter(array_map('trim', explode("\n", $tour->itinerary)));
                            @endphp
                            @foreach($items as $i => $item)
                                @php
                                    // Split "HH:MM - Label" or just use full string
                                    $parts = explode(' - ', $item, 2);
                                    $time  = isset($parts[1]) ? trim($parts[0]) : null;
                                    $label = isset($parts[1]) ? trim($parts[1]) : trim($parts[0]);
                                    $isLast = $loop->last;
                                @endphp
                                <li class="relative flex gap-4 {{ $isLast ? '' : 'pb-6' }}">
                                    {{-- Timeline line --}}
                                    @if(!$isLast)
                                        <div class="absolute left-[11px] top-6 h-full w-px bg-soft-divider"></div>
                                    @endif

                                    {{-- Dot --}}
                                    <div class="relative mt-1 flex size-6 shrink-0 items-center justify-center rounded-full border-2 border-carbon-black bg-canvas-white">
                                        <div class="size-2 rounded-full bg-carbon-black"></div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 pb-1">
                                        @if($time)
                                            <p class="mb-0.5 text-xs font-semibold uppercase tracking-wider text-dust-bunny">{{ $time }}</p>
                                        @endif
                                        <p class="font-medium text-carbon-black">{{ $label }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                {{-- Termasuk & Tidak Termasuk --}}
                <div class="mb-10 border-b border-soft-divider pb-10">
                    <h2 class="mb-6 text-xl font-bold text-carbon-black">Fasilitas Paket</h2>
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                        {{-- Termasuk --}}
                        <div>
                            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-storm-gray">Termasuk</h3>
                            <ul class="space-y-3">
                                @php
                                    $includes = [
                                        'Kendaraan AC ber-AC (Minibus/MPV)',
                                        'Driver berpengalaman & ramah',
                                        'Biaya parkir & tol',
                                        'Penjemputan & pengantaran hotel',
                                        'Air mineral selama perjalanan',
                                        'Tiket masuk objek wisata',
                                    ];
                                @endphp
                                @foreach($includes as $item)
                                    <li class="flex items-start gap-3 text-sm text-storm-gray">
                                        <span class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-carbon-black text-canvas-white">
                                            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                        </span>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Tidak Termasuk --}}
                        <div>
                            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-storm-gray">Tidak Termasuk</h3>
                            <ul class="space-y-3">
                                @php
                                    $excludes = [
                                        'Konsumsi makan siang & malam',
                                        'Pengeluaran pribadi',
                                        'Tips untuk driver & guide',
                                        'Biaya loker atau penyewaan perlengkapan',
                                    ];
                                @endphp
                                @foreach($excludes as $item)
                                    <li class="flex items-start gap-3 text-sm text-storm-gray">
                                        <span class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full border border-soft-divider bg-faint-gray text-storm-gray">
                                            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                            </svg>
                                        </span>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Area Penjemputan --}}
                <div class="mb-10">
                    <h2 class="mb-4 text-xl font-bold text-carbon-black">Area Penjemputan</h2>
                    <div class="rounded-card border border-soft-divider bg-faint-gray p-5">
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 shrink-0 rounded-btn bg-carbon-black p-1.5 text-canvas-white">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                            </span>
                            <div>
                                <p class="mb-1 font-semibold text-carbon-black">Area Layanan Penjemputan</p>
                                <p class="text-sm leading-relaxed text-storm-gray">
                                    Kuta, Seminyak, Legian, Canggu, Jimbaran, Nusa Dua, Sanur, Denpasar, Ubud, dan sekitarnya.
                                    Untuk area di luar wilayah ini, silakan hubungi kami terlebih dahulu.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /Kolom Kiri --}}

            {{-- ════════════════════════════════════════
                 KOLOM KANAN — Sticky Booking Card (30%)
            ════════════════════════════════════════ --}}
            <div class="w-full lg:w-80 xl:w-96 shrink-0">
                <div class="sticky top-24 space-y-4">

                    {{-- Booking Card --}}
                    <div class="overflow-hidden rounded-card border border-soft-divider bg-canvas-white">
                        {{-- Price Header --}}
                        <div class="border-b border-soft-divider px-6 py-5">
                            <p class="text-sm text-storm-gray">Harga per orang</p>
                            <p class="mt-1 text-3xl font-bold text-carbon-black">
                                Rp {{ number_format($tour->price, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Tour Info Summary --}}
                        <div class="divide-y divide-soft-divider px-6">
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Durasi</span>
                                <span class="font-medium text-carbon-black">{{ $tour->duration }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Tipe</span>
                                <span class="font-medium text-carbon-black">Private Tour</span>
                            </div>
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Kapasitas</span>
                                <span class="font-medium text-carbon-black">Maks. 6 orang</span>
                            </div>
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Penjemputan</span>
                                <span class="font-medium text-carbon-black">Hotel Pickup</span>
                            </div>
                        </div>

                        {{-- CTA --}}
                        <div class="px-6 pb-6 pt-4">
                            @auth
                                <a href="{{ route('booking.tours.create', $tour) }}" class="block w-full">
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
                                    Hubungi kami via WhatsApp untuk pertanyaan seputar paket wisata ini.
                                </p>
                                <a href="https://wa.me/{{ config('company.phone_intl') }}?text=Halo,%20saya%20ingin%20bertanya%20tentang%20{{ urlencode($tour->name) }}"
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

                </div>{{-- /sticky --}}
            </div>{{-- /Kolom Kanan --}}

        </div>{{-- /flex --}}
    </x-page-container>
</div>

@endsection
