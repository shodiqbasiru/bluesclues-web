<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ShowRequestsController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\DashboardNewsController;
use App\Http\Controllers\DashboardEventsController;
use App\Http\Controllers\DashboardSongsController;
use App\Http\Controllers\DashboardMerchandiseController;
use App\Http\Controllers\MessagesController;
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



Route::get('/', [HomeController::class, 'index']); // Home page

// video page
Route::get('/videos', [VideosController::class, 'showVideos'])->name('showVideos'); // Show all videos
Route::get('/videos-data', [VideosController::class, 'index'])->name('videos.index');

// news page
Route::get('/news', [NewsController::class, 'index']); // Show all news
Route::get('/news/{news:slug}', [NewsController::class, 'show']); // Show single news

// event page
Route::get('/events', [EventsController::class, 'index'])->name('events'); // Show all events
Route::get('/events/filter/{filter}', [EventsController::class, 'filter'])->name('events.filter'); // Filter events

//show requests routes
Route::post('/events', [ShowRequestsController::class, 'store'])->name('showRequests.store'); // Store show request

// contact-us routes
Route::group(['middleware' => ['verified']], function () {
    Route::get('/contact-us', [MessagesController::class, 'form']); // Show contact us page
    Route::post('/contact-us', [MessagesController::class, 'store'])->name('message.store');
}); // Store message



// Register Routes
Route::group(['middleware' => ['guest', 'prevent.user.login']], function () {
    Route::get('/register', [UserController::class, 'register'])->name('user.register');
    Route::post('/register', [UserController::class, 'store'])->name('user.store');
});


// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return view('auth.verify.email-verified'); // Redirect to a page or show a message that says your email has been verified
})->middleware(['auth', 'signed'])->name('verification.verify'); //


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification(); // Send verification email

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

Route::resource('/admin/dashboard/news', DashboardNewsController::class)
    ->middleware('admin');

Route::resource('/admin/dashboard/events', DashboardEventsController::class)
    ->middleware('admin');

Route::resource('/admin/dashboard/songs', DashboardSongsController::class)
    ->middleware('admin');

Route::resource('/admin/dashboard/merchandise', DashboardMerchandiseController::class)
    ->middleware('admin');

Route::get('/admin/dashboard/messages', [MessagesController::class, 'index'])
    ->middleware('admin');

Route::get('admin/dashboard/messages/{message}', [MessagesController::class, 'show']) // Show single message
    ->middleware('admin');

Route::delete('admin/dashboard/messages/{message}', [MessagesController::class, 'destroy']) // Delete message
    ->middleware('admin');


Route::get('/admin/dashboard/show-requests/{status?}', [ShowRequestsController::class, 'index'])
    ->middleware('admin')
    ->name('show-requests.index');




//show requests approval or denial
Route::post('/show-requests/{showRequest}/approve', [ShowRequestsController::class, 'approve'])
    ->middleware('admin')
    ->name('show-request.approve');
Route::post('/show-requests/{showRequest}/reject', [ShowRequestsController::class, 'reject'])
    ->middleware('admin')
    ->name('show-request.reject');




Route::get('/songs', function () {
    return view('songs', [
        'title' => 'Songs'
    ]);
});
