# Panduan Konfigurasi Notifikasi Email

## 📧 Sistem Informasi Travel Manik Jaya Trans

**Versi**: 1.0  
**Tanggal**: 1 Juni 2026  
**Status**: Production Ready

---

## 📋 Daftar Isi

1. [Overview Sistem Email](#overview-sistem-email)
2. [Jenis Email Notifikasi](#jenis-email-notifikasi)
3. [Konfigurasi Development](#konfigurasi-development)
4. [Konfigurasi Production](#konfigurasi-production)
5. [Testing Email](#testing-email)
6. [Troubleshooting](#troubleshooting)
7. [FAQ](#faq)

---

## 📌 Overview Sistem Email

Sistem notifikasi email sudah **100% terimplementasi** dalam aplikasi dengan fitur:

✅ **3 Jenis Email Otomatis**:
- Email konfirmasi booking
- Email pembayaran berhasil
- Email update status booking

✅ **Trigger Otomatis**:
- Saat customer membuat booking
- Saat pembayaran berhasil via Midtrans
- Saat admin mengubah status booking

✅ **Error Handling**:
- Try-catch untuk mencegah crash
- Logging error ke file log
- Aplikasi tetap jalan meskipun email gagal

✅ **Design Email**:
- Menggunakan Laravel Markdown Mailable
- Responsive dan mobile-friendly
- Button CTA yang jelas
- Branding konsisten

---

## 📨 Jenis Email Notifikasi

### 1. **Booking Created Email**

**Trigger**: Customer berhasil membuat booking (rental, tour, transfer, atau shuttle)

**Dikirim Oleh**:
- `RentalBookingController@store`
- `TourBookingController@store`
- `TransferBookingController@store`
- `ShuttleBookingController@store`

**Subject**: `Konfirmasi Pesanan Anda: [BOOKING_CODE]`

**Isi Email**:
```
Halo [Nama Customer],

Terima kasih telah melakukan pemesanan di Manik Jaya Trans.
Berikut adalah rincian pesanan Anda:

- Kode Booking: RNT-20260601-0001
- Tanggal Pesan: 1 Juni 2026
- Total Tagihan: Rp 500.000

[Button: Lihat Detail Pesanan]

Silakan segera lakukan pembayaran agar pesanan Anda dapat diproses.

Terima kasih,
Tim Manik Jaya Trans
```

**File Terkait**:
- Mail Class: `app/Mail/BookingCreatedMail.php`
- Template: `resources/views/emails/booking/created.blade.php`

---

### 2. **Payment Success Email**

**Trigger**: Pembayaran berhasil dikonfirmasi oleh Midtrans

**Dikirim Oleh**:
- `MidtransCallbackController@handleCallback`

**Subject**: `Pembayaran Berhasil: [BOOKING_CODE]`

**Isi Email**:
```
Halo [Nama Customer],

Pembayaran Anda untuk pesanan RNT-20260601-0001 telah BERHASIL kami terima.

- Nominal Pembayaran: Rp 500.000
- Status Pembayaran: Lunas (Paid)

[Button: Lihat Pesanan]

Tim kami akan segera memproses layanan Anda. Terima kasih telah 
mempercayakan perjalanan Anda bersama Manik Jaya Trans.

Salam hangat,
Tim Manik Jaya Trans
```

**File Terkait**:
- Mail Class: `app/Mail/PaymentSuccessMail.php`
- Template: `resources/views/emails/payment/success.blade.php`

---

### 3. **Booking Status Updated Email**

**Trigger**: Admin mengubah status booking via Filament admin panel

**Dikirim Oleh**:
- `BookingObserver@updated`

**Subject**: `Update Status Pesanan Anda: [BOOKING_CODE]`

**Isi Email**:
```
Halo [Nama Customer],

Status pesanan Anda dengan kode RNT-20260601-0001 telah diperbarui.

- Status Terbaru: APPROVED

[Button: Cek Status Pemesanan]

Jika Anda memiliki pertanyaan terkait perubahan status ini, 
silakan hubungi tim layanan pelanggan kami.

Terima kasih,
Tim Manik Jaya Trans
```

**File Terkait**:
- Mail Class: `app/Mail/BookingStatusUpdatedMail.php`
- Template: `resources/views/emails/booking/status-updated.blade.php`
- Observer: `app/Observers/BookingObserver.php`

---

## 🛠 Konfigurasi Development

### Option 1: Log Driver (Default) ⚡ **Tercepat untuk Development**

Email tidak benar-benar dikirim, hanya disimpan di log file.

#### **Setup**:

Edit file `.env`:
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@manikjaya.test"
MAIL_FROM_NAME="Manik Jaya Trans"
```

#### **Testing**:
```bash
# Buat booking via aplikasi, lalu lihat log
tail -f storage/logs/laravel.log | grep -A 50 "Message-ID"
```

#### **Kelebihan**:
- ✅ Setup paling cepat
- ✅ Tidak perlu akun email
- ✅ Tidak ada rate limit

#### **Kekurangan**:
- ❌ Tidak bisa lihat tampilan email
- ❌ Tidak bisa test di email client

---

### Option 2: Mailtrap 📬 **Recommended untuk Development**

Mailtrap adalah fake SMTP server untuk testing. Email ditangkap dan bisa dilihat di dashboard web.

#### **Setup**:

**1. Daftar Mailtrap** (Gratis):
   - Kunjungi: https://mailtrap.io
   - Buat akun gratis
   - Buat inbox baru
   - Dapatkan credentials SMTP

**2. Edit file `.env`**:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username_here
MAIL_PASSWORD=your_mailtrap_password_here
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@manikjaya.test"
MAIL_FROM_NAME="Manik Jaya Trans"
```

**3. Clear config cache**:
```bash
php artisan config:clear
```

#### **Testing**:
1. Buat booking via aplikasi
2. Buka dashboard Mailtrap
3. Lihat email masuk di inbox
4. Preview email dalam berbagai email client

#### **Kelebihan**:
- ✅ Lihat tampilan email sebenarnya
- ✅ Test di berbagai email client (Gmail, Outlook, dll)
- ✅ Debug HTML email
- ✅ Spam score testing
- ✅ Free tier cukup untuk development

#### **Kekurangan**:
- ❌ Perlu registrasi akun
- ❌ Email tidak sampai ke user sebenarnya

---

### Option 3: MailHog 🐶 **Local SMTP Server**

MailHog adalah SMTP server lokal yang berjalan di Docker.

#### **Setup**:

**1. Install MailHog via Docker**:
```bash
docker run -d -p 1025:1025 -p 8025:8025 mailhog/mailhog
```

**2. Edit file `.env`**:
```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@manikjaya.test"
MAIL_FROM_NAME="Manik Jaya Trans"
```

**3. Clear config cache**:
```bash
php artisan config:clear
```

#### **Testing**:
1. Buat booking via aplikasi
2. Buka http://localhost:8025
3. Lihat email masuk di MailHog UI

#### **Kelebihan**:
- ✅ 100% lokal, tidak perlu internet
- ✅ Lihat tampilan email
- ✅ Tidak perlu akun

#### **Kekurangan**:
- ❌ Perlu install Docker
- ❌ Harus menjalankan Docker container

---

## 🚀 Konfigurasi Production

### Option 1: Gmail SMTP 📧 **Paling Mudah**

Gunakan akun Gmail untuk mengirim email. Cocok untuk volume kecil-menengah.

#### **Setup**:

**1. Enable 2-Factor Authentication di Gmail**:
   - Login ke Google Account
   - Security → 2-Step Verification → Enable

**2. Buat App Password**:
   - Security → 2-Step Verification
   - Scroll ke bawah → App passwords
   - Pilih "Mail" dan "Other"
   - Copy password yang dihasilkan

**3. Edit file `.env`**:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@manikjayatrans.com"
MAIL_FROM_NAME="Manik Jaya Trans"
```

**4. Clear config cache**:
```bash
php artisan config:clear
php artisan config:cache
```

#### **Limit Gmail**:
- **Free**: 500 email/hari
- **Google Workspace**: 2,000 email/hari

#### **Kelebihan**:
- ✅ Setup mudah
- ✅ Gratis (untuk volume kecil)
- ✅ Reliable

#### **Kekurangan**:
- ❌ Limit 500 email/hari
- ❌ Tidak cocok untuk high volume
- ❌ Bisa kena spam filter

---

### Option 2: Mailgun 📮 **Recommended untuk Production**

Service email profesional dengan deliverability tinggi.

#### **Setup**:

**1. Daftar Mailgun**:
   - Kunjungi: https://www.mailgun.com
   - Daftar akun (Free tier: 5,000 email/bulan)
   - Verify domain Anda

**2. Dapatkan Credentials**:
   - Dashboard → Sending → Domain settings
   - Copy SMTP credentials

**3. Install Mailgun Package** (Opsional, untuk API):
```bash
composer require mailgun/mailgun-php symfony/http-client
```

**4. Edit file `.env`**:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@your-domain.com
MAIL_PASSWORD=your-mailgun-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@manikjayatrans.com"
MAIL_FROM_NAME="Manik Jaya Trans"

# Opsional: Jika menggunakan API
MAILGUN_DOMAIN=your-domain.com
MAILGUN_SECRET=your-api-key
MAILGUN_ENDPOINT=api.mailgun.net
```

**5. Clear config cache**:
```bash
php artisan config:clear
php artisan config:cache
```

#### **Pricing**:
- **Free**: 5,000 email/bulan (3 bulan pertama)
- **Foundation**: $35/bulan (50,000 email)
- **Growth**: $80/bulan (100,000 email)

#### **Kelebihan**:
- ✅ High deliverability
- ✅ Analytics & tracking
- ✅ Webhook support
- ✅ Scalable

#### **Kekurangan**:
- ❌ Perlu verify domain
- ❌ Berbayar setelah free tier

---

### Option 3: Amazon SES 📬 **Paling Scalable**

Service email dari AWS dengan harga sangat murah untuk volume tinggi.

#### **Setup**:

**1. Setup AWS SES**:
   - Login ke AWS Console
   - Amazon SES → Verified identities
   - Verify domain atau email
   - Request production access (default: sandbox mode)

**2. Dapatkan SMTP Credentials**:
   - SES → SMTP settings
   - Create SMTP credentials

**3. Install AWS SDK** (Opsional):
```bash
composer require aws/aws-sdk-php
```

**4. Edit file `.env`**:
```env
MAIL_MAILER=smtp
MAIL_HOST=email-smtp.us-east-1.amazonaws.com
MAIL_PORT=587
MAIL_USERNAME=your-smtp-username
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@manikjayatrans.com"
MAIL_FROM_NAME="Manik Jaya Trans"

# Opsional: Jika menggunakan SES API
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
```

**5. Clear config cache**:
```bash
php artisan config:clear
php artisan config:cache
```

#### **Pricing**:
- **First 62,000 emails**: GRATIS (jika dari EC2)
- **Setelahnya**: $0.10 per 1,000 email

#### **Kelebihan**:
- ✅ Sangat murah untuk volume tinggi
- ✅ Highly scalable
- ✅ Terintegrasi dengan AWS
- ✅ 99.9% uptime

#### **Kekurangan**:
- ❌ Setup lebih kompleks
- ❌ Default sandbox mode (perlu request production)
- ❌ Perlu AWS account

---

### Option 4: SendGrid 📧 **Alternative Populer**

Service email populer dengan interface yang bagus.

#### **Setup**:

**1. Daftar SendGrid**:
   - Kunjungi: https://sendgrid.com
   - Daftar akun (Free: 100 email/hari)
   - Verify sender identity

**2. Buat API Key**:
   - Settings → API Keys
   - Create API Key dengan "Mail Send" permission
   - Copy API key

**3. Install SendGrid Package** (Opsional):
```bash
composer require sendgrid/sendgrid
```

**4. Edit file `.env`**:
```env
# Via SMTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@manikjayatrans.com"
MAIL_FROM_NAME="Manik Jaya Trans"

# Atau via API
SENDGRID_API_KEY=your-sendgrid-api-key
```

**5. Clear config cache**:
```bash
php artisan config:clear
php artisan config:cache
```

#### **Pricing**:
- **Free**: 100 email/hari
- **Essentials**: $19.95/bulan (50,000 email)
- **Pro**: $89.95/bulan (100,000 email)

#### **Kelebihan**:
- ✅ Interface user-friendly
- ✅ Good deliverability
- ✅ Marketing features
- ✅ Good documentation

#### **Kekurangan**:
- ❌ Free tier sangat terbatas (100/hari)
- ❌ Lebih mahal dari SES untuk volume tinggi

---

## 🧪 Testing Email

### 1. **Test via Artisan Tinker**

```bash
php artisan tinker
```

```php
// Test BookingCreatedMail
$user = App\Models\User::where('role', 'customer')->first();
$booking = App\Models\RentalBooking::first();
Mail::to($user->email)->send(new App\Mail\BookingCreatedMail($booking));

// Test PaymentSuccessMail
Mail::to($user->email)->send(new App\Mail\PaymentSuccessMail($booking));

// Test BookingStatusUpdatedMail
Mail::to($user->email)->send(new App\Mail\BookingStatusUpdatedMail($booking));
```

---

### 2. **Test via Manual Booking**

**Step-by-step**:
1. Register akun customer baru dengan email Anda
2. Login sebagai customer
3. Pilih kendaraan/tour/transfer/shuttle
4. Buat booking baru
5. **Cek email** → Harus menerima "Booking Created Email"
6. Lakukan pembayaran via Midtrans (Sandbox)
7. **Cek email** → Harus menerima "Payment Success Email"
8. Login sebagai admin di `/admin`
9. Ubah status booking menjadi "approved"
10. **Cek email** → Harus menerima "Booking Status Updated Email"

---

### 3. **Test via Queue Worker**

Jika menggunakan queue untuk email (opsional):

```bash
# Jalankan queue worker
php artisan queue:work

# Atau untuk testing
php artisan queue:work --tries=1 --timeout=30
```

---

### 4. **Check Email Log**

Lihat log untuk memastikan email terkirim:

```bash
# Lihat log terbaru
tail -f storage/logs/laravel.log

# Atau cari error email
grep -i "Failed to send email" storage/logs/laravel.log
```

---

## 🔧 Troubleshooting

### ❌ **Email Tidak Terkirim**

#### **Cek 1: Konfigurasi `.env`**
```bash
# Pastikan config sudah di-load
php artisan config:clear
php artisan config:cache

# Test koneksi SMTP
php artisan tinker
>>> config('mail.mailers.smtp')
```

#### **Cek 2: Log Error**
```bash
tail -f storage/logs/laravel.log | grep -i mail
```

#### **Cek 3: Firewall/Port**
```bash
# Test koneksi ke SMTP server
telnet smtp.gmail.com 587
# atau
telnet smtp.mailgun.org 587
```

#### **Cek 4: Credentials**
- Username dan password benar?
- App password sudah dibuat (untuk Gmail)?
- API key valid?

---

### ❌ **Email Masuk Spam**

#### **Solusi**:

1. **Verify Domain**:
   - Setup SPF record
   - Setup DKIM
   - Setup DMARC

2. **Gunakan Email Service Profesional**:
   - Mailgun / SendGrid / Amazon SES
   - Mereka sudah memiliki reputation yang baik

3. **Improve Email Content**:
   - Jangan gunakan kata-kata spam
   - Balance text dan gambar
   - Gunakan unsubscribe link

4. **Test Spam Score**:
   - Gunakan mail-tester.com
   - Target score > 8/10

---

### ❌ **Error: Connection Refused**

#### **Penyebab**:
- Port diblokir firewall
- SMTP server salah
- Credentials salah

#### **Solusi**:
```bash
# Test koneksi
telnet smtp.gmail.com 587

# Pastikan port 587 atau 465 terbuka
# Coba ganti MAIL_PORT antara 587 dan 465
```

---

### ❌ **Error: Too Many Login Attempts**

#### **Penyebab**:
- Gmail mendeteksi aktivitas mencurigakan
- Rate limit exceeded

#### **Solusi**:
1. Buka link: https://accounts.google.com/DisplayUnlockCaptcha
2. Klik "Continue"
3. Coba kirim email lagi

---

### ❌ **Email Delay/Lambat**

#### **Penyebab**:
- Email dikirim synchronous
- SMTP server lambat

#### **Solusi**: Gunakan Queue

**1. Setup Queue**:
```env
QUEUE_CONNECTION=database
```

**2. Migrate Queue Table**:
```bash
php artisan queue:table
php artisan migrate
```

**3. Update Mail Class** untuk implement `ShouldQueue`:
```php
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingCreatedMail extends Mailable implements ShouldQueue
{
    // ...
}
```

**4. Run Queue Worker**:
```bash
# Development
php artisan queue:work

# Production (dengan Supervisor)
sudo supervisorctl start laravel-worker:*
```

---

## ❓ FAQ

### **1. Berapa biaya kirim email?**

| Service | Free Tier | Paid Tier |
|---------|-----------|-----------|
| Gmail | 500/hari | 2,000/hari (Google Workspace) |
| Mailgun | 5,000/bulan (3 bulan) | $35/bulan (50k email) |
| SendGrid | 100/hari | $19.95/bulan (50k email) |
| Amazon SES | 62,000 (dari EC2) | $0.10 per 1,000 email |

**Rekomendasi**: Mulai dengan Gmail, upgrade ke Mailgun atau SES saat sudah high traffic.

---

### **2. Email sampai berapa lama?**

| Trigger | Waktu Kirim |
|---------|-------------|
| Booking Created | **Langsung** setelah booking |
| Payment Success | **1-5 detik** setelah callback Midtrans |
| Status Updated | **Langsung** setelah admin save |

Jika menggunakan **Queue**, tambah delay 5-30 detik tergantung queue worker.

---

### **3. Customer tidak terima email, kenapa?**

**Checklist**:
- ☑️ Email masuk folder spam?
- ☑️ Email address customer benar?
- ☑️ Check log: `storage/logs/laravel.log`
- ☑️ SMTP credentials benar?
- ☑️ Config sudah di-cache? (`php artisan config:cache`)

---

### **4. Bisa custom template email?**

**Ya!** Edit file di `resources/views/emails/`:

```php
// resources/views/emails/booking/created.blade.php
<x-mail::message>
# Halo {{ $booking->user->name }}, 🎉

**Yeay!** Booking Anda berhasil dibuat.

<x-mail::panel>
🎫 Kode Booking: **{{ $booking->booking_code }}**
</x-mail::panel>

<x-mail::button :url="$url" color="success">
Lihat Detail Pesanan
</x-mail::button>

Terima kasih sudah memilih kami! 🙏

Salam,<br>
{{ config('app.name') }}
</x-mail::message>
```

**Publish vendor views** untuk custom lebih lanjut:
```bash
php artisan vendor:publish --tag=laravel-mail
```

---

### **5. Bisa kirim email dengan attachment?**

**Ya!** Tambahkan method `attachments()`:

```php
public function attachments(): array
{
    return [
        Attachment::fromPath(storage_path('app/invoice.pdf'))
            ->as('Invoice.pdf')
            ->withMime('application/pdf'),
    ];
}
```

---

### **6. Bagaimana cara track email dibuka?**

**Opsi 1**: Gunakan service yang support tracking:
- Mailgun: Auto tracking
- SendGrid: Auto tracking
- Amazon SES: Pakai SNS notifications

**Opsi 2**: Manual tracking dengan pixel:
```php
// Tambahkan di template
<img src="{{ route('email.track', $booking->id) }}" width="1" height="1" />
```

---

### **7. Bisa kirim email dalam bahasa Inggris?**

**Ya!** Buat template baru atau deteksi bahasa user:

```php
// Mail class
public function content(): Content
{
    $locale = $this->booking->user->language ?? 'id';
    
    return new Content(
        markdown: "emails.booking.created-{$locale}",
        with: ['booking' => $this->booking],
    );
}
```

Template:
- `emails/booking/created-id.blade.php` (Indonesia)
- `emails/booking/created-en.blade.php` (English)

---

### **8. Bagaimana testing email tanpa kirim ke customer?**

**Gunakan Mailtrap atau Log driver**:

```env
# Development
MAIL_MAILER=log
# atau
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
```

**Atau override recipient** di `.env`:
```env
# Semua email dikirim ke email ini
MAIL_ALWAYS_TO=developer@example.com
```

---

## 📚 Resources

### **Dokumentasi**:
- [Laravel Mail Documentation](https://laravel.com/docs/11.x/mail)
- [Laravel Markdown Mailable](https://laravel.com/docs/11.x/mail#markdown-mailables)
- [Laravel Queues](https://laravel.com/docs/11.x/queues)

### **Email Services**:
- [Mailtrap](https://mailtrap.io) - Email testing
- [Mailgun](https://www.mailgun.com) - Production email service
- [SendGrid](https://sendgrid.com) - Production email service
- [Amazon SES](https://aws.amazon.com/ses/) - AWS email service

### **Tools**:
- [Mail Tester](https://www.mail-tester.com) - Test spam score
- [MailHog](https://github.com/mailhog/MailHog) - Local SMTP server
- [Email on Acid](https://www.emailonacid.com) - Email testing across clients

---

## 📞 Support

Jika ada masalah dengan email notification:

1. **Check log first**: `storage/logs/laravel.log`
2. **Test koneksi**: `telnet smtp-server port`
3. **Verify credentials**: Login manual ke email service
4. **Check documentation**: File ini atau Laravel docs

---

## ✅ Checklist Setup Email

### Development
- [ ] Pilih email service (Log, Mailtrap, atau MailHog)
- [ ] Update `.env` dengan konfigurasi yang sesuai
- [ ] Run `php artisan config:clear`
- [ ] Test kirim email via tinker
- [ ] Test buat booking manual
- [ ] Verify email diterima

### Production
- [ ] Pilih email service (Gmail, Mailgun, SES, atau SendGrid)
- [ ] Daftar dan verify domain
- [ ] Dapatkan credentials (SMTP atau API)
- [ ] Update `.env` production
- [ ] Run `php artisan config:cache`
- [ ] Test kirim email
- [ ] Setup monitoring/alerting
- [ ] Verify deliverability (check spam score)
- [ ] **Opsional**: Setup queue worker untuk async email

---

**Last Updated**: 1 Juni 2026  
**Version**: 1.0  
**Status**: ✅ Production Ready

---

**Happy Emailing! 📧**
