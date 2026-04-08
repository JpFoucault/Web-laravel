<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\CustomPasswordResetController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Étape 1 : email
    Route::get('forgot-password', [CustomPasswordResetController::class, 'showEmailForm'])
        ->name('password.request');
    Route::post('forgot-password', [CustomPasswordResetController::class, 'submitEmail'])
        ->name('password.email');

    // Étape 2 : code de vérification
    Route::get('verify-reset-code', [CustomPasswordResetController::class, 'showCodeForm'])
        ->name('password.verify-code');
    Route::post('verify-reset-code', [CustomPasswordResetController::class, 'submitCode'])
        ->name('password.submit-code');

    // Étape 3 : nouveau mot de passe
    Route::get('reset-password-custom', [CustomPasswordResetController::class, 'showResetForm'])
        ->name('password.reset-custom');
    Route::post('reset-password-custom', [CustomPasswordResetController::class, 'submitReset'])
        ->name('password.update-custom');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
