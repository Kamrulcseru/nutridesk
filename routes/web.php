<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DietitianMenuController;
use App\Http\Controllers\Admin\FruitController;
use App\Http\Controllers\Admin\KitchenController;
use App\Http\Controllers\Admin\OrderProcessingController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SmsLogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\InvoiceController;
use App\Http\Controllers\Customer\PaymentGatewayController;
use App\Http\Controllers\Customer\PortalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| NutriDesk Web Routes (Public, Customer Portal & Web Admin Panel)
|--------------------------------------------------------------------------
*/

// Public Landing Page & Locale Switcher
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', [HomeController::class, 'setLocale'])->name('set.locale');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register'])->name('register.post');
});

// Authenticated Logout
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout')->middleware('auth');

// Payment Gateway Processing
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/gateway/{order}', [PaymentGatewayController::class, 'showGatewayPage'])->name('payment.gateway.page');
    Route::match(['get', 'post'], '/payment/callback/{order}', [PaymentGatewayController::class, 'processCallback'])->name('payment.callback');
});

// Customer Portal (Requires Auth)
Route::middleware(['auth'])->prefix('portal')->name('customer.')->group(function () {
    Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/checkout/{package}', [PortalController::class, 'showCheckout'])->name('checkout');
    Route::post('/checkout', [PortalController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/subscriptions/{subscription}/pause', [PortalController::class, 'pauseDelivery'])->name('subscriptions.pause');
    Route::post('/subscriptions/{subscription}/resume', [PortalController::class, 'resumeDelivery'])->name('subscriptions.resume');
    Route::get('/orders', [PortalController::class, 'orders'])->name('orders');

    // Invoices & Corporate Receipts
    Route::get('/orders/{order}/invoice', [InvoiceController::class, 'viewInvoice'])->name('orders.invoice');
    Route::get('/orders/{order}/invoice/download', [InvoiceController::class, 'downloadPdf'])->name('orders.invoice.download');
});

// Admin Panel (Protected by Auth & Role: Super Admin, Staff, Dietitian)
Route::middleware(['auth', 'role:super_admin,staff,dietitian'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Analytics
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Order Processing & Deliveries (Accessible to both Super Admin & Staff / Normal User)
    Route::get('/orders', [OrderProcessingController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderProcessingController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [OrderProcessingController::class, 'updateStatus'])->name('orders.status');

    // Kitchen Preparation Board & Delivery Dispatch
    Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
    Route::post('/kitchen/deliveries/{delivery}/status', [KitchenController::class, 'updateDeliveryStatus'])->name('kitchen.status');

    // SMS Notification Logs
    Route::get('/sms', [SmsLogController::class, 'index'])->name('sms.index');

    // Dietitian Menu Planner (Super Admin & Dietitian)
    Route::middleware(['role:super_admin,dietitian'])->group(function () {
        Route::get('/dietitian', [DietitianMenuController::class, 'index'])->name('dietitian.index');
        Route::get('/dietitian/{dietitianMenu}/edit', [DietitianMenuController::class, 'edit'])->name('dietitian.edit');
        Route::put('/dietitian/{dietitianMenu}', [DietitianMenuController::class, 'update'])->name('dietitian.update');

        // Fruit Inventory
        Route::resource('fruits', FruitController::class);
    });

    // Super Admin Exclusive (User Management & Role Permissions, Package Management)
    Route::middleware(['role:super_admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('packages', PackageController::class);
    });
});
