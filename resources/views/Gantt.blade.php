<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gantt — {{ $projet->nom_client }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{--bg:#f1f5f9;--surface:#fff;--surface2:#f8fafc;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--muted:#94a3b8;--accent:#3b82f6;--shadow:0 2px 12px rgba(0,0,0,.06);}
        [data-theme="dark"]{--bg:#0f172a;--surface:#1e293b;--surface2:#162032;--border:#334155;--text:#e2e8f0;--text2:#94a3b8;--muted:#64748b;--accent:#3b82f6;--shadow:0 2px 12px rgba(0,0,0,.3);}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;}

        /* HEADER */
        .site-header{background:#0f172a;padding:18px 32px 0;border-bottom:2px solid #1e3a5f;}
        .header-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;}
        .logo{font-size:20px;font-weight:700;color:#fff;}
        .logo-sub{font-size:12px;color:#64748b;margin-top:2px;}
        .hbtns{display:flex;align-items:center;gap:8px;}
        .hbtn{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#94a3b8;height:34px;border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;font-family:'Inter',sans-serif;font-weight:500;padding:0 14px;gap:6px;text-decoration:none;transition:all .2s;}
        .hbtn:hover{background:rgba(255,255,255,.12);color:#fff;}
        .hbtn.icon{width:34px;padding:0;}
        .nav-wrap{display:flex;gap:4px;}
        .nav-item{padding:9px 18px;border-radius:8px 8px 0 0;font-size:13px;font-weight:500;color:#64748b;text-decoration:none;display:flex;align-items:center;gap:7px;transition:all .2s;border:1px solid transparent;border-bottom:none;}
        .nav-item:hover{color:#cbd5e1;background:rgba(255,255,255,.04);}
        .nav-item.active{background:var(--bg);color:var(--text);border-color:#334155;border-bottom-color:var(--bg);}

        /* PAGE */
        .page{max-width:1400px;margin:0 auto;padding:28px 32px;}

        /* STATS */
        .stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;}
        .sc{background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:18px 20px;box-shadow:var(--shadow);display:flex;align-items:center;gap:14px;}
        .sc-icon{width:42px;height:42px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
        .sc-icon.blue{background:rgba(59,130,246,.12);color:#3b82f6;}
        .sc-icon.green{background:rgba(34,197,94,.12);color:#22c55e;}
        .sc-icon.yellow{background:rgba(234,179,8,.12);color:#eab308;}
        .sc-icon.red{background:rgba(239,68,68,.12);color:#ef4444;}
        .sc-lbl{font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);}
        .sc-val{font-size:22px;font-weight:700;color:var(--text);line-height:1.2;}

        /* TOOLBAR */
        .toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;gap:12px;}
        .toolbar-left{display:flex;align-items:center;gap:10px;}
        .page-title{font-size:18px;font-weight:700;}
        .page-sub{font-size:12px;color:var(--muted);margin-top:2px;}
        .btn{display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:9px;font-size:13px;font-family:'Inter',sans-serif;font-weight:500;cursor:pointer;border:none;transition:all .18s;text-decoration:none;}
        .btn-primary{background:#3b82f6;color:#fff;}
        .btn-primary:hover{background:#2563eb;}
        .btn-ghost{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
        .btn-ghost:hover{border-color:var(--accent);color:var(--accent);}
        .btn-success{background:rgba(34,197,94,.1);color:#22c55e;border:1px solid rgba(34,197,94,.2);}
        .btn-success:hover{background:rgba(34,197,94,.2);}
        .btn-sm{padding:6px 12px;font-size:12px;}

        /* ALERTS */
        .alert{border-radius:10px;padding:11px 15px;font-size:13px;display:flex;align-items:center;gap:8px;margin-bottom:20px;}
        .alert-s{background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);color:#16a34a;}
        .alert-e{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#ef4444;}

        /* UPLOAD CARD */
        .upload-card{background:var(--surface);border:2px dashed var(--border);border-radius:14px;padding:28px;text-align:center;margin-bottom:24px;transition:border-color .2s;}
        .upload-card:hover{border-color:var(--accent);}
        .upload-card i{font-size:32px;color:var(--muted);display:block;margin-bottom:10px;}
        .upload-card p{font-size:13px;color:var(--text2);margin-bottom:14px;}

        /* GANTT CHART */
        .gantt-wrap{background:var(--surface);border:1px solid var(--border);border-radius:14px;overflow:hidden;box-shadow:var(--shadow);margin-bottom:24px;}
        .gantt-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
        .gantt-title{font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;}
        .gantt-title i{color:var(--accent);}

        /* Timeline */
        .gantt-container{overflow-x:auto;}
        .gantt-grid{display:grid;min-width:900px;}
        .gantt-row{display:grid;grid-template-columns:40px 200px 80px 80px 80px 80px 1fr;border-bottom:1px solid var(--border);align-items:center;min-height:44px;}
        .gantt-row:last-child{border-bottom:none;}
        .gantt-row.header{background:var(--surface2);font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);}
        .gantt-row:hover:not(.header){background:var(--surface2);}
        .gc{padding:8px 12px;font-size:12px;}
        .gc.num{color:var(--muted);font-weight:600;text-align:center;}
        .gc.name{font-weight:500;color:var(--text);}
        .gc.resp{color:var(--muted);font-size:11px;}
        .gc.num-cell{text-align:center;}
        .gc.retard{color:#ef4444;font-weight:600;}
        .gc.ok{color:#22c55e;font-weight:600;}

        /* Barre Gantt */
        .gantt-bar-wrap{padding:6px 12px;position:relative;min-width:200px;}
        .gantt-bar-bg{height:8px;background:var(--border);border-radius:4px;position:relative;overflow:visible;}
        .gantt-bar-prevue{height:8px;border-radius:4px;background:linear-gradient(90deg,#3b82f6,#8b5cf6);position:absolute;top:0;left:0;}
        .gantt-bar-realisee{height:5px;border-radius:3px;background:linear-gradient(90deg,#22c55e,#10b981);position:absolute;top:1.5px;left:0;opacity:.9;}
        .gantt-bar-realisee.over{background:linear-gradient(90deg,#ef4444,#f97316);}
        .gantt-dates{display:flex;justify-content:space-between;font-size:10px;color:var(--muted);margin-top:4px;}

        /* Alerte badge */
        .badge-retard{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;background:rgba(239,68,68,.1);color:#ef4444;border:1px solid rgba(239,68,68,.2);}
        .badge-ok{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;background:rgba(34,197,94,.1);color:#22c55e;border:1px solid rgba(34,197,94,.2);}
        .badge-nd{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;background:var(--surface2);color:var(--muted);border:1px solid var(--border);}

        /* TABLEAU */
        .table-wrap{background:var(--surface);border:1px solid var(--border);border-radius:14px;overflow:hidden;box-shadow:var(--shadow);}
        table{width:100%;border-collapse:collapse;}
        thead th{background:var(--surface2);color:var(--muted);font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;padding:10px 14px;border-bottom:1px solid var(--border);text-align:left;white-space:nowrap;}
        tbody td{padding:10px 14px;border-bottom:1px solid var(--border);font-size:12px;vertical-align:middle;}
        tbody tr:last-child td{border-bottom:none;}
        tbody tr:hover td{background:var(--surface2);}

        /* MODAL */
        .ov{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);backdrop-filter:blur(4px);z-index:1000;align-items:center;justify-content:center;}
        .ov.open{display:flex;}
        .modal{background:var(--surface);border:1px solid var(--border);border-radius:14px;width:100%;max-width:520px;padding:26px;box-shadow:0 20px 60px rgba(0,0,0,.25);animation:mIn .2s ease both;max-height:90vh;overflow-y:auto;}
        @keyframes mIn{from{opacity:0;transform:scale(.96)}to{opacity:1;transform:scale(1)}}
        .modal-title{font-size:15px;font-weight:700;margin-bottom:4px;}
        .modal-sub{font-size:12px;color:var(--text2);margin-bottom:20px;}
        .modal-actions{display:flex;gap:8px;justify-content:flex-end;margin-top:20px;}
        .fg{margin-bottom:14px;}
        .fl{display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.07em;color:var(--text2);margin-bottom:5px;}
        .fc{width:100%;background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:8px 12px;font-size:13px;font-family:'Inter',sans-serif;color:var(--text);outline:none;transition:border-color .2s;}
        .fc:focus{border-color:var(--accent);}
        .row2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}

        /* EMPTY */
        .empty{text-align:center;padding:60px 24px;color:var(--muted);}
        .empty i{font-size:40px;opacity:.3;display:block;margin-bottom:10px;}

        /* Avancement bar inline */
        .av-bar{height:4px;background:var(--border);border-radius:2px;overflow:hidden;margin-top:3px;}
        .av-fill{height:100%;border-radius:2px;background:linear-gradient(90deg,#3b82f6,#8b5cf6);}
    </style>
</head>
<body>
<script>(function(){const t=localStorage.getItem('lmc-theme')||'dark';document.documentElement.setAttribute('data-theme',t);})();</script>

<header class="site-header">
    <div class="header-top">
        <div>
            <div class="logo">{{ $projet->reference_projet }} — {{ $projet->nom_client }}</div>
            <div class="logo-sub">Planning Gantt · Chef: {{ $projet->chef_nom ?? '—' }}</div>
        </div>
        <div class="hbtns">
            <a href="/projet/{{ $projet->id }}" class="hbtn"><i class="bi bi-arrow-left"></i> Détails</a>
            <a href="/" class="hbtn"><i class="bi bi-grid"></i> Données</a>
            <button class="hbtn icon" id="themeToggle"><i class="bi bi-sun-fill" id="themeIcon"></i></button>
        </div>
    </div>
    <nav class="nav-wrap">
        <a href="/" class="nav-item"><i class="bi bi-grid-fill"></i> Données</a>
        <a href="/tableau-de-bord" class="nav-item"><i class="bi bi-bar-chart-fill"></i> Tableau de Bord</a>
        <a href="/projet/{{ $projet->id }}" class="nav-item"><i class="bi bi-info-circle-fill"></i> Détails</a>
        <a href="/projet/{{ $projet->id }}/gantt" class="nav-item active"><i class="bi bi-bar-chart-steps"></i> Gantt</a>
        @if(auth()->user()->hasPermission('modifier_projets'))
        <a href="/projet/{{ $projet->id }}/edit" class="nav-item"><i class="bi bi-pencil-fill"></i> Modifier</a>
        @endif
    </nav>
</header>

<div class="page">

    @if(session('success'))
    <div class="alert alert-s"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-e"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    @endif

    {{-- STATS --}}
    <div class="stats">
        <div class="sc">
            <div class="sc-icon blue"><i class="bi bi-list-task"></i></div>
            <div><div class="sc-lbl">Tâches</div><div class="sc-val">{{ count($taches) }}</div></div>
        </div>
        <div class="sc">
            <div class="sc-icon yellow"><i class="bi bi-clock-fill"></i></div>
            <div><div class="sc-lbl">CT Prévue</div><div class="sc-val">{{ $totalPrevus }} j</div></div>
        </div>
        <div class="sc">
            <div class="sc-icon green"><i class="bi bi-check2-circle"></i></div>
            <div><div class="sc-lbl">CT Réalisée</div><div class="sc-val">{{ $totalRealises }} j</div></div>
        </div>
        <div class="sc">
            <div class="sc-icon red"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div><div class="sc-lbl">En retard</div><div class="sc-val">{{ $enRetard }}</div></div>
        </div>
    </div>

    {{-- UPLOAD --}}
    @if(auth()->user()->hasPermission('modifier_projets'))
    <div class="upload-card">
        <i class="bi bi-file-earmark-excel-fill" style="color:#22c55e;"></i>
        <p>Importez votre fichier Excel Gantt (même format que le canevas LMC)</p>
        <form method="POST" action="/projet/{{ $projet->id }}/gantt/upload" enctype="multipart/form-data" style="display:inline-flex;gap:10px;align-items:center;justify-content:center;">
            @csrf
            <input type="file" name="fichier" accept=".xlsx,.xls" style="font-size:13px;color:var(--text2);">
            <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-upload"></i> Importer</button>
        </form>
    </div>
    @endif

    {{-- TOOLBAR --}}
    <div class="toolbar">
        <div class="toolbar-left">
            <div>
                <div class="page-title"><i class="bi bi-bar-chart-steps" style="color:var(--accent);margin-right:6px;"></i>Planning Gantt</div>
                <div class="page-sub">Vue timeline — barres bleues = prévues · vertes = réalisées · rouges = dépassement</div>
            </div>
        </div>
        @if(auth()->user()->hasPermission('modifier_projets'))
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('addOv').classList.add('open')">
            <i class="bi bi-plus-lg"></i> Ajouter tâche
        </button>
        @endif
    </div>

    @if(count($taches) === 0)
    <div class="gantt-wrap">
        <div class="empty">
            <i class="bi bi-bar-chart-steps"></i>
            <p style="font-size:14px;font-weight:600;color:var(--text2);margin-bottom:6px;">Aucune tâche planifiée</p>
            <p style="font-size:12px;">Importez un fichier Excel ou ajoutez des tâches manuellement</p>
        </div>
    </div>
    @else

    {{-- GANTT CHART --}}
    @php
        $allDates = collect($taches)->filter(fn($t) => $t->date_debut)->map(fn($t) => \Carbon\Carbon::parse($t->date_debut));
        $allFins  = collect($taches)->filter(fn($t) => $t->date_fin_calculee ?? $t->date_fin_initiale)
                     ->map(fn($t) => \Carbon\Carbon::parse($t->date_fin_calculee ?? $t->date_fin_initiale));
        $minDate  = $allDates->min() ?? now();
        $maxDate  = $allFins->max() ?? now()->addMonths(3);
        $totalDays = max(1, $minDate->diffInDays($maxDate));
    @endphp

    <div class="gantt-wrap">
        <div class="gantt-header">
            <div class="gantt-title"><i class="bi bi-diagram-3-fill"></i> Timeline</div>
            <div style="font-size:11px;color:var(--muted);">
                {{ \Carbon\Carbon::parse($minDate)->format('d/m/Y') }} →
                {{ \Carbon\Carbon::parse($maxDate)->format('d/m/Y') }}
                ({{ $totalDays }} jours)
            </div>
        </div>
        <div class="gantt-container">
            <div class="gantt-grid">
                {{-- Header --}}
                <div class="gantt-row header">
                    <div class="gc num-cell">#</div>
                    <div class="gc">Désignation</div>
                    <div class="gc">CT Prév.</div>
                    <div class="gc">CT Réal.</div>
                    <div class="gc">Écart</div>
                    <div class="gc">Statut</div>
                    <div class="gc">Timeline</div>
                </div>
                {{-- Rows --}}
                @foreach($taches as $t)
                @php
                    $ecart  = $t->ct_realisee - $t->ct_prevue;
                    $isOver = $ecart > 0 && $t->ct_prevue > 0;
                    $avPct  = round($t->avancement * 100);

                    // Bar positions
                    $barLeft  = 0;
                    $barWidth = 0;
                    $realWidth = 0;

                    if ($t->date_debut && $totalDays > 0) {
                        $start = \Carbon\Carbon::parse($t->date_debut);
                        $end   = $t->date_fin_calculee
                            ? \Carbon\Carbon::parse($t->date_fin_calculee)
                            : $start->copy()->addDays($t->delai_jours);
                        $barLeft  = round(max(0, $minDate->diffInDays($start)) / $totalDays * 100, 1);
                        $barWidth = round(max(1, $start->diffInDays($end)) / $totalDays * 100, 1);
                        $realWidth = round($barWidth * $t->avancement, 1);
                    }
                @endphp
                <div class="gantt-row">
                    <div class="gc num">{{ $t->numero }}</div>
                    <div class="gc name">
                        {{ $t->designation }}
                        @if($t->responsable)
                        <div style="font-size:10px;color:var(--muted);margin-top:2px;">{{ Str::limit($t->responsable, 30) }}</div>
                        @endif
                    </div>
                    <div class="gc">{{ $t->ct_prevue > 0 ? $t->ct_prevue.' j' : '—' }}</div>
                    <div class="gc {{ $isOver ? 'retard' : ($t->ct_realisee > 0 ? 'ok' : '') }}">
                        {{ $t->ct_realisee > 0 ? $t->ct_realisee.' j' : '—' }}
                    </div>
                    <div class="gc {{ $isOver ? 'retard' : 'ok' }}">
                        {{ $t->ct_prevue > 0 ? ($ecart > 0 ? '+'.$ecart : ($ecart < 0 ? $ecart : '=')) : '—' }}
                    </div>
                    <div class="gc">
                        @if($isOver)
                            <span class="badge-retard"><i class="bi bi-exclamation-triangle-fill"></i> Retard</span>
                        @elseif($avPct >= 100)
                            <span class="badge-ok"><i class="bi bi-check-circle-fill"></i> Terminé</span>
                        @elseif($avPct > 0)
                            <span class="badge-nd"><i class="bi bi-clock"></i> {{ $avPct }}%</span>
                        @else
                            <span class="badge-nd">— N/A</span>
                        @endif
                    </div>
                    <div class="gantt-bar-wrap">
                        @if($barWidth > 0)
                        <div class="gantt-bar-bg" style="position:relative;height:8px;background:var(--border);border-radius:4px;">
                            {{-- Barre prévue --}}
                            <div class="gantt-bar-prevue" style="left:{{ $barLeft }}%;width:{{ $barWidth }}%;"></div>
                            {{-- Barre réalisée --}}
                            @if($realWidth > 0)
                            <div class="gantt-bar-realisee {{ $isOver ? 'over' : '' }}"
                                 style="left:{{ $barLeft }}%;width:{{ min($realWidth, $barLeft + $barWidth) }}%;top:1.5px;"></div>
                            @endif
                        </div>
                        <div class="gantt-dates">
                            <span>{{ $t->date_debut ? \Carbon\Carbon::parse($t->date_debut)->format('d/m') : '' }}</span>
                            <span>{{ ($t->date_fin_calculee ?? $t->date_fin_initiale) ? \Carbon\Carbon::parse($t->date_fin_calculee ?? $t->date_fin_initiale)->format('d/m') : '' }}</span>
                        </div>
                        @else
                        <span style="font-size:11px;color:var(--muted);">Dates non définies</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- TABLEAU DÉTAILLÉ --}}
    <div class="table-wrap">
        <div class="gantt-header">
            <div class="gantt-title"><i class="bi bi-table"></i> Tableau détaillé</div>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Désignation</th>
                        <th>Responsable</th>
                        <th>CT Prévue</th>
                        <th>CT Réalisée</th>
                        <th>Avancement</th>
                        <th>Début</th>
                        <th>Délai</th>
                        <th>Fin Initiale</th>
                        <th>Fin Calculée</th>
                        <th>Statut</th>
                        @if(auth()->user()->hasPermission('modifier_projets'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($taches as $t)
                    @php
                        $ecart  = $t->ct_realisee - $t->ct_prevue;
                        $isOver = $ecart > 0 && $t->ct_prevue > 0;
                        $avPct  = round($t->avancement * 100);
                    @endphp
                    <tr>
                        <td style="color:var(--muted);font-weight:600;">{{ $t->numero }}</td>
                        <td style="font-weight:500;">{{ $t->designation }}</td>
                        <td style="font-size:11px;color:var(--muted);">{{ $t->responsable ?? '—' }}</td>
                        <td>{{ $t->ct_prevue > 0 ? $t->ct_prevue.' j' : '—' }}</td>
                        <td style="color:{{ $isOver ? '#ef4444' : '#22c55e' }};font-weight:{{ $t->ct_realisee > 0 ? '600' : '400' }}">
                            {{ $t->ct_realisee > 0 ? $t->ct_realisee.' j' : '—' }}
                        </td>
                        <td>
                            <div style="font-size:11px;font-weight:600;color:var(--text2);">{{ $avPct }}%</div>
                            <div class="av-bar" style="width:80px;">
                                <div class="av-fill" style="width:{{ $avPct }}%;"></div>
                            </div>
                        </td>
                        <td>{{ $t->date_debut ? \Carbon\Carbon::parse($t->date_debut)->format('d/m/Y') : '—' }}</td>
                        <td>{{ $t->delai_jours }} j</td>
                        <td style="font-size:11px;">{{ $t->date_fin_initiale ? \Carbon\Carbon::parse($t->date_fin_initiale)->format('d/m/Y') : '—' }}</td>
                        <td style="font-size:11px;">{{ $t->date_fin_calculee ? \Carbon\Carbon::parse($t->date_fin_calculee)->format('d/m/Y') : '—' }}</td>
                        <td>
                            @if($isOver)
                                <span class="badge-retard"><i class="bi bi-exclamation-triangle-fill"></i> Retard +{{ $ecart }}j</span>
                            @elseif($avPct >= 100)
                                <span class="badge-ok"><i class="bi bi-check-circle-fill"></i> Terminé</span>
                            @elseif($avPct > 0)
                                <span class="badge-nd">En cours</span>
                            @else
                                <span class="badge-nd">Non démarré</span>
                            @endif
                        </td>
                        @if(auth()->user()->hasPermission('modifier_projets'))
                        <td>
                            <form method="POST" action="/projet/{{ $projet->id }}/gantt/tache/{{ $t->id }}" style="margin:0;" onsubmit="return confirm('Supprimer cette tâche ?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;color:#ef4444;cursor:pointer;font-size:13px;padding:4px;" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

{{-- ADD MODAL --}}
<div class="ov" id="addOv">
    <div class="modal">
        <div class="modal-title"><i class="bi bi-plus-circle-fill" style="color:var(--accent);margin-right:6px;"></i>Ajouter une tâche</div>
        <div class="modal-sub">Ajoutez manuellement une tâche au planning</div>
        <form method="POST" action="/projet/{{ $projet->id }}/gantt/tache">
            @csrf
            <div class="fg">
                <label class="fl">Désignation *</label>
                <input type="text" name="designation" class="fc" placeholder="Ex: Réunion de lancement" required>
            </div>
            <div class="row2">
                <div class="fg">
                    <label class="fl">CT Prévue (j)</label>
                    <input type="number" name="ct_prevue" class="fc" placeholder="0" step="0.5" min="0">
                </div>
                <div class="fg">
                    <label class="fl">CT Réalisée (j)</label>
                    <input type="number" name="ct_realisee" class="fc" placeholder="0" step="0.5" min="0">
                </div>
            </div>
            <div class="fg">
                <label class="fl">Responsable</label>
                <input type="text" name="responsable" class="fc" placeholder="Ex: Client / LMC">
            </div>
            <div class="row2">
                <div class="fg">
                    <label class="fl">Date début</label>
                    <input type="date" name="date_debut" class="fc">
                </div>
                <div class="fg">
                    <label class="fl">Délai (jours)</label>
                    <input type="number" name="delai_jours" class="fc" placeholder="1" min="1" value="1">
                </div>
            </div>
            <div class="row2">
                <div class="fg">
                    <label class="fl">Fin initiale</label>
                    <input type="date" name="date_fin_initiale" class="fc">
                </div>
                <div class="fg">
                    <label class="fl">Avancement (%)</label>
                    <input type="number" name="avancement" class="fc" placeholder="0" min="0" max="100" value="0">
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('addOv').classList.remove('open')">Annuler</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Ajouter</button>
            </div>
        </form>
    </div>
</div>

<script>
// Theme
const ti=document.getElementById('themeIcon');
function applyTheme(t){document.documentElement.setAttribute('data-theme',t);localStorage.setItem('lmc-theme',t);ti.className=t==='dark'?'bi bi-sun-fill':'bi bi-moon-fill';}
applyTheme(localStorage.getItem('lmc-theme')||'dark');
document.getElementById('themeToggle').addEventListener('click',()=>applyTheme(document.documentElement.getAttribute('data-theme')==='dark'?'light':'dark'));
// Close modal on backdrop
document.querySelectorAll('.ov').forEach(o=>o.addEventListener('click',e=>{if(e.target===o)o.classList.remove('open');}));
</script>
</body>
</html>