<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InviteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

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

Route::get('/', [AuthController::class, 'redirectIfLoggedIn'])->name('default');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');

Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('/send-invite', [InviteController::class, 'sendInvite'])->name('send.invite');

Route::get('/setup-account/{uniqueID}', [InviteController::class, 'setupAccount'])->name('setup.account');
Route::post('/setup-account/{uniqueID}', [InviteController::class, 'submitSetupAccount'])->name('setup.account_submit');

Route::get('/personal-form/{uniqueID}', [InviteController::class, 'personalForm'])->name('personal.form');
Route::post('/personal-form/{uniqueID}', [InviteController::class, 'submitPersonalForm'])->name('personal.form_submit');
