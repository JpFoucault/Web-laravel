<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;



class TicketController extends Controller
{
    public function create()
    {
        $projects = Project::all(); // Récupère tous tes projets
        return view('pages.user.create_tickets', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:150',
            'description' => 'required',
            'type' => 'required|in:bug,feature,support',
            'priorite' => 'required|in:low,medium,high,critical',
            'delai' => 'nullable|date',
            'projet_id' => 'nullable|exists:projects,id',
        ]);

        // On ajoute manuellement l'ID du créateur (utilisateur connecté)
        $validated['createur_id'] = auth()->id();
        $validated['statut'] = 'Nouveau';

        Ticket::create($validated);

        return redirect()->route('tickets.index')->with('success', 'Ticket créé !');
    }
}
