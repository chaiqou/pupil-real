<?php

use App\Http\Controllers\NavigationController;
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




Route::get('/parent/transactions/{id}', [NavigationController::class, 'getParentTransactions'])->name('parent.transactions_api');
Route::get('/school/transactions/{id}', [NavigationController::class, 'getSchoolTransactions'])->name('school.transactions_api');
