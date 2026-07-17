<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAccountApproved
{
    /**
     * Filet de sécurité : si une session existante devient non-approuvée
     * (ex. l'admin repasse un compte en "refuse" pendant qu'il est
     * connecté), on le déconnecte au prochain accès à une page protégée.
     * Le blocage principal a lieu à la connexion (AuthController::login).
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->estApprouve()) {
            $message = User::messageStatut($user->statut_compte);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->withErrors(['email' => $message]);
        }

        return $next($request);
    }
}
