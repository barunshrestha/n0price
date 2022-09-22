<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signupAction'])->name('register');

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@loginAction');
Route::get('verify-email', [EmailVerificationController::class, 'verify_email_invoke'])
        ->name('verification.notice');
Route::middleware(['auth', 'verified', 'topLevelApproval'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/user/approve/{id}', [UserController::class,'approveUser'])->name('user.approve');
    Route::get('/user/unnapprove/{id}', [UserController::class,'unapproveUser'])->name('user.unapprove');
    Route::post('/user/status', [UserController::class,'approvalFilter'])->name('user.approvalFilter');
    Route::resource('users', 'UserController');
    Route::resource('transactions', 'TransactionController');
    Route::resource('coins', 'CoinController');
    Route::get('/coin/active/{id}', [CoinController::class,'activeCoin'])->name('coins.active');
    Route::get('/coin/inactive/{id}', [CoinController::class,'inactiveCoin'])->name('coins.inactive');

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});


Route::group(['middleware' => 'auth'], function () {

    Route::post('check_username', 'UserController@checkUsername')->name('check_username');
    Route::resource('users', 'UserController');
    Route::get('/reset_password/{id}', 'UserController@reset')->name('users.reset');
    Route::resource('roles', 'RoleController');

    // Route::get('verify-email', [EmailVerificationController::class, 'verify_email_invoke'])
    //     ->name('verification.notice');
    Route::get('approval-page', [AuthController::class, 'approvalPending'])
        ->name('approvalpage');

    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
