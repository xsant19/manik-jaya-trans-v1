@extends('layouts.app')

@section('content')
<div class="py-16 bg-faint-gray border-b border-soft-divider">
    <x-page-container>
        <div class="max-w-3xl mx-auto text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-bold text-carbon-black mb-6">Sewa Kendaraan</h1>
            <p class="text-storm-gray text-lg">Pilih armada terbaik kami untuk menemani perjalanan Anda. Semua kendaraan dirawat secara berkala demi kenyamanan dan keselamatan.</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <form action="{{ route('vehicles.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3 bg-canvas-white p-3 rounded-xl border border-soft-divider shadow-sm">
                <div class="relative flex-grow w-full">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau tipe kendaraan..." 
                           class="w-full pl-12 pr-4 py-4 text-lg bg-transparent text-carbon-black focus:outline-none placeholder:text-storm-gray">
                </div>
                <button type="submit" class="w-full md:w-auto bg-carbon-black text-canvas-white px-8 py-4 rounded-lg font-bold text-lg hover:opacity-90 transition-opacity flex-shrink-0">
                    Cari Kendaraan
                </button>
            </form>
        </div>
    </x-page-container>
</div>

<div class="py-16">
    <x-page-container>
        @if($vehicles->isEmpty())
            <div class="text-center py-16">
                <p class="text-storm-gray text-lg">Belum ada kendaraan tersedia saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($vehicles as $vehicle)
                    <a href="{{ route('vehicles.show', $vehicle) }}" class="block outline-none h-full">
                        <div class="group w-full h-full overflow-hidden rounded-xl border border-soft-divider bg-canvas-white text-carbon-black shadow-sm transition-all duration-300 ease-in-out hover:shadow-lg hover:-translate-y-1 flex flex-col">
                            {{-- Image Section --}}
                            <div class="overflow-hidden bg-pale-drift shrink-0">
                                @if($vehicle->imageUrls && count($vehicle->imageUrls) > 0)
                                    <img src="{{ asset($vehicle->imageUrls[0]) }}"
                                         alt="{{ $vehicle->name }}"
                                         class="vehicle-card-image aspect-video w-full object-cover" loading="lazy" />
                                @else
                                    <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=800&auto=format&fit=crop" alt="Vehicle" class="h-60 w-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110" loading="lazy" />
                                @endif
                            </div>

                            {{-- Content Section --}}
                            <div class="space-y-3 p-5 flex flex-col grow">
                                <div class="flex items-start justify-between gap-4">
                                    <h3 class="text-lg font-bold tracking-tight group-hover:underline decoration-1 underline-offset-4 line-clamp-2">
                                        {{ $vehicle->name }}
                                    </h3>
                                    <p class="text-lg font-bold text-carbon-black shrink-0 whitespace-nowrap text-right">
                                        Rp {{ number_format($vehicle->price_half_day, 0, ',', '.') }}
                                        <span class="text-xs font-medium uppercase tracking-wider text-dust-bunny block mt-0.5">/ 6 Jam</span>
                                    </p>
                                </div>

                                <p class="mb-4 text-sm leading-relaxed text-storm-gray">
                                    {{ Str::limit(strip_tags($vehicle->description), 100) }}
                                </p>

                                <div class="flex flex-wrap items-center justify-between gap-2 text-sm text-storm-gray mt-auto pt-2">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                                            <circle cx="7" cy="17" r="2" />
                                            <circle cx="17" cy="17" r="2" />
                                        </svg>
                                        <span>{{ $vehicle->type }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="h-4 w-4 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        </svg>
                                        <span class="font-medium text-carbon-black">{{ $vehicle->capacity }} Penumpang</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </x-page-container>
</div>

{{-- Area Coverage & Remote Area Policy Section --}}
<div class="bg-faint-gray py-16">
    <x-page-container>
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-carbon-black mb-3">Area Layanan &amp; Kebijakan Wilayah</h2>
            <p class="text-storm-gray text-lg max-w-3xl mx-auto">Transparansi biaya untuk kenyamanan perjalanan Anda di seluruh Bali</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            {{-- Zona Standar --}}
            <div class="rounded-xl border-2 border-carbon-black bg-canvas-white p-6">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex size-12 items-center justify-center rounded-xl bg-carbon-black">
                            <svg class="size-6 text-canvas-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-carbon-black">Zona Standar</h3>
                            <p class="text-xs text-storm-gray">Sudah termasuk harga normal</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-btn bg-carbon-black px-3 py-1.5 text-xs font-semibold text-canvas-white">
                        <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Included
                    </span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @php
                        $standardZones = ['Bandara', 'Kuta', 'Seminyak', 'Canggu', 'Jimbaran Utara', 'Nusa Dua', 'Denpasar', 'Sanur', 'Ubud'];
                    @endphp
                    @foreach($standardZones as $zone)
                        <span class="inline-flex items-center gap-1.5 rounded-btn bg-faint-gray px-3 py-2 text-xs font-medium text-carbon-black border border-soft-divider">
                            <svg class="size-3 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            {{ $zone }}
                        </span>
                    @endforeach
                </div>
                <div class="mt-4 rounded-lg bg-faint-gray p-3">
                    <p class="text-xs text-storm-gray">
                        <svg class="inline size-3.5 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Jam operasional: 07:00 - 23:50
                    </p>
                </div>
            </div>

            {{-- Remote Area --}}
            <div class="rounded-xl border border-soft-divider bg-canvas-white p-6">
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex size-12 items-center justify-center rounded-xl bg-faint-gray border-2 border-soft-divider">
                        <svg class="size-6 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 11 18-5v12L3 14v-3z"/>
                            <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-carbon-black">Area Terpencil</h3>
                        <p class="text-xs text-storm-gray">Biaya tambahan berlaku</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between gap-3 rounded-lg border border-soft-divider bg-faint-gray p-3">
                        <span class="text-sm font-medium text-carbon-black">Bali Utara (Bedugul, Lovina, dll)</span>
                        <span class="text-sm font-semibold text-carbon-black">Rp 100.000 - 350.000</span>
                    </div>
                    <div class="flex items-center justify-between gap-3 rounded-lg border border-soft-divider bg-faint-gray p-3">
                        <span class="text-sm font-medium text-carbon-black">Bali Timur (Besakih, Amed, dll)</span>
                        <span class="text-sm font-semibold text-carbon-black">Rp 150.000 - 300.000</span>
                    </div>
                    <div class="flex items-center justify-between gap-3 rounded-lg border border-soft-divider bg-faint-gray p-3">
                        <span class="text-sm font-medium text-carbon-black">Penjemputan Subuh (&lt;05:00)</span>
                        <span class="text-sm font-semibold text-carbon-black">Rp 50.000</span>
                    </div>
                    <div class="flex items-center justify-between gap-3 rounded-lg border border-soft-divider bg-faint-gray p-3">
                        <span class="text-sm font-medium text-carbon-black">Layanan Malam (00:00-06:00)</span>
                        <span class="text-sm font-semibold text-carbon-black">Rp 250.000</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detailed Policy Accordion --}}
        <div class="rounded-xl border border-soft-divider bg-canvas-white overflow-hidden">
            <details class="group">
                <summary class="flex cursor-pointer items-center justify-between gap-4 px-6 py-5 hover:bg-faint-gray transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="size-5 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                            <path d="M12 17h.01"/>
                        </svg>
                        <span class="text-base font-semibold text-carbon-black">Lihat Detail Lengkap Area &amp; Biaya Tambahan</span>
                    </div>
                    <svg class="size-5 shrink-0 text-storm-gray transition-transform group-open:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </summary>
                
                <div class="border-t border-soft-divider bg-faint-gray px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Bali Utara Detail --}}
                        <div>
                            <h4 class="mb-3 flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-storm-gray">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m3 11 18-5v12L3 14v-3z"/>
                                    <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                                </svg>
                                Bali Utara
                            </h4>
                            <div class="space-y-2">
                                @php
                                    $northDetail = [
                                        ['area' => 'Bedugul, Jatiluwih, Batukaru, Penelokan, Kintamani', 'price' => 100000],
                                        ['area' => 'Munduk, Gitgit, Sekumpul, Banyumala, Aling-Aling', 'price' => 150000],
                                        ['area' => 'Lovina, Singaraja, Tejakula', 'price' => 250000],
                                        ['area' => 'Gilimanuk, Menjangan, Pemuteran', 'price' => 350000],
                                    ];
                                @endphp
                                @foreach($northDetail as $item)
                                    <div class="rounded-lg border border-soft-divider bg-canvas-white p-3">
                                        <div class="flex items-start justify-between gap-3 mb-1">
                                            <span class="text-xs font-semibold text-carbon-black">+Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                        </div>
                                        <p class="text-xs text-storm-gray leading-relaxed">{{ $item['area'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Bali Timur Detail --}}
                        <div>
                            <h4 class="mb-3 flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-storm-gray">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m3 11 18-5v12L3 14v-3z"/>
                                    <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                                </svg>
                                Bali Timur
                            </h4>
                            <div class="space-y-2">
                                @php
                                    $eastDetail = [
                                        ['area' => 'Besakih, Lempuyang, Tirta Gangga, Sidemen', 'price' => 150000],
                                        ['area' => 'Tejakula, Amed, Lahanangan Sweet', 'price' => 250000],
                                        ['area' => 'Tianyar, Tulamben, Kubu, Gretek', 'price' => 300000],
                                    ];
                                @endphp
                                @foreach($eastDetail as $item)
                                    <div class="rounded-lg border border-soft-divider bg-canvas-white p-3">
                                        <div class="flex items-start justify-between gap-3 mb-1">
                                            <span class="text-xs font-semibold text-carbon-black">+Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                        </div>
                                        <p class="text-xs text-storm-gray leading-relaxed">{{ $item['area'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Important Note --}}
                    <div class="mt-6 rounded-lg border-l-4 border-carbon-black bg-canvas-white p-4">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 size-5 shrink-0 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-carbon-black mb-1">Catatan Penting</p>
                                <p class="text-sm text-storm-gray leading-relaxed">
                                    Biaya tambahan akan dikonfirmasi saat booking. Untuk rute khusus atau area yang tidak tercantum, silakan hubungi kami untuk konsultasi gratis.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </details>
        </div>

        {{-- CTA Contact --}}
        <div class="mt-8 text-center">
            <p class="text-storm-gray mb-4">Punya rencana perjalanan khusus? Konsultasi gratis dengan kami!</p>
            <a href="https://wa.me/{{ config('company.phone_intl') }}?text=Halo,%20saya%20ingin%20konsultasi%20mengenai%20area%20perjalanan%20saya"
               target="_blank"
               class="inline-flex items-center gap-2 rounded-btn bg-carbon-black px-6 py-3 text-sm font-semibold text-canvas-white transition-opacity hover:opacity-90">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Hubungi via WhatsApp
            </a>
        </div>
    </x-page-container>
</div>
@endsection
