<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
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
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.request');

Route::middleware(['guest'])->group(function () {
	Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPasswordForm'])->name('password.request');
	Route::post('/forgot-password', [ForgotPasswordController::class, 'sendForgotPasswordEmail'])->name('password.email');
	Route::get('/reset-password/{token}', function ($token) {
		return view('auth.reset-password', ['token' => $token]);
	})->name('password.reset');
});

Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('/send-invite', [InviteController::class, 'sendInvite'])->name('send.invite');
