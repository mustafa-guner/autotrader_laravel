<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\Feedback\FeedbackController;
use App\Http\Controllers\Feedback\FeedbackTypeController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\Me\CreateTransactionController;
use App\Http\Controllers\Me\MyBankAccountController;
use App\Http\Controllers\Me\MyNotificationController;
use App\Http\Controllers\Me\MyPhoneController;
use App\Http\Controllers\Me\MyTransactionController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PhoneTypeController;
use App\Http\Controllers\TransactionStatusController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UpdateProfileController;
use App\Http\Controllers\UserBalanceHistoryController;
use App\Http\Controllers\UserTransactionController;
use App\Http\Controllers\VerifyPhoneController;
use App\Http\Controllers\WithdrawController;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', RegisterController::class)->name('auth.register');
    Route::post('login', [AuthController::class, 'store'])->name('auth.login');
    Route::post('forgot-password', ForgotPasswordController::class)->name('auth.forgot-password');
    Route::post('reset-password', ResetPasswordController::class)->name('auth.reset-password');
});

Route::get('genders', GenderController::class)->name('genders.index');
Route::get('countries', CountryController::class)->name('countries.index');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('auth/logout', [AuthController::class, 'destroy'])->name('auth.logout');

    //Phone types module is not in use currently
    Route::get('phone-types', PhoneTypeController::class)->name('phone-types.index');
    Route::get('transaction-statuses', TransactionStatusController::class)->name('transaction-statuses.index');
    Route::get('transaction-types', TransactionTypeController::class)->name('transaction-types.index');

    Route::get('banks', [BankController::class, 'index'])->name('banks.index');
    Route::get('companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

    Route::group(['prefix' => 'me'], function () {
        Route::get('/', [AuthController::class, 'index'])->name('me.index');
        Route::put('/update',[UpdateProfileController::class,'update']);
        Route::resource('phones', MyPhoneController::class)->only(['index', 'store']);
        Route::post('phone/verify', VerifyPhoneController::class)->name('phone.verify');

        Route::get('balance-histories', [UserBalanceHistoryController::class, 'index'])->name('balance-histories.index');

        Route::resource('transactions', MyTransactionController::class)->only(['index', 'show']);
        Route::post('transactions/create', CreateTransactionController::class)->name('transactions.create');
        Route::get('notifications', MyNotificationController::class)->name('notifications.index');

        Route::resource('bank-accounts', MyBankAccountController::class)->only(['index', 'store', 'destroy']);
        Route::resource('payment-methods', PaymentMethodController::class)->only(['index', 'store','destroy']);

        Route::put('deposit',[DepositController::class,'update']);
        Route::put('withdraw',[WithdrawController::class,'update']);
    });

    Route::get('feedback-types', [FeedbackTypeController::class, 'index'])->name('feedback-types.index');
    Route::post('feedbacks/create', [FeedbackController::class, 'store'])->name('feedbacks.store');


    //Admin module is not in use currently
    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::resource('feedbacks', FeedbackController::class)->only(['index']);
        Route::resource('banks', BankController::class)->only(['store', 'update', 'destroy']);
        Route::resource('companies', CompanyController::class)->only(['store', 'update', 'destroy']);
        Route::resource('announcements', AnnouncementController::class)->only(['store', 'update', 'destroy']);
        Route::resource('user/{id}/transactions', UserTransactionController::class)->only(['index', 'store']);
    });
});

Route::fallback(function () {
    return ResponseService::fail('Route not found', Response::HTTP_NOT_FOUND);
});
