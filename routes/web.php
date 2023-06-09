<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AdminController;
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

Route::get('/videos', [VideosController::class, 'showVideos'])->name('showVideos');
Route::get('/videos-data', [VideosController::class, 'index'])->name('videos.index');

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{news:slug}', [NewsController::class, 'show']);
Route::get('/admin/create-news', [NewsController::class, 'createNews'])->middleware('auth');
Route::get('/shownews', [NewsController::class, 'select']);
Route::post('/admin/create-news', [NewsController::class, 'store'])->middleware('auth')->name('news.store');

Route::get('/events', [EventsController::class, 'index'])->name('events.index');
Route::get('/admin/add-event', [EventsController::class, 'addEvent'])->middleware('auth');
Route::get('/events/{event:slug}', [EventsController::class, 'show']);
Route::post('/admin/add-event', [EventsController::class, 'store'])->middleware('auth')->name('events.store');

Route::get('/login-admin', [AdminController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login-admin', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/logout-admin', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/admin/dashboard', function () {
    return view('dashboard.index', [
        'title' => 'Admin Dashboard'
    ]);
})->middleware('auth')->name('admin.dashboard') ;

Route::resource('/admin/dashboard/news', DashboardNewsController::class)->middleware('auth');
Route::resource('/admin/dashboard/events', DashboardEventsController::class)->middleware('auth');
Route::resource('/admin/dashboard/songs', DashboardSongsController::class)->middleware('auth');
Route::resource('/admin/dashboard/merchandise', DashboardMerchandiseController::class)->middleware('auth');

 


Route::get('/songs', function () {
    return view('songs', [
        'title' => 'Songs'
    ]);
});

