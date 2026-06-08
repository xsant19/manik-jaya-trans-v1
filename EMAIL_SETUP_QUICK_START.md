# 📧 Email Setup - Quick Start Guide

Panduan cepat untuk mengaktifkan email notification system.

---

## ⚡ Quick Setup (5 Menit)

### Step 1: Update `.env` File

Tambahkan konfigurasi email berikut di file `.env`:

```env
# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=manikjayatrans@gmail.com
MAIL_PASSWORD=your_app_password_here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@manikjayatrans.com"
MAIL_FROM_NAME="Manik Jaya Trans"

# Admin Email (Penerima Notifikasi Booking)
MAIL_ADMIN_ADDRESS="manikjayatrans@gmail.com"
```

---

### Step 2: Generate Gmail App Password

**Jika menggunakan Gmail, WAJIB menggunakan App Password (bukan password biasa):**

1. **Login ke Gmail:** manikjayatrans@gmail.com
2. **Buka Google Account:** https://myaccount.google.com/
3. **Security → 2-Step Verification** (Aktifkan jika belum)
4. **App passwords:** https://myaccount.google.com/apppasswords
5. **Generate App Password:**
   - Select app: **Mail**
   - Select device: **Other (Custom name)**
   - Name: **Manik Jaya Trans Website**
   - Click **Generate**
6. **Copy 16-digit password** (format: xxxx xxxx xxxx xxxx)
7. **Paste ke `.env`** di field `MAIL_PASSWORD` (tanpa spasi)

**Example:**
```env
MAIL_PASSWORD=abcdabcdabcdabcd
```

---

### Step 3: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

---

### Step 4: Test Email

**Option A: Via Tinker (Quick Test)**

```bash
php artisan tinker
```

```php
Mail::raw('Test email from Manik Jaya Trans', function($message) {
    $message->to('manikjayatrans@gmail.com')
            ->subject('Test Email');
});

echo "Email sent! Check inbox.";
exit;
```

**Option B: Via Real Booking**

1. Login sebagai customer
2. Buat booking baru (rental/tour/transfer/shuttle)
3. Check email:
   - Customer email: booking confirmation
   - Admin email: booking notification

---

## 📧 Email Flow

### Saat Customer Buat Booking:

```
Customer creates booking
        ↓
System saves to database
        ↓
    ┌───────────────────────────────────┐
    │                                   │
    ↓                                   ↓
Email to CUSTOMER              Email to ADMIN
✉️ booking@customer.com         ✉️ manikjayatrans@gmail.com
                                  
Subject:                        Subject:
"Konfirmasi Pesanan Anda:       "[Pesanan Baru] RNT-xxx - Rental"
RNT-20260608-0001"              

Content:                        Content:
- Konfirmasi booking            - Alert pesanan baru
- Detail pesanan                - Detail lengkap booking
- Total tagihan                 - Info customer
- Button ke dashboard           - Button ke admin panel
```

---

## ⚙️ Configuration Details

### Admin Email Address

**Default:** `manikjayatrans@gmail.com`

**Lokasi konfigurasi:**

1. **`.env` file:**
   ```env
   MAIL_ADMIN_ADDRESS="manikjayatrans@gmail.com"
   ```

2. **Config file** (`config/mail.php`):
   ```php
   'admin_email' => env('MAIL_ADMIN_ADDRESS', 'manikjayatrans@gmail.com'),
   ```

3. **Controllers** (4 files):
   - `RentalBookingController.php`
   - `TourBookingController.php`
   - `TransferBookingController.php`
   - `ShuttleBookingController.php`

**Untuk mengganti email admin:**
```env
# Edit .env
MAIL_ADMIN_ADDRESS="new-admin@example.com"

# Clear cache
php artisan config:clear
```

---

## 🔍 Troubleshooting

### ❌ Problem: "Failed to authenticate"

**Cause:** Password salah atau bukan App Password

**Solution:**
1. Generate Gmail App Password (lihat Step 2)
2. Gunakan App Password, BUKAN password Gmail biasa
3. Pastikan 2-Step Verification aktif

---

### ❌ Problem: "Connection refused"

**Cause:** Port atau host salah

**Solution:**
```env
# Gmail
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls

# Atau gunakan SSL
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

---

### ❌ Problem: Email masuk ke Spam

**Cause:** Email dari domain berbeda dengan sender

**Solution:**
1. Gunakan email yang sama untuk FROM dan USERNAME:
   ```env
   MAIL_USERNAME=manikjayatrans@gmail.com
   MAIL_FROM_ADDRESS="manikjayatrans@gmail.com"
   ```

2. Atau setup SPF/DKIM records untuk domain

---

### ❌ Problem: Email tidak terkirim

**Check logs:**
```bash
tail -f storage/logs/laravel.log
```

**Test SMTP connection:**
```bash
php artisan tinker
config('mail.host');
config('mail.username');
```

---

## 📊 Email Types

### 1. Customer Emails (3 types)

| Email | Trigger | Recipient |
|-------|---------|-----------|
| **BookingCreatedMail** | Booking dibuat | Customer |
| **BookingStatusUpdatedMail** | Status berubah | Customer |
| **PaymentSuccessMail** | Payment berhasil | Customer |

### 2. Admin Emails (1 type)

| Email | Trigger | Recipient |
|-------|---------|-----------|
| **AdminBookingNotification** | Booking dibuat | Admin (manikjayatrans@gmail.com) |

**Total:** 4 email types

---

## 🚀 Production Checklist

Before going live:

- [ ] Gmail App Password generated
- [ ] `.env` configured with correct credentials
- [ ] `MAIL_ADMIN_ADDRESS` set to correct email
- [ ] Test email sent successfully
- [ ] Cache cleared
- [ ] Verified email in inbox (not spam)
- [ ] Test all booking types:
  - [ ] Rental booking
  - [ ] Tour booking
  - [ ] Transfer booking
  - [ ] Shuttle booking

---

## 💡 Tips

### Multiple Admin Recipients

**Edit controllers untuk send ke multiple email:**

```php
// In BookingController
$adminEmails = [
    'manikjayatrans@gmail.com',
    'manager@manikjayatrans.com',
    'booking@manikjayatrans.com'
];

foreach ($adminEmails as $email) {
    Mail::to($email)->send(new AdminBookingNotification($booking, 'rental'));
}
```

---

### Use BCC for Backup

**Edit `AdminBookingNotification.php`:**

```php
public function envelope(): Envelope
{
    return new Envelope(
        subject: '[Pesanan Baru] ' . $this->booking->booking_code,
        bcc: ['backup@manikjayatrans.com'], // Backup email
    );
}
```

---

### Enable Email Queue

**For better performance:**

1. **Update Mail class:**
   ```php
   // app/Mail/AdminBookingNotification.php
   class AdminBookingNotification extends Mailable implements ShouldQueue
   {
       use Queueable;
       // ...
   }
   ```

2. **Configure queue:**
   ```env
   QUEUE_CONNECTION=database
   ```

3. **Run queue worker:**
   ```bash
   php artisan queue:work
   ```

---

## 📝 Complete `.env` Example

```env
APP_NAME="Manik Jaya Trans"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://manikjayatrans.com

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=manikjayatrans@gmail.com
MAIL_PASSWORD=your_16_digit_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="manikjayatrans@gmail.com"
MAIL_FROM_NAME="Manik Jaya Trans"
MAIL_ADMIN_ADDRESS="manikjayatrans@gmail.com"

# Midtrans
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

# FTP
FTP_HOST=ftp.manikjayatrans.com
FTP_USERNAME=your_ftp_user
FTP_PASSWORD=your_ftp_password
FTP_PORT=21
FTP_ROOT=/
FTP_URL=https://manikjayatrans.com/image
```

---

## ✅ Verification

After setup, verify:

1. **Test email sent successfully:**
   ```bash
   php artisan tinker
   Mail::raw('Test', fn($m) => $m->to('manikjayatrans@gmail.com')->subject('Test'));
   ```

2. **Check inbox:**
   - Email should arrive within seconds
   - Check spam folder if not in inbox

3. **Create test booking:**
   - Login as customer
   - Create rental booking
   - Check both customer and admin email

4. **Check logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```
   Should see: "Admin notification sent successfully"

---

## 📞 Support

**If you need help:**

1. Check Laravel logs: `storage/logs/laravel.log`
2. Test SMTP connection manually
3. Verify Gmail App Password is correct
4. Check firewall/port 587 is open
5. Contact development team

---

## 🎯 Quick Commands

```bash
# Clear all caches
php artisan optimize:clear

# Test email via tinker
php artisan tinker
Mail::raw('Test', fn($m) => $m->to('manikjayatrans@gmail.com')->subject('Test'));
exit

# Check logs
tail -f storage/logs/laravel.log

# Restart queue worker (if using queue)
php artisan queue:restart
```

---

**Setup Time:** ~5 minutes  
**Difficulty:** Easy ⭐  
**Status:** Ready to use ✅

---

**Last Updated:** June 2026  
**Admin Email:** manikjayatrans@gmail.com
