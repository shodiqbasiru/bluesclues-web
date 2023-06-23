<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MusicsController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\DashboardNewsController;
use App\Http\Controllers\DashboardSongsController;
use App\Http\Controllers\DashboardEventsController;
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



// home
Route::get('/', [HomeController::class, 'index']);

// about
Route::get('/about', [AboutController::class, 'index']);

// video page
Route::get('/videos', [VideosController::class, 'showVideos'])->name('showVideos');
Route::get('/videos-data', [VideosController::class, 'index'])->name('videos.index');

// news page
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{news:slug}', [NewsController::class, 'show']);

// event page   
Route::get('/events', [EventsController::class, 'index'])->name('events');
Route::get('/events/filter/{filter}', [EventsController::class, 'filter'])->name('events.filter');

// store page
Route::get('/store', [StoreController::class, 'index']);
Route::get('/store/detail', [StoreController::class, 'detail']);

// Music Page
Route::get('/music', [MusicsController::class, 'index']);
Route::get('/music/{song:slug}', [MusicsController::class, 'show']);

Route::get('/events/request-show', function () {
    return view('event.request-show', [
        'title' => 'Request Show'
    ]);
});

// auth user
Route::get('/login-user', function () {
    return view('auth.user.login', [
        'title' => 'Login User'
    ]);
});

Route::get('/register-user', function () {
    return view('auth.user.register', [
        'title' => 'Register User'
    ]);
});

// contact page
Route::get('/contact-us', function () {
    return view('contact-us', [
        'title' => 'Contact Us'
    ]);
});

// dashboard admin
Route::get('/login-admin', [AdminController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login-admin', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/logout-admin', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/admin/dashboard', function () {
    return view('dashboard.index', [
        'title' => 'Admin Dashboard'
    ]);
})->middleware('auth')->name('admin.dashboard');

Route::resource('/admin/dashboard/news', DashboardNewsController::class)->middleware('auth');
Route::resource('/admin/dashboard/events', DashboardEventsController::class)->middleware('auth');
Route::resource('/admin/dashboard/songs', DashboardSongsController::class)->middleware('auth');
Route::resource('/admin/dashboard/merchandise', DashboardMerchandiseController::class)->middleware('auth');
