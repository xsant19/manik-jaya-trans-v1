@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="py-20 md:py-28 bg-canvas-white">
    <x-page-container>
        <div class="max-w-3xl mx-auto text-center">
            <p class="mb-4 inline-flex items-center gap-2 text-xs font-medium uppercase tracking-widest text-storm-gray">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                Hubungi Kami
            </p>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-carbon-black tracking-tight leading-tight mb-6">
                Ada Pertanyaan?
            </h1>
            <div class="w-16 h-0.5 bg-carbon-black mx-auto mb-8"></div>
            <p class="text-storm-gray text-base md:text-lg leading-relaxed max-w-2xl mx-auto">
                Kami siap membantu Anda merencanakan perjalanan terbaik di Bali. Hubungi kami melalui form di bawah atau langsung melalui kontak yang tersedia.
            </p>
        </div>
    </x-page-container>
</section>

<!-- Contact Info Cards -->
<section class="bg-canvas-white pb-16">
    <x-page-container>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Email -->
            <div class="bg-faint-gray p-6 rounded-card border border-soft-divider text-center" id="contact-card-email">
                <div class="w-12 h-12 mx-auto mb-4 bg-canvas-white rounded-card flex items-center justify-center border border-soft-divider">
                    <svg class="w-5 h-5 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                </div>
                <h3 class="font-bold text-carbon-black mb-1">Email</h3>
                <a href="mailto:{{ config('company.email') }}" class="text-sm text-storm-gray hover:text-carbon-black transition-colors notranslate">{{ config('company.email') }}</a>
            </div>

            <!-- Telepon -->
            <div class="bg-faint-gray p-6 rounded-card border border-soft-divider text-center" id="contact-card-phone">
                <div class="w-12 h-12 mx-auto mb-4 bg-canvas-white rounded-card flex items-center justify-center border border-soft-divider">
                    <svg class="w-5 h-5 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-carbon-black mb-1">Telepon</h3>
                <a href="{{ config('company.wa_link') }}" target="_blank" rel="noopener" class="text-sm text-storm-gray hover:text-carbon-black transition-colors notranslate">{{ config('company.phone') }}</a>
            </div>

            <!-- Alamat -->
            <div class="bg-faint-gray p-6 rounded-card border border-soft-divider text-center" id="contact-card-address">
                <div class="w-12 h-12 mx-auto mb-4 bg-canvas-white rounded-card flex items-center justify-center border border-soft-divider">
                    <svg class="w-5 h-5 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <h3 class="font-bold text-carbon-black mb-1">Alamat</h3>
                <p class="text-sm text-storm-gray">{{ config('company.address') }}</p>
            </div>
        </div>
    </x-page-container>
</section>

<!-- Contact Form + Map -->
<section class="py-20 md:py-24 bg-faint-gray">
    <x-page-container>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-16">
            <!-- Contact Form -->
            <div>
                <p class="text-xs font-medium uppercase tracking-widest text-storm-gray mb-3">Kirim Pesan</p>
                <h2 class="text-3xl md:text-4xl font-bold text-carbon-black tracking-tight mb-2">
                    Hubungi Kami
                </h2>
                <p class="text-storm-gray mb-8">
                    Isi form di bawah dan kami akan segera merespons pesan Anda.
                </p>

                <form id="contact-form" class="space-y-5" onsubmit="return false;">
                    <div>
                        <label for="contact-name" class="block text-sm font-medium text-carbon-black mb-1.5">Nama Lengkap</label>
                        <input
                            type="text"
                            id="contact-name"
                            required
                            placeholder="Masukkan nama Anda"
                            class="w-full px-4 py-3 text-carbon-black bg-canvas-white border border-soft-divider rounded-btn outline-none focus:border-carbon-black transition-colors placeholder:text-dust-bunny"
                        />
                    </div>
                    <div>
                        <label for="contact-email" class="block text-sm font-medium text-carbon-black mb-1.5">Email</label>
                        <input
                            type="email"
                            id="contact-email"
                            required
                            placeholder="email@contoh.com"
                            class="w-full px-4 py-3 text-carbon-black bg-canvas-white border border-soft-divider rounded-btn outline-none focus:border-carbon-black transition-colors placeholder:text-dust-bunny"
                        />
                    </div>
                    <div>
                        <label for="contact-phone" class="block text-sm font-medium text-carbon-black mb-1.5">No. Telepon</label>
                        <input
                            type="tel"
                            id="contact-phone"
                            placeholder="+62 812-xxxx-xxxx"
                            class="w-full px-4 py-3 text-carbon-black bg-canvas-white border border-soft-divider rounded-btn outline-none focus:border-carbon-black transition-colors placeholder:text-dust-bunny"
                        />
                    </div>
                    <div>
                        <label for="contact-message" class="block text-sm font-medium text-carbon-black mb-1.5">Pesan</label>
                        <textarea
                            id="contact-message"
                            required
                            rows="5"
                            placeholder="Tuliskan pesan atau pertanyaan Anda..."
                            class="w-full px-4 py-3 text-carbon-black bg-canvas-white border border-soft-divider rounded-btn outline-none focus:border-carbon-black transition-colors resize-none placeholder:text-dust-bunny"
                        ></textarea>
                    </div>
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-btn bg-carbon-black px-6 py-3 text-sm font-semibold text-canvas-white transition-opacity hover:opacity-90"
                    >
                        Kirim Pesan
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Google Maps Embed -->
            <div>
                <p class="text-xs font-medium uppercase tracking-widest text-storm-gray mb-3">Lokasi Kami</p>
                <h2 class="text-3xl md:text-4xl font-bold text-carbon-black tracking-tight mb-2">
                    Temukan Kami
                </h2>
                <p class="text-storm-gray mb-8">
                    Kunjungi kantor kami di Denpasar, Bali.
                </p>

                {{-- Google Maps Embed — responsif --}}
                <div class="rounded-card overflow-hidden border border-soft-divider bg-canvas-white">
                    <div class="relative w-full" style="padding-top: 60%;">
                        <iframe
                            id="contact-map"
                            src="{{ config('company.maps_embed_url') }}"
                            class="absolute inset-0 w-full h-full"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi {{ config('company.name') }} — {{ config('company.address') }}"
                        ></iframe>
                    </div>
                </div>

                {{-- Tombol buka di Google Maps --}}
                <a
                    href="{{ config('company.maps_share_url') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-3 inline-flex items-center gap-2 text-sm text-storm-gray hover:text-carbon-black transition-colors"
                    id="btn-open-gmaps"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    Buka di Google Maps
                </a>

                <!-- Address detail below map -->
                <div class="mt-6 flex items-start gap-4 p-5 bg-canvas-white rounded-card border border-soft-divider">
                    <div class="flex-shrink-0 w-10 h-10 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                        <svg class="w-5 h-5 text-carbon-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-carbon-black text-sm notranslate">{{ config('company.name') }}</h4>
                        <p class="text-sm text-storm-gray mt-0.5">{{ config('company.address') }}</p>
                        <p class="text-sm text-storm-gray">{{ config('company.hours') }}</p>
                        {{-- Tombol WhatsApp --}}
                        <a
                            href="{{ config('company.wa_link') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            id="btn-whatsapp-contact"
                            class="mt-3 inline-flex items-center gap-2 rounded-btn bg-[#25D366] px-4 py-2 text-sm font-semibold text-white transition-opacity hover:opacity-90"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                            </svg>
                            Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-page-container>
</section>

<!-- FAQ Section -->
<section class="py-20 md:py-24 bg-canvas-white" id="faq-section">
    <x-page-container>
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-14">
                <p class="text-xs font-medium uppercase tracking-widest text-storm-gray mb-3">FAQ</p>
                <x-section-heading>Pertanyaan yang Sering Diajukan</x-section-heading>
                <p class="text-storm-gray max-w-xl mx-auto">
                    Temukan jawaban untuk pertanyaan umum seputar layanan Manik Jaya Trans.
                </p>
            </div>

            <!-- Accordion -->
            <div class="space-y-3" id="faq-accordion">

                <!-- FAQ 1 -->
                <div class="faq-item border border-soft-divider rounded-card overflow-hidden" data-faq-open="true">
                    <button type="button" class="faq-trigger w-full flex items-center justify-between gap-4 p-5 text-left bg-canvas-white hover:bg-faint-gray transition-colors" aria-expanded="true">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-storm-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>
                                </svg>
                            </div>
                            <span class="text-base font-medium text-carbon-black">Bagaimana cara melakukan booking?</span>
                        </div>
                        <svg class="faq-chevron w-5 h-5 text-storm-gray transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <div class="faq-content">
                        <div class="px-5 pb-5 pt-0">
                            <div class="ml-11 p-4 bg-faint-gray rounded-lg text-sm text-storm-gray leading-relaxed">
                                Anda dapat melakukan booking langsung melalui website kami. Pilih layanan yang diinginkan (sewa kendaraan, paket wisata, airport transfer, atau hotel shuttle), isi form booking dengan data yang diperlukan, kemudian lanjutkan ke pembayaran. Booking Anda akan dikonfirmasi oleh tim kami.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item border border-soft-divider rounded-card overflow-hidden">
                    <button type="button" class="faq-trigger w-full flex items-center justify-between gap-4 p-5 text-left bg-canvas-white hover:bg-faint-gray transition-colors" aria-expanded="false">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-storm-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>
                                </svg>
                            </div>
                            <span class="text-base font-medium text-carbon-black">Metode pembayaran apa saja yang tersedia?</span>
                        </div>
                        <svg class="faq-chevron w-5 h-5 text-storm-gray transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <div class="faq-content">
                        <div class="px-5 pb-5 pt-0">
                            <div class="ml-11 p-4 bg-faint-gray rounded-lg text-sm text-storm-gray leading-relaxed">
                                Kami mendukung berbagai metode pembayaran melalui Midtrans, termasuk transfer bank (BCA, BNI, BRI, Mandiri), e-wallet (GoPay, OVO, DANA), kartu kredit/debit, dan gerai retail (Alfamart, Indomaret). Pembayaran diproses secara aman dan real-time.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-item border border-soft-divider rounded-card overflow-hidden">
                    <button type="button" class="faq-trigger w-full flex items-center justify-between gap-4 p-5 text-left bg-canvas-white hover:bg-faint-gray transition-colors" aria-expanded="false">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-storm-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>
                                </svg>
                            </div>
                            <span class="text-base font-medium text-carbon-black">Apakah sewa kendaraan sudah termasuk supir?</span>
                        </div>
                        <svg class="faq-chevron w-5 h-5 text-storm-gray transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <div class="faq-content">
                        <div class="px-5 pb-5 pt-0">
                            <div class="ml-11 p-4 bg-faint-gray rounded-lg text-sm text-storm-gray leading-relaxed">
                                Ya, semua layanan sewa kendaraan kami sudah termasuk supir profesional. Anda tidak perlu memilih supir saat booking — tim kami yang akan menugaskan supir terbaik untuk perjalanan Anda. Supir kami berpengalaman, ramah, dan menguasai rute wisata di Bali.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="faq-item border border-soft-divider rounded-card overflow-hidden">
                    <button type="button" class="faq-trigger w-full flex items-center justify-between gap-4 p-5 text-left bg-canvas-white hover:bg-faint-gray transition-colors" aria-expanded="false">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-storm-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>
                                </svg>
                            </div>
                            <span class="text-base font-medium text-carbon-black">Bisakah saya membatalkan booking?</span>
                        </div>
                        <svg class="faq-chevron w-5 h-5 text-storm-gray transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <div class="faq-content">
                        <div class="px-5 pb-5 pt-0">
                            <div class="ml-11 p-4 bg-faint-gray rounded-lg text-sm text-storm-gray leading-relaxed">
                                Booking dengan status "Menunggu" (pending) atau "Disetujui" (approved) dapat dibatalkan. Silakan hubungi tim kami melalui telepon atau email untuk proses pembatalan. Booking yang sudah dalam perjalanan atau selesai tidak dapat dibatalkan.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="faq-item border border-soft-divider rounded-card overflow-hidden">
                    <button type="button" class="faq-trigger w-full flex items-center justify-between gap-4 p-5 text-left bg-canvas-white hover:bg-faint-gray transition-colors" aria-expanded="false">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-storm-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>
                                </svg>
                            </div>
                            <span class="text-base font-medium text-carbon-black">Apa perbedaan sewa full day dan half day?</span>
                        </div>
                        <svg class="faq-chevron w-5 h-5 text-storm-gray transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <div class="faq-content">
                        <div class="px-5 pb-5 pt-0">
                            <div class="ml-11 p-4 bg-faint-gray rounded-lg text-sm text-storm-gray leading-relaxed">
                                Sewa <strong>full day</strong> (seharian) mencakup penggunaan kendaraan dan supir selama kurang lebih 10–12 jam, cocok untuk wisata ke beberapa destinasi. Sewa <strong>half day</strong> (setengah hari) mencakup sekitar 5–6 jam, ideal untuk perjalanan singkat atau kunjungan ke satu atau dua tempat.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="faq-item border border-soft-divider rounded-card overflow-hidden">
                    <button type="button" class="faq-trigger w-full flex items-center justify-between gap-4 p-5 text-left bg-canvas-white hover:bg-faint-gray transition-colors" aria-expanded="false">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-storm-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>
                                </svg>
                            </div>
                            <span class="text-base font-medium text-carbon-black">Bagaimana saya melihat status booking saya?</span>
                        </div>
                        <svg class="faq-chevron w-5 h-5 text-storm-gray transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <div class="faq-content">
                        <div class="px-5 pb-5 pt-0">
                            <div class="ml-11 p-4 bg-faint-gray rounded-lg text-sm text-storm-gray leading-relaxed">
                                Setelah login, Anda dapat mengakses halaman <strong>Dashboard</strong> untuk melihat ringkasan booking Anda, atau halaman <strong>Riwayat Booking</strong> untuk melihat semua detail booking beserta status booking dan status pembayaran secara lengkap.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="faq-item border border-soft-divider rounded-card overflow-hidden">
                    <button type="button" class="faq-trigger w-full flex items-center justify-between gap-4 p-5 text-left bg-canvas-white hover:bg-faint-gray transition-colors" aria-expanded="false">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-faint-gray rounded-lg flex items-center justify-center border border-soft-divider">
                                <svg class="w-4 h-4 text-storm-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>
                                </svg>
                            </div>
                            <span class="text-base font-medium text-carbon-black">Apakah layanan airport transfer tersedia 24 jam?</span>
                        </div>
                        <svg class="faq-chevron w-5 h-5 text-storm-gray transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <div class="faq-content">
                        <div class="px-5 pb-5 pt-0">
                            <div class="ml-11 p-4 bg-faint-gray rounded-lg text-sm text-storm-gray leading-relaxed">
                                Ya, layanan airport transfer kami tersedia kapan saja sesuai jadwal penerbangan Anda, termasuk untuk penerbangan dini hari atau larut malam. Cukup isi waktu jemput saat booking dan driver kami akan siap tepat waktu di lokasi.
                            </div>
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

<!-- FAQ Accordion Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var accordion = document.getElementById('faq-accordion');
    if (!accordion) return;

    var items = accordion.querySelectorAll('.faq-item');

    items.forEach(function (item) {
        var trigger = item.querySelector('.faq-trigger');
        var content = item.querySelector('.faq-content');
        var chevron = item.querySelector('.faq-chevron');
        var isOpen = item.getAttribute('data-faq-open') === 'true';

        // Set initial state
        if (isOpen) {
            content.style.maxHeight = content.scrollHeight + 'px';
            content.style.opacity = '1';
            chevron.style.transform = 'rotate(180deg)';
            trigger.setAttribute('aria-expanded', 'true');
        } else {
            content.style.maxHeight = '0';
            content.style.opacity = '0';
            content.style.overflow = 'hidden';
            trigger.setAttribute('aria-expanded', 'false');
        }

        trigger.addEventListener('click', function () {
            var currentlyOpen = trigger.getAttribute('aria-expanded') === 'true';

            // Close all items
            items.forEach(function (otherItem) {
                var otherTrigger = otherItem.querySelector('.faq-trigger');
                var otherContent = otherItem.querySelector('.faq-content');
                var otherChevron = otherItem.querySelector('.faq-chevron');

                otherContent.style.maxHeight = '0';
                otherContent.style.opacity = '0';
                otherContent.style.overflow = 'hidden';
                otherChevron.style.transform = 'rotate(0deg)';
                otherTrigger.setAttribute('aria-expanded', 'false');
                otherItem.removeAttribute('data-faq-open');
            });

            // Toggle clicked item
            if (!currentlyOpen) {
                content.style.maxHeight = content.scrollHeight + 'px';
                content.style.opacity = '1';
                content.style.overflow = 'visible';
                chevron.style.transform = 'rotate(180deg)';
                trigger.setAttribute('aria-expanded', 'true');
                item.setAttribute('data-faq-open', 'true');
            }
        });
    });
});
</script>

@endsection
