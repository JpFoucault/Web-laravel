<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::where('user_id', auth()->id())->get();
        return view('pages.user.contacts', compact('contacts'));
    }

    public function create()
    {
        return view('pages.user.new_contacts');
    }

    public function store(Request $request)
    {
        $request->validate([
            'prenom'     => 'required|string|max:255',
            'nom'        => 'required|string|max:255',
            'poste'      => 'required|string|max:255',
            'entreprise' => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'telephone'  => 'nullable|string|max:20',
            'notes'      => 'nullable|string',
        ]);

        Contact::create(array_merge($request->only([
            'prenom', 'nom', 'poste', 'entreprise', 'email', 'telephone', 'notes',
        ]), ['user_id' => auth()->id()]));

        return redirect()->route('contacts.index');
    }

    public function edit(Contact $contact)
    {
        abort_if($contact->user_id !== auth()->id(), 403);
        return view('pages.user.modif_contacts', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        abort_if($contact->user_id !== auth()->id(), 403);

        $request->validate([
            'prenom'     => 'required|string|max:255',
            'nom'        => 'required|string|max:255',
            'poste'      => 'required|string|max:255',
            'entreprise' => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'telephone'  => 'nullable|string|max:20',
            'notes'      => 'nullable|string',
        ]);

        $contact->update($request->only([
            'prenom', 'nom', 'poste', 'entreprise', 'email', 'telephone', 'notes',
        ]));

        return redirect()->route('contacts.index');
    }

    public function destroy(Contact $contact)
    {
        abort_if($contact->user_id !== auth()->id(), 403);
        $contact->delete();
        return redirect()->route('contacts.index');
    }
}
