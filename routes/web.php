<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\ConferenceController as AdminConferenceController;
use App\Http\Controllers\Admin\DownloadCategoryController;
use App\Http\Controllers\Admin\DownloadController as AdminDownloadController;
use App\Http\Controllers\Admin\HeroBannerController as AdminHeroBannerController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\ProceedingsTemplateController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SppController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ──────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('news', [NewsController::class, 'index'])->name('news.index');
Route::get('news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('activities/{slug}', [ActivityController::class, 'show'])->name('activities.show');
Route::get('spp', [SppController::class, 'show'])->name('spp.show');
Route::get('downloads/{download}/file', [DownloadController::class, 'download'])->name('downloads.download');

// ─── Legacy URLs (Backward Compatibility - 301 Redirects) ───────────────────
Route::redirect('index.html', '/', 301);
Route::redirect('news.html', '/news', 301);
Route::redirect('activities.html', '/activities', 301);
Route::redirect('spp.html', '/spp', 301);
Route::redirect('AdminDashboard.html', '/admin', 301);

// ─── Admin / Dashboard Routes ───────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('admin', 'dashboard')->name('admin');
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::post('admin/api/media/upload', [AdminMediaController::class, 'upload'])->name('admin.api.media.upload');

    Route::prefix('admin/api/hero-banner')->name('admin.api.hero-banner.')->group(function () {
        Route::get('/', [AdminHeroBannerController::class, 'show'])->name('show');
        Route::post('/', [AdminHeroBannerController::class, 'update'])->name('update');
        Route::delete('/', [AdminHeroBannerController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/api/news')->name('admin.api.news.')->group(function () {
        Route::get('/', [AdminNewsController::class, 'index'])->name('index');
        Route::post('/', [AdminNewsController::class, 'store'])->name('store');
        Route::get('{news}', [AdminNewsController::class, 'show'])->name('show');
        Route::post('{news}', [AdminNewsController::class, 'update'])->name('update.post');
        Route::match(['put', 'patch'], '{news}', [AdminNewsController::class, 'update'])->name('update');
        Route::delete('{news}', [AdminNewsController::class, 'destroy'])->name('destroy');
        Route::patch('{news}/status', [AdminNewsController::class, 'updateStatus'])->name('status');
    });

    Route::prefix('admin/api/activities')->name('admin.api.activities.')->group(function () {
        Route::get('/', [AdminActivityController::class, 'index'])->name('index');
        Route::post('/', [AdminActivityController::class, 'store'])->name('store');
        Route::get('{activity}', [AdminActivityController::class, 'show'])->name('show');
        Route::post('{activity}', [AdminActivityController::class, 'update'])->name('update.post');
        Route::match(['put', 'patch'], '{activity}', [AdminActivityController::class, 'update'])->name('update');
        Route::delete('{activity}', [AdminActivityController::class, 'destroy'])->name('destroy');
        Route::patch('{activity}/status', [AdminActivityController::class, 'updateStatus'])->name('status');
    });

    Route::prefix('admin/api/conferences')->name('admin.api.conferences.')->group(function () {
        Route::get('/', [AdminConferenceController::class, 'index'])->name('index');
        Route::post('/', [AdminConferenceController::class, 'store'])->name('store');
        Route::get('{conference}', [AdminConferenceController::class, 'show'])->name('show');
        Route::post('{conference}', [AdminConferenceController::class, 'update'])->name('update.post');
        Route::match(['put', 'patch'], '{conference}', [AdminConferenceController::class, 'update'])->name('update');
        Route::delete('{conference}', [AdminConferenceController::class, 'destroy'])->name('destroy');
        Route::patch('{conference}/status', [AdminConferenceController::class, 'updateStatus'])->name('status');
    });

    Route::apiResource('admin/api/download-categories', DownloadCategoryController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.api.download-categories');
    Route::apiResource('admin/api/downloads', AdminDownloadController::class)
        ->only(['store', 'update', 'destroy'])
        ->names('admin.api.downloads');
    Route::get('admin/api/proceedings-template', [ProceedingsTemplateController::class, 'show'])->name('admin.api.proceedings-template.show');
    Route::post('admin/api/proceedings-template', [ProceedingsTemplateController::class, 'update'])->name('admin.api.proceedings-template.update');
});

require __DIR__.'/settings.php';
