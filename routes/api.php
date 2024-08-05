<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\MyTransactionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CreateTransactionController;
use App\Http\Controllers\TransactionStatusController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UserTransactionController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', RegistrationController::class);
    Route::resource('auth', AuthController::class)->only(['index', 'store']);
});
Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)->name('verification.verify');


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [AuthController::class, 'destroy']);

    Route::get('genders', GenderController::class);
    Route::get('countries', CountryController::class);
    Route::get('transaction-statuses', [TransactionStatusController::class, 'index']);
    Route::get('transaction-types', [TransactionTypeController::class, 'index']);
    Route::get('banks', [BankController::class, 'index']);
    Route::get('companies', [CompanyController::class, 'index']);

    Route::resource('transactions', MyTransactionController::class)->only(['index', 'show']);
    Route::post('transactions/create', CreateTransactionController::class);

    Route::group(['middleware' => 'admin'], function () {
        Route::resource('banks', BankController::class)->only(['store', 'update', 'destroy']);
        Route::resource('companies', CompanyController::class)->only(['store', 'update', 'destroy']);
        Route::resource('user/{id}/transactions', UserTransactionController::class)->only(['index', 'store']);
    });
});
