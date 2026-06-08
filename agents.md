# Agents.md — Manik Jaya Trans

> Instruksi wajib untuk semua AI Agent yang bekerja pada proyek ini.
> Baca file ini **sebelum** melakukan perubahan apapun.

---

## 1. Identitas Proyek

| Key              | Value                                                    |
|------------------|----------------------------------------------------------|
| Nama             | Sistem Informasi Travel Manik Jaya Trans                 |
| Jenis            | Monolithic Web Application                               |
| Framework        | Laravel 13, PHP 8.3+                                     |
| Admin Panel      | Filament 5.6.6                                           |
| Frontend         | Blade Template + Tailwind CSS v4.3 + Vite 8.0           |
| Database         | MySQL 5.7+ / 8.0+                                        |
| Payment Gateway  | Midtrans Sandbox 2.6                                     |
| Status           | In Development — Phase 1–8 selesai, Phase 9 ongoing      |
| Version          | 1.1.0                                                    |
| Last Update      | 8 Juni 2026                                              |

**🆕 Recent Updates (v1.1.0)**:
- ✅ Driver assignment by admin only (customer tidak pilih supir)
- ✅ Simplified booking card UI (summary only, bukan form interaktif)
- ✅ WhatsApp integration pada semua halaman detail layanan
- ✅ Email notification system 100% complete dan production ready
- 📄 Documentation updates across all project files
- 📝 Lihat `CHANGELOG_RECENT_UPDATES.md` untuk detail lengkap

---

## 2. Sumber Kebenaran (Source of Truth)

Semua keputusan teknis dan desain **WAJIB** mengacu pada dokumen di folder `docs/`. Urutan prioritas:

1. `docs/SRS.md` — Validasi, behavior, aturan status, security
2. `docs/SDD.md` — Arsitektur, database schema, route design, service layer
3. `docs/PRD.md` — Requirements produk, fitur, scope
4. `docs/UI_UX_Flow.md` — Alur UI/UX, wireframe, responsive rules
5. `docs/DESIGN.md` — Design system, token warna, tipografi, spacing
6. `docs/Task_Breakdown.md` — Breakdown 44 task dalam 10 phase

**Jika ada konflik antara dokumen, gunakan urutan prioritas di atas.**

---

## 3. Arsitektur & Pola

### 3.1 Arsitektur Aplikasi (MVC + Service Layer)

```
Request → Route → Controller → FormRequest (validasi) → Service (logic) → Model → Database
                                                                         ↓
                                                                        View (Blade)
```

### 3.2 Aturan Layer

| Layer           | Tanggung Jawab                                    | Dilarang                                        |
|-----------------|---------------------------------------------------|-------------------------------------------------|
| Route           | Definisi endpoint saja                            | Logic bisnis                                    |
| Controller      | Menerima request, memanggil service, return view  | Query DB langsung, kalkulasi harga              |
| FormRequest     | Validasi input                                    | Logic bisnis                                    |
| Service         | Logic bisnis kompleks (booking, payment, notif)   | Return view                                     |
| Model           | Relasi, scope, accessor, mutator                  | Logic bisnis berat                              |
| View (Blade)    | Tampilan saja                                     | Logic bisnis, query DB                          |

### 3.3 Struktur Folder Backend

```
app/
├── Filament/Resources/          # 11 Filament resource (admin CRUD)
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                # Login, Register, Logout
│   │   ├── Booking/             # RentalBooking, TourBooking, TransferBooking, ShuttleBooking
│   │   ├── Frontend/            # Home, Vehicle, TourPackage, AirportTransfer, HotelShuttle, Dashboard, BookingHistory, Payment
│   │   ├── Payment/             # PaymentController
│   │   └── Webhook/             # MidtransCallbackController
│   ├── Middleware/              # Role middleware
│   └── Requests/               # FormRequest classes
├── Mail/                        # BookingCreatedMail, BookingStatusUpdatedMail, PaymentSuccessMail
├── Models/                      # 11 Eloquent models
├── Observers/                   # Model observers
├── Providers/                   # Service providers
└── Services/                    # BookingCodeService, BookingService, PaymentService
```

### 3.3 Struktur Folder Frontend

```
resources/
├── css/app.css                  # Tailwind v4 + design tokens (@theme)
├── js/app.js                    # JavaScript entry point
└── views/
    ├── auth/                    # login, register
    ├── components/              # navbar, footer, primary-button, ghost-button, service-card, status-badge, section-heading, page-container, form-error
    ├── customer/                # dashboard
    ├── emails/                  # email templates (booking/created, payment/success, booking/status-updated)
    ├── frontend/                # home, vehicles/, tours/, transfers/, shuttles/, booking/
    └── layouts/                 # app (authenticated), guest
```

**Catatan Update Terbaru**:
- Semua halaman detail layanan (vehicles, tours, transfers, shuttles) memiliki WhatsApp help card
- Booking card di halaman detail hanya menampilkan summary info (bukan form interaktif)
- WhatsApp number: `6281234567890` (placeholder, perlu update untuk production)
- Email notification system 100% complete dengan 3 jenis email

---

## 4. Database

### 4.1 Tabel (11 tabel utama)

| Tabel               | Deskripsi                          | Status Field                                           |
|----------------------|------------------------------------|--------------------------------------------------------|
| `users`              | User (admin & customer)            | `role`: admin, customer                                |
| `vehicles`           | Kendaraan rental                   | `status`: available, maintenance, inactive             |
| `drivers`            | Driver                             | `status`: available, on_trip, inactive                 |
| `tour_packages`      | Paket wisata                       | `status`: active, inactive                             |
| `airport_transfers`  | Rute airport transfer              | `status`: active, inactive                             |
| `hotel_shuttles`     | Layanan hotel shuttle              | `status`: active, inactive                             |
| `rental_bookings`    | Booking sewa kendaraan             | `booking_status` + `payment_status`                    |
| `tour_bookings`      | Booking paket wisata               | `booking_status` + `payment_status`                    |
| `transfer_bookings`  | Booking airport transfer           | `booking_status` + `payment_status`                    |
| `shuttle_bookings`   | Booking hotel shuttle              | `booking_status` + `payment_status`                    |
| `payments`           | Payment records (polymorphic)      | `status`: pending, paid, failed, expired, refunded     |

### 4.2 Relasi Kunci

```
User        → hasMany → RentalBooking, TourBooking, TransferBooking, ShuttleBooking, Payment
Vehicle     → hasMany → RentalBooking
Driver      → hasMany → RentalBooking
TourPackage → hasMany → TourBooking
AirportTransfer → hasMany → TransferBooking
HotelShuttle    → hasMany → ShuttleBooking
*Booking    → morphOne → Payment (payable)
Payment     → morphTo  → payable (*Booking)
```

**Catatan Penting untuk Rental Booking:**
- Sewa kendaraan **include supir** (tidak ada opsi lepas kunci)
- Customer **tidak memilih supir** saat booking
- `driver_id` default `null` saat booking dibuat
- Admin menugaskan supir melalui Filament admin panel

### 4.3 Status Enum

**Booking Status** — transisi valid:
```
pending → approved → on_trip → completed
   ↓         ↓
canceled  canceled
```
- `completed` dan `canceled` adalah terminal state.

**Payment Status** — transisi valid:
```
unpaid → pending → paid → refunded
            ↓
         failed / expired  (bisa retry jika booking belum canceled)
```

### 4.4 Tipe Data Harga

Semua field harga menggunakan `decimal(12,2)`. Jangan gunakan float/double.

---

## 5. Booking Code Format

Dihasilkan oleh `BookingCodeService`:

```
RNT-YYYYMMDD-0001     # Rental
TOUR-YYYYMMDD-0001    # Tour
TRF-YYYYMMDD-0001     # Transfer
SHT-YYYYMMDD-0001     # Shuttle
```

- Auto-increment per hari per prefix.
- Harus unique, tidak boleh duplikat.

---

## 6. Perhitungan Harga

**WAJIB dihitung di BACKEND (service layer), BUKAN di frontend.**

| Jenis Booking     | Rumus                                          |
|-------------------|-------------------------------------------------|
| Rental (full_day) | `vehicle->price_full_day`                       |
| Rental (half_day) | `vehicle->price_half_day`                       |
| Tour              | `tour_package->price × participant_count`       |
| Transfer          | `airport_transfer->price`                       |
| Shuttle           | `hotel_shuttle->price × passenger_count`        |

---

## 7. Route Structure

### Public (Guest)
```
GET  /                              # Home
GET  /about                         # Tentang Kami
GET  /contact                       # Hubungi Kami & FAQ
GET  /terms                         # Syarat dan Ketentuan
GET  /privacy                       # Kebijakan Privasi
GET  /vehicles                      # List kendaraan
GET  /vehicles/{vehicle}            # Detail kendaraan
GET  /tours                         # List paket wisata
GET  /tours/{tour}                  # Detail paket wisata
GET  /transfers                     # List airport transfer
GET  /transfers/{transfer}          # Detail transfer
GET  /shuttles                      # List hotel shuttle
GET  /shuttles/{shuttle}            # Detail shuttle
GET  /login | POST /login
GET  /register | POST /register
```

### Customer (auth + role:customer)
```
POST /logout
GET  /customer/dashboard
GET  /customer/my-bookings
GET  /customer/my-bookings/{type}/{code}

GET|POST /booking/vehicles/{vehicle}
GET|POST /booking/tours/{tour}
GET|POST /booking/transfers/{transfer}
GET|POST /booking/shuttles/{shuttle}

POST /payment/{type}/{booking_code}
```

### Webhook
```
POST /payments/midtrans/callback    # Midtrans callback (tanpa CSRF)
```

### Admin (Filament)
```
/admin/*                            # Semua admin route dikelola Filament
```

---

## 8. Design System — ATURAN MUTLAK

### 8.1 Karakter Visual

- **Theme**: Light only.
- **Gaya**: High-contrast editorial canvas.
- **Palet**: Netral (hitam-putih-abu).

### 8.2 Token Warna

```css
--color-carbon-black: #222222    /* Text utama, button utama, border penting */
--color-canvas-white: #ffffff    /* Background utama */
--color-faint-gray:   #f7f7f7   /* Background section sekunder */
--color-storm-gray:   #6a6a6a   /* Text sekunder */
--color-pale-drift:   #ebebeb   /* Background halus, border lembut */
--color-dust-bunny:   #a6a6a6   /* Elemen minor */
--color-soft-divider: #dddddd   /* Divider, border */
```

### 8.3 Tailwind Custom Classes

```css
/* Colors */
text-carbon-black | bg-carbon-black
text-canvas-white | bg-canvas-white
text-storm-gray   | bg-faint-gray
border-soft-divider | bg-pale-drift

/* Typography */
font-airbnb-cereal-vf  →  system-ui, sans-serif (substitusi)

/* Spacing */
--spacing-8 sampai --spacing-96 (kelipatan 8px)

/* Border Radius */
rounded-md (4px) | rounded-lg (8px) | rounded-xl (12px)
```

### 8.4 Komponen

| Komponen       | Style                                                                    |
|----------------|--------------------------------------------------------------------------|
| Primary Button | bg `#222222`, text `#ffffff`, radius 8px, padding 16px 32px              |
| Ghost Button   | bg transparent, text `#222222`, radius 8px                               |
| Card           | radius 12px, border halus (`#ebebeb` atau `#dddddd`), **tanpa shadow**  |
| Section        | bg `#ffffff` atau `#f7f7f7`, gap 48-64px antar section                  |

### 8.5 LARANGAN DESAIN (Hard Rules)

> **Pelanggaran apapun di bawah ini dianggap sebagai BUG dan harus diperbaiki.**

- ❌ **JANGAN** gunakan gradient apapun
- ❌ **JANGAN** gunakan shadow berat (`shadow-lg`, `shadow-xl`, `shadow-2xl`)
- ❌ **JANGAN** gunakan warna biru sebagai primary/dominan
- ❌ **JANGAN** gunakan warna-warna cerah/vibrant sebagai elemen utama
- ❌ **JANGAN** gunakan carousel/slider
- ❌ **JANGAN** buat copywriting panjang / terlalu banyak teks
- ❌ **JANGAN** buat dashboard terlalu ramai / banyak widget
- ❌ **JANGAN** gunakan animasi kompleks
- ❌ **JANGAN** variasikan border-radius sembarangan (tetap 4/8/12px)
- ❌ **JANGAN** tampilkan error teknis (stack trace) ke user

---

## 9. Security Rules

1. **Password** wajib hash (bcrypt).
2. **CSRF** aktif pada semua form (kecuali Midtrans callback).
3. **Middleware `auth`** untuk semua halaman customer.
4. **Middleware role** untuk admin dan customer routes.
5. **Policy** untuk booking ownership — customer hanya bisa lihat booking miliknya.
6. **Upload gambar** harus divalidasi (jpg, jpeg, png, webp, maks 2MB).
7. **Midtrans keys** harus di `.env`, jangan hardcode.
8. **Midtrans callback** harus signature validation + idempotent.
9. Semua harga dihitung di **backend**.
10. Jangan tampilkan error teknis ke user biasa.

---

## 10. Email Notifications

| Email                    | Trigger                           | Recipient |
|--------------------------|-----------------------------------|-----------|
| BookingCreatedMail       | Booking berhasil dibuat           | Customer  |
| PaymentSuccessMail       | Payment status → paid             | Customer  |
| BookingStatusUpdatedMail | Admin mengubah booking status     | Customer  |

**Status**: ✅ 100% Complete dan Production Ready

**File terkait**:
- Mail classes: `app/Mail/`
- Email templates: `resources/views/emails/`
- Observer: `app/Observers/BookingObserver.php`
- Controllers yang trigger email: `RentalBookingController`, `TourBookingController`, `TransferBookingController`, `ShuttleBookingController`, `MidtransCallbackController`

**Konfigurasi**: Lihat `EMAIL_NOTIFICATION_SETUP.md` untuk panduan lengkap setup email (development dan production).

Konfigurasi email menggunakan Mailtrap/SMTP di `.env`.

---

## 11. Filament Admin Panel

### Resources (11 buah)

Users, Vehicles, Drivers, TourPackages, AirportTransfers, HotelShuttles, RentalBookings, TourBookings, TransferBookings, ShuttleBookings, Payments

### Dashboard Widgets

- Maksimal **4 widget** pada dashboard admin.
- Tidak boleh redundant.
- Fokus operasional: total booking, booking pending, payment paid, active services.
- **Tidak perlu grafik** pada versi awal.

---

## 12. Konvensi Kode

### Penamaan

| Tipe          | Konvensi                              | Contoh                          |
|---------------|---------------------------------------|---------------------------------|
| Controller    | PascalCase + `Controller`             | `RentalBookingController`       |
| Model         | PascalCase singular                   | `RentalBooking`                 |
| Table         | snake_case plural                     | `rental_bookings`               |
| Variable      | camelCase                             | `$totalPrice`                   |
| Constant      | UPPER_SNAKE_CASE                      | `BOOKING_STATUS_PENDING`        |
| View          | kebab-case                            | `booking-detail.blade.php`      |
| Route name    | dot notation                          | `booking.vehicle.store`         |
| Migration     | Laravel default timestamp             | `2026_05_29_000006_create_...`  |
| FormRequest   | `Store` / `Update` + Model + Request  | `StoreRentalBookingRequest`     |
| Service       | PascalCase + `Service`                | `BookingCodeService`            |
| Mail          | PascalCase + `Mail`                   | `BookingCreatedMail`            |

### Commit Message

```
feat: Add vehicle booking feature
fix: Fix payment callback validation
docs: Update README
style: Format code with Pint
refactor: Refactor booking service
test: Add booking validation tests
chore: Update dependencies
```

---

## 13. Development Commands

```bash
# Fresh install
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev

# Start dev
composer dev              # atau: php artisan serve + npm run dev

# Akses
# Frontend : http://localhost:8000
# Admin    : http://localhost:8000/admin
# Login    : admin@manikjaya.test / password

# Utilitas
php artisan optimize:clear       # Clear semua cache
php artisan storage:link         # Link storage ke public
./vendor/bin/pint                # Code formatting
php artisan migrate:fresh --seed # Reset database
```

---

## 14. Scope — Yang BOLEH dan TIDAK

### ✅ In Scope

- Website frontend customer (home, list, detail, booking, dashboard, riwayat, payment)
- Auth customer (register, login, logout)
- Role admin/customer
- Admin panel Filament (CRUD semua data master + booking + payment)
- Booking 4 layanan (kendaraan, paket wisata, airport transfer, hotel shuttle)
- Payment Midtrans Sandbox
- Email notifikasi dasar
- Seeder data awal
- UI sesuai DESIGN.md

### ❌ Out of Scope

Mobile app, push notification, SMS gateway, live chat, review pelanggan, kupon diskon, refund otomatis, tracking real-time, multi bahasa, akuntansi, payroll driver, integrasi kalender.

---

## 15. Checklist Sebelum Commit

Sebelum menganggap pekerjaan selesai, pastikan:

- [ ] `php artisan migrate:fresh --seed` berhasil tanpa error
- [ ] `npm run dev` berhasil tanpa error
- [ ] `php artisan serve` berhasil
- [ ] UI mengikuti DESIGN.md (tanpa gradient, tanpa shadow berat, tanpa warna biru)
- [ ] Semua harga dihitung di backend
- [ ] Customer hanya bisa lihat booking miliknya
- [ ] Form memakai CSRF
- [ ] Validasi menggunakan FormRequest
- [ ] Responsive pada desktop, tablet, mobile
- [ ] Tidak ada error teknis yang tampil ke user
- [ ] File yang diubah sudah di-format dengan Pint

---

## 16. Hal Penting untuk Agent

### Saat Mengerjakan Frontend

1. Selalu gunakan Blade components yang sudah ada (`x-navbar`, `x-footer`, `x-primary-button`, dll).
2. Gunakan layout `app` untuk halaman authenticated, `guest` untuk halaman public.
3. Pastikan design tokens dari `resources/css/app.css` digunakan.
4. Card selalu `rounded-xl` (12px), button selalu `rounded-lg` (8px).
5. Section gap harus 48-64px (`py-12` sampai `py-16`).
6. Tidak boleh ada warna di luar palet design token.
7. **UPDATE**: Booking card pada halaman detail layanan hanya menampilkan summary info (bukan form interaktif).
8. **UPDATE**: Semua halaman detail layanan harus memiliki WhatsApp help card untuk kontak customer service.

### Saat Mengerjakan Backend

1. Semua logic booking dan payment ada di Service layer.
2. Validasi input menggunakan FormRequest — jangan validasi di Controller.
3. Booking code dihasilkan oleh `BookingCodeService` — jangan generate manual.
4. Status transisi harus mengikuti aturan di section 4.3.
5. Payment menggunakan polymorphic relation (`payable_type` + `payable_id`).
6. Jangan buat route untuk endpoint yang sudah ditangani Filament.
7. **PENTING**: Untuk rental booking, customer tidak memilih supir. Field `driver_id` diset `null` dan akan ditugaskan oleh admin via Filament.
8. **PENTING**: Form booking kendaraan TIDAK menampilkan field pemilihan supir sama sekali.
9. **UPDATE**: Email notification system sudah 100% complete. Lihat `EMAIL_NOTIFICATION_SETUP.md` untuk dokumentasi lengkap.

### Saat Mengerjakan Admin Panel

1. Filament resource sudah ada untuk semua 11 model.
2. Dashboard widget maksimal 4 — jangan tambah tanpa izin.
3. Admin tidak boleh mengubah `total_price` booking tanpa alasan teknis.
4. Jangan hapus data master yang sudah terkait booking.
5. **UPDATE**: Admin menugaskan supir melalui field `driver_id` pada rental booking setelah booking diapprove.

### Saat Menambah Fitur Baru

1. Baca **semua** dokumen di `docs/` terlebih dahulu.
2. Pastikan fitur tersebut **in scope** (lihat section 14).
3. Ikuti arsitektur yang sudah ada — jangan buat pola baru.
4. Buat migration, model, controller, request, service, view sesuai konvensi.
5. Update seeder jika perlu.
6. Test manual sebelum commit.
7. **UPDATE**: Jika menambahkan halaman detail layanan baru, pastikan ada WhatsApp help card.

---

## 17. File Penting — Quick Reference

| Kategori     | File / Path                                          |
|--------------|------------------------------------------------------|
| Routes       | `routes/web.php`                                     |
| CSS Tokens   | `resources/css/app.css`                              |
| Main Layout  | `resources/views/layouts/app.blade.php`              |
| Guest Layout | `resources/views/layouts/guest.blade.php`            |
| Home Page    | `resources/views/frontend/home.blade.php`            |
| Dashboard    | `resources/views/customer/dashboard.blade.php`       |
| Services     | `app/Services/BookingCodeService.php`                |
|              | `app/Services/BookingService.php`                    |
|              | `app/Services/PaymentService.php`                    |
| Models       | `app/Models/*.php` (11 model)                        |
| Migrations   | `database/migrations/*.php` (13 migration)           |
| Seeders      | `database/seeders/*.php` (7 seeder)                  |
| Filament     | `app/Filament/Resources/` (11 resource)              |
| Mail         | `app/Mail/*.php` (3 mail class)                      |
| Middleware   | `app/Http/Middleware/`                                |
| Requests     | `app/Http/Requests/*.php` (6 form request)           |
| Config       | `.env`, `config/midtrans.php`, `config/mail.php`     |
| Docs         | `docs/*.md` (6 dokumen)                              |
