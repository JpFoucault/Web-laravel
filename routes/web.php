<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

    // J'AI SUPPRIMÉ LA LIGNE AUTHCONTROLLER ICI CAR AUTH.PHP S'EN CHARGE DÉJÀ.

    // --- Autres vues statiques ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/bills', function(){
        return view('pages.user.bills');
    });

    Route::get('/contacts', function(){
        return view('pages.user.contacts');
    });

    Route::get('/documents', function(){
        return view('pages.user.documents');
    });

    Route::get('/modif_contacts', function(){
        return view('pages.user.modif_contacts');
    });


    Route::get('/modif_tickets', function(){
        return view('pages.user.modif_tickets');
    });

    Route::get('/new_bills', function(){
        return view('pages.user.new_bills');
    });

    Route::get('/new_contacts', function(){
        return view('pages.user.new_contacts');
    });

    Route::get('/new_documents', function(){
        return view('pages.user.new_documents');
    });

    Route::get('/settings', function(){
        return view('pages.user.settings');
    })->name('settings');
// On force l'URL à "/project" mais on garde le nom de route "projets.index" pour ne pas casser tes vues
    Route::get('/project', [ProjectController::class, 'index'])->name('projets.index');
    Route::get('/project/create', [ProjectController::class, 'create'])->name('projets.create');
    Route::post('/project', [ProjectController::class, 'store'])->name('projets.store');
    Route::get('/project/{id}', [ProjectController::class, 'show'])->name('projets.show');
    Route::get('/project/{id}/edit', [ProjectController::class, 'edit'])->name('projets.edit');
    Route::put('/project/{id}', [ProjectController::class, 'update'])->name('projets.update');
    Route::delete('/project/{id}', [ProjectController::class, 'destroy'])->name('projets.destroy');
    
    // Ta route pour lier les tickets
    Route::post('/project/{id}/link-ticket', [ProjectController::class, 'linkTicket'])->name('projets.link_ticket');
});

// C'est ce fichier qui contient déjà la vraie route 'logout' !
require __DIR__.'/auth.php';