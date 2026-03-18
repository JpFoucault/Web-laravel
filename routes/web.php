<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
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
    Route::get('/tickets', function() {
        // Maintenant ça fonctionne car 'Auth' est importé
        $tickets = Auth::user()->tickets()->latest()->get(); 
        return view('pages.user.tickets', compact('tickets'));
    })->name('tickets.index');
    
    Route::get('/create-tickets', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

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

    Route::get('/create_new_project', function(){
        return view('pages.user.create_new_project');
    });

    Route::get('/details_project', function(){
        return view('pages.user.details_project');
    });

    Route::get('/documents', function(){
        return view('pages.user.documents');
    });

    Route::get('/modif_contacts', function(){
        return view('pages.user.modif_contacts');
    });

    Route::get('/modif_project', function(){
        return view('pages.user.modif_project');
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

    Route::get('/project', function(){
        return view('pages.user.project');
    });

    Route::get('/settings', function(){
        return view('pages.user.settings');
    })->name('settings');
});

// C'est ce fichier qui contient déjà la vraie route 'logout' !
require __DIR__.'/auth.php';