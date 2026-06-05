# 🔐 Filament Authentication Customization

Dokumentasi untuk customisasi autentikasi Filament agar redirect ke `/login` (custom) instead of `/admin/login` (default Filament).

---

## 🎯 Problem

**Default Behavior:**
- Filament panel menggunakan halaman login sendiri di `/admin/login`
- Setelah logout dari admin panel, user di-redirect ke `/admin/login`
- Aplikasi kita punya halaman login custom di `/login` yang ingin digunakan untuk semua user (admin & customer)

**Desired Behavior:**
- User yang belum login dan mengakses `/admin` → redirect ke `/login` (bukan `/admin/login`)
- Admin yang logout dari panel → redirect ke `/login`
- Semua authentication menggunakan satu halaman login di `/login`

---

## ✅ Solution Implemented

### 1. Custom Authenticate Middleware (ONLY FILE NEEDED)

**File:** `app/Http/Middleware/FilamentAuthenticate.php`

```php
<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate as BaseAuthenticate;

class FilamentAuthenticate extends BaseAuthenticate
{
    /**
     * Redirect unauthenticated users to custom login page
     */
    protected function redirectTo($request): ?string
    {
        // Always redirect to custom login page instead of /admin/login
        return route('login');
    }
}
```

**Purpose:** Override Filament's default authenticate middleware untuk redirect ke `/login` custom kita.

**Note:** Kita TIDAK perlu custom Login page, cukup override middleware redirect saja.

---

### 2. Updated AdminPanelProvider

**File:** `app/Providers/Filament/AdminPanelProvider.php`

**Changes:**

```php
// Import custom middleware
use App\Http\Middleware\FilamentAuthenticate;

// In panel() method:
return $panel
    // ...
    // NO ->login() configuration needed!
    // ...
    ->authMiddleware([
        FilamentAuthenticate::class,  // Use custom middleware
    ]);
```

**Purpose:** Konfigurasi Filament panel untuk menggunakan custom authenticate middleware.

**Important:** Kita TIDAK set `->login()` di panel configuration, biarkan Filament handle login sendiri tapi dengan custom redirect middleware kita.

---

## 🔄 Authentication Flow

### Before (Default Filament):

```
User → /admin (not authenticated)
  ↓
Filament Authenticate Middleware
  ↓
Redirect to /admin/login
  ↓
User login via Filament form
  ↓
Redirect to /admin
```

### After (Customized):

```
User → /admin (not authenticated)
  ↓
Custom FilamentAuthenticate Middleware
  ↓
Redirect to /login (custom page)
  ↓
User login via custom form
  ↓
LoginController checks role:
  - If admin → redirect to /admin
  - If customer → redirect to /customer/dashboard
```

---

## 📋 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Auth/
│   │       └── LoginController.php  # Custom login logic
│   └── Middleware/
│       └── FilamentAuthenticate.php # Custom auth middleware (ONLY FILE NEEDED)
└── Providers/
    └── Filament/
        └── AdminPanelProvider.php   # Filament config
```

**Note:** Kita TIDAK perlu `app/Filament/Pages/Auth/Login.php` - middleware redirect sudah cukup!

---

## 🧪 Testing

### Test Scenarios:

#### 1. Unauthenticated User Accesses Admin Panel
```
URL: https://manikjayatrans.com/admin
Expected: Redirect to https://manikjayatrans.com/login
```

#### 2. User Directly Accesses Filament Login
```
URL: https://manikjayatrans.com/admin/login
Expected: Redirect to https://manikjayatrans.com/login
```

#### 3. Admin Logout from Panel
```
Action: Click logout in admin panel
Expected: Redirect to https://manikjayatrans.com/login
```

#### 4. Admin Login via Custom Page
```
1. Visit: https://manikjayatrans.com/login
2. Enter admin credentials
3. Expected: Redirect to https://manikjayatrans.com/admin
```

#### 5. Customer Login via Custom Page
```
1. Visit: https://manikjayatrans.com/login
2. Enter customer credentials
3. Expected: Redirect to https://manikjayatrans.com/customer/dashboard
```

---

## 🔍 How It Works

### 1. Middleware Level (FilamentAuthenticate)

```php
// When Filament checks authentication
if (!auth()->check()) {
    // Instead of redirecting to /admin/login (default)
    return redirect()->route('login');  // Redirect to /login (custom)
}
```

**Triggered:**
- Saat user mengakses route `/admin/*` tanpa autentikasi
- Saat session expired
- Saat logout

**Result:**
- User akan di-redirect ke `/login` (custom page kita)
- `/admin/login` tidak akan pernah ditampilkan

### 2. Controller Level (LoginController)

```php
// After successful login
if (Auth::user()->role === 'admin') {
    return redirect()->intended('/admin');  // Admin → admin panel
}

return redirect()->intended(route('customer.dashboard'));  // Customer → dashboard
```

**Triggered:**
- Setelah user berhasil login via `/login`
- Role-based redirect

---

## 🛠️ Troubleshooting

### Problem 1: Still Redirecting to /admin/login

**Possible Causes:**
1. Cache not cleared
2. Middleware not registered

**Solution:**
```bash
# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear

# Restart server
php artisan serve
```

---

### Problem 2: Redirect Loop

**Symptom:** Page keeps redirecting between `/login` and `/admin/login`

**Cause:** Conflict between Filament and custom auth

**Solution:** Check that both files exist:
- `app/Http/Middleware/FilamentAuthenticate.php`
- `app/Filament/Pages/Auth/Login.php`

And verify `AdminPanelProvider` uses both.

---

### Problem 3: Admin Can't Access Panel After Login

**Cause:** `intended()` redirect might be cached to wrong URL

**Solution:** In `LoginController`, use direct redirect:
```php
if (Auth::user()->role === 'admin') {
    return redirect('/admin');  // Direct, not intended
}
```

---

### Problem 4: Customer Redirected to Admin

**Cause:** Role check not working

**Solution:** Verify user has `role` field in database:
```sql
SELECT id, name, email, role FROM users;
```

Should return:
- `admin` for admin users
- `customer` for customer users

---

## 🔒 Security Notes

### 1. Session Management

Logout properly clears session:
```php
Auth::logout();
$request->session()->invalidate();
$request->session()->regenerateToken();
```

### 2. CSRF Protection

All forms protected:
```blade
@csrf
```

### 3. Role Middleware

Admin routes protected:
```php
// Filament uses authMiddleware
->authMiddleware([
    FilamentAuthenticate::class,
])
```

Customer routes protected:
```php
Route::middleware(['auth', 'role:customer'])->group(function () {
    // customer routes
});
```

---

## 📝 Configuration Summary

| Setting | Value | Purpose |
|---------|-------|---------|
| Login Page | `/login` | Custom unified login for all users |
| Admin Panel | `/admin` | Filament admin panel |
| Customer Dashboard | `/customer/dashboard` | Customer area |
| Logout Redirect | `/` | Homepage after logout |
| Failed Auth Redirect | `/login` | When authentication fails |

---

## 🚀 Deployment Notes

### After Deployment:

1. **Clear caches:**
   ```bash
   php artisan config:clear
   php artisan route:clear
   ```

2. **Test all scenarios:**
   - Unauthenticated access to `/admin`
   - Direct access to `/admin/login`
   - Admin login
   - Customer login
   - Admin logout
   - Customer logout

3. **Monitor logs:**
   ```
   storage/logs/laravel.log
   ```

---

## 💡 Why This Approach?

### Alternative Approaches Considered:

#### ❌ Option 1: Disable Filament Login Completely
```php
->login(false)
```
**Problem:** Users can't login to admin panel at all.

#### ❌ Option 2: Use Filament Login Only
```php
// Remove custom /login page
```
**Problem:** Customer experience inconsistent (different login pages).

#### ✅ Option 3: Hybrid Approach (Implemented)
- One unified login page for UX consistency
- Filament automatically redirects to custom login
- Role-based redirect after login
- Best of both worlds

---

## 📚 References

- [Filament Authentication Documentation](https://filamentphp.com/docs/3.x/panels/users#authentication)
- [Laravel Authentication Documentation](https://laravel.com/docs/11.x/authentication)
- [Filament Middleware Documentation](https://filamentphp.com/docs/3.x/panels/configuration#middleware)

---

**Last Updated:** 2026-06-04  
**Version:** 1.0.0  
**Author:** Manik Jaya Trans Development Team
