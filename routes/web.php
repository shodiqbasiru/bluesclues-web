<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\DashboardNewsController;
use App\Http\Controllers\DashboardEventsController;
use App\Http\Controllers\DashboardSongsController;
use App\Http\Controllers\DashboardMerchandiseController;
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



Route::get('/', [HomeController::class, 'index']);

Route::get('/videos', [VideosController::class, 'showVideos'])->name('showVideos')->middleware('verified');
Route::get('/videos-data', [VideosController::class, 'index'])->name('videos.index');


Route::group(['middleware' => ['verified']], function () {
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{news:slug}', [NewsController::class, 'show']);
    Route::get('/shownews', [NewsController::class, 'select']);
});

Route::get('/events', [EventsController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventsController::class, 'show']);

// Register Routes
Route::group(['middleware' => ['guest', 'prevent.user.login']], function () {
    Route::get('/register', [UserController::class, 'register'])->name('user.register');
    Route::post('/register', [UserController::class, 'store'])->name('user.store');
});


// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return view('auth.email-verified');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



// Only verified users may access this route...
// Route::get('/profile', function () {
// })->middleware(['auth', 'verified']);


// User Routes
Route::group(['middleware' => ['guest', 'prevent.admin.login']], function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'authenticate'])->name('user.authenticate');
});


Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

// Admin Routes
Route::group(['middleware' => ['guest', 'prevent.user.login', 'prevent.admin.login']], function () {
    Route::get('/admin/login', [AdminController::class, 'login'])->name('login.admin');
    Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
});

Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');



Route::get('/admin/dashboard', function () {
    return view('dashboard.index', [
        'title' => 'Admin Dashboard'
    ]);
})->middleware('admin')->name('admin.dashboard');

Route::resource('/admin/dashboard/news', DashboardNewsController::class)->middleware('admin');
Route::resource('/admin/dashboard/events', DashboardEventsController::class)->middleware('admin');
Route::resource('/admin/dashboard/songs', DashboardSongsController::class)->middleware('admin');
Route::resource('/admin/dashboard/merchandise', DashboardMerchandiseController::class)->middleware('admin');




Route::get('/songs', function () {
    return view('songs', [
        'title' => 'Songs'
    ]);
});
