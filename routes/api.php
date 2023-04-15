<?php

use App\Http\Controllers\Admin\Api\InviteController as AdminInviteController;
use App\Http\Controllers\Admin\Api\Merchant\InviteController as AdminMerchantInviteController;
use App\Http\Controllers\Admin\Api\Merchant\MerchantController as AdminMerchantController;
use App\Http\Controllers\Admin\Api\SchoolController as AdminSchoolController;
use App\Http\Controllers\Admin\Api\StudentController as AdminStudentController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\BillingoController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\LanguageController as ApiLanguageController;
use App\Http\Controllers\Merchant\Api\InviteController as ApiMerchantInviteController;
use App\Http\Controllers\Merchant\Api\MenuManagement\MenuExportController;
use App\Http\Controllers\Merchant\Api\MenuManagement\MenuManagementController;
use App\Http\Controllers\Parent\Api\InviteController as ApiParentInviteController;
use App\Http\Controllers\Parent\Api\OrderLunchController;
use App\Http\Controllers\Parent\Api\ParentMenuController;
use App\Http\Controllers\Parent\Api\SettingController as ParentSettingController;
use App\Http\Controllers\Parent\Api\StudentController as ParentStudentController;
use App\Http\Controllers\Parent\Api\TransactionController as ParentTransactionController;
use App\Http\Controllers\Parent\StripeCheckoutController;
use App\Http\Controllers\School\Api\InviteController as SchoolInviteController;
use App\Http\Controllers\School\Api\LineAreaChartController;
use App\Http\Controllers\School\Api\Lunch\LunchController;
use App\Http\Controllers\School\Api\PieChartController;
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
            Route::post('lunch-order/{student_id}/', [OrderLunchController::class, 'orderLunch'])->name('parent.order_lunch');
            Route::get('available-orders/{student_id}', [OrderLunchController::class, 'availableOrders'])->name('parent.available-orders');
            Route::post('checkout', [StripeCheckoutController::class, 'checkout'])->name('parent.checkout');
            Route::get('menu-retrieve/{student_id}', [ParentMenuController::class, 'menuRetrieve'])->name('parent.menu_retrieve');
            Route::post('choice-claims', [MenuManagementController::class, 'updateChoiceMenuClaims'])->name('parent.update_chpice_menu_claims');
            Route::controller(ParentSettingController::class)->group(function () {
                Route::post('update-password/{user_id}', 'updatePassword')->name('parent.update-password_api');
                Route::post('update-student', 'updateStudent')->name('parent.update-student_api');
            });
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
                Route::delete('invite/{invite_id}', 'delete')->name('admin.delete-invite');
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
                Route::delete('invite/{invite_id}', 'delete')->name('school.delete-invite');
            });
            Route::controller(TerminalController::class)->group(function () {
                Route::get('terminals', 'get')->name('terminal.get');
                Route::post('terminal', 'store')->name('terminal.store');
            });
            Route::controller(PieChartController::class)->group(function () {
                Route::get('pie-chart-data', 'calculateChartInfo')->name('school.pie-chart-data');
            });
            Route::controller(LineAreaChartController::class)->group(function () {
                Route::get('line-chart-data', 'calculateChartInfo')->name('school.line-chart-data');
            });
            Route::controller(InsightController::class)->group(function () {
                Route::get('active-students', 'activeStudents')->name('school.active-students_insights');
                Route::get('average-transactions', 'averageTransactionValue')->name('school.average-transactions_insights');
                Route::get('pending-transactions-value', 'pendingTransactionValue')->name('school.pending-transactions-value_insights');
                Route::get('average-student-weekly-spending', 'averageStudentWeeklySpending')->name('school.avg-student-weekly-spending_insights');
            });
        });
    });

    // Here should be defended routes
    Route::post('merchant/create-menu', [MenuManagementController::class, 'createMenu'])->name('merchant.create_menu');
    Route::get('merchant/request-export-menu', [MenuExportController::class, 'exportMenu'])->name('merchant.export_menu');
});

Route::controller()->group(function () {
    Route::get('{public_key}/verify', [TerminalController::class, 'getSignature'])->name('get.signature');
    Route::post('{public_key}/verify', [TerminalController::class, 'verifySignature'])->name('verify.signature');
    Route::get('lunch/retrieve', [LunchController::class, 'retrieveLunch'])->name('lunch.retrieve');
    Route::post('lunch/claim', [LunchController::class, 'claimLunch'])->name('lunch.claim');
    Route::get('lunch/students/retrieve', [LunchController::class, 'retrieveStudents'])->name('lunch.students.retrieve');
    Route::get('lunch/suitable-lunch/date', [LunchController::class, 'suitableLunchForDate'])->name('lunch.suitable_date');
});
Route::apiResource('school/lunch', LunchController::class);
Route::get('school/download-excel-lunches', [LunchController::class, 'excelLunches'])->name('schoo.excel_lunches');

Route::middleware(['guest'])->group(function () {
    Route::post('/resend-onboarding-verification/{uniqueID}', [TwoFactorAuthenticationController::class, 'resendForOnboardingUserApi'])->name('resend-verification_api');
    Route::controller(ApiParentInviteController::class)->group(function () {
        Route::post('/parent-setup-account/{uniqueID}', 'submitSetupAccount')->name('parent-setup.account_submit');

        Route::post('/parent-personal-form/{uniqueID}', 'submitPersonalForm')->name('parent-personal.form_submit');

        Route::post('/parent-setup-cards/{uniqueID}', 'submitSetupCards')->name('parent-setup.cards_submit');

        Route::post('/parent-verify-email/{uniqueID}', 'submitVerifyEmail')->name('parent-verify.email_submit');
    });
    Route::controller(ApiMerchantInviteController::class)->group(function () {
        Route::post('/merchant-setup-account/{uniqueID}', 'submitSetupAccount')->name('merchant-setup.account_submit');

        Route::post('/merchant-personal-form/{uniqueID}', 'submitPersonalForm')->name('merchant-personal.form_submit');

        Route::post('/merchant-company-details/{uniqueID}', 'submitCompanyDetails')->name('merchant-company.details_submit');

        Route::get('/merchant-setup-stripe/{uniqueID}', 'submitSetupStripe')->name('merchant-setup.stripe_submit');

        Route::get('/merchant-billingo-verify/{uniqueID}', 'billingoVerify')->name('merchant-billingo.verify');

        Route::post('/merchant-verify-email/{uniqueID}', 'submitVerifyEmail')->name('merchant-verify.email_submit');
    });
    Route::controller(BillingoController::class)->group(function () {
        Route::post('/merchant-billingo-verify/{uniqueID}', 'submitBillingoVerify')->name('merchant-billingo-verify_submit');
    });
});

Route::get('{user}/set-language/{locale}', [ApiLanguageController::class, 'setLocale'])->name('set-language');
