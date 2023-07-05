<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ShowRequestsController;
use App\Http\Controllers\MusicsController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\DashboardNewsController;
use App\Http\Controllers\DashboardSongsController;
use App\Http\Controllers\DashboardEventsController;
use App\Http\Controllers\DashboardMerchandiseController;
use App\Http\Controllers\MessagesController;
use App\Http\Livewire\Checkout;
use App\Http\Livewire\History;
use App\Http\Livewire\ProofUpload;
use Illuminate\Support\Facades\Auth;
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

//show requests routes
Route::post('/events/request-show', [ShowRequestsController::class, 'store'])->name('showRequests.store');
Route::get('/events/request-show', function () {
    return view('event.request-show', [
        'title' => 'Request Show'
    ]);
});

// store page
Route::group(['middleware' => []], function () {
    Route::get('/store', [StoreController::class, 'index'])->name('store.index');
    Route::get('/store/detail/{merchandise:slug}', [StoreController::class, 'detail']);
});

Route::post('/store/detail/{merchandise:slug}', [CartController::class, 'addToCart'])->name('addToCart')->middleware(['auth', 'verified']);
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware(['auth', 'verified']);
Route::delete('/cart/{orderDetail}', [CartController::class, 'destroy'])->name('cart.destroy')->middleware(['auth', 'verified']);
Route::patch('/cart/{orderDetail}/increase', [CartController::class, 'increaseQuantity'])->name('cart.increaseQuantity')->middleware(['auth', 'verified']);
Route::patch('/cart/{orderDetail}/decrease', [CartController::class, 'decreaseQuantity'])->name('cart.decreaseQuantity')->middleware(['auth', 'verified']);

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/checkout', Checkout::class)->name('checkout');
    Route::get('/checkout/upload/{orderId}', ProofUpload::class)
        ->name('proof-upload');
    Route::get('/store/history', History::class)
        ->name('history');;
});


// Music Page
Route::get('/music', [MusicsController::class, 'index']);
Route::get('/music/{song:slug}', [MusicsController::class, 'show']);

// contact-us
Route::group(['middleware' => []], function () {
    Route::get('/contact-us', [MessagesController::class, 'form']); // Show contact us page
    Route::post('/contact-us', [MessagesController::class, 'store'])->name('message.store');
});


// User Login
Route::group(['middleware' => ['guest', 'prevent.admin.login']], function () {
    Route::get('/login-user', [UserController::class, 'login'])->name('login');
    Route::post('/login-user', [UserController::class, 'authenticate'])->name('user.authenticate');
});

// Register User
Route::group(['middleware' => ['guest', 'prevent.user.login']], function () {
    Route::get('/register-user', [UserController::class, 'register'])->name('user.register');
    Route::post('/register-user', [UserController::class, 'store'])->name('user.store');
});


Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

// Admin Auth
Route::group(['middleware' => ['guest', 'prevent.user.login', 'prevent.admin.login']], function () {
    Route::get('/admin/login', [AdminController::class, 'login'])->name('login.admin');
    Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
});

Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


// Email Verification
Route::get('/email/verify', function () {
    if (Auth::user()->hasVerifiedEmail()) {
        return redirect('/'); // Replace 'home' with the desired route for already verified users
    }
    return view('auth.verify.verify-email');
})->middleware(['auth', 'verified'])->name('verification.notice');

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
