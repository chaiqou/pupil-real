<?php

use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\api\LunchController;
use App\Http\Controllers\Dashboard\ParentController;
use App\Http\Controllers\Dashboard\SchoolController;
use App\Http\Controllers\Admin\SchoolController as AdminSchoolController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\Admin\InviteController as AdminInviteController;
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


    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('/admin/')->group(function () {
            Route::controller(AdminStudentController::class)->group(function () {
                Route::get('students', 'index')->name('admin.students_api');
            });
            Route::controller(AdminSchoolController::class)->group(function () {
                Route::get('schools', 'index')->name('admin.schools_api');
            });
            Route::controller(AdminInviteController::class)->group(function () {
                Route::get('invites', 'index')->name('admin.invites_api');
                Route::get('invite-emails', 'getInviteEmails')->name('admin_invites.invite-emails_api');
                Route::get('user-emails', 'getUserEmails')->name('admin_invites.user-emails_api');
                Route::post('{schoolId}/send-invite', [AdminInviteController::class, 'store'])->name('admin_send-invite_api');
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
Route::get("/{school_id}/invite-emails", [InviteController::class, 'getInviteEmails'])->name('school_invites.get-emails');
Route::get("/{school_id}/user-emails", [InviteController::class, 'getUserEmails'])->name('school_invites.get-emails');
