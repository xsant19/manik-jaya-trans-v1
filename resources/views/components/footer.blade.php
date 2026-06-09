<footer class="bg-faint-gray border-t border-soft-divider mt-24">
    <x-page-container class="py-12 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-1">
                <img src="https://res.cloudinary.com/dafmuqvhh/image/upload/v1781009142/Logo_f7m95a.png" alt="Manik Jaya Trans Logo" class="h-8 w-auto mb-4">
                <p class="text-storm-gray text-sm leading-relaxed">
                    {{ config('company.tagline') }}
                </p>
            </div>

            <div>
                <h4 class="font-bold text-carbon-black mb-4">Layanan</h4>
                <ul class="space-y-3 text-sm text-storm-gray">
                    <li><a href="{{ route('vehicles.index') }}" class="hover:text-carbon-black transition-colors">Sewa Kendaraan</a></li>
                    <li><a href="{{ route('tours.index') }}" class="hover:text-carbon-black transition-colors">Paket Wisata</a></li>
                    <li><a href="{{ route('transfers.index') }}" class="notranslate hover:text-carbon-black transition-colors">Airport Transfer</a></li>
                    <li><a href="{{ route('shuttles.index') }}" class="notranslate hover:text-carbon-black transition-colors">Hotel Shuttle</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-carbon-black mb-4">Perusahaan</h4>
                <ul class="space-y-3 text-sm text-storm-gray">
                    <li><a href="{{ route('about') }}" class="hover:text-carbon-black transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-carbon-black transition-colors">Hubungi Kami</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-carbon-black transition-colors">Syarat &amp; Ketentuan</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-carbon-black transition-colors">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-carbon-black mb-4">Kontak</h4>
                <ul class="space-y-3 text-sm text-storm-gray">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-dust-bunny" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>{{ config('company.address') }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0 text-dust-bunny" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <a href="{{ config('company.wa_link') }}" target="_blank" rel="noopener" class="hover:text-carbon-black transition-colors notranslate">
                            {{ config('company.phone') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0 text-dust-bunny" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <a href="mailto:{{ config('company.email') }}" class="hover:text-carbon-black transition-colors notranslate">
                            {{ config('company.email') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-soft-divider mt-12 pt-8 text-center text-sm text-dust-bunny">
            &copy; {{ date('Y') }} {{ config('company.name') }}. All rights reserved.
        </div>
    </x-page-container>
</footer>
