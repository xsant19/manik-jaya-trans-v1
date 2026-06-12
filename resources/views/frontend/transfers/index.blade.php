@extends('layouts.app')

@section('content')
<div class="py-16 bg-faint-gray border-b border-soft-divider">
    <x-page-container>
        <div class="max-w-3xl mx-auto text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-bold text-carbon-black mb-6">Airport Transfer</h1>
            <p class="text-storm-gray text-lg">Layanan antar-jemput bandara yang nyaman dan tepat waktu. Nikmati perjalanan tanpa khawatir dengan driver profesional kami.</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <form action="{{ route('transfers.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3 bg-canvas-white p-3 rounded-xl border border-soft-divider shadow-sm">
                <div class="relative flex-grow w-full">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-storm-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama rute atau lokasi..." 
                           class="w-full pl-12 pr-4 py-4 text-lg bg-transparent text-carbon-black focus:outline-none placeholder:text-storm-gray">
                </div>
                <button type="submit" class="w-full md:w-auto bg-carbon-black text-canvas-white px-8 py-4 rounded-lg font-bold text-lg hover:opacity-90 transition-opacity flex-shrink-0">
                    Cari Transfer
                </button>
            </form>
        </div>
    </x-page-container>
</div>

<div class="py-16">
    <x-page-container>
        @if($transfers->isEmpty())
            <div class="text-center py-16">
                <p class="text-storm-gray text-lg">Belum ada layanan airport transfer tersedia saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($transfers as $transfer)
                    <a href="{{ route('transfers.show', $transfer) }}" class="block group">
                        <x-service-card>
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-carbon-black group-hover:underline mb-3">{{ $transfer->route_name }}</h3>
                                
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 text-storm-gray flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <div>
                                            <div class="text-storm-gray">Dari</div>
                                            <div class="text-carbon-black font-medium">{{ $transfer->pickup_location }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 text-storm-gray flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <div>
                                            <div class="text-storm-gray">Ke</div>
                                            <div class="text-carbon-black font-medium">{{ $transfer->dropoff_location }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($transfer->estimated_duration)
                                    <div class="mt-3 text-xs text-storm-gray flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Estimasi {{ $transfer->estimated_duration }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex justify-between items-center mt-auto pt-4 border-t border-soft-divider">
                                <span class="text-sm text-dust-bunny">Harga</span>
                                <span class="font-bold text-carbon-black">Rp {{ number_format($transfer->price, 0, ',', '.') }}</span>
                            </div>
                        </x-service-card>
                    </a>
                @endforeach
            </div>
        @endif
    </x-page-container>
</div>

{{-- Syarat & Ketentuan Layanan --}}
<div class="border-t border-soft-divider bg-canvas-white py-16">
    <x-page-container>
        <div class="mx-auto max-w-4xl">
            <h2 class="mb-8 text-center text-3xl font-bold text-carbon-black">Syarat & Ketentuan Layanan</h2>
            
            <div class="space-y-6">
                {{-- Mata Uang --}}
                <div class="rounded-card border border-soft-divider bg-faint-gray p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-carbon-black">
                            <svg class="size-5 text-canvas-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="mb-2 text-lg font-semibold text-carbon-black">Mata Uang</h3>
                            <p class="text-sm leading-relaxed text-storm-gray">Semua harga yang tertera dan ditawarkan menggunakan mata uang <strong class="text-carbon-black">Rupiah (IDR)</strong>.</p>
                        </div>
                    </div>
                </div>

                {{-- Fasilitas Include --}}
                <div class="rounded-card border border-soft-divider bg-faint-gray p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-carbon-black">
                            <svg class="size-5 text-canvas-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="mb-2 text-lg font-semibold text-carbon-black">Fasilitas yang Termasuk</h3>
                            <p class="mb-3 text-sm leading-relaxed text-storm-gray">Harga sudah termasuk:</p>
                            <ul class="space-y-2 text-sm text-storm-gray">
                                <li class="flex items-start gap-2">
                                    <svg class="mt-0.5 size-4 shrink-0 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    <span>Bensin (Bahan Bakar)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="mt-0.5 size-4 shrink-0 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    <span>Biaya Parkir</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="mt-0.5 size-4 shrink-0 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    <span>Biaya Jalan Tol</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Kebutuhan Penjemputan --}}
                <div class="rounded-card border border-soft-divider bg-faint-gray p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-carbon-black">
                            <svg class="size-5 text-canvas-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="mb-2 text-lg font-semibold text-carbon-black">Kebutuhan Penjemputan di Bandara</h3>
                            <p class="text-sm leading-relaxed text-storm-gray">Untuk layanan penjemputan di Bandara, mohon siapkan:</p>
                            <ul class="mt-3 space-y-2 text-sm text-storm-gray">
                                <li class="flex items-start gap-2">
                                    <svg class="mt-0.5 size-4 shrink-0 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    <span><strong class="text-carbon-black">Nomor Penerbangan</strong> (Flight Number)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="mt-0.5 size-4 shrink-0 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    <span><strong class="text-carbon-black">Nama Lengkap</strong> untuk pembuatan papan nama penjemputan (Signboard)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Kebijakan Pembatalan --}}
                <div class="grid gap-6 md:grid-cols-2">
                    {{-- Pembatalan < 24 Jam --}}
                    <div class="rounded-card border border-soft-divider bg-faint-gray p-6">
                        <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-carbon-black">
                            <svg class="size-5 text-canvas-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-carbon-black">Pembatalan &lt; 24 Jam</h3>
                        <p class="text-sm leading-relaxed text-storm-gray">Pesanan yang dibatalkan <strong class="text-carbon-black">kurang dari 24 jam</strong> sebelum jadwal tidak dapat dikembalikan (<strong class="text-carbon-black">non-refundable</strong>).</p>
                    </div>

                    {{-- Pembatalan > 24 Jam --}}
                    <div class="rounded-card border border-soft-divider bg-faint-gray p-6">
                        <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-carbon-black">
                            <svg class="size-5 text-canvas-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-carbon-black">Pembatalan &gt; 24 Jam</h3>
                        <p class="text-sm leading-relaxed text-storm-gray">Pesanan yang dibatalkan <strong class="text-carbon-black">lebih dari 24 jam</strong> sebelum jadwal dapat dikembalikan (<strong class="text-carbon-black">refundable</strong>).</p>
                    </div>
                </div>

                {{-- Important Notice --}}
                <div class="rounded-card border-l-4 border-carbon-black bg-canvas-white p-5">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 size-5 shrink-0 text-carbon-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>
                        </svg>
                        <div class="text-sm leading-relaxed text-storm-gray">
                            <strong class="text-carbon-black">Catatan Penting:</strong> Dengan melakukan pemesanan, Anda dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan layanan kami. Untuk pertanyaan lebih lanjut, hubungi kami via WhatsApp.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-page-container>
</div>
@endsection
