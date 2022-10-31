<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

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

Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');


Route::middleware(['auth', 'verified', 'topLevelApproval', 'adminAuth'])->group(function () {
    Route::get('/user/approve/{id}', [UserController::class, 'approveUser'])->name('user.approve');
    Route::get('/user/unnapprove/{id}', [UserController::class, 'unapproveUser'])->name('user.unapprove');
    Route::post('/user/status', [UserController::class, 'approvalFilter'])->name('user.approvalFilter');
    Route::resource('users', 'UserController');
    Route::post('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.delete');
    Route::resource('coins', 'CoinController');
    Route::post('/coin/active', [CoinController::class, 'activeCoin'])->name('coins.active');
    Route::post('/coin/inactive', [CoinController::class, 'inactiveCoin'])->name('coins.inactive');
    Route::get('/sync/coin', [CoinController::class, 'sync_coin'])->name('coins.sync');
    Route::get('/all/transactions', [TransactionController::class, 'all_transaction'])->name('all.transactions');
    Route::get('/get/all/transactions', [TransactionController::class, 'getall_transactions'])->name('get.all.transactions');
    Route::get('/admin/get/all/coins', [CoinController::class, 'adminGetAllCoins'])->name('adminGetAllCoins');
});

Route::middleware(['auth', 'verified', 'topLevelApproval'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::resource('transactions', 'TransactionController');
    Route::post('/destroyTransaction', [TransactionController::class, 'destroy'])->name('destroymyTransaction');
    Route::get('/profit_calc', [TransactionController::class, 'profit_calculation']);
    Route::post('/change_allocation', [TransactionController::class, 'change_allocation'])->name('percentage.allocation');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/portfolio_summary', 'DashboardController@portfolio_summary')->name('portfolio_summary');
    Route::get('/return_calculation', [DashboardController::class, 'return_calculation'])->name('return_calculation');
    Route::get('/dashboardTransactionPartials', 'DashboardController@dashboardTransactionPartials')->name('dashboardTransactionPartials');
    Route::get('/get/all/coins', [DashboardController::class, 'getallcoins']);
});

Route::group(['middleware' => 'auth'], function () {

    Route::post('check_username', 'UserController@checkUsername')->name('check_username');
    Route::get('/reset_password/{id}', 'UserController@reset')->name('users.reset');
    Route::resource('roles', 'RoleController');

    Route::get('approval-page', [AuthController::class, 'approvalPending'])
        ->name('approvalpage');
    Route::get('verify-email', [EmailVerificationController::class, 'verify_email_invoke'])
        ->name('verification.notice');

    Route::get('/get/specific/user/transaction', [DashboardController::class, 'get_transaction_of_specific_user'])->name('get_transaction_of_specific_user');


    Route::post('email/verification-notification', [EmailVerificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});


Route::get('/add/asset/to/all/user',[TransactionController::class,'assign_asset_matrix_constraints']);