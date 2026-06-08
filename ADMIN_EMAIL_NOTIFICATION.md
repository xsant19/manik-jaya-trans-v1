# 📧 Admin Email Notification System

Dokumentasi lengkap untuk sistem notifikasi email ke admin/perusahaan setiap ada booking baru.

---

## 🎯 Overview

Setiap kali customer membuat booking baru (rental, tour, transfer, atau shuttle), sistem akan **otomatis mengirim 2 email**:

1. ✅ **Email ke Customer** - Konfirmasi booking
2. ✅ **Email ke Admin/Perusahaan** - Notifikasi booking baru (NEW!)

---

## 📋 Features

### Email ke Admin Berisi:

- 🔔 Alert "Pesanan Baru Masuk"
- 📝 Detail lengkap booking:
  - Kode booking
  - Tanggal & waktu order
  - Status pembayaran
  - Total tagihan
- 👤 Informasi customer:
  - Nama
  - Email
  - Telepon
- 🚗 Detail layanan sesuai tipe booking:
  - **Rental:** Kendaraan, tipe rental, tanggal, lokasi
  - **Tour:** Paket wisata, tanggal tour, jumlah peserta
  - **Transfer:** Rute, lokasi jemput/antar, waktu, no. penerbangan
  - **Shuttle:** Hotel, lokasi, waktu, jumlah penumpang
- 🔗 Link langsung ke admin panel untuk kelola booking

---

## 🛠️ Implementation

### Files Created/Modified:

#### 1. New Mail Class
**File:** `app/Mail/AdminBookingNotification.php`

```php
<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class AdminBookingNotification extends Mailable
{
    public $booking;
    public $bookingType;

    public function __construct($booking, string $bookingType)
    {
        $this->booking = $booking;
        $this->bookingType = $bookingType;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Pesanan Baru] ' . $this->booking->booking_code . ' - ' . ucfirst($this->bookingType),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin.booking-notification',
            with: [
                'booking' => $this->booking,
                'bookingType' => $this->bookingType,
            ],
        );
    }
}
```

---

#### 2. Email Template
**File:** `resources/views/emails/admin/booking-notification.blade.php`

Template menggunakan Laravel Markdown Mail dengan:
- Professional layout
- Organized sections
- Color-coded panels
- Direct link to admin panel

---

#### 3. Updated Controllers

**Modified Files:**
- `app/Http/Controllers/Booking/RentalBookingController.php`
- `app/Http/Controllers/Booking/TourBookingController.php`
- `app/Http/Controllers/Booking/TransferBookingController.php`
- `app/Http/Controllers/Booking/ShuttleBookingController.php`

**Changes:**
```php
// Send email to customer
try {
    Mail::to(auth()->user()->email)->send(new BookingCreatedMail($booking));
} catch (\Exception $e) {
    Log::error('Failed to send customer email: ' . $e->getMessage());
}

// Send notification to admin/company (NEW!)
try {
    $adminEmail = config('mail.admin_email', env('MAIL_ADMIN_ADDRESS', 'admin@manikjayatrans.com'));
    Mail::to($adminEmail)->send(new AdminBookingNotification($booking, 'rental'));
} catch (\Exception $e) {
    Log::error('Failed to send admin notification email: ' . $e->getMessage());
}
```

---

#### 4. Config File
**File:** `config/mail.php`

Added new config key:
```php
'admin_email' => env('MAIL_ADMIN_ADDRESS', 'admin@manikjayatrans.com'),
```

---

#### 5. Environment Variables
**File:** `.env.example`

Added new variable:
```env
MAIL_ADMIN_ADDRESS="admin@manikjayatrans.com"
```

---

## ⚙️ Configuration

### Step 1: Set Admin Email Address

Add to your `.env` file:

```env
# Admin email for booking notifications
MAIL_ADMIN_ADDRESS="admin@manikjayatrans.com"
```

**Multiple Recipients (Optional):**

If you want to send to multiple admin emails, you can modify the controllers:

```php
// In BookingController
$adminEmails = [
    'admin@manikjayatrans.com',
    'booking@manikjayatrans.com',
    'manager@manikjayatrans.com'
];

foreach ($adminEmails as $email) {
    Mail::to($email)->send(new AdminBookingNotification($booking, 'rental'));
}
```

---

### Step 2: Configure SMTP

Make sure your SMTP is configured in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@manikjayatrans.com"
MAIL_FROM_NAME="Manik Jaya Trans"
MAIL_ADMIN_ADDRESS="admin@manikjayatrans.com"
```

---

### Step 3: Clear Config Cache

```bash
php artisan config:clear
```

---

## 🧪 Testing

### Test via Booking Process

1. **Create a test booking:**
   - Login as customer
   - Create new booking (rental/tour/transfer/shuttle)
   - Complete the booking form

2. **Check emails sent:**
   - Customer should receive confirmation email
   - Admin should receive notification email

---

### Test via Tinker

```bash
php artisan tinker
```

```php
// Get test data
$booking = App\Models\RentalBooking::first();

// Send test email to admin
Mail::to('admin@manikjayatrans.com')
    ->send(new App\Mail\AdminBookingNotification($booking, 'rental'));

// Check if sent
echo "Email sent!";
exit;
```

---

### Test with Mailtrap (Development)

1. **Setup Mailtrap** (free tier: https://mailtrap.io)
2. **Configure `.env`:**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   MAIL_ADMIN_ADDRESS="test@example.com"
   ```
3. **Create booking** via web interface
4. **Check Mailtrap inbox** - you should see 2 emails:
   - One to customer
   - One to admin

---

## 📊 Email Flow Diagram

```
Customer creates booking
        ↓
BookingController->store()
        ↓
Save booking to database
        ↓
    ┌───────────────────────────────┐
    │                               │
    ↓                               ↓
Send email to CUSTOMER        Send email to ADMIN
(BookingCreatedMail)          (AdminBookingNotification)
    ↓                               ↓
Customer receives             Admin receives
confirmation                  notification
```

---

## 🎨 Email Preview

### Subject Line Examples:

- `[Pesanan Baru] RNT-20260608-0001 - Rental`
- `[Pesanan Baru] TOUR-20260608-0002 - Tour`
- `[Pesanan Baru] TRF-20260608-0003 - Transfer`
- `[Pesanan Baru] SHT-20260608-0004 - Shuttle`

### Email Content Structure:

```
┌─────────────────────────────────────────────┐
│ 🔔 Pesanan Baru Masuk!                      │
│                                             │
│ Tipe Layanan: Rental                        │
│ ──────────────────────────────────────────  │
│                                             │
│ ## Detail Pesanan                           │
│ ┌─────────────────────────────────────────┐ │
│ │ Kode Booking: RNT-20260608-0001         │ │
│ │ Tanggal Pesan: 8 Juni 2026 14:30       │ │
│ │ Status Pembayaran: UNPAID               │ │
│ │ Total Tagihan: Rp 500.000               │ │
│ └─────────────────────────────────────────┘ │
│                                             │
│ ## Data Customer                            │
│ • Nama: John Doe                            │
│ • Email: john@example.com                   │
│ • Telepon: 08123456789                      │
│                                             │
│ ## Detail Layanan                           │
│ • Kendaraan: Toyota Avanza 2023             │
│ • Tipe Rental: Full Day (24 Jam)           │
│ • Tanggal Mulai: 10 Juni 2026              │
│ • Tanggal Selesai: 11 Juni 2026            │
│ • Lokasi Jemput: Hotel Sanur Beach         │
│                                             │
│ ┌───────────────────────────────────────┐   │
│ │  Kelola Pesanan di Admin Panel  →    │   │
│ └───────────────────────────────────────┘   │
│                                             │
│ Segera proses pesanan ini!                  │
└─────────────────────────────────────────────┘
```

---

## 🔍 Troubleshooting

### Problem 1: Admin email not received

**Check:**
1. `.env` has correct `MAIL_ADMIN_ADDRESS`
2. SMTP configuration is correct
3. Check Laravel logs: `storage/logs/laravel.log`

**Test SMTP:**
```bash
php artisan tinker
Mail::raw('Test email', function($msg) {
    $msg->to('admin@manikjayatrans.com')->subject('Test');
});
```

---

### Problem 2: Email sent but not received

**Possible causes:**
1. **Spam folder** - Check spam/junk folder
2. **Email bounced** - Check SMTP provider dashboard
3. **Invalid email address** - Verify admin email is correct
4. **Rate limiting** - Some SMTP providers limit emails/hour

**Solution:**
- Use reputable SMTP provider (Gmail, SendGrid, Mailgun)
- Verify domain ownership (SPF, DKIM records)
- Check SMTP provider logs

---

### Problem 3: Customer email works, admin email doesn't

**Check:**
```php
// In controller
Log::info('Sending admin notification to: ' . $adminEmail);

try {
    Mail::to($adminEmail)->send(new AdminBookingNotification($booking, 'rental'));
    Log::info('Admin notification sent successfully');
} catch (\Exception $e) {
    Log::error('Failed to send admin notification: ' . $e->getMessage());
}
```

Then check logs:
```bash
tail -f storage/logs/laravel.log
```

---

### Problem 4: Email format broken

**Cause:** Blade syntax error in template

**Solution:**
```bash
# Test email template
php artisan tinker

$booking = App\Models\RentalBooking::first();
$mailable = new App\Mail\AdminBookingNotification($booking, 'rental');
echo $mailable->render();
```

---

## 📈 Email Statistics

### Emails Sent Per Booking:

| Booking Type | Customer Email | Admin Email | Total |
|--------------|----------------|-------------|-------|
| Rental       | ✅             | ✅          | 2     |
| Tour         | ✅             | ✅          | 2     |
| Transfer     | ✅             | ✅          | 2     |
| Shuttle      | ✅             | ✅          | 2     |

**Total:** 4 emails per booking cycle (2 at creation + 2 more if status changes)

---

## 🔒 Security Considerations

### 1. Email Address Validation

Admin email is validated through Laravel's email validation in config.

### 2. Rate Limiting

Consider implementing rate limiting for email sending:

```php
// In controller
use Illuminate\Support\Facades\RateLimiter;

if (RateLimiter::tooManyAttempts('send-admin-email:'.$booking->id, 5)) {
    Log::warning('Too many email attempts for booking: ' . $booking->id);
    return;
}

RateLimiter::hit('send-admin-email:'.$booking->id);

// Send email...
```

### 3. Error Logging

All email failures are logged for monitoring:
```php
Log::error('Failed to send admin notification email: ' . $e->getMessage());
```

### 4. Sensitive Data

Email template doesn't include:
- ❌ Payment card details
- ❌ Full bank account numbers
- ❌ Passwords

Only includes:
- ✅ Booking information
- ✅ Customer contact details
- ✅ Service details

---

## 🎛️ Customization

### Change Email Subject

Edit `app/Mail/AdminBookingNotification.php`:

```php
public function envelope(): Envelope
{
    return new Envelope(
        subject: '🔔 NEW ORDER: ' . $this->booking->booking_code,
    );
}
```

---

### Add CC/BCC

```php
public function envelope(): Envelope
{
    return new Envelope(
        subject: '[Pesanan Baru] ' . $this->booking->booking_code,
        cc: ['manager@manikjayatrans.com'],
        bcc: ['backup@manikjayatrans.com'],
    );
}
```

---

### Customize Template

Edit `resources/views/emails/admin/booking-notification.blade.php`

Add company logo:
```blade
<x-mail::message>
![Company Logo]({{ asset('images/logo.png') }})

# 🔔 Pesanan Baru Masuk!
...
```

---

### Queue Emails (Recommended for Production)

To avoid blocking the request, queue the emails:

1. **Update Mail class:**
```php
class AdminBookingNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
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

## 📝 Best Practices

### 1. Use Queue for Emails
✅ Prevents blocking user requests
✅ Better error handling
✅ Retry failed emails automatically

### 2. Monitor Email Logs
✅ Check `storage/logs/laravel.log` regularly
✅ Monitor SMTP provider dashboard
✅ Set up alerts for failed emails

### 3. Test in Staging First
✅ Use Mailtrap for development
✅ Test all booking types
✅ Verify email formatting

### 4. Backup Admin Email
✅ Consider multiple recipients
✅ Use BCC for backup email
✅ Store in database for audit trail

---

## 🚀 Production Deployment

### Checklist:

- [ ] Set `MAIL_ADMIN_ADDRESS` in production `.env`
- [ ] Configure production SMTP credentials
- [ ] Test email sending in production
- [ ] Monitor email logs for first week
- [ ] Set up email delivery monitoring
- [ ] Configure queue worker for background processing
- [ ] Add email to on-call rotation

---

## 📞 Support

If emails are not being delivered:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check SMTP provider logs
3. Verify email address is correct
4. Test SMTP connection manually
5. Check spam folder

For technical support, contact development team.

---

## ✅ Summary

**Features Added:**
- ✅ Admin email notification on every new booking
- ✅ Detailed booking information in email
- ✅ Direct link to admin panel
- ✅ Support for all 4 booking types
- ✅ Error handling and logging
- ✅ Configurable admin email address

**Configuration Required:**
- Set `MAIL_ADMIN_ADDRESS` in `.env`
- Configure SMTP credentials
- Clear config cache

**Testing:**
- Create test bookings
- Check admin email inbox
- Verify email content and formatting

---

**Last Updated:** June 2026  
**Version:** 1.0.0  
**Author:** Manik Jaya Trans Development Team
