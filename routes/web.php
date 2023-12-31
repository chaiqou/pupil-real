<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Dashboard\NavigationController;
use App\Http\Controllers\Merchant\InviteController as MerchantInviteController;
use App\Http\Controllers\Parent\InviteController as ParentInviteController;
use App\Http\Controllers\Parent\ParentController;
use App\Http\Controllers\Parent\SettingController;
use App\Http\Controllers\Parent\StripeCheckoutController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::post('/resend-onboarding-verification/{uniqueID}', [TwoFactorAuthenticationController::class, 'resendForOnboardingUser'])->name('resend-verification');
    Route::controller(ParentInviteController::class)->group(function () {
        Route::get('/parent-setup-account/{uniqueID}', 'setupAccount')->name('parent-setup.account');
        Route::get('/parent-personal-form/{uniqueID}', 'personalForm')->name('parent-personal.form');
        Route::get('/parent-setup-cards/{uniqueID}', 'setupCards')->name('parent-setup.cards');
        Route::get('/parent-verify-email/{uniqueID}', 'verifyEmail')->name('parent-verify.email');
    });

    Route::controller(MerchantInviteController::class)->group(function () {
        Route::get('/merchant-setup-account/{uniqueID}', 'setupAccount')->name('merchant-setup.account');
        Route::get('/merchant-personal-form/{uniqueID}', 'personalForm')->name('merchant-personal.form');
        Route::get('/merchant-company-details/{uniqueID}', 'companyDetails')->name('merchant-company.details');
        Route::get('/merchant-setup-stripe/{uniqueID}', 'setupStripe')->name('merchant-setup.stripe');
        Route::get('/merchant-billingo-verify/{uniqueID}', 'billingoVerify')->name('merchant-billingo.verify');
        Route::get('/merchant-verify-email/{uniqueID}', 'verifyEmail')->name('merchant-verify.email');
    });

    Route::view('/', 'auth.sign-in')->name('default');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/mail-sent', 'forgotRedirect')->name('forgot.redirect');
        Route::get('/forgot-password', 'forgotPasswordForm')->name('forgot.form');
        Route::post('/forgot-password', 'sendForgotPasswordMail')->name('forgot.request');
    });
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');

    Route::controller(TwoFactorAuthenticationController::class)->group(function () {
        Route::get('/two-factor-authentication', 'form')->name('2fa.form');
        Route::post('/submit-two-factor-authentication', 'verify')->name('2fa.submit');
        Route::post('/resend-two-factor-authentication', 'resend')->name('2fa.resend');
        Route::post('/logout-from-two-fa-form', 'logoutFromTwoFa')->name('2fa.logout');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('/admin/')->group(function () {
            Route::controller(NavigationController::class)->group(function () {
                Route::get('dashboard', 'admin')->name('admin.dashboard');
                Route::get('students', 'admin')->name('admin.students');
                Route::get('invite', 'admin')->name('admin.invite');
                Route::get('schools', 'admin')->name('admin.schools');
                Route::get('school/{school_id}/merchants', 'admin')->name('admin.merchants');
                Route::get('/school/{school_id}/merchant-invites', 'admin')->name('admin.merchant-invites');
                Route::get('settings', 'admin')->name('admin.settings');
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
                Route::post('change-two-fa-status', 'changeTwoFa')->name('parent.two-fa');
                Route::post('settings/{student_id}', 'updatePersonal')->name('parent.settings_submit');
            });

            Route::controller(NavigationController::class)->group(function () {
                Route::get('settings/{student_id}', 'parent')->name('parent.settings');
                Route::get('transactions/{student_id}', 'parent')->name('parent.transactions');
                Route::get('dashboard/{student_id}', 'parent')->name('parent.dashboard');
                Route::get('available-lunches/{student_id}', 'parent')->name('parent.available-lunches');
                Route::get('lunch-details/{student_id}', 'parent')->name('parent.lunch-details');
                Route::get('menus/{student_id}', 'parent')->name('parent.menus');
            });
            Route::get('checkout/success', [StripeCheckoutController::class, 'success'])->name('parent.checkout_success');
            Route::get('checkout/cancel', [StripeCheckoutController::class, 'cancel'])->name('parent.checkout_cancel');
        });
    });

    Route::group(['middleware' => ['role:school', 'permission:can use account']], function () {
        Route::prefix('/school/')->group(function () {
            Route::controller(NavigationController::class)->group(function () {
                Route::get('lunch-management', 'school')->name('school.lunch-management');
                Route::get('add-lunch', 'school')->name('school.add-lunch');
                Route::get('students', 'school')->name('school.students');
                Route::get('transactions', 'school')->name('school.transactions');
                Route::get('dashboard', 'school')->name('school.dashboard');
                Route::get('invite', 'school')->name('school.invite');
                Route::get('lunch-management/{lunch_id}/edit', 'school')->name('school.lunch-management-edit');
                Route::get('terminals', 'school')->name('school.terminals');
                Route::get('menu-management', 'school')->name('school.menu-management');
                Route::get('settings', 'school')->name('school.settings');
            });
        });
    });
});

Route::post('/webhook/stripe', [StripeCheckoutController::class, 'webhook'])->name('parent.webhook');
