# 🚀 Deployment Guide - Rumahweb Shared Hosting

Panduan lengkap untuk mendeploy aplikasi Laravel Manik Jaya Trans ke Rumahweb Shared Hosting menggunakan GitHub Actions CI/CD dengan **Incremental FTP Upload**.

---

## 🎯 Key Features

- ✅ **Automated deployment** via GitHub Actions
- ✅ **Incremental FTP upload** — hanya upload file yang berubah
- ✅ **60-90% faster** deployment setelah initial deploy
- ✅ **Automatic asset building** (Vite)
- ✅ **Composer optimization** untuk production
- ✅ **Optional remote database import**

**⚡ Speed:** First deploy ~8 minutes, subsequent deploys ~30-90 seconds

See: `INCREMENTAL_DEPLOYMENT.md` untuk detail teknis tentang incremental upload.

---

## 📋 Prerequisites

Sebelum melakukan deployment, pastikan Anda memiliki:

- ✅ Repository GitHub untuk project ini
- ✅ Akun Rumahweb Shared Hosting aktif
- ✅ Akses FTP ke hosting Rumahweb
- ✅ Database MySQL sudah dibuat di cPanel
- ✅ Domain/subdomain sudah disetup

---

## 🔧 Step 1: Setup GitHub Repository

### 1.1 Push Code ke GitHub

Jika belum, push project ke GitHub:

```bash
# Initialize git (jika belum)
git init

# Add remote repository
git remote add origin https://github.com/username/manik-jaya-trans-v1.git

# Add all files
git add .

# Commit
git commit -m "Initial commit"

# Push to main branch
git branch -M main
git push -u origin main
```

---

## 🔐 Step 2: Setup GitHub Secrets

GitHub Secrets digunakan untuk menyimpan credential yang sensitif (FTP, Database, dll).

### 2.1 Cara Menambahkan Secrets

1. Buka repository GitHub Anda
2. Klik **Settings** → **Secrets and variables** → **Actions**
3. Klik **New repository secret**
4. Tambahkan secrets berikut:

### 2.2 Daftar Secrets yang Diperlukan

#### **FTP Configuration**

| Secret Name | Description | Contoh Value |
|------------|-------------|--------------|
| `FTP_SERVER` | FTP Server Rumahweb | `ftp.namadomainanda.com` atau `123.456.789.10` |
| `FTP_USERNAME` | Username FTP (biasanya nama domain) | `namadomainanda.com` atau `user123` |
| `FTP_PASSWORD` | Password FTP | `YourFtpPassword123!` |
| `FTP_SERVER_DIR` | Path folder di hosting | `/public_html/` atau `/public_html/manik-jaya/` |

#### **Application Configuration (Optional)**

| Secret Name | Description | Contoh Value |
|------------|-------------|--------------|
| `APP_URL` | URL aplikasi Anda | `https://namadomainanda.com` |

#### **SSH Configuration (Optional - Jika support SSH)**

| Secret Name | Description | Contoh Value |
|------------|-------------|--------------|
| `SSH_HOST` | SSH Host | `namadomainanda.com` |
| `SSH_USERNAME` | SSH Username | `user123` |
| `SSH_PASSWORD` | SSH Password | `YourSshPassword123!` |
| `SSH_PORT` | SSH Port | `22` (default) atau port custom |

---

## 📂 Step 3: Cara Mendapatkan Informasi FTP Rumahweb

### 3.1 Login ke cPanel Rumahweb

1. Login ke **cPanel** Rumahweb
2. URL biasanya: `https://namadomainanda.com/cpanel` atau `https://cpanel.rumahweb.com`

### 3.2 FTP Information

Di cPanel, cari menu **FTP Accounts** atau **File Manager**:

- **FTP Server**: Lihat di bagian "FTP Configuration"
  - Biasanya: `ftp.yourdomain.com` atau IP server
- **FTP Username**: Sama dengan username cPanel atau buat FTP account baru
- **FTP Password**: Password yang Anda set saat membuat FTP account
- **FTP Server Directory**: 
  - Root: `/public_html/`
  - Subdomain: `/public_html/subdomain/`
  - Folder tertentu: `/public_html/folder-name/`

### 3.3 Cara Test FTP Connection

Gunakan FTP client seperti **FileZilla** untuk test:

```
Host: ftp.yourdomain.com
Username: your-ftp-username
Password: your-ftp-password
Port: 21 (default FTP)
```

---

## 🗄️ Step 4: Setup Database di Rumahweb

### 4.1 Buat Database MySQL

1. Login ke **cPanel Rumahweb**
2. Cari menu **MySQL Databases**
3. Buat database baru:
   - Database Name: `manik_jaya_trans` (atau nama lain)
4. Buat user database:
   - Username: `db_user`
   - Password: (password kuat)
5. Tambahkan user ke database (pilih ALL PRIVILEGES)
6. Catat informasi berikut:
   ```
   DB_HOST=localhost
   DB_DATABASE=username_manik_jaya_trans
   DB_USERNAME=username_db_user
   DB_PASSWORD=your_db_password
   ```

### 4.2 Import Database (First Time)

Jika Anda sudah memiliki database lokal:

1. Export database dari local:
   ```bash
   php artisan migrate:fresh --seed
   mysqldump -u root manik_jaya_trans > database.sql
   ```

2. Import ke Rumahweb via **phpMyAdmin**:
   - Login ke cPanel → phpMyAdmin
   - Pilih database yang sudah dibuat
   - Klik **Import** → Pilih file `database.sql`
   - Klik **Go**

Atau jalankan migration dari server (jika SSH available):
```bash
php artisan migrate --force
php artisan db:seed --force
```

---

## 📝 Step 5: Setup .env File di Server

File `.env` **TIDAK** di-deploy via GitHub (untuk keamanan).

### 5.1 Upload .env Manual

1. Buat file `.env` di local dengan konfigurasi production:

```env
APP_NAME="Manik Jaya Trans"
APP_ENV=production
APP_KEY=base64:YOUR_PRODUCTION_KEY_HERE
APP_DEBUG=false
APP_URL=https://namadomainanda.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_manik_jaya_trans
DB_USERNAME=username_db_user
DB_PASSWORD=your_db_password

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=mail.namadomainanda.com
MAIL_PORT=587
MAIL_USERNAME=noreply@namadomainanda.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@namadomainanda.com
MAIL_FROM_NAME="Manik Jaya Trans"

MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

2. Upload via **File Manager** cPanel atau FTP client
3. Letakkan di root folder aplikasi (sejajar dengan `artisan`)

### 5.2 Generate APP_KEY

Jika SSH tersedia:
```bash
php artisan key:generate --force
```

Jika tidak ada SSH, generate di local lalu copy ke `.env` server:
```bash
php artisan key:generate --show
```

---

## 🏗️ Step 6: Setup Folder Structure di Hosting

### 6.1 Struktur Folder Rumahweb

Rumahweb shared hosting biasanya memiliki struktur:

```
/home/username/
├── public_html/           # Document root (public facing)
│   └── index.php         # Harus pointing ke Laravel public
└── laravel-app/          # Aplikasi Laravel (di luar public_html)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── public/           # Assets Laravel
    ├── resources/
    ├── routes/
    ├── storage/
    └── vendor/
```

### 6.2 Cara Setup (Rekomendasi)

#### **Option 1: Laravel di dalam public_html (Simple)**

Jika traffic rendah-medium, bisa deploy langsung ke `public_html/`:

```
FTP_SERVER_DIR=/public_html/
```

Document Root di cPanel tetap `/public_html/public`

#### **Option 2: Laravel di luar public_html (Secure)**

Lebih aman, aplikasi di luar public:

1. Upload aplikasi ke folder `/laravel-app/`
2. Copy isi folder `public/` Laravel ke `/public_html/`
3. Edit `/public_html/index.php`:

```php
<?php

require __DIR__.'/../laravel-app/bootstrap/app.php';

$app = require_once __DIR__.'/../laravel-app/bootstrap/app.php';
```

---

## 🔄 Step 7: Cara Deploy

### 7.1 Automatic Deployment (Recommended)

Deploy otomatis terjadi ketika Anda push ke branch `main`:

```bash
git add .
git commit -m "Update feature X"
git push origin main
```

GitHub Actions akan otomatis:
1. ✅ Install dependencies
2. ✅ Build assets (Vite)
3. ✅ Deploy via FTP ke Rumahweb
4. ✅ Set permissions

### 7.2 Manual Deployment (via GitHub UI)

1. Buka repository GitHub
2. Klik tab **Actions**
3. Pilih workflow **Deploy to Rumahweb Shared Hosting**
4. Klik **Run workflow**
5. Pilih branch (main)
6. Klik **Run workflow**

---

## ⚙️ Step 8: Post-Deployment Tasks

### 8.1 Set Permissions (via File Manager cPanel)

Pastikan folder berikut writable (755 atau 775):

```
chmod 755 storage -R
chmod 755 bootstrap/cache -R
```

Via cPanel File Manager:
1. Klik kanan folder → **Change Permissions**
2. Set ke **755** untuk storage dan bootstrap/cache

### 8.2 Setup Storage Link (First Time Only)

Via SSH (jika tersedia):
```bash
php artisan storage:link
```

Via manual (jika tidak ada SSH):
1. Buka File Manager cPanel
2. Di folder `public/`, buat symlink manual:
   - Dari: `public/storage`
   - Ke: `../storage/app/public`

### 8.3 Clear Cache

Via SSH:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Jika tidak ada SSH, hapus manual folder:
- `bootstrap/cache/config.php`
- `bootstrap/cache/routes-v7.php`
- Folder `storage/framework/views/*.php`

---

## 🐛 Troubleshooting

### Problem 1: 500 Internal Server Error

**Penyebab:**
- `.env` tidak ada atau salah
- Permissions storage/bootstrap salah
- PHP version tidak sesuai (butuh 8.3+)

**Solusi:**
```bash
# Cek error log
tail -f storage/logs/laravel.log

# Set permissions
chmod -R 755 storage bootstrap/cache

# Clear cache
php artisan config:clear
```

### Problem 2: Assets (CSS/JS) Not Loading

**Penyebab:**
- `APP_URL` di `.env` salah
- Asset path tidak benar
- File tidak ter-upload

**Solusi:**
- Pastikan `APP_URL` di `.env` sesuai domain
- Cek folder `public/build/` ada file CSS/JS
- Run `php artisan storage:link`

### Problem 3: Database Connection Error

**Penyebab:**
- DB credentials salah
- DB host bukan `localhost`
- Database tidak exist

**Solusi:**
```env
# Cek di .env
DB_HOST=localhost        # Coba juga: 127.0.0.1
DB_DATABASE=full_database_name_with_prefix
DB_USERNAME=full_username_with_prefix
```

### Problem 4: FTP Upload Failed

**Penyebab:**
- FTP credentials salah
- Server directory salah
- Firewall block

**Solusi:**
- Test FTP via FileZilla
- Cek GitHub Secrets sudah benar
- Pastikan `FTP_SERVER_DIR` dengan trailing slash: `/public_html/`

### Problem 5: Permission Denied

**Penyebab:**
- Folder tidak writable

**Solusi:**
```bash
# Via SSH
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Via File Manager cPanel
# Klik kanan → Change Permissions → 755
```

---

## 📊 Monitoring Deployment

### Melihat Status Deployment

1. Buka repository GitHub
2. Klik tab **Actions**
3. Lihat workflow run terbaru
4. Klik untuk melihat detail log

### Setup Notifications (Optional)

Untuk dapat notifikasi deployment via email/Slack, edit `.github/workflows/deploy.yml`:

```yaml
# Tambahkan step ini di akhir
- name: Notify via Email
  if: failure()
  uses: dawidd6/action-send-mail@v3
  with:
    server_address: smtp.gmail.com
    server_port: 587
    username: ${{ secrets.MAIL_USERNAME }}
    password: ${{ secrets.MAIL_PASSWORD }}
    subject: ❌ Deployment Failed - Manik Jaya Trans
    body: Deployment to Rumahweb failed. Check GitHub Actions logs.
    to: your-email@example.com
    from: github-actions@yourdomain.com
```

---

## 🔒 Security Best Practices

### 1. Jangan Commit File Sensitif

File yang **TIDAK BOLEH** di-commit:
- `.env` (sudah ada di `.gitignore`)
- `storage/logs/*.log`
- `vendor/` (akan di-install saat deploy)
- `node_modules/` (akan di-install saat deploy)

### 2. Setup APP_DEBUG

```env
# Production
APP_DEBUG=false
APP_ENV=production
```

### 3. Protect .env File

Tambahkan di `.htaccess` (root Laravel):

```apache
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

### 4. Setup HTTPS

Di cPanel, aktifkan **SSL/TLS** (Let's Encrypt gratis):
1. cPanel → SSL/TLS Status
2. Pilih domain
3. Klik **Run AutoSSL**

Update `.env`:
```env
APP_URL=https://yourdomain.com
```

---

## 📞 Support

Jika ada masalah:

1. **Cek GitHub Actions Log** - Lihat error message
2. **Cek Laravel Log** - `storage/logs/laravel.log`
3. **Cek Apache Error Log** - Via cPanel → Errors
4. **Rumahweb Support** - [https://rumahweb.com/support](https://rumahweb.com/support)

---

## 📝 Checklist Deployment

Sebelum deploy, pastikan:

- [ ] Repository GitHub sudah dibuat
- [ ] GitHub Secrets sudah disetup (FTP credentials)
- [ ] Database MySQL sudah dibuat di cPanel
- [ ] File `.env` production sudah dibuat
- [ ] Folder `storage/` dan `bootstrap/cache/` writable
- [ ] `APP_DEBUG=false` di production
- [ ] `APP_URL` sesuai domain
- [ ] Midtrans keys production sudah diisi (jika sudah live)
- [ ] SSL certificate aktif (HTTPS)

---

## 🎉 Selesai!

Setelah semua step diikuti, aplikasi Laravel Manik Jaya Trans Anda akan otomatis ter-deploy setiap kali push ke branch `main`!

**Deployment URL:** `https://yourdomain.com`

---

**Last Updated:** 2026-06-03  
**Version:** 1.0.0
