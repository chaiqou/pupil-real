<?php

use App\Http\Controllers\Admin\Api\InviteController as AdminInviteController;
use App\Http\Controllers\Admin\Api\Merchant\InviteController as AdminMerchantInviteController;
use App\Http\Controllers\Admin\Api\Merchant\MerchantController as AdminMerchantController;
use App\Http\Controllers\Admin\Api\SchoolController as AdminSchoolController;
use App\Http\Controllers\Admin\Api\StudentController as AdminStudentController;
use App\Http\Controllers\Parent\Api\OrderLunchController;
use App\Http\Controllers\Parent\Api\StudentController as ParentStudentController;
use App\Http\Controllers\Parent\Api\TransactionController as ParentTransactionController;
use App\Http\Controllers\Parent\SettingController;
use App\Http\Controllers\School\Api\InviteController as SchoolInviteController;
use App\Http\Controllers\School\Api\Lunch\LunchController;
use App\Http\Controllers\School\Api\StudentController as SchoolStudentController;
use App\Http\Controllers\School\Api\TerminalController;
use App\Http\Controllers\School\Api\TransactionController as SchoolTransactionController;
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
            Route::controller(ParentStudentController::class)->group(function () {
                Route::get('{user_id}/students', 'get')->name('parent.students_api');
                Route::get('student/{student_id}', 'show')->name('parent.student_api');
            });
            Route::controller(ParentTransactionController::class)->group(function () {
                Route::get('{student_id}/week-spending', 'getLastWeekTransactionsSpending')->name('parent.week-spending_api');
                Route::get('{student_id}/month-spending', 'getLastMonthTransactionsSpending')->name('parent.month-spending_api');
                Route::get('{student_id}/last-transactions', 'getLastFiveTransactions')->name('parent.last-transactions_api');
                Route::get('{student_id}/transactions', 'getTransactions')->name('parent.transactions_api');
            });
            Route::get('available-lunches', [LunchController::class, 'index'])->name('parent.available-lunches_api');
            Route::post('lunch-order/{student_id}/', [OrderLunchController::class, 'index'])->name('parent.order_lunch');
        });
    });
    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('/admin/')->group(function () {
            Route::controller(AdminStudentController::class)->group(function () {
                Route::get('students', 'get')->name('admin.students_api');
            });
            Route::controller(AdminSchoolController::class)->group(function () {
                Route::get('schools-for-invites', 'getSchoolsForInvite')->name('admin.schools-invites_api');
                Route::get('schools', 'index')->name('admin.schools-index_api');
                Route::get('school/{school_id}', 'show')->name('admin.school-show_api');
                Route::put('school', 'update')->name('admin.school-update_api');
                Route::post('school', 'store')->name('admin.school-store_api');
            });
            Route::controller(AdminMerchantController::class)->group(function () {
                Route::get('school/{school_id}/merchants', 'index')->name('admin.merchants-index_api');
                Route::get('merchant/{merchant_id}', 'show')->name('admin.merchant-show_api');
                Route::put('merchant', 'update')->name('admin.merchant-update_api');
                Route::put('merchant-status', 'updateStatus')->name('admin.merchant-update-status_api');
                Route::post('merchant', 'store')->name('admin.merchant-store_api');
            });
            Route::controller(AdminInviteController::class)->group(function () {
                Route::get('invites', 'get')->name('admin.invites_api');
                Route::get('invite-emails', 'getInviteEmails')->name('admin_invites.invite-emails_api');
                Route::get('user-emails', 'getUserEmails')->name('admin_invites.user-emails_api');
                Route::post('{schoolId}/send-invite', 'store')->name('admin_send-invite_api');
            });
            Route::controller(AdminMerchantInviteController::class)->group(function () {
                Route::get('/school/{school_id}/merchant-invites', 'get')->name('admin.merchant-invites-get_api');
                Route::post('school/{schoolId}/merchant/send-invite', 'store')->name('admin_merchant-send-invite_api');
            });
        });
    });

    Route::group(['middleware' => ['role:school']], function () {
        Route::prefix('/school/')->group(function () {
            Route::controller(SchoolStudentController::class)->group(function () {
                Route::get('{school_id}/dashboard-students', 'getDashboardStudents')->name('school.dashboard-students');
                Route::get('{school_id}/students', 'getStudents')->name('school.students_api');
            });
            Route::controller(SchoolTransactionController::class)->group(function () {
                Route::get('{school_id}/last-transactions', 'getLastFiveTransactions')->name('school.last-transactions_api');
                Route::get('{school_id}/transactions', 'getTransactions')->name('school.transactions_api');
            });
            Route::controller(SchoolInviteController::class)->group(function () {
                Route::get('{school_id}/invites', 'get')->name('school.invites_api');
                Route::get('{school_id}/invite-emails', 'getInviteEmails')->name('school_invites.get-emails');
                Route::get('{school_id}/user-emails', 'getUserEmails')->name('school_invites.get-emails');
                Route::post('send-invite', 'sendInvite')->name('send.invite');
            });
            Route::controller(TerminalController::class)->group(function () {
                Route::get('{merchant_id}/terminals', 'get')->name('terminal.get');
                Route::post('terminal', 'store')->name('terminal.store');
            });
        });
    });
});

Route::controller()->group(function () {
    Route::get('{public_key}/verify', [TerminalController::class, 'getSignature'])->name('get.signature');
    Route::post('{public_key}/verify', [TerminalController::class, 'verifySignature'])->name('verify.signature');
    Route::get('lunch/retrieve', [LunchController::class, 'retrieveLunch'])->name('lunch.retrieve');
    Route::post('lunch/claim', [LunchController::class, 'claimLunch'])->name('lunch.claim');
    Route::get('lunch/students/retrieve', [LunchController::class, 'retrieveStudents'])->name('lunch.students.retrieve');
});
Route::apiResource('school/lunch', LunchController::class);
