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

    // ── Role helpers ──
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

    // ── Permission check ──
    public function hasPermission(string $permission): bool
    {
        // Super admin — tout autorisé
        if ($this->role === 'super_admin') return true;

        $perms = $this->permissions ?? [];
        return ($perms[$permission] ?? 'no') === 'yes';
    }
}