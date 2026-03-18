<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'consultant_id', 'permissions'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'permissions' => 'array',
    ];

    // ── Relations ──
    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
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
}