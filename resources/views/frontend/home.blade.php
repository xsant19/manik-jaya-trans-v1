@extends('layouts.app')

@section('content')

<!-- Hero Section — Images Slider -->
<section
    id="hero-slider"
    class="relative h-[85vh] min-h-[560px] w-full overflow-hidden bg-carbon-black"
    aria-label="Hero slideshow destinasi Bali"
>
    {{-- ── Slides ── --}}
    {{-- Slide 1: Tanah Lot --}}
    <div class="hero-slide" aria-hidden="true">
        <img
            src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1920&auto=format&fit=crop"
            alt="Pura Tanah Lot Bali"
            class="h-full w-full object-cover object-center"
        />
    </div>

    {{-- Slide 2: Tegalalang Rice Terrace --}}
    <div class="hero-slide" aria-hidden="true">
        <img
            src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=1920&auto=format&fit=crop"
            alt="Tegalalang Rice Terrace Ubud"
            class="h-full w-full object-cover object-center"
        />
    </div>

    {{-- Slide 3: Uluwatu Temple --}}
    <div class="hero-slide" aria-hidden="true">
        <img
            src="https://images.unsplash.com/photo-1604999565976-8913ad2ddb37?q=80&w=1920&auto=format&fit=crop"
            alt="Pura Uluwatu Bali"
            class="h-full w-full object-cover object-center"
        />
    </div>

    {{-- Slide 4: Bali Beach --}}
    <div class="hero-slide" aria-hidden="true">
        <img
            src="https://images.unsplash.com/photo-1573790387438-4da905039392?q=80&w=1920&auto=format&fit=crop"
            alt="Pantai Bali"
            class="h-full w-full object-cover object-center"
        />
    </div>

    {{-- Slide 5: Bali Rice Fields --}}
    <div class="hero-slide" aria-hidden="true">
        <img
            src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?q=80&w=1920&auto=format&fit=crop"
            alt="Sawah Bali"
            class="h-full w-full object-cover object-center"
        />
    </div>

    {{-- ── Hero Content (layered above overlay) ── --}}
    <div class="hero-content absolute inset-0 z-10 flex items-center pt-32 md:pt-32">
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                {{-- Eyebrow --}}
                <p class="mb-4 inline-flex items-center gap-2 rounded-btn border border-white/25 bg-white/10 px-3 py-1 text-xs font-medium uppercase tracking-widest text-white backdrop-blur-sm">
                    <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    Bali, Indonesia
                </p>

                {{-- Heading --}}
                <h1 class="mb-5 text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl md:text-6xl">
                    Eksplorasi Bali<br>dengan Perjalanan<br>Tak Terlupakan.
                </h1>

                {{-- Subheading --}}
                <p class="mb-8 max-w-lg text-base text-white/75 md:text-lg">
                    Layanan sewa kendaraan dan paket wisata tepercaya yang mengutamakan kenyamanan, keamanan, dan pengalaman terbaik.
                </p>

                {{-- CTAs --}}
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('vehicles.index') }}"
                       class="inline-flex items-center gap-2 rounded-btn bg-canvas-white px-6 py-3 text-sm font-semibold text-carbon-black transition-opacity hover:opacity-90">
                        Sewa Kendaraan
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('tours.index') }}"
                       class="inline-flex items-center gap-2 rounded-btn border border-white/40 bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition-colors hover:bg-white/20">
                        Lihat Paket Wisata
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Prev / Next Buttons ── --}}
    <button id="hero-prev" type="button" class="hero-nav-btn left-4 sm:left-6" aria-label="Slide sebelumnya">
        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
    </button>
    <button id="hero-next" type="button" class="hero-nav-btn right-4 sm:right-6" aria-label="Slide berikutnya">
        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6"/>
        </svg>
    </button>

    {{-- ── Dot Indicators ── --}}
    <div class="absolute bottom-6 left-1/2 z-20 flex -translate-x-1/2 items-center gap-2" role="tablist" aria-label="Slide indicators">
        <button type="button" class="hero-dot" aria-label="Slide 1" role="tab"></button>
        <button type="button" class="hero-dot" aria-label="Slide 2" role="tab"></button>
        <button type="button" class="hero-dot" aria-label="Slide 3" role="tab"></button>
        <button type="button" class="hero-dot" aria-label="Slide 4" role="tab"></button>
        <button type="button" class="hero-dot" aria-label="Slide 5" role="tab"></button>
    </div>
</section>

<!-- Featured Vehicles — Sparks Carousel -->
<section class="py-20 md:py-24" id="vehicle-carousel">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between md:mb-12">
            <div>
                <a href="{{ route('vehicles.index') }}" class="group inline-flex items-center">
                    <h2 class="text-2xl font-bold tracking-tight text-carbon-black md:text-3xl lg:text-4xl">
                        Kendaraan Pilihan
                    </h2>
                    <svg class="ml-2 size-6 text-carbon-black transition-transform group-hover:translate-x-1"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </a>
                <p class="mt-1.5 text-storm-gray text-sm md:text-base">
                    Armada terawat untuk perjalanan nyaman Anda di Bali.
                </p>
            </div>
        </div>
    </div>

    {{-- Scrollable Carousel --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="vehicle-scroll-container flex w-full space-x-5 overflow-x-auto pb-4 scrollbar-hide">
            @foreach($vehicles as $index => $vehicle)
                <div class="vehicle-card group w-[300px] md:w-[320px] flex-shrink-0">
                    <a href="{{ route('vehicles.show', $vehicle) }}" class="block">
                        <div class="overflow-hidden rounded-card border border-soft-divider bg-canvas-white transition-shadow hover:shadow-md">
                            {{-- Image --}}
                            <div class="relative overflow-hidden">
                                @if($vehicle->image)
                                    <img src="{{ asset($vehicle->imageUrls[0]) }}"
                                         alt="{{ $vehicle->name }}"
                                         class="vehicle-card-image aspect-video w-full object-cover" />
                                @else
                                    {{-- Placeholder --}}
                                    <div class="vehicle-card-image flex aspect-video w-full items-center justify-center bg-pale-drift">
                                        <svg class="size-14 text-dust-bunny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                                            <circle cx="7" cy="17" r="2" />
                                            <path d="M9 17h6" />
                                            <circle cx="17" cy="17" r="2" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Type badge --}}
                                <span class="absolute top-3 left-3 inline-flex items-center gap-1 rounded-btn bg-carbon-black/80 px-2.5 py-1 text-xs font-medium text-canvas-white backdrop-blur-sm">
                                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                                        <circle cx="7" cy="17" r="2" />
                                        <circle cx="17" cy="17" r="2" />
                                    </svg>
                                    {{ $vehicle->type }}
                                </span>

                                {{-- Capacity badge --}}
                                <span class="absolute top-3 right-3 inline-flex items-center gap-1 rounded-btn bg-canvas-white/80 px-2 py-1 text-xs font-medium text-carbon-black backdrop-blur-sm">
                                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                    {{ $vehicle->capacity }}
                                </span>
                            </div>

                            {{-- Content --}}
                            <div class="p-5">
                                <h3 class="text-base font-bold leading-snug text-carbon-black group-hover:underline decoration-1 underline-offset-4 md:text-lg">
                                    {{ $vehicle->name }}
                                </h3>
                                <p class="mt-2 line-clamp-2 text-sm text-storm-gray">
                                    {{ Str::limit($vehicle->description, 100) }}
                                </p>

                                {{-- Price --}}
                                <div class="mt-4 border-t border-soft-divider pt-4">
                                    <p class="text-xl font-bold text-carbon-black">
                                        Rp {{ number_format($vehicle->price_half_day, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs font-medium uppercase tracking-wider text-dust-bunny">
                                        Mulai dari / 12 Jam
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Overlay Nav Buttons --}}
        <button id="vehicle-carousel-prev" type="button"
                class="absolute left-2 top-1/2 z-10 -translate-y-1/2 rounded-full border border-soft-divider bg-canvas-white/80 p-2.5 text-carbon-black backdrop-blur-sm transition-all hover:bg-canvas-white opacity-0 pointer-events-none sm:left-4"
                aria-label="Scroll ke kiri">
            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
        </button>
        <button id="vehicle-carousel-next" type="button"
                class="absolute right-2 top-1/2 z-10 -translate-y-1/2 rounded-full border border-soft-divider bg-canvas-white/80 p-2.5 text-carbon-black backdrop-blur-sm transition-all hover:bg-canvas-white opacity-0 pointer-events-none sm:right-4"
                aria-label="Scroll ke kanan">
            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </button>
    </div>
</section>

<!-- Featured Tours — Sparks Carousel -->
<section class="py-20 md:py-24 bg-faint-gray" id="tour-carousel">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between md:mb-12">
            <div>
                <a href="{{ route('tours.index') }}" class="group inline-flex items-center">
                    <h2 class="text-2xl font-bold tracking-tight text-carbon-black md:text-3xl lg:text-4xl">
                        Paket Wisata Populer
                    </h2>
                    <svg class="ml-2 size-6 text-carbon-black transition-transform group-hover:translate-x-1"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </a>
                <p class="mt-1.5 text-storm-gray text-sm md:text-base">
                    Pengalaman tak terlupakan di destinasi terbaik Bali.
                </p>
            </div>
        </div>
    </div>

    {{-- Scrollable Carousel --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="tour-scroll-container flex w-full space-x-5 overflow-x-auto pb-4 scrollbar-hide">
            @foreach($packages as $index => $package)
                <div class="tour-card group w-[300px] md:w-[320px] flex-shrink-0">
                    <a href="{{ route('tours.show', $package) }}" class="block">
                        <div class="overflow-hidden rounded-card border border-soft-divider bg-canvas-white transition-shadow hover:shadow-md">
                            {{-- Image --}}
                            <div class="relative overflow-hidden">
                                @if($package->imageUrls)
                                    <img src="{{ asset($package->imageUrls[0]) }}"
                                         alt="{{ $package->name }}"
                                         class="tour-card-image aspect-video w-full object-cover" />
                                @else
                                    {{-- Placeholder --}}
                                    <div class="tour-card-image flex aspect-video w-full items-center justify-center bg-pale-drift">
                                        <svg class="size-14 text-dust-bunny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                                            <circle cx="12" cy="10" r="3" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Duration badge --}}
                                <span class="absolute top-3 left-3 inline-flex items-center gap-1 rounded-btn bg-carbon-black/80 px-2.5 py-1 text-xs font-medium text-canvas-white backdrop-blur-sm">
                                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                    {{ $package->duration }}
                                </span>
                            </div>

                            {{-- Content --}}
                            <div class="p-5">
                                <h3 class="text-base font-bold leading-snug text-carbon-black group-hover:underline decoration-1 underline-offset-4 md:text-lg">
                                    {{ $package->name }}
                                </h3>
                                <p class="mt-2 line-clamp-2 text-sm text-storm-gray">
                                    {{ Str::limit($package->description, 100) }}
                                </p>

                                {{-- Price --}}
                                <div class="mt-4 border-t border-soft-divider pt-4">
                                    <p class="text-xl font-bold text-carbon-black">
                                        Rp {{ number_format($package->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs font-medium uppercase tracking-wider text-dust-bunny">
                                        Per Orang
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Overlay Nav Buttons --}}
        <button id="tour-carousel-prev" type="button"
                class="absolute left-2 top-1/2 z-10 -translate-y-1/2 rounded-full border border-soft-divider bg-canvas-white/80 p-2.5 text-carbon-black backdrop-blur-sm transition-all hover:bg-canvas-white opacity-0 pointer-events-none sm:left-4"
                aria-label="Scroll ke kiri">
            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
        </button>
        <button id="tour-carousel-next" type="button"
                class="absolute right-2 top-1/2 z-10 -translate-y-1/2 rounded-full border border-soft-divider bg-canvas-white/80 p-2.5 text-carbon-black backdrop-blur-sm transition-all hover:bg-canvas-white opacity-0 pointer-events-none sm:right-4"
                aria-label="Scroll ke kanan">
            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </button>
    </div>
</section>

<!-- Services Overview -->
<section class="py-20">
    <x-page-container>
        <div class="text-center mb-12">
            <x-section-heading>Layanan Kami</x-section-heading>
            <p class="text-storm-gray max-w-2xl mx-auto">Berbagai pilihan layanan transportasi untuk memenuhi kebutuhan perjalanan Anda di Bali.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <a href="{{ route('transfers.index') }}" class="block group">
                <div class="bg-faint-gray p-8 rounded-card border border-soft-divider hover:border-carbon-black transition-colors">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-carbon-black rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-canvas-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-carbon-black mb-2 group-hover:underline">Airport Transfer</h3>
                            <p class="text-storm-gray text-sm">Layanan antar-jemput bandara yang nyaman dan tepat waktu dengan driver profesional.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ route('shuttles.index') }}" class="block group">
                <div class="bg-faint-gray p-8 rounded-card border border-soft-divider hover:border-carbon-black transition-colors">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-carbon-black rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-canvas-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-carbon-black mb-2 group-hover:underline">Hotel Shuttle</h3>
                            <p class="text-storm-gray text-sm">Shuttle terjadwal dari dan ke hotel pilihan dengan kenyamanan maksimal.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </x-page-container>
</section>

@endsection
