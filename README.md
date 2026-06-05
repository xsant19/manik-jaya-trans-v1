# 🚗 Manik Jaya Trans - Travel Management System

> Sistem Informasi Travel untuk layanan sewa kendaraan, paket wisata, airport transfer, dan hotel shuttle di Bali.

[![Laravel](https://img.shields.io/badge/Laravel-13.8-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-5.6.6-F59E0B?style=flat&logo=laravel&logoColor=white)](https://filamentphp.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.3-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

---

## 📋 Table of Contents

- [About](#about)
- [Tech Stack](#tech-stack)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Development](#development)
- [Deployment](#deployment)
- [Project Structure](#project-structure)
- [Documentation](#documentation)
- [License](#license)

---

## 📖 About

**Manik Jaya Trans** adalah sistem informasi travel berbasis web yang menyediakan berbagai layanan transportasi di Bali:

- 🚘 **Sewa Kendaraan** - Full day / Half day rental dengan driver
- 🏝️ **Paket Wisata** - Tour packages ke destinasi populer Bali
- ✈️ **Airport Transfer** - Antar-jemput bandara
- 🏨 **Hotel Shuttle** - Shuttle dari/ke hotel

Sistem ini dibangun dengan fokus pada:
- ✅ User experience yang clean & minimalis
- ✅ Admin panel yang powerful dengan Filament
- ✅ Payment gateway terintegrasi (Midtrans)
- ✅ Responsive design untuk semua devices
- ✅ Automated deployment via GitHub Actions

---

## 🛠️ Tech Stack

### Backend
| Technology | Version | Purpose |
|------------|---------|---------|
| **PHP** | 8.3+ | Server-side language |
| **Laravel** | 13.8 | PHP framework |
| **Filament** | 5.6.6 | Admin panel framework |
| **MySQL** | 5.7+ / 8.0+ | Database |

### Frontend
| Technology | Version | Purpose |
|------------|---------|---------|
| **Tailwind CSS** | 4.3 | Utility-first CSS framework |
| **Blade** | - | Laravel templating engine |
| **Vite** | 8.0 | Frontend build tool |
| **Alpine.js** | - | Lightweight JavaScript framework |

### Payment & Services
| Service | Version | Purpose |
|---------|---------|---------|
| **Midtrans** | 2.6 | Payment gateway (sandbox) |
| **FTP** | Flysystem 3.31 | File storage via FTP |
| **Mailtrap** | - | Email testing (development) |

### Development Tools
| Tool | Version | Purpose |
|------|---------|---------|
| **Composer** | 2.x | PHP dependency manager |
| **NPM** | Latest | Node package manager |
| **Laravel Pint** | 1.27 | Code formatter |
| **PHPUnit** | 12.5 | Testing framework |

---

## ✨ Features

### Customer Features
- 🔐 **Authentication** - Register, login, logout
- 🚗 **Browse & Book** - Vehicle rental, tour packages, transfers, shuttles
- 💳 **Payment** - Midtrans integration (multiple payment methods)
- 📊 **Dashboard** - Booking history, status tracking
- ✉️ **Email Notifications** - Booking confirmations, status updates

### Admin Features (Filament Panel)
- 👥 **User Management** - Manage customers and admins
- 🚘 **Vehicle Management** - CRUD vehicles (with multiple images support)
- 👨‍✈️ **Driver Management** - Assign drivers to bookings
- 🏝️ **Tour Package Management** - CRUD tour packages
- ✈️ **Transfer & Shuttle Management** - Airport & hotel services
- 📋 **Booking Management** - View, approve, update bookings
- 💰 **Payment Tracking** - Monitor payment status
- 📊 **Dashboard Widgets** - Key metrics overview

### Technical Features
- 📱 **Responsive Design** - Mobile, tablet, desktop optimized
- 🎨 **Design System** - Consistent UI with design tokens
- 🔒 **Security** - CSRF protection, role-based access
- 📧 **Email System** - Automated notifications
- 💾 **FTP Upload** - Images stored via FTP
- 🚀 **CI/CD** - GitHub Actions automated deployment
- 🗄️ **Remote Database** - Migration via remote MySQL access

---

## 📦 Requirements

### Minimum Requirements
- **PHP:** 8.3 or higher
- **Composer:** 2.x
- **Node.js:** 20.x LTS
- **NPM:** Latest
- **MySQL:** 5.7+ or 8.0+
- **Web Server:** Apache / Nginx

### Recommended (Development)
- **PHP:** 8.4
- **MySQL:** 8.0+
- **RAM:** 4GB minimum, 8GB recommended
- **Disk Space:** 2GB free space

### Production Server
- **Shared Hosting:** Compatible (no SSH required)
- **FTP Access:** Required for file uploads
- **PHP Extensions:** 
  - BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, PDO_MySQL, Tokenizer, XML, GD, Zip

---

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/manik-jaya-trans-v1.git
cd manik-jaya-trans-v1
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure .env

Edit `.env` file with your configuration:

```env
APP_NAME="Manik Jaya Trans"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manik_jaya_trans
DB_USERNAME=root
DB_PASSWORD=

# Midtrans (Sandbox)
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

# FTP Configuration (Optional for local dev)
FTP_HOST=ftp.yourserver.com
FTP_USERNAME=your_ftp_user
FTP_PASSWORD=your_ftp_password
FTP_PORT=21
FTP_ROOT=/
FTP_PASSIVE=true
FTP_SSL=false
FTP_URL=https://yourserver.com/image

# Mail Configuration (Mailtrap for development)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
```

### 5. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 6. Storage Link (Local Development)

```bash
php artisan storage:link
```

### 7. Build Assets

```bash
# Build for development
npm run dev

# Or build for production
npm run build
```

### 8. Start Development Server

```bash
# Start Laravel server
php artisan serve

# In another terminal, start Vite (for hot reload)
npm run dev
```

Access the application:
- **Frontend:** http://localhost:8000
- **Admin Panel:** http://localhost:8000/admin
  - Email: `admin@manikjaya.test`
  - Password: `password`

---

## 💻 Development

### Quick Start Script

```bash
# One command to start everything
composer dev
```

This will start:
- Laravel server (http://localhost:8000)
- Queue worker
- Vite dev server (hot reload)

### Useful Commands

```bash
# Clear all caches
php artisan optimize:clear

# Format code (Laravel Pint)
./vendor/bin/pint

# Run tests
php artisan test

# Create database dump
php artisan db:dump-schema

# Test FTP connection
php artisan ftp:test
```

### Code Style

Project menggunakan **Laravel Pint** untuk code formatting. Jalankan sebelum commit:

```bash
./vendor/bin/pint
```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=BookingTest
```

---

## 🌐 Deployment

### Automated Deployment (GitHub Actions)

Project sudah dilengkapi CI/CD via GitHub Actions:

```bash
# Push to main branch to trigger auto-deployment
git push origin main
```

**What happens:**
1. ✅ Install dependencies
2. ✅ Build production assets
3. ✅ Deploy via FTP
4. ✅ Import database schema (if configured)

### Manual Deployment

See detailed guide: [`DEPLOYMENT.md`](DEPLOYMENT.md)

**Quick Steps:**

1. **Configure GitHub Secrets:**
   - `FTP_SERVER`, `DEPLOY_FTP_USERNAME`, `DEPLOY_FTP_PASSWORD`
   - `FTP_SERVER_DIR`, `APP_URL`
   - `REMOTE_DB_HOST`, `REMOTE_DB_USERNAME`, `REMOTE_DB_PASSWORD` (optional)

2. **Generate database schema:**
   ```bash
   php artisan db:dump-schema
   git add database/schema.sql
   git commit -m "Update database schema"
   ```

3. **Push to GitHub:**
   ```bash
   git push origin main
   ```

4. **Manual post-deployment tasks:**
   - Upload `.env` via FTP/File Manager
   - Import database via phpMyAdmin or remote connection
   - Clear cache (delete files in `bootstrap/cache/` and `storage/framework/views/`)

---

## 📁 Project Structure

```
manik-jaya-trans-v1/
├── app/
│   ├── Console/Commands/          # Artisan commands
│   ├── Filament/                  # Filament admin panel
│   │   ├── Resources/             # 11 CRUD resources
│   │   ├── Pages/                 # Custom pages
│   │   └── Widgets/               # Dashboard widgets
│   ├── Http/
│   │   ├── Controllers/           # Web controllers
│   │   │   ├── Auth/              # Authentication
│   │   │   ├── Booking/           # Booking logic
│   │   │   ├── Frontend/          # Public pages
│   │   │   ├── Payment/           # Payment handling
│   │   │   └── Webhook/           # Midtrans callback
│   │   ├── Middleware/            # Custom middleware
│   │   └── Requests/              # Form requests
│   ├── Mail/                      # Email classes
│   ├── Models/                    # Eloquent models (11 models)
│   ├── Observers/                 # Model observers
│   ├── Providers/                 # Service providers
│   └── Services/                  # Business logic
│       ├── BookingCodeService.php
│       ├── BookingService.php
│       └── PaymentService.php
├── database/
│   ├── migrations/                # Database migrations
│   ├── seeders/                   # Database seeders
│   └── schema.sql                 # Production schema dump
├── resources/
│   ├── css/
│   │   └── app.css                # Tailwind CSS v4 + design tokens
│   ├── js/
│   │   └── app.js                 # JavaScript entry
│   └── views/
│       ├── auth/                  # Login, register
│       ├── components/            # Blade components
│       ├── customer/              # Customer dashboard
│       ├── frontend/              # Public pages
│       └── layouts/               # Layouts (app, guest)
├── routes/
│   └── web.php                    # Web routes
├── docs/                          # Project documentation
│   ├── PRD.md                     # Product Requirements
│   ├── SRS.md                     # Software Requirements
│   ├── SDD.md                     # Software Design
│   ├── DESIGN.md                  # Design system
│   ├── UI_UX_Flow.md              # UI/UX specifications
│   └── Task_Breakdown.md          # Development phases
├── .github/workflows/             # CI/CD workflows
└── tests/                         # PHPUnit tests
```

---

## 📚 Documentation

### User Documentation
- [📖 README.md](README.md) - This file
- [🚀 DEPLOYMENT.md](DEPLOYMENT.md) - Deployment guide
- [🔧 FTP_UPLOAD_SETUP.md](FTP_UPLOAD_SETUP.md) - FTP configuration
- [🗄️ REMOTE_DATABASE_SETUP.md](REMOTE_DATABASE_SETUP.md) - Remote DB access

### Technical Documentation
- [📝 AGENTS.md](AGENTS.md) - AI agents development guide
- [🎨 docs/DESIGN.md](docs/DESIGN.md) - Design system & tokens
- [🔐 FILAMENT_AUTH_CUSTOMIZATION.md](FILAMENT_AUTH_CUSTOMIZATION.md) - Auth setup

### Product Documentation
- [📋 docs/PRD.md](docs/PRD.md) - Product Requirements Document
- [🔍 docs/SRS.md](docs/SRS.md) - Software Requirements Specification
- [🏗️ docs/SDD.md](docs/SDD.md) - Software Design Document
- [🎯 docs/UI_UX_Flow.md](docs/UI_UX_Flow.md) - UI/UX Flow & Wireframes
- [📊 docs/Task_Breakdown.md](docs/Task_Breakdown.md) - 44 Tasks in 10 Phases

### Changelog
- [📝 CHANGELOG_*.md](.) - Various feature changelogs

---

## 🗄️ Database

### Tables (11 Core Tables)

| Table | Purpose |
|-------|---------|
| `users` | User accounts (admin & customer) |
| `vehicles` | Vehicle inventory |
| `drivers` | Driver management |
| `tour_packages` | Tour packages |
| `airport_transfers` | Airport transfer routes |
| `hotel_shuttles` | Hotel shuttle services |
| `rental_bookings` | Vehicle rental bookings |
| `tour_bookings` | Tour package bookings |
| `transfer_bookings` | Airport transfer bookings |
| `shuttle_bookings` | Hotel shuttle bookings |
| `payments` | Payment transactions (polymorphic) |

### Seeders

```bash
# Seed all data
php artisan db:seed

# Specific seeders
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=VehicleSeeder
php artisan db:seed --class=DriverSeeder
php artisan db:seed --class=TourPackageSeeder
php artisan db:seed --class=AirportTransferSeeder
php artisan db:seed --class=HotelShuttleSeeder
```

---

## 🎨 Design System

### Color Palette

```css
--color-carbon-black: #222222    /* Primary text, buttons */
--color-canvas-white: #ffffff    /* Background */
--color-faint-gray:   #f7f7f7   /* Secondary background */
--color-storm-gray:   #6a6a6a   /* Secondary text */
--color-pale-drift:   #ebebeb   /* Subtle background */
--color-dust-bunny:   #a6a6a6   /* Tertiary elements */
--color-soft-divider: #dddddd   /* Borders, dividers */
```

### Typography

- **Font Family:** System UI stack (substitutes Airbnb Cereal)
- **Heading Sizes:** 32px - 64px
- **Body Text:** 16px - 20px
- **Line Height:** 1.5 - 1.75

### Design Principles

- ❌ No gradients
- ❌ No heavy shadows
- ❌ No blue as primary color
- ✅ High contrast editorial canvas
- ✅ Clean & minimal
- ✅ Consistent spacing (8px grid)

---

## 🔧 Configuration

### Key Configuration Files

- `.env` - Environment variables
- `config/filesystems.php` - FTP storage configuration
- `config/midtrans.php` - Payment gateway settings
- `config/mail.php` - Email configuration
- `tailwind.config.js` - Tailwind CSS configuration
- `vite.config.js` - Vite build configuration

### Environment Variables

See `.env.example` for all available configuration options.

---

## 🐛 Troubleshooting

### Common Issues

**1. Error: "Class Filament\Pages\Auth\Login not found"**
- **Solution:** Check `app/Http/Middleware/FilamentAuthenticate.php` exists
- See: [FILAMENT_AUTH_CUSTOMIZATION.md](FILAMENT_AUTH_CUSTOMIZATION.md)

**2. Images not uploading**
- **Solution:** Check FTP credentials in `.env`
- Test: `php artisan ftp:test`
- See: [FTP_UPLOAD_SETUP.md](FTP_UPLOAD_SETUP.md)

**3. Database connection error**
- **Solution:** Verify database credentials in `.env`
- Check: `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

**4. Payment not working**
- **Solution:** Verify Midtrans credentials
- Check: `MIDTRANS_SERVER_KEY`, `MIDTRANS_CLIENT_KEY`
- Ensure `MIDTRANS_IS_PRODUCTION=false` for testing

**5. Unable to cast value to decimal**
- **Solution:** Models now handle empty price values safely
- Clear cache: `php artisan config:clear`

---

## 🤝 Contributing

### Development Workflow

1. Create feature branch: `git checkout -b feature/nama-fitur`
2. Make changes following code style (run `./vendor/bin/pint`)
3. Test changes: `php artisan test`
4. Commit: `git commit -m "feat: add feature description"`
5. Push: `git push origin feature/nama-fitur`
6. Create Pull Request

### Commit Convention

```
feat: Add new feature
fix: Bug fix
docs: Documentation update
style: Code style changes (formatting)
refactor: Code refactoring
test: Add or update tests
chore: Maintenance tasks
```

---

## 📄 License

This project is developed for academic purposes (Skripsi/Thesis).

**Copyright © 2026 Manik Jaya Trans Development Team**

---

## 👨‍💻 Development Team

- **Developer:** [Your Name]
- **Institution:** D4 TRPL RPL - Politeknik Negeri Bali
- **Supervisor:** [Supervisor Name]
- **Academic Year:** 2025/2026

---

## 📞 Support

For issues, questions, or contributions:

- 📧 Email: [your-email@example.com]
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/manik-jaya-trans-v1/issues)
- 📚 Documentation: See `docs/` folder

---

## 🙏 Acknowledgments

- Laravel Framework Team
- Filament PHP Team
- Tailwind CSS Team
- Midtrans Indonesia
- Politeknik Negeri Bali

---

**Built with ❤️ in Bali, Indonesia**

---

## 📊 Project Status

- ✅ **Phase 1-8:** Completed (Core features, admin panel, frontend)
- ⏳ **Phase 9:** In Progress (Additional features)
- 📅 **Phase 10:** Planned (Polish & optimization)

**Current Version:** 1.0.0-beta  
**Last Updated:** June 2026
