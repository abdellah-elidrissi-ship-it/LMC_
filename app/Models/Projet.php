<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_projet', 'client_id', 'chef_projet_id', 'type_projet',
        'statut', 'jours_prevus', 'jours_realises', 'avancement_percent',
        'blocage', 'commentaire', 'date_debut', 'date_fin_prevue', 'date_fin_reelle'
    ];
    
    protected $appends = ['conso_jours_percent', 'ecart_jours'];
    
    // العلاقات
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function chefProjet()
    {
        return $this->belongsTo(Consultant::class, 'chef_projet_id');
    }
    
    public function normes()
    {
        return $this->belongsToMany(Norme::class, 'projet_normes');
    }
    
    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }
    
    public function consultants()
    {
        return $this->belongsToMany(Consultant::class, 'affectations')
                    ->withPivot('role_dans_projet', 'jours_alloues', 'jours_realises');
    }
    
    public function suiviChapitres()
    {
        return $this->hasMany(SuiviChapitre::class);
    }

    public function ganttPhases()
    {
        return $this->hasMany(GanttPhase::class)->orderBy('ordre');
    }
    
public function formations()
{
    return $this->belongsToMany(Formation::class, 'projet_formations')
                ->withPivot('statut', 'observations', 'jours_realises', 'date_realisation')
                ->withTimestamps();
}

    public function sensibilisations()
    {
        return $this->hasMany(Sensibilisation::class);
    }

    // Accès direct accordé à des users (indépendant du staffing via affectations)
    public function usersAccesDirect()
    {
        return $this->belongsToMany(User::class, 'user_projet_access')->withTimestamps();
    }

    /**
     * Projets visibles pour un user donné : super_admin voit tout,
     * sinon chef_projet_id / affectations (staffing) / user_projet_access
     * (accès direct accordé depuis /admin/users). Seule source de vérité
     * pour cette règle — réutilisée par Api\ProjetController@index.
     */
    public function scopeVisiblesPour($query, User $user)
    {
        if ($user->isSuperAdmin()) {
            return $query;
        }

        return $query->where(function ($q) use ($user) {
            if ($user->consultant_id) {
                $q->where('chef_projet_id', $user->consultant_id)
                    ->orWhereIn('id', function ($sub) use ($user) {
                        $sub->select('projet_id')
                            ->from('affectations')
                            ->where('consultant_id', $user->consultant_id);
                    });
            }

            $q->orWhereIn('id', function ($sub) use ($user) {
                $sub->select('projet_id')
                    ->from('user_projet_access')
                    ->where('user_id', $user->id);
            });
        });
    }

    // الحقول المحسوبة
    public function getConsoJoursPercentAttribute()
    {
        if ($this->jours_prevus > 0) {
            return round(($this->jours_realises / $this->jours_prevus) * 100);
        }
        return 0;
    }
    
    public function getEcartJoursAttribute()
    {
        return $this->jours_realises - $this->jours_prevus;
    }
}