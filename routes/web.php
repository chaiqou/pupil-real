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

Route::get('/', 'App\Http\Controllers\LoginController@redirIfLoggedIn')->name('default');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dash', function () {
        return view('dashboard')->with('page', 'Dashboard');
    })->name('dashboard');
});
Route::post('/login-post', 'App\Http\Controllers\LoginController@authenticate')->name('login.post');
Route::get('/logout', 'App\Http\Controllers\LoginController@logout')->name('logout');