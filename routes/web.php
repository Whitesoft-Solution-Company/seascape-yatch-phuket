<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Login;
use App\Http\Controllers\Report;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookingController::class, 'index'])->name('home');


Route::get('auth/google', [Login::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [Login::class, 'handleGoogleCallback'])->name('google.callback');
Route::post('/logout', [Login::class, 'logout'])->name('logout');
Route::post('login', [Admin::class, 'login'])->name('admin.login');
Route::get('/calendarview', [BookingController::class, 'calendarview'])->name('calendar');
Route::match(['get', 'post'], '/send-line-notify', [BookingController::class, 'sendLineNotify']);

Route::middleware(AdminMiddleware::class)->group(function () {
    // Index - แสดงรายการทั้งหมด
    // routes/web.php
   
    Route::post('/findprice', [BookingController::class, 'findprice'])->name('findprice');
    Route::get('/get-booking-details/{id}', [BookingController::class, 'getBookingDetails']);

    Route::get('admin/agents', [AgentController::class, 'index'])->name('admin.agents.index');

    // Create - แสดงฟอร์มสร้างใหม่
    Route::get('admin/agents/create', [AgentController::class, 'create'])->name('admin.agents.create');

    // Store - บันทึกข้อมูลใหม่
    Route::post('admin/agents', [AgentController::class, 'store'])->name('admin.agents.store');

    // Show - แสดงข้อมูลเดี่ยว
    Route::get('admin/agents/{agent}', [AgentController::class, 'show'])->name('admin.agents.show');

    // Edit - แสดงฟอร์มแก้ไข
    Route::get('admin/agents/{agent}/edit', [AgentController::class, 'edit'])->name('admin.agents.edit');

    // Update - อัปเดตข้อมูล
    Route::put('admin/agents/{agent}', [AgentController::class, 'update'])->name('admin.agents.update');

    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');

    // Destroy - ลบข้อมูล
    Route::delete('admin/agents/{agent}', [AgentController::class, 'destroy'])->name('admin.agents.destroy');
    Route::delete('/admin/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    Route::get('/get-booking/{bookingId}', [Admin::class, 'getBooking']);
    Route::get('/packages/{tripType}', [Admin::class, 'getPackagesByType']);
    Route::get('/admin/bookings', [Admin::class, 'booking'])->name('admin.bookings');
   
    Route::get('/admin/packages', [PackageController::class, 'index'])->name('package');
    Route::put('/admin/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('/admin/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');
    Route::post('/admin/packages', [PackageController::class, 'store'])->name('packages.store');
    Route::post('/booking/addbooking', [BookingController::class, 'addbooking'])->name('booking.addbooking');
    Route::get('/dashboard', [Admin::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/admin/calendar', [BookingController::class, 'calendar'])->name('calendar');

    //report
    Route::get('/report/{id}', [Report::class, 'generateReport'])->name('report.generate');
    Route::post('/get-history', [Report::class, 'getHistory']);
    Route::get('/admin/report', [Report::class, 'index'])->name('report');



    Route::get('/calendar/invoice1/{id}', [Admin::class, 'invoice1'])->name('calendar.invoice1');
    Route::get('/calendar/invoice2/{id}', [Admin::class, 'invoice2'])->name('calendar.invoice2');
    Route::get('/calendar/invoice3/{id}', [Admin::class, 'invoice3'])->name('calendar.invoice3');
});


Route::post('/payment/success', [PaymentController::class, 'payment_success'])
    ->name('payment.success');
Route::get('/checkin/{package_id}', [BookingController::class, 'Checkin'])->name('checkin');
Route::get('/booking_detail/{bid?}', [BookingController::class, 'BookingDetail'])->name('booking_detail');
Route::get('/payment/{bid?}', [PaymentController::class, 'index'])->name('payment');

Route::middleware(UserMiddleware::class)->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/edit-phone', [UserController::class, 'editPhone'])->name('phone.edit');
    Route::post('/update-phone', [UserController::class, 'updatePhone'])->name('phone.update');
    Route::get('/booking/create/{package_id}', [BookingController::class, 'create'])->name('booking.create');

    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
});

require __DIR__ . '/auth.php';
