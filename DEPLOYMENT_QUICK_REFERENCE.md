# 🚀 Quick Reference - Deployment ke Rumahweb

Cheat sheet cepat untuk deployment Laravel ke Rumahweb Shared Hosting.

---

## 📋 GitHub Secrets yang Diperlukan

```
FTP_SERVER          → ftp.yourdomain.com
FTP_USERNAME        → your-ftp-username
FTP_PASSWORD        → your-ftp-password
FTP_SERVER_DIR      → /public_html/
APP_URL             → https://yourdomain.com
```

**Cara Setup:**
```
GitHub Repo → Settings → Secrets and variables → Actions → New repository secret
```

---

## 🔧 File .env Production (Upload Manual ke Server)

```env
APP_NAME="Manik Jaya Trans"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=username_manik_jaya_trans
DB_USERNAME=username_db_user
DB_PASSWORD=your_db_password

MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false

MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
```

---

## 🚀 Cara Deploy

### Automatic (Recommended)
```bash
git add .
git commit -m "Your commit message"
git push origin main
```
✅ GitHub Actions otomatis deploy!

### Manual (via GitHub UI)
```
1. Buka GitHub Repo
2. Tab "Actions"
3. Pilih workflow "Deploy to Rumahweb"
4. Click "Run workflow"
```

---

## 📂 Struktur Folder di Rumahweb

### Option 1: Simple (Laravel di public_html)
```
/public_html/
├── app/
├── bootstrap/
├── config/
├── public/          ← Document Root
├── resources/
├── storage/
└── vendor/
```

Document Root: `/public_html/public`

### Option 2: Secure (Laravel di luar public)
```
/laravel-app/        ← Aplikasi Laravel
    ├── app/
    ├── bootstrap/
    └── ...

/public_html/        ← Copy isi folder public/ Laravel
    ├── index.php    ← Edit pointing ke ../laravel-app/
    ├── build/
    └── ...
```

Document Root: `/public_html/`

---

## 🗄️ Database Setup (First Time)

### 1. Buat Database di cPanel
```
cPanel → MySQL Databases
- Database: manik_jaya_trans
- User: db_user
- Add user to database (ALL PRIVILEGES)
```

### 2. Import Database
```bash
# Via phpMyAdmin
cPanel → phpMyAdmin → Import → database.sql

# Atau via SSH (jika tersedia)
php artisan migrate --force
php artisan db:seed --force
```

---

## ⚙️ Post-Deployment (First Time)

### 1. Set Permissions
```bash
chmod 755 storage -R
chmod 755 bootstrap/cache -R
```

Via cPanel File Manager:
```
Klik kanan folder → Change Permissions → 755
```

### 2. Create Storage Link
```bash
# Via SSH
php artisan storage:link

# Manual (via File Manager)
public/storage → symlink ke → ../storage/app/public
```

### 3. Cache Configuration
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🧪 Test Deployment Sebelum Push

### Linux/Mac
```bash
chmod +x deploy-local.sh
./deploy-local.sh
```

### Windows
```powershell
.\deploy-local.ps1
```

---

## 🐛 Troubleshooting Common Errors

### 500 Internal Server Error
```bash
# Cek permissions
chmod -R 755 storage bootstrap/cache

# Cek .env
# Pastikan .env ada dan APP_KEY ter-set

# Cek log
tail storage/logs/laravel.log
```

### Assets Not Loading
```env
# Cek APP_URL di .env
APP_URL=https://yourdomain.com

# Jalankan
php artisan storage:link
```

### Database Connection Error
```env
# Cek credentials di .env
DB_HOST=localhost
DB_DATABASE=full_db_name_with_prefix
DB_USERNAME=full_username_with_prefix
```

---

## 📞 FTP Info dari Rumahweb

### Cara Dapatkan FTP Credentials

```
cPanel → FTP Accounts

FTP Server:   ftp.yourdomain.com (atau IP)
Username:     yourdomain.com atau user123
Password:     [yang Anda set]
Port:         21 (default)
Path:         /public_html/
```

### Test FTP Connection
```
Gunakan FileZilla atau WinSCP:
Host: ftp.yourdomain.com
User: your-ftp-username
Pass: your-ftp-password
Port: 21
```

---

## ✅ Checklist Deployment

### Pre-Deployment
- [ ] GitHub Secrets sudah disetup
- [ ] Database MySQL dibuat di cPanel
- [ ] .env production sudah siap
- [ ] FTP credentials sudah di-test
- [ ] Domain/subdomain sudah pointing

### First Deployment
- [ ] Upload .env manual ke server
- [ ] Set permissions (755 storage & bootstrap/cache)
- [ ] Run migration (import database)
- [ ] Create storage symlink
- [ ] Test akses website

### Setiap Deployment
- [ ] Test di local dulu
- [ ] Commit & push ke GitHub
- [ ] Monitor GitHub Actions log
- [ ] Test website setelah deploy
- [ ] Cek log error (jika ada issue)

---

## 🔗 Useful Links

- **GitHub Actions**: [github.com/your-username/repo/actions](https://github.com)
- **Rumahweb cPanel**: `https://yourdomain.com/cpanel`
- **Midtrans Dashboard**: [dashboard.midtrans.com](https://dashboard.midtrans.com)
- **FileZilla**: [filezilla-project.org](https://filezilla-project.org)

---

## 📝 Common Commands

```bash
# Local development
php artisan serve
npm run dev

# Test deployment
./deploy-local.sh        # Linux/Mac
.\deploy-local.ps1       # Windows

# Git commands
git status
git add .
git commit -m "message"
git push origin main

# Laravel commands (via SSH)
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

---

**Last Updated:** 2026-06-03  
**Version:** 1.0.0
