<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ConferenceController as AdminConferenceController;
use App\Http\Controllers\Admin\DownloadCategoryController;
use App\Http\Controllers\Admin\DownloadController as AdminDownloadController;
use App\Http\Controllers\Admin\HeroBannerController as AdminHeroBannerController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\MembershipApplicationController as AdminMembershipApplicationController;
use App\Http\Controllers\Admin\MembershipArticleController as AdminMembershipArticleController;
use App\Http\Controllers\Admin\MembershipFaqController as AdminMembershipFaqController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\PortalManagerController as AdminPortalManagerController;
use App\Http\Controllers\Admin\ProceedingsTemplateController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JoinSppController;
use App\Http\Controllers\MembershipArticleController;
use App\Http\Controllers\MembershipFaqController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortalAnnouncementController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\VideoController;
use App\Models\Announcement;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ──────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('about', [AboutController::class, 'show'])->name('about.show');
Route::get('news', [NewsController::class, 'index'])->name('news.index');
Route::get('news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('activities/{slug}', [ActivityController::class, 'show'])->name('activities.show');
Route::get('spp', [SppController::class, 'show'])->name('spp.show');
Route::get('videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('membership-faq', [MembershipFaqController::class, 'index'])->name('membership-faq');
Route::get('membership/articles/{slug}', [MembershipArticleController::class, 'show'])->name('membership-articles.show');
Route::get('downloads/{download}/file', [DownloadController::class, 'download'])->name('downloads.download');
Route::get('join-spp', [JoinSppController::class, 'create'])->name('join-spp');
Route::post('join-spp', [JoinSppController::class, 'store'])->name('join-spp.store');

Route::prefix('membership-portal')->name('membership-portal.')->group(function () {
    Route::get('/', function () {
        $announcements = Announcement::query()->published()->latest()->take(3)->get();

        return view('portal.dashboard', compact('announcements'));
    })->name('dashboard');
    Route::view('application', 'portal.application')->name('application');
    Route::view('membership', 'portal.membership')->name('membership');
    Route::view('information', 'portal.information')->name('information');
    Route::view('inquiries', 'portal.inquiries')->name('inquiries');
    Route::get('announcements', [PortalAnnouncementController::class, 'index'])->name('announcements');
    Route::get('notifications', function () {
        $announcements = Announcement::query()->published()->latest()->get();

        return view('portal.notifications', compact('announcements'));
    })->name('notifications');
    Route::view('settings', 'portal.settings')->name('settings');
});

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
    Route::get('admin/membership-portal', [AdminPortalManagerController::class, 'index'])->name('admin.membership-portal');
    Route::get('admin/about', [AdminAboutController::class, 'edit'])->name('admin.about.edit');
    Route::put('admin/about', [AdminAboutController::class, 'update'])->name('admin.about.update');

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

    Route::apiResource('admin/api/videos', AdminVideoController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.api.videos');

    Route::apiResource('admin/api/membership-faqs', AdminMembershipFaqController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.api.membership-faqs');
    Route::get('admin/api/membership-article', [AdminMembershipArticleController::class, 'show'])->name('admin.api.membership-article.show');
    Route::put('admin/api/membership-article', [AdminMembershipArticleController::class, 'update'])->name('admin.api.membership-article.update');

    Route::apiResource('admin/api/download-categories', DownloadCategoryController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.api.download-categories');
    Route::apiResource('admin/api/downloads', AdminDownloadController::class)
        ->only(['store', 'update', 'destroy'])
        ->names('admin.api.downloads');
    Route::get('admin/api/proceedings-template', [ProceedingsTemplateController::class, 'show'])->name('admin.api.proceedings-template.show');
    Route::post('admin/api/proceedings-template', [ProceedingsTemplateController::class, 'update'])->name('admin.api.proceedings-template.update');

    Route::apiResource('admin/api/announcements', AdminAnnouncementController::class)
        ->names('admin.api.announcements');
    Route::patch('admin/api/announcements/{announcement}/status', [AdminAnnouncementController::class, 'updateStatus'])
        ->name('admin.api.announcements.status');

    Route::prefix('admin/api/membership-applications')->name('admin.api.membership-applications.')->group(function () {
        Route::get('/', [AdminMembershipApplicationController::class, 'index'])->name('index');
        Route::get('{application}', [AdminMembershipApplicationController::class, 'show'])->name('show');
        Route::patch('{application}/status', [AdminMembershipApplicationController::class, 'updateStatus'])->name('status');
        Route::delete('{application}', [AdminMembershipApplicationController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/settings.php';
