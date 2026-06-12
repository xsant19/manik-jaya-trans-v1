# UI/UX FLOW DOCUMENT V3
# Sistem Informasi Travel Manik Jaya Trans

## 1. Ringkasan UI/UX

Dokumen ini menjelaskan alur UI/UX lengkap untuk Sistem Informasi Travel Manik Jaya Trans. Seluruh desain harus mengikuti `DESIGN.md` dengan pendekatan high-contrast editorial canvas.

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


## 3. Tujuan UI/UX

1. Membuat customer cepat memahami layanan.
2. Membuat customer mudah booking.
3. Membuat customer mudah melihat status.
4. Membuat admin mudah mengelola data.
5. Menjaga tampilan clean dan tidak ramai.
6. Menjaga website tetap responsif.
7. Menyesuaikan seluruh visual dengan `DESIGN.md`.

## 4. Prinsip UI Final

- High contrast.
- Dominan putih dan hitam.
- Banyak whitespace.
- Heading kuat.
- Body text singkat.
- CTA jelas.
- Tidak memakai warna biru dominan.
- Tidak memakai gradient.
- Tidak memakai shadow berat.
- Tidak memakai carousel jika tidak perlu.
- Tidak banyak widget.
- Tidak banyak copywriting.

## 5. Sitemap

```text
/
├── Home
├── Paket Wisata
│   ├── List Paket Wisata
│   └── Detail Paket Wisata
│       └── Booking Paket Wisata
├── Sewa Kendaraan
│   ├── List Kendaraan
│   └── Detail Kendaraan
│       └── Booking Kendaraan
├── Airport Transfer
│   ├── List Airport Transfer
│   └── Detail Airport Transfer
│       └── Booking Airport Transfer
├── Hotel Shuttle
│   ├── List Hotel Shuttle
│   └── Detail Hotel Shuttle
│       └── Booking Hotel Shuttle
├── Login
├── Register
├── Dashboard Customer
│   ├── Riwayat Booking
│   ├── Detail Booking
│   └── Payment
└── Admin Panel Filament
```

## 6. Navbar Flow

### Guest Navbar

Menu:
- Home
- Paket Wisata
- Sewa Kendaraan
- Airport Transfer
- Hotel Shuttle
- Login
- Register

Style:
- Background #ffffff.
- Text #222222.
- Border bottom #dddddd.
- Ghost link.
- Register sebagai primary button.
- Tidak memakai shadow.

### Customer Navbar

Menu:
- Home
- Layanan
- Booking Saya
- Profil
- Logout

Style:
- Tetap minimal.
- Booking Saya mudah terlihat.
- Logout tidak terlalu dominan.

### Mobile Navbar

Behavior:
- Hamburger menu.
- Menu vertikal.
- Button full width.
- Spacing lega.

## 7. Flow Guest

### 7.1 Melihat Layanan

```text
Guest membuka website
↓
Melihat hero
↓
Melihat ringkasan layanan
↓
Memilih layanan
↓
Masuk halaman list
↓
Melihat card layanan
↓
Klik detail
↓
Melihat detail layanan
```

UX:
- Semua layanan utama terlihat dari home.
- Card layanan singkat.
- Harga terlihat.
- CTA detail jelas.

### 7.2 Guest Klik Booking

```text
Guest klik tombol Booking
↓
Sistem cek login
↓
Guest diarahkan ke Login
↓
Guest login
↓
Sistem arahkan ke form booking
```

UX:
- Pesan: Silakan login untuk melanjutkan booking.
- Jangan biarkan guest mengisi form booking sebelum login.

## 8. Flow Customer

### 8.1 Register

```text
Buka Register
↓
Isi nama, email, password, konfirmasi password, telepon
↓
Submit
↓
Validasi
↓
Akun dibuat
↓
Masuk dashboard atau login
```

UI:
- Form centered.
- Background putih.
- Input border #dddddd.
- Button hitam.
- Error merah sederhana.

### 8.2 Login

```text
Buka Login
↓
Isi email dan password
↓
Submit
↓
Validasi
↓
Masuk dashboard
```

UI:
- Form singkat.
- Link register.
- Pesan error sederhana.

### 8.3 Dashboard Customer

Komponen:
- Greeting singkat.
- Total booking.
- Booking pending.
- Booking paid.
- Booking terbaru.

Aturan:
- Maksimal 3 kartu ringkasan.
- Tidak banyak widget.
- Gunakan badge status.

## 9. Flow Booking Paket Wisata

```text
Customer membuka Paket Wisata
↓
Memilih paket
↓
Membuka detail
↓
Klik Booking
↓
Isi tanggal
↓
Isi jumlah peserta
↓
Isi catatan opsional
↓
Lihat total harga
↓
Submit
↓
Booking dibuat
↓
Masuk detail booking
```

Screen list:
- Header singkat.
- Grid card.
- Card radius 12px.
- Border halus.
- Tombol detail.

Screen detail:
- Gambar.
- Nama paket.
- Harga.
- Durasi.
- Deskripsi.
- Itinerary.
- Button booking.

Form:
- Tanggal.
- Jumlah peserta.
- Catatan.
- Ringkasan harga.

## 10. Flow Booking Kendaraan

```text
Customer membuka Sewa Kendaraan
↓
Memilih kendaraan
↓
Membuka detail
↓
Klik Booking
↓
Pilih full day (12 jam) atau half day (6 jam)
↓
Isi tanggal mulai
↓
Isi tanggal selesai jika perlu
↓
Isi lokasi jemput
↓
Isi catatan
↓
Lihat total harga
↓
Submit
↓
Booking dibuat
```

UX:
- **Full day**: Sewa 12 jam dengan harga price_full_day.
- **Half day**: Sewa 6 jam dengan harga price_half_day.
- Total harga harus terlihat sebelum submit.
- Kendaraan maintenance tidak bisa dibooking.
- Driver TIDAK dipilih customer (ditugaskan admin setelah approved).

## 11. Flow Booking Airport Transfer

```text
Customer membuka Airport Transfer
↓
Memilih rute
↓
Membuka detail
↓
Klik Booking
↓
Isi tanggal
↓
Isi jumlah penumpang
↓
Isi nomor penerbangan opsional
↓
Isi waktu pickup opsional
↓
Submit
↓
Booking dibuat
```

UX:
- Informasi pickup dan dropoff harus jelas.
- Harga tampil jelas.
- Form tetap singkat.

## 12. Flow Booking Hotel Shuttle

```text
Customer membuka Hotel Shuttle
↓
Memilih layanan
↓
Membuka detail
↓
Klik Booking
↓
Isi tanggal
↓
Isi jumlah penumpang
↓
Isi waktu pickup
↓
Submit
↓
Booking dibuat
```

UX:
- Nama hotel jelas.
- Jadwal terlihat jika ada.
- Harga terlihat sebelum submit.

## 13. Flow Payment

```text
Customer membuka detail booking
↓
Status unpaid terlihat
↓
Klik Bayar
↓
Sistem membuat payment
↓
Customer diarahkan ke Midtrans
↓
Customer membayar
↓
Callback diterima
↓
Status menjadi paid
```

UI:
- Button Bayar hanya muncul jika unpaid.
- Booking canceled tidak menampilkan button bayar.
- Booking paid menampilkan badge Lunas.

## 14. Flow Riwayat Booking

```text
Customer membuka Booking Saya
↓
Melihat semua booking
↓
Filter berdasarkan jenis atau status
↓
Klik detail
↓
Melihat status dan pembayaran
```

Desktop:
- Tabel.

Mobile:
- Card.

Badge:
- Status booking.
- Status payment.

## 15. Flow Admin

### 15.1 Login Admin

```text
Admin membuka /admin
↓
Login
↓
Validasi role
↓
Masuk dashboard
```

### 15.2 Dashboard Admin

Widget maksimal:
1. Total booking.
2. Booking pending.
3. Payment paid.
4. Active services.

Aturan:
- Tidak perlu grafik.
- Tidak redundant.
- Fokus operasional.

### 15.3 Kelola Data Master & Booking (UI Admin)

UI Admin menggunakan skema **Single Column Layout**:
- Form panjang/banyak tidak dibagi menjadi sidebar terpisah.
- Tampilan satu kolom penuh (`columnSpanFull` pada section/schema utama).
- Sebelum data disimpan (Create/Edit), terdapat modal konfirmasi ("Apakah Anda yakin...?").

```text
Admin buka resource
↓
Lihat list data
↓
Create/Edit/Delete
↓
Modal Konfirmasi
↓
Simpan
↓
Data terupdate (dan tampil di frontend jika active/tidak hidden)
```

### 15.4 Kelola Booking

```text
Admin buka booking resource
↓
Filter status
↓
Search booking code
↓
Buka detail
↓
Ubah status
↓
Simpan
```

## 16. Status Badge

Booking:
- pending: Menunggu.
- approved: Disetujui.
- on_trip: Dalam Perjalanan.
- completed: Selesai.
- canceled: Dibatalkan.

Payment:
- unpaid: Belum Dibayar.
- pending: Menunggu Pembayaran.
- paid: Lunas.
- failed: Gagal.
- expired: Kedaluwarsa.
- refunded: Refund.

Warna badge boleh semantik, tetapi tidak boleh mendominasi palet netral.

## 17. Wireframe Home

```text
[Navbar minimal]

[Hero Editorial]
Large Heading
Short body text
Primary CTA

[Services Section]
4 cards

[Featured Vehicles]
3 cards

[Featured Tour Packages]
3 cards

[Simple CTA]

[Footer]
```

## 18. Wireframe Form Booking

```text
[Navbar]

[Page Header]

[Two Column Layout]
Left: Form
Right: Order Summary

[Submit Button]

[Footer]
```

## 19. Empty State

Tidak ada layanan:
```text
Belum ada layanan tersedia.
```

Belum ada booking:
```text
Belum ada booking.
```

Payment belum tersedia:
```text
Pembayaran belum tersedia untuk booking ini.
```

## 20. Error State

- Error validasi tampil dekat field.
- Input tidak hilang.
- Pesan error sederhana.
- Jangan tampilkan stack trace ke user.

## 21. Loading State

Digunakan saat:
- Login.
- Register.
- Submit booking.
- Membuat payment.

Label:
```text
Memproses...
```

Tombol disabled sementara untuk mencegah submit ganda.

## 22. Responsive Rules

Desktop:
- Max-width contained.
- Grid 3 kolom.
- Form 2 kolom.
- Heading besar.

Tablet:
- Grid 2 kolom.
- Heading turun ukuran.

Mobile:
- Grid 1 kolom.
- Button full width.
- Form 1 kolom.
- Table berubah menjadi card.
- Heading 32-40px.

## 23. Acceptance Criteria UI/UX

1. Guest dapat melihat layanan.
2. Guest diarahkan login saat booking.
3. Customer dapat booking dengan alur jelas.
4. Customer dapat melihat status.
5. Admin dapat mengelola data.
6. Layout responsif.
7. UI mengikuti `DESIGN.md`.
8. Tidak ada warna biru dominan.
9. Tidak ada gradient.
10. Tidak ada shadow berat.
11. Card radius 12px.
12. Button radius 8px.
13. Section gap lega.
14. Copywriting ringkas.
15. Dashboard admin tidak redundant.
