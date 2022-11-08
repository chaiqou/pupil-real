<?php

use App\Http\Controllers\api\LunchController;
use App\Http\Controllers\Dashboard\ParentController;
use App\Http\Controllers\Dashboard\SchoolController;
use App\Http\Controllers\Dashboard\SettingController;
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


Route::middleware('auth')->group(function () {
    Route::prefix('/school/')->group(function() {
         Route::controller(SchoolController::class)->group(function () {
            Route::get('{school_id}/dashboard-students', [SchoolController::class, 'getDashboardStudents'])->name('school.dashboard-students');
            Route::get('{school_id}/last-transactions', [SchoolController::class, 'getLastFiveTransactions'])->name('school.last-transactions_api');
            Route::get('{school_id}/transactions', [SchoolController::class, 'getTransactions'])->name('school.transactions_api');
            Route::get('{school_id}/students', [SchoolController::class, 'getStudents'])->name('school.students_api');
        });
    });

    Route::prefix('/parent/')->group(function() {
      Route::post('update-student', [SettingController::class, 'updateStudent'])->name('parent.update-student_api');
        Route::controller(ParentController::class)->group(function () {
           Route::get('{student_id}/week-spending','getLastWeekTransactionsSpending')->name('parent.week-spending_api');
           Route::get('{student_id}/month-spending','getLastMonthTransactionsSpending')->name('parent.month-spending_api');
           Route::get('{student_id}/last-transactions','getLastFiveTransactions')->name('parent.last-transactions_api');
           Route::get('{user_id}/students','getStudents')->name('parent.students_api');
           Route::get('{student_id}/transactions','getTransactions')->name('parent.transactions_api');
       });
    });
});

Route::apiResource('lunch', LunchController::class);
