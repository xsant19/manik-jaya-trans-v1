# 📤 FTP Upload Setup Guide

Panduan lengkap untuk setup file upload menggunakan FTP di Laravel untuk Rumahweb Shared Hosting.

---

## 🎯 Kenapa Pakai FTP Upload?

Ketika aplikasi Laravel berjalan di **shared hosting** seperti Rumahweb, menggunakan FTP untuk upload file memberikan beberapa keuntungan:

1. ✅ **Direct Upload** - File langsung ke server tanpa melalui local storage
2. ✅ **Scalability** - Tidak ada batasan storage local
3. ✅ **CDN Ready** - File bisa diakses langsung via URL
4. ✅ **Separation** - Pisahkan storage dari aplikasi
5. ✅ **Backup** - File tetap ada meski aplikasi di-redeploy

---

## 📦 Prerequisites

### 1. Package FTP sudah terinstall

Package `league/flysystem-ftp` sudah ada di `composer.json`:

```json
{
  "require": {
    "league/flysystem-ftp": "^3.31"
  }
}
```

Jika belum terinstall, jalankan:

```bash
composer require league/flysystem-ftp:^3
```

### 2. PHP FTP Extension

Pastikan PHP FTP extension aktif. Cek dengan:

```bash
php -m | grep ftp
```

Output seharusnya: `ftp`

---

## ⚙️ Konfigurasi

### 1. Filesystem Configuration (`config/filesystems.php`)

File ini sudah dikonfigurasi dengan 2 FTP disks:

#### **Disk `ftp` - General FTP Storage**
```php
'ftp' => [
    'driver'   => 'ftp',
    'host'     => env('FTP_HOST'),
    'username' => env('FTP_USERNAME'),
    'password' => env('FTP_PASSWORD'),
    'port'     => env('FTP_PORT', 21),
    'root'     => env('FTP_ROOT', '/public_html'),
    'passive'  => env('FTP_PASSIVE', true),
    'ssl'      => env('FTP_SSL', false),
    'timeout'  => env('FTP_TIMEOUT', 30),
    'url'      => env('FTP_URL', env('APP_URL')),
    'visibility' => 'public',
],
```

#### **Disk `ftp_public` - Public Files (Images, Assets)**
```php
'ftp_public' => [
    'driver'   => 'ftp',
    'host'     => env('FTP_HOST'),
    'username' => env('FTP_USERNAME'),
    'password' => env('FTP_PASSWORD'),
    'port'     => env('FTP_PORT', 21),
    'root'     => env('FTP_PUBLIC_ROOT', '/public_html/storage'),
    'passive'  => env('FTP_PASSIVE', true),
    'ssl'      => env('FTP_SSL', false),
    'timeout'  => env('FTP_TIMEOUT', 30),
    'url'      => rtrim(env('APP_URL'), '/').'/storage',
    'visibility' => 'public',
],
```

### 2. Environment Variables (`.env`)

Tambahkan konfigurasi FTP di `.env`:

```env
# FTP Configuration (for file uploads on shared hosting)
FTP_HOST=ftp.yourdomain.com
FTP_USERNAME=your-ftp-username
FTP_PASSWORD=your-ftp-password
FTP_PORT=21
FTP_ROOT=/public_html
FTP_PUBLIC_ROOT=/public_html/storage
FTP_PASSIVE=true
FTP_SSL=false
FTP_TIMEOUT=30
FTP_URL="${APP_URL}"
```

### 3. Set Default Filesystem (Optional)

Jika ingin semua upload default ke FTP, ubah di `.env`:

```env
FILESYSTEM_DISK=ftp_public
```

Atau tetap pakai `public` (local) untuk development:

```env
# Development (local)
FILESYSTEM_DISK=public

# Production (FTP)
FILESYSTEM_DISK=ftp_public
```

---

## 🔧 Cara Mendapatkan FTP Credentials

### Rumahweb cPanel

1. Login ke **cPanel Rumahweb**
2. Cari menu **FTP Accounts**
3. Buat FTP account atau gunakan yang ada
4. Catat credentials:

```
FTP Server:   ftp.yourdomain.com (atau IP server)
Username:     yourdomain.com atau custom username
Password:     [your FTP password]
Port:         21 (default FTP) atau 22 (SFTP)
Root Path:    /public_html (untuk domain utama)
              /public_html/subdomain (untuk subdomain)
```

### Test FTP Connection

Gunakan FTP client seperti **FileZilla** atau **WinSCP**:

```
Host:     ftp.yourdomain.com
Username: your-username
Password: your-password
Port:     21
```

Pastikan koneksi berhasil sebelum konfigurasi Laravel.

---

## 💻 Cara Menggunakan di Code

### 1. Upload File (Basic)

```php
use Illuminate\Support\Facades\Storage;

// Upload file menggunakan disk FTP
$path = Storage::disk('ftp_public')->put('vehicles', $request->file('image'));

// Atau dengan nama custom
$filename = 'vehicle_' . time() . '.' . $request->file('image')->extension();
$path = Storage::disk('ftp_public')->putFileAs('vehicles', $request->file('image'), $filename);

// Get URL
$url = Storage::disk('ftp_public')->url($path);
```

### 2. Upload Multiple Files

```php
$images = [];
foreach ($request->file('images') as $image) {
    $path = Storage::disk('ftp_public')->put('vehicles', $image);
    $images[] = $path;
}

// Save ke database
$vehicle->image = json_encode($images);
$vehicle->save();
```

### 3. Update File (Replace Old)

```php
// Hapus file lama jika ada
if ($vehicle->image) {
    $oldImages = json_decode($vehicle->image, true);
    foreach ($oldImages as $oldImage) {
        Storage::disk('ftp_public')->delete($oldImage);
    }
}

// Upload file baru
$images = [];
foreach ($request->file('images') as $image) {
    $path = Storage::disk('ftp_public')->put('vehicles', $image);
    $images[] = $path;
}

$vehicle->image = json_encode($images);
$vehicle->save();
```

### 4. Delete File

```php
// Delete single file
Storage::disk('ftp_public')->delete('vehicles/vehicle_123.jpg');

// Delete multiple files
$images = json_decode($vehicle->image, true);
Storage::disk('ftp_public')->delete($images);

// Delete directory
Storage::disk('ftp_public')->deleteDirectory('vehicles');
```

### 5. Check File Exists

```php
if (Storage::disk('ftp_public')->exists($path)) {
    // File exists
}
```

### 6. Get File URL

```php
// Get public URL
$url = Storage::disk('ftp_public')->url($path);
// Output: https://yourdomain.com/storage/vehicles/vehicle_123.jpg

// Get file content
$content = Storage::disk('ftp_public')->get($path);

// Download file
return Storage::disk('ftp_public')->download($path);
```

---

## 🎨 Update Filament Resource untuk FTP Upload

### Example: VehicleForm dengan FTP

File: `app/Filament/Resources/Vehicles/Schemas/VehicleForm.php`

```php
use Filament\Forms\Components\FileUpload;

FileUpload::make('image')
    ->multiple()
    ->image()
    ->disk('ftp_public')  // ← Gunakan FTP disk
    ->directory('vehicles')
    ->visibility('public')
    ->maxFiles(5)
    ->reorderable()
    ->helperText('Upload hingga 5 gambar kendaraan. Gambar akan di-upload langsung ke server via FTP.');
```

---

## 🔄 Update Model untuk FTP URL

### Option 1: Accessor Otomatis

File: `app/Models/Vehicle.php`

```php
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

protected function image(): Attribute
{
    return Attribute::make(
        get: function (?string $value) {
            $images = json_decode($value, true) ?? [];
            
            return array_map(function ($path) {
                // Jika sudah full URL, return as is
                if (filter_var($path, FILTER_VALIDATE_URL)) {
                    return $path;
                }
                
                // Generate URL dari FTP disk
                return Storage::disk('ftp_public')->url($path);
            }, $images);
        },
    );
}
```

### Option 2: Manual di Controller/View

```php
// Di controller
$vehicle = Vehicle::find($id);
$imageUrls = array_map(function($path) {
    return Storage::disk('ftp_public')->url($path);
}, json_decode($vehicle->image, true));

// Di Blade
@foreach($vehicle->image as $imagePath)
    <img src="{{ Storage::disk('ftp_public')->url($imagePath) }}" alt="{{ $vehicle->name }}">
@endforeach
```

---

## 📁 Struktur Folder di FTP Server

Rekomendasi struktur folder:

```
/public_html/
├── index.php                    # Laravel public/index.php
├── .htaccess                    # Laravel .htaccess
├── build/                       # Vite compiled assets
└── storage/                     # FTP upload destination
    ├── vehicles/                # Upload kendaraan
    │   ├── vehicle_123.jpg
    │   └── vehicle_456.jpg
    ├── tours/                   # Upload paket wisata
    ├── transfers/               # Upload transfer
    └── shuttles/                # Upload shuttle
```

**Path Mapping:**
- FTP Path: `/public_html/storage/vehicles/vehicle_123.jpg`
- Public URL: `https://yourdomain.com/storage/vehicles/vehicle_123.jpg`

---

## 🔐 Security & Permissions

### 1. Set Folder Permissions

Via cPanel File Manager atau FTP client:

```
/public_html/storage/  → 755 (rwxr-xr-x)
/public_html/storage/vehicles/  → 755
```

### 2. Protect .env File

Pastikan `.env` **TIDAK** terupload ke FTP server public. Sudah ada di `.gitignore`.

### 3. Validate File Upload

Selalu validasi file sebelum upload:

```php
$request->validate([
    'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
    'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
]);
```

### 4. Sanitize Filename

```php
use Illuminate\Support\Str;

$filename = Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME)) 
    . '_' . time() 
    . '.' . $file->extension();
```

---

## 🧪 Testing FTP Upload

### 1. Test Connection

Buat artisan command untuk test:

```bash
php artisan make:command TestFtpConnection
```

File: `app/Console/Commands/TestFtpConnection.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestFtpConnection extends Command
{
    protected $signature = 'ftp:test';
    protected $description = 'Test FTP connection and upload';

    public function handle()
    {
        $this->info('Testing FTP connection...');
        
        try {
            // Test connection
            $disk = Storage::disk('ftp_public');
            
            // Test write
            $testFile = 'test_' . time() . '.txt';
            $disk->put($testFile, 'Test content from Laravel');
            $this->info('✓ File uploaded successfully');
            
            // Test read
            $content = $disk->get($testFile);
            $this->info('✓ File content: ' . $content);
            
            // Test URL
            $url = $disk->url($testFile);
            $this->info('✓ File URL: ' . $url);
            
            // Test delete
            $disk->delete($testFile);
            $this->info('✓ File deleted successfully');
            
            $this->info('🎉 FTP connection test successful!');
            
        } catch (\Exception $e) {
            $this->error('✗ FTP test failed: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
```

Jalankan:

```bash
php artisan ftp:test
```

### 2. Test Upload via Tinker

```bash
php artisan tinker
```

```php
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// Create fake file
$file = UploadedFile::fake()->image('test.jpg', 800, 600);

// Upload to FTP
$path = Storage::disk('ftp_public')->put('test', $file);

// Get URL
$url = Storage::disk('ftp_public')->url($path);

echo $url;

// Clean up
Storage::disk('ftp_public')->delete($path);
```

---

## 🐛 Troubleshooting

### Problem 1: Connection Timeout

**Error:** `ftp_login(): Login failed` atau `Connection timeout`

**Solusi:**
1. Cek FTP credentials benar
2. Cek firewall/server allow FTP (port 21)
3. Ubah `FTP_PASSIVE=true` menjadi `false` (atau sebaliknya)
4. Tingkatkan timeout: `FTP_TIMEOUT=60`

```env
FTP_PASSIVE=false
FTP_TIMEOUT=60
```

### Problem 2: Permission Denied

**Error:** `Permission denied` saat upload

**Solusi:**
1. Cek permissions folder di FTP server (755)
2. Pastikan user FTP punya write access
3. Coba ubah `FTP_ROOT` ke folder yang punya permission

### Problem 3: Path Not Found

**Error:** `Directory not found: /public_html/storage`

**Solusi:**
1. Buat folder `storage` di `/public_html/` via FTP
2. Atau ubah `FTP_PUBLIC_ROOT` sesuai struktur server Anda

```env
FTP_PUBLIC_ROOT=/public_html/app/storage
```

### Problem 4: URL Tidak Bisa Diakses

**Error:** Image URL return 404

**Solusi:**
1. Pastikan file benar-benar ter-upload (cek via FTP client)
2. Cek `FTP_URL` di `.env` sesuai dengan domain
3. Pastikan tidak ada `.htaccess` yang block folder `storage`

```env
FTP_URL=https://yourdomain.com
```

URL seharusnya: `https://yourdomain.com/storage/vehicles/image.jpg`

### Problem 5: SSL/TLS Error

**Error:** `SSL connection failed`

**Solusi:**
Jika server support FTPS, ubah:

```env
FTP_SSL=true
FTP_PORT=990  # FTPS port (bukan 21)
```

Jika tidak support, tetap:

```env
FTP_SSL=false
FTP_PORT=21
```

---

## 🔄 Migration dari Local Storage ke FTP

Jika sudah ada file di local storage dan ingin pindah ke FTP:

### Artisan Command

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;

class MigrateToFtp extends Command
{
    protected $signature = 'storage:migrate-ftp';
    protected $description = 'Migrate files from local storage to FTP';

    public function handle()
    {
        $this->info('Starting migration to FTP...');
        
        $vehicles = Vehicle::whereNotNull('image')->get();
        $bar = $this->output->createProgressBar($vehicles->count());
        
        foreach ($vehicles as $vehicle) {
            $images = json_decode($vehicle->image, true);
            $newPaths = [];
            
            foreach ($images as $localPath) {
                try {
                    // Get file content from local
                    if (Storage::disk('public')->exists($localPath)) {
                        $content = Storage::disk('public')->get($localPath);
                        
                        // Upload to FTP
                        $newPath = Storage::disk('ftp_public')->put('vehicles', $content);
                        $newPaths[] = $newPath;
                        
                        // Optional: Delete from local
                        // Storage::disk('public')->delete($localPath);
                    }
                } catch (\Exception $e) {
                    $this->error("Failed to migrate: {$localPath}");
                }
            }
            
            if (!empty($newPaths)) {
                $vehicle->image = json_encode($newPaths);
                $vehicle->save();
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->info("\n✓ Migration completed!");
        
        return 0;
    }
}
```

Jalankan:

```bash
php artisan storage:migrate-ftp
```

---

## 📊 Performance Tips

### 1. Use Queues for Large Uploads

```php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;

Queue::push(function () use ($file) {
    Storage::disk('ftp_public')->put('vehicles', $file);
});
```

### 2. Optimize Image Before Upload

```php
use Intervention\Image\Laravel\Facades\Image;

$image = Image::read($request->file('image'))
    ->resize(1200, 800)
    ->toJpeg(80);

Storage::disk('ftp_public')->put('vehicles/image.jpg', $image);
```

### 3. Use CDN (Optional)

Untuk performance lebih baik, consider menggunakan CDN seperti Cloudflare di depan domain Anda.

---

## ✅ Checklist Setup

- [ ] Package `league/flysystem-ftp` terinstall
- [ ] PHP FTP extension aktif
- [ ] FTP credentials sudah didapat dari Rumahweb
- [ ] `.env` dikonfigurasi dengan FTP credentials
- [ ] Test FTP connection via FileZilla/WinSCP
- [ ] Folder `storage` dibuat di `/public_html/`
- [ ] Permissions folder set ke 755
- [ ] Test upload via `php artisan ftp:test`
- [ ] Update Filament form menggunakan disk `ftp_public`
- [ ] Update model accessor untuk generate URL
- [ ] Test upload via admin panel
- [ ] Test akses file via browser

---

## 🎯 Kesimpulan

Dengan setup FTP upload ini:

✅ File upload langsung ke FTP server Rumahweb  
✅ Tidak perlu deploy file setiap kali ada upload baru  
✅ File tetap ada meski aplikasi di-redeploy  
✅ Scalable dan production-ready  

**Next Steps:**
1. Setup FTP credentials di `.env`
2. Test koneksi dengan `php artisan ftp:test`
3. Update Filament forms untuk menggunakan disk `ftp_public`
4. Deploy & enjoy! 🚀

---

**Last Updated:** 2026-06-03  
**Version:** 1.0.0
