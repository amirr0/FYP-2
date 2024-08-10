<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Frontend\FrontendChatController;

use App\Http\Controllers\Frontend\FrontendOrderController;
use App\Http\Controllers\Frontend\PackageController as FrontendPackageController;
use App\Http\Controllers\Frontend\ServiceController as FrontendServiceController;
use App\Http\Controllers\BackendOrderController;
use App\Http\Controllers\BackendChatController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return redirect()->route('services.index');
});

// Login Route
Route::get('login', [AuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('register', [AuthController::class, 'showregisterForm'])->name('showregisterForm');
Route::post('register', [AuthController::class, 'register'])->name('register');


Route::get('forget-password', [AuthController::class, 'showForgetForm'])->name('show.forget.form');
Route::post('forget-password', [AuthController::class, 'forgetPassword'])->name('forget.password');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware('auth.check')->group(function () {
    Route::prefix('backend')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');

        // ========== User Module Routes Start ==========

        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('backend.users.index')->middleware('permission.check:view_users');
            Route::get('{user}/show', [UserController::class, 'show'])->name('backend.user.show');
            Route::post('create', [UserController::class, 'store'])->name('backend.user.store')->middleware('permission.check:create_user');
            Route::get('{user}/edit', [UserController::class, 'edit'])->name('backend.user.edit')->middleware('permission.check:edit_user');
            Route::put('{user}/update', [UserController::class, 'update'])->name('backend.user.update')->middleware('permission.check:edit_user');
            Route::delete('{user}/trash-delete', [UserController::class, 'destroy'])->name('backend.user.destroy')->middleware('permission.check:delete_user');
            Route::post('{user}/update-status', [UserController::class, 'updateStatus'])->name('backend.user.updateStatus')->middleware('permission.check:edit_user');
            Route::delete('{id}/permanent-delete', [UserController::class, 'userPermanentDelete'])->name('backend.user.permanent.delete')->middleware('permission.check:delete_user');
            Route::put('{id}/restore', [UserController::class, 'restoreUser'])->name('backend.user.restore');
        });

        // ========== User Module Routes End ==========

        // ========== Services Module Routes Start ==========

        Route::prefix('services')->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('backend.services.index')->middleware('permission.check:view_services');
            Route::post('create', [ServiceController::class, 'store'])->name('backend.service.store')->middleware('permission.check:create_service');
            Route::get('{service}/edit', [ServiceController::class, 'edit'])->name('backend.service.edit')->middleware('permission.check:edit_service');
            Route::put('{service}/update', [ServiceController::class, 'update'])->name('backend.service.update')->middleware('permission.check:edit_service');
            Route::delete('{service}/trash-delete', [ServiceController::class, 'destroy'])->name('backend.service.destroy')->middleware('permission.check:delete_service');
            Route::post('{service}/update-status', [ServiceController::class, 'updateStatus'])->name('backend.service.updateStatus')->middleware('permission.check:edit_service');
            Route::delete('{id}/permanent-delete', [ServiceController::class, 'servicePermanentDelete'])->name('backend.service.permanent.delete')->middleware('permission.check:delete_service');
            Route::put('{id}/restore', [ServiceController::class, 'restoreservice'])->name('backend.service.restore');
        });

        // ========== Services Module Routes End ==========

        // ========== Packages Module Routes Start ==========

        Route::prefix('packages')->group(function () {
            Route::get('/', [PackageController::class, 'index'])->name('backend.packages.index')->middleware('permission.check:view_packages');
            Route::post('create', [PackageController::class, 'store'])->name('backend.package.store')->middleware('permission.check:create_package');
            Route::get('{package}/edit', [PackageController::class, 'edit'])->name('backend.package.edit')->middleware('permission.check:edit_package');
            Route::put('{package}/update', [PackageController::class, 'update'])->name('backend.package.update')->middleware('permission.check:edit_package');
            Route::delete('{package}/trash-delete', [PackageController::class, 'destroy'])->name('backend.package.destroy')->middleware('permission.check:delete_package');
            Route::post('{package}/update-status', [PackageController::class, 'updateStatus'])->name('backend.package.updateStatus')->middleware('permission.check:edit_package');
            Route::delete('{id}/permanent-delete', [PackageController::class, 'packagePermanentDelete'])->name('backend.package.permanent.delete')->middleware('permission.check:delete_package');
            Route::put('{id}/restore', [PackageController::class, 'restorepackage'])->name('backend.package.restore');


            Route::get('/{package}', [ItemController::class, 'index'])
                ->name('backend.items.package')
                ->middleware('permission.check:view_items');
        });

        // ========== Packages Module Routes End ==========
        // ========== Items Module Routes End ==========
        Route::prefix('items')->group(function () {

            Route::get('/', [ItemController::class, 'index'])->name('backend.items.index')->middleware('permission.check:view_items');
            Route::post('create', [ItemController::class, 'store'])->name('backend.item.store')->middleware('permission.check:create_item');
            // Route::post('{package}/create', [ItemController::class, 'store'])->name('backend.item.store')->middleware('permission.check:create_item');
            Route::post('{item}/update-status', [ItemController::class, 'updateStatus'])->name('backend.item.updateStatus')->middleware('permission.check:edit_item');
            Route::delete('{item}/trash-delete', [ItemController::class, 'destroy'])->name('backend.item.destroy')->middleware('permission.check:delete_item');
            Route::get('{item}/edit', [ItemController::class, 'edit'])->name('backend.item.edit')->middleware('permission.check:edit_item');
            Route::put('{item}/update', [ItemController::class, 'update'])->name('backend.item.update')->middleware('permission.check:edit_item');
            Route::delete('{id}/permanent-delete', [ItemController::class, 'itemPermanentDelete'])->name('backend.item.permanent.delete')->middleware('permission.check:delete_item');
            Route::put('{id}/restore', [ItemController::class, 'restoreitem'])->name('backend.item.restore');
        });
        // ========== Items Module Routes End ==========

        // ========== Role Module Routes End ==========

        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('backend.roles.index')->middleware('permission.check:view_roles');
            Route::get('create', [RoleController::class, 'create'])->name('backend.role.create')->middleware('permission.check:create_role');
            Route::post('/', [RoleController::class, 'store'])->name('backend.role.store')->middleware('permission.check:create_role');
            Route::get('{role}', [RoleController::class, 'show'])->name('backend.role.show')->middleware('permission.check:view_role');
            Route::get('{role}/edit', [RoleController::class, 'edit'])->name('backend.role.edit')->middleware('permission.check:edit_role');
            Route::put('{role}', [RoleController::class, 'update'])->name('backend.role.update')->middleware('permission.check:edit_role');
            Route::delete('{role}', [RoleController::class, 'destroy'])->name('backend.role.destroy')->middleware('permission.check:delete_role');
        });

        Route::delete('role-permanent-delete/{id}', [RoleController::class, 'rolePermanentDelete'])->name('backend.role.permanent.delete');
        Route::put('role-restore/{id}', [RoleController::class, 'restoreRole'])->name('backend.role.restore');
        Route::get('view-permission/{id}', [RoleController::class, 'showPermissions'])->name('backend.permission.show');

        // ========== Role Module Routes End ==========




        // ========== Orders Module Routes End ==========

        Route::prefix('orders')->group(function () {
            Route::get('/', [BackendOrderController::class, 'index'])->name('backend.orders.index');
            Route::get('/{orderId}', [BackendOrderController::class, 'show'])->name('orders.show');
            Route::patch('/{order}/status', [BackendOrderController::class, 'updateStatus'])->name('orders.updateStatus');
            Route::patch('/assign', [BackendOrderController::class, 'assignVendor'])->name('orders.assign');
            // Route::patch('/assign', [BackendOrderController::class, 'assignVendor'])->name('orders.assign');
            Route::post('/update-progress', [BackendOrderController::class, 'updateProgress'])->name('orders.updateProgress');
        });
        // ========== Orders Module Routes End ==========

        Route::post('payment-proof-submit', [PaymentController::class, 'uploadProof'])->name('payment.proof.submit');
        Route::post('view-payment-proofs', [PaymentController::class, 'viewUploadedProofs'])->name('view-payment-proofs');
        Route::post('process-stripe-payment', [PaymentController::class, 'processStripePayment'])->name('payment.processStripe');




        Route::put('/profile/update', [UserProfileController::class, 'update'])->name('user.profile.update');
    });

    Route::post('/order/store', [FrontendOrderController::class, 'store'])->name('order.store');
    Route::post('/order/store/stripe', [FrontendOrderController::class, 'storeStripe'])->name('order.store.stripe');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

// ========== Frontend  Routes End ==========
Route::prefix('services')->group(function () {
    Route::get('/', [FrontendServiceController::class, 'index'])->name('services.index');
});
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');


Route::prefix('packages')->group(function () {
    Route::get('/{service}', [FrontendPackageController::class, 'index'])->name('packages.index');
});


// Guest chat routes
Route::prefix('chats')->group(function () {
    Route::get('/', [FrontendChatController::class, 'index'])->name('chat.index');
    Route::post('create', [FrontendChatController::class, 'store'])->name('chat.store');
    Route::post('mark-read', [FrontendChatController::class, 'markRead'])->name('chat.markRead');
});

// Admin chat routes
// routes/web.php
Route::get('/admin/chat/list', [BackendChatController::class, 'listGuests'])->name('admin.chat.list');
Route::get('/admin/chat/index', [BackendChatController::class, 'index'])->name('backend.chat.index');
Route::get('/admin/chat/messages', [BackendChatController::class, 'getMessagesForAdmin'])->name('admin.chat.messages');
Route::post('/admin/chat/store', [BackendChatController::class, 'storeMessageFromAdmin'])->name('admin.chat.store');



// ========== Frontend  Routes End ==========
