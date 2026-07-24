<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Libellés affichés sur la page 403 — tenus à jour avec PERMS_DEF côté
     * admin-users.blade.php (source de vérité de la liste des permissions).
     */
    private const LABELS = [
        'voir_details' => 'la fiche détails du projet',
        'creer_projets' => 'la création de projet',
        'modifier_projets' => "la modification d'un projet",
        'supprimer_projets' => 'la suppression de projet',
        'voir_consultants' => 'la page Consultants',
        'creer_consultants' => "l'ajout d'un consultant",
        'modifier_consultants' => "la modification d'un consultant",
        'supprimer_consultants' => "la suppression d'un consultant",
        'voir_gantt' => 'le planning Gantt',
        'voir_tableau_bord' => 'le Tableau de Bord',
        'gerer_preuves' => 'la gestion des preuves documentaires',
    ];

    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->user()->hasPermission($permission)) {
            $label = self::LABELS[$permission] ?? 'cette page';
            abort(403, "Accès non autorisé à {$label}");
        }

        return $next($request);
    }
}