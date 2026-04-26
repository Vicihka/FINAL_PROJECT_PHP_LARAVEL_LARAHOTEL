<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GuestBookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// ── Public routes ──────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', fn() => view('about'))->name('about');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{roomType}', [RoomController::class, 'show'])->name('rooms.show');

// ── Auth routes ────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Booking routes (requires login) ───────────────────────────────────────────
Route::post('/rooms/{roomType}/book', [BookingController::class, 'store'])
    ->name('bookings.store')
    ->middleware('auth');

Route::get('/my-bookings', [GuestBookingController::class, 'index'])
    ->name('bookings.my')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/payment/{booking}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{booking}/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
    Route::get('/payment/{booking}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

// ── Admin routes ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Room Types (categories)
    Route::get('/room-types', [Admin\RoomTypeController::class, 'index'])->name('room-types.index');
    Route::get('/room-types/create', [Admin\RoomTypeController::class, 'create'])->name('room-types.create');
    Route::post('/room-types', [Admin\RoomTypeController::class, 'store'])->name('room-types.store');
    Route::get('/room-types/{roomType}/edit', [Admin\RoomTypeController::class, 'edit'])->name('room-types.edit');
    Route::patch('/room-types/{roomType}', [Admin\RoomTypeController::class, 'update'])->name('room-types.update');
    Route::delete('/room-types/{roomType}', [Admin\RoomTypeController::class, 'destroy'])->name('room-types.destroy');

    // Room Categories
    Route::get('/room-categories', [Admin\RoomCategoryController::class, 'index'])->name('room-categories.index');
    Route::get('/room-categories/create', [Admin\RoomCategoryController::class, 'create'])->name('room-categories.create');
    Route::post('/room-categories', [Admin\RoomCategoryController::class, 'store'])->name('room-categories.store');
    Route::get('/room-categories/{roomCategory}/edit', [Admin\RoomCategoryController::class, 'edit'])->name('room-categories.edit');
    Route::patch('/room-categories/{roomCategory}', [Admin\RoomCategoryController::class, 'update'])->name('room-categories.update');
    Route::delete('/room-categories/{roomCategory}', [Admin\RoomCategoryController::class, 'destroy'])->name('room-categories.destroy');

    // Individual Rooms
    Route::get('/rooms', [Admin\RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create', [Admin\RoomController::class, 'create'])->name('rooms.create');
    Route::get('/rooms/bulk-create', [Admin\RoomController::class, 'bulkCreate'])->name('rooms.bulk-create');
    Route::post('/rooms/bulk', [Admin\RoomController::class, 'bulkStore'])->name('rooms.bulk-store');
    Route::post('/rooms', [Admin\RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}/edit', [Admin\RoomController::class, 'edit'])->name('rooms.edit');
    Route::patch('/rooms/{room}', [Admin\RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [Admin\RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::patch('/rooms/{room}/status', [Admin\RoomController::class, 'updateStatus'])->name('rooms.status');

    // Bookings
    Route::get('/bookings', [Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [Admin\BookingController::class, 'updateStatus'])->name('bookings.status');
    Route::get('/bookings/{booking}/checkin-slip', [Admin\BookingController::class, 'checkinSlip'])->name('bookings.checkin-slip');

    // Guests
    Route::get('/guests', [Admin\GuestController::class, 'index'])->name('guests.index');

    // Contact Messages
    Route::get('/messages', [Admin\MessageController::class, 'index'])->name('messages.index');
});
