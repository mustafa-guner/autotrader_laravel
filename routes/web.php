<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::get('email/verify/{id}/{hash}', VerifyEmailController::class)->name('verification.verify');
