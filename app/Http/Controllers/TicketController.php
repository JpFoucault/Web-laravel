<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Tickets créés PAR l'user + tickets où il est membre
        $tickets = Ticket::where('createur_id', $user->id)
            ->orWhereHas('membres', fn($q) => $q->where('user_id', $user->id))
            ->with(['project', 'membres'])
            ->latest()
            ->get();

        return view('pages.user.tickets', compact('tickets'));
    }

    public function create()
    {
        $projects = Project::all();
        $users    = User::where('id', '!=', auth()->id())->get();
        return view('pages.user.create_tickets', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'       => 'required|string|max:150',
            'description' => 'required',
            'type'        => 'required|in:bug,feature,support',
            'priorite'    => 'required|in:low,medium,high,critical',
            'delai'       => 'nullable|date',
            'projet_id'   => 'nullable|exists:projets,id',
            'membres'     => 'nullable|array',
            'membres.*.id'   => 'exists:users,id',
            'membres.*.role' => 'in:lecteur,editeur',
        ]);

        $validated['createur_id'] = auth()->id();
        $validated['statut']      = 'Nouveau';

        $ticket = Ticket::create($validated);

        // Attacher les membres avec leur rôle
        if (!empty($request->membres)) {
            $syncData = [];
            foreach ($request->membres as $membre) {
                $syncData[$membre['id']] = ['role' => $membre['role']];
            }
            $ticket->membres()->sync($syncData);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket créé avec succès !');
    }

    public function edit(Ticket $ticket)
    {
        abort_if(!$ticket->peutModifier(auth()->user()), 403);

        $projects = Project::all();
        $users    = User::where('id', '!=', auth()->id())->get();
        $membresActuels = $ticket->membres()->pluck('role', 'users.id');

        return view('pages.user.modif_tickets', compact('ticket', 'projects', 'users', 'membresActuels'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        abort_if(!$ticket->peutModifier(auth()->user()), 403);

        $validated = $request->validate([
            'titre'       => 'required|string|max:150',
            'description' => 'required',
            'type'        => 'required|in:bug,feature,support',
            'priorite'    => 'required|in:low,medium,high,critical',
            'statut'      => 'required|string',
            'delai'       => 'nullable|date',
            'projet_id'   => 'nullable|exists:projets,id',
            'membres'     => 'nullable|array',
            'membres.*.id'   => 'exists:users,id',
            'membres.*.role' => 'in:lecteur,editeur',
        ]);

        $ticket->update($validated);

        // Re-synchroniser les membres
        $syncData = [];
        foreach ($request->membres ?? [] as $membre) {
            $syncData[$membre['id']] = ['role' => $membre['role']];
        }
        $ticket->membres()->sync($syncData);

        return redirect()->route('tickets.index')->with('success', 'Ticket modifié avec succès !');
    }

    public function destroy(Ticket $ticket)
    {
        abort_if($ticket->createur_id !== auth()->id(), 403);
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket supprimé.');
    }

    public function show(Ticket $ticket)
    {
        // Sécurité : seuls les membres et le créateur peuvent voir
        abort_if(!$ticket->estVisible(auth()->user()), 403);

        // Charge les relations utiles pour la page
        $ticket->load(['project', 'createur', 'membres']);

        return view('pages.user.ticket_detail', compact('ticket'));
    }

    public function addTime(Request $request, Ticket $ticket)
    {
        abort_if(!$ticket->estVisible(auth()->user()), 403);

        $request->validate(['heures' => 'required|integer|min:1']);

        $ticket->increment('temps_passe', $request->heures);

        return redirect()->route('tickets.show', $ticket)->with('time_added', true);
    }
}