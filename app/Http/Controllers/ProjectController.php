<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        
        // On récupère les projets créés + assignés
        $projets = clone $user->projetsCrees->merge($user->projetsCollab)->sortByDesc('created_at');
        
        // Pointe vers resources/views/pages/user/project.blade.php
        return view('pages.user.project', compact('projets'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get(); 
        
        // Pointe vers resources/views/pages/user/create_new_project.blade.php
        return view('pages.user.create_new_project', compact('users'));
    }

    public function show($id)
    {
        $projet = Projet::with(['tickets', 'collaborateurs'])->findOrFail($id);
        $user = Auth::user();
        
        // Vérification de sécurité
        $estCreateur = $projet->createur_id === $user->id;
        $estCollaborateur = $projet->collaborateurs->contains($user->id);

        if (!$estCreateur && !$estCollaborateur) {
            abort(403, "Accès refusé : Vous n'avez pas le droit de voir ce projet.");
        }

        $total_heures = $projet->tickets->sum('temps_passe'); 
        $free_tickets = Ticket::whereNull('projet_id')->orWhere('projet_id', '!=', $id)->get();

        // Pointe vers resources/views/pages/user/details_project.blade.php
        return view('pages.user.details_project', compact('projet', 'total_heures', 'free_tickets'));
    }

    public function edit($id)
    {
        $projet = Projet::findOrFail($id);

        // Vérification de sécurité
        if ($projet->createur_id !== Auth::id()) {
            abort(403, "Accès refusé : Seul le créateur du projet peut le modifier.");
        }

        $users = User::orderBy('name')->get();
        $collabs_array = $projet->collaborateurs->pluck('id')->toArray();

        // Pointe vers resources/views/pages/user/modif_project.blade.php
        return view('pages.user.modif_project', compact('projet', 'users', 'collabs_array'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_projet' => 'required|string|max:255',
            'client_name' => 'nullable|string',
            'statut' => 'required|string',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date',
            'budget' => 'nullable|numeric',
            'temps_estime' => 'nullable|integer',
            'technologies' => 'nullable|string',
        ]);

        $validated['createur_id'] = Auth::id();
        $projet = Projet::create($validated);

        if ($request->has('collabs')) {
            $projet->collaborateurs()->sync($request->collabs);
        }

        return redirect()->route('pages.user.project')->with('success', 'Projet créé avec succès !');
    }

    public function update(Request $request, $id)
    {
        $projet = Projet::findOrFail($id);

        // VÉRIFICATION DE SÉCURITÉ MANUELLE
        if ($projet->createur_id !== Auth::id()) {
            abort(403, "Accès refusé : Seul le créateur du projet peut le modifier.");
        }

        $projet->update($request->except(['_token', '_method', 'collabs']));

        if ($request->has('collabs')) {
            $projet->collaborateurs()->sync($request->collabs);
        } else {
            $projet->collaborateurs()->detach();
        }

        return redirect()->route('pages.user.details_project', $projet->id)->with('success', 'Projet mis à jour !');
    }

    public function destroy($id)
    {
        $projet = Projet::findOrFail($id);
        
        // VÉRIFICATION DE SÉCURITÉ MANUELLE
        if ($projet->createur_id !== Auth::id()) {
            abort(403, "Accès refusé : Seul le créateur peut supprimer ce projet.");
        }
        
        $projet->delete();
        return redirect()->route('pages.user.project')->with('success', 'Projet supprimé.');
    }

    public function linkTicket(Request $request, $id)
    {
        $projet = Projet::findOrFail($id);

        // VÉRIFICATION DE SÉCURITÉ MANUELLE
        if ($projet->createur_id !== Auth::id()) {
            abort(403, "Accès refusé : Seul le créateur peut lier des tickets.");
        }

        $ticket = Ticket::findOrFail($request->ticket_id);
        $ticket->projet_id = $projet->id;
        $ticket->save();

        return back()->with('success', 'Ticket lié avec succès.');
    }
}