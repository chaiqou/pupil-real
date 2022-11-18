<?php

use App\Http\Controllers\api\LunchController;
use App\Http\Controllers\Dashboard\ParentController;
use App\Http\Controllers\Dashboard\SchoolController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\InviteController;
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


Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => ['role:parent']], function () {
        Route::prefix('/parent/')->group(function () {
            Route::post('update-student', [SettingController::class, 'updateStudent'])->name('parent.update-student_api');
            Route::controller(ParentController::class)->group(function () {
                Route::get('{student_id}/week-spending', 'getLastWeekTransactionsSpending')->name('parent.week-spending_api');
                Route::get('{student_id}/month-spending', 'getLastMonthTransactionsSpending')->name('parent.month-spending_api');
                Route::get('{student_id}/last-transactions', 'getLastFiveTransactions')->name('parent.last-transactions_api');
                Route::get('{user_id}/students', 'getStudents')->name('parent.students_api');
                Route::get('{student_id}/transactions', 'getTransactions')->name('parent.transactions_api');
            });
        });
    });

    Route::group(['middleware' => ['role:school']], function () {
        Route::post('send-invite', [InviteController::class, 'sendInvite'])->name('send.invite');
        Route::prefix('/school/')->group(function() {
            Route::controller(SchoolController::class)->group(function () {
                Route::get('{school_id}/dashboard-students', 'getDashboardStudents')->name('school.dashboard-students');
                Route::get('{school_id}/last-transactions', 'getLastFiveTransactions')->name('school.last-transactions_api');
                Route::get('{school_id}/transactions', 'getTransactions')->name('school.transactions_api');
                Route::get('{school_id}/students', 'getStudents')->name('school.students_api');
            });
            Route::get('{school_id}/invites', [InviteController::class, 'getInvites'])->name('school.invites_api');
        });
    });

});

Route::apiResource('lunch', LunchController::class);
Route::get("/{school_id}/invite-emails", [InviteController::class, 'getInviteEmails'])->name('invites.get-emails');
Route::get("/{school_id}/user-emails", [InviteController::class, 'getUserEmails'])->name('invites.get-emails');
