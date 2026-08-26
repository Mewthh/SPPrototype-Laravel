<?php

use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SppController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ──────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('news', [NewsController::class, 'index'])->name('news.index');
Route::get('news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('spp', [SppController::class, 'show'])->name('spp.show');

// ─── Legacy URLs (Backward Compatibility) ───────────────────────────────────
Route::get('index.html', [HomeController::class, 'index']);
Route::get('news.html', [NewsController::class, 'index']);
Route::get('spp.html', [SppController::class, 'show']);
Route::view('AdminDashboard.html', 'dashboard');

// ─── Admin / Dashboard Routes ───────────────────────────────────────────────
Route::view('admin', 'dashboard')->name('admin');

Route::prefix('admin/api/news')->name('admin.api.news.')->group(function () {
    Route::get('/', [AdminNewsController::class, 'index'])->name('index');
    Route::post('/', [AdminNewsController::class, 'store'])->name('store');
    Route::get('{news}', [AdminNewsController::class, 'show'])->name('show');
    Route::post('{news}', [AdminNewsController::class, 'update'])->name('update.post');
    Route::match(['put', 'patch'], '{news}', [AdminNewsController::class, 'update'])->name('update');
    Route::delete('{news}', [AdminNewsController::class, 'destroy'])->name('destroy');
    Route::patch('{news}/status', [AdminNewsController::class, 'updateStatus'])->name('status');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
