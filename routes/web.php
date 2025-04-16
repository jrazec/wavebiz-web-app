<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
// For Changing Password
Route::get('/password/change', [App\Http\Controllers\ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');

Route::prefix('admin')->group(function () {
    Route::get('/signin', [App\Http\Controllers\Admin\AdminSigninController::class, 'showSignin'])->name('admin.signin');
    Route::post('/signin', [App\Http\Controllers\Admin\AdminSigninController::class, 'signin'])->name('signin');
    // Route::get('/logout', [App\Http\Controllers\Admin\AdminSigninController::class, 'logout'])->name('admin.logout');
    // Admin Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    // Admin Users
    Route::get('/user', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('admin.memberlist');
    // Route::get('/user/create', [App\Http\Controllers\Admin\AdminUserController::class, 'createUser'])->name('admin.user.create');
    // Route::post('/user/store', [App\Http\Controllers\Admin\AdminUserController::class, 'storeUser'])->name ('admin.user.store');
    // Route::get('/user/edit/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'editUser'])->name('admin.user.edit');
    // Route::post('/user/update/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'updateUser'])->name('admin.user.update');
    // Route::get('/user/delete/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'deleteUser'])->name('admin.user.delete');
    // Admin Products
    Route::get('/products', [App\Http\Controllers\Admin\AdminProductController::class, 'index'])->name('admin.products');
    // Route::get('/products/create', [App\Http\Controllers\Admin\AdminProductController::class, 'createProduct'])->name('admin.products.create');
    // Route::post('/products/store', [App\Http\Controllers\Admin\AdminProductController::class, 'storeProduct'])->name('admin.products.store');
    // Route::get('/products/edit/{id}', [App\Http\Controllers\Admin\AdminProductController::class, 'editProduct'])->name('admin.products.edit');
    // Route::post('/products/update/{id}', [App\Http\Controllers\Admin\AdminProductController::class, 'updateProduct'])->name('admin.products.update');
    // Route::get('/products/delete/{id}', [App\Http\Controllers\Admin\AdminProductController::class, 'deleteProduct'])->name('admin.products.delete');
    // Admin Settings
    Route::get('/settings', [App\Http\Controllers\Admin\AdminSettingsController::class, 'settings'])->name('admin.settings');
    Route::post('/settings/update', [App\Http\Controllers\Admin\AdminSettingsController::class, 'updateSettings'])->name('admin.settings.update');
    // Admin Delivery
    Route::get('/delivery', [App\Http\Controllers\Admin\AdminDeliveryController::class, 'delivery'])->name('admin.delivery');
    Route::post('/delivery/update', [App\Http\Controllers\Admin\AdminDeliveryController::class, 'updateDelivery'])->name('admin.delivery.update');
    //Admin Logs
    Route::get('/logs', [App\Http\Controllers\Admin\AdminAuditLogsController::class, 'logs'])->name('admin.logs');
    
});