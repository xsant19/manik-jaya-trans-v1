# Changelog — Factory Migration

**Date**: 8 Juni 2026  
**Version**: 1.1.1  
**Type**: Refactoring — Data Seeding Strategy

---

## 📦 What Changed?

Migrasi dari **manual seeders** ke **Laravel Factories** untuk data generation yang lebih flexible dan maintainable.

---

## ✅ Changes Made

### 1. **New Factories Created**

Created 5 factory classes to replace manual seeders:

#### VehicleFactory
- **Path**: `database/factories/VehicleFactory.php`
- **Features**:
  - 15 realistic vehicle names
  - 5 vehicle types (sedan, suv, mpv, minibus, bus)
  - Capacity-based pricing strategy
  - States: `available()`, `maintenance()`, `inactive()`, `ofType()`

#### DriverFactory
- **Path**: `database/factories/DriverFactory.php`
- **Features**:
  - Realistic Indonesian names
  - Indonesian phone format (08XXXXXXXXXX)
  - Auto-generated license numbers (DRV-YYYY-XXXX)
  - States: `available()`, `onTrip()`, `inactive()`

#### TourPackageFactory
- **Path**: `database/factories/TourPackageFactory.php`
- **Features**:
  - 12 realistic tour package names
  - Duration-based pricing (half day, full day, multi day)
  - Auto-generated detailed itineraries
  - States: `active()`, `inactive()`

#### AirportTransferFactory ⭐ NEW
- **Path**: `database/factories/AirportTransferFactory.php`
- **Features**:
  - 8 real airport transfer routes (Ngurah Rai → various destinations)
  - Realistic pricing based on distance
  - Estimated duration for each route
  - States: `active()`, `inactive()`

#### HotelShuttleFactory ⭐ NEW
- **Path**: `database/factories/HotelShuttleFactory.php`
- **Features**:
  - 10 hotel shuttle routes (various locations → Ngurah Rai)
  - Cheaper than airport transfer (shared shuttle concept)
  - Estimated duration for each route
  - States: `active()`, `inactive()`

---

### 2. **Seeders Removed**

Deleted 5 manual seeder files (replaced by factories):

- ❌ `VehicleSeeder.php` → ✅ `VehicleFactory.php`
- ❌ `DriverSeeder.php` → ✅ `DriverFactory.php`
- ❌ `TourPackageSeeder.php` → ✅ `TourPackageFactory.php`
- ❌ `AirportTransferSeeder.php` → ✅ `AirportTransferFactory.php`
- ❌ `HotelShuttleSeeder.php` → ✅ `HotelShuttleFactory.php`

**Kept**: `AdminSeeder.php` (required for admin user)

---

### 3. **DatabaseSeeder Updated**

**Before**:
```php
$this->call([
    AdminSeeder::class,
    VehicleSeeder::class,
    DriverSeeder::class,
    TourPackageSeeder::class,
    AirportTransferSeeder::class,
    HotelShuttleSeeder::class,
]);
```

**After**:
```php
// Seed Admin User only
$this->call([
    AdminSeeder::class,
]);

// Generate data using factories
Vehicle::factory()->count(15)->create();
Driver::factory()->count(12)->create();
TourPackage::factory()->count(10)->create();
AirportTransfer::factory()->count(8)->create();
HotelShuttle::factory()->count(10)->create();
```

---

### 4. **Documentation Created**

- ✅ `FACTORY_SETUP.md` — Comprehensive factory documentation
- ✅ `CHANGELOG_FACTORY_MIGRATION.md` — This file
- ✅ Updated `AGENTS.md` — Section 11, 12, 17

---

## 🎯 Benefits

### Before (Manual Seeders)
- ❌ Hardcoded data, tidak flexible
- ❌ Tidak bisa digunakan untuk testing
- ❌ Sulit modify/customize data
- ❌ Setiap perubahan perlu edit seeder manually

### After (Factories)
- ✅ **Flexible**: Generate berbagai kombinasi dengan states
- ✅ **Reusable**: Digunakan untuk seeding DAN testing
- ✅ **Maintainable**: Lebih mudah update structure
- ✅ **Realistic**: Data lebih varied dan realistic
- ✅ **DRY**: Single source of truth untuk data generation

---

## 📊 Default Data Generated

When running `php artisan migrate:fresh --seed`:

| Model            | Count | Source           |
|------------------|-------|------------------|
| Admin User       | 1     | AdminSeeder      |
| Vehicles         | 15    | VehicleFactory   |
| Drivers          | 12    | DriverFactory    |
| Tour Packages    | 10    | TourPackageFactory |
| Airport Transfers| 8     | AirportTransferFactory |
| Hotel Shuttles   | 10    | HotelShuttleFactory |

**Total**: 56 records (56 data dummy untuk testing)

---

## 🧪 Testing

Factories dapat digunakan dalam testing:

```php
public function test_booking_flow()
{
    // Arrange
    $vehicle = Vehicle::factory()->available()->create();
    $user = User::factory()->create(['role' => 'customer']);
    
    // Act & Assert
    $response = $this->actingAs($user)
        ->post(route('booking.vehicle.store', $vehicle->id), [...]);
    
    $response->assertRedirect();
}
```

---

## 🔄 Migration Guide

### For Developers

**No changes required** untuk existing code! Factories hanya affect data seeding:

1. Run migration as usual:
   ```bash
   php artisan migrate:fresh --seed
   ```

2. Data akan di-generate oleh factories (bukan seeders)

3. Testing now easier dengan factory states:
   ```php
   Vehicle::factory()->available()->count(5)->create();
   ```

### For Production

**No impact** — Factories hanya untuk development/testing environment.

---

## 📝 Usage Examples

### Seeding with Custom States

```php
// Generate only available vehicles
Vehicle::factory()->available()->count(10)->create();

// Generate only sedan type
Vehicle::factory()->ofType('sedan')->count(5)->create();

// Generate available drivers
Driver::factory()->available()->count(8)->create();

// Generate active tour packages
TourPackage::factory()->active()->count(5)->create();

// Mix and match
Vehicle::factory()->count(10)->create(['status' => 'available']);
```

### Using in Tinker

```bash
php artisan tinker

# Quick test data
Vehicle::factory()->count(5)->create();
Driver::factory()->available()->count(3)->create();

# With specific attributes
TourPackage::factory()->create([
    'name' => 'Custom Tour',
    'price' => 500000,
]);
```

---

## ✅ Verified

- ✅ `php artisan migrate:fresh --seed` — **SUCCESS**
- ✅ All 5 factories working correctly
- ✅ Data generated with realistic values
- ✅ No errors or warnings
- ✅ Admin login works (admin@manikjaya.test / password)
- ✅ Filament admin panel accessible
- ✅ All relationships intact

---

## 🔗 Related Files

**Created**:
- `database/factories/AirportTransferFactory.php`
- `database/factories/HotelShuttleFactory.php`
- `FACTORY_SETUP.md`
- `CHANGELOG_FACTORY_MIGRATION.md`

**Modified**:
- `database/seeders/DatabaseSeeder.php`
- `AGENTS.md`

**Deleted**:
- `database/seeders/VehicleSeeder.php`
- `database/seeders/DriverSeeder.php`
- `database/seeders/TourPackageSeeder.php`
- `database/seeders/AirportTransferSeeder.php`
- `database/seeders/HotelShuttleSeeder.php`

**Kept**:
- `database/seeders/AdminSeeder.php` (required)

---

## 📚 References

- `FACTORY_SETUP.md` — Detailed factory documentation
- `AGENTS.md` — Section 11 (Data Seeding Strategy)
- [Laravel Factory Docs](https://laravel.com/docs/11.x/eloquent-factories)

---

**Migration completed successfully** ✅
