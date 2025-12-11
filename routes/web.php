<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EventsCalendarController;
use App\Http\Controllers\GalleryCategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrthodoxCalendarController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TemplePageController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/test', [TestController::class, 'test']);

Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('/calendar', [PageController::class, 'calendar'])->name('calendar');
Route::get('/news', [PageController::class, 'news'])->name('news.index');
Route::get('/news/{slug}', [PageController::class, 'newsRead'])->name('news.read');

Route::get('/activity', [PageController::class, 'activity'])->name('activity.index');
Route::get('/activity/{slug}', [PageController::class, 'activityRead'])->name('activity.read');

Route::get('/temple', [PageController::class, 'temple'])->name('temple');

Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/gallery/desc', function () {
    return view('gallery/index');
})->name('gallery.desc');

Route::get('/zapiski', function () {
    return view('zapiskiAndTreby/zapiski');
})->name('zapiski');

Route::get('/treby', function () {
    return view('zapiskiAndTreby/treby');
})->name('treby');

Route::get('/park', function () {
    return view('park');
})->name('park');

Route::get('/api/calendar/events', [CalendarController::class, 'index'])->name('calendar.events');

Route::get('/contact', function () {
    return view('contacts/index');
})->name('contact');

Route::get('/personal-data', function () {
    return view('personal-data/index');
})->name('personal-data');

Route::get('/privacy-policy', function () {
    return view('privacy-policy/index');
})->name('privacy-policy');

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    // Сначала регистрируем категории галереи (более специфичный маршрут)
    Route::resource('gallery-categories', GalleryCategoryController::class)->names([
        'index' => 'gallery.categories.index',
        'create' => 'gallery.categories.create',
        'store' => 'gallery.categories.store',
        'show' => 'gallery.categories.show',
        'edit' => 'gallery.categories.edit',
        'update' => 'gallery.categories.update',
        'destroy' => 'gallery.categories.destroy',
    ]);

    Route::softDeletableResources([
        'news' => NewsController::class,
        'activity' => ActivityController::class,
        'users' => UserController::class,
        'orthodox_calendar' => OrthodoxCalendarController::class,
        'gallery' => GalleryController::class,
    ]);

    Route::get('events', [EventsCalendarController::class, 'index'])->name('events.index');
    Route::get('api/events', [EventsCalendarController::class, 'apiIndex'])->name('events.apiIndex');
    Route::get('events/create', [EventsCalendarController::class, 'create'])->name('events.create');
    Route::post('events', [EventsCalendarController::class, 'store'])->name('events.store');
    Route::get('events/{id}/edit', [EventsCalendarController::class, 'edit'])->name('events.edit');
    Route::put('events/{id}', [EventsCalendarController::class, 'update'])->name('events.update');
    Route::delete('events/{id}', [EventsCalendarController::class, 'destroy'])->name('events.destroy');
    Route::post('admin/news/upload-image', [NewsController::class, 'uploadImage'])
        ->name('news.upload-image');
    Route::post('admin/activity/upload-image', [ActivityController::class, 'uploadImage'])
        ->name('activity.upload-image');

    // Temple page management
    Route::get('temple-page/edit', [TemplePageController::class, 'edit'])->name('temple.edit');
    Route::post('temple-page/update', [TemplePageController::class, 'update'])->name('temple.update');

    // Temple page management
    Route::get('temple-page/edit', [TemplePageController::class, 'edit'])->name('temple.edit');
    Route::post('temple-page/update', [TemplePageController::class, 'update'])->name('temple.update');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
