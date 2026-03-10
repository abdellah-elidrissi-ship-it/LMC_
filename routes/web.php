<?php
use App\Http\Controllers\Api\ProjetController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\NouveauProjetController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\GanttController;
use Illuminate\Support\Facades\Route;

// ── AUTH ──
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── PROTÉGÉES ──
Route::middleware(['auth'])->group(function () {

    // Tout le monde — liste projets (filtrée selon role)
    Route::get('/', [ProjetController::class, 'index'])->name('projets.index');
    Route::get('/tableau-de-bord', fn() => view('tableau-de-bord'))->name('tableau-de-bord');

    // Voir détails — permission: voir_details
    Route::get('/projet/{id}', [EditController::class, 'show'])
        ->name('projet.details')
        ->middleware('permission:voir_details');

    // Gantt — visible à tous (auth), upload/ajout = modifier_projets
    Route::get('/projet/{id}/gantt', [GanttController::class, 'show'])->name('gantt.show');
    Route::middleware(['permission:modifier_projets'])->group(function () {
        Route::post('/projet/{id}/gantt/upload', [GanttController::class, 'upload'])->name('gantt.upload');
        Route::post('/projet/{id}/gantt/tache', [GanttController::class, 'storeTache'])->name('gantt.tache.store');
        Route::delete('/projet/{id}/gantt/tache/{tacheId}', [GanttController::class, 'destroyTache'])->name('gantt.tache.destroy');
    });

    // Créer — permission: creer_projets
    Route::get('/nouveau-projet', [NouveauProjetController::class, 'create'])
        ->name('projet.create')
        ->middleware('permission:creer_projets');
    Route::post('/projets', [NouveauProjetController::class, 'store'])
        ->name('projets.store')
        ->middleware('permission:creer_projets');

    // Modifier — permission: modifier_projets
    Route::get('/projet/{id}/edit', [EditController::class, 'edit'])
        ->name('projet.edit')
        ->middleware('permission:modifier_projets');
    Route::put('/projets/{id}', [EditController::class, 'update'])
        ->name('projets.update')
        ->middleware('permission:modifier_projets');

    // Supprimer — permission: supprimer_projets
    Route::delete('/projets/{id}', [EditController::class, 'destroy'])
        ->name('projets.destroy')
        ->middleware('permission:supprimer_projets');

    // Consultants — permission: voir_consultants
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

    // Admin users — super_admin uniquement
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });
});
