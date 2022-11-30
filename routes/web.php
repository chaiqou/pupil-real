<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Dashboard\NavigationController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\Parent\ParentController;
use App\Http\Controllers\Parent\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::controller(InviteController::class)->group(function () {
        Route::get('/setup-account/{uniqueID}', 'setupAccount')->name('setup.account');
        Route::post('/setup-account/{uniqueID}', 'submitSetupAccount')->name('setup.account_submit');

        Route::get('/personal-form/{uniqueID}', 'personalForm')->name('personal.form');
        Route::post('/personal-form/{uniqueID}', 'submitPersonalForm')->name('personal.form_submit');

        Route::get('/verify-email/{uniqueID}', 'verifyEmail')->name('verify.email');
        Route::post('/verify-email/{uniqueID}', 'submitVerifyEmail')->name('verify.email_submit');
    });

    Route::get('/', [AuthController::class, 'redirectIfLoggedIn'])->name('default');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/mail-sent', 'forgotRedirect')->name('forgot.redirect');
        Route::get('/forgot-password', 'forgotPasswordForm')->name('forgot.form');
        Route::post('/forgot-password', 'sendForgotPasswordMail')->name('forgot.request');
    });
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(TwoFactorAuthenticationController::class)->group(function () {
        Route::get('/two-factor-authentication', 'form')->name('2fa.form');
        Route::post('/submit-two-factor-authentication', 'verify')->name('2fa.submit');
        Route::post('/resend-two-factor-authentication', 'resend')->name('2fa.resend');
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('/admin/')->group(function () {
            Route::controller(NavigationController::class)->group(function () {
                Route::get('dashboard', 'admin')->name('admin.dashboard');
                Route::get('students', 'admin')->name('admin.students');
                Route::get('invite', 'admin')->name('admin.invite');
            });
        });
    });

    Route::group(['middleware' => ['role:parent']], function () {
        Route::prefix('/parent/')->group(function () {
            Route::controller(ParentController::class)->group(function () {
                Route::get('create-student/{user_id}', 'createStudent')->name('parent.create-student');
                Route::post('create-student/{user_id}', 'storeStudent')->name('parent.create-student_submit');
                Route::get('create-student/verify/{student_id}', 'verifyStudentCreation')->name('parent.create-student-verify');
                Route::post('create-student-verify/{student_id}', 'submitStudentCreation')->name('parent.create-student-verify_submit');
                Route::get('dashboard', 'parentDashboard')->name('parents.dashboard');
            });

            Route::controller(SettingController::class)->group(function () {
                Route::post('two-fa/{user_id}', 'changeTwoFa')->name('parent.two-fa');
                Route::post('update-password/{user_id}', 'updatePassword')->name('parent.update-password');
                Route::post('settings/{student_id}', 'updatePersonal')->name('parent.settings_submit');
            });

            Route::controller(NavigationController::class)->group(function () {
                Route::get('settings/{student_id}', 'parent')->name('parent.settings');
                Route::get('transactions/{student_id}', 'parent')->name('parent.transactions');
                Route::get('dashboard/{student_id}', 'parent')->name('parent.dashboard');
            });
        });
    });

    Route::group(['middleware' => ['role:school']], function () {
        Route::prefix('/school/')->group(function () {
            Route::controller(NavigationController::class)->group(function () {
                Route::get('lunch-management', 'school')->name('school.lunch-management');
                Route::get('students', 'school')->name('school.students');
                Route::get('transactions', 'school')->name('school.transactions');
                Route::get('dashboard', 'school')->name('school.dashboard');
                Route::get('invite', 'school')->name('school.invite');
            });
        });
    });
});
