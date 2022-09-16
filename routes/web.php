<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

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


Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@loginAction');


Route::group(['middleware' => 'auth'], function () {

    //Dahsboard - Reports
    Route::get('/', 'DashboardController@index')->name('dashboard');
    
    Route::post('check_username', 'UserController@checkUsername')->name('check_username');
    Route::resource('users', 'UserController');
    Route::get('/reset_password/{id}', 'UserController@reset')->name('users.reset');
    Route::resource('roles', 'RoleController');
    
    // Demo routes
    Route::get('/datatables', 'PagesController@datatables');
    Route::get('/ktdatatables', 'PagesController@ktDatatables');
    Route::get('/select2', 'PagesController@select2');
    Route::get('/jquerymask', 'PagesController@jQueryMask');
    Route::get('/icons/custom-icons', 'PagesController@customIcons');
    Route::get('/icons/flaticon', 'PagesController@flaticon');
    Route::get('/icons/fontawesome', 'PagesController@fontawesome');
    Route::get('/icons/lineawesome', 'PagesController@lineawesome');
    Route::get('/icons/socicons', 'PagesController@socicons');
    Route::get('/icons/svg', 'PagesController@svg');

    Route::get('/systemMonitor', 'SystemMonitorController@status');

    Route::get('/test', 'ServicingController@test');

    // Quick search dummy route to display html elements in search dropdown (header search)
    Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');

    // Route::put('messages/{$id}', [MessageController::class, 'flag'])->name('messages.flag');
});
