# 📊 IMPLEMENTATION PLAN: VEHICLE & DRIVER MANAGEMENT SYSTEM

**Project:** Manik Jaya Trans - Sistem Informasi Travel  
**Feature:** Manajemen Stok Kendaraan & Penugasan Driver  
**Version:** 2.2 (Revised - Payment-Based Stock + No Vehicle Status)  
**Date:** 10 Juni 2026  
**Author:** Development Team

---

## 🎯 OVERVIEW KEBUTUHAN (REVISED v2.2)

### Key Requirements:

1. **Vehicle Stock Management**
   - ✅ Tabel terpisah `vehicle_inventories` untuk tracking stock per hari
   - ✅ Kolom: `vehicle_id`, `date`, `stock`
   - ✅ **Vehicle TIDAK punya kolom `status`** - availability dari stock saja
   - ✅ **Stock berkurang HANYA jika payment `paid`**
   - ✅ **Stock dikembalikan jika booking `canceled`**
   - ✅ **Stock dikembalikan jika booking selesai sebelum akhir hari**
   - ✅ Hitung available stock: `stock - (total booking paid hari ini)`
   - ✅ User TIDAK pilih kendaraan saat booking
   - ✅ Admin assign kendaraan SETELAH user booking

2. **Driver Assignment**
   - ✅ Admin assign driver SETELAH user booking
   - ✅ Driver bisa ambil 2+ orderan per hari
   - ✅ Validasi: hanya driver `available` yang bisa ditugaskan
   - ✅ **Driver kembali `available` HANYA jika booking `completed` atau `canceled`**
   - ✅ **Status updated by admin**, bukan otomatis

3. **Booking Availability**
   - ✅ Hilangkan opsi booking jika vehicle/driver TIDAK tersedia

4. **New/Modified Tables:**
   - ✅ Tabel `vehicle_inventories` (vehicle_id, date, stock)
   - ✅ Tambah kolom `vehicle_id` & `driver_id` pada booking tour/transfer/shuttle
   - ❌ **HAPUS kolom `status` dari table `vehicles`**

5. **Payment & Stock Logic:**
   - ✅ Booking created → payment status `unpaid` → stock TIDAK berkurang
   - ✅ Payment `paid` → stock berkurang
   - ✅ Booking `canceled` → stock dikembalikan (jika sudah paid)
   - ✅ Booking `completed` sebelum akhir hari → stock dikembalikan untuk sisa hari

---

## 💡 WHY THESE CHANGES?

### 1. Remove Vehicle Status Column
**Rationale:** 
- Simplifikasi: Status vehicle redundant dengan inventory
- Single source of truth: Stock inventory menentukan availability
- Lebih flexible: Stock bisa berbeda per hari
- Avoid inconsistency: Tidak ada conflict antara status dan stock

**Before:** Vehicle.status = 'available' tapi stock = 0 → Confusing  
**After:** No status column → Check inventory.stock only

### 2. Stock Reduction Only After Payment Paid
**Rationale:**
- Prevent premature stock blocking: User booking tapi tidak bayar
- Fair system: Stock hanya reserved untuk yang sudah bayar
- Reduce abandoned bookings impact
- Real revenue tracking

**Flow:**
```
User booking → payment unpaid → stock NOT reduced (others can book)
User pay → payment paid → stock reduced (inventory secured)
User cancel (paid) → stock returned
User cancel (unpaid) → no stock impact
```

### 3. Stock Return for Short Duration Bookings
**Rationale:**
- Optimize resource utilization: Shuttle selesai jam 10 pagi, stock bisa dipakai lagi
- Maximize revenue: Same vehicle bisa ambil 2+ orderan per hari jika selesai cepat
- Real-world scenario: Transfer/shuttle typically 1-3 hours

**Example:**
```
Date: 2026-06-15
Vehicle: Avanza #1
Stock: 2

08:00-10:00: Shuttle A (paid, completed 10:00) → Stock returned 10:00
12:00-14:00: Transfer B (paid, ongoing) → Stock still locked
Result: Stock available = 1 (for afternoon bookings)
```

### 4. Driver Status Manual Update by Admin
**Rationale:**
- Admin control: Admin yang tahu real situation di lapangan
- Flexibility: Driver mungkin perlu break, maintenance, dll
- Prevent auto-errors: Observer auto-update bisa error jika edge case
- Human verification: Final decision by human

---

## 🔍 ANALISIS ARSITEKTUR SAAT INI

### Current Database Structure
- ✅ `vehicles` - Kendaraan (**HAPUS kolom `status`**, availability dari stock)
- ✅ `drivers` - Driver (sudah ada dengan status)
- ❌ `vehicle_inventories` - **PERLU DIBUAT** (vehicle_id, date, stock)
- ✅ `rental_bookings` - Sudah ada `vehicle_id` & `driver_id`
- ❌ `tour_bookings` - **BELUM ada `vehicle_id` & `driver_id`**
- ❌ `transfer_bookings` - **BELUM ada `vehicle_id` & `driver_id`**
- ❌ `shuttle_bookings` - **BELUM ada `vehicle_id` & `driver_id`**
- ✅ `payments` - Sudah ada dengan `status` field

### Payment Status (Existing)
- `unpaid` - Belum bayar (default saat booking dibuat)
- `pending` - Sedang diproses Midtrans
- `paid` - Sudah dibayar ✅ **TRIGGER: Kurangi stock**
- `failed` - Gagal
- `expired` - Kadaluarsa
- `refunded` - Refund

### Booking Status (Existing)
- `pending` - Menunggu konfirmasi admin
- `approved` - Disetujui admin
- `on_trip` - Sedang berjalan
- `completed` - Selesai ✅ **TRIGGER: Kembalikan stock (jika same day) + notify admin for driver**
- `canceled` - Dibatalkan ✅ **TRIGGER: Kembalikan stock + notify admin for driver**

### Driver Status (Existing)
- `available` - Siap menerima tugas
- `on_trip` - Sedang dalam perjalanan
- `inactive` - Tidak aktif

**Important:** Driver status diupdate oleh **admin secara manual**, tidak otomatis via observer.

### Stock Reduction Logic (NEW)

**Stock berkurang HANYA jika payment `paid`:**

```
Timeline:
1. User creates booking → Booking status = pending, Payment status = unpaid
   → Stock NOT reduced yet
   
2. User pays via Midtrans → Payment status = paid
   → Stock reduced immediately
   
3. Admin approves booking → Booking status = approved
   → No stock impact (already reduced at payment)
   
4. Booking started → Booking status = on_trip
   → No stock impact
   
5a. Booking completed (same day, short duration) → Booking status = completed
    → Stock returned for same day (shuttle/transfer case)
    
5b. Booking completed (overnight/multi-day) → Booking status = completed
    → Stock stays reduced until end of booking period
    
6. Booking canceled (payment was paid) → Booking status = canceled
   → Stock returned immediately
   
7. Booking canceled (payment was unpaid) → Booking status = canceled
   → No stock impact (never reduced)
```

### Stock Return Logic (NEW)

**Stock dikembalikan dalam kondisi:**

1. **Booking `canceled` + payment was `paid`:**
   - Kembalikan stock untuk semua tanggal booking
   - Immediate return
   
2. **Booking `completed` + duration < 1 day + completed today:**
   - Shuttle: Pickup 08:00, completed 10:00 → Return stock same day
   - Transfer: Pickup 14:00, completed 16:00 → Return stock same day
   - Allow same vehicle to be booked again for different time slot
   
3. **Booking `completed` + multi-day (rental/tour):**
   - Stock returns automatically at end of booking period
   - No manual return needed

**Logic untuk detect short duration booking:**
- Shuttle: `pickup_date` = `completed_at->toDateString()` + duration estimate 2-3 hours
- Transfer: `pickup_date` = `completed_at->toDateString()` + duration estimate 2-3 hours
- Rental: Always multi-day (`start_date` to `end_date`)
- Tour: Could be same day or multi-day (check `travel_date` vs duration)

---

## 📅 IMPLEMENTATION PHASES

---

## Phase 1: Database Design & Migration

### 1.1 Remove `status` Column from `vehicles` Table

**Migration File:** `2026_06_10_000001_remove_status_from_vehicles.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->enum('status', ['available', 'maintenance', 'inactive'])
                  ->default('available')
                  ->after('capacity');
        });
    }
};
```

**Note:** Setelah migration ini, vehicle availability 100% ditentukan dari `vehicle_inventories`.

---

### 1.2 Create New Table: `vehicle_inventories`

**Migration File:** `2026_06_10_000002_create_vehicle_inventories_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')
                  ->constrained('vehicles')
                  ->onDelete('cascade');
            $table->date('date');
            $table->integer('stock')->default(1);
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['vehicle_id', 'date'], 'unique_vehicle_date');
            
            // Indexes for performance
            $table->index('vehicle_id', 'idx_vehicle_id');
            $table->index('date', 'idx_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_inventories');
    }
};
```

**Business Rules:**
- Setiap vehicle memiliki stock untuk tanggal tertentu
- Jika tidak ada record untuk tanggal X, anggap stock = 0 (tidak tersedia)
- Admin mengatur stock untuk tanggal-tanggal tertentu
- Available stock = `stock - COUNT(bookings with payment paid)`
- UNIQUE constraint pada (vehicle_id, date) mencegah duplikasi

**Example Data:**
```
vehicle_id | date       | stock | available (calculated)
-----------|------------|-------|----------------------
1          | 2026-06-15 | 3     | 1 (3 - 2 paid bookings)
1          | 2026-06-16 | 3     | 3 (no bookings)
1          | 2026-06-17 | 2     | 0 (2 paid bookings)
2          | 2026-06-15 | 5     | 5 (no bookings)
```

---

## 📢 STATUS UPDATE (10 JUNI 2026)

> **Implementasi Phase 1 hingga Phase 6 telah SELESAI.**

Seluruh struktur kode, database, observer, *service layer*, validasi *frontend*, dan juga *admin panel* (Filament) telah dimodifikasi agar sesuai dengan rancangan v2.2 ini.

**Ringkasan Kondisi Saat Ini (Per 10 Juni 2026):**
1. **Frontend:** Sudah tidak mengecek `status` kendaraan (mencegah *crash*). Validasi *booking* menggunakan fungsi `isAvailableForDateRange()`.
2. **Backend (Admin Panel):** 
   - Halaman daftar kendaraan tidak lagi menampilkan/memfilter status.
   - Admin bisa mengatur stok lewat manajer relasi **"Inventaris / Stok Kendaraan"** saat mengedit kendaraan.
   - Ditambahkan fitur **Atur Stok Beberapa Hari (Bulk Creation)** untuk memudahkan pembuatan data stok beberapa hari sekaligus.
   - Tersedia field `completed_at` (terkunci) pada semua form pesanan. Jika pesanan di-*revert* dari status *Completed*, nilai ini otomatis kembali menjadi *null*.
3. **Logika Stok (Observer):** Sistem pengembalian dan pelacakan pembayaran *paid* sudah terhubung.
4. **Verifikasi:** Seluruh sistem telah lulus pengujian browser dan terminal (Phase 7 selesai).

**Status Akhir:** ✅ **Selesai 100% dan Siap Production.**

---

