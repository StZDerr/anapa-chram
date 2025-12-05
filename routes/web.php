<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsCalendarController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/temple', function () {
    return view('temple');
})->name('temple');

Route::get('/gallery', function () {
    return view('gallery/index');
})->name('gallery');

Route::get('/zapiski', function () {
    return view('zapiskiAndTreby/zapiski');
})->name('zapiski');

Route::get('/treby', function () {
    return view('zapiskiAndTreby/treby');
})->name('treby');

Route::get('/park', function () {
    return view('park');
})->name('park');

Route::get('/test', function () {
    return view('news/read');
})->name('test');

Route::get('/calendar', function () {
    return view('calendar');
})->name('calendar');

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

// Route::get('/news', function () {
//     return view('news/index');
// })->name('news.index');

Route::get('news', [Controller::class, 'news'])->name('news.index');

Route::get('/activity', function () {
    return view('activity/index');
})->name('activity.index');

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::softDeletableResources([
        'news' => NewsController::class,
        'activity' => ActivityController::class,
        'users' => UserController::class,
    ]);
    Route::get('events', [EventsCalendarController::class, 'index'])->name('events.index');
    Route::get('api/events', [EventsCalendarController::class, 'apiIndex'])->name('events.apiIndex');
    Route::get('events/create', [EventsCalendarController::class, 'create'])->name('events.create');
    Route::post('events', [EventsCalendarController::class, 'store'])->name('events.store');
    Route::get('events/{id}/edit', [EventsCalendarController::class, 'edit'])->name('events.edit');
    Route::put('events/{id}', [EventsCalendarController::class, 'update'])->name('events.update');
    Route::delete('events/{id}', [EventsCalendarController::class, 'destroy'])->name('events.destroy');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
