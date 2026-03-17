<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Planning Gantt · {{ $projet->reference_projet ?? '' }} | LMC Conseil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* ===== DESIGN SYSTEM ===== */
        :root {
            --primary-50: #eef2ff;
            --primary-100: #e0e7ff;
            --primary-200: #c7d2fe;
            --primary-300: #a5b4fc;
            --primary-400: #818cf8;
            --primary-500: #6366f1;
            --primary-600: #4f46e5;
            --primary-700: #4338ca;
            --primary-800: #3730a3;
            --primary-900: #312e81;
            
            --success-50: #f0fdf4;
            --success-500: #22c55e;
            --success-600: #16a34a;
            --warning-50: #fffbeb;
            --warning-500: #f59e0b;
            --warning-600: #d97706;
            --danger-50: #fef2f2;
            --danger-500: #ef4444;
            --danger-600: #dc2626;
            --info-50: #eff6ff;
            --info-500: #3b82f6;
            
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-full: 9999px;
        }

        [data-theme="dark"] {
            --primary-50: #1e1b4b;
            --primary-100: #2e2a5e;
            --primary-200: #3d3a71;
            --primary-300: #4d4a84;
            --primary-400: #5c5a97;
            --primary-500: #6366f1;
            --primary-600: #818cf8;
            --primary-700: #a5b4fc;
            --primary-800: #c7d2fe;
            --primary-900: #e0e7ff;
            
            --gray-50: #111827;
            --gray-100: #1f2937;
            --gray-200: #374151;
            --gray-300: #4b5563;
            --gray-400: #6b7280;
            --gray-500: #9ca3af;
            --gray-600: #d1d5db;
            --gray-700: #e5e7eb;
            --gray-800: #f3f4f6;
            --gray-900: #f9fafb;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            transition: background-color 0.2s, color 0.2s;
            font-size: 13px;
            line-height: 1.5;
        }

        /* ===== HEADER ===== */
        .site-header {
            background: var(--gray-900);
            padding: 1rem 2rem;
            border-bottom: 3px solid var(--primary-500);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-container {
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-mark {
            width: 36px;
            height: 36px;
            background: var(--primary-500);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }

        .logo-text {
            font-weight: 700;
            color: white;
            font-size: 1.1rem;
            letter-spacing: -0.02em;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            border: 1px solid var(--gray-700);
            background: var(--gray-800);
            color: var(--gray-300);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-icon:hover {
            background: var(--primary-500);
            color: white;
            border-color: var(--primary-500);
        }

        .btn-back {
            background: var(--gray-800);
            border: 1px solid var(--gray-700);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: var(--radius-full);
            font-weight: 500;
            font-size: 0.75rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: var(--primary-500);
            border-color: var(--primary-500);
        }

        /* ===== PAGE ===== */
        .page {
            max-width: 1600px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
        }

        /* ===== INFO PANEL ===== */
        .info-panel {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-xl);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .info-section {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            padding: 0.25rem 0;
            border-bottom: 1px dashed var(--gray-200);
        }

        .info-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .info-value {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .info-value.highlight {
            color: var(--primary-600);
            font-size: 0.9rem;
        }

        .info-value.warning {
            color: var(--danger-600);
        }

        .info-value.success {
            color: var(--success-600);
        }

        .info-value i {
            font-size: 0.7rem;
            margin-right: 0.25rem;
        }

        .progress-mini {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
        }

        .progress-mini-bar {
            flex: 1;
            height: 6px;
            background: var(--gray-200);
            border-radius: var(--radius-full);
            overflow: hidden;
        }

        .progress-mini-fill {
            height: 100%;
            background: var(--primary-500);
            border-radius: var(--radius-full);
        }

        /* ===== TOOLBAR ===== */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .legend {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 0.5rem 1rem;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-full);
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.7rem;
            color: var(--gray-600);
        }

        .legend-color {
            width: 16px;
            height: 6px;
            border-radius: var(--radius-full);
        }

        .legend-color.baseline { background: var(--gray-300); }
        .legend-color.progress { background: var(--primary-500); }
        .legend-color.completed { background: var(--success-500); }
        .legend-color.late { background: var(--danger-500); }
        .legend-line {
            width: 2px;
            height: 12px;
            background: var(--primary-500);
        }

        .btn-primary {
            background: var(--primary-500);
            color: white;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.5rem 1.25rem;
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: var(--primary-600);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* ===== GANTT CONTAINER ===== */
        .gantt-container {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .gantt-wrapper {
            display: flex;
            overflow: hidden;
            max-height: calc(100vh - 320px);
            overflow-y: auto;
        }

        /* ===== LEFT PANEL ===== */
        .left-panel {
            flex-shrink: 0;
            width: 650px;
            border-right: 2px solid var(--gray-200);
            overflow: hidden;
        }

        .left-header {
            display: grid;
            grid-template-columns: 45px 200px 70px 80px 80px 80px 95px;
            background: var(--gray-100);
            border-bottom: 2px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header-cell {
            padding: 0.75rem 0.5rem;
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-right: 1px solid var(--gray-200);
            text-align: center;
        }

        .header-cell:last-child { border-right: none; }

        .task-row {
            display: grid;
            grid-template-columns: 45px 200px 70px 80px 80px 80px 95px;
            border-bottom: 1px solid var(--gray-200);
            min-height: 44px;
            align-items: center;
            cursor: pointer;
            transition: all 0.15s;
            background: white;
        }

        .task-row:nth-child(even) { background: var(--gray-50); }
        .task-row:hover { background: var(--primary-50); }
        .task-row.selected { background: var(--primary-50); border-left: 3px solid var(--primary-500); }

        .task-cell {
            padding: 0.5rem;
            font-size: 0.75rem;
            border-right: 1px solid var(--gray-200);
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .task-cell:last-child { border-right: none; }
        .task-cell.center { text-align: center; }
        .task-cell.num {
            font-weight: 600;
            color: var(--gray-400);
            text-align: center;
        }

        .task-cell.resp {
            font-size: 0.7rem;
            color: var(--gray-500);
            text-align: center;
        }

        .ct-prev { text-align: center; font-weight: 600; color: var(--gray-700); }
        .ct-real { text-align: center; font-weight: 600; }
        .ct-real.over { color: var(--danger-500); }
        .ct-real.ok { color: var(--success-500); }

        .progress-container {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .progress-value {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--gray-700);
            text-align: center;
        }

        .progress-bar {
            width: 100%;
            height: 4px;
            background: var(--gray-200);
            border-radius: var(--radius-full);
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: var(--radius-full);
            transition: width 0.3s ease;
        }

        .progress-fill.low { background: var(--gray-400); }
        .progress-fill.medium { background: var(--primary-500); }
        .progress-fill.high { background: var(--success-500); }

        /* ===== RIGHT PANEL ===== */
        .right-panel {
            flex: 1;
            overflow-x: auto;
            overflow-y: hidden;
        }

        .timeline {
            min-width: fit-content;
            position: relative;
        }

        .timeline-header {
            position: sticky;
            top: 0;
            z-index: 20;
            background: var(--gray-800);
        }

        .months-row {
            display: flex;
            border-bottom: 1px solid var(--gray-700);
        }

        .month-cell {
            font-size: 0.65rem;
            font-weight: 600;
            color: white;
            padding: 0.6rem 0;
            border-right: 1px solid var(--gray-700);
            text-align: center;
            flex-shrink: 0;
        }

        .days-row {
            display: flex;
            background: var(--gray-800);
        }

        .day-cell {
            font-size: 0.55rem;
            color: var(--gray-300);
            text-align: center;
            padding: 0.2rem 0;
            border-right: 1px solid var(--gray-700);
            flex-shrink: 0;
            line-height: 1.2;
        }

        .day-cell.weekend { background: var(--gray-900); color: var(--gray-400); }
        .day-cell.today {
            background: var(--primary-500);
            color: white;
            font-weight: 600;
        }

        .timeline-rows { position: relative; }
        .timeline-row {
            position: relative;
            border-bottom: 1px solid var(--gray-200);
            min-height: 44px;
            display: flex;
            align-items: center;
        }

        .timeline-row:nth-child(even) { background: var(--gray-50); }
        .timeline-row:hover { background: var(--primary-50); }

        .day-column {
            position: absolute;
            top: 0;
            bottom: 0;
            border-right: 1px solid var(--gray-200);
            pointer-events: none;
        }

        .day-column.weekend { background: var(--gray-100); }
        .day-column.today {
            background: var(--primary-50);
            border-right: 2px solid var(--primary-500);
        }

        .gantt-bar {
            position: absolute;
            height: 22px;
            top: 50%;
            transform: translateY(-50%);
            border-radius: var(--radius-full);
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .gantt-bar:hover {
            filter: brightness(1.1);
            transform: translateY(-50%) scaleY(1.1);
            z-index: 5;
        }

        .bar-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gray-300);
            opacity: 0.3;
        }

        .bar-progress {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            border-radius: var(--radius-full);
            min-width: 4px;
            transition: width 0.3s ease;
        }

        .bar-progress.baseline { background: var(--gray-400); }
        .bar-progress.in-progress { background: var(--primary-500); }
        .bar-progress.completed { background: var(--success-500); }
        .bar-progress.late { background: var(--danger-500); }

        .today-line {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary-500);
            z-index: 10;
            pointer-events: none;
            box-shadow: 0 0 6px var(--primary-500);
        }

        .today-marker {
            position: absolute;
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary-500);
            border: 2px solid white;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active { display: flex; }

        .modal {
            background: white;
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            width: 500px;
            max-width: 95vw;
            box-shadow: var(--shadow-lg);
        }

        .modal h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal p {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-bottom: 1.25rem;
        }

        .form-group { margin-bottom: 1rem; }
        .form-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            display: block;
            margin-bottom: 0.3rem;
        }

        .form-control {
            width: 100%;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            padding: 0.6rem 0.8rem;
            font-size: 0.8rem;
            color: var(--gray-900);
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px var(--primary-100);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .btn-light {
            background: white;
            color: var(--gray-600);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-full);
            padding: 0.5rem 1.25rem;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .btn-light:hover { background: var(--gray-100); }

        .btn-danger {
            background: var(--danger-500);
            color: white;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.5rem 1.25rem;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .btn-danger:hover { background: var(--danger-600); }

        .edit-panel {
            display: none;
            background: var(--primary-50);
            border-bottom: 2px solid var(--primary-500);
            padding: 1rem;
        }

        .edit-panel.open { display: block; }
        .edit-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary-600);
            margin-bottom: 0.75rem;
        }

        .edit-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .edit-full { grid-column: 1 / -1; }
        .edit-label {
            font-size: 0.6rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            display: block;
            margin-bottom: 0.2rem;
        }

        .edit-input {
            width: 100%;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            padding: 0.4rem;
            font-size: 0.7rem;
        }

        .edit-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            padding-top: 0.75rem;
            border-top: 1px solid var(--gray-300);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-400);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

@php
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

$projetId = $projet->id;

// Données du projet
$client = DB::table('clients')->where('id', $projet->client_id)->first();
$chefProjet = DB::table('consultants')->where('id', $projet->chef_projet_id)->first();

// Tâches Gantt
$taches = DB::table('gantt_taches')
    ->where('projet_id', $projetId)
    ->orderBy('numero')
    ->get();

// Affectations pour les charges
$affectations = DB::table('affectations')
    ->where('projet_id', $projetId)
    ->get();

// Suivi des chapitres pour avancement global
$suiviChapitres = DB::table('suivi_chapitres')
    ->where('projet_id', $projetId)
    ->get();

// ===== DATES =====
$dateDebut = $projet->date_debut ? Carbon::parse($projet->date_debut) : null;
$dateFinPrevue = $projet->date_fin_prevue ? Carbon::parse($projet->date_fin_prevue) : null;
$aujourdhui = Carbon::today();

// ===== CALCULS PRINCIPAUX =====

// 1. Délai en jours (fin - début)
$delaiTotal = 0;
if ($dateDebut && $dateFinPrevue) {
    $delaiTotal = $dateDebut->diffInDays($dateFinPrevue) + 1; // +1 pour inclure les deux dates
}

// 2. % Écoulement Délai (basé sur les dates du projet)
$delaiEcoule = $dateDebut ? $dateDebut->diffInDays($aujourdhui) : 0;
$pourcentageDelai = $delaiTotal > 0 ? round(($delaiEcoule / $delaiTotal) * 100, 2) : 0;

// 3. Jours prévus (projet)
$joursPrevus = $projet->jours_prevus;

// 4. Jours réalisés (somme des jours d'intervention des affectations)
$joursRealises = $affectations->sum('jours_realises');

// 5. Avancement global (moyenne des chapitres)
$avancementGlobal = $suiviChapitres->avg('avancement_percent') ?: 0;
$avancementGlobalFormatted = number_format($avancementGlobal, 2);

// 6. Écart (réalisés - prévus)
$ecartJours = $joursRealises - $joursPrevus;

// 7. Consommation
$consoPourcentage = $joursPrevus > 0 ? round(($joursRealises / $joursPrevus) * 100) : 0;

// 8. Budget en jours (somme des CT prévues des tâches)
$budgetPrevus = $taches->sum('ct_prevue');
$budgetRealise = $taches->sum('ct_realisee');
$budgetEcart = $budgetRealise - $budgetPrevus;

// 9. Charge totale (affectations)
$chargeAllouee = $affectations->sum('jours_alloues');
$chargeRealisee = $affectations->sum('jours_realises');

// 10. Formatage
$budgetPrevusFormatted = number_format($budgetPrevus, 1, ',', ' ');
$budgetRealiseFormatted = number_format($budgetRealise, 1, ',', ' ');
$budgetEcartFormatted = number_format($budgetEcart, 1, ',', ' ');
$chargeAlloueeFormatted = number_format($chargeAllouee, 1, ',', ' ');
$chargeRealiseeFormatted = number_format($chargeRealisee, 1, ',', ' ');

// 11. Total tâches
$totalTaches = $taches->count();

// ===== CALCUL DE L'ÉCHELLE GANTT =====
$tachesAvecDate = $taches->filter(fn($t) => $t->date_debut);

if ($tachesAvecDate->isEmpty()) {
    $tlStart = Carbon::now()->startOfMonth()->subDays(7);
    $tlEnd = Carbon::now()->addMonths(3)->endOfMonth()->addDays(7);
} else {
    $minDebut = Carbon::parse($tachesAvecDate->min('date_debut'));
    $finDates = $taches->map(function($t) {
        if ($t->date_fin_calculee) return Carbon::parse($t->date_fin_calculee);
        if ($t->date_fin_initiale) return Carbon::parse($t->date_fin_initiale);
        if ($t->date_debut) return Carbon::parse($t->date_debut)->addDays(max($t->delai_jours - 1, 0));
        return null;
    })->filter()->sort();
    $maxFin = $finDates->last() ?? $minDebut->copy()->addMonths(3);
    $tlStart = $minDebut->copy()->subDays(7);
    $tlEnd = $maxFin->copy()->addDays(14);
}

// Génération des jours
$jours = [];
$cur = $tlStart->copy();
while ($cur->lte($tlEnd)) {
    $jours[] = $cur->copy();
    $cur->addDay();
}

$jourWidth = 22;
$totalJours = count($jours);
$timelineWidth = $totalJours * $jourWidth;

// Mois
$moisGroups = [];
foreach ($jours as $j) {
    $key = $j->format('Y-m');
    if (!isset($moisGroups[$key])) {
        $moisGroups[$key] = [
            'label' => $j->locale('fr')->isoFormat('MMM YYYY'),
            'count' => 0
        ];
    }
    $moisGroups[$key]['count']++;
}

// Position aujourd'hui
$todayPosition = max(0, $tlStart->diffInDays($aujourdhui)) * $jourWidth + ($jourWidth / 2);

function calculateBar($tache, $tlStart, $jourWidth) {
    if (!$tache->date_debut) return null;
    $start = Carbon::parse($tache->date_debut);
    if ($tache->date_fin_calculee) {
        $end = Carbon::parse($tache->date_fin_calculee);
    } elseif ($tache->date_fin_initiale) {
        $end = Carbon::parse($tache->date_fin_initiale);
    } else {
        $end = $start->copy()->addDays(max((int)$tache->delai_jours - 1, 0));
    }
    $duree = max($start->diffInDays($end) + 1, 1);
    $left = $tlStart->diffInDays($start) * $jourWidth;
    $width = max($duree * $jourWidth, $jourWidth);
    return ['left' => $left, 'width' => $width];
}
@endphp

<!-- Header -->
<div class="site-header">
    <div class="header-container">
        <div class="logo-wrapper">
            <div class="logo-mark">LMC</div>
            <span class="logo-text">lmc conseil</span>
        </div>
        <div class="header-actions">
            <button class="btn-icon" id="themeToggle">
                <i class="bi bi-moon-fill" id="themeIcon"></i>
            </button>
            <a href="/projet/{{ $projet->id }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Retour au projet
            </a>
        </div>
    </div>
</div>

<!-- Page -->
<div class="page">

    @if(session('success'))
    <div class="alert alert-success">...</div>
    @endif

    <!-- INFO PANEL - TOUS LES INDICATEURS -->
    <div class="info-panel">
        <!-- Colonne 1 : Dates et délais -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Date :</span>
                <span class="info-value">{{ $aujourdhui->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Délai en jours :</span>
                <span class="info-value highlight">{{ $delaiTotal }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Début du projet :</span>
                <span class="info-value">{{ $dateDebut ? $dateDebut->locale('fr')->isoFormat('ddd, j/M/YYYY') : '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fin du projet :</span>
                <span class="info-value">{{ $dateFinPrevue ? $dateFinPrevue->format('d/m/Y') : '—' }}</span>
            </div>
        </div>

        <!-- Colonne 2 : Écoulement et Avancement -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Prévue</span>
                <span class="info-value"></span>
            </div>
            <div class="info-row">
                <span class="info-label">% Écoulement Délai :</span>
                <span class="info-value {{ $pourcentageDelai > 100 ? 'warning' : ($pourcentageDelai > 80 ? 'warning' : 'success') }}">
                    <i class="bi {{ $pourcentageDelai > 100 ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill' }}"></i>
                    {{ number_format($pourcentageDelai, 2) }}%
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Réalisé</span>
                <span class="info-value"></span>
            </div>
            <div class="info-row">
                <span class="info-label">% Avancement :</span>
                <span class="info-value highlight">
                    <i class="bi bi-graph-up-arrow"></i>
                    {{ $avancementGlobalFormatted }}%
                </span>
            </div>
        </div>

        <!-- Colonne 3 : Budget et Charges -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Projet :</span>
                <span class="info-value highlight">{{ $projet->reference_projet }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">CP :</span>
                <span class="info-value">{{ $chefProjet->nom_complet ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Budget en j :</span>
                <span class="info-value">{{ $budgetPrevusFormatted }}</span>
                <span class="info-value">{{ $budgetRealiseFormatted }}</span>
                <span class="info-value {{ $budgetEcart < 0 ? 'success' : 'warning' }}">
                    {{ $budgetEcart > 0 ? '+' : '' }}{{ $budgetEcartFormatted }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Charge en j :</span>
                <span class="info-value">{{ $chargeAlloueeFormatted }}</span>
                <span class="info-value">{{ $chargeRealiseeFormatted }}</span>
                <span class="info-value {{ ($chargeRealisee - $chargeAllouee) < 0 ? 'success' : 'warning' }}">
                    {{ ($chargeRealisee - $chargeAllouee) > 0 ? '+' : '' }}{{ number_format($chargeRealisee - $chargeAllouee, 1, ',', ' ') }}
                </span>
            </div>
        </div>

        <!-- Colonne 4 : Consommation -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Jours Prévus :</span>
                <span class="info-value">{{ $joursPrevus }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jours Réalisés :</span>
                <span class="info-value">{{ $joursRealises }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Consommation :</span>
                <span class="info-value {{ $consoPourcentage > 100 ? 'warning' : 'success' }}">
                    {{ $consoPourcentage }}%
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Écart :</span>
                <span class="info-value {{ $ecartJours < 0 ? 'success' : 'warning' }}">
                    {{ $ecartJours > 0 ? '+' : '' }}{{ $ecartJours }}
                </span>
            </div>
            <div class="info-row">
                <div class="progress-mini">
                    <span class="info-value small">{{ $joursPrevus }}</span>
                    <div class="progress-mini-bar">
                        <div class="progress-mini-fill" style="width: {{ min($consoPourcentage, 100) }}%;"></div>
                    </div>
                    <span class="info-value small">{{ $joursRealises }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="legend">
            <div class="legend-item"><div class="legend-color baseline"></div><span>Prévu</span></div>
            <div class="legend-item"><div class="legend-color progress"></div><span>En cours</span></div>
            <div class="legend-item"><div class="legend-color completed"></div><span>Terminé</span></div>
            <div class="legend-item"><div class="legend-color late"></div><span>Retard</span></div>
            <div class="legend-item"><div class="legend-line"></div><span>Aujourd'hui</span></div>
        </div>
        @if(auth()->user()->hasPermission('modifier_projets'))
        <button class="btn-primary" onclick="openModal('addTaskModal')">
            <i class="bi bi-plus-lg"></i> Nouvelle tâche
        </button>
        @endif
    </div>

    <!-- Gantt -->
    @if($taches->isEmpty())
    <div class="gantt-container">
        <div class="empty-state">
            <i class="bi bi-bar-chart-steps"></i>
            <p>Aucune tâche planifiée</p>
        </div>
    </div>
    @else
    <div class="gantt-container">
        <div class="gantt-wrapper">

            <!-- Left Panel -->
            <div class="left-panel">
                <div class="left-header">
                    <div class="header-cell">#</div>
                    <div class="header-cell">Désignation</div>
                    <div class="header-cell">Unité</div>
                    <div class="header-cell">Responsable</div>
                    <div class="header-cell">CT Prév.</div>
                    <div class="header-cell">CT Réal.</div>
                    <div class="header-cell">Avancement</div>
                </div>

                @foreach($taches as $tache)
                @php
                    $avancement = round($tache->avancement * 100);
                    $ecart = $tache->ct_realisee - $tache->ct_prevue;
                    $isOver = $ecart > 0 && $tache->ct_prevue > 0;
                    $progressClass = $avancement == 0 ? 'low' : ($avancement >= 100 ? 'high' : 'medium');
                @endphp

                <div class="task-row" id="row-{{ $tache->id }}" onclick="toggleTaskEdit({{ $tache->id }})">
                    <div class="task-cell num">{{ $tache->numero }}</div>
                    <div class="task-cell">{{ Str::limit($tache->designation, 25) }}</div>
                    <div class="task-cell center">{{ $tache->unite }}</div>
                    <div class="task-cell resp">{{ Str::limit($tache->responsable ?? '—', 12) }}</div>
                    <div class="task-cell ct-prev">{{ $tache->ct_prevue > 0 ? number_format($tache->ct_prevue, 1) : '-' }}</div>
                    <div class="task-cell ct-real {{ $isOver ? 'over' : ($tache->ct_realisee > 0 ? 'ok' : '') }}">
                        {{ $tache->ct_realisee > 0 ? number_format($tache->ct_realisee, 1) : '-' }}
                    </div>
                    <div class="task-cell progress-container">
                        <span class="progress-value">{{ $avancement }}%</span>
                        <div class="progress-bar">
                            <div class="progress-fill {{ $progressClass }}" style="width: {{ $avancement }}%;"></div>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->hasPermission('modifier_projets'))
                <div class="edit-panel" id="ep-{{ $tache->id }}">
                    <div class="edit-title">Modifier tâche #{{ $tache->numero }}</div>
                    <form method="POST" action="/projet/{{ $projet->id }}/gantt/tache/{{ $tache->id }}/update">
                        @csrf @method('PUT')
                        <div class="edit-full">
                            <label class="edit-label">Désignation</label>
                            <input type="text" name="designation" class="edit-input" value="{{ $tache->designation }}" required>
                        </div>
                        <div class="edit-grid">
                            <div><label class="edit-label">CT Prév.</label><input type="number" name="ct_prevue" class="edit-input" value="{{ $tache->ct_prevue }}" step="0.5"></div>
                            <div><label class="edit-label">CT Réal.</label><input type="number" name="ct_realisee" class="edit-input" value="{{ $tache->ct_realisee }}" step="0.5"></div>
                            <div><label class="edit-label">Avancement</label><input type="number" name="avancement" class="edit-input" value="{{ $avancement }}" min="0" max="100"></div>
                            <div><label class="edit-label">Délai</label><input type="number" name="delai_jours" class="edit-input" value="{{ $tache->delai_jours }}" min="1"></div>
                        </div>
                        <div class="edit-grid">
                            <div><label class="edit-label">Responsable</label><input type="text" name="responsable" class="edit-input" value="{{ $tache->responsable }}"></div>
                            <div><label class="edit-label">Début</label><input type="date" name="date_debut" class="edit-input" value="{{ $tache->date_debut }}"></div>
                            <div><label class="edit-label">Unité</label>
                                <select name="unite" class="edit-input">
                                    <option value="H/J" {{ $tache->unite=='H/J'?'selected':'' }}>H/J</option>
                                    <option value="H" {{ $tache->unite=='H'?'selected':'' }}>H</option>
                                    <option value="J" {{ $tache->unite=='J'?'selected':'' }}>J</option>
                                </select>
                            </div>
                        </div>
                        <div class="edit-actions">
                            <button type="button" class="btn-light" onclick="closeEdit({{ $tache->id }})">Annuler</button>
                            <button type="button" class="btn-danger" onclick="confirmDelete({{ $tache->id }})">Supprimer</button>
                            <button type="submit" class="btn-primary">Enregistrer</button>
                        </div>
                    </form>
                    <form id="delete-form-{{ $tache->id }}" method="POST" action="/projet/{{ $projet->id }}/gantt/tache/{{ $tache->id }}" style="display:none;">@csrf @method('DELETE')</form>
                </div>
                @endif
                @endforeach
            </div>

            <!-- Right Panel -->
            <div class="right-panel" id="rightPanel">
                <div class="timeline" style="width: {{ $timelineWidth }}px;">
                    <div class="timeline-header">
                        <div class="months-row">
                            @foreach($moisGroups as $mois)
                            <div class="month-cell" style="width: {{ $mois['count'] * $jourWidth }}px;">
                                {{ strtoupper($mois['label']) }}
                            </div>
                            @endforeach
                        </div>
                        <div class="days-row">
                            @foreach($jours as $j)
                            <div class="day-cell {{ $j->isWeekend() ? 'weekend' : ($j->isSameDay($aujourdhui) ? 'today' : '') }}" style="width: {{ $jourWidth }}px;">
                                {{ $j->format('d') }}<br><span style="font-size:0.5rem;">{{ strtoupper($j->locale('fr')->isoFormat('dd')) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="timeline-rows">
                        <div class="today-line" style="left: {{ $todayPosition }}px;"><div class="today-marker"></div></div>
                        @foreach($taches as $tache)
                        @php
                            $bar = calculateBar($tache, $tlStart, $jourWidth);
                            $avancement = round($tache->avancement * 100);
                            $ecart = $tache->ct_realisee - $tache->ct_prevue;
                            $isOver = $ecart > 0 && $tache->ct_prevue > 0;
                            $barClass = $avancement == 0 ? 'baseline' : ($avancement >= 100 ? 'completed' : ($isOver ? 'late' : 'in-progress'));
                            $progressWidth = $bar ? round($bar['width'] * min($tache->avancement, 1)) : 0;
                        @endphp

                        <div class="timeline-row" style="width: {{ $timelineWidth }}px;">
                            @foreach($jours as $idx => $j)
                            <div class="day-column {{ $j->isWeekend() ? 'weekend' : ($j->isSameDay($aujourdhui) ? 'today' : '') }}" style="left: {{ $idx * $jourWidth }}px; width: {{ $jourWidth }}px;"></div>
                            @endforeach
                            @if($bar)
                            <div class="gantt-bar" style="left: {{ $bar['left'] }}px; width: {{ $bar['width'] }}px;" onclick="toggleTaskEdit({{ $tache->id }})" title="{{ $tache->designation }} ({{ $avancement }}%)">
                                <div class="bar-bg"></div>
                                @if($avancement > 0)
                                <div class="bar-progress {{ $barClass }}" style="width: {{ $progressWidth }}px;"></div>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Add Task Modal -->
<div class="modal-overlay" id="addTaskModal">
    <div class="modal">
        <h3><i class="bi bi-plus-circle-fill" style="color: var(--primary-500);"></i> Nouvelle tâche</h3>
        <p>Ajouter une tâche au planning</p>
        <form method="POST" action="/projet/{{ $projet->id }}/gantt/tache">
            @csrf
            <div class="form-group">
                <label class="form-label">Désignation</label>
                <input type="text" name="designation" class="form-control" required>
            </div>
            <div class="form-row">
                <div><label class="form-label">CT Prévue</label><input type="number" name="ct_prevue" class="form-control" step="0.5" value="0"></div>
                <div><label class="form-label">CT Réalisée</label><input type="number" name="ct_realisee" class="form-control" step="0.5" value="0"></div>
                <div><label class="form-label">Avancement %</label><input type="number" name="avancement" class="form-control" min="0" max="100" value="0"></div>
            </div>
            <div class="form-row">
                <div><label class="form-label">Responsable</label><input type="text" name="responsable" class="form-control"></div>
                <div><label class="form-label">Date début</label><input type="date" name="date_debut" class="form-control"></div>
                <div><label class="form-label">Délai (j)</label><input type="number" name="delai_jours" class="form-control" min="1" value="1"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Unité</label>
                <select name="unite" class="form-control">
                    <option value="H/J">H/J</option>
                    <option value="H">Heures</option>
                    <option value="J">Jours</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-light" onclick="closeModal('addTaskModal')">Annuler</button>
                <button type="submit" class="btn-primary">Créer</button>
            </div>
        </form>
    </div>
</div>

<script>
// Theme toggle
(function() {
    const saved = localStorage.getItem('lmc-theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = saved === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
})();

document.getElementById('themeToggle').addEventListener('click', () => {
    const next = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('lmc-theme', next);
    const icon = document.getElementById('themeIcon');
    icon.className = next === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
});

// Modal
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }

document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('active'); });
});

// Task editing
let currentEditId = null;

function toggleTaskEdit(id) {
    if (currentEditId !== null && currentEditId !== id) closeEdit(currentEditId);
    const ep = document.getElementById('ep-' + id);
    const row = document.getElementById('row-' + id);
    if (!ep) return;
    if (ep.classList.contains('open')) { closeEdit(id); }
    else {
        ep.classList.add('open');
        row.classList.add('selected');
        currentEditId = id;
    }
}

function closeEdit(id) {
    const ep = document.getElementById('ep-' + id);
    const row = document.getElementById('row-' + id);
    if (ep) ep.classList.remove('open');
    if (row) row.classList.remove('selected');
    if (currentEditId === id) currentEditId = null;
}

function confirmDelete(id) {
    if (confirm('Supprimer cette tâche ?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Initial scroll
window.addEventListener('load', () => {
    const rightPanel = document.getElementById('rightPanel');
    if (rightPanel) {
        const todayPosition = {{ $todayPosition }};
        rightPanel.scrollLeft = Math.max(0, todayPosition - rightPanel.offsetWidth / 3);
    }
});
</script>
</body>
</html>