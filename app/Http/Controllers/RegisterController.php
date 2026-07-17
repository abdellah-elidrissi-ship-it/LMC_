<?php

namespace App\Http\Controllers;

use App\Mail\VerifyAccountMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function create()
    {
        if (Auth::check()) return redirect('/');
        return view('register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.unique' => 'Un compte existe déjà avec cet email.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $user = User::create([
            'name' => trim($validated['prenom'] . ' ' . $validated['nom']),
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'consultant',
            'statut_compte' => 'en_attente',
            'permissions' => [],
        ]);

        Mail::to($user->email)->send(new VerifyAccountMail($user));

        return redirect('/login')->with(
            'success',
            'Compte créé ! Vérifiez votre boîte mail pour confirmer votre adresse — votre demande sera ensuite examinée par un administrateur.'
        );
    }
}
