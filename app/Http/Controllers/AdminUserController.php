<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Consultant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users       = User::with('consultant')->get();
        $consultants = Consultant::orderBy('nom_complet')->get();

        $consultants = $consultants->map(function ($c) {
            $c->user_id = User::where('consultant_id', $c->id)->value('id');
            return $c;
        });

        return view('admin-users', compact('users', 'consultants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'consultant_id' => 'required|exists:consultants,id',
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => ['required', 'min:8'],
            'role'          => 'required|in:super_admin,chef_projet,consultant',
        ], [
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $existing = User::where('consultant_id', $request->consultant_id)->first();
        if ($existing) {
            return back()->with('error', 'Ce consultant a déjà un compte utilisateur.');
        }

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => $request->role,
            'consultant_id' => $request->consultant_id,
            'permissions'   => $request->input('permissions', []),
        ]);

        return back()->with('success', "Compte créé pour {$request->name}.");
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => 'required|in:super_admin,chef_projet,consultant',
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