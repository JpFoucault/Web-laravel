<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $ticketsQuery = Ticket::where('createur_id', $user->id)
            ->orWhereHas('membres', fn($q) => $q->where('user_id', $user->id));

        $projetsCount  = Projet::where('createur_id', $user->id)
            ->orWhereHas('collaborateurs', fn($q) => $q->where('user_id', $user->id))
            ->count();

        $ticketsCount  = (clone $ticketsQuery)->count();
        $heuresTotal   = (clone $ticketsQuery)->sum('temps_passe');

        $ticketsRecents = (clone $ticketsQuery)
            ->with('project')
            ->latest()
            ->take(5)
            ->get();

        $projetsRecents = Projet::where('createur_id', $user->id)
            ->orWhereHas('collaborateurs', fn($q) => $q->where('user_id', $user->id))
            ->latest()
            ->take(4)
            ->get();

        return view('dashboard', compact(
            'projetsCount', 'ticketsCount', 'heuresTotal',
            'ticketsRecents', 'projetsRecents'
        ));
    }
}
