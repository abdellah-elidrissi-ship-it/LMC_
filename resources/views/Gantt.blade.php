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
            --bg: #f4f6f9;
            --surface: #ffffff;
            --border: #e2e8f0;
            --border-strong: #cbd5e1;
            --text: #0f172a;
            --text-muted: #64748b;
            --accent: #164b78;
            --prevu: #a8b4c2;
            --realise: #2ea8e0;
            --phase-bg: #dde5ee;
            --tache-bg: #ffffff;
            --phase-violet: #7c3aed;
            --danger-bg: #fee2e2;
            --danger-text: #b91c1c;
            --warning-bg: #fef3c7;
            --warning-text: #b45309;
            --success-bg: #dcfce7;
            --success-text: #15803d;
            --ecart-neg: #b91c1c;
            --btn: #78716c;
            --btn-hover: #57534e;
            --journee: #0d9488;
            --report-gap: #f59e0b;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #0b1220;
                --surface: #131b2c;
                --border: #263349;
                --border-strong: #34445f;
                --text: #e5e9f0;
                --text-muted: #93a0b4;
                --accent: #4a9eda;
                --prevu: #4b5768;
                --realise: #38bdf8;
                --phase-bg: #1b2a41;
                --tache-bg: #131b2c;
                --phase-violet: #a78bfa;
                --danger-bg: #4c1d1d;
                --danger-text: #fca5a5;
                --warning-bg: #4a2e05;
                --warning-text: #fcd34d;
                --success-bg: #0f3d24;
                --success-text: #86efac;
                --ecart-neg: #fca5a5;
                --btn: #a8a29e;
                --btn-hover: #d6d3d1;
                --journee: #2dd4bf;
                --report-gap: #fbbf24;
            }
        }

        :root[data-theme="dark"] {
            --bg: #0b1220;
            --surface: #131b2c;
            --border: #263349;
            --border-strong: #34445f;
            --text: #e5e9f0;
            --text-muted: #93a0b4;
            --accent: #4a9eda;
            --prevu: #4b5768;
            --realise: #38bdf8;
            --phase-bg: #1b2a41;
            --tache-bg: #131b2c;
            --phase-violet: #a78bfa;
            --danger-bg: #4c1d1d;
            --danger-text: #fca5a5;
            --warning-bg: #4a2e05;
            --warning-text: #fcd34d;
            --success-bg: #0f3d24;
            --success-text: #86efac;
            --ecart-neg: #fca5a5;
            --btn: #a8a29e;
            --btn-hover: #d6d3d1;
            --journee: #2dd4bf;
            --report-gap: #fbbf24;
        }

        :root[data-theme="light"] {
            --bg: #f4f6f9;
            --surface: #ffffff;
            --border: #e2e8f0;
            --border-strong: #cbd5e1;
            --text: #0f172a;
            --text-muted: #64748b;
            --accent: #164b78;
            --prevu: #a8b4c2;
            --realise: #2ea8e0;
            --phase-bg: #dde5ee;
            --tache-bg: #ffffff;
            --phase-violet: #7c3aed;
            --danger-bg: #fee2e2;
            --danger-text: #b91c1c;
            --warning-bg: #fef3c7;
            --warning-text: #b45309;
            --success-bg: #dcfce7;
            --success-text: #15803d;
            --ecart-neg: #b91c1c;
            --btn: #78716c;
            --btn-hover: #57534e;
            --journee: #0d9488;
            --report-gap: #f59e0b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); font-size: 13px; }

        .page { max-width: 1700px; margin: 0 auto; padding: 2rem; }

        .page-title {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-retour-gantt {
            display: inline-flex; align-items: center; gap: 0.4rem;
            border: 1px solid var(--border); border-radius: 6px;
            padding: 0.4rem 0.9rem; font-size: 0.78rem; font-weight: 600;
            color: var(--text); background: var(--surface); text-decoration: none;
            transition: background 0.15s;
        }
        .btn-retour-gantt:hover { background: var(--bg); color: var(--text); }

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

        .toolbar { display: flex; gap: 0.5rem; }

        .btn {
            border: 1px solid transparent; border-radius: 6px; padding: 0.5rem 1rem; font-size: 0.8rem; font-weight: 500;
            cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; transition: background 0.15s;
            text-decoration: none;
        }
        .btn-accent { background: var(--btn); color: white; }
        .btn-accent:hover { background: var(--btn-hover); }
        .btn-light { background: var(--surface); color: var(--btn); border-color: var(--btn); }
        .btn-light:hover { background: var(--bg); }
        .btn-danger { background: transparent; color: var(--btn); border-color: var(--btn); }
        .btn-danger:hover { background: var(--btn); color: white; }
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
        .consultants-dropdown { position: relative; }
        .consultants-dropdown-toggle { width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; border: 1px solid var(--border-strong); border-radius: 6px; padding: 0.5rem 0.7rem; font-size: 0.82rem; font-family: 'Inter', sans-serif; background: var(--surface); color: var(--text); cursor: pointer; text-align: left; }
        .consultants-dropdown-toggle:focus { outline: none; border-color: var(--accent); }
        .consultants-dropdown-toggle .cdt-label { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .consultants-dropdown-toggle .cdt-label.cdt-placeholder { color: var(--text-muted); }
        .consultants-dropdown-toggle i { flex-shrink: 0; color: var(--text-muted); transition: transform 0.15s; }
        .consultants-dropdown.open .consultants-dropdown-toggle i { transform: rotate(180deg); }
        .consultants-dropdown-panel { display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0; z-index: 20; background: var(--surface); border: 1px solid var(--border-strong); border-radius: 6px; box-shadow: 0 6px 16px rgba(0,0,0,0.15); padding: 0.4rem 0.6rem; max-height: 180px; overflow-y: auto; }
        .consultants-dropdown.open .consultants-dropdown-panel { display: block; }
        .consultants-checklist .consultant-check { display: flex; align-items: center; gap: 0.5rem; padding: 0.25rem 0; font-size: 0.82rem; }
        .consultants-checklist .consultant-check input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--accent); flex-shrink: 0; }
        .consultants-checklist .consultant-check label { cursor: pointer; margin: 0; }
        .consultants-checklist .consultants-empty { font-size: 0.78rem; color: var(--text-muted); padding: 0.2rem 0; }
        .equipe-badge { display: inline-flex; align-items: center; gap: 0.3rem; background: color-mix(in srgb, var(--accent) 15%, var(--surface)); color: var(--accent); font-size: 0.72rem; font-weight: 600; padding: 0.2rem 0.55rem; border-radius: 999px; white-space: nowrap; }

        /* ===== Table Gantt ===== */
        :root { --row-h: 42px; --header-h: 44px; }

        .gantt-container { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; margin-top: 1.5rem; }

        /* Bandeau d'en-tête FIXE — hors du flux scrollable, plus de position:sticky */
        .gantt-head { display: flex; background: var(--bg); border-bottom: 1px solid var(--border-strong); }
        .gantt-head-left { flex-shrink: 0; width: 890px; border-right: 1px solid var(--border); }
        .gantt-head-right { flex: 1; overflow: hidden; }

        .gantt-wrapper { display: flex; align-items: flex-start; max-height: calc(100vh - 300px); overflow-y: auto; }
        .left-panel { flex-shrink: 0; width: 890px; border-right: 1px solid var(--border); }
        .right-panel { flex: 1; overflow-x: auto; overflow-y: hidden; }

        .cols-grid { display: grid; grid-template-columns: 1fr 130px 100px 100px 90px 110px 90px; }

        .table-header-row { height: var(--header-h); }
        .table-header-row .col { display: flex; align-items: center; justify-content: center; padding: 0 0.6rem; font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.02em; color: var(--text-muted); }
        .table-header-row .col:first-child { justify-content: flex-start; }

        .phase-row { height: var(--row-h); overflow: hidden; background: var(--phase-bg); border-bottom: 1px solid var(--border); border-top: 1px solid var(--border); border-left: 5px solid var(--phase-violet); align-items: center; }
        .phase-row .col.nom i { color: var(--phase-violet); }
        .tl-phase-row { border-left: 5px solid var(--phase-violet); }
        .phase-row .col { padding: 0.5rem 0.6rem; font-weight: 600; font-size: 0.82rem; text-align: center; overflow: hidden; }
        .phase-row .col.nom { text-align: left; display: flex; align-items: center; gap: 0.5rem; white-space: nowrap; text-overflow: ellipsis; }
        .phase-row .col.nom span.label { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; min-width: 0; }
        .phase-row .col.nom i { color: var(--text-muted); flex-shrink: 0; }
        .phase-row .count { font-weight: 400; font-size: 0.72rem; color: var(--text-muted); flex-shrink: 0; }
        .phase-actions { display: flex; gap: 0.2rem; justify-content: center; flex-shrink: 0; }
        .icon-btn { border: none; background: transparent; color: var(--text-muted); cursor: pointer; padding: 0.2rem 0.35rem; border-radius: 4px; font-size: 0.85rem; }
        .icon-btn:hover { background: var(--border); color: var(--text); }
        .icon-btn.danger:hover { background: var(--danger-bg); color: var(--danger-text); }

        .tache-row { height: var(--row-h); overflow: hidden; background: var(--tache-bg); border-bottom: 1px solid var(--border); align-items: center; cursor: pointer; transition: background 0.1s; }
        .tache-row:hover { background: var(--bg); }
        .tache-row.selected { background: #f0f5ff; }
        .tache-row .col { padding: 0.4rem 0.6rem; font-size: 0.8rem; text-align: center; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
        .tache-row .col.nom { text-align: left; padding-left: 1.5rem; }

        .ecart-pos { color: var(--text-muted); }
        .ecart-neg { color: var(--ecart-neg); font-weight: 600; }
        .ecart-zero { color: var(--text-muted); }
        .tt-ecart-display { padding: 0.5rem 0.75rem; font-size: 0.85rem; font-weight: 600; }

        /* Mini barre de progression bicolore : même logique que la timeline
           (fond = Prévu, remplissage = Réalisation/Journée selon le type de tâche),
           au lieu d'un code couleur rouge/orange/vert déconnecté du reste du Gantt. */
        .avancement-pill {
            font-weight: 700;
            padding: 0.15rem 0.6rem;
            border-radius: 999px;
            color: var(--text);
            border: 1px solid var(--border-strong);
            background: linear-gradient(90deg,
                color-mix(in srgb, var(--realise) 40%, var(--surface)) var(--fill, 0%),
                var(--bg) var(--fill, 0%));
        }
        .avancement-pill.journee {
            background: linear-gradient(90deg,
                color-mix(in srgb, var(--journee) 40%, var(--surface)) var(--fill, 0%),
                var(--bg) var(--fill, 0%));
        }

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
        .tl-day-cell.weekend .tl-day-letter { color: var(--accent); }
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

        /* Type "Journée" — jours discontinus, un bloc par jour choisi */
        .tl-journee-block { position: absolute; height: 20px; top: 50%; transform: translateY(-50%); border-radius: 4px; background: var(--journee); }

        /* Type "Report" — période d'attente entre l'interruption et la reprise */
        .tl-report-gap {
            position: absolute; height: 12px; top: 50%; transform: translateY(-50%); border-radius: 3px;
            background: repeating-linear-gradient(45deg, var(--report-gap), var(--report-gap) 5px, transparent 5px, transparent 10px);
            border: 1px dashed var(--report-gap); opacity: 0.85;
        }

        /* Icône de type dans la colonne Désignation */
        .tache-type-icon { margin-right: 0.3rem; font-size: 0.75rem; }
        .tache-type-icon.journee { color: var(--journee); }
        .tache-type-icon.report { color: var(--report-gap); }

        /* ===== Sélecteur de type de tâche (formulaires) ===== */
        .type-tache-selector { display: flex; gap: 0.5rem; }
        .type-pill {
            flex: 1; display: flex; align-items: center; justify-content: center; gap: 0.35rem;
            padding: 0.5rem 0.4rem; border: 1px solid var(--border-strong); border-radius: 6px;
            font-size: 0.78rem; font-weight: 600; cursor: pointer; transition: all 0.15s; color: var(--text-muted);
        }
        .type-pill input { display: none; }
        .type-pill.active { background: var(--text); color: var(--surface); border-color: var(--text); }

        /* ===== Sélecteur de jours (type Journée) ===== */
        .jour-picker { border: 1px solid var(--border-strong); border-radius: 6px; padding: 0.75rem; margin-top: 0.5rem; }
        .jp-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; }
        .jp-header .jp-month-label { font-size: 0.8rem; font-weight: 600; text-transform: capitalize; }
        .jp-nav { border: none; background: transparent; cursor: pointer; color: var(--text-muted); padding: 0.2rem 0.4rem; border-radius: 4px; }
        .jp-nav:hover { background: var(--bg); color: var(--text); }
        .jp-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 3px; }
        .jp-dow { text-align: center; font-size: 0.6rem; font-weight: 600; color: var(--text-muted); padding-bottom: 0.2rem; }
        .jp-day { border: 1px solid transparent; background: var(--bg); border-radius: 4px; padding: 0.3rem 0; font-size: 0.72rem; cursor: pointer; color: var(--text); }
        .jp-day:hover { border-color: var(--journee); }
        .jp-day.weekend { color: var(--text-muted); }
        .jp-day.selected { background: var(--journee); color: white; font-weight: 700; }
        .jp-counter { margin-top: 0.5rem; font-size: 0.72rem; font-weight: 600; text-align: center; }
        .jp-counter.jp-counter-ok { color: var(--success-text); }
        .jp-counter.jp-counter-bad { color: var(--danger-text); }
        .tt-date-fin-preview { font-size: 0.7rem; color: var(--text-muted); margin-top: 0.3rem; }
        .tt-date-reprise-countdown { font-size: 0.7rem; margin-top: 0.3rem; }
        .tt-countdown-ok { color: var(--text-muted); font-weight: 600; }
        .tt-countdown-late { color: var(--danger-text); font-weight: 700; }

        .tt-report-block { border-top: 1px dashed var(--border-strong); padding-top: 0.6rem; }
        .tt-report-status { font-size: 0.75rem; font-weight: 600; color: var(--report-gap); margin-bottom: 0.4rem; }
        .tt-report-reveal { margin-top: 0.5rem; display: flex; align-items: flex-end; gap: 0.6rem; flex-wrap: wrap; }
        .tt-report-reveal .edit-input { width: auto; }
    </style>
</head>
<body>

@include('partials.navbar', ['navBackUrl' => url('/projet/'.$projet->id)])

<div class="page">

    <div class="page-title">
        <a href="{{ url('/projet/'.$projet->id) }}" class="btn-retour-gantt">
            <i class="bi bi-arrow-left"></i> Retour au projet
        </a>
        PLANNING GANTT - ACCOMPAGNEMENT SMI
    </div>

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
    @endphp

    <div class="legend">
        <span><span class="legend-swatch" style="background:var(--prevu);"></span>Prévu</span>
        <span><span class="legend-swatch" style="background:var(--realise);"></span>Réalisation</span>
        <span><span class="legend-swatch" style="background:var(--journee);"></span>Journée (jours choisis)</span>
        <span><span class="legend-swatch" style="background:var(--report-gap);"></span>Report (en attente de reprise)</span>

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
                <span class="gstat-value avancement-pill" style="--fill: {{ $avancementGlobal }}%;">{{ $avancementGlobal }}%</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert" style="background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; padding:0.6rem 1rem; border-radius:6px; margin-bottom:1rem; font-size:0.85rem;">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert" style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca; padding:0.6rem 1rem; border-radius:6px; margin-bottom:1rem; font-size:0.85rem;">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ $errors->first() }}
    </div>
    @endif

    <div class="toolbar">
        @if($groupBy === 'consultant')
        <a href="{{ route('gantt.show', $projet->id) }}" class="btn btn-light">
            <i class="bi bi-folder2-open"></i> Vue par phase
        </a>
        @else
        <a href="{{ route('gantt.show', $projet->id) }}?groupBy=consultant" class="btn btn-light">
            <i class="bi bi-people"></i> Vue par consultant
        </a>
        @endif

        @if(auth()->user()->hasPermission('modifier_projets'))
        <button class="btn btn-light" onclick="openModal('addPhaseModal')">
            <i class="bi bi-folder-plus"></i> Ajouter une phase
        </button>
        <button class="btn btn-accent" onclick="openModal('addTacheModal')">
            <i class="bi bi-plus-lg"></i> Ajouter une tâche
        </button>
        @endif
    </div>

    @php
        // Toutes les lignes de groupe (phase ou consultant) partagent la même couleur
        // de bordure (--phase-violet, définie en CSS) — plus de cycle de palette par index.
        $groupes = [];

        if ($groupBy === 'consultant') {
            $toutesTachesProjet = \App\Models\GanttTache::where('projet_id', $projet->id)
                ->orderBy('numero')
                ->with('consultants')
                ->get();
            $idsConsultantsProjet = $consultantsProjet->pluck('id');

            // Une tâche avec plusieurs consultants apparaît dans le groupe de chacun d'eux.
            foreach ($consultantsProjet as $consultant) {
                $groupes[] = [
                    'nom' => $consultant->nom_complet,
                    'phase' => null,
                    'taches' => $toutesTachesProjet->filter(
                        fn($t) => $t->consultants->contains('id', $consultant->id)
                    ),
                    'icon' => 'bi-person-circle',
                ];
            }

            // Tâches sans consultant, ou assignées uniquement à des consultants qui ne sont plus dans l'équipe projet.
            $nonAssignees = $toutesTachesProjet->reject(
                fn($t) => $t->consultants->pluck('id')->intersect($idsConsultantsProjet)->isNotEmpty()
            );
            if ($nonAssignees->isNotEmpty()) {
                $groupes[] = ['nom' => 'Non assigné', 'phase' => null, 'taches' => $nonAssignees, 'icon' => 'bi-person-circle'];
            }
        } else {
            foreach ($phases as $phase) {
                $groupes[] = [
                    'nom' => $phase->nom,
                    'phase' => $phase,
                    'taches' => $phase->taches,
                    'icon' => 'bi-folder2-open',
                ];
            }
            if ($tachesSansPhase->isNotEmpty()) {
                $groupes[] = ['nom' => 'Sans phase', 'phase' => null, 'taches' => $tachesSansPhase, 'icon' => 'bi-folder2-open'];
            }
        }

        $toutesTaches = collect($groupes)->flatMap(fn($g) => $g['taches']);

        $aujourdhui = \Carbon\Carbon::today();
        $tachesAvecDate = $toutesTaches->filter(fn($t) => $t->date_debut);

        if ($tachesAvecDate->isEmpty()) {
            $tlStart = \Carbon\Carbon::now()->startOfMonth()->subDays(5);
            $tlEnd = \Carbon\Carbon::now()->addMonths(2)->endOfMonth();
        } else {
            $tlStart = $tachesAvecDate->min('date_debut')->copy()->subDays(5);
            $finMax = $tachesAvecDate->map(function ($t) {
                $fin = $t->date_fin ?? $t->date_debut;
                return ($t->date_reprise && $t->date_reprise->gt($fin)) ? $t->date_reprise : $fin;
            })->max();
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

        // Position de scroll cible pour la tâche qu'on vient de créer/modifier (voir
        // GanttController et le script en bas de page). On centre sur le MILIEU de
        // [date_debut, date_fin] plutôt que sur le tout début : pour une tâche en
        // report, date_fin est recalculée après la reprise (voir
        // GanttTacheDateCalculator::resoudrePourPhase), donc ce milieu tombe déjà
        // naturellement dans/près de la pause — flexible avec la durée du report,
        // qu'il soit court ou très long, sans avoir à cibler un segment DOM précis.
        $scrollTargetLeft = null;
        $tacheAScroller = session('scrollToTacheId') ? $toutesTaches->firstWhere('id', (int) session('scrollToTacheId')) : null;
        if ($tacheAScroller && $tacheAScroller->date_debut) {
            $finCible = $tacheAScroller->date_fin ?? $tacheAScroller->date_debut;
            $milieu = $tacheAScroller->date_debut->copy()->addDays(intdiv($tacheAScroller->date_debut->diffInDays($finCible), 2));
            $scrollTargetLeft = $tlStart->diffInDays($milieu) * $jourWidth;
        }

        // Projette les segments déjà résolus/stockés (colonne `segments`, calculés
        // au save() par App\Services\GanttTacheDateCalculator) en pixels. Aucune
        // décision de date ici — uniquement date -> pixel via $tlStart/$jourWidth.
        if (!function_exists('ganttProjeterSegments')) {
            function ganttProjeterSegments($tache, $tlStart, $jourWidth) {
                return collect($tache->segments ?? [])->map(function ($seg) use ($tlStart, $jourWidth) {
                    $debut = \Carbon\Carbon::parse($seg['debut']);
                    $width = $seg['jours'] * $jourWidth;
                    $fillJours = $seg['fill_jours'] ?? 0;

                    return [
                        'type' => $seg['type'],
                        'left' => $tlStart->diffInDays($debut) * $jourWidth,
                        'width' => $width,
                        'fillWidth' => $fillJours >= $seg['jours'] ? $width : round($fillJours * $jourWidth),
                    ];
                })->all();
            }
        }
    @endphp

    @if(empty($groupes))
    <div class="gantt-container">
        <div class="empty-state">
            <i class="bi bi-bar-chart-steps"></i>
            @if($groupBy === 'consultant')
                Aucun consultant affecté à ce projet pour le moment.
            @else
                Aucune phase ni tâche pour le moment.
            @endif
        </div>
    </div>
    @else
    <div class="gantt-container">

    <div class="gantt-head">
        <div class="gantt-head-left">
            <div class="cols-grid table-header-row">
                <div class="col">Désignation</div>
                <div class="col">Consultant</div>
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
        <div class="cols-grid phase-row">
            <div class="col nom">
                <i class="bi {{ $groupe['icon'] }}"></i>
                <span class="label">{{ $groupe['nom'] }}</span>
                <span class="count">({{ $groupe['taches']->count() }} tâche{{ $groupe['taches']->count() > 1 ? 's' : '' }})</span>
            </div>
            <div class="col"></div>
            <div class="col">{{ number_format($ctPrevuTotal, 1) }}</div>
            <div class="col">{{ number_format($ctRealiseTotal, 1) }}</div>
            <div class="col {{ $ecartTotal > 0 ? 'ecart-pos' : ($ecartTotal < 0 ? 'ecart-neg' : 'ecart-zero') }}">{{ number_format($ecartTotal, 1) }}</div>
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
            <div class="col nom">
                @if($tache->isJournee())
                <i class="bi bi-calendar-week tache-type-icon journee" title="Journée (jours choisis)"></i>
                @endif
                @if($tache->hasReport())
                <i class="bi bi-pause-circle-fill tache-type-icon report" title="En pause — reprise prévue le {{ $tache->date_reprise->format('d/m/Y') }}"></i>
                @endif
                {{ $tache->designation }}
            </div>
            @php $nomsConsultants = $tache->consultants->pluck('nom_complet')->join(', '); @endphp
            <div class="col" title="{{ $nomsConsultants }}">
                @if($tache->consultants->count() > 1)
                <span class="equipe-badge"><i class="bi bi-people-fill"></i> Équipe ({{ $tache->consultants->count() }})</span>
                @else
                {{ $nomsConsultants ?: '—' }}
                @endif
            </div>
            <div class="col">{{ number_format($tache->ct_prevue, 1) }}</div>
            <div class="col">{{ number_format($tache->ct_realisee, 1) }}</div>
            <div class="col {{ $tache->ecart > 0 ? 'ecart-pos' : ($tache->ecart < 0 ? 'ecart-neg' : 'ecart-zero') }}">{{ number_format($tache->ecart, 1) }}</div>
            <div class="col"><span class="avancement-pill {{ $tache->isJournee() ? 'journee' : '' }}" style="--fill: {{ round($tache->avancement) }}%;">{{ round($tache->avancement) }}%</span></div>
            <div class="col"></div>
        </div>

        @if(auth()->user()->hasPermission('modifier_projets'))
        <div class="edit-panel" id="ep-{{ $tache->id }}">
            <form method="POST" action="{{ route('gantt.tache.update', [$projet->id, $tache->id]) }}" class="tt-root">
                @csrf @method('PUT')
                <input type="hidden" name="_tache_id" value="{{ $tache->id }}">
                <input type="hidden" name="responsable" value="{{ $tache->responsable }}">
                <div class="edit-grid">
                    <div class="edit-full">
                        <label class="edit-label">Désignation</label>
                        <input type="text" name="designation" class="edit-input" value="{{ $tache->designation }}" required>
                    </div>
                </div>
                <div class="edit-grid">
                    <div>
                        <label class="edit-label tt-ct-prevue-label">CT Prévu (H/J)</label>
                        <input type="number" name="ct_prevue" class="edit-input tt-ct-prevue" value="{{ $tache->ct_prevue }}" step="0.5" min="0">
                    </div>
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
                        <label class="edit-label">Consultant(s)</label>
                        @php $selectedNoms = $tache->consultants->pluck('nom_complet'); @endphp
                        <div class="consultants-dropdown" data-consultants-dropdown>
                            <button type="button" class="consultants-dropdown-toggle" data-cdt-toggle>
                                <span class="cdt-label {{ $selectedNoms->isEmpty() ? 'cdt-placeholder' : '' }}" data-cdt-label>{{ $selectedNoms->isNotEmpty() ? $selectedNoms->join(', ') : 'Sélectionner...' }}</span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="consultants-dropdown-panel">
                                <div class="consultants-checklist">
                                    @forelse($consultantsProjet as $c)
                                    @php $checkId = "edit-consultant-{$tache->id}-{$c->id}"; @endphp
                                    <div class="consultant-check">
                                        <input type="checkbox" name="consultant_ids[]" value="{{ $c->id }}" id="{{ $checkId }}"
                                            data-cdt-name="{{ $c->nom_complet }}"
                                            {{ $tache->consultants->contains('id', $c->id) ? 'checked' : '' }}>
                                        <label for="{{ $checkId }}">{{ $c->nom_complet }}</label>
                                    </div>
                                    @empty
                                    <div class="consultants-empty">Aucun consultant affecté au projet.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="edit-label">CT Réalisé (H/J)</label>
                        <input type="number" name="ct_realisee" class="edit-input tt-ct-realisee" value="{{ $tache->ct_realisee }}" step="0.5" min="0">
                    </div>
                    <div>
                        <label class="edit-label">Avancement (%)</label>
                        <input type="number" name="avancement" class="edit-input" value="{{ round($tache->avancement) }}" min="0" max="100">
                    </div>
                    <div>
                        <label class="edit-label">Écart</label>
                        <div class="tt-ecart-display {{ $tache->ecart < 0 ? 'ecart-neg' : 'ecart-zero' }}">{{ number_format($tache->ecart, 1) }}</div>
                    </div>
                </div>

                <div class="edit-grid">
                    <div class="edit-full">
                        <label class="edit-label">Type de tâche</label>
                        <div class="type-tache-selector">
                            <label class="type-pill {{ !$tache->isJournee() ? 'active' : '' }}">
                                <input type="radio" name="type_tache" value="phase" {{ !$tache->isJournee() ? 'checked' : '' }}>
                                <i class="bi bi-bar-chart-steps"></i> Phase
                            </label>
                            <label class="type-pill {{ $tache->isJournee() ? 'active' : '' }}">
                                <input type="radio" name="type_tache" value="journee" {{ $tache->isJournee() ? 'checked' : '' }}>
                                <i class="bi bi-calendar-week"></i> Journée
                            </label>
                        </div>
                    </div>
                </div>

                <div class="edit-grid tt-fields-phase">
                    <div>
                        <label class="edit-label">Date début</label>
                        <input type="date" name="date_debut" lang="fr" class="edit-input tt-date-debut" value="{{ $tache->date_debut?->format('Y-m-d') }}">
                    </div>
                    <div class="tt-date-fin-preview"></div>
                </div>

                <div class="edit-grid tt-fields-journee" style="display:{{ $tache->isJournee() ? '' : 'none' }};">
                    <div class="edit-full jour-picker" data-initial='@json($tache->jours_choisis ?? [])'>
                        <div class="jp-header">
                            <button type="button" class="jp-nav jp-prev"><i class="bi bi-chevron-left"></i></button>
                            <span class="jp-month-label"></span>
                            <button type="button" class="jp-nav jp-next"><i class="bi bi-chevron-right"></i></button>
                        </div>
                        <div class="jp-grid"></div>
                        <div class="jp-counter"></div>
                    </div>
                    <div class="jp-hidden-inputs"></div>
                </div>

                <div class="edit-grid tt-report-block">
                    <div class="edit-full">
                        <button type="button" class="btn btn-light btn-sm tt-report-toggle" onclick="toggleReportField(this)">
                            <i class="bi bi-pause-circle"></i> {{ $tache->hasReport() ? 'Modifier le report' : 'Reporter cette tâche' }}
                        </button>
                        <div class="tt-report-reveal" style="display:{{ $tache->hasReport() ? '' : 'none' }};">
                            <div>
                                <label class="edit-label">Date de début du report</label>
                                <input type="date" name="date_interruption" lang="fr" class="edit-input tt-date-interruption" value="{{ $tache->date_interruption?->format('Y-m-d') }}">
                            </div>
                            <div>
                                <label class="edit-label">Date de reprise</label>
                                <input type="date" name="date_reprise" lang="fr" class="edit-input tt-date-reprise" value="{{ $tache->date_reprise?->format('Y-m-d') }}">
                            </div>
                            <div class="tt-date-reprise-countdown"></div>
                            @if($tache->hasReport())
                            <button type="button" class="btn btn-light btn-sm" onclick="annulerReport(this)">Annuler le report</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="edit-actions">
                    <button type="button" class="btn btn-light btn-sm" onclick="closeEdit({{ $tache->id }})" data-persist-cancel>Annuler</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteTache({{ $tache->id }})">Supprimer</button>
                    <button type="submit" class="btn btn-accent btn-sm tt-submit-btn">Enregistrer</button>
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
                <div class="tl-phase-row" style="width: {{ $timelineWidth }}px;"></div>
                @foreach($groupe['taches'] as $tache)
                @php
                    $segmentsProjetes = ganttProjeterSegments($tache, $tlStart, $jourWidth);
                @endphp
                <div class="tl-row" style="width: {{ $timelineWidth }}px;">
                    @foreach($jours as $idx => $j)
                    <div class="tl-day-col {{ $j->isWeekend() ? 'weekend' : '' }}" style="left: {{ $idx * $jourWidth }}px; width: {{ $jourWidth }}px;"></div>
                    @endforeach
                    @foreach($segmentsProjetes as $seg)
                        @if($seg['type'] === 'report')
                        <div class="tl-report-gap" style="left: {{ $seg['left'] }}px; width: {{ $seg['width'] }}px;" title="Reporté — reprise prévue le {{ $tache->date_reprise?->format('d/m/Y') }}"></div>
                        @elseif($seg['type'] === 'journee')
                        <div class="tl-journee-block" style="left: {{ $seg['left'] }}px; width: {{ $seg['width'] }}px;" title="{{ $tache->designation }} — {{ round($tache->avancement) }}%"></div>
                        @else
                        <div class="tl-bar" style="left: {{ $seg['left'] }}px; width: {{ $seg['width'] }}px;" title="{{ $tache->designation }} — {{ round($tache->avancement) }}%">
                            <div class="tl-bar-fill" style="width: {{ $seg['fillWidth'] }}px;"></div>
                        </div>
                        @endif
                    @endforeach
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
                <button type="button" class="btn btn-light" onclick="closeModal('addPhaseModal')" data-persist-cancel>Annuler</button>
                <button type="submit" class="btn btn-accent">Créer</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ajouter tâche -->
<div class="modal-overlay" id="addTacheModal">
    <div class="modal" style="width:520px;">
        <h3><i class="bi bi-plus-circle"></i> Nouvelle tâche</h3>
        <form method="POST" action="{{ route('gantt.tache.store', $projet->id) }}" class="tt-root">
            @csrf
            <div class="form-group">
                <label class="form-label">Désignation</label>
                <input type="text" name="designation" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label tt-ct-prevue-label">CT Prévu (H/J)</label>
                <input type="number" name="ct_prevue" class="form-control tt-ct-prevue" step="0.5" min="0" value="0">
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
                <label class="form-label">Consultant(s)</label>
                <div class="consultants-dropdown" data-consultants-dropdown>
                    <button type="button" class="consultants-dropdown-toggle" data-cdt-toggle>
                        <span class="cdt-label cdt-placeholder" data-cdt-label>Sélectionner...</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <div class="consultants-dropdown-panel">
                        <div class="consultants-checklist">
                            @forelse($consultantsProjet as $c)
                            <div class="consultant-check">
                                <input type="checkbox" name="consultant_ids[]" value="{{ $c->id }}" id="add-consultant-{{ $c->id }}" data-cdt-name="{{ $c->nom_complet }}">
                                <label for="add-consultant-{{ $c->id }}">{{ $c->nom_complet }}</label>
                            </div>
                            @empty
                            <div class="consultants-empty">Aucun consultant affecté au projet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Type de tâche</label>
                <div class="type-tache-selector">
                    <label class="type-pill active">
                        <input type="radio" name="type_tache" value="phase" checked>
                        <i class="bi bi-bar-chart-steps"></i> Phase
                    </label>
                    <label class="type-pill">
                        <input type="radio" name="type_tache" value="journee">
                        <i class="bi bi-calendar-week"></i> Journée
                    </label>
                </div>
            </div>

            <div class="tt-fields-phase">
                <div class="form-group">
                    <label class="form-label">Date début</label>
                    <input type="date" name="date_debut" lang="fr" class="form-control tt-date-debut">
                    <div class="tt-date-fin-preview"></div>
                </div>
            </div>

            <div class="tt-fields-journee" style="display:none;">
                <div class="jour-picker" data-initial="[]">
                    <div class="jp-header">
                        <button type="button" class="jp-nav jp-prev"><i class="bi bi-chevron-left"></i></button>
                        <span class="jp-month-label"></span>
                        <button type="button" class="jp-nav jp-next"><i class="bi bi-chevron-right"></i></button>
                    </div>
                    <div class="jp-grid"></div>
                    <div class="jp-counter"></div>
                </div>
                <div class="jp-hidden-inputs"></div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-light" onclick="closeModal('addTacheModal')" data-persist-cancel>Annuler</button>
                <button type="submit" class="btn btn-accent tt-submit-btn">Créer</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Renommer phase -->
<div class="modal-overlay" id="renamePhaseModal">
    <div class="modal">
        <h3><i class="bi bi-pencil"></i> Renommer la phase</h3>
        <form method="POST" id="renamePhaseForm" data-no-persist>
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
        <h3><i class="bi bi-exclamation-triangle" style="color:var(--danger-text);"></i> Confirmation</h3>
        <p id="confirmModalMessage" style="font-size:0.85rem; color:var(--text-muted); margin-bottom:0.5rem;"></p>
        <div class="modal-actions">
            <button type="button" class="btn btn-light" onclick="closeModal('confirmModal')">Annuler</button>
            <button type="button" class="btn btn-danger" id="confirmModalBtn">Supprimer</button>
        </div>
    </div>
</div>
@endif

<script>
// Theme toggle
// localStorage peut lever une SecurityError selon le contexte du navigateur
// (mode privé strict, politique de stockage, etc.) — sans ce try/catch, une
// exception ici arrêtait silencieusement TOUT le reste de ce script (donc
// aussi le sélecteur de type de tâche plus bas).
(function() {
    let saved = 'light';
    try { saved = localStorage.getItem('lmc-theme') || 'light'; } catch (e) {}
    document.documentElement.setAttribute('data-theme', saved);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = saved === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
})();

document.getElementById('themeToggle')?.addEventListener('click', () => {
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', next);
    try { localStorage.setItem('lmc-theme', next); } catch (e) {}
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = next === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
});

function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }

document.querySelectorAll('.modal-overlay').forEach(function (modal) {
    modal.addEventListener('click', function (e) { if (e.target === modal) modal.classList.remove('active'); });
});

function updateConsultantsDropdownLabel(dropdown) {
    const label = dropdown.querySelector('[data-cdt-label]');
    if (!label) return;
    const checked = dropdown.querySelectorAll('input[type="checkbox"]:checked');
    if (checked.length === 0) {
        label.textContent = 'Sélectionner...';
        label.classList.add('cdt-placeholder');
    } else {
        label.textContent = Array.from(checked).map(function (cb) { return cb.dataset.cdtName; }).join(', ');
        label.classList.remove('cdt-placeholder');
    }
}

document.addEventListener('click', function (e) {
    const toggle = e.target.closest('[data-cdt-toggle]');
    if (toggle) {
        const dropdown = toggle.closest('[data-consultants-dropdown]');
        const wasOpen = dropdown.classList.contains('open');
        document.querySelectorAll('.consultants-dropdown.open').forEach(function (d) { d.classList.remove('open'); });
        if (!wasOpen) dropdown.classList.add('open');
        return;
    }
    if (!e.target.closest('[data-consultants-dropdown]')) {
        document.querySelectorAll('.consultants-dropdown.open').forEach(function (d) { d.classList.remove('open'); });
    }
});

document.addEventListener('change', function (e) {
    if (e.target.matches('[data-consultants-dropdown] input[type="checkbox"]')) {
        updateConsultantsDropdownLabel(e.target.closest('[data-consultants-dropdown]'));
    }
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
    if (!timelineBodyScroll) return;

    // Une tâche vient d'être créée/modifiée (voir GanttController) : on centre la
    // timeline sur elle (voir $scrollTargetLeft, calculé côté serveur — milieu de
    // [date_debut, date_fin], y compris pour une tâche en report puisque date_fin
    // est recalculée après la reprise) plutôt que sur "aujourd'hui", sinon une
    // tâche datée dans le passé (ou loin dans le futur) reste hors champ après le
    // scroll par défaut et donne l'impression de ne jamais apparaître dans la
    // timeline.
    const scrollTargetLeft = @json($scrollTargetLeft);
    if (scrollTargetLeft !== null) {
        timelineBodyScroll.scrollLeft = Math.max(0, scrollTargetLeft - timelineBodyScroll.offsetWidth / 2);
        return;
    }

    const todayPosition = {{ $todayPosition ?? 0 }};
    timelineBodyScroll.scrollLeft = Math.max(0, todayPosition - timelineBodyScroll.offsetWidth / 3);
});

// ===== TYPE DE TÂCHE (Phase / Journée / Report) =====

function setGroupVisibility(el, visible) {
    if (!el) return;
    el.style.display = visible ? '' : 'none';
    el.querySelectorAll('input, select, textarea').forEach(function (field) {
        field.disabled = !visible;
    });
}

function applyTypeTacheVisibility(root) {
    const checked = root.querySelector('input[name="type_tache"]:checked');
    const type = checked ? checked.value : 'phase';

    root.querySelectorAll('.type-pill').forEach(function (pill) {
        pill.classList.toggle('active', pill.querySelector('input').value === type);
    });

    const ctLabel = root.querySelector('.tt-ct-prevue-label');
    if (ctLabel) ctLabel.textContent = (type === 'journee') ? 'Nombre de jours' : 'CT Prévu (H/J)';

    setGroupVisibility(root.querySelector('.tt-fields-phase'), type !== 'journee');
    setGroupVisibility(root.querySelector('.tt-fields-journee'), type === 'journee');

    const submitBtn = root.querySelector('.tt-submit-btn');
    if (submitBtn && type === 'journee') {
        const picker = root.querySelector('.jour-picker');
        if (picker && picker._updateCounter) picker._updateCounter();
    } else if (submitBtn) {
        submitBtn.disabled = false;
    }

    updateDateFinPreview(root);
    updateReportRemainingWork(root);
    updateEcartDisplay(root);
}

// Compare une date cible à aujourd'hui : "X jours restants" ou "En retard de X jours".
function formatCountdown(targetDate) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const t = new Date(targetDate);
    t.setHours(0, 0, 0, 0);
    const diffDays = Math.round((t - today) / 86400000);

    if (diffDays < 0) {
        const n = Math.abs(diffDays);
        return { text: 'En retard de ' + n + ' jour' + (n > 1 ? 's' : ''), late: true };
    }
    return { text: diffDays + ' jour' + (diffDays > 1 ? 's' : '') + ' restant' + (diffDays > 1 ? 's' : ''), late: false };
}

function countdownHtml(cd) {
    return '<span class="' + (cd.late ? 'tt-countdown-late' : 'tt-countdown-ok') + '">' + cd.text + '</span>';
}

function updateDateFinPreview(root) {
    const preview = root.querySelector('.tt-date-fin-preview');
    if (!preview) return;
    const checked = root.querySelector('input[name="type_tache"]:checked');
    const type = checked ? checked.value : 'phase';
    if (type === 'journee') { preview.innerHTML = ''; return; }

    // Une fois un report actif, la vraie date de fin dépend du report (calculée
    // côté serveur à partir de la date de reprise + jours restants), pas de ce
    // calcul naïf date_debut + CT Prévu — l'afficher quand même produisait un
    // "jours restants" incohérent avec celui du bloc report (bug constaté).
    const dateRepriseInput = root.querySelector('.tt-date-reprise');
    if (dateRepriseInput && dateRepriseInput.value) { preview.innerHTML = ''; return; }

    const dateInput = root.querySelector('.tt-date-debut');
    const ctInput = root.querySelector('.tt-ct-prevue');
    if (!dateInput || !ctInput || !dateInput.value || !ctInput.value) { preview.innerHTML = ''; return; }

    const start = new Date(dateInput.value + 'T00:00:00');
    let restants = Math.max(0, Math.ceil(parseFloat(ctInput.value) || 0) - 1);
    const d = new Date(start);
    while (restants > 0) {
        d.setDate(d.getDate() + 1);
        if (d.getDay() !== 0 && d.getDay() !== 6) restants--;
    }
    preview.innerHTML = 'Fin calculée (jours ouvrés) : ' + d.toLocaleDateString('fr-FR') + ' — ' + countdownHtml(formatCountdown(d));
}

// "Jours restants" pour une tâche Report = CT Prévu − CT Réalisé (travail qu'il
// reste réellement à faire), PAS un compte à rebours calendaire jusqu'à la date
// de reprise — la date de reprise dit QUAND on reprend, pas COMBIEN il reste à faire.
function updateReportRemainingWork(root) {
    const el = root.querySelector('.tt-date-reprise-countdown');
    if (!el) return;

    // Report est un état orthogonal au type — le compteur ne dépend que de la
    // présence d'une date de reprise saisie, pas du type de tâche (phase/journée).
    const dateRepriseInput = root.querySelector('.tt-date-reprise');
    if (!dateRepriseInput || !dateRepriseInput.value) { el.innerHTML = ''; return; }

    const ctPrevueInput = root.querySelector('.tt-ct-prevue');
    const ctRealiseeInput = root.querySelector('.tt-ct-realisee');
    if (!ctPrevueInput || !ctRealiseeInput) { el.innerHTML = ''; return; }

    const ctPrevue = parseFloat(ctPrevueInput.value) || 0;
    const ctRealisee = parseFloat(ctRealiseeInput.value) || 0;
    const restant = Math.round((ctPrevue - ctRealisee) * 10) / 10;

    if (restant > 0) {
        el.innerHTML = '<span class="tt-countdown-ok">' + restant + ' jour' + (restant > 1 ? 's' : '') + ' de travail restant' + (restant > 1 ? 's' : '') + '</span>';
    } else if (restant === 0) {
        el.innerHTML = '<span class="tt-countdown-ok">Travail prévu complété</span>';
    } else {
        el.innerHTML = '<span class="tt-countdown-late">Dépassement de ' + Math.abs(restant) + ' jour' + (Math.abs(restant) > 1 ? 's' : '') + '</span>';
    }
}

// Écart = CT Prévu - CT Réalisé. Négatif = dépassement (rouge), sinon neutre.
function updateEcartDisplay(root) {
    const el = root.querySelector('.tt-ecart-display');
    if (!el) return;

    const ctPrevueInput = root.querySelector('.tt-ct-prevue');
    const ctRealiseeInput = root.querySelector('.tt-ct-realisee');
    if (!ctPrevueInput || !ctRealiseeInput) return;

    const ecart = Math.round(((parseFloat(ctPrevueInput.value) || 0) - (parseFloat(ctRealiseeInput.value) || 0)) * 10) / 10;

    el.textContent = ecart.toFixed(1);
    el.classList.toggle('ecart-neg', ecart < 0);
    el.classList.toggle('ecart-zero', ecart >= 0);
}

function initJourPicker(root) {
    const picker = root.querySelector('.jour-picker');
    if (!picker) return;

    const nbInput = root.querySelector('.tt-ct-prevue');
    const monthLabel = picker.querySelector('.jp-month-label');
    const grid = picker.querySelector('.jp-grid');
    const counter = picker.querySelector('.jp-counter');
    // .jp-hidden-inputs est un frère de .jour-picker (pas un descendant) : chercher
    // depuis root, pas depuis picker (c'était le 2e bug — le calendrier ne crashait
    // qu'à l'initialisation, silencieusement, faute de ce conteneur trouvé).
    const hiddenWrap = root.querySelector('.jp-hidden-inputs');
    const submitBtn = root.querySelector('.tt-submit-btn');

    let initial = [];
    try { initial = JSON.parse(picker.dataset.initial || '[]'); } catch (e) { initial = []; }
    const selected = new Set(initial);

    let viewDate = selected.size
        ? new Date(Array.from(selected).sort()[0] + 'T00:00:00')
        : new Date();
    viewDate.setDate(1);

    function pad(n) { return String(n).padStart(2, '0'); }
    function iso(d) { return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()); }

    function syncHiddenInputs() {
        hiddenWrap.innerHTML = '';
        Array.from(selected).sort().forEach(function (d) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'jours[]';
            input.value = d;
            hiddenWrap.appendChild(input);
        });
    }

    function updateCounter() {
        const needed = parseInt((nbInput && nbInput.value) || '0', 10) || 0;
        // Report actif = les jours restants seront choisis plus tard, après la
        // reprise — on ne bloque plus sur l'égalité stricte, juste sur le dépassement.
        const dateRepriseInput = root.querySelector('.tt-date-reprise');
        const hasReport = !!(dateRepriseInput && dateRepriseInput.value);
        const ok = hasReport ? (selected.size <= needed) : (selected.size === needed);
        counter.textContent = selected.size + ' / ' + needed + ' jour' + (needed > 1 ? 's' : '') + ' sélectionné' + (selected.size > 1 ? 's' : '');
        counter.classList.toggle('jp-counter-ok', ok);
        counter.classList.toggle('jp-counter-bad', !ok);

        const currentType = root.querySelector('input[name="type_tache"]:checked');
        if (submitBtn && currentType && currentType.value === 'journee') {
            submitBtn.disabled = !ok;
        }
    }
    picker._updateCounter = updateCounter;

    function toggleDay(key) {
        if (selected.has(key)) selected.delete(key);
        else selected.add(key);
        syncHiddenInputs();
        render();
    }

    function render() {
        monthLabel.textContent = viewDate.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' });
        grid.innerHTML = '';

        ['L', 'M', 'M', 'J', 'V', 'S', 'D'].forEach(function (d) {
            const el = document.createElement('span');
            el.className = 'jp-dow';
            el.textContent = d;
            grid.appendChild(el);
        });

        const year = viewDate.getFullYear(), month = viewDate.getMonth();
        const first = new Date(year, month, 1);
        const startOffset = (first.getDay() + 6) % 7; // lundi = 0
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < startOffset; i++) grid.appendChild(document.createElement('span'));

        for (let d = 1; d <= daysInMonth; d++) {
            const cellDate = new Date(year, month, d);
            const key = iso(cellDate);
            const btn = document.createElement('button');
            btn.type = 'button';
            const isWeekend = cellDate.getDay() === 0 || cellDate.getDay() === 6;
            btn.className = 'jp-day' + (selected.has(key) ? ' selected' : '') + (isWeekend ? ' weekend' : '');
            btn.textContent = String(d);
            btn.addEventListener('click', function () { toggleDay(key); });
            grid.appendChild(btn);
        }

        updateCounter();
    }

    picker.querySelector('.jp-prev').addEventListener('click', function () { viewDate.setMonth(viewDate.getMonth() - 1); render(); });
    picker.querySelector('.jp-next').addEventListener('click', function () { viewDate.setMonth(viewDate.getMonth() + 1); render(); });
    if (nbInput) nbInput.addEventListener('input', updateCounter);

    syncHiddenInputs();
    render();
}

function initTypeTacheUI(root) {
    if (!root || root._ttInitialized) return;
    root._ttInitialized = true;

    root.querySelectorAll('.type-pill').forEach(function (pill) {
        pill.addEventListener('click', function () {
            const input = pill.querySelector('input');
            input.checked = true;
            applyTypeTacheVisibility(root);
        });
    });

    root.querySelectorAll('.tt-date-debut, .tt-ct-prevue').forEach(function (field) {
        field.addEventListener('input', function () {
            updateDateFinPreview(root);
            updateReportRemainingWork(root);
            updateEcartDisplay(root);
        });
    });

    const ctRealiseeInput = root.querySelector('.tt-ct-realisee');
    if (ctRealiseeInput) {
        ctRealiseeInput.addEventListener('input', function () {
            updateReportRemainingWork(root);
            updateEcartDisplay(root);
        });
    }

    const dateRepriseInput = root.querySelector('.tt-date-reprise');
    if (dateRepriseInput) {
        dateRepriseInput.addEventListener('input', function () {
            updateReportRemainingWork(root);
            updateDateFinPreview(root);
            refreshJourPickerCounter(root);
        });
    }

    initJourPicker(root);
    applyTypeTacheVisibility(root);
}

// Le compteur "X / CT Prévu jours sélectionnés" (type Journée) tolère un compte
// partiel tant qu'un report est actif — le recalculer quand l'état du report change.
function refreshJourPickerCounter(root) {
    const picker = root.querySelector('.jour-picker');
    if (picker && picker._updateCounter) picker._updateCounter();
}

// "Reporter cette tâche" / "Modifier le report" : révèle les 2 champs de dates manuels.
function toggleReportField(btn) {
    const reveal = btn.parentElement.querySelector('.tt-report-reveal');
    if (!reveal) return;
    reveal.style.display = (reveal.style.display === 'none') ? '' : 'none';
    const root = btn.closest('.tt-root');
    updateDateFinPreview(root);
    refreshJourPickerCounter(root);
}

// "Annuler le report" : vide les 2 champs — la sauvegarde (bouton Enregistrer)
// effacera alors date_reprise ET date_interruption côté serveur.
function annulerReport(btn) {
    const reveal = btn.closest('.tt-report-reveal');
    const dateRepriseInput = reveal ? reveal.querySelector('.tt-date-reprise') : null;
    const dateInterruptionInput = reveal ? reveal.querySelector('.tt-date-interruption') : null;
    if (!dateRepriseInput) return;
    dateRepriseInput.value = '';
    if (dateInterruptionInput) dateInterruptionInput.value = '';
    const root = dateRepriseInput.closest('.tt-root');
    updateReportRemainingWork(root);
    updateDateFinPreview(root);
    refreshJourPickerCounter(root);
}

document.querySelectorAll('.tt-root').forEach(initTypeTacheUI);

@if($errors->any() && old('_tache_id'))
// Une soumission (report, etc.) a échoué la validation — rouvre le panneau
// d'édition de la tâche concernée, sinon le message d'erreur ci-dessus n'a
// aucun panneau visible pour s'y rattacher.
toggleEdit({{ (int) old('_tache_id') }});
document.getElementById('row-{{ (int) old('_tache_id') }}')?.scrollIntoView({ block: 'center' });
@endif
</script>

</body>
</html>
