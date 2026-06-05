# 🛠️ Tech Stack - Manik Jaya Trans

Dokumentasi lengkap tentang teknologi yang digunakan dalam project Manik Jaya Trans.

---

## 📊 Overview

| Category | Technologies |
|----------|--------------|
| **Backend** | PHP 8.3+, Laravel 13.8, Filament 5.6.6 |
| **Frontend** | Tailwind CSS 4.3, Blade, Alpine.js, Vite 8.0 |
| **Database** | MySQL 5.7+ / 8.0+ |
| **Payment** | Midtrans 2.6 (Sandbox) |
| **Storage** | FTP (Flysystem 3.31) |
| **Email** | SMTP (Mailtrap for dev) |
| **CI/CD** | GitHub Actions |
| **Deployment** | Shared Hosting (Rumahweb) |

---

## 🖥️ Backend Stack

### PHP 8.3+

**Version:** 8.3 (minimum), 8.4 (recommended)

**Why PHP 8.3+?**
- ✅ Type safety improvements
- ✅ Performance optimizations
- ✅ Better error handling
- ✅ Modern syntax (readonly properties, enums)
- ✅ Required by Laravel 13

**Key Features Used:**
- Constructor property promotion
- Named arguments
- Nullsafe operator (`?->`)
- Match expressions
- Attributes

**Installation:**
```bash
# Check PHP version
php -v

# Required extensions
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_MySQL
- Tokenizer
- XML
- GD
- Zip
```

---

### Laravel 13.8

**Version:** 13.8 (latest stable)

**Why Laravel 13?**
- ✅ Latest PHP 8.3+ features
- ✅ Improved performance
- ✅ Better developer experience
- ✅ Modern routing & middleware
- ✅ Enhanced Eloquent ORM

**Key Features Used:**
- **Eloquent ORM** - Database interactions
- **Blade Templates** - Server-side rendering
- **Form Requests** - Input validation
- **Migrations** - Database version control
- **Seeders** - Sample data generation
- **Mail** - Email notifications
- **Observers** - Model event handling
- **Service Layer** - Business logic separation
- **Middleware** - Request filtering
- **Policies** - Authorization

**File Structure:**
```
app/
├── Http/Controllers/     # Request handling
├── Models/               # Database models
├── Services/             # Business logic
├── Mail/                 # Email classes
├── Observers/            # Model events
└── Providers/            # Service providers
```

---

### Filament 5.6.6

**Version:** 5.6.6 (latest stable)

**Why Filament 5?**
- ✅ Powerful admin panel framework
- ✅ Built on Livewire 3
- ✅ Beautiful UI out of the box
- ✅ Rapid CRUD development
- ✅ Extensible & customizable
- ✅ PHP 8.3+ support

**Components Used:**
- **Resources** - 11 CRUD resources
  - Users, Vehicles, Drivers
  - Tour Packages, Airport Transfers, Hotel Shuttles
  - Rental Bookings, Tour Bookings, Transfer Bookings, Shuttle Bookings
  - Payments
- **Dashboard** - Admin overview with widgets
- **Forms** - Complex form building
- **Tables** - Data listing with filters & actions
- **Notifications** - User feedback
- **Custom Pages** - Auth customization

**Configuration:**
```php
// app/Providers/Filament/AdminPanelProvider.php
$panel
    ->id('admin')
    ->path('admin')
    ->colors(['primary' => Color::Amber])
    ->authMiddleware([FilamentAuthenticate::class]);
```

**Resources Structure:**
```
app/Filament/Resources/
├── [Resource]/
│   ├── [Resource]Resource.php    # Main resource class
│   ├── Pages/                     # CRUD pages
│   ├── Schemas/                   # Form schemas
│   └── Tables/                    # Table configurations
```

---

## 🎨 Frontend Stack

### Tailwind CSS 4.3

**Version:** 4.3 (latest)

**Why Tailwind CSS 4?**
- ✅ Native CSS integration (faster builds)
- ✅ New design tokens system
- ✅ Improved performance
- ✅ Better tree-shaking
- ✅ Modern CSS features

**Design Token System:**
```css
/* resources/css/app.css */
@theme {
  --color-carbon-black: #222222;
  --color-canvas-white: #ffffff;
  --color-faint-gray: #f7f7f7;
  --color-storm-gray: #6a6a6a;
  --color-pale-drift: #ebebeb;
  --color-dust-bunny: #a6a6a6;
  --color-soft-divider: #dddddd;
}
```

**Utilities Used:**
- Custom colors (design tokens)
- Responsive classes (`sm:`, `md:`, `lg:`)
- Flexbox & Grid layouts
- Typography utilities
- Spacing (8px grid system)
- Border radius (4/8/12px)

**Configuration:**
```js
// vite.config.js
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    tailwindcss(),
  ],
})
```

---

### Blade Templates

**Version:** Bundled with Laravel 13

**Why Blade?**
- ✅ Native Laravel templating
- ✅ Server-side rendering (SEO friendly)
- ✅ Component system
- ✅ Directives for control flow
- ✅ Layout inheritance

**Template Structure:**
```
resources/views/
├── layouts/
│   ├── app.blade.php        # Authenticated layout
│   └── guest.blade.php      # Guest layout
├── components/              # Reusable components
│   ├── navbar.blade.php
│   ├── footer.blade.php
│   ├── primary-button.blade.php
│   └── status-badge.blade.php
├── frontend/                # Public pages
│   ├── home.blade.php
│   ├── vehicles/
│   ├── tours/
│   ├── transfers/
│   └── shuttles/
├── customer/                # Customer dashboard
└── auth/                    # Authentication pages
```

**Custom Components:**
```blade
<x-navbar />
<x-primary-button>Click me</x-primary-button>
<x-status-badge status="active" />
```

---

### Alpine.js

**Version:** Bundled via Filament

**Why Alpine.js?**
- ✅ Lightweight JavaScript framework
- ✅ Vue-like syntax
- ✅ Perfect for small interactions
- ✅ No build step required
- ✅ Works great with Blade

**Usage:**
- Dropdown menus
- Modal dialogs
- Interactive forms
- Show/hide toggles
- Hero slider

**Example:**
```html
<div x-data="{ open: false }">
  <button @click="open = !open">Toggle</button>
  <div x-show="open">Content</div>
</div>
```

---

### Vite 8.0

**Version:** 8.0 (latest)

**Why Vite 8?**
- ✅ Lightning fast HMR (Hot Module Replacement)
- ✅ Optimized production builds
- ✅ ES modules support
- ✅ Built-in CSS handling
- ✅ Laravel integration

**Configuration:**
```js
// vite.config.js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js'
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
})
```

**Development:**
```bash
npm run dev        # Start dev server with HMR
```

**Production:**
```bash
npm run build      # Build optimized assets
```

---

## 🗄️ Database

### MySQL 8.0+

**Version:** 5.7+ (minimum), 8.0+ (recommended)

**Why MySQL?**
- ✅ Widely supported on shared hosting
- ✅ Mature & reliable
- ✅ Good performance
- ✅ Laravel native support
- ✅ Easy migration tools

**Configuration:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manik_jaya_trans
DB_USERNAME=root
DB_PASSWORD=
```

**Database Structure:**
- **11 Core Tables**
- **Migrations:** Version controlled schema
- **Seeders:** Sample data for development
- **Relations:** Eloquent relationships
- **Indexes:** Optimized queries

**Key Tables:**
```sql
users                  # User accounts
vehicles               # Vehicle inventory
drivers                # Driver management
tour_packages          # Tour packages
airport_transfers      # Airport transfers
hotel_shuttles         # Hotel shuttles
rental_bookings        # Vehicle bookings
tour_bookings          # Tour bookings
transfer_bookings      # Transfer bookings
shuttle_bookings       # Shuttle bookings
payments               # Payment records (polymorphic)
```

---

## 💳 Payment Gateway

### Midtrans 2.6

**Version:** 2.6 (latest)

**Why Midtrans?**
- ✅ Leading payment gateway in Indonesia
- ✅ Multiple payment methods
- ✅ Sandbox environment for testing
- ✅ Good documentation
- ✅ Snap integration (popup)

**Payment Methods Supported:**
- Credit/Debit Cards (Visa, Mastercard)
- Bank Transfer (BCA, Mandiri, BNI, BRI, Permata)
- E-Wallet (GoPay, OVO, DANA, ShopeePay)
- Convenience Store (Alfamart, Indomaret)
- Kredivo, Akulaku (Installment)

**Integration:**
```php
// config/midtrans.php
return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,
];
```

**Flow:**
1. Customer creates booking
2. System generates Snap token
3. Customer completes payment via Snap popup
4. Midtrans sends webhook notification
5. System updates payment status
6. Email notification sent

**Webhook Handler:**
```php
// app/Http/Controllers/Webhook/MidtransCallbackController.php
- Signature validation
- Idempotency check
- Status update
- Notification trigger
```

---

## 📦 Storage

### FTP (Flysystem 3.31)

**Version:** league/flysystem-ftp 3.31

**Why FTP?**
- ✅ Compatible with shared hosting
- ✅ Direct file upload to public URL
- ✅ No local storage needed
- ✅ Laravel Filesystem integration

**Configuration:**
```php
// config/filesystems.php
'ftp' => [
    'driver' => 'ftp',
    'host' => env('FTP_HOST'),
    'username' => env('FTP_USERNAME'),
    'password' => env('FTP_PASSWORD'),
    'port' => (int) env('FTP_PORT', 21),
    'root' => env('FTP_ROOT', '/'),
    'passive' => (bool) env('FTP_PASSIVE', true),
    'ssl' => (bool) env('FTP_SSL', false),
],
'ftp_public' => [
    'driver' => 'ftp',
    // ... same as above
    'url' => env('FTP_URL'),
    'visibility' => 'public',
],
```

**Usage:**
```php
// Upload image via Filament
Storage::disk('ftp_public')
    ->putFileAs('vehicles', $file, $filename);

// Get public URL
Storage::disk('ftp_public')->url($path);
```

**Directory Structure:**
```
public_html/
└── manikjayatrans.com/
    └── image/                 # FTP upload path
        ├── vehicles/
        ├── tours/
        ├── drivers/
        └── users/
```

---

## 📧 Email

### SMTP (Mailtrap for Development)

**Development:** Mailtrap (email testing)
**Production:** SMTP server

**Configuration:**
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io   # Dev only
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@manikjayatrans.com
MAIL_FROM_NAME="Manik Jaya Trans"
```

**Email Classes:**
```php
app/Mail/
├── BookingCreatedMail.php           # Booking confirmation
├── BookingStatusUpdatedMail.php     # Status change
└── PaymentSuccessMail.php           # Payment success
```

**Templates:**
```
resources/views/emails/
├── booking-created.blade.php
├── booking-status-updated.blade.php
└── payment-success.blade.php
```

---

## 🚀 CI/CD & Deployment

### GitHub Actions

**Workflow:** `.github/workflows/deploy.yml`

**Features:**
- ✅ Automated deployment on push to main
- ✅ Composer install (production)
- ✅ NPM install & build
- ✅ FTP upload (incremental)
- ✅ Optional database import

**Workflow Steps:**
1. Checkout code
2. Setup PHP 8.3
3. Install Composer dependencies
4. Setup Node.js 20
5. Install NPM dependencies
6. Build assets (Vite)
7. Create deployment package
8. Upload via FTP
9. Import database (optional)

**Secrets Required:**
```
FTP_SERVER
DEPLOY_FTP_USERNAME
DEPLOY_FTP_PASSWORD
FTP_SERVER_DIR
APP_URL
REMOTE_DB_HOST (optional)
REMOTE_DB_USERNAME (optional)
REMOTE_DB_PASSWORD (optional)
REMOTE_DB_DATABASE (optional)
```

---

## 🔧 Development Tools

### Composer 2.x

**Package Manager:** PHP dependencies

**Key Packages:**
```json
"require": {
  "php": "^8.3",
  "filament/filament": "^5.6",
  "laravel/framework": "^13.8",
  "laravel/tinker": "^3.0",
  "league/flysystem-ftp": "^3.31",
  "midtrans/midtrans-php": "^2.6"
}
```

**Dev Packages:**
```json
"require-dev": {
  "laravel/pint": "^1.27",        # Code formatter
  "phpunit/phpunit": "^12.5.12",  # Testing
  "laravel/pail": "^1.2.5"        # Log viewer
}
```

---

### NPM

**Package Manager:** Frontend dependencies

**Key Packages:**
```json
"devDependencies": {
  "@tailwindcss/vite": "^4.3.0",
  "tailwindcss": "^4.3.0",
  "vite": "^8.0.0",
  "laravel-vite-plugin": "^3.1",
  "concurrently": "^9.0.1"
}
```

---

### Laravel Pint 1.27

**Code Formatter:** PSR-12 based

**Configuration:**
```json
// pint.json
{
  "preset": "laravel"
}
```

**Usage:**
```bash
./vendor/bin/pint              # Format all files
./vendor/bin/pint app/         # Format specific directory
./vendor/bin/pint --test       # Check without fixing
```

---

### PHPUnit 12.5

**Testing Framework:** Unit & Feature tests

**Configuration:**
```xml
<!-- phpunit.xml -->
<phpunit bootstrap="vendor/autoload.php">
  <testsuites>
    <testsuite name="Feature">
      <directory>tests/Feature</directory>
    </testsuite>
    <testsuite name="Unit">
      <directory>tests/Unit</directory>
    </testsuite>
  </testsuites>
</phpunit>
```

**Usage:**
```bash
php artisan test               # Run all tests
php artisan test --filter=BookingTest  # Specific test
```

---

## 📊 Performance

### Optimization Strategies

**Backend:**
- ✅ Composer autoload optimization
- ✅ Config caching
- ✅ Route caching
- ✅ View caching
- ✅ Database query optimization
- ✅ Eager loading (N+1 prevention)

**Frontend:**
- ✅ Vite code splitting
- ✅ CSS purging (Tailwind)
- ✅ Asset minification
- ✅ Image optimization (FTP)
- ✅ Lazy loading

**Production Build:**
```bash
# Backend optimization
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Frontend optimization
npm run build
```

---

## 🔒 Security

### Security Measures

**Backend:**
- ✅ CSRF protection (all forms)
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ Password hashing (bcrypt)
- ✅ Environment variables (.env)
- ✅ Input validation (Form Requests)
- ✅ Authorization (Policies & Middleware)

**Frontend:**
- ✅ XSS prevention (Blade escaping)
- ✅ Content Security Policy
- ✅ HTTPS enforcement (production)

**Payment:**
- ✅ Midtrans signature validation
- ✅ Server-side verification
- ✅ Idempotency checks

---

## 📈 Monitoring & Logging

**Laravel Log:**
```
storage/logs/laravel.log
```

**Log Channels:**
- Stack (default)
- Daily rotation
- Error level filtering

**Viewing Logs:**
```bash
# Using Laravel Pail
php artisan pail

# Or tail
tail -f storage/logs/laravel.log
```

---

## 🔄 Version Control

**Git:**
- Repository: GitHub
- Branch: `main` (production)
- Commit convention: Conventional Commits

**Deployment Flow:**
```
Local Development
     ↓
   Git Push
     ↓
GitHub Repository
     ↓
GitHub Actions CI/CD
     ↓
Rumahweb Shared Hosting
```

---

## 📚 Documentation

All technologies documented in:
- `README.md` - Project overview
- `AGENTS.md` - Development guidelines
- `DEPLOYMENT.md` - Deployment guide
- `docs/SDD.md` - Software design
- Individual feature docs

---

## 🎯 Technology Choices Rationale

### Why This Stack?

**Laravel 13 + PHP 8.3:**
- Modern PHP features
- Mature ecosystem
- Great documentation
- Large community

**Filament 5:**
- Rapid admin development
- Beautiful UI
- Highly customizable
- Laravel native

**Tailwind CSS 4:**
- Utility-first approach
- Fast development
- Consistent design
- Small bundle size

**MySQL:**
- Shared hosting compatible
- Reliable & mature
- Good performance
- Easy to manage

**Midtrans:**
- Indonesia-focused
- Multiple payment methods
- Good support
- Sandbox testing

**FTP Storage:**
- Shared hosting compatible
- Direct public access
- No complexity
- Cost effective

---

## ✅ Summary

This tech stack provides:
- ✅ Modern development experience
- ✅ Production-ready performance
- ✅ Shared hosting compatibility
- ✅ Scalable architecture
- ✅ Security best practices
- ✅ Great developer experience

**Last Updated:** June 2026  
**Stack Version:** 1.0.0
