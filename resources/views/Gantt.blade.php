<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LMC Conseil</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --bg: #fafafa;
            --surface: #ffffff;
            --border: #e5e5e5;
            --border-strong: #d4d4d4;
            --text: #171717;
            --text-muted: #8a8a8a;
            --accent: #2563eb;
            --prevu: #94a3b8;
            --realise: #2563eb;
            --phase-bg: #eef2f9;
            --tache-bg: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); font-size: 13px; }

        .page { max-width: 1700px; margin: 0 auto; padding: 2rem; }

        .page-title {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            margin-bottom: 1rem;
        }

        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: center;
            font-size: 0.8rem;
            color: var(--text-muted);
            padding-bottom: 1rem;
            margin-bottom: 1.25rem;
            border-bottom: 1px solid var(--border);
        }
        .legend-swatch { display: inline-block; width: 14px; height: 10px; border-radius: 3px; margin-right: 0.4rem; vertical-align: middle; }

        .global-stats { display: flex; align-items: center; gap: 0.5rem; margin-left: auto; padding-left: 1.25rem; border-left: 1px solid var(--border); }
        .gstat-title { display: flex; align-items: center; gap: 0.35rem; font-size: 0.72rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.02em; margin-right: 0.25rem; }
        .gstat { display: flex; align-items: center; gap: 0.4rem; background: var(--bg); border: 1px solid var(--border); border-radius: 6px; padding: 0.3rem 0.6rem; }
        .gstat i { font-size: 0.75rem; color: var(--text-muted); }
        .gstat-label { font-size: 0.68rem; color: var(--text-muted); }
        .gstat-value { font-size: 0.82rem; font-weight: 700; color: var(--text); }
        .gstat-value.avancement-pill { padding: 0.1rem 0.45rem; border-radius: 999px; font-size: 0.72rem; }
        .gstat-value.avancement-pill.danger { background: rgba(220,38,38,.1); }
        .gstat-value.avancement-pill.warning { background: rgba(217,119,6,.1); }
        .gstat-value.avancement-pill.success { background: rgba(5,150,105,.1); }

        .toolbar { display: flex; gap: 0.5rem; }

        .btn {
            border: 1px solid transparent; border-radius: 6px; padding: 0.5rem 1rem; font-size: 0.8rem; font-weight: 500;
            cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; transition: background 0.15s;
        }
        .btn-accent { background: var(--text); color: white; }
        .btn-accent:hover { background: #000; }
        .btn-light { background: var(--surface); color: var(--text); border-color: var(--border-strong); }
        .btn-light:hover { background: var(--bg); }
        .btn-danger { background: transparent; color: #dc2626; border-color: var(--border-strong); }
        .btn-danger:hover { background: #fef2f2; }
        .btn-sm { padding: 0.3rem 0.7rem; font-size: 0.72rem; }

        /* ===== Modal ===== */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal { background: var(--surface); border-radius: 8px; padding: 1.75rem; width: 460px; max-width: 92vw; }
        .modal h3 { font-size: 1rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-label { font-size: 0.72rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.3rem; }
        .form-control { width: 100%; border: 1px solid var(--border-strong); border-radius: 6px; padding: 0.5rem 0.7rem; font-size: 0.85rem; font-family: 'Inter', sans-serif; }
        .form-control:focus { outline: none; border-color: var(--accent); }
        .modal-actions { display: flex; justify-content: flex-end; gap: 0.6rem; margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border); }

        /* ===== Table Gantt ===== */
        :root { --row-h: 42px; --header-h: 44px; }

        .gantt-container { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; margin-top: 1.5rem; }

        /* Bandeau d'en-tête FIXE — hors du flux scrollable, plus de position:sticky */
        .gantt-head { display: flex; background: var(--bg); border-bottom: 1px solid var(--border-strong); }
        .gantt-head-left { flex-shrink: 0; width: 760px; border-right: 1px solid var(--border); }
        .gantt-head-right { flex: 1; overflow: hidden; }

        .gantt-wrapper { display: flex; align-items: flex-start; max-height: calc(100vh - 300px); overflow-y: auto; }
        .left-panel { flex-shrink: 0; width: 760px; border-right: 1px solid var(--border); }
        .right-panel { flex: 1; overflow-x: auto; overflow-y: hidden; }

        .cols-grid { display: grid; grid-template-columns: 1fr 100px 100px 90px 110px 90px; }

        .table-header-row { height: var(--header-h); }
        .table-header-row .col { display: flex; align-items: center; justify-content: center; padding: 0 0.6rem; font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.02em; color: var(--text-muted); }
        .table-header-row .col:first-child { justify-content: flex-start; }

        .phase-row { height: var(--row-h); overflow: hidden; background: var(--phase-bg); border-bottom: 1px solid var(--border); border-top: 1px solid var(--border); border-left: 4px solid var(--phase-color, var(--border-strong)); align-items: center; }
        .phase-row .col.nom i { color: var(--phase-color, var(--text-muted)); }
        .tl-phase-row { border-left: 4px solid var(--phase-color, var(--border-strong)); }
        .phase-row .col { padding: 0.5rem 0.6rem; font-weight: 600; font-size: 0.82rem; text-align: center; overflow: hidden; }
        .phase-row .col.nom { text-align: left; display: flex; align-items: center; gap: 0.5rem; white-space: nowrap; text-overflow: ellipsis; }
        .phase-row .col.nom span.label { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; min-width: 0; }
        .phase-row .col.nom i { color: var(--text-muted); flex-shrink: 0; }
        .phase-row .count { font-weight: 400; font-size: 0.72rem; color: var(--text-muted); flex-shrink: 0; }
        .phase-actions { display: flex; gap: 0.2rem; justify-content: center; flex-shrink: 0; }
        .icon-btn { border: none; background: transparent; color: var(--text-muted); cursor: pointer; padding: 0.2rem 0.35rem; border-radius: 4px; font-size: 0.85rem; }
        .icon-btn:hover { background: var(--border); color: var(--text); }
        .icon-btn.danger:hover { background: #fef2f2; color: var(--danger, #dc2626); }

        .tache-row { height: var(--row-h); overflow: hidden; background: var(--tache-bg); border-bottom: 1px solid var(--border); align-items: center; cursor: pointer; transition: background 0.1s; }
        .tache-row:hover { background: var(--bg); }
        .tache-row.selected { background: #f0f5ff; }
        .tache-row .col { padding: 0.4rem 0.6rem; font-size: 0.8rem; text-align: center; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
        .tache-row .col.nom { text-align: left; padding-left: 1.5rem; }

        .ecart-pos { color: var(--text-muted); }
        .ecart-neg { color: #dc2626; font-weight: 600; }
        .ecart-zero { color: var(--text-muted); }

        .avancement-pill { font-weight: 600; }
        .avancement-pill.danger { color: #dc2626; }
        .avancement-pill.warning { color: #d97706; }
        .avancement-pill.success { color: #059669; }

        .edit-panel { display: none; background: var(--bg); border-bottom: 1px solid var(--border-strong); padding: 1rem 1.25rem; }
        .edit-panel.open { display: block; }
        .edit-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.6rem; margin-bottom: 0.6rem; }
        .edit-full { grid-column: 1 / -1; }
        .edit-label { font-size: 0.62rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 0.2rem; }
        .edit-input { width: 100%; border: 1px solid var(--border-strong); border-radius: 6px; padding: 0.45rem 0.6rem; font-size: 0.78rem; font-family: 'Inter', sans-serif; }
        .edit-input:focus { outline: none; border-color: var(--accent); }
        .edit-actions { display: flex; gap: 0.6rem; justify-content: flex-end; padding-top: 0.6rem; }

        .empty-state { text-align: center; padding: 3rem 2rem; color: var(--text-muted); }
        .empty-state i { font-size: 2.25rem; margin-bottom: 0.75rem; color: var(--border-strong); display: block; }

        /* ===== Timeline ===== */
        .tl-months-row { height: calc(var(--header-h) / 2); display: flex; align-items: center; border-bottom: 1px solid var(--border); }
        .tl-month-cell { font-size: 0.68rem; font-weight: 600; color: var(--text-muted); text-align: center; text-transform: uppercase; flex-shrink: 0; }
        .tl-days-row { height: calc(var(--header-h) / 2); display: flex; align-items: center; }
        .tl-day-cell { font-size: 0.62rem; line-height: 1.2; color: var(--text-muted); text-align: center; flex-shrink: 0; }
        .tl-day-cell .tl-day-letter { display: block; font-size: 0.58rem; font-weight: 600; color: var(--text-muted); }
        .tl-day-cell.weekend .tl-day-letter { color: #2563eb; }
        .tl-day-cell.weekend { background: var(--bg); }
        .tl-day-cell.today { color: var(--accent); font-weight: 700; }
        .tl-day-cell.today .tl-day-letter { color: var(--accent); }

        .tl-body { position: relative; }
        .tl-phase-row { height: var(--row-h); overflow: hidden; border-bottom: 1px solid var(--border); background: var(--phase-bg); position: relative; }
        .tl-row { height: var(--row-h); overflow: hidden; border-bottom: 1px solid var(--border); background: var(--tache-bg); position: relative; }

        .tl-day-col { position: absolute; top: 0; bottom: 0; border-right: 1px solid var(--border); pointer-events: none; }
        .tl-day-col.weekend { background: rgba(0,0,0,0.015); }

        .tl-today-line { position: absolute; top: 0; bottom: 0; width: 1px; background: var(--accent); z-index: 1; }

        .tl-bar { position: absolute; height: 20px; top: 50%; transform: translateY(-50%); border-radius: 4px; background: var(--prevu); }
        .tl-bar-fill { position: absolute; top: 0; left: 0; bottom: 0; background: var(--realise); border-radius: 3px; }
    </style>
</head>
<body>

@include('partials.navbar', ['navBackUrl' => url('/projet/'.$projet->id)])

<div class="page">

    <div class="page-title">PLANNING GANTT - ACCOMPAGNEMENT SMI</div>

    @php
        // Total général du projet — Avancement pondéré par CT Prévu (une tâche
        // de 20 j/h à 10% pèse plus qu'une tâche de 1 j/h à 100%), contrairement
        // à GanttPhase::avancement_moyen qui fait une moyenne simple par phase.
        $toutesTachesGlobal = \App\Models\GanttTache::where('projet_id', $projet->id)->get(['ct_prevue', 'ct_realisee', 'avancement']);
        $ctPrevuGlobal = round($toutesTachesGlobal->sum('ct_prevue'), 2);
        $ctRealiseGlobal = round($toutesTachesGlobal->sum('ct_realisee'), 2);
        $ecartGlobal = round($ctPrevuGlobal - $ctRealiseGlobal, 2);
        $avancementGlobal = $ctPrevuGlobal > 0
            ? round($toutesTachesGlobal->sum(fn($t) => $t->ct_prevue * $t->avancement) / $ctPrevuGlobal)
            : 0;
        $ecartGlobalClass = $ecartGlobal > 0 ? 'ecart-pos' : ($ecartGlobal < 0 ? 'ecart-neg' : 'ecart-zero');
        $avancementGlobalTier = $avancementGlobal >= 100 ? 'success' : ($avancementGlobal >= 50 ? 'warning' : 'danger');
    @endphp

    <div class="legend">
        <span><span class="legend-swatch" style="background:var(--prevu);"></span>Prévu</span>
        <span><span class="legend-swatch" style="background:var(--realise);"></span>Réalisation</span>

        <div class="global-stats">
            <span class="gstat-title"><i class="bi bi-calculator"></i> Total général</span>
            <div class="gstat">
                <i class="bi bi-bullseye"></i>
                <span class="gstat-label">CT Prévu</span>
                <span class="gstat-value">{{ number_format($ctPrevuGlobal, 1) }}</span>
            </div>
            <div class="gstat">
                <i class="bi bi-check2-circle"></i>
                <span class="gstat-label">CT Réalisé</span>
                <span class="gstat-value" style="color:var(--realise);">{{ number_format($ctRealiseGlobal, 1) }}</span>
            </div>
            <div class="gstat">
                <i class="bi bi-arrow-left-right"></i>
                <span class="gstat-label">Écart</span>
                <span class="gstat-value {{ $ecartGlobalClass }}">{{ number_format($ecartGlobal, 1) }}</span>
            </div>
            <div class="gstat">
                <i class="bi bi-speedometer2"></i>
                <span class="gstat-label">Avancement</span>
                <span class="gstat-value avancement-pill {{ $avancementGlobalTier }}">{{ $avancementGlobal }}%</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert" style="background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; padding:0.6rem 1rem; border-radius:6px; margin-bottom:1rem; font-size:0.85rem;">
        {{ session('success') }}
    </div>
    @endif

    @if(auth()->user()->hasPermission('modifier_projets'))
    <div class="toolbar">
        <button class="btn btn-light" onclick="openModal('addPhaseModal')">
            <i class="bi bi-folder-plus"></i> Ajouter une phase
        </button>
        <button class="btn btn-accent" onclick="openModal('addTacheModal')">
            <i class="bi bi-plus-lg"></i> Ajouter une tâche
        </button>
    </div>
    @endif

    @php
        // Palette professionnelle — une couleur distincte par phase (cycle si plus de 8 phases).
        $palettePhases = ['#2563eb', '#7c3aed', '#0891b2', '#059669', '#d97706', '#dc2626', '#4f46e5', '#db2777'];

        $groupes = [];
        foreach ($phases as $idx => $phase) {
            $groupes[] = [
                'nom' => $phase->nom,
                'phase' => $phase,
                'taches' => $phase->taches,
                'couleur' => $palettePhases[$idx % count($palettePhases)],
            ];
        }
        if ($tachesSansPhase->isNotEmpty()) {
            $groupes[] = ['nom' => 'Sans phase', 'phase' => null, 'taches' => $tachesSansPhase, 'couleur' => null];
        }
        $toutesTaches = collect($groupes)->flatMap(fn($g) => $g['taches']);

        $aujourdhui = \Carbon\Carbon::today();
        $tachesAvecDate = $toutesTaches->filter(fn($t) => $t->date_debut);

        if ($tachesAvecDate->isEmpty()) {
            $tlStart = \Carbon\Carbon::now()->startOfMonth()->subDays(5);
            $tlEnd = \Carbon\Carbon::now()->addMonths(2)->endOfMonth();
        } else {
            $tlStart = $tachesAvecDate->min('date_debut')->copy()->subDays(5);
            $finMax = $tachesAvecDate->map(fn($t) => $t->date_fin ?? $t->date_debut)->max();
            $tlEnd = $finMax->copy()->addDays(10);
        }

        $jours = [];
        $cur = $tlStart->copy();
        while ($cur->lte($tlEnd)) {
            $jours[] = $cur->copy();
            $cur->addDay();
        }
        $jourWidth = 30;
        $timelineWidth = count($jours) * $jourWidth;

        $moisGroups = [];
        foreach ($jours as $j) {
            $key = $j->format('Y-m');
            if (!isset($moisGroups[$key])) {
                $moisGroups[$key] = ['label' => $j->copy()->locale('fr')->isoFormat('MMM YYYY'), 'count' => 0];
            }
            $moisGroups[$key]['count']++;
        }

        $todayPosition = max(0, $tlStart->diffInDays($aujourdhui)) * $jourWidth;

        if (!function_exists('ganttTimelineBar')) {
            function ganttTimelineBar($tache, $tlStart, $jourWidth) {
                if (!$tache->date_debut) return null;
                $start = $tache->date_debut;
                $end = $tache->date_fin ?? $start;
                if ($end->lt($start)) $end = $start;
                $duree = $start->diffInDays($end) + 1;
                return [
                    'left' => $tlStart->diffInDays($start) * $jourWidth,
                    'width' => max($duree * $jourWidth, $jourWidth),
                ];
            }
        }
    @endphp

    @if($toutesTaches->isEmpty() && $phases->isEmpty())
    <div class="gantt-container">
        <div class="empty-state">
            <i class="bi bi-bar-chart-steps"></i>
            Aucune phase ni tâche pour le moment.
        </div>
    </div>
    @else
    <div class="gantt-container">

    <div class="gantt-head">
        <div class="gantt-head-left">
            <div class="cols-grid table-header-row">
                <div class="col">Désignation</div>
                <div class="col">CT Prévu</div>
                <div class="col">CT Réalisé</div>
                <div class="col">Écart</div>
                <div class="col">Avancement</div>
                <div class="col"></div>
            </div>
        </div>
        <div class="gantt-head-right" id="timelineHeadScroll">
            <div style="width: {{ $timelineWidth }}px;">
                <div class="tl-months-row">
                    @foreach($moisGroups as $mois)
                    <div class="tl-month-cell" style="width: {{ $mois['count'] * $jourWidth }}px;">{{ strtoupper($mois['label']) }}</div>
                    @endforeach
                </div>
                <div class="tl-days-row">
                    @foreach($jours as $j)
                    <div class="tl-day-cell {{ $j->isWeekend() ? 'weekend' : ($j->isSameDay($aujourdhui) ? 'today' : '') }}" style="width: {{ $jourWidth }}px;">
                        <span class="tl-day-letter">{{ strtoupper(substr($j->copy()->locale('fr')->isoFormat('dd'), 0, 1)) }}</span>{{ $j->format('d') }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="gantt-wrapper">
    <div class="left-panel">
        @foreach($groupes as $groupe)
        @php
            $ctPrevuTotal = $groupe['phase']->ct_prevu_total ?? $groupe['taches']->sum('ct_prevue');
            $ctRealiseTotal = $groupe['phase']->ct_realise_total ?? $groupe['taches']->sum('ct_realisee');
            $ecartTotal = $ctPrevuTotal - $ctRealiseTotal;
            $avancementMoyen = $groupe['phase']->avancement_moyen ?? round($groupe['taches']->avg('avancement') ?: 0);
        @endphp
        <div class="cols-grid phase-row" @if($groupe['couleur']) style="--phase-color: {{ $groupe['couleur'] }};" @endif>
            <div class="col nom">
                <i class="bi bi-folder2-open"></i>
                <span class="label">{{ $groupe['nom'] }}</span>
                <span class="count">({{ $groupe['taches']->count() }} tâche{{ $groupe['taches']->count() > 1 ? 's' : '' }})</span>
            </div>
            <div class="col">{{ number_format($ctPrevuTotal, 1) }}</div>
            <div class="col">{{ number_format($ctRealiseTotal, 1) }}</div>
            <div class="col">{{ number_format($ecartTotal, 1) }}</div>
            <div class="col">{{ $avancementMoyen }}%</div>
            <div class="col">
                @if($groupe['phase'] && auth()->user()->hasPermission('modifier_projets'))
                <div class="phase-actions">
                    <button type="button" class="icon-btn" title="Renommer" onclick="renommerPhase({{ $groupe['phase']->id }}, '{{ addslashes($groupe['phase']->nom) }}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button type="button" class="icon-btn danger" title="Supprimer" onclick="supprimerPhase({{ $groupe['phase']->id }})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                @endif
            </div>
        </div>

        @foreach($groupe['taches'] as $tache)
        <div class="cols-grid tache-row" id="row-{{ $tache->id }}" onclick="toggleEdit({{ $tache->id }})">
            <div class="col nom">{{ $tache->designation }}</div>
            <div class="col">{{ number_format($tache->ct_prevue, 1) }}</div>
            <div class="col">{{ number_format($tache->ct_realisee, 1) }}</div>
            <div class="col {{ $tache->ecart > 0 ? 'ecart-pos' : ($tache->ecart < 0 ? 'ecart-neg' : 'ecart-zero') }}">{{ number_format($tache->ecart, 1) }}</div>
            <div class="col"><span class="avancement-pill {{ $tache->statut_color }}">{{ round($tache->avancement) }}%</span></div>
            <div class="col"></div>
        </div>

        @if(auth()->user()->hasPermission('modifier_projets'))
        <div class="edit-panel" id="ep-{{ $tache->id }}">
            <form method="POST" action="{{ route('gantt.tache.update', [$projet->id, $tache->id]) }}">
                @csrf @method('PUT')
                <input type="hidden" name="responsable" value="{{ $tache->responsable }}">
                <div class="edit-grid">
                    <div class="edit-full">
                        <label class="edit-label">Désignation</label>
                        <input type="text" name="designation" class="edit-input" value="{{ $tache->designation }}" required>
                    </div>
                </div>
                <div class="edit-grid">
                    <div>
                        <label class="edit-label">Phase</label>
                        <select name="phase_id" class="edit-input">
                            <option value="">Sans phase</option>
                            @foreach($phases as $p)
                            <option value="{{ $p->id }}" {{ $tache->phase_id == $p->id ? 'selected' : '' }}>{{ $p->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="edit-label">CT Prévu (H/J)</label>
                        <input type="number" name="ct_prevue" class="edit-input" value="{{ $tache->ct_prevue }}" step="0.5" min="0">
                    </div>
                    <div>
                        <label class="edit-label">CT Réalisé (H/J)</label>
                        <input type="number" name="ct_realisee" class="edit-input" value="{{ $tache->ct_realisee }}" step="0.5" min="0">
                    </div>
                    <div>
                        <label class="edit-label">Avancement (%)</label>
                        <input type="number" name="avancement" class="edit-input" value="{{ round($tache->avancement) }}" min="0" max="100">
                    </div>
                </div>
                <div class="edit-grid">
                    <div>
                        <label class="edit-label">Date début</label>
                        <input type="date" name="date_debut" class="edit-input" value="{{ $tache->date_debut?->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="edit-label">Date fin (prévue)</label>
                        <input type="date" name="date_fin" class="edit-input" value="{{ $tache->date_fin?->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="edit-actions">
                    <button type="button" class="btn btn-light btn-sm" onclick="closeEdit({{ $tache->id }})">Annuler</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteTache({{ $tache->id }})">Supprimer</button>
                    <button type="submit" class="btn btn-accent btn-sm">Enregistrer</button>
                </div>
            </form>
            <form id="delete-tache-{{ $tache->id }}" method="POST" action="{{ route('gantt.tache.destroy', [$projet->id, $tache->id]) }}" style="display:none;">@csrf @method('DELETE')</form>
        </div>
        @endif
        @endforeach
        @endforeach
    </div>

    <div class="right-panel" id="timelineBodyScroll">
        <div style="width: {{ $timelineWidth }}px; position:relative;">
            <div class="tl-body">
                <div class="tl-today-line" style="left: {{ $todayPosition }}px;"></div>
                @foreach($groupes as $groupe)
                <div class="tl-phase-row" style="width: {{ $timelineWidth }}px; {{ $groupe['couleur'] ? '--phase-color: '.$groupe['couleur'].';' : '' }}"></div>
                @foreach($groupe['taches'] as $tache)
                @php $bar = ganttTimelineBar($tache, $tlStart, $jourWidth); @endphp
                <div class="tl-row" style="width: {{ $timelineWidth }}px;">
                    @foreach($jours as $idx => $j)
                    <div class="tl-day-col {{ $j->isWeekend() ? 'weekend' : '' }}" style="left: {{ $idx * $jourWidth }}px; width: {{ $jourWidth }}px;"></div>
                    @endforeach
                    @if($bar)
                    <div class="tl-bar" style="left: {{ $bar['left'] }}px; width: {{ $bar['width'] }}px;" title="{{ $tache->designation }} — {{ round($tache->avancement) }}%">
                        <div class="tl-bar-fill" style="width: {{ round($bar['width'] * min($tache->avancement, 100) / 100) }}px;"></div>
                    </div>
                    @endif
                </div>
                @endforeach
                @endforeach
            </div>
        </div>
    </div>

    </div>
    </div>
    @endif

</div>

@if(auth()->user()->hasPermission('modifier_projets'))
<!-- Modal Ajouter phase -->
<div class="modal-overlay" id="addPhaseModal">
    <div class="modal">
        <h3><i class="bi bi-folder-plus"></i> Nouvelle phase</h3>
        <form method="POST" action="{{ route('gantt.phase.store', $projet->id) }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nom de la phase</label>
                <input type="text" name="nom" class="form-control" placeholder="Ex: Phase 1 — Diagnostic" required>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-light" onclick="closeModal('addPhaseModal')">Annuler</button>
                <button type="submit" class="btn btn-accent">Créer</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ajouter tâche -->
<div class="modal-overlay" id="addTacheModal">
    <div class="modal">
        <h3><i class="bi bi-plus-circle"></i> Nouvelle tâche</h3>
        <form method="POST" action="{{ route('gantt.tache.store', $projet->id) }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Désignation</label>
                <input type="text" name="designation" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Phase</label>
                <select name="phase_id" class="form-control">
                    <option value="">Sans phase</option>
                    @foreach($phases as $p)
                    <option value="{{ $p->id }}">{{ $p->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">CT Prévu (H/J)</label>
                <input type="number" name="ct_prevue" class="form-control" step="0.5" min="0" value="0" required>
            </div>
            <div class="form-group" style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                <div>
                    <label class="form-label">Date début</label>
                    <input type="date" name="date_debut" class="form-control">
                </div>
                <div>
                    <label class="form-label">Date fin (prévue)</label>
                    <input type="date" name="date_fin" class="form-control">
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-light" onclick="closeModal('addTacheModal')">Annuler</button>
                <button type="submit" class="btn btn-accent">Créer</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Renommer phase -->
<div class="modal-overlay" id="renamePhaseModal">
    <div class="modal">
        <h3><i class="bi bi-pencil"></i> Renommer la phase</h3>
        <form method="POST" id="renamePhaseForm">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Nom de la phase</label>
                <input type="text" name="nom" id="renamePhaseInput" class="form-control" required>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-light" onclick="closeModal('renamePhaseModal')">Annuler</button>
                <button type="submit" class="btn btn-accent">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Confirmation (remplace confirm() du navigateur) -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal" style="width:400px;">
        <h3><i class="bi bi-exclamation-triangle" style="color:#dc2626;"></i> Confirmation</h3>
        <p id="confirmModalMessage" style="font-size:0.85rem; color:var(--text-muted); margin-bottom:0.5rem;"></p>
        <div class="modal-actions">
            <button type="button" class="btn btn-light" onclick="closeModal('confirmModal')">Annuler</button>
            <button type="button" class="btn btn-danger" id="confirmModalBtn">Supprimer</button>
        </div>
    </div>
</div>
@endif

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }

document.querySelectorAll('.modal-overlay').forEach(function (modal) {
    modal.addEventListener('click', function (e) { if (e.target === modal) modal.classList.remove('active'); });
});

let currentEditId = null;

function toggleEdit(id) {
    if (currentEditId !== null && currentEditId !== id) closeEdit(currentEditId);
    const ep = document.getElementById('ep-' + id);
    const row = document.getElementById('row-' + id);
    if (!ep) return;
    if (ep.classList.contains('open')) {
        closeEdit(id);
    } else {
        ep.classList.add('open');
        if (row) row.classList.add('selected');
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

function showConfirmDialog(message, onConfirm) {
    document.getElementById('confirmModalMessage').textContent = message;
    const btn = document.getElementById('confirmModalBtn');
    const freshBtn = btn.cloneNode(true);
    btn.parentNode.replaceChild(freshBtn, btn);
    freshBtn.addEventListener('click', function () {
        closeModal('confirmModal');
        onConfirm();
    });
    openModal('confirmModal');
}

function confirmDeleteTache(id) {
    showConfirmDialog('Supprimer cette tâche ?', function () {
        document.getElementById('delete-tache-' + id).submit();
    });
}

function renommerPhase(id, nomActuel) {
    document.getElementById('renamePhaseInput').value = nomActuel;
    document.getElementById('renamePhaseForm').action = '{{ url("/projet/".$projet->id."/gantt/phase") }}/' + id;
    openModal('renamePhaseModal');
}

function supprimerPhase(id) {
    showConfirmDialog('Supprimer cette phase ? Les tâches associées passeront en "Sans phase".', function () {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("/projet/".$projet->id."/gantt/phase") }}/' + id;
        form.innerHTML = '@csrf @method("DELETE")';
        document.body.appendChild(form);
        form.submit();
    });
}

// Synchronise le défilement horizontal du header de la timeline avec son corps
const timelineBodyScroll = document.getElementById('timelineBodyScroll');
const timelineHeadScroll = document.getElementById('timelineHeadScroll');
if (timelineBodyScroll && timelineHeadScroll) {
    timelineBodyScroll.addEventListener('scroll', function () {
        timelineHeadScroll.scrollLeft = timelineBodyScroll.scrollLeft;
    });
}

window.addEventListener('load', function () {
    if (timelineBodyScroll) {
        const todayPosition = {{ $todayPosition ?? 0 }};
        timelineBodyScroll.scrollLeft = Math.max(0, todayPosition - timelineBodyScroll.offsetWidth / 3);
    }
});
</script>

</body>
</html>
