<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/project/{id}/link-ticket', [ProjectController::class, 'linkTicket'])->name('projets.link_ticket');
});
