<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'admin'], function () {
    Route::post('register', 'Admin\Register')->name('admin-register');
    Route::post('login', 'Admin\Login')->name('admin-login');
    // Route::post('logout', 'Admin\Logout')->name('admin-logout');

});
Route::group(['prefix' => 'user'], function () {
    Route::post('register', 'User\Register')->name('user-register');
    Route::post('login', 'User\Login')->name('user-login');
    // Route::post('logout', 'User\Logout')->name('user-logout');

});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', 'UserController@index');
});
