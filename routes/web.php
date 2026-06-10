<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\CustomerDashboardController;
use App\Http\Controllers\Frontend\AirportTransferController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\HotelShuttleController;
use App\Http\Controllers\Frontend\TourPackageController;
use App\Http\Controllers\Frontend\VehicleController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes - Frontend
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');

Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

Route::get('/tours', [TourPackageController::class, 'index'])->name('tours.index');
Route::get('/tours/{tour}', [TourPackageController::class, 'show'])->name('tours.show');

Route::get('/transfers', [AirportTransferController::class, 'index'])->name('transfers.index');
Route::get('/transfers/{transfer}', [AirportTransferController::class, 'show'])->name('transfers.show');

Route::get('/shuttles', [HotelShuttleController::class, 'index'])->name('shuttles.index');
Route::get('/shuttles/{shuttle}', [HotelShuttleController::class, 'show'])->name('shuttles.show');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

use App\Http\Controllers\Booking\RentalBookingController;
use App\Http\Controllers\Booking\TourBookingController;
use App\Http\Controllers\Booking\TransferBookingController;
use App\Http\Controllers\Booking\ShuttleBookingController;

use App\Http\Controllers\Frontend\BookingHistoryController;
use App\Http\Controllers\Frontend\InvoiceController;

// Authenticated Routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\Frontend\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\Frontend\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Frontend\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Booking Routes
    Route::get('/booking/vehicles/{vehicle}', [RentalBookingController::class, 'create'])->name('booking.rental.create');
    Route::post('/booking/vehicles/{vehicle}', [RentalBookingController::class, 'store'])->name('booking.rental.store');

    Route::get('/booking/tours/{tour}', [TourBookingController::class, 'create'])->name('booking.tours.create');
    Route::post('/booking/tours/{tour}', [TourBookingController::class, 'store'])->name('booking.tours.store');

    Route::get('/booking/transfers/{transfer}', [TransferBookingController::class, 'create'])->name('booking.transfers.create');
    Route::post('/booking/transfers/{transfer}', [TransferBookingController::class, 'store'])->name('booking.transfers.store');

    Route::get('/booking/shuttles/{shuttle}', [ShuttleBookingController::class, 'create'])->name('booking.shuttles.create');
    Route::post('/booking/shuttles/{shuttle}', [ShuttleBookingController::class, 'store'])->name('booking.shuttles.store');

    // Customer Dashboard & Detail Booking
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/my-bookings', [BookingHistoryController::class, 'index'])->name('bookings.index');

        // Custom route binding with booking_code
        Route::get('/my-bookings/rental/{rental:booking_code}', [RentalBookingController::class, 'show'])->name('rental.show');
        Route::get('/my-bookings/tours/{tourBooking:booking_code}', [TourBookingController::class, 'show'])->name('tours.show');
        Route::get('/my-bookings/transfers/{transferBooking:booking_code}', [TransferBookingController::class, 'show'])->name('transfers.show');
        Route::get('/my-bookings/shuttles/{shuttleBooking:booking_code}', [ShuttleBookingController::class, 'show'])->name('shuttles.show');
    });

    // Payment Route
    Route::post('/payment/{type}/{booking_code}', [\App\Http\Controllers\Frontend\PaymentController::class, 'store'])->name('payment.store');

    // Invoice & Voucher PDF
    Route::get('/customer/my-bookings/{type}/{booking_code}/invoice',
        [InvoiceController::class, 'download']
    )->name('customer.invoice.download')
     ->where('type', 'rental|tour|transfer|shuttle');

    Route::get('/customer/my-bookings/rental/{booking_code}/voucher',
        [InvoiceController::class, 'downloadVoucher']
    )->name('customer.rental.voucher');
});

// Webhook Route
Route::post('/payments/midtrans/callback', [\App\Http\Controllers\Webhook\MidtransCallbackController::class, 'handle'])->name('midtrans.callback');

// Dokumen PDF & Excel (Admin)
require __DIR__ . '/documents.php';
