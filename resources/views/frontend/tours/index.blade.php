@extends('layouts.app')

@section('content')
<div class="py-12 bg-faint-gray border-b border-soft-divider">
    <x-page-container>
        <h1 class="text-4xl font-bold text-carbon-black mb-4">Paket Wisata</h1>
        <p class="text-storm-gray text-lg max-w-2xl">Jelajahi keindahan Bali dengan paket wisata pilihan kami. Pengalaman tak terlupakan dengan pemandu berpengalaman.</p>
    </x-page-container>
</div>

<div class="py-16">
    <x-page-container>
        @if($packages->isEmpty())
            <div class="text-center py-16">
                <p class="text-storm-gray text-lg">Belum ada paket wisata tersedia saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($packages as $package)
                    <a href="{{ route('tours.show', $package) }}" class="block outline-none h-full">
                        <div class="group w-full h-full overflow-hidden rounded-xl border border-soft-divider bg-canvas-white text-carbon-black shadow-sm transition-all duration-300 ease-in-out hover:shadow-lg hover:-translate-y-1 flex flex-col">
                            {{-- Image Section --}}
                            <div class="overflow-hidden bg-pale-drift shrink-0">
                                @if($package->image)
                                    <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="h-60 w-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110" />
                                @else
                                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800&auto=format&fit=crop" alt="Bali Tour" class="h-60 w-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110" />
                                @endif
                            </div>

                            {{-- Content Section --}}
                            <div class="space-y-3 p-5 flex flex-col flex-grow">
                                <div class="flex items-start justify-between gap-4">
                                    <h3 class="text-lg font-bold tracking-tight group-hover:underline decoration-1 underline-offset-4 line-clamp-2">
                                        {{ $package->name }}
                                    </h3>
                                    <p class="text-lg font-bold text-carbon-black shrink-0 whitespace-nowrap text-right">
                                        Rp {{ number_format($package->price, 0, ',', '.') }}
                                        <span class="text-xs font-medium uppercase tracking-wider text-dust-bunny block mt-0.5">/ Orang</span>
                                    </p>
                                </div>
                                
                                <p class="text-sm text-storm-gray line-clamp-2 flex-grow">
                                    {{ Str::limit($package->description, 100) }}
                                </p>

                                <div class="flex flex-wrap items-center justify-between gap-2 text-sm text-storm-gray mt-auto pt-2">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                        <span>Bali, Indonesia</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="h-4 w-4 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        <span class="font-medium text-carbon-black">{{ $package->duration }}</span>
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
