# Sistem Informasi Travel Manik Jaya Trans

> **File ini adalah konteks wajib untuk Gemini AI.**
> Baca `agents.md` sebagai instruksi utama sebelum melakukan perubahan apapun.

---

## 📋 Overview

Sistem Informasi Travel Manik Jaya Trans adalah aplikasi web berbasis Laravel untuk mengelola layanan travel, paket wisata, penyewaan kendaraan, airport transfer, hotel shuttle, booking pelanggan, pembayaran, dan notifikasi email.

**Status Proyek**: 🚧 Dalam Pengembangan — Phase 1–8 selesai, Phase 9–10 pending

**Tech Stack**:
- Laravel 13, PHP 8.3+
- Filament 4 (Admin Panel)
- Tailwind CSS v4 + Vite
- MySQL
- Blade Template
- Midtrans Sandbox (Payment Gateway)

---

## 📚 Dokumentasi Utama

Proyek ini memiliki dokumentasi lengkap di folder `docs/`. **Urutan prioritas**:

1. `docs/SRS.md` — Validasi, behavior, aturan status, security
2. `docs/SDD.md` — Arsitektur, database schema, route design, service layer
3. `docs/PRD.md` — Requirements produk, fitur, scope
4. `docs/UI_UX_Flow.md` — Alur UI/UX, wireframe, responsive rules
5. `docs/DESIGN.md` — Design system, token warna, tipografi, spacing
6. `docs/Task_Breakdown.md` — Breakdown 44 task dalam 10 phase

**⚠️ PENTING**: Jika ada konflik antara dokumen, gunakan urutan prioritas di atas.

---

## 🎨 Design System

### Prinsip Desain
- **Theme**: Light only
- **Style**: High-contrast editorial canvas (terinspirasi Airbnb)
- **Palet**: Netral (hitam-putih-abu) — **BUKAN warna biru**

### Token Warna
```css
--color-carbon-black: #222222    /* Text utama, button utama, border penting */
--color-canvas-white: #ffffff    /* Background utama */
--color-faint-gray:   #f7f7f7   /* Background section sekunder */
--color-storm-gray:   #6a6a6a   /* Text sekunder */
--color-pale-drift:   #ebebeb   /* Background halus, border lembut */
--color-dust-bunny:   #a6a6a6   /* Elemen minor */
--color-soft-divider: #dddddd   /* Divider, border */
```

### Typography
- **Font**: `system-ui, sans-serif` (substitusi Airbnb Cereal VF)
- **Heading**: weight 700, size 48-72px (desktop)
- **Body**: weight 400, size 16-18px
- **Label/Nav**: weight 500

### Spacing & Radius
- **Base spacing**: 8px
- **Section gap**: 48-64px
- **Card padding**: 24px
- **Button radius**: 8px | **Card radius**: 12px | **Link radius**: 4px

### LARANGAN DESAIN (Hard Rules)

> **Pelanggaran apapun dianggap BUG.**

- ❌ Gradient apapun
- ❌ Shadow berat (`shadow-lg`, `shadow-xl`, `shadow-2xl`)
- ❌ Warna biru sebagai primary/dominan
- ❌ Warna cerah/vibrant sebagai elemen utama
- ❌ Carousel/slider
- ❌ Copywriting panjang
- ❌ Dashboard ramai / banyak widget
- ❌ Animasi kompleks
- ❌ Border-radius tidak standar (harus 4/8/12px)
- ❌ Error teknis (stack trace) ke user

---

## 👥 User Roles

### Guest
- Melihat home, list & detail layanan, register, login
- **Tidak bisa**: booking, dashboard, riwayat, payment, admin panel

### Customer
- Login/logout, booking semua layanan, dashboard, riwayat, detail booking, payment, email notifikasi
- **Tidak bisa**: akses Filament, ubah data master, ubah status booking, lihat booking user lain, ubah harga

### Admin
- Login Filament, CRUD data master, kelola booking & payment, ubah status booking, dashboard ringkas
- **Tidak boleh**: dashboard ramai, ubah total harga tanpa alasan, hapus data master yang sudah dipakai booking

---

## 🗄️ Database Schema

### 11 Tabel Utama

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

### Relasi Utama
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

### Status Enum & Transisi

**Booking Status**:
```
pending → approved → on_trip → completed
   ↓         ↓
canceled  canceled
```
- `completed` dan `canceled` = terminal state

**Payment Status**:
```
unpaid → pending → paid → refunded
            ↓
         failed / expired  (retry jika booking belum canceled)
```

### Tipe Data Harga
Semua field harga: `decimal(12,2)`. Jangan gunakan float/double.

---

## 🏗️ Arsitektur Aplikasi

### MVC + Service Layer
```
Request → Route → Controller → FormRequest (validasi) → Service (logic) → Model → Database
                                                                         ↓
                                                                        View (Blade)
```

### Aturan Layer

| Layer           | Tanggung Jawab                                    | Dilarang                                        |
|-----------------|---------------------------------------------------|-------------------------------------------------|
| Route           | Definisi endpoint saja                            | Logic bisnis                                    |
| Controller      | Menerima request, memanggil service, return view  | Query DB langsung, kalkulasi harga              |
| FormRequest     | Validasi input                                    | Logic bisnis                                    |
| Service         | Logic bisnis kompleks (booking, payment, notif)   | Return view                                     |
| Model           | Relasi, scope, accessor, mutator                  | Logic bisnis berat                              |
| View (Blade)    | Tampilan saja                                     | Logic bisnis, query DB                          |

### Struktur Backend
```
app/
├── Filament/Resources/          # 11 Filament resource (admin CRUD)
│   ├── AirportTransfers/
│   ├── Drivers/
│   ├── HotelShuttles/
│   ├── Payments/
│   ├── RentalBookings/
│   ├── ShuttleBookings/
│   ├── TourBookings/
│   ├── TourPackages/
│   ├── TransferBookings/
│   ├── Users/
│   └── Vehicles/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                # Login, Register, Logout
│   │   ├── Booking/             # RentalBookingController, TourBookingController, TransferBookingController, ShuttleBookingController, BookingController
│   │   ├── Frontend/            # HomeController, VehicleController, TourPackageController, AirportTransferController, HotelShuttleController, CustomerDashboardController, BookingHistoryController, PaymentController
│   │   ├── Payment/             # PaymentController
│   │   └── Webhook/             # MidtransCallbackController
│   ├── Middleware/              # Role middleware
│   └── Requests/               # StoreRentalBookingRequest, StoreTourBookingRequest, StoreTransferBookingRequest, StoreShuttleBookingRequest, StoreBookingRequest, StorePaymentRequest
├── Mail/                        # BookingCreatedMail, BookingStatusUpdatedMail, PaymentSuccessMail
├── Models/                      # User, Vehicle, Driver, TourPackage, AirportTransfer, HotelShuttle, RentalBooking, TourBooking, TransferBooking, ShuttleBooking, Payment
├── Observers/                   # Model observers
├── Providers/                   # Service providers
└── Services/                    # BookingCodeService, BookingService, PaymentService
```

### Struktur Frontend
```
resources/
├── css/app.css                  # Tailwind v4 + design tokens (@theme)
├── js/app.js                    # JavaScript entry point
└── views/
    ├── auth/                    # login, register
    ├── components/              # navbar, footer, primary-button, ghost-button, service-card, status-badge, section-heading, page-container, form-error
    ├── customer/                # dashboard
    ├── emails/                  # email templates
    ├── frontend/                # home, vehicles/, tours/, transfers/, shuttles/, booking/
    └── layouts/                 # app (authenticated), guest
```

---

## 🌐 Routes & Endpoints

### Public (Guest)
```
GET  /                              Home
GET  /about                         Tentang Kami
GET  /contact                       Hubungi Kami & FAQ
GET  /terms                         Syarat dan Ketentuan
GET  /privacy                       Kebijakan Privasi
GET  /vehicles                      List kendaraan
GET  /vehicles/{vehicle}            Detail kendaraan
GET  /tours                         List paket wisata
GET  /tours/{tour}                  Detail paket wisata
GET  /transfers                     List airport transfer
GET  /transfers/{transfer}          Detail transfer
GET  /shuttles                      List hotel shuttle
GET  /shuttles/{shuttle}            Detail shuttle
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

## 💼 Business Logic

### Booking Code Format
```
RNT-YYYYMMDD-0001     # Rental
TOUR-YYYYMMDD-0001    # Tour
TRF-YYYYMMDD-0001     # Transfer
SHT-YYYYMMDD-0001     # Shuttle
```
Service: `BookingCodeService` — auto-increment per hari, unique, no duplikat.

### Perhitungan Harga

**WAJIB dihitung di BACKEND (service layer), BUKAN di frontend.**

| Jenis Booking     | Rumus                                          |
|-------------------|-------------------------------------------------|
| Rental (full_day) | `vehicle->price_full_day`                       |
| Rental (half_day) | `vehicle->price_half_day`                       |
| Tour              | `tour_package->price × participant_count`       |
| Transfer          | `airport_transfer->price`                       |
| Shuttle           | `hotel_shuttle->price × passenger_count`        |

---

## 🔐 Security Rules

1. **Password** wajib hash (bcrypt)
2. **CSRF** aktif pada semua form (kecuali Midtrans callback)
3. **Middleware `auth`** untuk semua halaman customer
4. **Middleware role** untuk admin dan customer routes
5. **Policy** untuk booking ownership — customer hanya lihat booking miliknya
6. **Upload gambar** divalidasi (jpg, jpeg, png, webp, maks 2MB)
7. **Midtrans keys** di `.env`, jangan hardcode
8. **Midtrans callback** wajib signature validation + idempotent
9. Semua harga dihitung di **backend**
10. Jangan tampilkan error teknis ke user biasa

---

## 📧 Email Notifications

| Email                    | Trigger                           | Recipient |
|--------------------------|-----------------------------------|-----------|
| BookingCreatedMail       | Booking berhasil dibuat           | Customer  |
| PaymentSuccessMail       | Payment status → paid             | Customer  |
| BookingStatusUpdatedMail | Admin mengubah booking status     | Customer  |

---

## 💳 Payment Integration (Midtrans Sandbox)

### Flow
1. Customer klik "Bayar" di detail booking
2. System create payment record (status: pending)
3. System create Midtrans transaction
4. Customer redirect ke Midtrans Snap
5. Customer complete payment
6. Midtrans send callback ke `/payments/midtrans/callback`
7. System validate signature
8. System update payment status + booking payment_status
9. System send email notification

### Config
```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

---

## 🎯 UI Components Reference

### Blade Components
```blade
<x-navbar />                        <!-- Navigation bar -->
<x-footer />                        <!-- Footer -->
<x-page-container>                  <!-- Max-width container -->
<x-section-heading>                 <!-- Section heading -->
<x-service-card>                    <!-- Service card -->
<x-primary-button>                  <!-- Primary button (hitam) -->
<x-ghost-button>                    <!-- Ghost button (transparent) -->
<x-status-badge :status="$status">  <!-- Status badge -->
<x-form-error :messages="$errors->get('field')" />
```

### Tailwind Utility Classes
```css
/* Colors */
text-carbon-black | bg-carbon-black
text-canvas-white | bg-canvas-white
text-storm-gray   | bg-faint-gray
border-soft-divider | bg-pale-drift

/* Layout patterns */
py-12 sampai py-16        /* Section spacing 48-64px */
max-w-7xl mx-auto px-4    /* Container */
grid grid-cols-1 md:grid-cols-3 gap-8
```

---

## 📝 Konvensi Kode

| Tipe          | Konvensi                              | Contoh                          |
|---------------|---------------------------------------|---------------------------------|
| Controller    | PascalCase + `Controller`             | `RentalBookingController`       |
| Model         | PascalCase singular                   | `RentalBooking`                 |
| Table         | snake_case plural                     | `rental_bookings`               |
| Variable      | camelCase                             | `$totalPrice`                   |
| View          | kebab-case                            | `booking-detail.blade.php`      |
| Route name    | dot notation                          | `booking.vehicle.store`         |
| FormRequest   | `Store`/`Update` + Model + Request    | `StoreRentalBookingRequest`     |
| Service       | PascalCase + `Service`                | `BookingCodeService`            |
| Mail          | PascalCase + `Mail`                   | `BookingCreatedMail`            |
| Commit        | conventional commits                 | `feat: Add vehicle booking`     |

---

## 📦 Project Status

### ✅ Completed (Phase 1–8)
- [x] Project setup (Laravel, Tailwind, Filament)
- [x] Authentication & authorization (register, login, logout, role, policy)
- [x] Database & models (11 tabel, relasi, seeders)
- [x] Frontend website (home, list, detail semua layanan, responsive)
- [x] Booking system (4 layanan, dashboard, riwayat, detail)
- [x] Admin panel Filament (11 resources, dashboard widgets)
- [x] Payment integration (Midtrans, callback, status sync)
- [x] Notification system (3 email templates)
- [x] Invoice & Voucher PDF generation (DOMPDF)

### 🚧 Pending (Phase 9–10)
- [ ] Validation testing
- [ ] Authorization testing
- [ ] Responsive testing
- [ ] Performance optimization
- [ ] Production configuration
- [ ] Deployment checklist

---

## 🚀 Development Commands

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

## 🐛 Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| Tailwind classes not working | `npm run dev` atau `npm run build` |
| 404 on admin panel | `php artisan filament:upgrade && php artisan optimize:clear` |
| Migration error | `php artisan migrate:fresh --seed` |
| Payment callback not working | Cek Midtrans credentials di `.env`, cek signature validation |
| Email not sending | Cek mail config di `.env`, gunakan Mailtrap |
| Images not displaying | `php artisan storage:link` |

---

## 🎯 Scope Project

### ✅ In Scope
Website frontend customer, auth, role admin/customer, admin panel Filament, CRUD data master, booking 4 layanan, riwayat booking, payment Midtrans Sandbox, email notifikasi, seeder, UI sesuai DESIGN.md

### ❌ Out of Scope
Mobile app, push notification, SMS gateway, live chat, review pelanggan, kupon diskon, refund otomatis, tracking real-time, multi bahasa, akuntansi, payroll driver, integrasi kalender

---

## 📁 File Penting — Quick Reference

| Kategori     | File / Path                                          |
|--------------|------------------------------------------------------|
| Agent Rules  | `agents.md`                                          |
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

---

## ✅ Checklist Sebelum Commit

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
