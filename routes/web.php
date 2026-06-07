<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnerCafeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewReplyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\LocaleController;

// Public routes
Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/discover', [CafeController::class, 'index'])->name('discover');
Route::get('/nearby', function () {
    return redirect()->route('discover', ['sort' => 'nearby']);
})->name('cafes.nearby');
Route::get('/cafe/{slug}', [CafeController::class, 'show'])->name('cafe.show');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reviews (any authenticated user)
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Favorites (any authenticated user)
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// User-only routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

// Owner routes
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerCafeController::class, 'dashboard'])->name('dashboard');
    Route::get('/cafe/create', [OwnerCafeController::class, 'create'])->name('cafe.create');
    Route::post('/cafe', [OwnerCafeController::class, 'store'])->name('cafe.store');
    Route::get('/cafe/edit', [OwnerCafeController::class, 'edit'])->name('cafe.edit');
    Route::put('/cafe', [OwnerCafeController::class, 'update'])->name('cafe.update');

    // Owner reply to reviews
    Route::post('/reviews/{review}/reply', [ReviewReplyController::class, 'store'])->name('reviews.reply');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/cafes', [AdminController::class, 'cafes'])->name('cafes');
    Route::delete('/cafes/{cafe}', [AdminController::class, 'deleteCafe'])->name('cafes.delete');
    Route::patch('/cafes/{cafe}/approve', [AdminController::class, 'approveCafe'])->name('cafes.approve');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

require __DIR__.'/auth.php';
