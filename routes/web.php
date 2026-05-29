<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CarRateController;
use App\Http\Controllers\Admin\CarTypeController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Admin\CarProcessController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\CarMoveRequestController;
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'about'])->name('about-us');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/services/{slug}', [HomeController::class, 'serviceShow'])->name('services.single');
Route::get('/happy-clients', [HomeController::class, 'happyClients'])
    ->name('happy-clients');

Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [HomeController::class, 'blogShow'])->name('blog.single');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/price-search', [FrontendController::class, 'index'])->name('frontend.price-search');
Route::post('/car-movers/request', [FrontendController::class, 'requestMove'])
    ->name('car-movers.request');
    Route::post('/contact-submit', [FrontendController::class, 'submit'])
    ->name('contact.submit');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
        Route::resource('price-list', CarRateController::class);
       Route::resource('car-types', CarTypeController::class);
       Route::get('car-process-data', [
    \App\Http\Controllers\Admin\CarProcessController::class,
    'ajaxData'
])->name('car-process.ajax');

         Route::resource('car-process', CarProcessController::class);
         Route::delete(
    'car-process/{id}/remove-image',
    [App\Http\Controllers\Admin\CarProcessController::class, 'removeImage']
)->name('car-process.remove-image');

             Route::get('car-process-gallery',[CarProcessController::class, 'gallery'])->name('car-process.gallery');
Route::get('testimonials-ajax', [TestimonialController::class, 'ajax'])
    ->name('testimonials.ajax');

               Route::resource('testimonials', TestimonialController::class);
                   Route::resource('settings', SettingsController::class)
        ->only(['index', 'store']);
Route::get('about-ajax', [\App\Http\Controllers\Admin\AboutController::class, 'ajax'])
    ->name('about.ajax');

        Route::resource('about', AboutController::class);
Route::get('blogs/ajax', [BlogController::class, 'ajax'])->name('blogs.ajax');
Route::resource('blogs', BlogController::class);
Route::get('admin-services/ajax', [ServiceController::class, 'ajax'])->name('admin-services.ajax');
Route::resource('admin-services', ServiceController::class);
 Route::resource('contact-messages', ContactMessageController::class)
        ->only(['index', 'show', 'destroy']);

    // 🔹 Datatable AJAX (separate route)
    Route::get('contact-messages-ajax',
        [ContactMessageController::class, 'ajax']
    )->name('contact-messages.ajax');

    // 🔹 Mark inactive (custom action)
    Route::post('contact-messages/{id}/inactive',
        [ContactMessageController::class, 'markInactive']
    )->name('contact-messages.inactive');

         Route::resource('car-move-requests', CarMoveRequestController::class)
        ->only(['index','show','destroy']);

    Route::get('car-move-requests-ajax',
        [CarMoveRequestController::class,'ajax']
    )->name('car-move-requests.ajax');

    Route::post('car-move-requests/{id}/status',
        [CarMoveRequestController::class,'updateStatus']);


});
