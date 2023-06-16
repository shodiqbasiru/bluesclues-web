<?php

use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\DashboardNewsController;
use App\Http\Controllers\DashboardEventsController;
use App\Http\Controllers\DashboardSongsController;
use App\Http\Controllers\MusicsController;
use App\Http\Controllers\StoreController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// home
Route::get('/', [HomeController::class, 'index']);

// about
Route::get('/about', [AboutController::class, 'index']);

// video page
Route::get('/videos', [VideosController::class, 'index']);
Route::get('/video/{id}', [VideosController::class, 'show'])->name('video');

// store page
Route::get('/store', [StoreController::class, 'index']);
Route::get('/store/detail', [StoreController::class, 'detail']);

// Music Page
Route::get('/music', [MusicsController::class, 'index']);

// news page
Route::get('/news', [NewsController::class, 'index']);
// Route::get('/news/more', [NewsController::class, 'loadMore'])->name('news');
Route::get('/news/{news:slug}', [NewsController::class, 'show']);
Route::get('/admin/create-news', [NewsController::class, 'createNews'])->middleware('auth');
Route::get('/shownews', [NewsController::class, 'select']);
Route::post('/admin/create-news', [NewsController::class, 'store'])->middleware('auth')->name('news.store');

// event page   
Route::get('/events', [EventsController::class, 'index'])->name('events');
Route::get('/events/filter/{filter}', [EventsController::class, 'filter'])->name('events.filter');
Route::get('/admin/add-event', [EventsController::class, 'addEvent'])->middleware('auth');
Route::get('/events/{event:slug}', [EventsController::class, 'show']);
Route::post('/admin/add-event', [EventsController::class, 'store'])->middleware('auth')->name('events.store');


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
