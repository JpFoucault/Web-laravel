<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomPasswordResetController extends Controller
{
    private const RESET_CODE = '2222';

    // Étape 1 : afficher le formulaire email
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    // Étape 1 : soumettre l'email
    public function submitEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Aucun compte associé à cette adresse email.',
        ]);

        session(['reset_email' => $request->email]);

        return redirect()->route('password.verify-code');
    }

    // Étape 2 : afficher le formulaire de code
    public function showCodeForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-reset-code');
    }

    // Étape 2 : valider le code
    public function submitCode(Request $request)
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'code' => 'required|string',
        ]);

        if ($request->code !== self::RESET_CODE) {
            return back()->withErrors(['code' => 'Code incorrect. Réessayez.']);
        }

        session(['reset_code_verified' => true]);

        return redirect()->route('password.reset-custom');
    }

    // Étape 3 : afficher le formulaire de nouveau mot de passe
    public function showResetForm()
    {
        if (!session('reset_email') || !session('reset_code_verified')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password-custom', [
            'email' => session('reset_email'),
        ]);
    }

    // Étape 3 : mettre à jour le mot de passe
    public function submitReset(Request $request)
    {
        if (!session('reset_email') || !session('reset_code_verified')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', session('reset_email'))->firstOrFail();
        $user->update(['password' => Hash::make($request->password)]);

        session()->forget(['reset_email', 'reset_code_verified']);

        return redirect()->route('login')->with('status', 'Mot de passe réinitialisé avec succès !');
    }
}
