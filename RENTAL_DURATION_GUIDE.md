# Panduan Durasi Sewa Kendaraan

**Sistem**: Manik Jaya Trans  
**Update**: 10 Juni 2026  
**Status**: Definisi Resmi

---

## 📋 Definisi Durasi Rental

### Full Day (Sewa Harian Penuh)
- **Durasi**: 12 Jam
- **Harga**: Menggunakan `vehicle->price_full_day`
- **Database Field**: `rental_type = 'full_day'`

### Half Day (Sewa Setengah Hari)
- **Durasi**: 6 Jam
- **Harga**: Menggunakan `vehicle->price_half_day`
- **Database Field**: `rental_type = 'half_day'`

---

## 💻 Implementasi di Code

### Backend Service (BookingService)

```php
// Perhitungan harga rental booking
if ($rentalBooking->rental_type === 'full_day') {
    $totalPrice = $vehicle->price_full_day;  // 12 jam
} else {
    $totalPrice = $vehicle->price_half_day;  // 6 jam
}
```

### Frontend Display

**List/Card View:**
```blade
<div class="price-info">
    <p>Full Day (12 jam): Rp {{ number_format($vehicle->price_full_day) }}</p>
    <p>Half Day (6 jam): Rp {{ number_format($vehicle->price_half_day) }}</p>
</div>
```

**Form Booking:**
```blade
<select name="rental_type" required>
    <option value="full_day">Full Day (12 jam) - Rp {{ number_format($vehicle->price_full_day) }}</option>
    <option value="half_day">Half Day (6 jam) - Rp {{ number_format($vehicle->price_half_day) }}</option>
</select>
```

---

## 📝 Catatan Penting

### Yang Termasuk dalam Harga
- ✅ Supir profesional (ditugaskan oleh admin)
- ✅ Bensin
- ✅ Parkir
- ✅ Asuransi dasar kendaraan

### Yang TIDAK Termasuk
- ❌ Biaya parkir di tempat wisata khusus (jika ada)
- ❌ Biaya masuk objek wisata
- ❌ Makanan/minuman untuk supir dan penumpang

### Aturan Rental
1. **Customer TIDAK memilih supir** saat booking
2. Admin menugaskan supir setelah booking diapprove
3. Semua sewa kendaraan include supir (tidak ada opsi lepas kunci)
4. Waktu dihitung mulai dari waktu penjemputan

---

## 🔍 Referensi Dokumentasi

Definisi ini berlaku di semua file dokumentasi berikut:

- ✅ `README.md`
- ✅ `agents.md`
- ✅ `claude.md`
- ✅ `docs/SRS.md`
- ✅ `docs/SDD.md`
- ✅ `docs/PRD.md`
- ✅ `docs/UI_UX_Flow.md`
- ✅ `CHANGELOG_RECENT_UPDATES.md`

**Last Updated**: 10 Juni 2026

---

## ✅ Checklist Implementasi

Saat mengimplementasikan fitur rental booking, pastikan:

- [ ] Form menampilkan "(12 jam)" untuk Full Day
- [ ] Form menampilkan "(6 jam)" untuk Half Day
- [ ] Harga sesuai dengan rental_type yang dipilih
- [ ] Validasi rental_type hanya menerima 'full_day' atau 'half_day'
- [ ] Dokumentasi internal code menyebutkan durasi
- [ ] Email notifikasi menyebutkan durasi jika relevan
- [ ] Invoice/Voucher PDF menampilkan durasi yang jelas

---

**Kontak untuk Perubahan**: Development Team  
**Approval**: Project Manager / Product Owner
