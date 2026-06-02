@extends('layouts.app')

@section('content')
<div class="py-12 bg-faint-gray border-b border-soft-divider">
    <x-page-container>
        <h1 class="text-4xl font-bold text-carbon-black mb-4">Sewa Kendaraan</h1>
        <p class="text-storm-gray text-lg max-w-2xl">Pilih armada terbaik kami untuk menemani perjalanan Anda. Semua kendaraan dirawat secara berkala demi kenyamanan dan keselamatan.</p>
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
                                         class="vehicle-card-image aspect-video w-full object-cover" />
                                @else
                                    <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=800&auto=format&fit=crop" alt="Vehicle" class="h-60 w-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110" />
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
                                        <span class="text-xs font-medium uppercase tracking-wider text-dust-bunny block mt-0.5">/ 12 Jam</span>
                                    </p>
                                </div>

                                <p class="text-sm text-storm-gray line-clamp-2 grow">
                                    {{ Str::limit($vehicle->description, 100) }}
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
@endsection
