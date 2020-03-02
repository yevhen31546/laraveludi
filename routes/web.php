<?php
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\InvoiceController;

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


Route::group(['middleware' => 'web'], function () {
    Route::get('/', function () {
        return redirect($to = 'dashboard', $status = 302, $headers = [], $secure = null);
        return view('welcome');
    })->middleware(['auth','verified']);
    Route::get('/home', function () {
        return redirect($to = 'dashboard', $status = 302, $headers = [], $secure = null);
        //return view('welcome');
    })->middleware(['auth','verified']);

    // These routes require the user to be logged in
    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        Route::any('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::any('getudi', [DashboardController::class, 'getUdi'])->name('getudi');
        Route::any('reloadudi', [DashboardController::class, 'reloadUdi'])->name('reloadudi');
        Route::any('card', [CardController::class, 'index'])->name('card');
        Route::any('printcard', [CardController::class, 'printCard'])->name('printcard');
        Route::any('invoice', [InvoiceController::class, 'index'])->name('invoice');
        Route::any('generate_invoice', [InvoiceController::class, 'generate_invoice'])->name('generate_invoice');
    });

    // These routes require no user to be logged in
    Route::group(['middleware' => 'guest'], function () {
        // Authentication Routes
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');

        // Registration Routes
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register'])->name('register.post');

        // Confirm Account Routes
        Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

        // Password Reset Routes
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.email');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email.post');

        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.update');
    });
});
