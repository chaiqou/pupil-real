<?php

use App\Http\Controllers\ParentController;
use App\Http\Controllers\SchoolController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});




Route::post('/parent/transactions', [ParentController::class, 'getTransactions'])->name('parent.transactions_api')->middleware('auth');
Route::post('/school/transactions', [SchoolController::class, 'getTransactions'])->name('school.transactions_api')->middleware('auth');
Route::post('/school/students', [SchoolController::class, 'getStudents'])->name('school.students_api')->middleware('auth');
