<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'prenom', 'nom', 'email', 'password', 'role', 'consultant_id',
        'permissions', 'statut_compte', 'motif_refus',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'permissions' =>'array',
    ];

    // ── Relations ──
    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    // Accès direct à des projets (indépendant du staffing via affectations)
    public function projetsAccesDirect()
    {
        return $this->belongsToMany(Projet::class, 'user_projet_access')->withTimestamps();
    }

    // ── Vérifications de rôle ──
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isChefProjet(): bool
    {
        return $this->role === 'chef_projet';
    }

    public function isConsultant(): bool
    {
        return $this->role === 'consultant';
    }

    // ── Vérification de permission (la seule méthode vraiment nécessaire) ──
    public function hasPermission(string $permission): bool
    {
        // Super Admin a tout
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Pour les autres, vérifier dans le tableau permissions
        $perms = $this->permissions ?? [];
        return ($perms[$permission] ?? 'no') === 'yes';
    }

    // ── Statut du compte (validation manuelle par le Super Admin) ──
    public function estApprouve(): bool
    {
        return $this->statut_compte === 'approuve';
    }

    public function estEnAttente(): bool
    {
        return $this->statut_compte === 'en_attente';
    }

    public static function messageStatut(string $statut): string
    {
        return match ($statut) {
            'en_attente' => "Votre compte est en attente de validation par un administrateur.",
            'refuse' => "Votre demande d'accès a été refusée. Contactez un administrateur pour plus d'informations.",
            default => "Votre compte n'est pas encore actif.",
        };
    }
}