# 🔧 FTP Upload - Troubleshooting Guide

## ❌ Error: "Unable to resolve connection root. It does not seem to exist"

### Problem
```
Error: Unable to list contents for '/', shallow listing
Reason: Unable to resolve connection root. 
It does not seem to exist: public_html/manikjayatrans.com/image
```

### Cause
Folder path di `FTP_PUBLIC_ROOT` tidak ada di FTP server Anda.

---

## ✅ Solution

### Step 1: Cek Struktur Folder di FTP Server

Gunakan **FileZilla** atau **cPanel File Manager** untuk melihat struktur folder aktual di server Anda.

#### Login FileZilla:
```
Host:     ftp.manikjayatrans.com
Username: admin@manikjayatrans.com
Password: [your FTP password]
Port:     21
```

### Step 2: Identifikasi Root Path Anda

Setelah login FTP, Anda akan melihat struktur seperti ini (contoh):

#### Contoh 1: Root di `/` (Rumahweb Standard)
```
/
├── public_html/
│   ├── index.php
│   ├── .htaccess
│   └── [folder lainnya]
```

**Set di .env:**
```env
FTP_ROOT=/public_html
FTP_PUBLIC_ROOT=/public_html/storage
```

#### Contoh 2: Root sudah di `/public_html/`
```
/
├── manikjayatrans.com/
│   ├── public_html/
│   │   ├── index.php
│   │   └── image/
```

**Set di .env:**
```env
FTP_ROOT=/manikjayatrans.com/public_html
FTP_PUBLIC_ROOT=/manikjayatrans.com/public_html/storage
```

#### Contoh 3: Multiple Domains
```
/
├── public_html/              # Domain utama
│   └── ...
├── manikjayatrans.com/       # Addon domain
│   └── public_html/
│       └── image/
```

**Set di .env:**
```env
FTP_ROOT=/manikjayatrans.com/public_html
FTP_PUBLIC_ROOT=/manikjayatrans.com/public_html/image
```

### Step 3: Buat Folder jika Belum Ada

Via **FileZilla** atau **cPanel File Manager**:

1. Navigate ke folder root Anda
2. Buat folder `storage` (atau `image`, sesuai kebutuhan)
3. Set permissions: **755**

```
[root]/
├── storage/         ← Buat folder ini
│   ├── vehicles/    ← Buat subfolder
│   ├── tours/
│   ├── transfers/
│   └── shuttles/
```

### Step 4: Update `.env`

Sesuaikan dengan struktur folder Anda:

```env
# Sesuaikan dengan struktur folder FTP Anda
FTP_HOST=ftp.manikjayatrans.com
FTP_USERNAME=admin@manikjayatrans.com
FTP_PASSWORD=your_password
FTP_PORT=21
FTP_ROOT=/public_html
FTP_PUBLIC_ROOT=/public_html/storage
FTP_PASSIVE=true
FTP_SSL=false
FTP_TIMEOUT=30
```

### Step 5: Clear Config & Test Lagi

```bash
php artisan config:clear
php artisan ftp:test
```

---

## 🎯 Cara Menemukan Path yang Benar

### Method 1: Via FileZilla

1. Login FTP via FileZilla
2. Lihat panel sebelah kanan (Remote site)
3. Path yang terlihat di address bar adalah path Anda
4. Contoh: `/public_html/` atau `/manikjayatrans.com/public_html/`

### Method 2: Via cPanel File Manager

1. Login cPanel
2. Open **File Manager**
3. Lihat breadcrumb di atas
4. Contoh: `home/username/public_html/`
5. Untuk FTP, hilangkan `home/username`, jadi: `/public_html/`

### Method 3: Via SSH (jika tersedia)

```bash
# Login SSH
ssh username@manikjayatrans.com

# Check current directory
pwd
# Output: /home/username

# Navigate to public_html
cd public_html
pwd
# Output: /home/username/public_html

# Untuk FTP, path relatif dari root FTP
# Biasanya: /public_html
```

---

## 🔄 Common Path Configurations

### Rumahweb Shared Hosting (Standard)

```env
FTP_ROOT=/public_html
FTP_PUBLIC_ROOT=/public_html/storage
```

URL: `https://yourdomain.com/storage/`

### Rumahweb dengan Addon Domain

```env
FTP_ROOT=/yourdomain.com/public_html
FTP_PUBLIC_ROOT=/yourdomain.com/public_html/storage
```

### Rumahweb dengan Subdomain

```env
FTP_ROOT=/public_html/subdomain
FTP_PUBLIC_ROOT=/public_html/subdomain/storage
```

### Laravel Terpisah dari public_html

```env
FTP_ROOT=/laravel-app
FTP_PUBLIC_ROOT=/public_html/storage
```

---

## 🧪 Test dengan Path Sederhana

Jika masih bingung, test dengan path root dulu:

### Step 1: Set Minimal Config

```env
FTP_ROOT=/
FTP_PUBLIC_ROOT=/test
```

### Step 2: Buat Folder `/test` via FileZilla

1. Login FTP
2. Buat folder `test` di root
3. Set permission 755

### Step 3: Test

```bash
php artisan ftp:test
```

Jika berhasil, berarti FTP working. Tinggal adjust path sesuai kebutuhan.

---

## 🐛 Other Common Errors

### Error: "ftp_login(): Login failed"

**Cause:** Username atau password salah

**Solution:**
1. Cek credentials di cPanel → FTP Accounts
2. Reset password FTP jika perlu
3. Pastikan tidak ada typo di `.env`

### Error: "Connection timeout"

**Cause:** 
- Firewall block port 21
- FTP passive mode issue

**Solution:**
```env
# Try passive mode off
FTP_PASSIVE=false

# Or increase timeout
FTP_TIMEOUT=60
```

### Error: "Permission denied"

**Cause:** Folder tidak writable

**Solution:**
1. Set folder permission ke 755 atau 775
2. Via FileZilla: Klik kanan → File permissions
3. Check: Read, Write, Execute untuk Owner

### Error: "SSL/TLS connection failed"

**Cause:** FTP_SSL=true tapi server tidak support FTPS

**Solution:**
```env
FTP_SSL=false
FTP_PORT=21
```

Jika server support FTPS:
```env
FTP_SSL=true
FTP_PORT=990  # FTPS port
```

---

## 📋 Checklist Debugging

- [ ] FTP credentials benar (test via FileZilla)
- [ ] Folder path exists di FTP server
- [ ] Folder permission 755 atau 775
- [ ] Port 21 tidak di-block firewall
- [ ] `FTP_ROOT` path benar (cek via File Manager)
- [ ] `FTP_PUBLIC_ROOT` folder sudah dibuat
- [ ] Config cache cleared (`php artisan config:clear`)
- [ ] Test via `php artisan ftp:test`

---

## 💡 Pro Tips

### Tip 1: Gunakan Path Absolut

Selalu gunakan leading slash `/`:

```env
✅ FTP_ROOT=/public_html
❌ FTP_ROOT=public_html
```

### Tip 2: Test Incremental

Test step by step:
1. Test connection (root path)
2. Test folder listing
3. Test create folder
4. Test upload file
5. Test delete file

### Tip 3: Check via FTP Client First

Sebelum setup Laravel, pastikan FTP working via FileZilla/WinSCP dulu.

### Tip 4: Use Same Credentials

Pastikan credentials yang dipakai di FileZilla sama dengan di `.env`.

---

## 📞 Need Help?

Jika masih error setelah ikuti semua step:

1. **Screenshot error message** lengkap
2. **Screenshot FileZilla** (folder structure)
3. **Copy `.env` FTP config** (hide password)
4. Contact support atau tanyakan ke developer

---

**Last Updated:** 2026-06-03
