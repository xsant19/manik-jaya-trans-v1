# Changelog: Perubahan Sistem Penugasan Supir

**Tanggal**: 1 Juni 2026  
**Versi**: 1.0.1  
**Tipe**: Business Logic Update

---

## 📋 Ringkasan Perubahan

Menghilangkan pemilihan supir dari form pemesanan kendaraan di frontend customer. Supir sekarang akan ditugaskan oleh admin melalui Filament admin panel.

---

## 🎯 Alasan Perubahan

1. **Sewa kendaraan include supir** - Tidak ada opsi lepas kunci
2. **Penugasan supir lebih baik dilakukan oleh admin** - Admin memiliki informasi lebih lengkap tentang ketersediaan dan jadwal supir
3. **Menyederhanakan proses booking customer** - Customer tidak perlu memilih supir saat booking
4. **Meningkatkan fleksibilitas operasional** - Admin dapat menugaskan atau mengubah supir sesuai kebutuhan operasional

---

## 🔧 Perubahan Teknis

### 1. Frontend (View)
**File**: `resources/views/frontend/booking/rental/create.blade.php`

**Dihapus**:
- Dropdown pemilihan supir
- Label "Supir (Opsional)"
- Opsi "Tanpa Supir (Lepas Kunci)"
- Daftar supir yang tersedia
- Teks bantuan "Tinggalkan kosong jika menyewa lepas kunci"

### 2. Controller
**File**: `app/Http/Controllers/Booking/RentalBookingController.php`

**Perubahan**:
- **Method `create()`**: Menghapus query untuk mengambil daftar driver
- **Method `store()`**: Mengubah `driver_id` dari `$validated['driver_id'] ?? null` menjadi `null` dengan komentar "Driver will be assigned by admin"

### 3. Form Request Validation
**File**: `app/Http/Requests/StoreRentalBookingRequest.php`

**Dihapus**:
- Validasi field `driver_id`
- Rule untuk memeriksa ketersediaan driver

### 4. Dokumentasi

#### SRS.md (Software Requirements Specification)
- **Section 3.2**: Menambahkan batasan customer tidak dapat memilih supir
- **Section 3.3**: Menambahkan kemampuan admin untuk menugaskan supir
- **Section 5.9**: Menghapus field `driver_id` dari validasi booking kendaraan
- **Section 5.9**: Menambahkan behavior bahwa `driver_id` default null dan supir ditugaskan via admin

#### SDD.md (System Design Document)
- **Section 5.7**: Menambahkan catatan bahwa `driver_id` default null saat booking dibuat
- **Section 5.7**: Menambahkan catatan bahwa admin menugaskan supir melalui Filament
- **Section 5.7**: Menambahkan catatan bahwa sewa kendaraan include supir

#### PRD.md (Product Requirements Document)
- **Section 5.2**: Menambahkan batasan customer tidak dapat memilih supir
- **Section 5.3**: Menambahkan kemampuan admin menugaskan supir
- **Section 6.3**: Menambahkan fitur admin untuk menugaskan supir
- **Section 7.2**: Menambahkan step bahwa driver_id diset null untuk rental booking
- **Section 7.3**: Menambahkan step admin menugaskan supir

#### claude.md (Developer Documentation)
- **Section User Roles - Customer**: Menambahkan batasan tidak dapat memilih supir
- **Section User Roles - Admin**: Menambahkan kemampuan menugaskan supir
- **Section Validation Rules**: Menghapus validasi driver_id
- **Section Business Logic**: Menambahkan catatan bahwa sewa kendaraan include supir

#### agents.md (AI Agent Instructions)
- **Section 4.2**: Menambahkan catatan penting tentang rental booking dan penugasan supir
- **Section 16**: Menambahkan poin penting untuk agent saat mengerjakan backend

---

## 📊 Database Schema

**Tidak ada perubahan pada database schema**. Field `driver_id` tetap ada di tabel `rental_bookings` sebagai foreign key nullable.

```sql
driver_id BIGINT UNSIGNED NULL
FOREIGN KEY (driver_id) REFERENCES drivers(id) ON DELETE SET NULL
```

**Behavior**:
- Saat customer membuat booking: `driver_id = NULL`
- Admin menugaskan supir via Filament: `driver_id = [id_supir]`
- Jika supir dihapus: `driver_id = NULL` (ON DELETE SET NULL)

---

## 🔄 Flow Proses Baru

### Customer Flow
1. Customer login
2. Customer pilih kendaraan
3. Customer klik "Booking Sekarang"
4. Customer isi form booking (tanpa pilih supir)
5. Customer submit booking
6. Sistem buat booking dengan `driver_id = NULL`
7. Customer dapat melihat detail booking

### Admin Flow
1. Admin login ke Filament
2. Admin buka menu "Rental Bookings"
3. Admin pilih booking yang perlu ditugaskan supir
4. Admin edit booking
5. Admin pilih supir dari dropdown (hanya supir dengan status "available")
6. Admin save perubahan
7. Supir berhasil ditugaskan ke booking

---

## ✅ Testing Checklist

- [x] Form booking kendaraan tidak menampilkan dropdown supir
- [x] Customer dapat membuat booking tanpa memilih supir
- [x] Booking tersimpan dengan `driver_id = NULL`
- [x] Admin dapat menugaskan supir melalui Filament
- [x] Validasi form tidak memeriksa `driver_id`
- [x] Dokumentasi telah diperbarui
- [x] Routes masih berfungsi dengan baik

---

## 📝 Catatan Penting

1. **Backward Compatibility**: Perubahan ini tidak mempengaruhi booking yang sudah ada. Booking lama yang sudah memiliki `driver_id` tetap valid.

2. **Admin Panel**: Pastikan Filament resource untuk `RentalBooking` memiliki field `driver_id` yang dapat diedit oleh admin.

3. **Email Notification**: Email notifikasi booking tidak perlu diubah karena informasi supir tidak ditampilkan di email awal (hanya ditampilkan setelah admin menugaskan).

4. **Future Enhancement**: Jika diperlukan, admin dapat menambahkan notifikasi email otomatis ke customer saat supir ditugaskan.

---

## 🔗 File yang Diubah

1. `resources/views/frontend/booking/rental/create.blade.php`
2. `app/Http/Controllers/Booking/RentalBookingController.php`
3. `app/Http/Requests/StoreRentalBookingRequest.php`
4. `docs/SRS.md`
5. `docs/SDD.md`
6. `docs/PRD.md`
7. `claude.md`
8. `agents.md`

---

## 👥 Impact Analysis

### Customer Impact
- ✅ **Positif**: Proses booking lebih sederhana
- ✅ **Positif**: Tidak perlu memikirkan pemilihan supir
- ⚠️ **Netral**: Customer tidak tahu supir siapa yang akan ditugaskan sampai admin mengkonfirmasi

### Admin Impact
- ✅ **Positif**: Kontrol penuh atas penugasan supir
- ✅ **Positif**: Dapat mengoptimalkan jadwal supir
- ⚠️ **Netral**: Perlu menugaskan supir secara manual untuk setiap booking

### Developer Impact
- ✅ **Positif**: Kode lebih sederhana
- ✅ **Positif**: Validasi lebih sedikit
- ✅ **Positif**: Dokumentasi lebih jelas

---

## 🚀 Deployment Notes

Tidak ada migration baru yang diperlukan. Perubahan ini hanya mempengaruhi:
- Frontend view
- Controller logic
- Validation rules
- Dokumentasi

**Deployment Steps**:
1. Pull latest code
2. Clear cache: `php artisan optimize:clear`
3. Rebuild assets: `npm run build`
4. Restart server (jika menggunakan queue worker)

---

**Prepared by**: AI Agent (Kiro)  
**Reviewed by**: [Pending]  
**Approved by**: [Pending]
