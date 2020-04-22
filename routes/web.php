<?php
use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('message')->group(function () {
    Route::post('/sendMessage', 'HomeController@sendMessage')->name('user.send.message');
    Route::post('/deleteAll', 'HomeController@deleteAllMessage')->name('user.delete.all');
});

Route::resource("rooms", "RoomsController");

Route::prefix('admin')->group(function () {
    Route::get('login', 'AdminAuthController@showLoginForm')->name('admin.login');
    Route::post('login', 'AdminAuthController@login');
    Route::get('logout', 'AdminAuthController@logout');
    Route::middleware('auth:admin')->group(function () {
        Route::get('/', function () {
            dd('admin');
    });
});



});
