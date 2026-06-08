# Factory Setup Documentation

## Overview

Proyek ini menggunakan **Laravel Factories** untuk generate data dummy/testing, menggantikan seeders manual. Factories memberikan fleksibilitas lebih tinggi dan kode yang lebih maintainable.

---

## 📦 Available Factories

### 1. **VehicleFactory**
**Path**: `database/factories/VehicleFactory.php`

**Features**:
- 15 realistic vehicle names (Toyota Avanza, Honda Jazz, dll)
- 5 vehicle types: sedan, suv, mpv, minibus, bus
- Capacity-based pricing strategy
- Random status: available (70%), maintenance (20%), inactive (10%)
- Image placeholder support

**States**:
- `->available()` — Force status available
- `->maintenance()` — Force status maintenance
- `->inactive()` — Force status inactive
- `->ofType('sedan')` — Force specific vehicle type

**Example**:
```php
Vehicle::factory()->count(10)->create();
Vehicle::factory()->available()->ofType('sedan')->create();
```

---

### 2. **DriverFactory**
**Path**: `database/factories/DriverFactory.php`

**Features**:
- Realistic Indonesian names
- Indonesian phone format: 08XXXXXXXXXX (11-13 digits)
- Auto-generated license numbers: DRV-YYYY-XXXX
- Random status: available (60%), on_trip (30%), inactive (10%)
- Random experience: 1-15 years

**States**:
- `->available()` — Force status available
- `->onTrip()` — Force status on_trip
- `->inactive()` — Force status inactive

**Example**:
```php
Driver::factory()->count(12)->create();
Driver::factory()->available()->create();
```

---

### 3. **TourPackageFactory**
**Path**: `database/factories/TourPackageFactory.php`

**Features**:
- 12 realistic tour package names (Ubud Culture Tour, Tanah Lot Sunset, dll)
- Duration-based pricing:
  - Half day (4-6 hours): Rp 350.000 - Rp 550.000
  - Full day (8-10 hours): Rp 650.000 - Rp 950.000
  - Multi day (2-3 days): Rp 1.500.000 - Rp 2.500.000
- Auto-generated detailed itineraries
- Random status: active (75%), inactive (25%)
- Image placeholder support

**States**:
- `->active()` — Force status active
- `->inactive()` — Force status inactive

**Example**:
```php
TourPackage::factory()->count(10)->create();
TourPackage::factory()->active()->create();
```

---

### 4. **AirportTransferFactory**
**Path**: `database/factories/AirportTransferFactory.php`

**Features**:
- 8 real airport transfer routes (Ngurah Rai - Kuta, Seminyak, Ubud, dll)
- Realistic pricing based on distance
- Estimated duration for each route
- Random status: active (75%), inactive (25%)

**States**:
- `->active()` — Force status active
- `->inactive()` — Force status inactive

**Example**:
```php
AirportTransfer::factory()->count(8)->create();
AirportTransfer::factory()->active()->create();
```

---

### 5. **HotelShuttleFactory**
**Path**: `database/factories/HotelShuttleFactory.php`

**Features**:
- 10 hotel shuttle routes (Kuta - Bandara, Seminyak - Bandara, dll)
- Cheaper than airport transfer (shared shuttle concept)
- Estimated duration for each route
- Random status: active (75%), inactive (25%)

**States**:
- `->active()` — Force status active
- `->inactive()` — Force status inactive

**Example**:
```php
HotelShuttle::factory()->count(10)->create();
HotelShuttle::factory()->active()->create();
```

---

## 🚀 Usage

### 1. **Seeding Database**

Standard seeding (akan generate data default):
```bash
php artisan migrate:fresh --seed
```

Data yang di-generate:
- 1 Admin user (via AdminSeeder)
- 15 Vehicles
- 12 Drivers
- 10 Tour Packages
- 8 Airport Transfers
- 10 Hotel Shuttles

---

### 2. **Custom Seeding in Tinker**

```bash
php artisan tinker
```

```php
// Generate specific amount
Vehicle::factory()->count(5)->create();
Driver::factory()->count(3)->create();

// With states
Vehicle::factory()->available()->ofType('sedan')->count(3)->create();
Driver::factory()->available()->count(5)->create();
TourPackage::factory()->active()->create();

// Mix and match
Vehicle::factory()->count(10)->create([
    'status' => 'available',
]);
```

---

### 3. **Testing**

Factories sangat berguna untuk testing:

```php
public function test_booking_vehicle()
{
    $vehicle = Vehicle::factory()->available()->create();
    $user = User::factory()->create(['role' => 'customer']);
    
    // Test booking logic here...
}
```

---

## 📁 Seeders

Setelah refactoring, hanya **1 seeder** yang tersisa:

### AdminSeeder
**Path**: `database/seeders/AdminSeeder.php`

**Purpose**: Create admin user untuk login ke Filament admin panel.

**Credentials**:
- Email: `admin@manikjaya.test`
- Password: `password`
- Role: `admin`

**Why keep this seeder?**
Admin user harus tetap sama untuk consistency. Menggunakan factory untuk admin user tidak diperlukan karena hanya 1 admin default.

---

## 🔧 Customization

### Modifying Factory Data

Edit file factory yang sesuai di `database/factories/`:

**Example**: Menambah vehicle baru di `VehicleFactory.php`:
```php
$vehicleData = [
    // ... existing vehicles
    [
        'name' => 'Suzuki Ertiga',
        'type' => 'mpv',
        'capacity' => 7,
    ],
];
```

### Modifying Default Seed Count

Edit `database/seeders/DatabaseSeeder.php`:
```php
Vehicle::factory()->count(20)->create(); // Change from 15 to 20
```

---

## ✅ Benefits of Using Factories

1. **Flexible**: Dapat generate berbagai kombinasi data dengan mudah
2. **Reusable**: Digunakan untuk seeding DAN testing
3. **Maintainable**: Lebih mudah update/modify data structure
4. **Realistic**: Data yang di-generate lebih realistis dan varied
5. **States**: Dapat force specific conditions dengan states
6. **DRY**: Tidak perlu duplicate data definition

---

## 🛠 Troubleshooting

### Factory not found
```bash
composer dump-autoload
```

### Price casting error
Factories sudah menggunakan integer untuk price (will be cast to decimal automatically by model).

### Unique constraint violation
Factories menggunakan static index untuk prevent duplicate pada route names.

---

## 📚 References

- [Laravel Factory Documentation](https://laravel.com/docs/11.x/eloquent-factories)
- [Database Testing](https://laravel.com/docs/11.x/database-testing)
- Project: `AGENTS.md` section 11 (Konvensi Kode)
