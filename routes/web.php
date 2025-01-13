<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HobbyController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes (added by Laravel UI)
Auth::routes();

// Public routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/hobbies', [HobbyController::class, 'index'])->name('hobbies.index');
Route::get('/hobbies/{hobby}', [HobbyController::class, 'show'])->name('hobbies.show');

// Routes that require authentication
Route::middleware(['auth', 'web'])->group(function () {
    // User routes
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Friendship routes
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friendships.index');
    Route::post('/friends/{user}', [FriendshipController::class, 'store'])->name('friendships.store');
    Route::put('/friends/{friendship}', [FriendshipController::class, 'update'])->name('friendships.update');
    Route::delete('/friends/{friendship}', [FriendshipController::class, 'destroy'])->name('friendships.destroy');

    // Message routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');

    // Wishlist route
    Route::post('/wishlist/{user}', [HomeController::class, 'toggleWishlist'])->name('wishlist.toggle');

    // Wallet routes
    Route::get('/wallet', [WalletController::class, 'show'])->name('wallet.show');
    Route::post('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');

    // Payment routes
    Route::get('/payment', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment', [PaymentController::class, 'process'])->name('payment.process');
    Route::post('/payment/overpayment', [PaymentController::class, 'handleOverpayment'])->name('payment.handle-overpayment');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications/{notification}/view', [NotificationController::class, 'viewAndMarkAsRead'])->name('notifications.viewAndMarkAsRead');
});

