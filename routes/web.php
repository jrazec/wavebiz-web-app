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
    // Admin Dashboard
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

        // Products
        Route::get('/products', [App\Http\Controllers\Admin\AdminProductController::class, 'index'])->name('admin.products');
        Route::post('/products/create', [App\Http\Controllers\Admin\AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products/edit', [App\Http\Controllers\Admin\AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::post('/products/delete/', [App\Http\Controllers\Admin\AdminProductController::class, 'delete'])->name('admin.products.delete');
        Route::post('/product-import', [App\Http\Controllers\Admin\AdminProductController::class, 'import'])->name('admin.products.import');
        Route::get('/product-export', [App\Http\Controllers\Admin\AdminProductController::class, 'export'])->name('admin.products.export');

        // Categories
        Route::get('/categories', [App\Http\Controllers\Admin\AdminCategoryController::class, 'index'])->name('admin.categories');
        Route::post('/categories/create', [App\Http\Controllers\Admin\AdminCategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories/edit', [App\Http\Controllers\Admin\AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::post('/categories/delete/', [App\Http\Controllers\Admin\AdminCategoryController::class, 'delete'])->name('admin.categories.delete');

        // Subcategories
        Route::get('/subcategories', [App\Http\Controllers\Admin\AdminSubcategoryController::class, 'index'])->name('admin.subcategories');
        Route::post('/subcategories/create', [App\Http\Controllers\Admin\AdminSubcategoryController::class, 'create'])->name('admin.subcategories.create');
        Route::post('/subcategories/edit', [App\Http\Controllers\Admin\AdminSubcategoryController::class, 'edit'])->name('admin.subcategories.edit');
        Route::post('/subcategories/delete/', [App\Http\Controllers\Admin\AdminSubcategoryController::class, 'delete'])->name('admin.subcategories.delete');

        // Users
        Route::get('/user', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('admin.memberlist');

        // Roles
        Route::get('/roles', [App\Http\Controllers\Admin\AdminRoleController::class, 'index'])->name('admin.roles');


        Route::get('/settings', [App\Http\Controllers\Admin\AdminSettingsController::class, 'settings'])->name('admin.profile');
        // Admin Delivery
        Route::get('/delivery', [App\Http\Controllers\Admin\AdminDeliveryController::class, 'delivery'])->name('admin.delivery');
        Route::post('/delivery/update', [App\Http\Controllers\Admin\AdminDeliveryController::class, 'updateDelivery'])->name('admin.delivery.update');
        //Admin Logs
        Route::get('/logs', [App\Http\Controllers\Admin\AdminAuditLogsController::class, 'logs'])->name('admin.logs');

        // Admin Change Password
        Route::post('/settings', [App\Http\Controllers\Admin\AdminSettingsController::class, 'changePassword'])->name('admin.profile.change-password');
        Route::post('/forgot-password', [App\Http\Controllers\Admin\AdminSettingsController::class, 'changePassword'])->name('admin.profile.forgot-password');

        // Admin Signout

        Route::post('/logout', [App\Http\Controllers\Admin\AdminSigninController::class, 'logout'])->name('admin.logout');
    });

   
    // Route::get('/user/create', [App\Http\Controllers\Admin\AdminUserController::class, 'createUser'])->name('admin.user.create');
    // Route::post('/user/store', [App\Http\Controllers\Admin\AdminUserController::class, 'storeUser'])->name ('admin.user.store');
    // Route::get('/user/edit/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'editUser'])->name('admin.user.edit');
    // Route::post('/user/update/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'updateUser'])->name('admin.user.update');
    // Route::get('/user/delete/{id}', [App\Http\Controllers\Admin\AdminUserController::class, 'deleteUser'])->name('admin.user.delete');
    // Admin Products
  
    
    
    // Admin Settings
  
    
});