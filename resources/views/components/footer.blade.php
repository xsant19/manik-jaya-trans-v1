<footer class="bg-faint-gray border-t border-soft-divider mt-24">
    <x-page-container class="py-12 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-1">
                <span class="font-bold text-xl text-carbon-black tracking-tight block mb-4 notranslate">MANIK JAYA.</span>
                <p class="text-storm-gray text-sm leading-relaxed">
                    Penyedia layanan transportasi wisata dan sewa kendaraan terpercaya di Bali dengan pelayanan premium.
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
                    <li><a href="{{ route('terms') }}" class="hover:text-carbon-black transition-colors">Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-carbon-black transition-colors">Kebijakan Privasi</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-bold text-carbon-black mb-4">Kontak</h4>
                <ul class="space-y-3 text-sm text-storm-gray">
                    <li>Jl. Manik Jaya No. 1, Denpasar, Bali</li>
                    <li>+62 812-3456-7890</li>
                    <li>info@manikjaya.test</li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-soft-divider mt-12 pt-8 text-center text-sm text-dust-bunny">
            &copy; {{ date('Y') }} Sistem Informasi Travel Manik Jaya Trans. All rights reserved.
        </div>
    </x-page-container>
</footer>
