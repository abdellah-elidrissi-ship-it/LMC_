<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Vérifie l'email d'un candidat qui ne s'est jamais connecté (pas de
     * session) — volontairement pas le contrôleur stock Laravel qui
     * suppose un utilisateur déjà authentifié.
     */
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            abort(403);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect('/login')->with(
            'success',
            'Email vérifié ! Votre demande est maintenant en attente de validation par un administrateur.'
        );
    }
}
