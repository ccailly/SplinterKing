<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SnapshotsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DropController;
use App\Http\Controllers\RankingController;
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

    Route::prefix('drops')->group(function () {
        Route::get('/', [DropController::class, 'index'])->name('drops.index');
        Route::post('/getReward', [DropController::class, 'getReward'])->name('drops.getReward');
    });

    Route::prefix('/ranking')->group(function () {
        Route::get('/', [RankingController::class, 'shows'])->name('ranking.shows');
    });

    Route::prefix('accounts')->group(function () {
        Route::get('/', [AccountController::class, 'shows'])->name('accounts.shows');
        Route::get('/add', [AccountController::class, 'add'])->name('accounts.add');
        Route::post('/add', [AccountController::class, 'store'])->name('accounts.store');
        Route::get('/{account}/delete', [AccountController::class, 'delete'])->name('accounts.delete');
        Route::post('/{account}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
        Route::get('/{account}/{tab}', [AccountController::class, 'show'])
            ->whereIn('tab', ['Informations', 'Roulette', 'Coupons', 'Snapshots', 'Historique'])->name('accounts.show');
    });

    Route::prefix('snapshots')->group(function () {
        Route::get('/', [SnapshotsController::class, 'shows'])->name('snapshots.shows');

        Route::prefix('requests')->group(function () {
            Route::get('/add', [SnapshotsController::class, 'add'])->name('snapshots.requests.add');
            Route::post('/add', [SnapshotsController::class, 'store'])->name('snapshots.requests.store');
            Route::get('/{snapshot_request_id}', [SnapshotsController::class, 'show'])->name('snapshots.requests.show');
            Route::post('/{snapshot_request_id}/edit', [SnapshotsController::class, 'edit'])->name('snapshots.requests.edit');
            Route::get('/{snapshot_request_id}/delete', [SnapshotsController::class, 'delete'])->name('snapshots.requests.delete');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
