# 🔑 KEY CHANGES: Vehicle Inventory System v2.2

**Date:** 10 Juni 2026  
**Status:** Implemented (Phase 1-6 Selesai, Phase 7 Pending Testing)

---

## 🎯 CRITICAL CHANGES FROM PREVIOUS VERSION

### 1. ❌ Remove Vehicle `status` Column

**Action:** Drop `status` column from `vehicles` table  
**Reason:** Availability determined 100% from inventory stock

**Migration:**
```php
Schema::table('vehicles', function (Blueprint $table) {
    $table->dropColumn('status');
});
```

**Impact:**
- Vehicle model: Remove `status` from fillable
- Queries: Replace `where('status', 'available')` with inventory checks
- Admin panel: Remove status filter/field

---

### 2. 💰 Stock Reduction ONLY After Payment Paid

**Rule:** Stock berkurang hanya jika `payment.status = 'paid'`

**Flow:**
```
Booking Created → payment = 'unpaid' → Stock NOT reduced ❌
Payment Success → payment = 'paid' → Stock reduced ✅
Booking Canceled (paid) → Stock returned ✅
Booking Canceled (unpaid) → No stock impact (never reduced)
```

**Implementation:** Observer on `Payment` model, not `Booking` model

---

### 3. ⏰ Stock Return for Same-Day Completions

**Rule:** Jika booking selesai di hari yang sama (shuttle/transfer 2 jam), kembalikan stock

**Logic:**
```php
// Example: Shuttle
Pickup: 2026-06-15 08:00
Completed: 2026-06-15 10:00
→ Return stock for 2026-06-15 (allow afternoon bookings)

// Example: Rental (overnight)
Start: 2026-06-15
End: 2026-06-17
Completed: 2026-06-17 18:00
→ NO return (multi-day booking, stock consumed for all days)
```

**Detection:**
```php
// Check if same day completion
$isShortDuration = $booking->pickup_date->isSameDay($booking->completed_at)
                && in_array(get_class($booking), [ShuttleBooking::class, TransferBooking::class]);
```

---

### 4. 👤 Driver Status Manual Update by Admin

**Rule:** Driver status TIDAK auto-update via observer, **admin update manual**

**Reason:**
- Admin knows real field situation
- Driver might need break, maintenance
- Prevent auto-update errors

**Implementation:**
- Remove `BookingStatusObserver` untuk driver status update
- Admin manually changes driver status via Filament
- Keep observer only for notifications/logs

---

## 📊 NEW DATABASE SCHEMA

### `vehicle_inventories` Table
```sql
CREATE TABLE vehicle_inventories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    vehicle_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    stock INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    UNIQUE KEY unique_vehicle_date (vehicle_id, date),
    INDEX idx_vehicle_id (vehicle_id),
    INDEX idx_date (date),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE
);
```

### Modified Booking Tables
```sql
-- tour_bookings
ALTER TABLE tour_bookings 
ADD COLUMN vehicle_id BIGINT UNSIGNED NULL AFTER tour_package_id,
ADD COLUMN driver_id BIGINT UNSIGNED NULL AFTER vehicle_id,
ADD COLUMN completed_at TIMESTAMP NULL AFTER booking_status,
ADD FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE SET NULL,
ADD FOREIGN KEY (driver_id) REFERENCES drivers(id) ON DELETE SET NULL;

-- Same for transfer_bookings, shuttle_bookings
```

**New Column:** `completed_at` - untuk track exact completion time (needed for same-day stock return)

---

## 🔄 STOCK FLOW DIAGRAM

```
┌─────────────────┐
│ User Books      │
│ payment=unpaid  │
│ Stock: NO CHANGE│
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ User Pays       │
│ payment=paid    │
│ Stock: -1       │◄─── TRIGGER POINT
└────────┬────────┘
         │
         ├──────────────────┬──────────────────┐
         ▼                  ▼                  ▼
┌─────────────┐    ┌─────────────┐    ┌──────────────┐
│ Cancel      │    │ Complete    │    │ Complete     │
│ (any time)  │    │ (same day)  │    │ (multi-day)  │
│ Stock: +1   │    │ Stock: +1   │    │ Stock: auto  │
│             │    │ (today only)│    │ (end date)   │
└─────────────┘    └─────────────┘    └──────────────┘
```

---

## 🛠️ IMPLEMENTATION PRIORITIES

### Phase 1: Database (HIGH - 4 hours)
1. ✅ Migration: Remove vehicle status
2. ✅ Migration: Create vehicle_inventories
3. ✅ Migration: Add vehicle_id, driver_id, completed_at to bookings

### Phase 2: Models (HIGH - 3 hours)
1. ✅ VehicleInventory model
2. ✅ Vehicle model: Remove status, add inventory methods
3. ✅ Booking models: Add relationships, completed_at cast

### Phase 3: Observer Pattern (HIGH - 4 hours)
1. ✅ PaymentObserver: Handle stock reduction on payment paid
2. ✅ BookingObserver: Handle stock return on cancel/complete
3. ✅ Remove driver auto-status logic

### Phase 4: Services (MEDIUM - 3 hours)
1. ✅ VehicleAvailabilityService: Check stock based on paid bookings only
2. ✅ StockManagementService: Handle stock reduction/return logic

### Phase 5: Admin Panel (MEDIUM - 4 hours)
1. ✅ Vehicle Resource: Remove status field
2. ✅ Inventory RelationManager: CRUD for vehicle_inventories
3. ✅ Booking Resources: Add completed_at field
4. ✅ Driver Resource: Manual status change

### Phase 6: Frontend (LOW - 2 hours)
1. ✅ Update availability checks (no vehicle status filter)
2. ✅ Update booking forms

### Phase 7: Testing (LOW - 4 hours)
1. ⏳ Test payment paid → stock reduction
2. ⏳ Test same-day complete → stock return
3. ⏳ Test cancel → stock return

---

## 🧪 TESTING SCENARIOS

### Scenario 1: Unpaid Booking (No Stock Impact)
```
1. User books shuttle for 2026-06-15 (payment unpaid)
2. Check inventory: stock should NOT decrease
3. User cancels booking
4. Check inventory: no change (never reduced)
✅ Expected: Stock unchanged throughout
```

### Scenario 2: Paid Booking → Cancel (Stock Return)
```
1. User books shuttle for 2026-06-15
2. User pays → payment.status = 'paid'
3. Check inventory: stock decreased by 1
4. Admin cancels booking
5. Check inventory: stock returned (+1)
✅ Expected: Stock back to original
```

### Scenario 3: Same-Day Completion (Stock Return)
```
1. User books shuttle for 2026-06-15 08:00
2. User pays → stock decreased
3. Shuttle completed at 10:00 (same day)
4. Admin marks booking completed
5. Check inventory for 2026-06-15: stock returned (+1)
✅ Expected: Stock available for afternoon bookings
```

### Scenario 4: Multi-Day Booking (No Immediate Return)
```
1. User books rental 2026-06-15 to 2026-06-17
2. User pays → stock decreased for all 3 days
3. Rental completed on 2026-06-17 18:00
4. Check inventory: stock NOT returned (consumed full period)
✅ Expected: Stock consumed for entire rental period
```

---

## ⚠️ BREAKING CHANGES

### 1. Vehicle Model
```php
// BEFORE
Vehicle::where('status', 'available')->get();

// AFTER
Vehicle::all()->filter(fn($v) => $v->hasInventoryForDate($date));
```

### 2. Booking Logic
```php
// BEFORE
// Stock reduced on booking creation

// AFTER
// Stock reduced only on payment paid (observer)
```

### 3. Driver Status
```php
// BEFORE
// Auto-update via observer when booking completed

// AFTER
// Manual update by admin via Filament
```

---

## 📚 RELATED FILES

- `app/Models/Vehicle.php` - Remove status logic
- `app/Models/VehicleInventory.php` - NEW
- `app/Models/Payment.php` - Add stock reduction trigger
- `app/Observers/PaymentObserver.php` - NEW (handle stock on paid)
- `app/Observers/BookingObserver.php` - UPDATE (handle stock return, remove driver auto-status)
- `app/Services/StockManagementService.php` - NEW (centralized stock logic)
- `database/migrations/2026_06_10_*` - NEW migrations

---

**Last Updated:** 10 Juni 2026  
**Version:** 2.2 (Finalized)

