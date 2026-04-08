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
        
        $estCreateur = $projet->createur_id === $user->id;
        $estCollaborateur = $projet->collaborateurs->contains($user->id);

        if (!$estCreateur && !$estCollaborateur) {
            abort(403, "Accès refusé : Vous n'avez pas le droit de voir ce projet.");
        }

        $total_heures = $projet->tickets->sum('temps_passe'); 
        $free_tickets = Ticket::whereNull('projet_id')->get();

        return view('pages.user.details_project', compact('projet', 'total_heures', 'free_tickets'));
    }

    public function edit($id)
    {
        $projet = Projet::findOrFail($id);

        if ($projet->createur_id !== Auth::id()) {
            abort(403, "Accès refusé : Seul le créateur du projet peut le modifier.");
        }

        $users = User::orderBy('name')->get();
        $collabs_array = $projet->collaborateurs->pluck('id')->toArray();

        return view('pages.user.modif_project', compact('projet', 'users', 'collabs_array'));
    }

    public function store(Request $request)
    {
        // 1. Validation des données entrantes (Sécurité)
        $validated = $request->validate([
            'nom_projet'   => 'required|string|max:255',
            'client_name'  => 'nullable|string|max:255',
            'statut'       => 'required|in:nouveau,en_cours,termine,en_pause',
            'description'  => 'nullable|string',
            'date_debut'   => 'nullable|date',
            'date_fin'     => 'nullable|date|after_or_equal:date_debut',
            'budget'       => 'nullable|numeric|min:0',
            'temps_estime' => 'nullable|integer|min:0',
            'technologies' => 'nullable|string',
            'collabs'      => 'nullable|array',
            'collabs.*'    => 'exists:users,id'
        ]);

        // 2. Ajout de l'ID du créateur
        $validated['createur_id'] = auth()->id();

        // 3. Création du projet en base de données
        $projet = Projet::create($validated);

        // 4. Ajout des collaborateurs (si des cases ont été cochées)
        if ($request->has('collabs')) {
            // attach() lie automatiquement les ID des utilisateurs à ce projet dans la table pivot
            $projet->collaborateurs()->attach($request->collabs);
        }

        // 5. Redirection avec un message de succès
        return redirect()->route('projets.index')->with('success', 'Le projet a été créé avec succès !');
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

        return redirect()->route('projets.show', $projet->id)->with('success', 'Projet mis à jour !');
    }

    public function destroy($id)
    {
        $projet = Projet::findOrFail($id);
        
        // VÉRIFICATION DE SÉCURITÉ MANUELLE
        if ($projet->createur_id !== Auth::id()) {
            abort(403, "Accès refusé : Seul le créateur peut supprimer ce projet.");
        }
        
        $projet->delete();
        return redirect()->route('projets.index')->with('success', 'Projet supprimé.');
    }

    public function linkTicket(Request $request, $id)
    {
        $projet = Projet::findOrFail($id);

        if ($projet->createur_id !== Auth::id()) {
            return response()->json(['error' => 'Accès refusé'], 403);
        }

        $ticket = Ticket::findOrFail($request->ticket_id);
        $ticket->projet_id = $projet->id;
        $ticket->save();

        // Recharge les relations pour la réponse
        $ticket->load('createur');

        return response()->json([
            'success' => true,
            'ticket' => [
                'id'       => $ticket->id,
                'titre'    => $ticket->titre,
                'priorite' => $ticket->priorite,
                'statut'   => $ticket->statut,
                'delai'    => $ticket->delai
                    ? \Carbon\Carbon::parse($ticket->delai)->format('d/m/Y')
                    : null,
                'createur' => $ticket->createur?->name ?? '—',
                'url'      => route('tickets.show', $ticket->id),
            ]
        ]);
    }
}