<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gantt — {{ $projet->nom_client ?? '' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Inter',sans-serif; background:#f0f2f5; color:#1a1a2e; font-size:13px; }

/* ── NAV ── */
.topbar {
    background:#1e3a5f; color:#fff; padding:0 24px;
    display:flex; align-items:stretch; gap:0;
    border-bottom:3px solid #2563eb;
}
.topbar-brand { display:flex; align-items:center; gap:10px; padding:12px 20px 12px 0; border-right:1px solid rgba(255,255,255,.1); margin-right:8px; }
.topbar-brand .logo-text { font-size:16px; font-weight:700; }
.topbar-brand .logo-sub  { font-size:10px; color:#94a3b8; }
.nav-link { display:flex; align-items:center; gap:6px; padding:0 16px; color:rgba(255,255,255,.65); text-decoration:none; font-size:12px; font-weight:500; border-bottom:3px solid transparent; margin-bottom:-3px; transition:all .18s; height:100%; }
.nav-link:hover  { color:#fff; background:rgba(255,255,255,.06); }
.nav-link.active { color:#60a5fa; border-bottom-color:#60a5fa; }
.topbar-right { margin-left:auto; display:flex; align-items:center; gap:8px; }
.topbar-btn { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); color:#cbd5e1; padding:6px 12px; border-radius:6px; font-size:11px; font-weight:500; cursor:pointer; text-decoration:none; display:flex; align-items:center; gap:5px; transition:all .15s; }
.topbar-btn:hover { background:rgba(255,255,255,.18); color:#fff; }

/* ── PAGE ── */
.page { padding:20px 24px; max-width:1800px; margin:0 auto; }

/* ── PROJECT HEADER ── */
.proj-header {
    background:#fff; border:1px solid #d1d9e6; border-radius:10px;
    padding:14px 20px; margin-bottom:16px;
    display:flex; align-items:center; justify-content:space-between;
    box-shadow:0 1px 4px rgba(0,0,0,.06);
}
.proj-title { font-size:16px; font-weight:700; color:#1e3a5f; }
.proj-meta  { font-size:11px; color:#64748b; margin-top:3px; }
.proj-badges { display:flex; gap:8px; align-items:center; }
.badge { padding:3px 10px; border-radius:12px; font-size:11px; font-weight:600; }
.badge-blue  { background:#dbeafe; color:#1d4ed8; }
.badge-green { background:#dcfce7; color:#15803d; }
.badge-gray  { background:#f1f5f9; color:#475569; }

/* ── ALERT ── */
.alert { padding:10px 16px; border-radius:8px; font-size:12px; font-weight:500; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
.alert-ok  { background:#dcfce7; border:1px solid #86efac; color:#166534; }
.alert-err { background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; }

/* ── TOOLBAR ── */
.toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
.toolbar-left { display:flex; align-items:center; gap:10px; }
.btn { border:none; border-radius:6px; cursor:pointer; font-family:'Inter',sans-serif; font-size:12px; font-weight:500; display:inline-flex; align-items:center; gap:5px; padding:7px 14px; transition:all .15s; }
.btn-primary { background:#2563eb; color:#fff; }
.btn-primary:hover { background:#1d4ed8; }
.btn-success { background:#16a34a; color:#fff; }
.btn-success:hover { background:#15803d; }
.btn-danger  { background:#dc2626; color:#fff; }
.btn-danger:hover  { background:#b91c1c; }
.btn-light   { background:#fff; color:#374151; border:1px solid #d1d5db; }
.btn-light:hover { background:#f9fafb; }
.btn-sm { padding:5px 10px; font-size:11px; }

/* ── GANTT CONTAINER ── */
.gantt-container {
    background:#fff;
    border:1px solid #cbd5e1;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 1px 6px rgba(0,0,0,.07);
}

/* ── GANTT LAYOUT : gauche fixe + droite scroll ── */
.gantt-body {
    display:flex;
    overflow:hidden;
}

/* PANNEAU GAUCHE */
.g-left {
    flex-shrink:0;
    width:560px;
    border-right:2px solid #1e3a5f;
    overflow:hidden;
}

/* HEADER GAUCHE */
.g-left-head {
    display:grid;
    grid-template-columns: 38px 160px 60px 60px 80px 80px 80px;
    background:#1e3a5f;
    color:#fff;
    border-bottom:1px solid #2d4f7c;
}
.gh {
    padding:8px 6px;
    font-size:10px;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:.4px;
    border-right:1px solid #2d4f7c;
    white-space:nowrap;
    overflow:hidden;
    text-align:center;
}
.gh:last-child { border-right:none; }
.gh.left { text-align:left; }

/* LIGNE TÂCHE GAUCHE */
.g-row {
    display:grid;
    grid-template-columns: 38px 160px 60px 60px 80px 80px 80px;
    border-bottom:1px solid #e2e8f0;
    min-height:38px;
    align-items:center;
    cursor:pointer;
    transition:background .12s;
}
.g-row:nth-child(even) { background:#fafbfd; }
.g-row:hover { background:#eff6ff; }
.g-row.editing { background:#eff6ff; border-left:3px solid #2563eb; }

.gc { padding:5px 6px; font-size:12px; border-right:1px solid #e2e8f0; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; }
.gc:last-child { border-right:none; }
.gc.center { text-align:center; }
.gc.num { color:#64748b; font-weight:700; text-align:center; font-size:11px; }
.gc.name { text-align:left; font-weight:500; }
.gc.resp { font-size:10px; color:#64748b; }
.gc.ct   { text-align:center; font-weight:600; }
.gc.over { color:#dc2626; }
.gc.ok   { color:#16a34a; }
.gc.ecart-pos { color:#dc2626; font-weight:700; }
.gc.ecart-neg { color:#16a34a; font-weight:700; }
.gc.ecart-eq  { color:#64748b; }

/* Barre avancement dans cellule */
.av-cell { text-align:center; }
.av-pct  { font-size:11px; font-weight:700; color:#1e3a5f; }
.av-bar  { width:100%; height:6px; background:#e2e8f0; border-radius:2px; overflow:hidden; margin-top:3px; }
.av-fill { height:100%; border-radius:2px; }
.av-fill.c0   { background:#cbd5e1; }
.av-fill.c50  { background:#3b82f6; }
.av-fill.c100 { background:#16a34a; }

/* EDIT PANEL */
.edit-panel {
    display:none;
    background:#f0f6ff;
    border-bottom:2px solid #93c5fd;
    border-top:1px solid #bfdbfe;
    padding:12px 14px;
}
.edit-panel.open { display:block; }
.ep-title { font-size:11px; font-weight:700; color:#1d4ed8; margin-bottom:10px; display:flex; align-items:center; gap:5px; }
.ep-grid  { display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:8px; }
.ep-grid3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px; margin-bottom:8px; }
.ep-grid4 { display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:8px; margin-bottom:8px; }
.ep-full  { grid-column:1/-1; }
.ep-lbl   { font-size:10px; font-weight:600; color:#475569; text-transform:uppercase; letter-spacing:.4px; display:block; margin-bottom:3px; }
.ep-inp   { width:100%; background:#fff; border:1px solid #cbd5e1; border-radius:5px; padding:5px 8px; font-size:12px; color:#1a1a2e; font-family:'Inter',sans-serif; }
.ep-inp:focus { outline:none; border-color:#2563eb; }
.ep-actions { display:flex; gap:6px; justify-content:flex-end; padding-top:10px; border-top:1px solid #bfdbfe; margin-top:8px; }

/* PANNEAU DROIT — TIMELINE */
.g-right {
    flex:1;
    overflow-x:auto;
    overflow-y:hidden;
}

/* HEADER TIMELINE */
.tl-head {
    position:sticky;
    top:0;
    z-index:10;
    background:#1e3a5f;
    border-bottom:1px solid #2d4f7c;
}
.tl-months {
    display:flex;
    border-bottom:1px solid #2d4f7c;
}
.tl-month {
    font-size:10px;
    font-weight:700;
    color:#93c5fd;
    padding:5px 8px;
    border-right:1px solid #2d4f7c;
    text-transform:uppercase;
    letter-spacing:.5px;
    white-space:nowrap;
    flex-shrink:0;
}
.tl-days {
    display:flex;
}
.tl-day {
    font-size:9px;
    color:rgba(255,255,255,.55);
    text-align:center;
    padding:3px 0;
    border-right:1px solid rgba(255,255,255,.08);
    flex-shrink:0;
    line-height:1.2;
}
.tl-day.weekend { background:rgba(0,0,0,.15); }
.tl-day.today-d { background:#1d4ed8; color:#fff; font-weight:700; }

/* TIMELINE ROWS */
.tl-rows { position:relative; }
.tl-row  {
    position:relative;
    border-bottom:1px solid #e2e8f0;
    min-height:38px;
    display:flex;
    align-items:center;
}
.tl-row:nth-child(even) { background:#fafbfd; }
.tl-row:hover { background:#eff6ff; }

/* fond colonnes jours */
.day-col {
    position:absolute; top:0; bottom:0;
    border-right:1px solid rgba(203,213,225,.4);
    flex-shrink:0;
}
.day-col.weekend { background:rgba(241,245,249,.7); }
.day-col.today-col { background:rgba(37,99,235,.08); border-right:2px solid #2563eb; }

/* BARRE GANTT */
.bar-wrap {
    position:absolute;
    height:22px;
    top:50%;
    transform:translateY(-50%);
    border-radius:2px;
    overflow:hidden;
}
/* Fond = durée totale prévue */
.bar-bg {
    position:absolute; top:0; left:0; right:0; bottom:0;
    background:#94a3b8;
    opacity:.35;
    border-radius:2px;
}
/* Fill = avancement */
.bar-fill {
    position:absolute; top:0; left:0; bottom:0;
    border-radius:2px;
    min-width:3px;
}
.bar-fill.nd   { background:#94a3b8; opacity:.5; }
.bar-fill.prog { background:#3b82f6; }
.bar-fill.done { background:#22c55e; }
.bar-fill.late { background:#ef4444; }

/* Ligne today */
.today-line {
    position:absolute; top:0; bottom:0; width:2px;
    background:#2563eb; opacity:.9; z-index:6; pointer-events:none;
}
.today-pip {
    position:absolute; top:0; left:50%; transform:translateX(-50%);
    width:8px; height:8px; border-radius:50%; background:#2563eb;
}

/* SPACER timeline (aligner avec edit panel) */
.tl-spacer { border-bottom:1px solid #e2e8f0; }

/* ── MODAL ── */
.modal-bg { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:100; align-items:center; justify-content:center; }
.modal-bg.open { display:flex; }
.modal { background:#fff; border-radius:12px; padding:24px; width:480px; max-width:95vw; box-shadow:0 20px 60px rgba(0,0,0,.3); max-height:90vh; overflow-y:auto; }
.modal h3 { font-size:15px; font-weight:700; color:#1e3a5f; margin-bottom:4px; }
.modal p  { font-size:12px; color:#64748b; margin-bottom:18px; }
.fg { margin-bottom:12px; }
.fl { font-size:11px; font-weight:600; color:#475569; text-transform:uppercase; letter-spacing:.4px; display:block; margin-bottom:4px; }
.fc { width:100%; background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; padding:7px 10px; font-size:12px; color:#1a1a2e; font-family:'Inter',sans-serif; }
.fc:focus { outline:none; border-color:#2563eb; }
.row2 { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.row3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; }
.modal-actions { display:flex; justify-content:flex-end; gap:8px; margin-top:16px; padding-top:14px; border-top:1px solid #e2e8f0; }

.empty-state { text-align:center; padding:60px 20px; color:#94a3b8; }
.empty-state i { font-size:48px; opacity:.3; display:block; margin-bottom:12px; }

/* Légende */
.legend { display:flex; align-items:center; gap:14px; font-size:11px; color:#64748b; }
.leg { display:flex; align-items:center; gap:5px; }
.leg-b { width:20px; height:10px; border-radius:2px; }
</style>
</head>
<body>

@php
use Carbon\Carbon;

// ── Calculs timeline ──────────────────────────────────────────────────
$tachesAvecDate = collect($taches)->filter(fn($t) => $t->date_debut);

if ($tachesAvecDate->isEmpty()) {
    // Pas de dates → afficher mois en cours + 3 mois
    $tlStart = Carbon::now()->startOfMonth()->subDays(3);
    $tlEnd   = Carbon::now()->addMonths(3)->endOfMonth()->addDays(3);
} else {
    $minDebut = Carbon::parse($tachesAvecDate->min('date_debut'));

    // Calculer la fin max : date_fin_calculee ou date_debut + delai_jours
    $finDates = collect($taches)->map(function($t) {
        if ($t->date_fin_calculee) return Carbon::parse($t->date_fin_calculee);
        if ($t->date_fin_initiale) return Carbon::parse($t->date_fin_initiale);
        if ($t->date_debut) return Carbon::parse($t->date_debut)->addDays(max($t->delai_jours - 1, 0));
        return null;
    })->filter()->sort();

    $maxFin = $finDates->last() ?? $minDebut->copy()->addMonths(3);

    // Ajouter marges
    $tlStart = $minDebut->copy()->subDays(7);
    $tlEnd   = $maxFin->copy()->addDays(14);
}

// Générer tous les jours
$jours = [];
$cur   = $tlStart->copy();
while ($cur->lte($tlEnd)) {
    $jours[] = $cur->copy();
    $cur->addDay();
}

$totalJours = count($jours);
$jourW = 20; // px par jour
$tlW   = $totalJours * $jourW;
$today = Carbon::today();

// Grouper jours par mois pour le header
$moisGroups = [];
foreach ($jours as $j) {
    $key = $j->format('Y-m');
    if (!isset($moisGroups[$key])) {
        $moisGroups[$key] = ['label' => $j->locale('fr')->isoFormat('MMM YYYY'), 'count' => 0];
    }
    $moisGroups[$key]['count']++;
}

// Position du jour "aujourd'hui"
$todayPx = $tlStart->diffInDays($today) * $jourW;

// Fonction position barre
function ganttBar($dateDebut, $dateFin, $delai, $tlStart, $jourW) {
    if (!$dateDebut) return null;
    $start = Carbon::parse($dateDebut);
    if ($dateFin) {
        $end = Carbon::parse($dateFin);
    } else {
        $end = $start->copy()->addDays(max((int)$delai - 1, 0));
    }
    $durée = max($start->diffInDays($end) + 1, 1);
    $left  = $tlStart->diffInDays($start) * $jourW;
    $width = max($durée * $jourW, $jourW); // min 1 jour
    return ['left' => $left, 'width' => $width];
}
@endphp

<!-- TOPBAR -->
<div class="topbar">
    <div class="topbar-brand">
        <div>
            <div class="logo-text">LMC Conseil</div>
            <div class="logo-sub">Planning Gantt</div>
        </div>
    </div>
    <a href="/" class="nav-link"><i class="bi bi-grid-fill"></i> Projets</a>
    <a href="/tableau-de-bord" class="nav-link"><i class="bi bi-bar-chart-fill"></i> Tableau de bord</a>
    <a href="/projet/{{ $projet->id }}" class="nav-link"><i class="bi bi-folder-fill"></i> Détails</a>
    <a href="/projet/{{ $projet->id }}/gantt" class="nav-link active"><i class="bi bi-bar-chart-steps"></i> Gantt</a>
    @if(auth()->user()->hasPermission('modifier_projets'))
    <a href="/projet/{{ $projet->id }}/edit" class="nav-link"><i class="bi bi-pencil-fill"></i> Modifier</a>
    @endif
    <div class="topbar-right">
        <a href="/projet/{{ $projet->id }}" class="topbar-btn"><i class="bi bi-arrow-left"></i> Retour</a>
    </div>
</div>

<div class="page">

    @if(session('success'))
    <div class="alert alert-ok"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-err"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    @endif

    <!-- EN-TÊTE PROJET -->
    <div class="proj-header">
        <div>
            <div class="proj-title">
                <i class="bi bi-bar-chart-steps" style="color:#2563eb;margin-right:6px;"></i>
                {{ $projet->reference_projet ?? '' }} — {{ $projet->nom_client ?? '' }}
            </div>
            <div class="proj-meta">
                Chef de projet : <strong>{{ $projet->chef_nom ?? '—' }}</strong>
                &nbsp;·&nbsp; {{ count($taches) }} tâche(s)
                @php
                    $totalPrevus   = collect($taches)->sum('ct_prevue');
                    $totalRealises = collect($taches)->sum('ct_realisee');
                    $avgAv = count($taches) > 0 ? round(collect($taches)->avg('avancement') * 100) : 0;
                @endphp
                &nbsp;·&nbsp; CT Prévue : <strong>{{ $totalPrevus }} j</strong>
                &nbsp;·&nbsp; CT Réalisée : <strong>{{ $totalRealises }} j</strong>
                &nbsp;·&nbsp; Avancement moyen : <strong>{{ $avgAv }}%</strong>
            </div>
        </div>
        <div class="proj-badges">
            <span class="badge badge-blue">{{ $projet->statut ?? 'En cours' }}</span>
        </div>
    </div>

    <!-- TOOLBAR -->
    <div class="toolbar">
        <div class="toolbar-left">
            <div class="legend">
                <div class="leg"><div class="leg-b" style="background:#94a3b8;opacity:.35;border:1px solid #cbd5e1;"></div><span>Durée prévue</span></div>
                <div class="leg"><div class="leg-b" style="background:#3b82f6;"></div><span>En cours</span></div>
                <div class="leg"><div class="leg-b" style="background:#22c55e;"></div><span>Terminé</span></div>
                <div class="leg"><div class="leg-b" style="background:#ef4444;"></div><span>Retard CT</span></div>
                <div class="leg"><div style="width:2px;height:14px;background:#2563eb;"></div><span>Aujourd'hui</span></div>
            </div>
        </div>
        @if(auth()->user()->hasPermission('modifier_projets'))
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('modalAdd').classList.add('open')">
            <i class="bi bi-plus-lg"></i> Ajouter une tâche
        </button>
        @endif
    </div>

    <!-- GANTT -->
    @if(count($taches) === 0)
    <div class="gantt-container">
        <div class="empty-state">
            <i class="bi bi-bar-chart-steps"></i>
            <p style="font-size:14px;font-weight:600;color:#475569;margin-bottom:6px;">Aucune tâche planifiée</p>
            <p style="font-size:12px;color:#94a3b8;">Ajoutez des tâches manuellement ci-dessus</p>
        </div>
    </div>
    @else
    <div class="gantt-container">
        <div class="gantt-body">

            <!-- ── PANNEAU GAUCHE ── -->
            <div class="g-left" id="gLeft">
                <!-- Header -->
                <div class="g-left-head">
                    <div class="gh center">#</div>
                    <div class="gh left">Désignation</div>
                    <div class="gh center">U</div>
                    <div class="gh center">Resp.</div>
                    <div class="gh center">CT Prév.</div>
                    <div class="gh center">CT Réal.</div>
                    <div class="gh center">Avancement</div>
                </div>

                <!-- Lignes tâches -->
                @foreach($taches as $t)
                @php
                    $avPct  = round($t->avancement * 100);
                    $ecart  = $t->ct_realisee - $t->ct_prevue;
                    $isOver = $ecart > 0 && $t->ct_prevue > 0;
                    if ($avPct == 0)       $avClass = 'c0';
                    elseif ($avPct >= 100) $avClass = 'c100';
                    else                   $avClass = 'c50';
                @endphp

                <div class="g-row" id="row-{{ $t->id }}" onclick="toggleEdit({{ $t->id }})">
                    <div class="gc num">{{ $t->numero }}</div>
                    <div class="gc name" title="{{ $t->designation }}">{{ Str::limit($t->designation, 22) }}</div>
                    <div class="gc center" style="font-size:10px;color:#64748b;">{{ $t->unite }}</div>
                    <div class="gc resp center" title="{{ $t->responsable }}">{{ Str::limit($t->responsable ?? '—', 14) }}</div>
                    <div class="gc ct center">{{ $t->ct_prevue > 0 ? $t->ct_prevue : '—' }}</div>
                    <div class="gc ct center {{ $isOver ? 'over' : ($t->ct_realisee > 0 ? 'ok' : '') }}">
                        {{ $t->ct_realisee > 0 ? $t->ct_realisee : '—' }}
                    </div>
                    <div class="gc av-cell">
                        <div class="av-pct">{{ $avPct }}%</div>
                        <div class="av-bar"><div class="av-fill {{ $avClass }}" style="width:{{ $avPct }}%;"></div></div>
                    </div>
                </div>

                <!-- EDIT PANEL -->
                @if(auth()->user()->hasPermission('modifier_projets'))
                <div class="edit-panel" id="ep-{{ $t->id }}">
                    <div class="ep-title"><i class="bi bi-pencil-fill"></i> Modifier la tâche #{{ $t->numero }}</div>
                    <form method="POST" action="/projet/{{ $projet->id }}/gantt/tache/{{ $t->id }}/update">
                        @csrf @method('PUT')
                        <div class="ep-grid">
                            <div class="ep-full">
                                <label class="ep-lbl">Désignation</label>
                                <input type="text" name="designation" class="ep-inp" value="{{ $t->designation }}" required>
                            </div>
                        </div>
                        <div class="ep-grid4">
                            <div><label class="ep-lbl">CT Prévue (j)</label><input type="number" name="ct_prevue" class="ep-inp" value="{{ $t->ct_prevue }}" step="0.5" min="0"></div>
                            <div><label class="ep-lbl">CT Réalisée (j)</label><input type="number" name="ct_realisee" class="ep-inp" value="{{ $t->ct_realisee }}" step="0.5" min="0"></div>
                            <div><label class="ep-lbl">Avancement (%)</label><input type="number" name="avancement" class="ep-inp" value="{{ $avPct }}" min="0" max="100"></div>
                            <div><label class="ep-lbl">Délai (jours)</label><input type="number" name="delai_jours" class="ep-inp" value="{{ $t->delai_jours }}" min="1"></div>
                        </div>
                        <div class="ep-grid3">
                            <div><label class="ep-lbl">Responsable</label><input type="text" name="responsable" class="ep-inp" value="{{ $t->responsable }}"></div>
                            <div><label class="ep-lbl">Date début</label><input type="date" name="date_debut" class="ep-inp" value="{{ $t->date_debut }}"></div>
                            <div><label class="ep-lbl">Unité</label>
                                <select name="unite" class="ep-inp">
                                    <option value="H/J" {{ $t->unite=='H/J'?'selected':'' }}>H/J</option>
                                    <option value="H"   {{ $t->unite=='H'  ?'selected':'' }}>H</option>
                                    <option value="J"   {{ $t->unite=='J'  ?'selected':'' }}>J</option>
                                </select>
                            </div>
                        </div>
                        <div class="ep-actions">
                            <button type="button" class="btn btn-light btn-sm" onclick="closeEdit({{ $t->id }})">
                                <i class="bi bi-x"></i> Annuler
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="supprimerTache({{ $t->id }})">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-check-lg"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                    <!-- Form DELETE séparé -->
                    <form id="del-{{ $t->id }}" method="POST" action="/projet/{{ $projet->id }}/gantt/tache/{{ $t->id }}" style="display:none;">
                        @csrf @method('DELETE')
                    </form>
                </div>
                @endif

                @endforeach
            </div>

            <!-- ── PANNEAU DROIT : TIMELINE ── -->
            <div class="g-right" id="gRight">

                <!-- Header jours -->
                <div class="tl-head">
                    <!-- Mois -->
                    <div class="tl-months">
                        @foreach($moisGroups as $m)
                        <div class="tl-month" style="width:{{ $m['count'] * $jourW }}px; min-width:{{ $m['count'] * $jourW }}px;">
                            {{ strtoupper($m['label']) }}
                        </div>
                        @endforeach
                    </div>
                    <!-- Jours -->
                    <div class="tl-days">
                        @foreach($jours as $j)
                        @php
                            $isWE  = $j->isWeekend();
                            $isTod = $j->isSameDay($today);
                            $cls   = $isTod ? 'today-d' : ($isWE ? 'weekend' : '');
                        @endphp
                        <div class="tl-day {{ $cls }}" style="width:{{ $jourW }}px; min-width:{{ $jourW }}px;">
                            {{ $j->format('d') }}<br>
                            <span style="font-size:7px;opacity:.7;">{{ strtoupper(substr($j->locale('fr')->isoFormat('dd'),0,1)) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Timeline rows -->
                <div class="tl-rows" style="position:relative; width:{{ $tlW }}px;">

                    <!-- Ligne aujourd'hui -->
                    <div class="today-line" style="left:{{ $todayPx + $jourW/2 }}px; top:0; bottom:0; position:absolute;">
                        <div class="today-pip"></div>
                    </div>

                    @foreach($taches as $t)
                    @php
                        $avPct   = round($t->avancement * 100);
                        $ecart   = $t->ct_realisee - $t->ct_prevue;
                        $isOver  = $ecart > 0 && $t->ct_prevue > 0;
                        $finDate = $t->date_fin_calculee ?? $t->date_fin_initiale;
                        $bar     = ganttBar($t->date_debut, $finDate, $t->delai_jours, $tlStart, $jourW);

                        // Couleur fill
                        if ($avPct == 0)       $fillCls = 'nd';
                        elseif ($avPct >= 100)  $fillCls = 'done';
                        elseif ($isOver)        $fillCls = 'late';
                        else                    $fillCls = 'prog';

                        $fillW = $bar ? max(round($bar['width'] * min($t->avancement, 1)), ($avPct > 0 ? 3 : 0)) : 0;
                    @endphp

                    <!-- Fond colonnes jours -->
                    <div class="tl-row" id="trow-{{ $t->id }}" style="width:{{ $tlW }}px; min-height:38px; position:relative;">
                        @foreach($jours as $ji => $j)
                        @php $isWE=$j->isWeekend(); $isTod=$j->isSameDay($today); @endphp
                        <div class="day-col {{ $isTod ? 'today-col' : ($isWE ? 'weekend' : '') }}"
                             style="left:{{ $ji * $jourW }}px; width:{{ $jourW }}px;"></div>
                        @endforeach

                        @if($bar)
                        <!-- Barre Gantt -->
                        <div class="bar-wrap" style="left:{{ $bar['left'] }}px; width:{{ $bar['width'] }}px;">
                            <div class="bar-bg"></div>
                            @if($avPct > 0)
                            <div class="bar-fill {{ $fillCls }}" style="width:{{ $fillW }}px;"></div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <!-- Spacer edit panel (aligner avec panneau gauche) -->
                    @if(auth()->user()->hasPermission('modifier_projets'))
                    <div id="sp-{{ $t->id }}" class="tl-spacer" style="display:none; width:{{ $tlW }}px;"></div>
                    @endif

                    @endforeach
                </div>
            </div>

        </div>{{-- fin gantt-body --}}
    </div>{{-- fin gantt-container --}}
    @endif

</div>{{-- fin page --}}

<!-- ── MODAL AJOUTER ── -->
<div class="modal-bg" id="modalAdd">
    <div class="modal">
        <h3><i class="bi bi-plus-circle-fill" style="color:#2563eb;margin-right:6px;"></i>Ajouter une tâche</h3>
        <p>Remplissez les informations de la nouvelle tâche</p>
        <form method="POST" action="/projet/{{ $projet->id }}/gantt/tache">
            @csrf
            <div class="fg"><label class="fl">Désignation *</label><input type="text" name="designation" class="fc" required placeholder="Ex: Réunion de lancement"></div>
            <div class="row3">
                <div class="fg"><label class="fl">CT Prévue (j)</label><input type="number" name="ct_prevue" class="fc" step="0.5" min="0" value="0"></div>
                <div class="fg"><label class="fl">CT Réalisée (j)</label><input type="number" name="ct_realisee" class="fc" step="0.5" min="0" value="0"></div>
                <div class="fg"><label class="fl">Avancement (%)</label><input type="number" name="avancement" class="fc" min="0" max="100" value="0"></div>
            </div>
            <div class="fg"><label class="fl">Responsable</label><input type="text" name="responsable" class="fc" placeholder="Ex: Client / LMC"></div>
            <div class="row3">
                <div class="fg"><label class="fl">Date début</label><input type="date" name="date_debut" class="fc"></div>
                <div class="fg"><label class="fl">Délai (jours)</label><input type="number" name="delai_jours" class="fc" min="1" value="1"></div>
                <div class="fg"><label class="fl">Unité</label>
                    <select name="unite" class="fc"><option value="H/J">H/J</option><option value="H">Heures</option><option value="J">Jours</option></select>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-light" onclick="document.getElementById('modalAdd').classList.remove('open')">Annuler</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Ajouter</button>
            </div>
        </form>
    </div>
</div>

<script>
// Fermer modal en cliquant à l'extérieur
document.querySelectorAll('.modal-bg').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});

// Toggle edit panel
let openId = null;

function toggleEdit(id) {
    if (openId !== null && openId !== id) closeEdit(openId);
    const ep = document.getElementById('ep-' + id);
    if (!ep) return;
    if (ep.classList.contains('open')) {
        closeEdit(id);
    } else {
        ep.classList.add('open');
        document.getElementById('row-' + id).classList.add('editing');
        openId = id;
        // Sync spacer hauteur
        requestAnimationFrame(() => {
            const sp = document.getElementById('sp-' + id);
            if (sp) { sp.style.display = 'block'; sp.style.height = ep.offsetHeight + 'px'; }
        });
    }
}

function closeEdit(id) {
    const ep  = document.getElementById('ep-' + id);
    const row = document.getElementById('row-' + id);
    const sp  = document.getElementById('sp-' + id);
    if (ep)  ep.classList.remove('open');
    if (row) row.classList.remove('editing');
    if (sp)  { sp.style.display = 'none'; sp.style.height = '0'; }
    if (openId === id) openId = null;
}

function supprimerTache(id) {
    if (!confirm('Supprimer cette tâche définitivement ?')) return;
    document.getElementById('del-' + id).submit();
}

// Scroll vers aujourd'hui au chargement
window.addEventListener('load', () => {
    const gr = document.getElementById('gRight');
    if (!gr) return;
    const todayPx = {{ $todayPx }};
    gr.scrollLeft = Math.max(0, todayPx - gr.offsetWidth / 3);
});
</script>
</body>
</html>