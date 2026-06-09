# SYSTEM DESIGN DOCUMENT
# Sistem Informasi Travel Manik Jaya Trans

## 1. Ringkasan Sistem

Sistem Informasi Travel Manik Jaya Trans adalah aplikasi monolithic web application berbasis Laravel 13. Sistem menggunakan MVC sebagai arsitektur aplikasi utama, Filament 5.6.6 untuk admin panel, Tailwind CSS v4.3 untuk tampilan frontend, MySQL 5.7+ / 8.0+ untuk database, dan Midtrans Sandbox 2.6 untuk pembayaran.

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


## 3. Arsitektur Sistem

### 3.1 Arsitektur Umum

```text
Customer Browser
      |
      v
Laravel Web Routes
      |
      v
Frontend Controller
      |
      v
Service Layer
      |
      v
Eloquent Model
      |
      v
MySQL Database
```

```text
Admin Browser
      |
      v
Filament Admin Panel
      |
      v
Filament Resource
      |
      v
Eloquent Model
      |
      v
MySQL Database
```

```text
Customer
   |
   v
PaymentController
   |
   v
PaymentService
   |
   v
Midtrans API
   |
   v
Midtrans Callback
   |
   v
Payment Status Sync
```

### 3.2 Arsitektur Aplikasi

Layer:
1. Routes.
2. Controllers.
3. Form Requests.
4. Services.
5. Models.
6. Views.
7. Filament Resources.
8. Mail Classes.
9. Policies.
10. Middleware.

Aturan:
- Route hanya mendefinisikan endpoint.
- Controller mengatur request dan response.
- Form Request mengatur validasi.
- Service mengatur logic kompleks.
- Model mengatur relasi.
- View tidak boleh berisi logic bisnis berat.

## 4. Frontend Design Architecture

### 4.1 Tailwind Design Token

Tambahkan token berikut ke `resources/css/app.css`.

```css
@theme {
  --color-carbon-black: #222222;
  --color-canvas-white: #ffffff;
  --color-faint-gray: #f7f7f7;
  --color-storm-gray: #6a6a6a;
  --color-pale-drift: #ebebeb;
  --color-dust-bunny: #a6a6a6;
  --color-soft-divider: #dddddd;

  --font-airbnb-cereal-vf: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;

  --text-body: 18px;
  --text-subheading: 22px;
  --text-heading: 26px;
  --text-heading-lg: 48px;
  --text-display: 72px;

  --spacing-8: 8px;
  --spacing-16: 16px;
  --spacing-24: 24px;
  --spacing-32: 32px;
  --spacing-40: 40px;
  --spacing-48: 48px;
  --spacing-64: 64px;
  --spacing-80: 80px;
  --spacing-96: 96px;

  --radius-md: 4px;
  --radius-lg: 8px;
  --radius-xl: 12px;
}
```

### 4.2 Komponen Frontend

Komponen Blade:
- `layouts/app.blade.php`
- `layouts/guest.blade.php`
- `components/navbar.blade.php`
- `components/footer.blade.php`
- `components/primary-button.blade.php`
- `components/ghost-button.blade.php`
- `components/service-card.blade.php`
- `components/status-badge.blade.php`
- `components/section-heading.blade.php`
- `components/page-container.blade.php`
- `components/form-error.blade.php`

Aturan komponen:
- Button utama hitam putih.
- Card radius 12px.
- Border halus.
- Tanpa shadow berat.
- Section lega.
- Text ringkas.

## 5. Database Design

### 5.1 users

Field:
```text
id bigint primary key
name varchar
email varchar unique
password varchar
role enum admin/customer
phone varchar nullable
address text nullable
email_verified_at timestamp nullable
remember_token varchar nullable
created_at timestamp
updated_at timestamp
```

Index:
```text
email unique
role index
```

Relasi:
```text
User hasMany RentalBooking
User hasMany TourBooking
User hasMany TransferBooking
User hasMany ShuttleBooking
User hasMany Payment
```

### 5.2 vehicles

Field:
```text
id bigint primary key
name varchar
type varchar
capacity integer
price_full_day decimal(12,2)
price_half_day decimal(12,2)
description text nullable
image varchar nullable
status enum available/maintenance/inactive
created_at timestamp
updated_at timestamp
```

Index:
```text
status index
type index
```

Relasi:
```text
Vehicle hasMany RentalBooking
```

### 5.3 drivers

Field:
```text
id bigint primary key
name varchar
phone varchar
license_number varchar nullable
status enum available/on_trip/inactive
created_at timestamp
updated_at timestamp
```

Index:
```text
status index
```

Relasi:
```text
Driver hasMany RentalBooking
```

### 5.4 tour_packages

Field:
```text
id bigint primary key
name varchar
description text
itinerary text nullable
duration varchar
price decimal(12,2)
image varchar nullable
status enum active/inactive
created_at timestamp
updated_at timestamp
```

Index:
```text
status index
```

Relasi:
```text
TourPackage hasMany TourBooking
```

### 5.5 airport_transfers

Field:
```text
id bigint primary key
route_name varchar
pickup_location varchar
dropoff_location varchar
price decimal(12,2)
estimated_duration varchar nullable
status enum active/inactive
created_at timestamp
updated_at timestamp
```

Index:
```text
status index
pickup_location index
dropoff_location index
```

Relasi:
```text
AirportTransfer hasMany TransferBooking
```

### 5.6 hotel_shuttles

Field:
```text
id bigint primary key
hotel_name varchar
pickup_location varchar
dropoff_location varchar
price decimal(12,2)
schedule varchar nullable
status enum active/inactive
created_at timestamp
updated_at timestamp
```

Index:
```text
status index
hotel_name index
```

Relasi:
```text
HotelShuttle hasMany ShuttleBooking
```

### 5.7 rental_bookings

Field:
```text
id bigint primary key
user_id foreign key
vehicle_id foreign key
driver_id foreign key nullable
booking_code varchar unique
rental_type enum full_day/half_day
start_date date
end_date date nullable
pickup_location varchar
note text nullable
total_price decimal(12,2)
booking_status enum pending/approved/on_trip/completed/canceled
payment_status enum unpaid/pending/paid/failed/expired/refunded
created_at timestamp
updated_at timestamp
```

Index:
```text
booking_code unique
user_id index
vehicle_id index
driver_id index
booking_status index
payment_status index
start_date index
```

Relasi:
```text
RentalBooking belongsTo User
RentalBooking belongsTo Vehicle
RentalBooking belongsTo Driver nullable
RentalBooking morphOne Payment as payable
```

Catatan Penting:
- driver_id default null saat booking dibuat oleh customer
- Customer TIDAK memilih supir saat booking (field tidak ada di form)
- Admin menugaskan supir melalui Filament admin panel setelah booking approved
- Sewa kendaraan include supir (tidak ada opsi lepas kunci)
- Form booking customer hanya berisi: vehicle, rental_type, dates, pickup_location, note

### 5.8 tour_bookings

Field:
```text
id bigint primary key
user_id foreign key
tour_package_id foreign key
booking_code varchar unique
booking_date date
participant_count integer
note text nullable
total_price decimal(12,2)
booking_status enum pending/approved/on_trip/completed/canceled
payment_status enum unpaid/pending/paid/failed/expired/refunded
created_at timestamp
updated_at timestamp
```

Relasi:
```text
TourBooking belongsTo User
TourBooking belongsTo TourPackage
TourBooking morphOne Payment as payable
```

### 5.9 transfer_bookings

Field:
```text
id bigint primary key
user_id foreign key
airport_transfer_id foreign key
booking_code varchar unique
booking_date date
passenger_count integer
flight_number varchar nullable
pickup_time time nullable
note text nullable
total_price decimal(12,2)
booking_status enum pending/approved/on_trip/completed/canceled
payment_status enum unpaid/pending/paid/failed/expired/refunded
created_at timestamp
updated_at timestamp
```

Relasi:
```text
TransferBooking belongsTo User
TransferBooking belongsTo AirportTransfer
TransferBooking morphOne Payment as payable
```

### 5.10 shuttle_bookings

Field:
```text
id bigint primary key
user_id foreign key
hotel_shuttle_id foreign key
booking_code varchar unique
booking_date date
passenger_count integer
pickup_time time nullable
note text nullable
total_price decimal(12,2)
booking_status enum pending/approved/on_trip/completed/canceled
payment_status enum unpaid/pending/paid/failed/expired/refunded
created_at timestamp
updated_at timestamp
```

Relasi:
```text
ShuttleBooking belongsTo User
ShuttleBooking belongsTo HotelShuttle
ShuttleBooking morphOne Payment as payable
```

### 5.11 payments

Field:
```text
id bigint primary key
user_id foreign key
payable_type varchar
payable_id bigint
booking_code varchar
payment_method varchar nullable
payment_gateway varchar nullable
transaction_id varchar nullable
gross_amount decimal(12,2)
status enum pending/paid/failed/expired/refunded
paid_at timestamp nullable
raw_response json nullable
created_at timestamp
updated_at timestamp
```

Index:
```text
user_id index
booking_code index
status index
transaction_id index
payable_type payable_id index
```

Relasi:
```text
Payment belongsTo User
Payment morphTo payable
```

## 6. Backend Structure

```text
app/
├── Filament/
│   ├── Pages/
│   ├── Resources/
│   └── Widgets/
├── Http/
│   ├── Controllers/
│   │   ├── Frontend/
│   │   ├── Booking/
│   │   └── Payment/
│   ├── Middleware/
│   └── Requests/
├── Mail/
├── Models/
├── Policies/
└── Services/
```

Controllers:
- HomeController
- VehicleController
- TourPackageController
- AirportTransferController
- HotelShuttleController
- CustomerDashboardController
- RentalBookingController
- TourBookingController
- TransferBookingController
- ShuttleBookingController
- PaymentController
- MidtransCallbackController
- InvoiceController
- DocumentController

Services:
- BookingCodeService
- BookingService
- PaymentService
- NotificationService

Requests:
- StoreRentalBookingRequest
- StoreTourBookingRequest
- StoreTransferBookingRequest
- StoreShuttleBookingRequest
- StoreVehicleRequest
- StoreDriverRequest
- StoreTourPackageRequest

Filament Resources:
- UserResource
- VehicleResource
- DriverResource
- TourPackageResource
- AirportTransferResource
- HotelShuttleResource
- RentalBookingResource
- TourBookingResource
- TransferBookingResource
- ShuttleBookingResource
- PaymentResource
- LaporanKeuangan (Custom Page)

## 7. Route Design

Public routes:
```text
GET /
GET /vehicles
GET /vehicles/:vehicle
GET /tour-packages
GET /tour-packages/:tourPackage
GET /airport-transfers
GET /airport-transfers/:airportTransfer
GET /hotel-shuttles
GET /hotel-shuttles/:hotelShuttle
GET /login
GET /register
```

Customer routes:
```text
GET /dashboard
GET /my-bookings
GET /my-bookings/:type/:bookingCode
GET /vehicles/:vehicle/booking
POST /vehicles/:vehicle/booking
GET /tour-packages/:tourPackage/booking
POST /tour-packages/:tourPackage/booking
GET /airport-transfers/:airportTransfer/booking
POST /airport-transfers/:airportTransfer/booking
GET /hotel-shuttles/:hotelShuttle/booking
POST /hotel-shuttles/:hotelShuttle/booking
POST /payments/:type/:bookingCode
GET /invoice/:type/:bookingCode/download
GET /voucher/:type/:bookingCode/download
```

Payment callback:
```text
POST /payments/midtrans/callback
```

Admin:
```text
/admin
/admin/laporan-keuangan
GET /documents/spk/:type/:id
GET /documents/laporan-keuangan
```

## 8. API Design

API bersifat opsional pada versi awal. Fokus utama memakai Blade dan web routes. API dapat disiapkan untuk pengembangan mobile di masa depan.

Endpoint opsional:
```text
GET /api/vehicles
GET /api/tour-packages
GET /api/airport-transfers
GET /api/hotel-shuttles
POST /api/rental-bookings
POST /api/tour-bookings
POST /api/transfer-bookings
POST /api/shuttle-bookings
POST /api/payments
```

## 9. Service Design

### BookingCodeService

Format:
```text
RNT-YYYYMMDD-0001
TOUR-YYYYMMDD-0001
TRF-YYYYMMDD-0001
SHT-YYYYMMDD-0001
```

Tanggung jawab:
- Membuat kode unik.
- Menentukan prefix.
- Mencegah duplikasi.

### BookingService

Tanggung jawab:
- Hitung total harga.
- Simpan booking.
- Set status awal.
- Trigger email.

### PaymentService

Tanggung jawab:
- Membuat payment.
- Membuat transaksi Midtrans.
- Validasi callback.
- Update status.

### NotificationService

Tanggung jawab:
- Kirim email booking.
- Kirim email payment.
- Kirim email update status.

## 10. Security Design

- Password hash.
- CSRF aktif.
- Role middleware.
- Booking ownership policy.
- Payment callback signature validation.
- Upload validation.
- Environment key di `.env`.
- Jangan expose error teknis.

## 11. Deployment Basic

Local:
```bash
composer install
npm install
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```

Production basic:
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 12. Acceptance Criteria Teknis

1. Semua migration berhasil.
2. Seeder berhasil.
3. Model relationship benar.
4. Route berjalan.
5. Customer bisa booking.
6. Admin bisa CRUD.
7. Payment berjalan.
8. Callback berjalan.
9. UI token DESIGN.md tersedia.
10. Tidak ada warna biru dominan.
11. Tidak ada gradient.
12. Tidak ada shadow berat.
