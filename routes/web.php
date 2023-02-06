<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::redirect('/dashboard', '/');

    Route::prefix('accounts')->group(function () {
        Route::get('/', [AccountController::class, 'shows'])->name('accounts.shows');
        Route::get('/add', [AccountController::class, 'add'])->name('accounts.add');
        Route::post('/add', [AccountController::class, 'store'])->name('accounts.store');
        Route::get('/{account}/delete', [AccountController::class, 'delete'])->name('accounts.delete');
        Route::post('/{account}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
        Route::get('/{account}/{tab}', [AccountController::class, 'show'])
            ->whereIn('tab', ['Informations', 'Roulette', 'Coupons', 'Snapshots', 'Historique'])->name('accounts.show');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
