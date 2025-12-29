<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CarRateController;
use App\Http\Controllers\Admin\CarTypeController;
use App\Http\Controllers\Frontend\FrontendController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/happy-clients', [HomeController::class, 'happyClients'])
    ->name('happy-clients');

Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/price-search', [FrontendController::class, 'index'])->name('frontend.price-search');
Route::post('/car-movers/request', [FrontendController::class, 'requestMove'])
    ->name('car-movers.request');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
        Route::resource('price-list', CarRateController::class);
       Route::resource('car-types', CarTypeController::class);

});
