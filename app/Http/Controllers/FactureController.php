<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::where('user_id', auth()->id())->latest()->get();
        return view('pages.user.bills', compact('factures'));
    }

    // Affiche le formulaire de dépôt
    public function create()
    {
        return view('pages.user.new_facture');
    }

    // Enregistre le fichier déposé
    public function store(Request $request)
    {
        $request->validate([
            'nom_facture' => 'required|string|max:255',
            'statut'      => 'required|in:payee,en cours,cancel',
            'fichier'     => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $fichier     = $request->file('fichier');
        $nomOriginal = $fichier->getClientOriginalName();
        $nomFichier  = time() . '_' . $nomOriginal;

        $fichier->storeAs('facture', $nomFichier, 'local');

        Facture::create([
            'nom_facture' => $request->nom_facture,
            'statut'      => $request->statut,
            'nom_fichier' => $nomFichier,
            'user_id'     => auth()->id(),
        ]);

        return redirect()->route('bills')->with('success', 'Facture déposée avec succès.');
    }

    // Affiche le formulaire de modification
    public function edit(Facture $facture)
    {
        if ($facture->user_id !== auth()->id()) {
            abort(403, 'Accès refusé.');
        }

        return view('pages.user.modif_facture', compact('facture'));
    }

    // Met à jour le statut (et éventuellement le nom) de la facture
    public function update(Request $request, Facture $facture)
    {
        if ($facture->user_id !== auth()->id()) {
            abort(403, 'Accès refusé.');
        }

        $request->validate([
            'nom_facture' => 'required|string|max:255',
            'statut'      => 'required|in:payee,en cours,cancel',
        ]);

        $facture->update([
            'nom_facture' => $request->nom_facture,
            'statut'      => $request->statut,
        ]);

        return redirect()->route('bills')->with('success', 'Facture mise à jour.');
    }

    // Télécharge le fichier — uniquement si c'est l'utilisateur qui l'a déposé
    public function download(Facture $facture)
    {
        if ($facture->user_id !== auth()->id()) {
            abort(403, 'Accès refusé.');
        }

        $chemin = 'facture/' . $facture->nom_fichier;

        if (!Storage::disk('local')->exists($chemin)) {
            abort(404, 'Fichier introuvable.');
        }

        return Storage::disk('local')->download($chemin, $facture->nom_facture);
    }

    // Supprime une facture
    public function destroy(Facture $facture)
    {
        if ($facture->user_id !== auth()->id()) {
            abort(403, 'Accès refusé.');
        }

        Storage::disk('local')->delete('facture/' . $facture->nom_fichier);
        $facture->delete();

        return redirect()->route('bills');
    }
}
