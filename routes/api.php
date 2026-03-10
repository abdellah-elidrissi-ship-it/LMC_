<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ConsultantController;
use App\Http\Controllers\Api\NormeController;
use App\Http\Controllers\Api\ProjetController;
use App\Http\Controllers\Api\ProjetNormeController;
use App\Http\Controllers\Api\ChapitreSmiController;
use App\Http\Controllers\Api\SuiviChapitreController;
use App\Http\Controllers\Api\FormationController;
use App\Http\Controllers\Api\ProjetFormationController;
use App\Http\Controllers\Api\AffectationController;


Route::apiResource('clients', ClientController::class);
Route::apiResource('consultants', ConsultantController::class);
Route::apiResource('normes', NormeController::class);
Route::apiResource('projets', ProjetController::class);
Route::apiResource('chapitres', ChapitreSmiController::class);
Route::apiResource('suivis-chapitres', SuiviChapitreController::class);
Route::apiResource('formations', FormationController::class);
Route::apiResource('projet-formations', ProjetFormationController::class);
Route::apiResource('affectations', AffectationController::class);
