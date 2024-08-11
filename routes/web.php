<?php

use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::get('email/verify/{id}/{hash}', VerifyEmailController::class)->name('verification.verify');
