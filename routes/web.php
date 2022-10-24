<?php

use App\Http\Controllers\NavigationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\ParentController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;


Route::get('/', [AuthController::class, 'redirectIfLoggedIn'])->name('default');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');

Route::middleware(['guest'])->group(function () {
	Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPasswordForm'])->name('forgot.form');
	Route::post('/forgot-password', [ForgotPasswordController::class, 'sendForgotPasswordMail'])->name('forgot.request');
	Route::get('/mail-sent', [ForgotPasswordController::class, 'forgotRedirect'])->name('forgot.redirect');
	Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPasswordForm'])->name('password.reset');
	Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/parent/dashboard', [ParentController::class, 'parentDashboard'])->name('parents.dashboard');
Route::get('/parent/dashboard/{student_id}', [NavigationController::class, 'index'])->name('dashboard');

Route::get('/send-invite', [InviteController::class, 'index'])->name('invite.user');
Route::post('/send-invite', [InviteController::class, 'sendInvite'])->name('send.invite');

Route::get('/setup-account/{uniqueID}', [InviteController::class, 'setupAccount'])->name('setup.account');
Route::post('/setup-account/{uniqueID}', [InviteController::class, 'submitSetupAccount'])->name('setup.account_submit');

Route::get('/personal-form/{uniqueID}', [InviteController::class, 'personalForm'])->name('personal.form');
Route::post('/personal-form/{uniqueID}', [InviteController::class, 'submitPersonalForm'])->name('personal.form_submit');

Route::get('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'form'])->name('2fa.form');
Route::post('/submit-two-factor-authentication', [TwoFactorAuthenticationController::class, 'verify'])->name('2fa.submit');
Route::post('/resend-two-factor-authentication', [TwoFactorAuthenticationController::class, 'resend'])->name('2fa.resend');


Route::get('/verify-email/{uniqueID}', [InviteController::class, 'verifyEmail'])->name('verify.email');
Route::post('/verify-email/{uniqueID}', [InviteController::class, 'submitVerifyEmail'])->name('verify.email_submit');


