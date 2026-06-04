# 📋 Post-Deployment Manual Steps (No SSH Access)

Panduan lengkap untuk menyelesaikan deployment Laravel di shared hosting **tanpa akses SSH**.

---

## 🎯 Overview

Karena server shared hosting Rumahweb Anda **tidak support SSH**, beberapa task post-deployment harus dilakukan **manual via cPanel**:

- ✅ Clear cache files
- ✅ Set permissions
- ✅ Database migrations
- ✅ Configuration caching

**⚡ Good News:** GitHub Actions menggunakan **Incremental FTP Upload** — hanya file yang berubah yang diupload, membuat deployment 60-90% lebih cepat setelah deployment pertama!

See: `INCREMENTAL_DEPLOYMENT.md` untuk detail.

---

## 📝 Checklist Post-Deployment

### ☑️ After Every Deployment

- [ ] Clear cache files (bootstrap/cache)
- [ ] Clear view cache (storage/framework/views)
- [ ] Test application URL
- [ ] Check error logs

### ☑️ First Deployment Only

- [ ] Upload .env file
- [ ] Import database
- [ ] Set folder permissions
- [ ] Verify symlinks

---

## 🔧 Step-by-Step Manual Tasks

### 1️⃣ Verify .env File

#### Via cPanel File Manager:

1. Login cPanel: `https://yourdomain.com/cpanel`
2. Open **File Manager**
3. Navigate to application root (e.g., `/public_html/`)
4. Cek file `.env` exists
5. Klik kanan → **Edit**
6. Verify configuration:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://manikjayatrans.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. **Save Changes**

---

### 2️⃣ Set Folder Permissions

#### Via cPanel File Manager:

1. Navigate to application root
2. Find folder `storage/`
3. **Klik kanan** → **Change Permissions**
4. Set to **755** (rwxr-xr-x):
   - ✅ Read, Write, Execute untuk Owner
   - ✅ Read, Execute untuk Group
   - ✅ Read, Execute untuk World
5. Check **"Recurse into subdirectories"**
6. Click **Change Permissions**

Repeat for:
- `storage/framework/`
- `storage/logs/`
- `bootstrap/cache/`

#### Quick Permission Check:

| Folder | Permission | Owner | Group | Public |
|--------|-----------|-------|-------|--------|
| storage/ | 755 | rwx | r-x | r-x |
| storage/framework/ | 755 | rwx | r-x | r-x |
| storage/logs/ | 755 | rwx | r-x | r-x |
| bootstrap/cache/ | 755 | rwx | r-x | r-x |

---

### 3️⃣ Clear Cache Files

#### Config Cache:

1. Navigate to `bootstrap/cache/`
2. Delete file: `config.php` (if exists)
3. Delete files: `routes-*.php` (all routes cache)

#### View Cache:

1. Navigate to `storage/framework/views/`
2. **Select All** files (compiled Blade views)
3. **Delete**

#### Application Cache:

1. Navigate to `storage/framework/cache/`
2. Delete all files in subdirectories

#### Sessions (Optional - only if issues):

1. Navigate to `storage/framework/sessions/`
2. Delete old session files

---

### 4️⃣ Database Setup (First Deployment)

#### Option A: Import via phpMyAdmin

1. Export database from local:
```bash
# Local machine
php artisan migrate:fresh --seed
mysqldump -u root manik_jaya_trans > database.sql
```

2. Login **phpMyAdmin** di cPanel
3. Select your database
4. Click **Import** tab
5. **Choose File** → `database.sql`
6. Click **Go**

#### Option B: Run Migrations via cPanel Terminal (if available)

If your hosting has cPanel Terminal:

1. Open **Terminal** in cPanel
2. Navigate to application:
```bash
cd public_html/yourdomain/
```

3. Run migrations:
```bash
php artisan migrate --force
php artisan db:seed --force
```

#### Option C: Manual SQL Execution

1. Copy migration SQL from local
2. Run in phpMyAdmin SQL tab

---

### 5️⃣ Storage Link (First Deployment Only)

Since `php artisan storage:link` needs command line, create manually:

#### Via cPanel File Manager:

**Note:** Most shared hosting doesn't allow symlinks via File Manager. 

#### Workaround - Copy Files Instead:

1. Navigate to `storage/app/public/`
2. **Copy** all files
3. Navigate to `public/`
4. Create folder `storage/`
5. **Paste** files inside `public/storage/`

**Note:** Every time you upload new files to storage, you need to copy them manually to `public/storage/`.

#### Better Solution - Use FTP Upload:

Configure uploads to go directly to `public_html/yourdomain/image/` via FTP (already configured in your setup).

---

### 6️⃣ Test Application

#### Basic Tests:

1. **Homepage:**
   ```
   https://manikjayatrans.com
   ```
   - Should load without errors
   - Check CSS/JS loaded (inspect browser console)

2. **Admin Panel:**
   ```
   https://manikjayatrans.com/admin
   ```
   - Login with credentials
   - Test CRUD operations

3. **Database Connection:**
   - Try login/register
   - Should not get database errors

4. **File Upload:**
   - Upload image via admin
   - Check FTP folder has the file
   - Verify image displays on frontend

#### Check Error Logs:

Via cPanel File Manager:

1. Navigate to `storage/logs/`
2. Open `laravel.log`
3. Check for recent errors
4. Common errors to look for:
   - Database connection errors
   - Permission denied errors
   - Missing .env variables
   - Class not found (autoload issue)

---

## 🐛 Troubleshooting

### Problem 1: 500 Internal Server Error

**Causes:**
- Missing or invalid `.env` file
- Wrong folder permissions
- PHP version mismatch
- Missing dependencies

**Solutions:**

1. **Check .env:**
```bash
# Via File Manager, verify:
APP_KEY=base64:...  # Must be set
APP_ENV=production
APP_DEBUG=false
```

2. **Check permissions:**
```bash
storage/ → 755
bootstrap/cache/ → 755
```

3. **Check PHP version:**
- cPanel → Select PHP Version
- Must be PHP 8.3+

4. **View error details temporarily:**
```env
# In .env, temporarily set:
APP_DEBUG=true

# View page error
# Then IMMEDIATELY set back:
APP_DEBUG=false
```

---

### Problem 2: Assets (CSS/JS) Not Loading

**Causes:**
- Wrong `APP_URL` in .env
- Vite manifest not found
- Files not uploaded

**Solutions:**

1. **Check APP_URL:**
```env
# Must match your domain exactly:
APP_URL=https://manikjayatrans.com
```

2. **Verify build files exist:**
```
public/build/manifest.json  ✓
public/build/assets/*.css   ✓
public/build/assets/*.js    ✓
```

3. **Clear browser cache:**
- Hard refresh: Ctrl+Shift+R (Windows)
- Or: Cmd+Shift+R (Mac)

---

### Problem 3: Database Connection Failed

**Causes:**
- Wrong DB credentials
- Database doesn't exist
- DB user not added to database

**Solutions:**

1. **Verify credentials in .env:**
```env
DB_HOST=localhost
DB_DATABASE=mani6391_manik_jaya
DB_USERNAME=mani6391_dbuser
DB_PASSWORD=your_password
```

2. **Check database exists:**
- cPanel → MySQL Databases
- Verify database name

3. **Check user has privileges:**
- cPanel → MySQL Databases
- Verify user added to database
- All privileges granted

---

### Problem 4: Images Not Displaying

**Causes:**
- Storage link not working
- FTP upload path wrong
- Image URL incorrect

**Solutions:**

1. **Check FTP configuration:**
```env
# In .env:
FTP_URL=https://manikjayatrans.com/image
```

2. **Verify image uploaded:**
- Via File Manager, check folder:
  `/public_html/manikjayatrans.com/image/`
- Files should be there

3. **Test direct URL:**
```
https://manikjayatrans.com/image/filename.jpg
```

If can access directly, but not in app, check model accessor.

---

### Problem 5: Can't Clear Cache (No SSH)

**Solution - Manual Deletion:**

Delete these files/folders via File Manager:

```
bootstrap/cache/config.php              → DELETE
bootstrap/cache/routes-*.php            → DELETE
storage/framework/cache/data/*          → DELETE ALL
storage/framework/views/*.php           → DELETE ALL
storage/framework/sessions/*            → DELETE ALL (optional)
```

**Alternative - Cache Clearing Script:**

Create file: `public/clear-cache.php`

```php
<?php
// WARNING: Remove this file after use!
// Only use for emergency cache clearing

$files = [
    __DIR__ . '/../bootstrap/cache/config.php',
    __DIR__ . '/../bootstrap/cache/routes-v7.php',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        unlink($file);
        echo "Deleted: $file<br>";
    }
}

// Clear views
$viewPath = __DIR__ . '/../storage/framework/views/';
$viewFiles = glob($viewPath . '*.php');
foreach ($viewFiles as $file) {
    unlink($file);
}
echo "Cleared compiled views<br>";

echo "<br><strong>Cache cleared! Delete this file now!</strong>";
```

Access: `https://yourdomain.com/clear-cache.php`

**⚠️ IMPORTANT:** Delete `clear-cache.php` immediately after use!

---

## 📊 Deployment Checklist Template

Use this checklist after every deployment:

```
□ Deployment via GitHub Actions completed
□ .env file verified (APP_ENV=production, APP_DEBUG=false)
□ Folder permissions checked (storage 755, bootstrap/cache 755)
□ Cache files deleted:
  □ bootstrap/cache/config.php
  □ bootstrap/cache/routes-*.php
  □ storage/framework/views/*.php
□ Test homepage loads: https://yourdomain.com
□ Test admin panel: https://yourdomain.com/admin
□ Test login functionality
□ Test file upload (if changes made)
□ Check error logs: storage/logs/laravel.log
□ Browser cache cleared
□ Application working as expected
```

---

## 🔄 Workflow Summary

### Every Deployment:

```
1. Push code to GitHub (main branch)
   ↓
2. GitHub Actions auto-deploy via FTP
   ↓
3. Manual: Clear cache via cPanel File Manager
   ↓
4. Manual: Test application
   ↓
5. Manual: Check logs for errors
```

### First Deployment:

```
1. Push code to GitHub
   ↓
2. GitHub Actions auto-deploy
   ↓
3. Upload .env via FTP/File Manager
   ↓
4. Set folder permissions (755)
   ↓
5. Import database via phpMyAdmin
   ↓
6. Clear cache manually
   ↓
7. Test application
```

---

## 💡 Pro Tips

### Tip 1: Keep .env Backup

Always backup your `.env` file before changes:
- Download via FTP
- Save securely (not in Git!)

### Tip 2: Monitor Logs

Check logs regularly:
```
storage/logs/laravel.log
```

Use cPanel File Manager → View → Tail to see latest entries.

### Tip 3: Test Before Deploy

Always test locally first:
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer install --no-dev --optimize-autoloader
npm run build
php artisan serve
```

### Tip 4: Maintenance Mode

If major changes, enable maintenance:

Create file: `storage/framework/down`

Content:
```json
{
    "time": 1234567890,
    "message": "Aplikasi sedang maintenance. Kembali sebentar lagi.",
    "retry": 60
}
```

Users will see maintenance page.

Delete file when done.

### Tip 5: Database Backup

Before migrations, backup database:
- phpMyAdmin → Export → Quick
- Save SQL file locally

---

## 📞 Support Checklist

If you need support, provide:

- [ ] Error message (full text)
- [ ] Screenshot of error page
- [ ] Content of `storage/logs/laravel.log` (last 50 lines)
- [ ] Content of `.env` file (hide passwords!)
- [ ] PHP version (cPanel → Select PHP Version)
- [ ] What you tried to fix it

---

## ✅ Conclusion

Without SSH access, you need to:

1. ✅ Deploy code via GitHub Actions (automated)
2. ✅ Clear cache manually via cPanel File Manager
3. ✅ Set permissions via File Manager
4. ✅ Import database via phpMyAdmin
5. ✅ Monitor logs via File Manager

It's a bit more manual work, but completely doable!

---

**Last Updated:** 2026-06-03  
**Version:** 1.0.0
