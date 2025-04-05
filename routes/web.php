<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromotionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/admin', function () {
    return view('layout.admin');
});
Route::get('/booking', function () {
    return view('layout.booking');
});

// booking
Route::group(['prefix' => 'booking', 'middleware' => 'auth'], function () {
    Route::get('/index', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/rooms', [BookingController::class, 'rooms'])->name('booking.rooms');
    Route::get('/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::post('/review/{id}', [BookingController::class, 'reviewBooking'])->name('booking.review');
    Route::post('/order', [BookingController::class, 'storeOrder'])->name('booking.store');
    Route::get('/payment/{bill_id}', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/payment/{bill_id}', [BookingController::class, 'processPayment'])->name('booking.process');
    Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history');
});

// promotion(booking)
Route::group(['middleware' => 'auth'], function () {
    Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
    Route::post('/promotions/{id}/claim', [PromotionController::class, 'claimPromotion'])->name('promotions.claim');
});

// promotion
Route::group(['middleware' => ['auth:sanctum', 'role:admin'], 'prefix' => 'promotion'], function () {
    Route::get('/', [PromotionController::class, 'view'])->name('promotion.view');
    Route::get('/search', [PromotionController::class, 'search'])->name('promotion.search');
    Route::get('/create', [PromotionController::class, 'create'])->name('promotion.create');
    Route::post('/store', [PromotionController::class, 'store'])->name('promotion.store');
    Route::get('/edit/{id}', [PromotionController::class, 'edit'])->name('promotion.edit');
    Route::post('/update/{id}', [PromotionController::class, 'update'])->name('promotion.update');
    Route::post('/delete/{id}', [PromotionController::class, 'delete'])->name('promotion.delete');
});

// Login
Route::group(['prefix' => 'login'], function () {
    Route::get('/', [LoginController::class, 'index'])->name('login.index');
    Route::post('/', [LoginController::class, 'login'])->name('login.login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
});

// Register
Route::group(['prefix' => 'auth'], function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('register.index'); // Trang đăng ký
    Route::post('/register', [RegisterController::class, 'register'])->name('register.register'); // Xử lý đăng ký
});

Route::group(['prefix' => 'auth'], function () {
    Route::get('/forgot_pass', [ForgotPasswordController::class, 'index'])->name('forgot_pass.index');
    Route::get('/error', [ErrorController::class, 'index'])->name('404.index');
});

// Dashboard
Route::group(
    ['prefix' => 'dashboard', 'middleware' => ['login', 'role:admin']],function () {
        Route::get('/', [DashBoardController::class, 'index'])->name('dashboard.index');
    }
);


// Customer
Route::group(['middleware' => ['auth:sanctum', 'role:admin'], 'prefix' => 'customer'], function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/search', [CustomerController::class, 'search'])->name('customer.search');
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::post('/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
});

// Staff
Route::group(['middleware' => ['auth:sanctum', 'role:admin'], 'prefix' => 'staff'], function () {
    Route::get('/', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/search', [StaffController::class, 'search'])->name('staff.search');
    Route::get('/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/store', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
    Route::post('/update', [StaffController::class, 'update'])->name('staff.update');
    Route::post('/delete/{id}', [StaffController::class, 'delete'])->name('staff.delete');
});

// Bill
Route::group(['middleware' => ['auth:sanctum', 'role:admin'], 'prefix' => 'bill'], function () {
    Route::get('/', [BillController::class, 'index'])->name('bill.index');
    Route::get('/search', [BillController::class, 'search'])->name('bill.search');
    Route::get('/create', [BillController::class, 'create'])->name('bill.create');
    Route::post('/store', [BillController::class, 'store'])->name('bill.store');
    Route::get('/edit/{id}', [BillController::class, 'edit'])->name('bill.edit');
    Route::post('/update/{id}', [BillController::class, 'update'])->name('bill.update');
    Route::post('/delete/{id}', [BillController::class, 'delete'])->name('bill.delete');
});
// Order
Route::group(['middleware' => ['auth:sanctum', 'role:admin'], 'prefix' => 'order'], function () {
    Route::get('/', [OrderController::class, 'index'])->name('order.index');
    Route::get('/search', [OrderController::class, 'search'])->name('order.search');
    Route::get('/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::post('/update/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::post('/delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
});

// Device
Route::group(['middleware' => ['auth:sanctum', 'role:admin'], 'prefix' => 'device'], function () {
    Route::get('/', [DeviceController::class, 'index'])->name('device.index');
    Route::get('/search', [DeviceController::class, 'search'])->name('device.search');
    Route::get('/create', [DeviceController::class, 'create'])->name('device.create');
    Route::post('/store', [DeviceController::class, 'store'])->name('device.store');
    Route::get('/edit/{id}', [DeviceController::class, 'edit'])->name('device.edit');
    Route::post('/update', [DeviceController::class, 'update'])->name('device.update');
    Route::post('/delete/{id}', [DeviceController::class, 'delete'])->name('device.delete');
});

// Service
Route::group(['middleware' => ['auth:sanctum', 'role:admin'], 'prefix' => 'service'], function () {
    Route::get('/', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/search', [ServiceController::class, 'search'])->name('service.search');
    Route::get('/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::post('/update', [ServiceController::class, 'update'])->name('service.update');
    Route::post('/delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');
});

// Hotel
Route::group(['middleware' => ['auth:sanctum', 'role:admin'], 'prefix' => 'hotel'], function () {
    Route::get('/', [HotelController::class, 'index'])->name('hotel.index');
    Route::get('/search', [HotelController::class, 'search'])->name('hotel.search');
    Route::get('/create', [HotelController::class, 'create'])->name('hotel.create');
    Route::post('/store', [HotelController::class, 'store'])->name('hotel.store');
    Route::get('/edit/{id}', [HotelController::class, 'edit'])->name('hotel.edit');
    Route::post('/update', [HotelController::class, 'update'])->name('hotel.update');
    Route::post('/delete/{id}', [HotelController::class, 'delete'])->name('hotel.delete');
});

// Shift
Route::group(['middleware' => ['auth:sanctum', 'role:admin'], 'prefix' => 'shift'], function () {
    Route::get('/', [ShiftController::class, 'index'])->name('shift.index');
    Route::get('/search', [ShiftController::class, 'search'])->name('shift.search');
    Route::get('/create', [ShiftController::class, 'create'])->name('shift.create');
    Route::post('/store', [ShiftController::class, 'store'])->name('shift.store');
    Route::get('/edit/{id}', [ShiftController::class, 'edit'])->name('shift.edit');
    Route::post('/update', [ShiftController::class, 'update'])->name('shift.update');
    Route::post('/delete/{id}', [ShiftController::class, 'delete'])->name('shift.delete');
});

// Room
Route::group(['middleware' => ['auth:sanctum', 'role:admin'], 'prefix' => 'room'], function () {
    Route::get('/', [RoomController::class, 'index'])->name('room.index');
    Route::get('/search', [RoomController::class, 'search'])->name('room.search');
    Route::get('/create', [RoomController::class, 'create'])->name('room.create');
    Route::post('/store', [RoomController::class, 'store'])->name('room.store');
    Route::get('/edit/{id}', [RoomController::class, 'edit'])->name('room.edit');
    Route::post('/update', [RoomController::class, 'update'])->name('room.update');
    Route::post('/delete/{id}', [RoomController::class, 'delete'])->name('room.delete');
});
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('update.profile');