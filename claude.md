# Sistem Informasi Travel Manik Jaya Trans

## 📋 Overview

Sistem Informasi Travel Manik Jaya Trans adalah aplikasi web berbasis Laravel untuk mengelola layanan travel, paket wisata, penyewaan kendaraan, airport transfer, hotel shuttle, booking pelanggan, pembayaran, dan notifikasi email.

**Status Proyek**: 🚧 Dalam Pengembangan

**Tech Stack**:
- Laravel 13
- PHP 8.3+
- Filament 5.6.6 (Admin Panel)
- Tailwind CSS v4.3
- MySQL 5.7+ / 8.0+
- Blade Template
- Vite 8.0
- Midtrans Sandbox 2.6 (Payment Gateway)

---

## 🎯 Tujuan Proyek

1. Menyediakan sistem booking travel yang terpusat
2. Mempermudah customer melihat dan booking layanan
3. Menggantikan proses manual (buku, spreadsheet, WhatsApp)
4. Membangun sistem dengan struktur Laravel MVC yang rapi
5. Menghasilkan UI website yang clean, high contrast, dan responsif

---

## 📚 Dokumentasi Utama

Proyek ini memiliki dokumentasi lengkap di folder `docs/`:

1. **DESIGN.md** - Design system (Airbnb-style, high-contrast editorial canvas)
2. **PRD.md** - Product Requirements Document
3. **SRS.md** - Software Requirements Specification (validasi, behavior, aturan)
4. **SDD.md** - System Design Document (arsitektur, database, API)
5. **UI_UX_FLOW.md** - Alur UI/UX lengkap untuk semua halaman
6. **TASK_BREAKDOWN.md** - 44 task terstruktur dalam 10 phase

**⚠️ PENTING**: Semua dokumentasi di folder `docs/` adalah **single source of truth**. 
Prioritas: SRS → SDD → PRD → UI_UX_FLOW → DESIGN → TASK_BREAKDOWN

---

## 🎨 Design System

### Prinsip Desain
- **Theme**: Light
- **Style**: High-contrast editorial canvas
- **Karakter**: Bersih, langsung, editorial, fungsional
- **Palet**: Netral (BUKAN warna biru)

### Token Warna
```css
--color-carbon-black: #222222    /* Text utama, button utama, border */
--color-canvas-white: #ffffff    /* Background utama */
--color-faint-gray: #f7f7f7      /* Background section sekunder */
--color-storm-gray: #6a6a6a      /* Text sekunder */
--color-pale-drift: #ebebeb      /* Background halus, border lembut */
--color-dust-bunny: #a6a6a6      /* Elemen minor */
--color-soft-divider: #dddddd    /* Divider, border */
```

### Typography
- **Font**: `system-ui, sans-serif` (substitusi Airbnb Cereal VF)
- **Heading**: weight 700, size 48-72px (desktop)
- **Body**: weight 400, size 16-18px
- **Label/Nav**: weight 500

### Spacing
- **Base**: 8px
- **Section gap**: 48-64px
- **Card padding**: 24px
- **Element gap**: 8-16px

### Border Radius
- **Link**: 4px
- **Button**: 8px
- **Card**: 12px

### Aturan Desain
❌ **JANGAN**:
- Gradient
- Shadow berat
- Warna biru dominan
- Carousel
- Copywriting panjang
- Widget berlebihan

✅ **LAKUKAN**:
- High contrast
- Whitespace lega
- Hierarki tipografi kuat
- Layout clean dan minimal

---

## 👥 User Roles

### 1. Guest
**Dapat**:
- Melihat home
- Melihat list dan detail layanan
- Register
- Login

**Tidak Dapat**:
- Booking
- Melihat dashboard
- Melihat riwayat booking
- Melakukan pembayaran
- Mengakses admin panel

### 2. Customer
**Dapat**:
- Login/Logout
- Booking semua layanan (kendaraan include supir, paket wisata, airport transfer, hotel shuttle)
- Melihat dashboard
- Melihat riwayat booking
- Melihat detail booking
- Melakukan pembayaran
- Menerima email notifikasi
- Kontak customer service via WhatsApp dari halaman detail layanan

**Tidak Dapat**:
- Mengakses Filament admin panel
- Mengubah data master
- Mengubah status booking
- Melihat booking user lain
- Mengubah total harga
- Memilih supir (supir ditugaskan oleh admin)
- Form booking kendaraan TIDAK menampilkan field pemilihan supir

### 3. Admin
**Dapat**:
- Login ke Filament admin panel
- CRUD semua data master (user, kendaraan, driver, paket wisata, airport transfer, hotel shuttle)
- Kelola semua booking
- Kelola payment
- Ubah status booking
- Menugaskan supir ke booking kendaraan
- Melihat dashboard ringkas

**Tidak Boleh**:
- Dashboard terlalu ramai
- Mengubah total harga tanpa alasan teknis
- Menghapus data master yang sudah dipakai booking

---

## 🗄️ Database Schema

### Tabel Utama

1. **users** - User account (admin & customer)
2. **vehicles** - Kendaraan untuk rental
3. **drivers** - Driver untuk rental
4. **tour_packages** - Paket wisata
5. **airport_transfers** - Rute airport transfer
6. **hotel_shuttles** - Layanan hotel shuttle
7. **rental_bookings** - Booking sewa kendaraan
8. **tour_bookings** - Booking paket wisata
9. **transfer_bookings** - Booking airport transfer
10. **shuttle_bookings** - Booking hotel shuttle
11. **payments** - Payment records (polymorphic)

### Relasi Utama

```
User hasMany RentalBooking, TourBooking, TransferBooking, ShuttleBooking, Payment
Vehicle hasMany RentalBooking
Driver hasMany RentalBooking
TourPackage hasMany TourBooking
AirportTransfer hasMany TransferBooking
HotelShuttle hasMany ShuttleBooking
Payment morphTo payable (semua jenis booking)
```

### Status Enum

**Booking Status**:
- `pending` - Menunggu konfirmasi
- `approved` - Disetujui
- `on_trip` - Dalam perjalanan
- `completed` - Selesai
- `canceled` - Dibatalkan

**Payment Status**:
- `unpaid` - Belum dibayar
- `pending` - Menunggu pembayaran
- `paid` - Lunas
- `failed` - Gagal
- `expired` - Kedaluwarsa
- `refunded` - Refund

**Vehicle Status**:
- `available` - Tersedia (tampil di frontend)
- `maintenance` - Maintenance (tidak bisa dibooking)
- `inactive` - Tidak aktif (tidak tampil)

**Service Status** (Tour, Transfer, Shuttle):
- `active` - Aktif (tampil di frontend)
- `inactive` - Tidak aktif (tidak tampil)

---

## 🏗️ Struktur Aplikasi

### Backend Structure

```
app/
├── Filament/
│   ├── Resources/
│   │   ├── AirportTransfers/
│   │   ├── Drivers/
│   │   ├── HotelShuttles/
│   │   ├── Payments/
│   │   ├── RentalBookings/
│   │   ├── ShuttleBookings/
│   │   ├── TourBookings/
│   │   ├── TourPackages/
│   │   ├── TransferBookings/
│   │   ├── Users/
│   │   └── Vehicles/
│   └── Widgets/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   ├── Booking/
│   │   ├── Frontend/
│   │   └── Webhook/
│   ├── Middleware/
│   └── Requests/
├── Mail/
├── Models/
├── Policies/
└── Services/
    ├── BookingCodeService.php
    ├── BookingService.php
    ├── PaymentService.php
    └── NotificationService.php
```

### Frontend Structure

```
resources/
├── css/
│   └── app.css (Tailwind + Design Tokens)
├── js/
│   └── app.js
└── views/
    ├── auth/
    │   ├── login.blade.php
    │   └── register.blade.php
    ├── components/
    │   ├── footer.blade.php
    │   ├── form-error.blade.php
    │   ├── ghost-button.blade.php
    │   ├── navbar.blade.php
    │   ├── page-container.blade.php
    │   ├── primary-button.blade.php
    │   ├── section-heading.blade.php
    │   ├── service-card.blade.php
    │   └── status-badge.blade.php
    ├── customer/
    │   └── dashboard.blade.php
    ├── frontend/
    │   ├── booking/
    │   ├── shuttles/
    │   ├── tours/
    │   ├── transfers/
    │   ├── vehicles/
    │   └── home.blade.php
    └── layouts/
        ├── app.blade.php
        └── guest.blade.php
```

---

## 🌐 Routes & Endpoints

### Public Routes (Guest)
```
GET  /                              # Home
GET  /about                         # Tentang Kami
GET  /contact                       # Hubungi Kami & FAQ
GET  /terms                         # Syarat dan Ketentuan
GET  /privacy                       # Kebijakan Privasi
GET  /vehicles                      # List kendaraan
GET  /vehicles/{vehicle}            # Detail kendaraan
GET  /tours                         # List paket wisata
GET  /tours/{tour}              Detail paket wisata
GET  /transfers                 List airport transfer
GET  /transfers/{transfer}      Detail airport transfer
GET  /shuttles                  List hotel shuttle
GET  /shuttles/{shuttle}        Detail hotel shuttle
GET  /login                     Login page
POST /login                     Login action
GET  /register                  Register page
POST /register                  Register action
```

### Customer Routes (Authenticated)
```
POST /logout                                    Logout
GET  /customer/dashboard                        Dashboard customer
GET  /customer/my-bookings                      Riwayat booking
GET  /customer/my-bookings/rental/{code}        Detail rental booking
GET  /customer/my-bookings/tours/{code}         Detail tour booking
GET  /customer/my-bookings/transfers/{code}     Detail transfer booking
GET  /customer/my-bookings/shuttles/{code}      Detail shuttle booking

GET  /booking/vehicles/{vehicle}                Form booking kendaraan
POST /booking/vehicles/{vehicle}                Submit booking kendaraan
GET  /booking/tours/{tour}                      Form booking paket wisata
POST /booking/tours/{tour}                      Submit booking paket wisata
GET  /booking/transfers/{transfer}              Form booking airport transfer
POST /booking/transfers/{transfer}              Submit booking airport transfer
GET  /booking/shuttles/{shuttle}                Form booking hotel shuttle
POST /booking/shuttles/{shuttle}                Submit booking hotel shuttle

POST /payment/{type}/{booking_code}             Create payment
```

### Admin Routes (Filament)
```
GET  /admin                     Dashboard admin
GET  /admin/users               User management
GET  /admin/vehicles            Vehicle management
GET  /admin/drivers             Driver management
GET  /admin/tour-packages       Tour package management
GET  /admin/airport-transfers   Airport transfer management
GET  /admin/hotel-shuttles      Hotel shuttle management
GET  /admin/rental-bookings     Rental booking management
GET  /admin/tour-bookings       Tour booking management
GET  /admin/transfer-bookings   Transfer booking management
GET  /admin/shuttle-bookings    Shuttle booking management
GET  /admin/payments            Payment management
```

### Webhook Routes
```
POST /payments/midtrans/callback    Midtrans payment callback
```

---

## 🔐 Security & Validation

### Authentication
- Password hashing dengan bcrypt
- Session-based authentication
- CSRF protection pada semua form
- Role-based middleware (admin/customer)

### Authorization
- Policy untuk booking ownership
- Customer hanya bisa lihat booking miliknya
- Admin tidak bisa akses customer routes
- Guest redirect ke login saat booking

### Validation Rules

**Register**:
- name: required, min:3
- email: required, email, unique
- password: required, min:8, confirmed
- phone: optional, format angka/spasi/plus/strip

**Booking Kendaraan**:
- vehicle_id: required, exists, status available
- rental_type: required, enum (full_day/half_day)
- start_date: required, date, >= today
- end_date: optional, date, >= start_date
- pickup_location: required
- note: max:500
- driver_id: tidak ada (akan ditugaskan oleh admin)

**Booking Paket Wisata**:
- tour_package_id: required, exists, status active
- booking_date: required, date, >= today
- participant_count: required, integer, min:1
- note: max:500

**Booking Airport Transfer**:
- airport_transfer_id: required, exists, status active
- booking_date: required, date, >= today
- passenger_count: required, integer, min:1
- flight_number: optional
- pickup_time: optional
- note: max:500

**Booking Hotel Shuttle**:
- hotel_shuttle_id: required, exists, status active
- booking_date: required, date, >= today
- passenger_count: required, integer, min:1
- pickup_time: optional
- note: max:500

### Payment Security
- Midtrans signature validation
- Callback idempotency
- Prevent double payment
- Booking canceled tidak bisa dibayar
- Booking paid tidak bisa dibayar ulang

---

## 💼 Business Logic

### Booking Code Generator

Format booking code:
```
RNT-YYYYMMDD-0001   (Rental)
TOUR-YYYYMMDD-0001  (Tour)
TRF-YYYYMMDD-0001   (Transfer)
SHT-YYYYMMDD-0001   (Shuttle)
```

Service: `BookingCodeService`
- Generate unique code per hari
- Auto increment counter
- Prevent duplicate

### Price Calculation

**Rental Booking**:
```php
if (rental_type == 'full_day') {
    total_price = vehicle->price_full_day
} else {
    total_price = vehicle->price_half_day
}
```
**Catatan Penting**: 
- Sewa kendaraan include supir. 
- Driver akan ditugaskan oleh admin melalui Filament panel setelah booking approved.
- Customer TIDAK memilih supir saat booking (field tidak ada di form).
- Form booking hanya berisi: rental_type, start_date, end_date, pickup_location, note.

**Tour Booking**:
```php
total_price = tour_package->price * participant_count
```

**Transfer Booking**:
```php
total_price = airport_transfer->price
```

**Shuttle Booking**:
```php
total_price = hotel_shuttle->price * passenger_count
```

⚠️ **PENTING**: Semua perhitungan harga dilakukan di **backend**, bukan frontend!

### Booking Status Flow

```
pending → approved → on_trip → completed
   ↓          ↓
canceled   canceled
```

**Aturan**:
- `completed` tidak dapat diubah
- `canceled` tidak dapat dilanjutkan
- Hanya admin yang bisa ubah status

### Payment Status Flow

```
unpaid → pending → paid
            ↓        ↓
         failed   refunded
            ↓
         expired
```

**Aturan**:
- `failed` dan `expired` bisa retry
- `paid` bisa menjadi `refunded` oleh admin
- Satu booking hanya boleh 1 payment aktif

---

## 📧 Email Notifications

### Email Types

1. **Booking Created**
   - Trigger: Setelah booking berhasil dibuat
   - Recipient: Customer
   - Content: Booking code, detail layanan, total harga, status

2. **Payment Success**
   - Trigger: Setelah payment status menjadi `paid`
   - Recipient: Customer
   - Content: Payment confirmation, booking detail, invoice

3. **Booking Status Changed**
   - Trigger: Admin mengubah booking status
   - Recipient: Customer
   - Content: Status baru, booking detail

### Email Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@manikjaya.test
MAIL_FROM_NAME="Manik Jaya Trans"
```

---

## 💳 Payment Integration

### Midtrans Sandbox

**Configuration** (`config/midtrans.php`):
```php
'server_key' => env('MIDTRANS_SERVER_KEY'),
'client_key' => env('MIDTRANS_CLIENT_KEY'),
'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
'is_sanitized' => true,
'is_3ds' => true,
```

**Environment Variables**:
```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

### Payment Flow

1. Customer klik "Bayar" di detail booking
2. System create payment record (status: pending)
3. System create Midtrans transaction
4. Customer redirect ke Midtrans Snap
5. Customer complete payment
6. Midtrans send callback ke `/payments/midtrans/callback`
7. System validate signature
8. System update payment status
9. System update booking payment_status
10. System send email notification

### Callback Handling

- Validate Midtrans signature
- Idempotent (prevent duplicate processing)
- Update payment status based on transaction_status
- Update booking payment_status
- Log raw response to JSON field

---

## 🚀 Development Setup

### Prerequisites
- PHP 8.3+
- Composer
- Node.js & NPM
- MySQL
- Git

### Installation

1. **Clone Repository**
```bash
git clone <repository-url>
cd manik-jaya-trans-v1
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure Database**
Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manik_jaya_trans
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run Migrations & Seeders**
```bash
php artisan migrate:fresh --seed
```

6. **Build Assets**
```bash
npm run dev
```

7. **Start Development Server**
```bash
php artisan serve
```

Access:
- Frontend: http://localhost:8000
- Admin Panel: http://localhost:8000/admin

### Default Admin Credentials
```
Email: admin@manikjaya.test
Password: password
```

### Development Commands

**Run all services** (server + queue + logs + vite):
```bash
composer dev
```

**Run tests**:
```bash
composer test
```

**Code formatting**:
```bash
./vendor/bin/pint
```

**Clear cache**:
```bash
php artisan optimize:clear
```

---

## 📦 Project Status

### ✅ Completed Features

#### Phase 1: Project Setup
- [x] Laravel 13 installation
- [x] Database connection
- [x] Tailwind CSS setup with design tokens
- [x] Filament 4 admin panel

#### Phase 2: Authentication & Authorization
- [x] Customer authentication (register, login, logout)
- [x] Role system (admin/customer)
- [x] Authorization policies
- [x] Middleware protection

#### Phase 3: Database & Models
- [x] All migrations created
- [x] All models created
- [x] Model relationships
- [x] Database seeders

#### Phase 4: Frontend Website
- [x] Layout system (navbar, footer)
- [x] Home page with hero editorial
- [x] Vehicle list & detail pages
- [x] Tour package list & detail pages
- [x] Airport transfer list & detail pages
- [x] Hotel shuttle list & detail pages
- [x] Responsive design
- [x] Mobile menu
- [x] **UPDATE**: Simplified booking cards (summary only, no interactive forms)
- [x] **UPDATE**: WhatsApp help cards on all service detail pages

#### Phase 5: Booking System
- [x] Booking code generator service
- [x] Rental booking module
- [x] Tour booking module
- [x] Transfer booking module
- [x] Shuttle booking module
- [x] Customer dashboard
- [x] Booking history
- [x] Booking detail pages
- [x] **UPDATE**: Driver assignment by admin only (customer cannot select driver)

#### Phase 6: Admin Panel Filament
- [x] User resource
- [x] Vehicle resource
- [x] Driver resource
- [x] Tour package resource
- [x] Airport transfer resource
- [x] Hotel shuttle resource
- [x] Rental booking resource
- [x] Tour booking resource
- [x] Transfer booking resource
- [x] Shuttle booking resource
- [x] Payment resource
- [x] Dashboard widgets
- [x] **UPDATE**: Driver assignment functionality for rental bookings

#### Phase 7: Payment Integration
- [x] Payment model & logic
- [x] Midtrans integration
- [x] Midtrans callback handler
- [x] Payment status sync

#### Phase 8: Notification System
- [x] Mail configuration
- [x] Booking notification emails (BookingCreatedMail)
- [x] Payment notification emails (PaymentSuccessMail)
- [x] Status update notification emails (BookingStatusUpdatedMail)
- [x] **UPDATE**: Email notification system 100% complete and production ready
- [x] **UPDATE**: Comprehensive email setup documentation (EMAIL_NOTIFICATION_SETUP.md)

#### Phase 9: UI/UX Improvements (Recent Updates)
- [x] Simplified booking card UI across all services
- [x] WhatsApp integration on service detail pages
- [x] Consistent card design system
- [x] Enhanced customer support accessibility

---

### 🚧 In Progress / Pending

#### Recent Updates (v1.1.0):
- ✅ Driver assignment by admin only (customer tidak pilih supir)
- ✅ Simplified booking card UI (summary only, bukan form interaktif)
- ✅ WhatsApp integration pada semua halaman detail layanan
- ✅ Email notification system 100% complete dan production ready
- ✅ Invoice & Voucher PDF generation dengan DOMPDF
- 📄 Documentation updates across all project files
- 📝 Lihat `CHANGELOG_RECENT_UPDATES.md` untuk detail lengkap

#### Phase 9: Testing & Optimization
- [ ] Validation testing
- [ ] Authorization testing
- [ ] Responsive testing
- [ ] Performance optimization (eager loading, pagination)
- [ ] Image optimization
- [ ] Query optimization

#### Phase 10: Deployment Preparation
- [ ] Production configuration
- [ ] Environment setup
- [ ] Asset building
- [ ] Cache optimization
- [ ] Deployment checklist

---

## 🎯 Scope Project

### ✅ In Scope

1. Website frontend customer
2. Auth customer (register, login, logout)
3. Role admin/customer
4. Admin panel Filament
5. CRUD kendaraan, driver, paket wisata, airport transfer, hotel shuttle
6. Booking kendaraan, paket wisata, airport transfer, hotel shuttle
7. Riwayat booking customer
8. Detail booking customer
9. Payment basic dengan Midtrans Sandbox
10. Email notifikasi dasar
11. Seeder data awal
12. UI sesuai DESIGN.md (high-contrast, editorial, no gradient, no heavy shadow)

### ❌ Out of Scope

1. Mobile app
2. Push notification
3. SMS gateway
4. Live chat
5. Review pelanggan
6. Kupon diskon
7. Refund otomatis
8. Tracking kendaraan real-time
9. Multi bahasa
10. Akuntansi lengkap
11. Payroll driver
12. Integrasi kalender eksternal

---

## 🧪 Testing Guide

### Manual Testing Checklist

#### Guest Flow
- [ ] Buka home page
- [ ] Lihat featured vehicles & packages
- [ ] Klik "Sewa Kendaraan" → list tampil
- [ ] Klik detail kendaraan → detail tampil
- [ ] Klik "Booking Sekarang" → redirect ke login
- [ ] Ulangi untuk Tours, Transfers, Shuttles

#### Customer Registration & Login
- [ ] Klik "Daftar"
- [ ] Isi form register dengan data valid
- [ ] Submit → akun dibuat
- [ ] Login dengan akun baru
- [ ] Redirect ke dashboard

#### Customer Booking Flow
- [ ] Login sebagai customer
- [ ] Pilih layanan (vehicle/tour/transfer/shuttle)
- [ ] Klik "Booking Sekarang"
- [ ] Isi form booking
- [ ] Submit → booking dibuat
- [ ] Cek booking code generated
- [ ] Cek total price calculated
- [ ] Cek status: pending & unpaid

#### Customer Dashboard
- [ ] Lihat ringkasan booking
- [ ] Klik "Riwayat Booking"
- [ ] Lihat semua booking milik customer
- [ ] Klik detail booking
- [ ] Cek informasi lengkap

#### Payment Flow
- [ ] Buka detail booking (status unpaid)
- [ ] Klik "Bayar"
- [ ] Redirect ke Midtrans Snap
- [ ] Complete payment (sandbox)
- [ ] Callback received
- [ ] Payment status → paid
- [ ] Booking payment_status → paid
- [ ] Email notification sent

#### Admin Flow
- [ ] Login ke /admin
- [ ] Lihat dashboard widgets
- [ ] CRUD vehicles
- [ ] CRUD drivers
- [ ] CRUD tour packages
- [ ] CRUD airport transfers
- [ ] CRUD hotel shuttles
- [ ] Lihat list bookings
- [ ] Filter booking by status
- [ ] Search booking by code
- [ ] Ubah booking status
- [ ] Lihat payment records

---

## 🐛 Common Issues & Solutions

### Issue: Tailwind classes not working
**Solution**:
```bash
npm run dev
# or
npm run build
```

### Issue: 404 on admin panel
**Solution**:
```bash
php artisan filament:upgrade
php artisan optimize:clear
```

### Issue: Migration error
**Solution**:
```bash
php artisan migrate:fresh --seed
```

### Issue: Payment callback not working
**Solution**:
1. Check Midtrans credentials in `.env`
2. Verify callback URL in Midtrans dashboard
3. Check signature validation
4. Check logs: `storage/logs/laravel.log`

### Issue: Email not sending
**Solution**:
1. Check mail configuration in `.env`
2. Use Mailtrap for testing
3. Check queue is running: `php artisan queue:work`
4. See comprehensive guide: `EMAIL_NOTIFICATION_SETUP.md`

### Issue: Images not displaying
**Solution**:
```bash
php artisan storage:link
```

### Issue: Permission denied on storage
**Solution** (Linux/Mac):
```bash
chmod -R 775 storage bootstrap/cache
```

### Issue: Driver field showing on booking form
**Solution**:
- Check `resources/views/frontend/booking/rental/create.blade.php`
- Driver field should NOT be present in customer form
- Driver is assigned by admin via Filament panel

### Issue: WhatsApp link not working
**Solution**:
1. Verify WhatsApp number format (62xxx without +)
2. Check URL encoding in href
3. Update placeholder number to production CS number before deployment

---

## 📋 Recent Updates (June 2026)

### Version 1.1.0 - Latest Changes

#### ✅ Driver Assignment System
- Customer can no longer select driver during booking
- Driver automatically assigned by admin after booking approval
- Improved operational efficiency and driver availability management

#### ✅ Simplified Booking Card UI
- Booking cards now show summary info only (no interactive forms)
- Consistent design across all service detail pages
- Clearer call-to-action with direct booking button

#### ✅ WhatsApp Integration
- WhatsApp help cards added to all service detail pages
- One-click contact to customer service
- Pre-filled context messages for better support

#### ✅ Email Notification System (100% Complete)
- 3 email types fully implemented and tested
- Production-ready with comprehensive documentation
- Error handling with try-catch and logging
- See: `EMAIL_NOTIFICATION_SETUP.md` for complete guide

**For detailed changelog**: See `CHANGELOG_RECENT_UPDATES.md`

---

## 📝 Code Standards

### Laravel Best Practices

1. **MVC Pattern**
   - Route → Controller → Service → Model
   - No business logic in routes
   - No business logic in views

2. **Naming Conventions**
   - Controllers: `PascalCase` + `Controller` suffix
   - Models: `PascalCase` singular
   - Tables: `snake_case` plural
   - Variables: `camelCase`
   - Constants: `UPPER_SNAKE_CASE`

3. **Validation**
   - Use Form Request classes
   - Validate in backend, not just frontend
   - Return clear error messages

4. **Security**
   - Always use CSRF tokens
   - Hash passwords
   - Validate user input
   - Use policies for authorization
   - Sanitize database queries (use Eloquent)

5. **Performance**
   - Use eager loading to prevent N+1
   - Paginate large datasets
   - Cache when appropriate
   - Optimize images

---

## 🎨 UI Components Reference

### Blade Components

#### Layout Components
```blade
<x-navbar />                    <!-- Navigation bar -->
<x-footer />                    <!-- Footer -->
<x-page-container>              <!-- Max-width container -->
    Content here
</x-page-container>
```

#### UI Components
```blade
<x-section-heading>             <!-- Section heading -->
    Heading Text
</x-section-heading>

<x-service-card>                <!-- Service card -->
    <x-slot name="image">       <!-- Optional image slot -->
        <img src="..." />
    </x-slot>
    Card content here
</x-service-card>

<x-primary-button>              <!-- Primary button (black) -->
    Button Text
</x-primary-button>

<x-ghost-button>                <!-- Ghost button (transparent) -->
    Button Text
</x-ghost-button>

<x-status-badge :status="$status">  <!-- Status badge -->
    Status Text
</x-status-badge>

<x-form-error :messages="$errors->get('field')" />  <!-- Form error -->
```

### Tailwind Utility Classes

#### Colors
```css
text-carbon-black       /* #222222 */
text-canvas-white       /* #ffffff */
text-storm-gray         /* #6a6a6a */
text-dust-bunny         /* #a6a6a6 */

bg-canvas-white         /* #ffffff */
bg-faint-gray           /* #f7f7f7 */
bg-pale-drift           /* #ebebeb */
bg-carbon-black         /* #222222 */

border-soft-divider     /* #dddddd */
```

#### Border Radius
```css
rounded-link            /* 4px */
rounded-btn             /* 8px */
rounded-card            /* 12px */
```

#### Common Patterns
```css
/* Section spacing */
py-20                   /* Vertical padding 80px */
py-16                   /* Vertical padding 64px */
mb-12                   /* Margin bottom 48px */

/* Grid layouts */
grid grid-cols-1 md:grid-cols-3 gap-8
grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6

/* Container */
max-w-7xl mx-auto px-4 sm:px-6 lg:px-8
```

---

## 📚 Key Files Reference

### Configuration Files
```
.env                            Environment variables
config/app.php                  Application config
config/database.php             Database config
config/midtrans.php             Midtrans config
config/mail.php                 Mail config
```

### Important Backend Files
```
app/Models/User.php                         User model
app/Models/Vehicle.php                      Vehicle model
app/Models/RentalBooking.php                Rental booking model
app/Models/Payment.php                      Payment model

app/Services/BookingCodeService.php         Booking code generator
app/Services/BookingService.php             Booking business logic
app/Services/PaymentService.php             Payment business logic
app/Services/NotificationService.php        Email notifications

app/Http/Controllers/Frontend/HomeController.php
app/Http/Controllers/Frontend/VehicleController.php
app/Http/Controllers/Booking/RentalBookingController.php
app/Http/Controllers/Frontend/PaymentController.php
app/Http/Controllers/Webhook/MidtransCallbackController.php
```

### Important Frontend Files
```
resources/views/layouts/app.blade.php       Main layout
resources/views/frontend/home.blade.php     Home page
resources/views/frontend/vehicles/index.blade.php
resources/views/frontend/vehicles/show.blade.php
resources/views/customer/dashboard.blade.php

resources/css/app.css                       Tailwind + Design tokens
resources/js/app.js                         JavaScript entry
```

### Database Files
```
database/migrations/                        All migrations
database/seeders/DatabaseSeeder.php         Main seeder
database/factories/                         Model factories
```

### Routes
```
routes/web.php                              All web routes
routes/console.php                          Console commands
```

---

## 🔄 Git Workflow

### Branch Strategy
```
main            Production-ready code
develop         Development branch
feature/*       Feature branches
bugfix/*        Bug fix branches
hotfix/*        Hotfix branches
```

### Commit Message Convention
```
feat: Add vehicle booking feature
fix: Fix payment callback validation
docs: Update README
style: Format code with Pint
refactor: Refactor booking service
test: Add booking validation tests
chore: Update dependencies
```

### Common Git Commands
```bash
# Create feature branch
git checkout -b feature/booking-system

# Commit changes
git add .
git commit -m "feat: Add rental booking module"

# Push to remote
git push origin feature/booking-system

# Merge to develop
git checkout develop
git merge feature/booking-system

# Delete feature branch
git branch -d feature/booking-system
```

---

## 📞 Support & Resources

### Documentation Links
- [Laravel 13 Docs](https://laravel.com/docs/13.x)
- [Filament 4 Docs](https://filamentphp.com/docs/4.x)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [Midtrans Docs](https://docs.midtrans.com)

### Project Documentation
- `docs/DESIGN.md` - Design system
- `docs/PRD.md` - Product requirements
- `docs/SRS.md` - Software requirements
- `docs/SDD.md` - System design
- `docs/UI_UX_FLOW.md` - UI/UX flows
- `docs/TASK_BREAKDOWN.md` - Task breakdown
- `FRONTEND_PUBLIC_PAGES.md` - Frontend pages documentation

### Contact
- Project Lead: [Your Name]
- Email: [Your Email]
- Repository: [Repository URL]

---

## 📄 License

This project is proprietary software developed for Manik Jaya Trans.

---

**Last Updated**: 2024
**Version**: 1.0.0
**Status**: 🚧 In Development

---

## 🎯 Quick Start Commands

```bash
# Fresh install
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev

# Start development
composer dev

# Or manually
php artisan serve
npm run dev

# Access
# Frontend: http://localhost:8000
# Admin: http://localhost:8000/admin
# Login: admin@manikjaya.test / password
```

---

**Happy Coding! 🚀**
