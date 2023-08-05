<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Merchandise\Cart;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Merchandise\Store;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MusicsController;
use App\Http\Controllers\VideosController;
use App\Http\Livewire\Merchandise\History;
use App\Http\Livewire\Merchandise\Product;
use App\Http\Livewire\Merchandise\Checkout;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Livewire\Merchandise\ProofUpload;
use App\Http\Controllers\ShowRequestsController;
use App\Http\Livewire\Merchandise\ProductDetail;
use App\Http\Controllers\DashboardNewsController;
use App\Http\Controllers\DashboardSongsController;
use App\Http\Livewire\Merchandise\ProductCategory;
use App\Http\Controllers\DashboardEventsController;
use App\Http\Controllers\DashboardOrdersController;
use App\Http\Controllers\DashboardMerchandiseController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.share');

// event page
Route::get('/events', [EventsController::class, 'index'])->name('events');
Route::get('/events/{event:slug}', [EventsController::class, 'show'])->name('event.share');
Route::get('/events/filter/{filter}', [EventsController::class, 'filter'])->name('events.filter');

//show requests routes
Route::post('/events/request-show', [ShowRequestsController::class, 'store'])->name('showRequests.store');
Route::get('/request-show', function () {
    return view('event.request-show', [
        'title' => 'Request Show'
    ]);
});

// store page
Route::get('/store', Store::class)->name('merchandise.home');
Route::get('/product', Product::class)->name('products');
Route::get('/product/category/{categoryId}', ProductCategory::class)->name('product.category');
Route::get('/product/{slug}', ProductDetail::class)->name('product.detail');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/cart', Cart::class)->name('merchandise.cart');
    Route::get('/checkout', Checkout::class)->name('merchandise.checkout');
    Route::get('/checkout/upload/{orderId}', ProofUpload::class)
        ->name('proof-upload');
    Route::get('/store/history', History::class)
        ->name('history');;
});
// Route::post('/cart', [Cart::class, 'addToCart'])->middleware(['auth', 'verified']);


// Music Page
Route::get('/music', [MusicsController::class, 'index'])->name('music');
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


Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware('admin')->name('admin.dashboard');

Route::resource('/admin/dashboard/news', DashboardNewsController::class)
    ->middleware('admin');

Route::resource('/admin/dashboard/events', DashboardEventsController::class)
    ->middleware('admin');
Route::get('/admin/dashboard/export-events', [DashboardEventsController::class, 'export'])->name('events.export');


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

Route::get('/admin/dashboard/show-requests', [ShowRequestsController::class, 'index'])
    ->middleware('admin')
    ->name('show-requests.index');

Route::group(['middleware' => ['admin']], function () {
    //show requests approval or denial
    Route::post('/show-requests/{showRequest}/approve', [ShowRequestsController::class, 'approve'])
        ->middleware('admin')
        ->name('show-request.approve');
    Route::post('/show-requests/{showRequest}/reject', [ShowRequestsController::class, 'reject'])
        ->middleware('admin')
        ->name('show-request.reject');
    Route::get('/admin/dashboard/export-show-requests', [ShowRequestsController::class, 'export'])->name('show-requests.export');

    Route::get('/admin/dashboard/orders', [DashboardOrdersController::class, 'index'])
        ->middleware('admin')
        ->name('order.index');
    Route::get('/admin/dashboard/orders/{order}', [DashboardOrdersController::class, 'show']);
    Route::post('/admin/dashboard/orders/{order}/confirm', [DashboardOrdersController::class, 'confirm'])->name('order.confirm');
    Route::post('/admin/dashboard/orders/{order}/shipping', [DashboardOrdersController::class, 'shipping'])->name('order.shipping');
    Route::get('/admin/dashboard/export-orders', [DashboardOrdersController::class, 'export'])->name('order.export');


    Route::get('/admin/dashboard/admins', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/dashboard/admins/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/dashboard/admins', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/dashboard/admins/edit-account', [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/admin/dashboard/admins/edit-account', [AdminController::class, 'update'])->name('admin.update');
    Route::post('/admin/dashboard/admins/change-password', [AdminController::class, 'updatePassword'])->name('adminPassword.update');
    Route::delete('/admin/dashboard/admins/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy');

    Route::get('/admin/dashboard/users', [UserController::class, 'index'])->name('user.index');

});


// Route::post('/show-requests/{showRequest}/approve', [ShowRequestsController::class, 'approve'])
//     ->middleware('admin')
//     ->name('show-request.approve');
// Route::post('/show-requests/{showRequest}/reject', [ShowRequestsController::class, 'reject'])
//     ->middleware('admin')
//     ->name('show-request.reject');

// Route::get('/admin/dashboard/orders', [DashboardOrdersController::class, 'index'])
//     ->middleware('admin')
//     ->name('order.index');

// Route::get('/admin/dashboard/orders/{order}', [DashboardOrdersController::class, 'show']);
