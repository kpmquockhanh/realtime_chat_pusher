<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return \response()->json(\App\User::query()->paginate(1));
});

Route::prefix('v1')->group(function () {
    Route::post('/login', 'AuthController@login');
    Route::middleware('scope:view')->get('/view', 'AuthController@view');
    Route::get('/logout', 'AuthController@logout');
});
