# SOFTWARE REQUIREMENT SPECIFICATION
# Sistem Informasi Travel Manik Jaya Trans

## 1. Pendahuluan

SRS ini menjelaskan kebutuhan perangkat lunak untuk Sistem Informasi Travel Manik Jaya Trans. Fokus SRS mencakup validasi, behavior sistem, aturan aplikasi, role pengguna, keamanan, status booking, status pembayaran, dan aturan UI berdasarkan `DESIGN.md`.

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


## 3. Role Pengguna

### 3.1 Guest

Guest dapat:
- Melihat home.
- Melihat list layanan.
- Melihat detail layanan.
- Login.
- Register.

Guest tidak dapat:
- Booking.
- Melihat dashboard.
- Melihat riwayat booking.
- Melakukan pembayaran.
- Mengakses admin panel.

### 3.2 Customer

Customer dapat:
- Login.
- Logout.
- Booking layanan.
- Melihat dashboard.
- Melihat riwayat booking.
- Melihat detail booking.
- Melakukan pembayaran.
- Menerima email notifikasi.

Customer tidak dapat:
- Mengakses Filament.
- Mengubah data master.
- Mengubah status booking.
- Melihat booking milik user lain.
- Mengubah total harga.
- Memilih supir (supir ditugaskan oleh admin).

### 3.3 Admin

Admin dapat:
- Login ke Filament.
- Mengelola data master.
- Mengelola booking.
- Mengelola pembayaran.
- Mengubah status booking.
- Menugaskan supir ke booking kendaraan.
- Melihat dashboard ringkas.

Admin tidak boleh:
- Melihat dashboard yang terlalu ramai.
- Mengubah total harga booking tanpa alasan teknis.
- Menghapus data master yang sudah dipakai booking secara paksa.

## 4. Modul Sistem

1. Authentication.
2. Role Authorization.
3. User Management.
4. Vehicle Management.
5. Driver Management.
6. Tour Package Management.
7. Airport Transfer Management.
8. Hotel Shuttle Management.
9. Rental Booking.
10. Tour Booking.
11. Transfer Booking.
12. Shuttle Booking.
13. Payment.
14. Midtrans Callback.
15. Email Notification.
16. Customer Dashboard.
17. Filament Admin Panel.
18. Design System.

## 5. Validasi Sistem

### 5.1 Validasi Register

Field:
- name
- email
- password
- password_confirmation
- phone

Aturan:
- name wajib.
- name minimal 3 karakter.
- email wajib.
- email harus valid.
- email harus unique.
- password wajib.
- password minimal 8 karakter.
- password_confirmation harus sama.
- phone opsional.
- phone hanya boleh angka, spasi, plus, dan strip.
- role otomatis customer.

Behavior:
- Jika validasi gagal, tampilkan error dekat field.
- Jika berhasil, user dibuat.
- Password disimpan dalam bentuk hash.
- User diarahkan ke dashboard atau login.

### 5.2 Validasi Login

Field:
- email
- password

Aturan:
- email wajib.
- email harus valid.
- password wajib.

Behavior:
- Jika gagal, tampilkan pesan sederhana.
- Jika customer, arahkan ke dashboard customer.
- Jika admin, arahkan ke admin panel.
- Session dibuat setelah login berhasil.

### 5.3 Validasi User Admin

Field:
- name
- email
- password
- role
- phone
- address

Aturan:
- name wajib.
- email wajib dan unique.
- role hanya admin atau customer.
- password wajib saat create.
- password boleh kosong saat edit.
- phone opsional.
- address opsional.

Behavior:
- Admin dapat membuat user.
- Customer tidak dapat membuat admin.
- Role admin hanya dapat dibuat oleh admin atau seeder.

### 5.4 Validasi Kendaraan

Field:
- name
- type
- capacity
- price_full_day
- price_half_day
- description
- image
- status

Aturan:
- name wajib.
- type wajib.
- capacity wajib angka minimal 1.
- price_full_day wajib angka minimal 0.
- price_half_day wajib angka minimal 0.
- description opsional.
- image opsional, format jpg, jpeg, png, webp.
- image maksimal 2 MB.
- status hanya available, maintenance, inactive.

Behavior:
- available tampil di frontend dan dapat dibooking.
- maintenance tampil di admin tetapi tidak dapat dibooking.
- inactive tidak tampil di frontend.
- Harga tidak boleh negatif.

### 5.5 Validasi Driver

Field:
- name
- phone
- license_number
- status

Aturan:
- name wajib.
- phone wajib.
- license_number opsional.
- status hanya available, on_trip, inactive.

Behavior:
- available dapat dipilih.
- on_trip tidak direkomendasikan.
- inactive tidak dapat dipilih.

### 5.6 Validasi Paket Wisata

Field:
- name
- description
- itinerary
- duration
- price
- image
- status

Aturan:
- name wajib.
- description wajib.
- itinerary opsional.
- duration wajib.
- price wajib angka minimal 0.
- image opsional, format jpg, jpeg, png, webp.
- status hanya active atau inactive.

Behavior:
- active tampil di frontend.
- inactive tidak tampil di frontend.
- Harga dipakai untuk total booking.

### 5.7 Validasi Airport Transfer

Field:
- route_name
- pickup_location
- dropoff_location
- price
- estimated_duration
- status

Aturan:
- route_name wajib.
- pickup_location wajib.
- dropoff_location wajib.
- price wajib angka minimal 0.
- estimated_duration opsional.
- status hanya active atau inactive.

Behavior:
- active tampil dan dapat dibooking.
- inactive tidak tampil di frontend.

### 5.8 Validasi Hotel Shuttle

Field:
- hotel_name
- pickup_location
- dropoff_location
- price
- schedule
- status

Aturan:
- hotel_name wajib.
- pickup_location wajib.
- dropoff_location wajib.
- price wajib angka minimal 0.
- schedule opsional.
- status hanya active atau inactive.

Behavior:
- active tampil dan dapat dibooking.
- inactive tidak tampil di frontend.

### 5.9 Validasi Booking Kendaraan

Field:
- vehicle_id
- rental_type
- start_date
- end_date
- pickup_location
- note

Aturan:
- vehicle_id wajib dan valid.
- kendaraan harus available.
- rental_type hanya full_day atau half_day.
- start_date wajib.
- start_date tidak boleh sebelum hari ini.
- end_date opsional.
- end_date tidak boleh sebelum start_date.
- pickup_location wajib.
- note maksimal 500 karakter.
- driver_id TIDAK DITAMPILKAN di form customer (otomatis null).

Behavior:
- total_price dihitung backend.
- full_day (12 jam sewa) memakai price_full_day.
- half_day (6 jam sewa) memakai price_half_day.
- booking_code dibuat otomatis.
- booking_status default pending.
- payment_status default unpaid.
- driver_id default null (supir akan ditugaskan oleh admin).
- Customer hanya melihat booking miliknya.
- Sewa kendaraan include supir yang akan ditugaskan via admin panel.
- Form booking customer TIDAK memiliki field pemilihan supir.
- Supir ditugaskan oleh admin melalui Filament admin panel setelah booking approved.

### 5.10 Validasi Booking Paket Wisata

Field:
- tour_package_id
- booking_date
- participant_count
- note

Aturan:
- tour_package_id wajib dan valid.
- paket harus active.
- booking_date wajib.
- booking_date tidak boleh sebelum hari ini.
- participant_count wajib angka minimal 1.
- note maksimal 500 karakter.

Behavior:
- total_price = price x participant_count.
- booking_code dibuat otomatis.
- booking_status pending.
- payment_status unpaid.

### 5.11 Validasi Booking Airport Transfer

Field:
- airport_transfer_id
- booking_date
- passenger_count
- flight_number
- pickup_time
- note

Aturan:
- airport_transfer_id wajib dan valid.
- rute harus active.
- booking_date wajib.
- booking_date tidak boleh sebelum hari ini.
- passenger_count wajib angka minimal 1.
- flight_number opsional.
- pickup_time opsional.
- note maksimal 500 karakter.

Behavior:
- total_price dari harga rute.
- booking_code dibuat otomatis.
- booking_status pending.
- payment_status unpaid.

### 5.12 Validasi Booking Hotel Shuttle

Field:
- hotel_shuttle_id
- booking_date
- passenger_count
- pickup_time
- note

Aturan:
- hotel_shuttle_id wajib dan valid.
- layanan harus active.
- booking_date wajib.
- booking_date tidak boleh sebelum hari ini.
- passenger_count wajib angka minimal 1.
- pickup_time opsional.
- note maksimal 500 karakter.

Behavior:
- total_price dari harga shuttle.
- booking_code dibuat otomatis.
- booking_status pending.
- payment_status unpaid.

### 5.13 Validasi Payment

Field:
- booking_type
- booking_code
- gross_amount
- payment_method
- transaction_id
- status

Aturan:
- booking_type wajib dan valid.
- booking_code wajib dan valid.
- booking harus milik customer login.
- booking canceled tidak boleh dibayar.
- booking paid tidak boleh dibayar ulang.
- gross_amount harus sama dengan total_price.
- status hanya pending, paid, failed, expired, refunded.
- satu booking hanya boleh memiliki satu payment aktif.

Behavior:
- Jika payment berhasil, payment_status booking menjadi paid.
- Jika payment gagal, payment_status menjadi failed.
- Jika expired, payment_status menjadi expired.
- Raw response disimpan dalam JSON.
- Callback harus idempotent.

## 6. Behavior Sistem

### 6.1 Behavior Umum

- Sistem memakai MVC.
- Route tidak menyimpan logic bisnis berat.
- Controller menerima request.
- Form Request melakukan validasi.
- Service mengatur logic booking dan payment.
- Model mengatur relasi data.
- View hanya untuk tampilan.
- Semua form memakai CSRF.
- Semua harga dihitung di backend.

### 6.2 Behavior Home

- Menampilkan hero editorial.
- Menampilkan ringkasan layanan.
- Menampilkan featured vehicles.
- Menampilkan featured packages.
- Menampilkan CTA sederhana.
- Copywriting singkat.
- Tidak memakai carousel.
- Tidak memakai widget berlebihan.

### 6.3 Behavior List Layanan

- Hanya data active atau available yang tampil.
- Data inactive tidak tampil.
- Gunakan pagination jika data banyak.
- Card menampilkan nama, harga, informasi inti, dan tombol detail.
- Tampilan card mengikuti `DESIGN.md`.

### 6.4 Behavior Detail Layanan

- Menampilkan informasi layanan.
- Menampilkan harga.
- Menampilkan ringkasan layanan pada booking card (tanpa form interaktif).
- Menampilkan tombol booking direct CTA.
- Menampilkan WhatsApp help card untuk kontak customer service.
- Jika guest klik booking, redirect ke login.
- Jika customer klik booking, masuk form booking.
- Card booking hanya menampilkan summary info, bukan form input (untuk konsistensi UI).

### 6.5 Behavior Dashboard Customer

- Menampilkan ringkasan booking.
- Menampilkan booking terbaru.
- Menampilkan status booking dan payment.
- Maksimal 3 kartu ringkasan utama.
- Tidak banyak widget.

### 6.6 Behavior Admin Panel

- Admin login melalui Filament.
- Dashboard maksimal 4 widget.
- Admin dapat CRUD data.
- Admin dapat filter dan search.
- Admin dapat ubah status booking.
- Admin dapat melihat payment.

## 7. Aturan Status

### 7.1 Booking Status

Status:
- pending
- approved
- on_trip
- completed
- canceled

Transisi:
- pending ke approved.
- pending ke canceled.
- approved ke on_trip.
- approved ke canceled.
- on_trip ke completed.
- completed tidak dapat diubah oleh customer.
- canceled tidak dapat dilanjutkan.

### 7.2 Payment Status

Status:
- unpaid
- pending
- paid
- failed
- expired
- refunded

Transisi:
- unpaid ke pending.
- pending ke paid.
- pending ke failed.
- pending ke expired.
- failed dapat mencoba ulang.
- expired dapat mencoba ulang jika booking belum canceled.
- paid dapat menjadi refunded oleh admin.

## 8. Aturan UI Berdasarkan DESIGN.md

- Background utama harus #ffffff.
- Section sekunder boleh #f7f7f7.
- Text utama #222222.
- Text sekunder #6a6a6a.
- Divider #dddddd.
- Border halus #ebebeb.
- Button utama #222222 dengan text #ffffff.
- Radius button 8px.
- Radius card 12px.
- Tidak boleh memakai gradient.
- Tidak boleh memakai shadow kompleks.
- Tidak boleh memakai warna biru sebagai primary.
- Tidak boleh membuat dashboard terlalu ramai.
- Tidak boleh membuat terlalu banyak copywriting.
- Card padding 24px.
- Section gap 48-64px.
- Layout harus responsif.
- Booking card pada detail layanan hanya menampilkan summary (bukan form interaktif).
- Setiap halaman detail layanan menyediakan WhatsApp help card untuk kontak customer service.
- WhatsApp number: placeholder `6281234567890` (perlu update untuk production).

## 9. Security Requirement

- Password wajib hash.
- Middleware auth untuk halaman customer.
- Middleware role untuk admin dan customer.
- Policy untuk booking ownership.
- CSRF aktif.
- Upload gambar divalidasi.
- Midtrans key di `.env`.
- Callback payment divalidasi.
- Jangan tampilkan error teknis ke user biasa.

## 10. Acceptance Criteria

1. Register valid.
2. Login valid.
3. Role berjalan.
4. Customer bisa booking semua layanan.
5. Customer hanya melihat booking miliknya.
6. Admin bisa CRUD data master.
7. Admin bisa update status booking.
8. Harga dihitung backend.
9. Payment tidak bisa dobel.
10. Midtrans callback aman.
11. UI mengikuti `DESIGN.md`.
12. Tidak ada warna biru dominan.
13. Tidak ada gradient.
14. Tidak ada shadow berat.
15. Layout mobile rapi.
