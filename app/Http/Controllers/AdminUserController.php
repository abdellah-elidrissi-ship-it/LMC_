<?php

namespace App\Http\Controllers;

use App\Mail\CompteApprouveMail;
use App\Mail\CompteRefuseMail;
use App\Models\AccesAuditLog;
use App\Models\User;
use App\Models\Consultant;
use App\Models\Projet;
use App\Models\Tache;
use App\Notifications\TacheAssigneeNotification;
use App\Services\ProjetAccessNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminUserController extends Controller
{
    private const ROLE_RULE = 'required|in:super_admin,chef_projet,consultant';

    public function index()
    {
        $users = User::with([
                'consultant.projetsDiriges:id,reference_projet,chef_projet_id',
                'consultant.projets:id,reference_projet',
                'projetsAccesDirect:id,reference_projet',
            ])
            ->where('statut_compte', 'approuve')
            ->get();

        $consultantUserIds = User::whereNotNull('consultant_id')->pluck('id', 'consultant_id');

        $consultants = Consultant::orderBy('nom_complet')->get();

        $consultants = $consultants->map(function ($c) use ($consultantUserIds) {
            $c->user_id = $consultantUserIds->get($c->id);
            return $c;
        });

        $enAttente = User::where('statut_compte', 'en_attente')
            ->whereNotNull('email_verified_at')
            ->orderBy('created_at')
            ->get();

        $consultantsSansCompte = $consultants->whereNull('user_id')->values();

        $projets = Projet::orderBy('reference_projet')->get(['id', 'reference_projet']);

        $users = $users->map(function ($user) {
            $user->projets_derives = (!$user->isSuperAdmin() && $user->consultant)
                ? $user->consultant->projetsDiriges->merge($user->consultant->projets)->unique('id')->values()
                : collect();

            $user->projets_directs = $user->isSuperAdmin() ? collect() : $user->projetsAccesDirect;

            return $user;
        });

        $auditLog = AccesAuditLog::with(['user', 'admin'])->latest()->limit(30)->get();

        return view('admin-users', compact(
            'users', 'enAttente', 'consultantsSansCompte', 'projets', 'auditLog'
        ));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => self::ROLE_RULE,
            'password' => 'nullable|min:8',
        ]);

        if ($user->role === 'super_admin' && $request->role !== 'super_admin') {
            if (User::where('role', 'super_admin')->count() <= 1) {
                return back()->with('error', 'Impossible de rétrograder le seul Super Admin.');
            }
        }

        $data = [
            'name'        => $request->name,
            'email'       => $request->email,
            'role'        => $request->role,
            'permissions' => $request->input('permissions', []),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', "Compte de {$user->name} mis à jour.");
    }

    /**
     * Approuve une demande d'inscription en attente : l'admin fixe le
     * rôle final, les permissions, et lie (ou crée) un profil Consultant.
     */
    public function approuver(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user->estEnAttente()) {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $validated = $request->validate([
            'role' => self::ROLE_RULE,
            'permissions' => 'nullable|array',
            'consultant_mode' => 'required_unless:role,super_admin|in:existing,nouveau',
            'consultant_id' => 'required_if:consultant_mode,existing|nullable|exists:consultants,id',
            'nouveau_type_consultant' => 'required_if:consultant_mode,nouveau|nullable|in:Interne,Freelancer',
            'nouveau_specialite' => 'nullable|string|max:255',
            'nouveau_telephone' => 'nullable|string|max:50',
        ]);

        $consultantId = null;

        if ($validated['role'] !== 'super_admin') {
            if ($validated['consultant_mode'] === 'existing') {
                $consultantId = $validated['consultant_id'];

                if (User::where('consultant_id', $consultantId)->exists()) {
                    return back()->with('error', 'Ce consultant a déjà un compte utilisateur.');
                }
            } else {
                $consultant = Consultant::create([
                    'nom_complet' => $user->name,
                    'type_consultant' => $validated['nouveau_type_consultant'],
                    'specialite' => $validated['nouveau_specialite'] ?? null,
                    'email' => $user->email,
                    'telephone' => $validated['nouveau_telephone'] ?? null,
                    'actif' => true,
                ]);
                $consultantId = $consultant->id;
            }
        }

        $user->update([
            'role' => $validated['role'],
            'permissions' => $validated['permissions'] ?? [],
            'consultant_id' => $consultantId,
            'statut_compte' => 'approuve',
        ]);

        AccesAuditLog::create([
            'user_id' => $user->id,
            'action' => 'approuve',
            'performed_by' => auth()->id(),
            'details' => 'Rôle attribué : ' . $validated['role'],
        ]);

        Mail::to($user->email)->send(new CompteApprouveMail($user));

        if ($consultantId) {
            $tachesEnAttente = Tache::where('consultant_id', $consultantId)
                ->where('statut', 'Assignée')
                ->get();

            foreach ($tachesEnAttente as $tache) {
                $user->notify(new TacheAssigneeNotification($tache));
            }
        }

        return back()->with('success', "Compte de {$user->name} approuvé.");
    }

    /**
     * Refuse une demande d'inscription en attente.
     */
    public function refuser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user->estEnAttente()) {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $validated = $request->validate([
            'motif_refus' => 'nullable|string|max:1000',
        ]);

        $user->update([
            'statut_compte' => 'refuse',
            'motif_refus' => $validated['motif_refus'] ?? null,
        ]);

        AccesAuditLog::create([
            'user_id' => $user->id,
            'action' => 'refuse',
            'performed_by' => auth()->id(),
            'details' => $validated['motif_refus'] ?? null,
        ]);

        Mail::to($user->email)->send(new CompteRefuseMail($user));

        return back()->with('success', "Demande de {$user->name} refusée.");
    }

    /**
     * Met à jour les accès directs de cet utilisateur à des projets
     * (indépendant du staffing via affectations, non touché ici).
     */
    public function mettreAJourAccesProjets(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'projets' => 'nullable|array',
            'projets.*' => 'exists:projets,id',
        ]);

        $resultat = $user->projetsAccesDirect()->sync($validated['projets'] ?? []);

        foreach (Projet::whereIn('id', $resultat['attached'])->get() as $projet) {
            ProjetAccessNotifier::notifierAjout(
                projet: $projet,
                assignePar: auth()->user(),
                userDirect: $user
            );
        }

        foreach (Projet::whereIn('id', $resultat['detached'])->get() as $projet) {
            ProjetAccessNotifier::notifierRetrait(
                projet: $projet,
                retirePar: auth()->user(),
                userDirect: $user
            );
        }

        return back()->with('success', "Accès aux projets mis à jour pour {$user->name}.");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($user->role === 'super_admin' && User::where('role', 'super_admin')->count() <= 1) {
            return back()->with('error', 'Impossible de supprimer le seul Super Admin.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "Compte de {$name} supprimé.");
    }
}

