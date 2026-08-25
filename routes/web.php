<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('index.html', 'welcome');

Route::view('news', 'news')->name('news');
Route::view('news.html', 'news');

Route::view('spp', 'spp')->name('spp.show');
Route::view('spp.html', 'spp');

Route::view('admin', 'dashboard')->name('admin');
Route::view('AdminDashboard.html', 'dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
