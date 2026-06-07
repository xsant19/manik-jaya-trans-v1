@extends('layouts.app')

@section('content')

<!-- Header Section -->
<section class="py-16 md:py-24 bg-faint-gray border-b border-soft-divider">
    <x-page-container>
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-5xl font-bold text-carbon-black tracking-tight mb-6">
                Syarat dan Ketentuan
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
                        Selamat datang di Manik Jaya Trans. Syarat dan Ketentuan ini mengatur penggunaan layanan kami, termasuk penyewaan kendaraan, pemesanan paket wisata, airport transfer, dan hotel shuttle. Dengan menggunakan layanan kami, Anda menyetujui seluruh ketentuan yang tercantum di bawah ini.
                    </p>
                </div>

                <!-- Section 1: Pemesanan dan Pembayaran -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">1. Pemesanan dan Pembayaran</h2>
                    <ul class="list-disc pl-5 space-y-2 text-storm-gray leading-relaxed">
                        <li>Semua pemesanan harus dilakukan melalui platform resmi kami (website) atau kontak resmi.</li>
                        <li>Pembayaran penuh atau uang muka (DP) wajib dibayarkan sesuai dengan ketentuan layanan yang dipilih untuk mengonfirmasi pemesanan.</li>
                        <li>Pembayaran menggunakan gerbang pembayaran (Midtrans) tunduk pada syarat dan ketentuan dari penyedia layanan pembayaran tersebut.</li>
                        <li>Harga yang tertera sudah termasuk pajak dan biaya layanan, kecuali dinyatakan lain.</li>
                    </ul>
                </div>

                <!-- Section 2: Sewa Kendaraan -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">2. Ketentuan Sewa Kendaraan</h2>
                    <ul class="list-disc pl-5 space-y-2 text-storm-gray leading-relaxed">
                        <li>Seluruh penyewaan kendaraan <strong>wajib menggunakan supir</strong> dari pihak Manik Jaya Trans. Kami tidak melayani sewa lepas kunci.</li>
                        <li>Harga sewa sudah termasuk bahan bakar (BBM) dan jasa supir, namun tidak termasuk tiket masuk tempat wisata, parkir, dan tol (kecuali dinyatakan lain pada paket tertentu).</li>
                        <li>Sewa <em>full day</em> berlaku untuk durasi 10-12 jam, sedangkan sewa <em>half day</em> berlaku untuk durasi 5-6 jam dalam satu hari.</li>
                        <li>Kelebihan waktu (overtime) akan dikenakan biaya tambahan sebesar 10% dari harga sewa per jam.</li>
                    </ul>
                </div>

                <!-- Section 3: Pembatalan dan Pengembalian Dana -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">3. Pembatalan dan Pengembalian Dana (Refund)</h2>
                    <ul class="list-disc pl-5 space-y-2 text-storm-gray leading-relaxed">
                        <li>Pembatalan yang dilakukan lebih dari 48 jam sebelum waktu layanan akan mendapatkan pengembalian dana penuh (dipotong biaya administrasi bank/payment gateway jika ada).</li>
                        <li>Pembatalan dalam kurun waktu 24-48 jam sebelum waktu layanan akan dikenakan biaya pembatalan sebesar 50% dari total tagihan.</li>
                        <li>Pembatalan kurang dari 24 jam sebelum waktu layanan (No Show) tidak memenuhi syarat untuk pengembalian dana (non-refundable).</li>
                        <li>Proses pengembalian dana membutuhkan waktu 3-7 hari kerja tergantung pada metode pembayaran yang digunakan.</li>
                    </ul>
                </div>

                <!-- Section 4: Kewajiban dan Tanggung Jawab -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">4. Kewajiban dan Tanggung Jawab Penumpang</h2>
                    <ul class="list-disc pl-5 space-y-2 text-storm-gray leading-relaxed">
                        <li>Penumpang wajib menjaga kebersihan dan ketertiban di dalam kendaraan.</li>
                        <li>Dilarang membawa barang-barang berbahaya, ilegal, atau berbau menyengat ke dalam kendaraan.</li>
                        <li>Manik Jaya Trans tidak bertanggung jawab atas kehilangan atau kerusakan barang pribadi penumpang selama perjalanan.</li>
                        <li>Penumpang bertanggung jawab penuh atas kerusakan pada kendaraan yang disebabkan oleh kelalaian atau kesengajaan penumpang.</li>
                    </ul>
                </div>

                <!-- Section 5: Keadaan Memaksa (Force Majeure) -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">5. Keadaan Memaksa (Force Majeure)</h2>
                    <p class="text-storm-gray leading-relaxed">
                        Manik Jaya Trans dibebaskan dari tanggung jawab atas keterlambatan atau kegagalan dalam memberikan layanan yang disebabkan oleh kejadian di luar kendali kami (Force Majeure), termasuk namun tidak terbatas pada bencana alam, cuaca buruk, kerusuhan, pemogokan, penutupan jalan, atau gangguan lalu lintas yang parah.
                    </p>
                </div>

                <!-- Section 6: Perubahan Ketentuan -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold border-b border-soft-divider pb-2">6. Perubahan Syarat dan Ketentuan</h2>
                    <p class="text-storm-gray leading-relaxed">
                        Kami berhak untuk mengubah atau memperbarui Syarat dan Ketentuan ini kapan saja tanpa pemberitahuan sebelumnya. Perubahan akan berlaku segera setelah dipublikasikan di halaman ini. Kami menyarankan Anda untuk meninjau halaman ini secara berkala.
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
            <h2 class="text-2xl md:text-3xl font-bold text-carbon-black tracking-tight mb-4">Masih Punya Pertanyaan?</h2>
            <p class="text-storm-gray mb-8">Tim kami siap membantu menjelaskan lebih detail mengenai layanan kami.</p>
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
