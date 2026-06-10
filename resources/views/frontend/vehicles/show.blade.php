@extends('layouts.app')

@section('content')

{{-- ── Breadcrumb ── --}}
<div class="border-b border-soft-divider bg-canvas-white">
    <x-page-container>
        <div class="py-4">
            <a href="{{ route('vehicles.index') }}"
               class="inline-flex items-center gap-1.5 text-sm font-medium text-storm-gray transition-colors hover:text-carbon-black">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Kembali ke Daftar Kendaraan
            </a>
        </div>
    </x-page-container>
</div>

{{-- ── Image Gallery (1 Main + 2 Thumbnails below) ── --}}
<div class="bg-canvas-white">
    <x-page-container>
        <div class="py-6">
            @if($vehicle->imageUrls && count($vehicle->imageUrls) > 0)
                {{-- Has image from DB --}}
                <div class="space-y-2">
                    {{-- Main image --}}
                    <div class="overflow-hidden rounded-t-card border border-b-0 border-soft-divider bg-pale-drift">
                        <img src="{{ asset($vehicle->imageUrls[0]) }}"
                             alt="{{ $vehicle->name }}"
                             class="h-80 w-full object-cover transition-transform duration-500 hover:scale-105 md:h-[420px]" />
                    </div>
                    {{-- 2 thumbnails below --}}
                    <div class="grid grid-cols-2 gap-2">
                        @if(isset($vehicle->imageUrls[1]))
                            <div class="overflow-hidden rounded-bl-card border border-soft-divider bg-faint-gray">
                                <img src="{{ asset($vehicle->imageUrls[1]) }}"
                                     alt="{{ $vehicle->name }}"
                                     class="h-32 w-full object-cover md:h-44" />
                            </div>
                        @else
                            <div class="flex h-32 items-center justify-center overflow-hidden rounded-bl-card border border-soft-divider bg-faint-gray md:h-44">
                                <svg class="size-8 text-dust-bunny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                                    <circle cx="9" cy="9" r="2"/>
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                </svg>
                            </div>
                        @endif
                        @if(isset($vehicle->imageUrls[2]))
                            <div class="overflow-hidden rounded-br-card border border-soft-divider bg-faint-gray">
                                <img src="{{ asset($vehicle->imageUrls[2]) }}"
                                     alt="{{ $vehicle->name }}"
                                     class="h-32 w-full object-cover md:h-44" />
                            </div>
                        @else
                            <div class="flex h-32 items-center justify-center overflow-hidden rounded-br-card border border-soft-divider bg-faint-gray md:h-44">
                                <svg class="size-8 text-dust-bunny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                                    <circle cx="9" cy="9" r="2"/>
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                {{-- No image: 3-panel placeholder grid --}}
                <div class="space-y-2">
                    {{-- Main placeholder --}}
                    <div class="flex h-80 items-center justify-center overflow-hidden rounded-t-card border border-b-0 border-soft-divider bg-pale-drift md:h-[420px]">
                        <svg class="size-20 text-dust-bunny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                            <circle cx="7" cy="17" r="2"/>
                            <path d="M9 17h6"/>
                            <circle cx="17" cy="17" r="2"/>
                        </svg>
                    </div>
                    {{-- 2 smaller placeholder tiles --}}
                    <div class="grid grid-cols-2 gap-2">
                        @for($i = 0; $i < 2; $i++)
                            <div class="flex h-32 items-center justify-center overflow-hidden border border-soft-divider bg-faint-gray {{ $i === 0 ? 'rounded-bl-card' : 'rounded-br-card' }} md:h-44">
                                <svg class="size-8 text-dust-bunny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                                    <circle cx="9" cy="9" r="2"/>
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                </svg>
                            </div>
                        @endfor
                    </div>
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
                 KOLOM KIRI — Detail Kendaraan (~70%)
            ════════════════════════════════════════ --}}
            <div class="min-w-0 flex-1">

                {{-- Title + Badge + Meta --}}
                <div class="mb-8 border-b border-soft-divider pb-8">
                    <div class="mb-3 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1 rounded-btn bg-carbon-black px-3 py-1 text-xs font-semibold text-canvas-white">
                            {{ $vehicle->type }}
                        </span>
                        @if($vehicle->status === 'available')
                            <span class="inline-flex items-center gap-1.5 rounded-btn bg-faint-gray px-3 py-1 text-xs font-medium text-storm-gray">
                                <span class="size-2 rounded-full bg-green-500 inline-block"></span>
                                Tersedia
                            </span>
                        @endif
                    </div>

                    <h1 class="mb-4 text-3xl font-bold leading-tight tracking-tight text-carbon-black md:text-4xl">
                        {{ $vehicle->name }}
                    </h1>

                    {{-- Meta row --}}
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-storm-gray">
                        <span class="flex items-center gap-1.5">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            <span>Kapasitas <span class="font-semibold text-carbon-black">{{ $vehicle->capacity }} orang</span></span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                                <circle cx="7" cy="17" r="2"/>
                                <path d="M9 17h6"/>
                                <circle cx="17" cy="17" r="2"/>
                            </svg>
                            <span class="font-semibold text-carbon-black">{{ $vehicle->type }}</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span>Bali, Indonesia</span>
                        </span>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-10 border-b border-soft-divider pb-10">
                    <h2 class="mb-4 text-xl font-bold text-carbon-black">Tentang Kendaraan Ini</h2>
                    <p class="leading-relaxed text-storm-gray">{{ $vehicle->description }}</p>
                </div>

                {{-- Harga Sewa --}}
                <div class="mb-10 border-b border-soft-divider pb-10">
                    <h2 class="mb-5 text-xl font-bold text-carbon-black">Harga Sewa <span class="text-base font-normal text-storm-gray">(Sudah Termasuk Driver)</span></h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        {{-- Half Day --}}
                        <div class="rounded-card border border-soft-divider bg-faint-gray p-5">
                            <div class="mb-1.5 flex items-center gap-2">
                                <svg class="size-4 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <span class="text-sm font-medium text-storm-gray">Half Day (6 Jam)</span>
                            </div>
                            <p class="text-2xl font-bold text-carbon-black">
                                Rp {{ number_format($vehicle->price_half_day, 0, ',', '.') }}
                            </p>
                            <p class="mt-1 text-xs text-dust-bunny">Maksimal 6 jam pemakaian</p>
                        </div>
                        {{-- Full Day --}}
                        <div class="rounded-card border-2 border-carbon-black bg-canvas-white p-5">
                            <div class="mb-1.5 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg class="size-4 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <span class="text-sm font-medium text-carbon-black">Full Day (12 Jam)</span>
                                </div>
                                <span class="rounded-btn bg-carbon-black px-2 py-0.5 text-xs font-semibold text-canvas-white">
                                    Populer
                                </span>
                            </div>
                            <p class="text-2xl font-bold text-carbon-black">
                                Rp {{ number_format($vehicle->price_full_day, 0, ',', '.') }}
                            </p>
                            <p class="mt-1 text-xs text-dust-bunny">Maksimal 12 jam pemakaian</p>
                        </div>
                    </div>
                </div>

                {{-- Fasilitas Termasuk & Tidak --}}
                <div class="mb-10 border-b border-soft-divider pb-10">
                    <h2 class="mb-6 text-xl font-bold text-carbon-black">Fasilitas Sewa</h2>
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                        {{-- Termasuk --}}
                        <div>
                            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-storm-gray">Termasuk</h3>
                            <ul class="space-y-3">
                                @php
                                    $includes = [
                                        ['icon' => 'user', 'label' => 'Driver Berpengalaman'],
                                        ['icon' => 'fuel', 'label' => 'Bahan Bakar (BBM)'],
                                        ['icon' => 'droplets', 'label' => 'Air Mineral'],
                                        ['icon' => 'ticket', 'label' => 'Parkir & Tol Dasar'],
                                    ];
                                @endphp
                                @foreach($includes as $item)
                                    <li class="flex items-center gap-3 text-sm text-storm-gray">
                                        <span class="flex size-6 shrink-0 items-center justify-center rounded-full bg-carbon-black text-canvas-white">
                                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                        </span>
                                        {{ $item['label'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Tidak Termasuk --}}
                        <div>
                            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-storm-gray">Tidak Termasuk</h3>
                            <ul class="space-y-3">
                                @php
                                    $excludes = [
                                        'Tiket Masuk Objek Wisata',
                                        'Tip Supir (Sukarela)',
                                        'Konsumsi Makan Supir',
                                    ];
                                @endphp
                                @foreach($excludes as $item)
                                    <li class="flex items-center gap-3 text-sm text-storm-gray">
                                        <span class="flex size-6 shrink-0 items-center justify-center rounded-full border border-soft-divider bg-faint-gray text-storm-gray">
                                            <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="18" y1="6" x2="6" y2="18"/>
                                                <line x1="6" y1="6" x2="18" y2="18"/>
                                            </svg>
                                        </span>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Spesifikasi Kendaraan --}}
                <div class="mb-10 border-b border-soft-divider pb-10">
                    <h2 class="mb-5 text-xl font-bold text-carbon-black">Spesifikasi</h2>
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                        @php
                            $specs = [
                                ['icon' => 'users',   'label' => 'Kapasitas',  'value' => $vehicle->capacity . ' Penumpang'],
                                ['icon' => 'car',     'label' => 'Tipe',       'value' => $vehicle->type],
                                ['icon' => 'wind',    'label' => 'AC',         'value' => 'Full AC'],
                                ['icon' => 'luggage', 'label' => 'Bagasi',     'value' => 'Besar'],
                                ['icon' => 'wifi',    'label' => 'Kondisi',    'value' => 'Terawat'],
                                ['icon' => 'shield',  'label' => 'Asuransi',   'value' => 'Terlindungi'],
                            ];
                        @endphp
                        @foreach($specs as $spec)
                            <div class="flex flex-col gap-1.5 rounded-card border border-soft-divider bg-faint-gray p-4">
                                <svg class="size-4 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    @if($spec['icon'] === 'users')
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    @elseif($spec['icon'] === 'car')
                                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                                        <circle cx="7" cy="17" r="2"/>
                                        <circle cx="17" cy="17" r="2"/>
                                    @elseif($spec['icon'] === 'wind')
                                        <path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/>
                                        <path d="M9.6 4.6A2 2 0 1 1 11 8H2"/>
                                        <path d="M12.6 19.4A2 2 0 1 0 14 16H2"/>
                                    @elseif($spec['icon'] === 'luggage')
                                        <path d="M6 20h0a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2Z"/>
                                        <path d="M8 18V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v14"/>
                                        <line x1="10" y1="2" x2="10" y2="18"/>
                                        <line x1="14" y1="2" x2="14" y2="18"/>
                                    @elseif($spec['icon'] === 'wifi')
                                        <path d="M5 12.55a11 11 0 0 1 14.08 0"/>
                                        <path d="M1.42 9a16 16 0 0 1 21.16 0"/>
                                        <path d="M8.53 16.11a6 6 0 0 1 6.95 0"/>
                                        <line x1="12" y1="20" x2="12.01" y2="20"/>
                                    @elseif($spec['icon'] === 'shield')
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    @endif
                                </svg>
                                <p class="text-xs text-dust-bunny">{{ $spec['label'] }}</p>
                                <p class="text-sm font-semibold text-carbon-black">{{ $spec['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Area Coverage & Remote Area Policy --}}
                <div class="mb-10 border-b border-soft-divider pb-10">
                    <h2 class="mb-5 text-xl font-bold text-carbon-black">Area Layanan &amp; Kebijakan Wilayah</h2>
                    
                    {{-- Jam Operasional --}}
                    <div class="mb-6 rounded-card border border-soft-divider bg-canvas-white p-5">
                        <h3 class="mb-3 flex items-center gap-2 text-base font-semibold text-carbon-black">
                            <svg class="size-5 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            Jam Operasional Driver
                        </h3>
                        <p class="text-sm text-storm-gray">Maksimal mulai pukul <span class="font-semibold text-carbon-black">07:00</span> hingga <span class="font-semibold text-carbon-black">23:50 (11:50 PM)</span></p>
                    </div>

                    {{-- Zona Standar (Included) --}}
                    <div class="mb-6 rounded-card border-2 border-carbon-black bg-faint-gray p-5">
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <h3 class="flex items-center gap-2 text-base font-semibold text-carbon-black">
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                Zona Penjemputan Standar
                            </h3>
                            <span class="inline-flex items-center gap-1.5 rounded-btn bg-carbon-black px-2.5 py-1 text-xs font-semibold text-canvas-white">
                                <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Included
                            </span>
                        </div>
                        <p class="mb-3 text-sm text-storm-gray">Area berikut sudah termasuk dalam harga normal:</p>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $standardZones = ['Bandara (Airport)', 'Kuta', 'Seminyak', 'Canggu', 'Jimbaran Utara', 'Nusa Dua', 'Denpasar', 'Sanur', 'Ubud (area utama)'];
                            @endphp
                            @foreach($standardZones as $zone)
                                <span class="inline-flex items-center gap-1.5 rounded-btn bg-canvas-white px-3 py-1.5 text-xs font-medium text-carbon-black border border-soft-divider">
                                    <svg class="size-3 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    {{ $zone }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Remote Area Surcharge --}}
                    <div class="mb-6">
                        <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-carbon-black">
                            <svg class="size-5 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                                <path d="M21 3v5h-5"/>
                                <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                                <path d="M8 16H3v5"/>
                            </svg>
                            Area Terpencil (Biaya Tambahan)
                        </h3>
                        
                        {{-- Bali Utara --}}
                        <div class="mb-4 overflow-hidden rounded-card border border-soft-divider bg-canvas-white">
                            <div class="border-b border-soft-divider bg-faint-gray px-4 py-3">
                                <h4 class="text-sm font-semibold text-carbon-black">Bali Utara</h4>
                            </div>
                            <div class="divide-y divide-soft-divider">
                                @php
                                    $northAreas = [
                                        ['destinations' => 'Bedugul, Jatiluwih, Batukaru, Penelokan, Kintamani', 'surcharge' => 100000],
                                        ['destinations' => 'Munduk, Gitgit, Sekumpul, Banyumala, Aling-Aling', 'surcharge' => 150000],
                                        ['destinations' => 'Lovina, Singaraja, Tejakula', 'surcharge' => 250000],
                                        ['destinations' => 'Gilimanuk, Menjangan, Pemuteran', 'surcharge' => 350000],
                                    ];
                                @endphp
                                @foreach($northAreas as $area)
                                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                                        <span class="text-sm text-storm-gray">{{ $area['destinations'] }}</span>
                                        <span class="shrink-0 text-sm font-semibold text-carbon-black">+Rp {{ number_format($area['surcharge'], 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Bali Timur --}}
                        <div class="overflow-hidden rounded-card border border-soft-divider bg-canvas-white">
                            <div class="border-b border-soft-divider bg-faint-gray px-4 py-3">
                                <h4 class="text-sm font-semibold text-carbon-black">Bali Timur</h4>
                            </div>
                            <div class="divide-y divide-soft-divider">
                                @php
                                    $eastAreas = [
                                        ['destinations' => 'Besakih, Lempuyang, Tirta Gangga, Sidemen', 'surcharge' => 150000],
                                        ['destinations' => 'Tejakula, Amed, Lahanangan Sweet', 'surcharge' => 250000],
                                        ['destinations' => 'Tianyar, Tulamben, Kubu, Gretek', 'surcharge' => 300000],
                                    ];
                                @endphp
                                @foreach($eastAreas as $area)
                                    <div class="flex items-center justify-between gap-4 px-4 py-3">
                                        <span class="text-sm text-storm-gray">{{ $area['destinations'] }}</span>
                                        <span class="shrink-0 text-sm font-semibold text-carbon-black">+Rp {{ number_format($area['surcharge'], 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Biaya Tambahan Waktu Khusus --}}
                    <div class="rounded-card border border-soft-divider bg-faint-gray p-5">
                        <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-carbon-black">
                            <svg class="size-5 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2v4"/>
                                <path d="M12 18v4"/>
                                <path d="m4.93 4.93 2.83 2.83"/>
                                <path d="m16.24 16.24 2.83 2.83"/>
                                <path d="M2 12h4"/>
                                <path d="M18 12h4"/>
                                <path d="m4.93 19.07 2.83-2.83"/>
                                <path d="m16.24 7.76 2.83-2.83"/>
                            </svg>
                            Biaya Tambahan Waktu Khusus
                        </h3>
                        <ul class="space-y-3">
                            @php
                                $specialTimes = [
                                    ['label' => 'Penjemputan Subuh (Sebelum 05:00)', 'price' => 50000, 'icon' => 'sunrise'],
                                    ['label' => 'Layanan Malam/Dini Hari (00:00 - 06:00)', 'price' => 250000, 'icon' => 'moon'],
                                    ['label' => 'Akomodasi Driver (Menginap di luar kota)', 'price' => 200000, 'note' => 'per malam', 'icon' => 'bed'],
                                ];
                            @endphp
                            @foreach($specialTimes as $time)
                                <li class="flex items-start justify-between gap-4">
                                    <div class="flex items-start gap-2">
                                        <svg class="mt-0.5 size-4 shrink-0 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            @if($time['icon'] === 'sunrise')
                                                <path d="M12 2v8"/>
                                                <path d="m4.93 10.93 1.41 1.41"/>
                                                <path d="M2 18h2"/>
                                                <path d="M20 18h2"/>
                                                <path d="m19.07 10.93-1.41 1.41"/>
                                                <path d="M22 22H2"/>
                                                <path d="m8 6 4-4 4 4"/>
                                                <path d="M16 18a4 4 0 0 0-8 0"/>
                                            @elseif($time['icon'] === 'moon')
                                                <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                                            @elseif($time['icon'] === 'bed')
                                                <path d="M2 4v16"/>
                                                <path d="M2 8h18a2 2 0 0 1 2 2v10"/>
                                                <path d="M2 17h20"/>
                                                <path d="M6 8v9"/>
                                            @endif
                                        </svg>
                                        <div>
                                            <span class="text-sm font-medium text-carbon-black">{{ $time['label'] }}</span>
                                            @if(isset($time['note']))
                                                <span class="block text-xs text-dust-bunny">{{ $time['note'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="shrink-0 text-sm font-semibold text-carbon-black whitespace-nowrap">+Rp {{ number_format($time['price'], 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Important Notice --}}
                    <div class="mt-6 rounded-card border-l-4 border-carbon-black bg-faint-gray p-4">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 size-5 shrink-0 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-carbon-black">Penting untuk Diperhatikan</p>
                                <p class="mt-1 text-sm leading-relaxed text-storm-gray">
                                    Biaya tambahan area terpencil dan waktu khusus akan diinformasikan saat konfirmasi booking. Untuk rute yang tidak tercantum atau permintaan khusus, silakan hubungi kami via WhatsApp.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Syarat & Ketentuan --}}
                <div class="mb-10">
                    <h2 class="mb-4 text-xl font-bold text-carbon-black">Syarat &amp; Ketentuan</h2>
                    <div class="rounded-card border border-soft-divider bg-faint-gray p-5">
                        <ul class="space-y-3">
                            @php
                                $terms = [
                                    'Harga standar berlaku untuk zona penjemputan standar (Airport, Kuta, Seminyak, Canggu, dll).',
                                    'Biaya tambahan area terpencil dan waktu khusus akan dikonfirmasi sebelum booking final.',
                                    'Waktu sewa Half Day maksimal 6 jam, Full Day maksimal 12 jam.',
                                    'Pembatalan kurang dari 24 jam sebelum keberangkatan dapat dikenakan biaya.',
                                    'Driver membutuhkan waktu istirahat jika perjalanan melebihi durasi sewa.',
                                ];
                            @endphp
                            @foreach($terms as $i => $term)
                                <li class="flex items-start gap-3 text-sm text-storm-gray">
                                    <span class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full border border-soft-divider bg-canvas-white text-xs font-bold text-carbon-black">
                                        {{ $i + 1 }}
                                    </span>
                                    {{ $term }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>{{-- /Kolom Kiri --}}

            {{-- ════════════════════════════════════════
                 KOLOM KANAN — Sticky Booking Card (~30%)
            ════════════════════════════════════════ --}}
            <div class="w-full lg:w-80 xl:w-96 shrink-0">
                <div class="sticky top-24 space-y-4">

                    {{-- Booking Card --}}
                    <div class="overflow-hidden rounded-card border border-soft-divider bg-canvas-white">

                        {{-- Price Header --}}
                        <div class="border-b border-soft-divider px-6 py-5">
                            <p class="text-sm text-storm-gray">Mulai dari</p>
                            <p class="mt-1 text-3xl font-bold text-carbon-black">
                                Rp {{ number_format($vehicle->price_half_day, 0, ',', '.') }}
                            </p>
                            <p class="mt-0.5 text-xs text-dust-bunny">Per 6 jam (Half Day)</p>
                        </div>

                        {{-- Vehicle Info Summary --}}
                        <div class="divide-y divide-soft-divider px-6">
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Tipe Kendaraan</span>
                                <span class="font-medium text-carbon-black">{{ $vehicle->type }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Kapasitas</span>
                                <span class="font-medium text-carbon-black">{{ $vehicle->capacity }} Penumpang</span>
                            </div>
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">Driver</span>
                                <span class="font-medium text-carbon-black">Termasuk</span>
                            </div>
                            <div class="flex items-center justify-between py-3.5 text-sm">
                                <span class="text-storm-gray">BBM & Parkir</span>
                                <span class="font-medium text-carbon-black">Termasuk</span>
                            </div>
                        </div>

                        {{-- CTA --}}
                        <div class="px-6 pb-6 pt-4">
                            @auth
                                <a href="{{ route('booking.rental.create', $vehicle) }}" class="block w-full">
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
                            <svg class="mt-0.5 size-5 shrink-0 text-storm-gray" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                <path d="M12 17h.01"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-carbon-black">Butuh bantuan?</p>
                                <p class="mt-1 text-xs leading-relaxed text-storm-gray mb-3">
                                    Hubungi kami via WhatsApp untuk pertanyaan seputar kendaraan ini.
                                </p>
                                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20bertanya%20tentang%20{{ urlencode($vehicle->name) }}"
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
