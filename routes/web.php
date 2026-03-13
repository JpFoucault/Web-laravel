<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\login\LoginController::class, 'index']);
Route::get('forget', [\App\Http\Controllers\login\ForgetPasswordController::class, 'index']);
Route::get('create', [\App\Http\Controllers\login\CreateAccountController::class, 'index']);
Route::get('confirm', [\App\Http\Controllers\login\ConfirmEmailController::class, 'index']);
Route::get('dashboard', [\App\Http\Controllers\user\DashboardController::class, 'index']);
