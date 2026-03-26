<?php

use App\Http\Controllers\Api\ProjetController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\NouveauProjetController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\GanttController;
use App\Http\Controllers\LivrablesController;
use App\Http\Controllers\PreuveController;
use Illuminate\Support\Facades\Route;

// ── AUTH ──
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── PROTÉGÉES ──
Route::middleware(['auth'])->group(function () {

    Route::get('/', [ProjetController::class, 'index'])->name('projets.index');
    Route::get('/tableau-de-bord', fn() => view('tableau-de-bord'))->name('tableau-de-bord');

    // Détails
    Route::get('/projet/{id}', [EditController::class, 'show'])
        ->name('projet.details')
        ->middleware('permission:voir_details');

    // ── GANTT ──
    Route::get('/projet/{id}/gantt', [GanttController::class, 'show'])->name('gantt.show');

    Route::middleware(['permission:modifier_projets'])->group(function () {
        Route::post('/projet/{id}/gantt/tache',                     [GanttController::class, 'storeTache'])->name('gantt.tache.store');
        Route::put('/projet/{id}/gantt/tache/{tacheId}/update',     [GanttController::class, 'updateTache'])->name('gantt.tache.update'); // ← NOUVEAU
        Route::delete('/projet/{id}/gantt/tache/{tacheId}',         [GanttController::class, 'destroyTache'])->name('gantt.tache.destroy');
        Route::post('/projet/{id}/gantt/upload', [GanttController::class, 'upload'])->name('gantt.upload');
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

    // Admin
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/admin/users',         [AdminUserController::class, 'index'])->name('admin.users');
        Route::post('/admin/users',        [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{id}',    [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
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

    if (!$url) {
        abort(404);
    }

    return response()->streamDownload(function () use ($url) {
        echo file_get_contents($url);
    }, $name);
})->middleware('auth')->name('file.download');


Route::get('/view-file', function (\Illuminate\Http\Request $request) {
    $url = $request->query('url');

    if (!$url) {
        abort(404);
    }

    $content = file_get_contents($url);

    return response($content, 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="document.pdf"');
})->middleware('auth')->name('file.view');



