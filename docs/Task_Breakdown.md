# TASK BREAKDOWN DOCUMENT
# Sistem Informasi Travel Manik Jaya Trans

## 1. Ringkasan Project

Project: Sistem Informasi Travel Manik Jaya Trans

Tech Stack:

- Laravel 13
- PHP 8.3+
- Filament 5.6.6
- Tailwind CSS v4.3
- MySQL 5.7+ / 8.0+
- Blade Template
- Vite 8.0
- Midtrans Sandbox 2.6

Metodologi pengerjaan:

- Modular development
- MVC structure
- Feature-based implementation
- Incremental delivery

Target output:

- Website customer
- Admin panel Filament
- Booking system
- Payment integration
- Responsive UI

---

# 2. Phase Breakdown

# 2. Phase Breakdown

Project dibagi menjadi 10 phase utama (Phase 1-9 **Selesai**, Phase 10 **Ongoing**):

1. Project Setup (Selesai)
2. Authentication & Authorization (Selesai)
3. Database & Models (Selesai)
4. Frontend Website (Selesai)
5. Booking System (Selesai)
6. Admin Panel Filament (Selesai)
7. Payment Integration (Selesai)
8. Notification System (Selesai)
9. Testing & Optimization (Selesai)
10. Deployment Preparation (Ongoing)

---

# 3. Phase 1 — Project Setup

## TASK-001 — Setup Laravel Environment

Priority: Critical

Task:

- Install Laravel dependencies
- Setup environment file
- Configure APP_NAME
- Configure APP_URL
- Configure timezone
- Configure locale

Deliverable:

- Laravel project running.

Acceptance Criteria:

- php artisan serve berhasil.
- npm run dev berhasil.

---

## TASK-002 — Setup Database Connection

Priority: Critical

Task:

- Setup MySQL connection.
- Configure .env database.
- Test database connection.

Deliverable:

- Database connected.

Acceptance Criteria:

- php artisan migrate berhasil.

---

## TASK-003 — Setup Tailwind CSS

Priority: Critical

Task:

- Install Tailwind CSS.
- Configure Vite.
- Configure app.css.
- Configure frontend layout.

Deliverable:

- Tailwind berjalan.

Acceptance Criteria:

- Tailwind utility class berhasil dirender.

---

## TASK-004 — Setup Filament 4

Priority: Critical

Task:

- Install Filament.
- Configure admin panel.
- Create admin user.

Deliverable:

- Filament panel berjalan.

Acceptance Criteria:

- /admin dapat diakses admin.

---

# 4. Phase 2 — Authentication & Authorization

## TASK-005 — Customer Authentication

Priority: Critical

Task:

- Register.
- Login.
- Logout.
- Session handling.

Deliverable:

- Customer auth system.

Acceptance Criteria:

- Customer dapat register.
- Customer dapat login.
- Customer dapat logout.

---

## TASK-006 — Role System

Priority: Critical

Task:

- Create role column.
- Create middleware role.
- Restrict admin routes.
- Restrict customer routes.

Deliverable:

- Role-based access control.

Acceptance Criteria:

- Customer tidak dapat akses admin.
- Admin dapat akses admin panel.

---

## TASK-007 — Authorization Policy

Priority: High

Task:

- BookingPolicy.
- UserPolicy.
- Ownership validation.

Deliverable:

- Authorization layer.

Acceptance Criteria:

- Customer hanya dapat akses booking miliknya.

---

# 5. Phase 3 — Database & Models

## TASK-008 — Migration Creation

Priority: Critical

Task:

Create migrations:

- users
- vehicles
- drivers
- tour_packages
- airport_transfers
- hotel_shuttles
- rental_bookings
- tour_bookings
- transfer_bookings
- shuttle_bookings
- payments

Deliverable:

- Database schema.

Acceptance Criteria:

- migrate:fresh berhasil.

---

## TASK-009 — Model Creation

Priority: Critical

Task:

Create models:

- User
- Vehicle
- Driver
- TourPackage
- AirportTransfer
- HotelShuttle
- RentalBooking
- TourBooking
- TransferBooking
- ShuttleBooking
- Payment

Deliverable:

- Model layer.

Acceptance Criteria:

- Relationship berjalan.

---

## TASK-010 — Relationship Setup

Priority: Critical

Task:

Implement:

- hasMany
- belongsTo
- morphOne
- morphTo

Deliverable:

- Relational model working.

Acceptance Criteria:

- eager loading berhasil.

---

## TASK-011 — Seeder Creation

Priority: High

Task:

Create:

- admin user
- customer dummy
- vehicles
- drivers
- tour packages
- airport transfers
- hotel shuttles

Deliverable:

- Seeded project.

Acceptance Criteria:

- migrate:fresh --seed berhasil.

---

# 6. Phase 4 — Frontend Website

## TASK-012 — Layout System

Priority: Critical

Task:

Build:

- navbar
- footer
- guest layout
- authenticated layout

Deliverable:

- Shared UI layout.

Acceptance Criteria:

- Layout reusable.

---

## TASK-013 — Home Page

Priority: High

Task:

Create:

- hero section
- featured services
- featured vehicles
- featured packages

Deliverable:

- Home page.

Acceptance Criteria:

- responsive layout.

---

## TASK-014 — Vehicle Module Frontend

Priority: High

Task:

Create:

- vehicle list page
- vehicle detail page

Deliverable:

- Vehicle browsing.

Acceptance Criteria:

- active vehicle tampil.

---

## TASK-015 — Tour Package Frontend

Priority: High

Task:

Create:

- list page
- detail page

Deliverable:

- Tour package UI.

Acceptance Criteria:

- package detail tampil.

---

## TASK-016 — Airport Transfer Frontend

Priority: High

Task:

Create:

- list page
- detail page

Deliverable:

- Airport transfer browsing.

Acceptance Criteria:

- transfer route tampil.

---

## TASK-017 — Hotel Shuttle Frontend

Priority: High

Task:

Create:

- list page
- detail page

Deliverable:

- Hotel shuttle UI.

Acceptance Criteria:

- shuttle tampil.

---

# 7. Phase 5 — Booking System

## TASK-018 — Booking Code Generator

Priority: Critical

Task:

Build BookingCodeService.

Format:

- RNT-YYYYMMDD-0001
- TOUR-YYYYMMDD-0001
- TRF-YYYYMMDD-0001
- SHT-YYYYMMDD-0001

Deliverable:

- Unique booking generator.

Acceptance Criteria:

- no duplicate code.

---

## TASK-019 — Rental Booking Module

Priority: Critical

Task:

Build:

- controller
- request validation
- booking form
- price calculation

Deliverable:

- Rental booking working.

Acceptance Criteria:

- rental booking tersimpan.

---

## TASK-020 — Tour Booking Module

Priority: Critical

Task:

Build:

- controller
- booking form
- validation
- pricing logic

Deliverable:

- Tour booking working.

Acceptance Criteria:

- booking berhasil.

---

## TASK-021 — Transfer Booking Module

Priority: Critical

Task:

Build:

- transfer booking controller
- validation
- pricing

Deliverable:

- transfer booking system.

Acceptance Criteria:

- booking created.

---

## TASK-022 — Shuttle Booking Module

Priority: Critical

Task:

Build:

- shuttle booking controller
- validation
- pricing

Deliverable:

- shuttle booking system.

Acceptance Criteria:

- booking created.

---

## TASK-023 — Customer Dashboard

Priority: High

Task:

Create:

- booking overview
- booking history
- booking detail

Deliverable:

- dashboard working.

Acceptance Criteria:

- customer lihat booking miliknya.

---

# 8. Phase 6 — Admin Panel Filament

## TASK-024 — UserResource

Priority: High

Task:

Create:

- form schema
- table schema
- filters

Deliverable:

- User CRUD.

Acceptance Criteria:

- CRUD berjalan.

---

## TASK-025 — VehicleResource

Priority: High

Task:

Build CRUD vehicle.

Deliverable:

- Vehicle management.

Acceptance Criteria:

- CRUD working.

---

## TASK-026 — DriverResource

Priority: High

Task:

Build CRUD driver.

Deliverable:

- Driver management.

Acceptance Criteria:

- CRUD working.

---

## TASK-027 — TourPackageResource

Priority: High

Task:

Build CRUD package.

Deliverable:

- Package management.

Acceptance Criteria:

- CRUD working.

---

## TASK-028 — AirportTransferResource

Priority: High

Task:

Build CRUD transfer.

Deliverable:

- Transfer management.

Acceptance Criteria:

- CRUD working.

---

## TASK-029 — HotelShuttleResource

Priority: High

Task:

Build CRUD shuttle.

Deliverable:

- Shuttle management.

Acceptance Criteria:

- CRUD working.

---

## TASK-030 — Booking Resources

Priority: Critical

Task:

Create:

- RentalBookingResource
- TourBookingResource
- TransferBookingResource
- ShuttleBookingResource

Deliverable:

- Booking management.

Acceptance Criteria:

- admin update status.

---

## TASK-031 — PaymentResource

Priority: High

Task:

Create payment management.

Deliverable:

- payment admin page.

Acceptance Criteria:

- payment list tampil.

---

## TASK-032 — Dashboard Widget

Priority: Medium

Task:

Build:

- booking stats
- payment stats
- active services stats

Deliverable:

- dashboard widget.

Acceptance Criteria:

- widget tidak redundant.

---

# 9. Phase 7 — Payment Integration

## TASK-033 — Payment Model Logic

Priority: Critical

Task:

Build:

- payment record
- booking relation
- status sync

Deliverable:

- payment layer.

Acceptance Criteria:

- payment saved.

---

## TASK-034 — Midtrans Integration

Priority: Critical

Task:

Build:

- Snap integration
- redirect url generation

Deliverable:

- Midtrans working.

Acceptance Criteria:

- payment gateway open.

---

## TASK-035 — Midtrans Callback

Priority: Critical

Task:

Implement:

- callback route
- signature validation
- payment update

Deliverable:

- callback working.

Acceptance Criteria:

- payment status update.

---

# 10. Phase 8 — Notification System

## TASK-036 — Mail Configuration

Priority: Medium

Task:

Setup:

- Mailtrap or SMTP.

Deliverable:

- email system.

Acceptance Criteria:

- email terkirim.

---

## TASK-037 — Booking Notification

Priority: Medium

Task:

Create:

- booking created email
- admin booking email

Deliverable:

- booking notification.

Acceptance Criteria:

- email booking terkirim.

---

## TASK-038 — Payment Notification

Priority: Medium

Task:

Create payment success mail.

Deliverable:

- payment email.

Acceptance Criteria:

- email sukses terkirim.

---

# 11. Phase 9 — Testing & Optimization

## TASK-039 — Validation Testing

Priority: Critical

Task:

Test:

- auth validation
- booking validation
- payment validation

Deliverable:

- validated system.

Acceptance Criteria:

- invalid request ditolak.

---

## TASK-040 — Authorization Testing

Priority: Critical

Task:

Test:

- role middleware
- policy ownership
- admin restriction

Deliverable:

- secure access.

Acceptance Criteria:

- unauthorized blocked.

---

## TASK-041 — Responsive Testing

Priority: Medium

Task:

Test:

- desktop
- tablet
- mobile

Deliverable:

- responsive UI.

Acceptance Criteria:

- layout stable.

---

## TASK-042 — Performance Optimization

Priority: Medium

Task:

Optimize:

- eager loading
- pagination
- image handling
- query reduction

Deliverable:

- optimized system.

Acceptance Criteria:

- faster load.

---

# 12. Phase 10 — Deployment Preparation

## TASK-043 — Production Configuration

Priority: Medium

Task:

Configure:

- env production
- cache
- queue
- build assets

Deliverable:

- production ready.

Acceptance Criteria:

- deployment config selesai.

---

## TASK-044 — Deployment Checklist

Priority: Medium

Task:

Prepare:

- migrate
- seed
- npm build
- optimize command

Deliverable:

- deployment checklist.

Acceptance Criteria:

- ready deploy.

---

# 13. Suggested Timeline

## Week 1

- Setup
- Auth
- Database
- Models

## Week 2

- Frontend UI
- Booking system

## Week 3

- Filament admin panel
- Payment integration

## Week 4

- Notification
- Testing
- Optimization
- Deployment prep

---

# 14. Dependency Mapping

```text
Setup
 ↓
Database
 ↓
Models
 ↓
Authentication
 ↓
Frontend
 ↓
Booking
 ↓
Admin Panel
 ↓
Payment
 ↓
Notification
 ↓
Testing
 ↓
Deployment
```

---

# 15. Deliverable Checklist

Core Deliverables:

- Laravel project running
- Database schema
- Model relationship
- Authentication
- Role middleware
- Frontend pages
- Booking system
- Customer dashboard
- Filament admin panel (Single Column Layout & Confirmation Modals)
- Payment integration
- Notification (100% complete)
- Document Generation (Invoice, Voucher, SPK) via DOMPDF
- Laporan Keuangan Export
- Vehicle Inventory System
- WhatsApp integration
- Responsive UI
- Testing
- Deployment readiness

---

# 16. Definition of Done

Project dianggap selesai jika:

- Customer dapat register.
- Customer dapat login.
- Customer dapat melihat layanan.
- Customer dapat booking.
- Customer dapat melihat booking history.
- Payment integration berjalan.
- Admin dapat CRUD data.
- Filament admin panel stabil.
- Dokumen PDF (Invoice, Voucher, SPK) dapat diunduh.
- Laporan Keuangan dapat difilter dan diekspor.
- Validation berjalan.
- Authorization aman.
- Responsive UI selesai.
- migrate:fresh --seed berhasil.
- npm run dev berhasil.
- php artisan serve berhasil.
