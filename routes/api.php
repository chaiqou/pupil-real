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

Route::post('/parent/transactions', [ParentController::class, 'getTransactions'])->name('parent.transactions_api')->middleware('auth');
Route::post('/school/transactions', [SchoolController::class, 'getTransactions'])->name('school.transactions_api')->middleware('auth');
Route::post('/school/students', [SchoolController::class, 'getStudents'])->name('school.students_api')->middleware('auth');
Route::post('/parent/week-spending', [ParentController::class, 'getLastWeekTransactionsSpending'])->name('parent.week-spending_api')->middleware('auth');
Route::post('/parent/month-spending', [ParentController::class, 'getLastMonthTransactionsSpending'])->name('parent.month-spending_api')->middleware('auth');
Route::post('/parent/last-transactions', [ParentController::class, 'getLastFiveTransactions'])->name('parent.last-transactions_api')->middleware('auth');
Route::post('/parent/students', [ParentController::class, 'getStudents'])->name('parent.students_api')->middleware('auth');
Route::post('/parent/update-student', [SettingController::class, 'updateStudent'])->name('parent.update-student_api')->middleware('auth');
Route::post('/school/dashboard-students', [SchoolController::class, 'getDashboardStudents'])->name('school.dashboard-students')->middleware('auth');
Route::post('/school/last-transactions', [SchoolController::class, 'getLastFiveTransactions'])->name('school.last-transactions_api')->middleware('auth');

Route::apiResource('lunch', LunchController::class);
