@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="py-20 md:py-28 bg-canvas-white">
    <x-page-container>
        <div class="max-w-3xl mx-auto text-center">
            <p class="mb-4 inline-flex items-center gap-2 text-xs font-medium uppercase tracking-widest text-storm-gray">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                </svg>
                Bali, Indonesia
            </p>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-carbon-black tracking-tight leading-tight mb-6">
                Tentang Kami
            </h1>
            <div class="w-16 h-0.5 bg-carbon-black mx-auto mb-8"></div>
            <p class="text-storm-gray text-base md:text-lg leading-relaxed max-w-2xl mx-auto">
                Manik Jaya Trans adalah penyedia layanan transportasi wisata dan sewa kendaraan tepercaya di Bali. Kami berkomitmen memberikan pengalaman perjalanan terbaik dengan armada terawat dan driver profesional.
            </p>
        </div>
    </x-page-container>
</section>

<!-- Image Banner -->
<section class="bg-canvas-white">
    <x-page-container>
        <div class="rounded-card overflow-hidden border border-soft-divider">
            <img
                src="https://res.cloudinary.com/dafmuqvhh/image/upload/v1781011657/Jalan-Cinta_-Bali_ipibmo.jpg"
                alt="Jalan Cinta Bali Indonesia"
                class="w-full h-[280px] md:h-[400px] object-cover object-center"
            />
        </div>
    </x-page-container>
</section>

<!-- Our Story -->
<section class="py-20 md:py-24 bg-faint-gray">
    <x-page-container>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16 items-center">
            <div>
                <p class="text-xs font-medium uppercase tracking-widest text-storm-gray mb-3">Cerita Kami</p>
                <h2 class="text-3xl md:text-4xl font-bold text-carbon-black tracking-tight mb-6">
                    Berpengalaman Melayani Wisatawan di Bali
                </h2>
                <div class="space-y-4 text-storm-gray text-base leading-relaxed">
                    <p>
                        Berawal dari kecintaan terhadap keindahan Bali dan semangat untuk berbagi pengalaman, Manik Jaya Trans didirikan dengan satu tujuan: menjadikan setiap perjalanan di Bali nyaman, aman, dan berkesan.
                    </p>
                    <p>
                        Kami memahami bahwa transportasi adalah bagian penting dari pengalaman wisata. Oleh karena itu, kami menghadirkan armada kendaraan yang selalu terawat, driver profesional yang ramah dan berpengalaman, serta layanan yang fleksibel sesuai kebutuhan Anda.
                    </p>
                    <p>
                        Dari sewa kendaraan harian, paket wisata, airport transfer, hingga hotel shuttle — semua dirancang untuk memberikan kemudahan dan kenyamanan maksimal bagi setiap tamu kami.
                    </p>
                </div>
            </div>
            <div class="rounded-card overflow-hidden border border-soft-divider">
                <img
                    src="https://res.cloudinary.com/dafmuqvhh/image/upload/q_auto/f_auto/v1781011279/Tegalalang_kiswqz.jpg"
                    alt="Tegallalang Rice Terrace Ubud Bali"
                    class="w-full h-[320px] md:h-[400px] object-cover object-center"
                />
            </div>
        </div>
    </x-page-container>
</section>

<!-- Services -->
<section class="py-20 md:py-24 bg-canvas-white">
    <x-page-container>
        <div class="text-center mb-14">
            <p class="text-xs font-medium uppercase tracking-widest text-storm-gray mb-3">Apa yang Kami Tawarkan</p>
            <x-section-heading>Layanan Kami</x-section-heading>
            <p class="text-storm-gray max-w-2xl mx-auto">
                Empat layanan utama yang dirancang untuk memenuhi segala kebutuhan transportasi Anda di Bali.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Sewa Kendaraan -->
            <a href="{{ route('vehicles.index') }}" class="group block" id="about-service-vehicles">
                <div class="bg-faint-gray p-8 rounded-card border border-soft-divider hover:border-carbon-black transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-carbon-black rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-canvas-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                                <circle cx="7" cy="17" r="2"/>
                                <path d="M9 17h6"/>
                                <circle cx="17" cy="17" r="2"/>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-carbon-black mb-2 group-hover:underline decoration-1 underline-offset-4">Sewa Kendaraan</h3>
                            <p class="text-storm-gray text-sm leading-relaxed">
                                Pilihan armada kendaraan terawat untuk perjalanan harian atau setengah hari dengan supir berpengalaman yang siap mengantar Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Paket Wisata -->
            <a href="{{ route('tours.index') }}" class="group block" id="about-service-tours">
                <div class="bg-faint-gray p-8 rounded-card border border-soft-divider hover:border-carbon-black transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-carbon-black rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-canvas-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-carbon-black mb-2 group-hover:underline decoration-1 underline-offset-4">Paket Wisata</h3>
                            <p class="text-storm-gray text-sm leading-relaxed">
                                Paket wisata terkurasi ke destinasi terbaik Bali dengan itinerary fleksibel dan pengalaman tak terlupakan bersama guide lokal.
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Airport Transfer -->
            <a href="{{ route('transfers.index') }}" class="group block" id="about-service-transfers">
                <div class="bg-faint-gray p-8 rounded-card border border-soft-divider hover:border-carbon-black transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-carbon-black rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-canvas-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-carbon-black mb-2 group-hover:underline decoration-1 underline-offset-4 notranslate">Airport Transfer</h3>
                            <p class="text-storm-gray text-sm leading-relaxed">
                                Layanan antar-jemput bandara tepat waktu dengan driver profesional yang siap menyambut kedatangan atau mengantar keberangkatan Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Hotel Shuttle -->
            <a href="{{ route('shuttles.index') }}" class="group block" id="about-service-shuttles">
                <div class="bg-faint-gray p-8 rounded-card border border-soft-divider hover:border-carbon-black transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-carbon-black rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-canvas-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-carbon-black mb-2 group-hover:underline decoration-1 underline-offset-4 notranslate">Hotel Shuttle</h3>
                            <p class="text-storm-gray text-sm leading-relaxed">
                                Shuttle terjadwal dari dan ke hotel pilihan dengan kenyamanan maksimal untuk mobilitas harian Anda selama di Bali.
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </x-page-container>
</section>

<!-- Stats -->
<section class="py-20 md:py-24 bg-faint-gray">
    <x-page-container>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6" id="about-stats">
            <!-- Stat 1 -->
            <div class="bg-canvas-white p-6 md:p-8 rounded-card border border-soft-divider text-center about-stat-card" id="about-stat-projects">
                <div class="w-12 h-12 mx-auto mb-4 bg-faint-gray rounded-card flex items-center justify-center">
                    <svg class="w-6 h-6 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/>
                        <line x1="4" x2="4" y1="22" y2="15"/>
                    </svg>
                </div>
                <p class="text-3xl md:text-4xl font-bold text-carbon-black" data-count="500">0</p>
                <p class="text-sm text-storm-gray mt-1">Perjalanan Selesai</p>
                <div class="w-8 h-0.5 bg-carbon-black mx-auto mt-3"></div>
            </div>

            <!-- Stat 2 -->
            <div class="bg-canvas-white p-6 md:p-8 rounded-card border border-soft-divider text-center about-stat-card" id="about-stat-clients">
                <div class="w-12 h-12 mx-auto mb-4 bg-faint-gray rounded-card flex items-center justify-center">
                    <svg class="w-6 h-6 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <p class="text-3xl md:text-4xl font-bold text-carbon-black" data-count="1200">0</p>
                <p class="text-sm text-storm-gray mt-1">Tamu Puas</p>
                <div class="w-8 h-0.5 bg-carbon-black mx-auto mt-3"></div>
            </div>

            <!-- Stat 3 -->
            <div class="bg-canvas-white p-6 md:p-8 rounded-card border border-soft-divider text-center about-stat-card" id="about-stat-experience">
                <div class="w-12 h-12 mx-auto mb-4 bg-faint-gray rounded-card flex items-center justify-center">
                    <svg class="w-6 h-6 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                    </svg>
                </div>
                <p class="text-3xl md:text-4xl font-bold text-carbon-black" data-count="10">0</p>
                <p class="text-sm text-storm-gray mt-1">Tahun Pengalaman</p>
                <div class="w-8 h-0.5 bg-carbon-black mx-auto mt-3"></div>
            </div>

            <!-- Stat 4 -->
            <div class="bg-canvas-white p-6 md:p-8 rounded-card border border-soft-divider text-center about-stat-card" id="about-stat-satisfaction">
                <div class="w-12 h-12 mx-auto mb-4 bg-faint-gray rounded-card flex items-center justify-center">
                    <svg class="w-6 h-6 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <p class="text-3xl md:text-4xl font-bold text-carbon-black" data-count="98" data-suffix="%">0</p>
                <p class="text-sm text-storm-gray mt-1">Kepuasan Pelanggan</p>
                <div class="w-8 h-0.5 bg-carbon-black mx-auto mt-3"></div>
            </div>
        </div>
    </x-page-container>
</section>

<!-- Why Choose Us -->
<section class="py-20 md:py-24 bg-canvas-white">
    <x-page-container>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16 items-center">
            <div class="order-2 md:order-1 rounded-card overflow-hidden border border-soft-divider">
                <img
                    src="https://res.cloudinary.com/dafmuqvhh/image/upload/q_auto/f_auto/v1781011289/Uluwatu_xym36w.jpg"
                    alt="Pura Uluwatu Bali"
                    class="w-full h-[320px] md:h-[400px] object-cover object-center"
                />
            </div>
            <div class="order-1 md:order-2">
                <p class="text-xs font-medium uppercase tracking-widest text-storm-gray mb-3">Mengapa Memilih Kami</p>
                <h2 class="text-3xl md:text-4xl font-bold text-carbon-black tracking-tight mb-8">
                    Kepercayaan yang Terbangun dari Pelayanan
                </h2>
                <div class="space-y-6">
                    <!-- Point 1 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-carbon-black mb-1">Armada Terawat</h3>
                            <p class="text-sm text-storm-gray leading-relaxed">Semua kendaraan kami dirawat secara berkala untuk menjamin keamanan dan kenyamanan perjalanan Anda.</p>
                        </div>
                    </div>

                    <!-- Point 2 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-carbon-black mb-1">Driver Profesional</h3>
                            <p class="text-sm text-storm-gray leading-relaxed">Driver kami ramah, berpengalaman, dan menguasai rute-rute wisata di seluruh Bali.</p>
                        </div>
                    </div>

                    <!-- Point 3 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-carbon-black mb-1">Harga Transparan</h3>
                            <p class="text-sm text-storm-gray leading-relaxed">Tidak ada biaya tersembunyi. Harga yang tertera adalah harga yang Anda bayar, jelas dan terjangkau.</p>
                        </div>
                    </div>

                    <!-- Point 4 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-carbon-black mb-1">Booking Mudah</h3>
                            <p class="text-sm text-storm-gray leading-relaxed">Proses pemesanan cepat dan mudah langsung melalui website dengan konfirmasi instan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-page-container>
</section>

<!-- CTA Section -->
<section class="py-20 md:py-24 bg-faint-gray">
    <x-page-container>
        <div class="bg-carbon-black p-8 md:p-12 rounded-card">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-2xl md:text-3xl font-bold text-canvas-white mb-2">Siap Menjelajahi Bali?</h3>
                    <p class="text-dust-bunny">Mulai rencanakan perjalanan Anda bersama Manik Jaya Trans.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('vehicles.index') }}"
                       class="inline-flex items-center gap-2 rounded-btn bg-canvas-white px-6 py-3 text-sm font-semibold text-carbon-black transition-opacity hover:opacity-90">
                        Lihat Kendaraan
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('tours.index') }}"
                       class="inline-flex items-center gap-2 rounded-btn border border-canvas-white/40 bg-canvas-white/10 px-6 py-3 text-sm font-semibold text-canvas-white backdrop-blur-sm transition-colors hover:bg-canvas-white/20">
                        Paket Wisata
                    </a>
                </div>
            </div>
        </div>
    </x-page-container>
</section>

<!-- Stat Counter & Entrance Animation Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var statsSection = document.getElementById('about-stats');
    if (!statsSection) return;

    var animated = false;
    var cards = document.querySelectorAll('.about-stat-card');

    function animateCounters() {
        if (animated) return;

        var rect = statsSection.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.85 && rect.bottom > 0) {
            animated = true;

            // Trigger card entrance
            cards.forEach(function (card) {
                card.classList.add('about-stat-card--visible');
            });

            // Animate numbers
            document.querySelectorAll('[data-count]').forEach(function (el) {
                var target = parseInt(el.getAttribute('data-count'), 10);
                var suffix = el.getAttribute('data-suffix') || '+';
                var duration = 1600;
                var startTime = null;

                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    var progress = Math.min((timestamp - startTime) / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3);
                    var current = Math.floor(eased * target);
                    el.textContent = current.toLocaleString('id-ID') + (progress >= 1 ? suffix : '');
                    if (progress < 1) {
                        requestAnimationFrame(step);
                    }
                }

                requestAnimationFrame(step);
            });
        }
    }

    window.addEventListener('scroll', animateCounters, { passive: true });
    animateCounters();
});
</script>

@endsection
