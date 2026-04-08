<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // Affiche le formulaire de dépôt
    public function create()
    {
        return view('pages.user.new_document');
    }

    // Enregistre le fichier déposé
    public function store(Request $request)
    {
        $request->validate([
            'nom_document' => 'required|string|max:255',
            'statut'       => 'required|in:payee,en cours,cancel',
            'fichier'      => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $fichier     = $request->file('fichier');
        $nomOriginal = $fichier->getClientOriginalName();
        $nomFichier  = time() . '_' . $nomOriginal;

        $fichier->storeAs('document', $nomFichier, 'local');

        Document::create([
            'nom_document' => $request->nom_document,
            'statut'       => $request->statut,
            'nom_fichier'  => $nomFichier,
            'user_id'      => auth()->id(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Document déposé avec succès.');
    }

    // Affiche le formulaire de modification
    public function edit(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Accès refusé.');
        }

        return view('pages.user.modif_document', compact('document'));
    }

    // Met à jour le statut (et éventuellement le nom) du document
    public function update(Request $request, Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Accès refusé.');
        }

        $request->validate([
            'nom_document' => 'required|string|max:255',
            'statut'       => 'required|in:payee,en cours,cancel',
        ]);

        $document->update([
            'nom_document' => $request->nom_document,
            'statut'       => $request->statut,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document mis à jour.');
    }

    // Télécharge le fichier — uniquement si c'est l'utilisateur qui l'a déposé
    public function download(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Accès refusé.');
        }

        $chemin = 'document/' . $document->nom_fichier;

        if (!Storage::disk('local')->exists($chemin)) {
            abort(404, 'Fichier introuvable.');
        }

        return Storage::disk('local')->download($chemin, $document->nom_document);
    }

    // Supprime un document
    public function destroy(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Accès refusé.');
        }

        Storage::disk('local')->delete('document/' . $document->nom_fichier);
        $document->delete();

        return redirect()->route('documents.index');
    }
}
