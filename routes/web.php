<?php

use App\Http\Controllers\Admin\CalendrierAdminController;
use App\Http\Controllers\Api\ProjetController;
use App\Http\Controllers\CalendrierController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\NouveauProjetController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\GanttController;
use App\Http\Controllers\LivrablesController;
use App\Http\Controllers\PreuveController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// ── AUTH ──
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');

// ── PROTÉGÉES ──
Route::middleware(['auth', 'approuve'])->group(function () {

    Route::get('/', [ProjetController::class, 'index'])->name('projets.index');
    Route::get('/tableau-de-bord', function () {
        if (!auth()->user()->hasPermission('voir_tableau_bord')) {
            abort(403, 'Accès non autorisé au Tableau de Bord');
        }
        return view('tableau-de-bord');
    })->name('tableau-de-bord');

    // Détails
    Route::get('/projet/{id}', [EditController::class, 'show'])
        ->name('projet.details')
        ->middleware('permission:voir_details');

    // ── GANTT ──
    Route::get('/projet/{id}/gantt', [GanttController::class, 'show'])->name('gantt.show');

    Route::middleware(['permission:modifier_projets'])->group(function () {
        Route::post('/projet/{id}/gantt/phase',                     [GanttController::class, 'storePhase'])->name('gantt.phase.store');
        Route::put('/projet/{id}/gantt/phase/{phaseId}',            [GanttController::class, 'updatePhase'])->name('gantt.phase.update');
        Route::delete('/projet/{id}/gantt/phase/{phaseId}',         [GanttController::class, 'destroyPhase'])->name('gantt.phase.destroy');

        Route::post('/projet/{id}/gantt/tache',                     [GanttController::class, 'storeTache'])->name('gantt.tache.store');
        Route::put('/projet/{id}/gantt/tache/{tacheId}/update',     [GanttController::class, 'updateTache'])->name('gantt.tache.update');
        Route::delete('/projet/{id}/gantt/tache/{tacheId}',         [GanttController::class, 'destroyTache'])->name('gantt.tache.destroy');
    });

    // Créer
    Route::get('/nouveau-projet', [NouveauProjetController::class, 'create'])
        ->name('projet.create')
        ->middleware('permission:creer_projets');
    Route::post('/projets', [NouveauProjetController::class, 'store'])
        ->name('projets.store')
        ->middleware('permission:creer_projets');

    // Modifier
    Route::get('/projet/{id}/edit', [EditController::class, 'edit'])
        ->name('projet.edit')
        ->middleware('permission:modifier_projets');
    Route::put('/projets/{id}', [EditController::class, 'update'])
        ->name('projets.update')
        ->middleware('permission:modifier_projets');

    // Supprimer
    Route::delete('/projets/{id}', [EditController::class, 'destroy'])
        ->name('projets.destroy')
        ->middleware('permission:supprimer_projets');

    // Consultants
    Route::get('/consultants', [ConsultantController::class, 'index'])
        ->name('consultants.index')
        ->middleware('permission:voir_consultants');
    Route::post('/consultants', [ConsultantController::class, 'store'])
        ->name('consultants.store')
        ->middleware('permission:voir_consultants');
    Route::put('/consultants/{id}', [ConsultantController::class, 'update'])
        ->name('consultants.update')
        ->middleware('permission:voir_consultants');
    Route::delete('/consultants/{id}', [ConsultantController::class, 'destroy'])
        ->name('consultants.destroy')
        ->middleware('permission:voir_consultants');

    // Calendrier — "Mon calendrier" (consultant connecté)
    Route::get('/calendrier', [CalendrierController::class, 'index'])->name('calendrier.index');
    Route::get('/calendrier/events', [CalendrierController::class, 'events'])->name('calendrier.events');
    Route::post('/calendrier/taches/{id}/lire', [CalendrierController::class, 'marquerLue'])->name('calendrier.tache.lire');
    Route::post('/calendrier/taches/{id}/repondre', [CalendrierController::class, 'repondre'])->name('calendrier.tache.repondre');
    Route::post('/notifications/lire-tout', [CalendrierController::class, 'marquerNotificationsLues'])->name('notifications.lire-tout');

    // Admin — gestion des comptes utilisateurs (super admin uniquement)
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/admin/users',         [AdminUserController::class, 'index'])->name('admin.users');
        Route::put('/admin/users/{id}',    [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
        Route::put('/admin/users/{id}/approuver', [AdminUserController::class, 'approuver'])->name('admin.users.approuver');
        Route::put('/admin/users/{id}/refuser',   [AdminUserController::class, 'refuser'])->name('admin.users.refuser');
        Route::put('/admin/users/{id}/projets',   [AdminUserController::class, 'mettreAJourAccesProjets'])->name('admin.users.projets.update');
    });

    // Admin — calendrier / assignation de tâches (super admin + chef de projet)
    Route::middleware(['role:super_admin,chef_projet'])->group(function () {
        Route::get('/admin/calendrier',                    [CalendrierAdminController::class, 'index'])->name('admin.calendrier.index');
        Route::get('/admin/calendrier/{consultantId}',      [CalendrierAdminController::class, 'show'])->name('admin.calendrier.show');
        Route::get('/admin/calendrier/{consultantId}/events', [CalendrierAdminController::class, 'events'])->name('admin.calendrier.events');
        Route::post('/admin/calendrier/{consultantId}/taches', [CalendrierAdminController::class, 'store'])->name('admin.calendrier.tache.store');
        Route::put('/admin/calendrier/taches/{id}',         [CalendrierAdminController::class, 'update'])->name('admin.calendrier.tache.update');
        Route::patch('/admin/calendrier/taches/{id}/deplacer', [CalendrierAdminController::class, 'deplacer'])->name('admin.calendrier.tache.deplacer');
        Route::delete('/admin/calendrier/taches/{id}',      [CalendrierAdminController::class, 'destroy'])->name('admin.calendrier.tache.destroy');
        Route::delete('/admin/calendrier/{consultantId}/vider', [CalendrierAdminController::class, 'viderCalendrier'])->name('admin.calendrier.vider');
    });
});

Route::post('/projet/{id}/livrables', [LivrablesController::class, 'save'])
    ->name('projet.livrables.save')
    ->middleware('permission:modifier_projets');

// Sauvegarde AJAX d'un seul livrable (depuis details — dropdown change)
Route::post('/projet/{id}/livrables/single', [LivrablesController::class, 'saveSingle'])
    ->name('projet.livrables.single')
    ->middleware('permission:modifier_projets');


// Routes pour les preuves des livrables

Route::post('/preuves/upload', [App\Http\Controllers\PreuveController::class, 'upload'])->name('preuves.upload');
Route::delete('/preuves/{id}', [App\Http\Controllers\PreuveController::class, 'destroy'])->name('preuves.destroy');

// Routes pour les preuves projet

Route::post('/preuves-projet/upload', [App\Http\Controllers\ProjetPreuveController::class, 'upload'])->name('preuves-projet.upload');
Route::delete('/preuves-projet/{id}', [App\Http\Controllers\ProjetPreuveController::class, 'destroy'])->name('preuves-projet.destroy');
Route::get('/preuves-projet/{projetId}', [App\Http\Controllers\ProjetPreuveController::class, 'index'])->name('preuves-projet.index');


Route::get('/test-cloudinary', function() {
    try {
        $cloudName = config('cloudinary.cloud_name');
        $apiKey = config('cloudinary.api_key');
        
        return response()->json([
            'success' => true,
            'message' => 'Cloudinary configuré',
            'cloud_name' => $cloudName,
            'api_key' => substr($apiKey, 0, 5) . '...'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur Cloudinary: ' . $e->getMessage()
        ], 500);
    }
});

Route::get('/download-file', function (\Illuminate\Http\Request $request) {
    $url = $request->query('url');
    $name = $request->query('name', 'document');

    if (!$url || parse_url($url, PHP_URL_HOST) !== 'res.cloudinary.com') {
        abort(403);
    }

    return response()->streamDownload(function () use ($url) {
        echo file_get_contents($url);
    }, $name);
})->middleware('auth')->name('file.download');


Route::get('/view-file', function (\Illuminate\Http\Request $request) {
    $url = $request->query('url');

    if (!$url || parse_url($url, PHP_URL_HOST) !== 'res.cloudinary.com') {
        abort(403);
    }

    $content = file_get_contents($url);

    return response($content, 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="document.pdf"');
})->middleware('auth')->name('file.view');



