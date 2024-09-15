<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\Me\CreateTransactionController;
use App\Http\Controllers\Me\MyBankAccountController;
use App\Http\Controllers\Me\MyNotificationController;
use App\Http\Controllers\Me\MyPhoneController;
use App\Http\Controllers\Me\MyTransactionController;
use App\Http\Controllers\PhoneTypeController;
use App\Http\Controllers\TransactionStatusController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UserTransactionController;
use App\Http\Controllers\VerifyPhoneController;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', RegistrationController::class);
    Route::post('login', [AuthController::class, 'store']);
    Route::post('forgot-password', ForgotPasswordController::class);
    Route::post('reset-password', ResetPasswordController::class);
});

Route::get('genders', GenderController::class);
Route::get('countries', CountryController::class);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('auth/logout', [AuthController::class, 'destroy']);

    Route::get('phone-types', PhoneTypeController::class);
    Route::get('transaction-statuses', TransactionStatusController::class);
    Route::get('transaction-types', TransactionTypeController::class);

    Route::get('banks', [BankController::class, 'index']);
    Route::get('companies', [CompanyController::class, 'index']);
    Route::get('announcements', [AnnouncementController::class, 'index']);

    Route::group(['prefix' => 'me'], function () {
        Route::get('/', [AuthController::class, 'index']);
        Route::resource('phones', MyPhoneController::class)->only(['index', 'store']);
        Route::post('phone/verify', VerifyPhoneController::class);
        Route::resource('transactions', MyTransactionController::class)->only(['index', 'show']);
        Route::post('transactions/create', CreateTransactionController::class);
        Route::get('notifications', MyNotificationController::class);
        Route::resource('bank-accounts', MyBankAccountController::class)->only(['index', 'store', 'destroy']);
    });

    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::resource('banks', BankController::class)->only(['store', 'update', 'destroy']);
        Route::resource('companies', CompanyController::class)->only(['store', 'update', 'destroy']);
        Route::resource('announcements', AnnouncementController::class)->only(['store', 'update', 'destroy']);
        Route::resource('user/{id}/transactions', UserTransactionController::class)->only(['index', 'store']);
    });
});

Route::fallback(function () {
    return ResponseService::fail('Route not found', Response::HTTP_NOT_FOUND);
});
