<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    
    // --- Routes du Profil ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Routes des Tickets ---
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/create-tickets', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/add-time', [TicketController::class, 'addTime'])->name('tickets.addTime');

    // --- Dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // --- Routes des Factures ---
    Route::get('/bills', [FactureController::class, 'index'])->name('bills');
    Route::get('/factures/create', [FactureController::class, 'create'])->name('factures.create');
    Route::post('/factures', [FactureController::class, 'store'])->name('factures.store');
    Route::get('/factures/{facture}/edit', [FactureController::class, 'edit'])->name('factures.edit');
    Route::put('/factures/{facture}', [FactureController::class, 'update'])->name('factures.update');
    Route::get('/factures/{facture}/download', [FactureController::class, 'download'])->name('factures.download');
    Route::delete('/factures/{facture}', [FactureController::class, 'destroy'])->name('factures.destroy');

    // --- Routes des Documents ---
    Route::get('/documents', function(){
        $documents = \App\Models\Document::where('user_id', auth()->id())->latest()->get();
        return view('pages.user.documents', compact('documents'));
    })->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // --- Routes des Contacts ---
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');


    Route::get('/settings', function(){
        return view('pages.user.settings');
    })->name('settings');

    // --- Routes des Projets ---
    Route::get('/project', [ProjectController::class, 'index'])->name('projets.index');
    Route::get('/project/create', [ProjectController::class, 'create'])->name('projets.create');
    Route::post('/project', [ProjectController::class, 'store'])->name('projets.store');
    Route::get('/project/{id}', [ProjectController::class, 'show'])->name('projets.show');
    Route::get('/project/{id}/edit', [ProjectController::class, 'edit'])->name('projets.edit');
    Route::put('/project/{id}', [ProjectController::class, 'update'])->name('projets.update');
    Route::delete('/project/{id}', [ProjectController::class, 'destroy'])->name('projets.destroy');
    Route::post('/project/{id}/link-ticket', [ProjectController::class, 'linkTicket'])->name('projets.link_ticket');
});

require __DIR__.'/auth.php';