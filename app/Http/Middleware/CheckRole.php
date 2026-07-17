<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
   private const ROLE_LABELS = [
    'super_admin' => 'Super Admin',
    'chef_projet' => 'Chef de Projet',
    'consultant' => 'Consultant',
];

   public function handle(Request $request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    if (!in_array(auth()->user()->role, $roles)) {
        $rolesLabel = implode(', ', array_map(fn($r) => self::ROLE_LABELS[$r] ?? $r, $roles));
        abort(403, "Accès non autorisé — réservé au rôle {$rolesLabel}");
    }

    return $next($request);
}
}