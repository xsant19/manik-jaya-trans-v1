# PRODUCT REQUIREMENT DOCUMENT V3
# Sistem Informasi Travel Manik Jaya Trans

## 1. Ringkasan Produk

Sistem Informasi Travel Manik Jaya Trans adalah aplikasi berbasis website untuk mengelola layanan travel, paket wisata, penyewaan kendaraan, airport transfer, hotel shuttle, booking pelanggan, pembayaran, notifikasi email, serta pengelolaan data operasional oleh admin.

Aplikasi ini dibangun menggunakan Laravel 13 sebagai backend framework, Filament 5.6.6 sebagai admin panel, Tailwind CSS v4.3 sebagai frontend styling, Blade Template sebagai view engine, dan MySQL sebagai database utama.

Sistem dirancang untuk menggantikan proses manual seperti pencatatan menggunakan buku, spreadsheet, WhatsApp, telepon, media sosial, serta konfirmasi manual. Sistem juga dirancang agar customer dapat melihat layanan dan melakukan booking secara mandiri melalui website.

## 2. Acuan Desain

## Standar Desain Wajib Berdasarkan DESIGN.md

Seluruh desain website harus mengikuti `DESIGN.md` sebagai acuan utama.

Karakter visual:
- Theme: light.
- Gaya: high-contrast editorial canvas.
- Tampilan: bersih, langsung, editorial, dan fungsional.
- Palet utama: netral, bukan warna biru.
- Hindari gradient, shadow kompleks, animasi berlebihan, dan elemen dekoratif yang tidak perlu.
- Prioritaskan whitespace besar dan hierarki tipografi yang kuat.

Token warna:
- Carbon Black: `#222222` untuk teks utama, button utama, border penting.
- Canvas White: `#ffffff` untuk background utama.
- Faint Gray: `#f7f7f7` untuk background section sekunder.
- Storm Gray: `#6a6a6a` untuk teks sekunder.
- Pale Drift: `#ebebeb` untuk background halus dan border lembut.
- Dust Bunny: `#a6a6a6` untuk elemen minor.
- Soft Divider: `#dddddd` untuk divider dan border.

Tipografi:
- Gunakan `system-ui, sans-serif` sebagai substitusi Airbnb Cereal VF.
- Heading memakai weight 700.
- Body memakai weight 400.
- Label atau navigasi memakai weight 500.
- Heading besar boleh 48px sampai 72px di desktop.
- Body text ideal 16px sampai 18px.
- Line-height longgar agar mudah dibaca.

Spacing:
- Base spacing 8px.
- Section gap 48px sampai 64px.
- Card padding 24px.
- Element gap 8px sampai 16px.
- Layout harus lega dan tidak padat.

Radius:
- Link radius 4px.
- Button radius 8px.
- Card radius 12px.

Komponen:
- Primary button memakai background `#222222`, text `#ffffff`, radius 8px, padding 16px 32px.
- Ghost button memakai background transparent, text `#222222`, radius 8px.
- Card memakai radius 12px, border halus, dan tanpa shadow berat.
- Section memakai background `#ffffff` atau `#f7f7f7`.


## 3. Goals

Tujuan utama aplikasi:

1. Menyediakan sistem booking travel yang terpusat.
2. Mempermudah customer melihat layanan Manik Jaya Trans.
3. Mempermudah customer melakukan booking paket wisata, kendaraan, airport transfer, dan hotel shuttle.
4. Mempermudah customer melihat status booking dan status pembayaran.
5. Membantu admin mengelola data kendaraan, driver, paket wisata, airport transfer, hotel shuttle, booking, dan pembayaran.
6. Mengurangi risiko kesalahan pencatatan manual.
7. Mengurangi risiko duplikasi booking.
8. Mempercepat konfirmasi booking.
9. Membangun sistem dengan struktur Laravel MVC yang rapi.
10. Menghasilkan UI website yang clean, high contrast, responsif, dan sesuai `DESIGN.md`.

## 4. Aplikasi Apa

Aplikasi ini adalah sistem informasi travel berbasis website untuk Manik Jaya Trans.

Jenis aplikasi:
- Website informasi layanan travel.
- Katalog layanan travel.
- Sistem booking online.
- Dashboard customer.
- Admin panel internal.
- Sistem pencatatan pembayaran.
- Sistem notifikasi email dasar.

## 5. Target User

### 5.1 Guest

Guest adalah pengguna yang belum login.

Kebutuhan guest:
- Melihat halaman home.
- Melihat daftar layanan.
- Melihat detail layanan.
- Melihat harga.
- Register.
- Login.
- Memulai proses booking.

Batasan guest:
- Tidak dapat melakukan booking.
- Tidak dapat melihat riwayat booking.
- Tidak dapat melakukan pembayaran.
- Tidak dapat mengakses dashboard customer.
- Tidak dapat mengakses admin panel.

### 2.2 Customer

Customer adalah pengguna yang sudah login dengan role customer.

Kebutuhan customer:
- Melihat layanan.
- Booking paket wisata.
- Booking kendaraan (include supir).
- Booking airport transfer.
- Booking hotel shuttle.
- Melihat riwayat booking.
- Melihat detail booking.
- Melihat status booking.
- Melihat status pembayaran.
- Melakukan pembayaran.
- Menerima email notifikasi.
- Kontak customer service via WhatsApp dari halaman detail layanan.

Batasan customer:
- Tidak dapat mengakses Filament admin panel.
- Tidak dapat mengubah data master.
- Tidak dapat melihat booking milik customer lain.
- Tidak dapat mengubah status booking secara manual.
- Tidak dapat mengubah harga booking.
- Tidak dapat memilih supir (supir ditugaskan oleh admin).
- Form booking kendaraan TIDAK menampilkan pilihan supir.

### 5.3 Admin

Admin adalah pengguna internal Manik Jaya Trans.

Kebutuhan admin:
- Login ke Filament admin panel.
- Mengelola data user.
- Mengelola data kendaraan.
- Mengelola data driver.
- Mengelola data paket wisata.
- Mengelola data airport transfer.
- Mengelola data hotel shuttle.
- Mengelola booking.
- Mengubah status booking.
- Menugaskan supir ke booking kendaraan.
- Mengelola pembayaran.
- Melihat dashboard ringkas.

Batasan admin:
- Admin tidak perlu melakukan booking melalui frontend customer.
- Admin panel tidak boleh terlalu banyak widget.
- Admin panel harus fokus pada pengelolaan data.

## 6. Fitur Utama

### 6.1 Fitur Guest

1. Melihat halaman home.
2. Melihat daftar paket wisata.
3. Melihat detail paket wisata.
4. Melihat daftar kendaraan.
5. Melihat detail kendaraan.
6. Melihat daftar airport transfer.
7. Melihat detail airport transfer.
8. Melihat daftar hotel shuttle.
9. Melihat detail hotel shuttle.
10. Register.
11. Login.

### 6.2 Fitur Customer

1. Register.
2. Login.
3. Logout.
4. Melihat dashboard customer.
5. Melihat layanan aktif.
6. Booking kendaraan.
7. Booking paket wisata.
8. Booking airport transfer.
9. Booking hotel shuttle.
10. Melihat riwayat booking.
11. Melihat detail booking.
12. Melihat status booking.
13. Melihat status pembayaran.
14. Membuat payment.
15. Melanjutkan pembayaran.
16. Menerima email booking.
17. Menerima email pembayaran berhasil.
18. Menerima email perubahan status booking.
19. Mengunduh Invoice PDF untuk transaksi yang sudah lunas.
20. Mengunduh Voucher Perjalanan PDF untuk layanan sewa kendaraan (jika sudah approved & lunas).

### 6.3 Fitur Admin

1. Login admin panel.
2. Dashboard ringkas.
3. CRUD user.
4. CRUD kendaraan.
5. CRUD driver.
6. CRUD paket wisata.
7. CRUD airport transfer.
8. CRUD hotel shuttle.
9. Kelola rental booking.
10. Kelola tour booking.
11. Kelola transfer booking.
12. Kelola shuttle booking.
13. Kelola payment.
14. Ubah booking status.
15. Menugaskan supir ke booking kendaraan.
16. Ubah payment status jika diperlukan.
17. Filter data berdasarkan status.
18. Search berdasarkan booking code.
19. Melihat data customer pada booking.
20. Mengunduh Laporan Keuangan (PDF & Excel) dengan rentang tanggal khusus.
21. Mengunduh cetak Surat Perintah Kerja (SPK) PDF untuk pengugasan supir.

## 7. User Flow Ringkas

### 7.1 Flow Guest ke Booking

1. Guest membuka website.
2. Guest melihat halaman home.
3. Guest memilih layanan.
4. Guest membuka detail layanan.
5. Guest klik tombol booking.
6. Sistem mengecek status login.
7. Jika belum login, sistem mengarahkan ke login.
8. Setelah login, customer diarahkan ke form booking.

### 7.2 Flow Booking Customer

1. Customer login.
2. Customer memilih layanan.
3. Customer membuka detail layanan.
4. Customer mengisi form booking.
5. Sistem validasi data.
6. Sistem menghitung total harga di backend.
7. Sistem membuat booking code.
8. Sistem menyimpan booking dengan status pending dan unpaid.
9. Untuk booking kendaraan, driver_id diset null (akan ditugaskan admin).
10. Sistem mengarahkan customer ke detail booking.
11. Customer dapat lanjut ke pembayaran.

### 7.3 Flow Admin Mengelola Booking

1. Admin login ke Filament.
2. Admin membuka menu booking.
3. Admin melihat daftar booking.
4. Admin filter booking berdasarkan status.
5. Admin membuka detail booking.
6. Admin mengubah status booking.
7. Admin menugaskan supir untuk booking kendaraan (jika belum ada).
8. Sistem menyimpan perubahan.
9. Customer dapat melihat status terbaru.

### 7.4 Flow Payment

1. Customer membuka detail booking.
2. Customer klik tombol bayar.
3. Sistem membuat payment record.
4. Sistem membuat transaksi Midtrans.
5. Customer diarahkan ke Midtrans Sandbox.
6. Customer menyelesaikan pembayaran.
7. Midtrans mengirim callback.
8. Sistem memvalidasi callback.
9. Sistem update payment status.
10. Sistem update booking payment status.

## 8. UI/UX Requirement

### 8.1 Prinsip Desain

UI wajib mengikuti `DESIGN.md`.

Prinsip:
- Clean.
- High contrast.
- Editorial.
- Minimal.
- Responsif.
- Tidak ramai.
- Tidak memakai warna biru dominan.
- Tidak memakai gradient.
- Tidak memakai shadow berat.
- Tidak banyak copywriting.
- Tidak banyak widget.

### 8.2 Struktur Halaman

Halaman utama:
1. Home.
2. Paket Wisata.
3. Detail Paket Wisata.
4. Sewa Kendaraan.
5. Detail Kendaraan.
6. Airport Transfer.
7. Detail Airport Transfer.
8. Hotel Shuttle.
9. Detail Hotel Shuttle.
10. Login.
11. Register.
12. Dashboard Customer.
13. Riwayat Booking.
14. Detail Booking.
15. Payment Page.

### 8.3 Home Page

Komponen:
- Navbar minimal.
- Hero editorial dengan heading besar.
- Deskripsi singkat.
- CTA utama.
- Ringkasan empat layanan.
- Featured vehicles.
- Featured tour packages.
- CTA sederhana.
- Footer minimal.

Aturan desain:
- Background utama putih.
- Heading Carbon Black.
- Body Storm Gray.
- CTA hitam.
- Section gap 48-64px.
- Tidak memakai carousel.
- Tidak memakai hero yang terlalu ramai.

### 8.4 Card Layanan

Card menampilkan:
- Gambar opsional.
- Nama layanan.
- Informasi utama.
- Harga.
- Tombol detail.

Aturan desain:
- Radius 12px.
- Border halus.
- Padding 24px.
- Tanpa shadow berat.
- Tidak terlalu banyak teks.

Catatan:
- Pada halaman detail layanan, booking card menampilkan summary info (bukan form interaktif).
- Desain card booking konsisten di semua jenis layanan (vehicle, tour, transfer, shuttle).
- CTA tombol booking mengarah langsung ke form booking (bukan di dalam card).

### 8.5 Form Booking

Form menampilkan:
- Input utama sesuai jenis booking.
- Ringkasan layanan.
- Total harga.
- Tombol submit.
- WhatsApp help card untuk kontak customer service.

Aturan desain:
- Desktop dua kolom.
- Mobile satu kolom.
- Error dekat field.
- Tombol utama hitam.
- Summary memakai background Faint Gray atau border Soft Divider.

Catatan Penting untuk Booking Kendaraan:
- Form booking kendaraan TIDAK memiliki field pemilihan supir.
- Customer hanya mengisi: rental_type, start_date, end_date, pickup_location, note.
- Supir akan ditugaskan oleh admin setelah booking diapprove.

## 9. Database Overview

Tabel utama:
1. users
2. vehicles
3. drivers
4. tour_packages
5. airport_transfers
6. hotel_shuttles
7. rental_bookings
8. tour_bookings
9. transfer_bookings
10. shuttle_bookings
11. payments

Relasi utama:
- User memiliki banyak booking.
- Vehicle memiliki banyak rental booking.
- Driver memiliki banyak rental booking.
- TourPackage memiliki banyak tour booking.
- AirportTransfer memiliki banyak transfer booking.
- HotelShuttle memiliki banyak shuttle booking.
- Payment menggunakan polymorphic relation ke semua jenis booking.

## 10. Technical Requirement

Backend:
- Laravel 13.
- PHP 8.3+.
- MVC.
- Eloquent ORM.
- Form Request validation.
- Service layer untuk booking dan payment.
- Policy untuk ownership booking.

Frontend:
- Tailwind CSS v4.3.
- Vite 8.0.
- Blade Template.
- Design token dari `DESIGN.md`.

Admin:
- Filament 4.
- Resource per model.
- Dashboard maksimal 4 widget utama.

Database:
- MySQL.
- Migration.
- Seeder.
- Index untuk field penting.

Payment:
- Midtrans Sandbox.
- Callback validation.
- Payment status sync.

Email:
- Laravel Mail.
- Mailtrap atau SMTP untuk testing.

## 11. Scope Project

### 11.1 In Scope

1. Website frontend customer.
2. Auth customer.
3. Role admin/customer.
4. Admin panel Filament.
5. CRUD kendaraan.
6. CRUD driver.
7. CRUD paket wisata.
8. CRUD airport transfer.
9. CRUD hotel shuttle.
10. Booking kendaraan.
11. Booking paket wisata.
12. Booking airport transfer.
13. Booking hotel shuttle.
14. Riwayat booking customer.
15. Detail booking customer.
16. Payment basic.
17. Midtrans Sandbox.
18. Email notifikasi dasar.
19. Seeder data awal.
20. UI sesuai `DESIGN.md`.

### 11.2 Out of Scope

1. Mobile app.
2. Push notification.
3. SMS gateway.
4. Live chat.
5. Review pelanggan.
6. Kupon diskon.
7. Refund otomatis.
8. Tracking kendaraan real-time.
9. Multi bahasa.
10. Akuntansi lengkap.
11. Payroll driver.
12. Integrasi kalender eksternal.

## 12. Acceptance Criteria

Project dianggap sesuai PRD jika:
1. Customer dapat register dan login.
2. Customer dapat melihat layanan aktif.
3. Customer dapat melakukan booking.
4. Sistem membuat booking code unik.
5. Customer dapat melihat riwayat booking.
6. Customer hanya dapat melihat booking miliknya.
7. Admin dapat login ke Filament.
8. Admin dapat CRUD data master.
9. Admin dapat mengubah status booking.
10. Payment record dapat dibuat.
11. Midtrans Sandbox berjalan.
12. Email notifikasi dasar berjalan.
13. UI mengikuti `DESIGN.md`.
14. Tidak ada warna biru dominan.
15. Tidak ada gradient dekoratif.
16. Tidak ada shadow berat.
17. Dashboard admin tidak redundant.
18. Layout responsif.
