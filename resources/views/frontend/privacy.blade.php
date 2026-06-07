@extends('layouts.app')

@section('content')

<!-- Header Section -->
<section class="py-16 md:py-24 bg-faint-gray border-b border-soft-divider">
    <x-page-container>
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-5xl font-bold text-carbon-black tracking-tight mb-6">
                Kebijakan Privasi
            </h1>
            <p class="text-storm-gray text-base md:text-lg">
                Terakhir diperbarui: {{ date('d F Y') }}
            </p>
        </div>
    </x-page-container>
</section>

<!-- Content Section -->
<section class="py-16 md:py-24 bg-canvas-white">
    <x-page-container>
        <div class="max-w-4xl mx-auto prose prose-carbon">
            <div class="space-y-12 text-carbon-black">
                
                <!-- Introduction -->
                <div class="space-y-4">
                    <p class="text-storm-gray leading-relaxed text-lg">
                        Manik Jaya Trans ("kami", "milik kami", atau "perusahaan") menghargai privasi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengungkapkan, dan melindungi informasi pribadi Anda saat Anda menggunakan website dan layanan transportasi kami.
                    </p>
                </div>

                <!-- Section 1: Pengumpulan Informasi -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">1. Informasi yang Kami Kumpulkan</h2>
                    <p class="text-storm-gray leading-relaxed">Kami mengumpulkan informasi dari Anda ketika Anda mendaftar di situs kami, memesan layanan, berlangganan buletin, merespons survei, atau mengisi formulir. Informasi yang kami kumpulkan termasuk namun tidak terbatas pada:</p>
                    <ul class="list-disc pl-5 space-y-2 text-storm-gray leading-relaxed">
                        <li><strong>Informasi Identitas:</strong> Nama lengkap, alamat email, nomor telepon, dan password (yang dienkripsi).</li>
                        <li><strong>Data Pemesanan:</strong> Rincian pemesanan seperti jenis kendaraan, tanggal sewa, lokasi penjemputan, dan preferensi layanan.</li>
                        <li><strong>Data Pembayaran:</strong> Kami menggunakan penyedia gerbang pembayaran (Midtrans). Kami tidak menyimpan rincian kartu kredit atau data perbankan sensitif Anda di server kami.</li>
                        <li><strong>Data Otomatis:</strong> Alamat IP, jenis peramban (browser), sistem operasi, dan informasi teknis lainnya terkait penggunaan website melalui cookies dan teknologi pelacakan serupa.</li>
                    </ul>
                </div>

                <!-- Section 2: Penggunaan Informasi -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">2. Bagaimana Kami Menggunakan Informasi Anda</h2>
                    <p class="text-storm-gray leading-relaxed">Informasi yang kami kumpulkan dari Anda dapat digunakan dalam salah satu cara berikut:</p>
                    <ul class="list-disc pl-5 space-y-2 text-storm-gray leading-relaxed">
                        <li><strong>Untuk memproses transaksi:</strong> Informasi Anda membantu kami memberikan layanan yang Anda pesan secara akurat dan efisien.</li>
                        <li><strong>Untuk meningkatkan layanan pelanggan:</strong> Informasi Anda membantu kami untuk lebih efektif merespons permintaan layanan pelanggan dan kebutuhan dukungan Anda.</li>
                        <li><strong>Untuk komunikasi:</strong> Alamat email yang Anda berikan untuk pemrosesan pesanan akan digunakan untuk mengirimi Anda informasi dan pembaruan terkait pesanan Anda, serta berita perusahaan, atau informasi layanan terkait (jika Anda berlangganan).</li>
                        <li><strong>Untuk meningkatkan situs web kami:</strong> Kami senantiasa berupaya menyempurnakan penawaran situs web kami berdasarkan informasi dan umpan balik yang kami terima dari Anda.</li>
                    </ul>
                </div>

                <!-- Section 3: Perlindungan Data -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">3. Perlindungan Informasi Anda</h2>
                    <p class="text-storm-gray leading-relaxed">
                        Kami menerapkan berbagai langkah keamanan untuk menjaga keamanan informasi pribadi Anda. Kata sandi pengguna dienkripsi secara sepihak (hash) sehingga tidak dapat dibaca oleh siapa pun, termasuk administrator kami. Transaksi pembayaran diproses dengan standar keamanan yang ketat oleh penyedia pihak ketiga (Midtrans) dan tidak disimpan di server kami.
                    </p>
                </div>

                <!-- Section 4: Pembagian Informasi -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">4. Pengungkapan kepada Pihak Ketiga</h2>
                    <p class="text-storm-gray leading-relaxed">
                        Kami tidak menjual, memperdagangkan, atau mentransfer informasi pengenal pribadi Anda kepada pihak luar. Hal ini tidak termasuk pihak ketiga tepercaya yang membantu kami dalam mengoperasikan situs web kami, menjalankan bisnis kami, atau melayani Anda (seperti penyedia layanan hosting atau gateway pembayaran), selama pihak-pihak tersebut setuju untuk merahasiakan informasi ini. 
                    </p>
                    <p class="text-storm-gray leading-relaxed">
                        Kami juga dapat merilis informasi Anda jika kami yakin bahwa perilisan tersebut sesuai untuk mematuhi hukum, menegakkan kebijakan situs kami, atau melindungi hak, properti, atau keselamatan kami atau pihak lain.
                    </p>
                </div>

                <!-- Section 5: Cookies -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">5. Penggunaan Cookies</h2>
                    <p class="text-storm-gray leading-relaxed">
                        Ya, kami menggunakan cookies. Cookies adalah file kecil yang ditransfer oleh situs atau penyedia layanannya ke hard drive komputer Anda melalui browser Web Anda (jika Anda mengizinkan) yang memungkinkan sistem situs atau penyedia layanan untuk mengenali browser Anda serta menangkap dan mengingat informasi tertentu (seperti preferensi sesi login Anda).
                    </p>
                </div>

                <!-- Section 6: Persetujuan dan Perubahan -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">6. Persetujuan dan Perubahan Kebijakan</h2>
                    <p class="text-storm-gray leading-relaxed">
                        Dengan menggunakan situs kami, Anda menyetujui kebijakan privasi situs web kami. Kami berhak untuk mengubah atau memperbarui Kebijakan Privasi ini kapan saja. Perubahan apa pun akan dipublikasikan di halaman ini dan tanggal pembaruan terakhir di bagian atas halaman ini akan direvisi.
                    </p>
                </div>
                
            </div>
        </div>
    </x-page-container>
</section>

<!-- CTA Section -->
<section class="py-16 md:py-24 bg-faint-gray border-t border-soft-divider">
    <x-page-container>
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-carbon-black tracking-tight mb-4">Pertanyaan Mengenai Privasi Anda?</h2>
            <p class="text-storm-gray mb-8">Hubungi kami jika Anda memiliki pertanyaan lebih lanjut tentang bagaimana kami menangani data Anda.</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 rounded-btn bg-carbon-black px-6 py-3 text-sm font-semibold text-canvas-white transition-opacity hover:opacity-90">
                Hubungi Kami
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                </svg>
            </a>
        </div>
    </x-page-container>
</section>

@endsection
