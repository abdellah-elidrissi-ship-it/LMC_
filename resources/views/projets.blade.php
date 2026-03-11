<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMC Conseil - Données</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        [data-theme="light"] {
            --bg:         #f1f5f9;
            --surface:    #ffffff;
            --surface2:   #f8fafc;
            --border:     #e2e8f0;
            --text:       #0f172a;
            --text2:      #475569;
            --muted:      #94a3b8;
            --accent:     #3b82f6;
            --header-bg:  linear-gradient(135deg, #0f172a, #1e293b);
            --nav-bg:     rgba(255,255,255,0.1);
            --shadow:     0 2px 12px rgba(0,0,0,0.06);
            --shadow-md:  0 4px 20px rgba(0,0,0,0.08);
        }

        [data-theme="dark"] {
            --bg:         #0f172a;
            --surface:    #1e293b;
            --surface2:   #162032;
            --border:     #334155;
            --text:       #e2e8f0;
            --text2:      #94a3b8;
            --muted:      #64748b;
            --accent:     #3b82f6;
            --header-bg:  linear-gradient(135deg, #020817, #0f172a);
            --nav-bg:     rgba(255,255,255,0.05);
            --shadow:     0 2px 12px rgba(0,0,0,0.3);
            --shadow-md:  0 4px 20px rgba(0,0,0,0.4);
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            transition: background .3s, color .3s;
        }

        .site-header {
            background: var(--header-bg);
            padding: 1rem 0;
            border-bottom: 3px solid #3b82f6;
        }

        .logo { font-size:1.3rem; font-weight:700; color:white; }
        .logo-sub { font-size:.73rem; color:rgba(255,255,255,.4); margin-top:.1rem; }

        .meta-pill {
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.1);
            color:rgba(255,255,255,.5);
            padding:.28rem .8rem; border-radius:50px; font-size:.73rem;
        }

        .theme-btn {
            width:34px; height:34px; border-radius:50%;
            border:1px solid rgba(255,255,255,.15);
            background:rgba(255,255,255,.08);
            color:rgba(255,255,255,.65);
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; transition:all .2s;
        }
        .theme-btn:hover { background:rgba(255,255,255,.15); color:white; }

        .nav-wrap {
            display:flex; gap:.3rem;
            background:var(--nav-bg);
            border:1px solid rgba(255,255,255,.08);
            padding:.38rem; border-radius:50px;
            margin-top:.85rem; width:fit-content;
        }

        .nav-item {
            padding:.48rem 1.15rem; border-radius:50px;
            font-size:.82rem; font-weight:500;
            color:rgba(255,255,255,.5); text-decoration:none;
            transition:all .2s; display:inline-flex; align-items:center; gap:.35rem;
        }
        .nav-item:hover { background:rgba(255,255,255,.08); color:white; }
        .nav-item.active { background:white; color:#0f172a; font-weight:600; }

        .stat-card {
            background:var(--surface); border:1px solid var(--border);
            border-radius:16px; padding:1.25rem 1.4rem;
            box-shadow:var(--shadow); transition:transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform:translateY(-2px); box-shadow:var(--shadow-md); }

        .stat-icon {
            width:38px; height:38px; border-radius:11px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.15rem; margin-bottom:.85rem;
        }
        .stat-label {
            font-size:.7rem; font-weight:600; text-transform:uppercase;
            letter-spacing:.07em; color:var(--muted); margin-bottom:.2rem;
        }
        .stat-value { font-size:1.85rem; font-weight:700; color:var(--text); line-height:1; }
        .stat-sub   { font-size:.78rem; color:var(--muted); margin-top:.3rem; }

        .search-wrap {
            background:var(--surface); border:1px solid var(--border);
            border-radius:12px; padding:.48rem 1rem;
            display:flex; align-items:center; gap:.65rem;
            box-shadow:var(--shadow); transition:border-color .2s;
        }
        .search-wrap:focus-within { border-color:var(--accent); }
        .search-wrap i  { color:var(--muted); }
        .search-wrap input {
            border:none; outline:none; background:transparent;
            color:var(--text); font-size:.88rem; width:100%;
            font-family:'Inter',sans-serif;
        }
        .search-wrap input::placeholder { color:var(--muted); }

        .proj-card {
            background:var(--surface); border:1px solid var(--border);
            border-radius:18px; overflow:hidden;
            box-shadow:var(--shadow); transition:transform .2s, box-shadow .2s, border-color .2s;
            display:flex; flex-direction:column; height:100%;
        }
        .proj-card:hover {
            transform:translateY(-3px);
            box-shadow:var(--shadow-md);
            border-color:var(--accent);
        }

        .top-bar { height:4px; }
        .proj-card.finalise .top-bar { background:linear-gradient(90deg,#10b981,#34d399); }
        .proj-card.retard   .top-bar { background:linear-gradient(90deg,#ef4444,#f87171); }
        .proj-card.cours    .top-bar { background:linear-gradient(90deg,#f97316,#fbbf24); }
        .proj-card.planifie .top-bar { background:linear-gradient(90deg,#6366f1,#818cf8); }

        .proj-body { padding:1.25rem; flex:1; display:flex; flex-direction:column; }

        .proj-header {
            display:flex; justify-content:space-between;
            align-items:center; margin-bottom:.95rem;
        }

        .proj-ref {
            font-size:.7rem; font-weight:600; letter-spacing:.06em;
            text-transform:uppercase; color:var(--muted);
            background:var(--surface2); padding:.22rem .7rem;
            border-radius:50px; border:1px solid var(--border);
        }

        .proj-badge {
            font-size:.7rem; font-weight:600;
            padding:.24rem .78rem; border-radius:50px;
        }
        [data-theme="light"] .proj-badge.finalise { background:#dcfce7; color:#166534; }
        [data-theme="light"] .proj-badge.retard   { background:#fee2e2; color:#991b1b; }
        [data-theme="light"] .proj-badge.cours    { background:#ffedd5; color:#9a3412; }
        [data-theme="light"] .proj-badge.planifie { background:#ede9fe; color:#4c1d95; }
        [data-theme="dark"]  .proj-badge.finalise { background:rgba(16,185,129,.15); color:#34d399; }
        [data-theme="dark"]  .proj-badge.retard   { background:rgba(239,68,68,.15);  color:#f87171; }
        [data-theme="dark"]  .proj-badge.cours    { background:rgba(249,115,22,.15); color:#fb923c; }
        [data-theme="dark"]  .proj-badge.planifie { background:rgba(99,102,241,.15); color:#a5b4fc; }

        .proj-client {
            font-size:1.12rem; font-weight:700; color:var(--text);
            margin-bottom:.2rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        }
        .proj-sector {
            font-size:.78rem; color:var(--muted);
            display:flex; align-items:center; gap:.3rem; margin-bottom:.85rem;
        }

        .normes-row {
            display:flex; flex-wrap:wrap; gap:.3rem;
            padding:.7rem 0; border-top:1px solid var(--border);
            border-bottom:1px solid var(--border); margin-bottom:.85rem;
        }
        .norme-pill {
            font-size:.68rem; font-weight:500;
            padding:.2rem .6rem; border-radius:50px;
            background:var(--surface2); border:1px solid var(--border); color:var(--text2);
        }

        .proj-chef {
            display:flex; align-items:center; gap:.45rem; margin-bottom:.85rem;
        }
        .chef-av {
            width:25px; height:25px; border-radius:50%;
            background:linear-gradient(135deg,#3b82f6,#8b5cf6);
            display:flex; align-items:center; justify-content:center;
            font-size:.62rem; font-weight:700; color:white; flex-shrink:0;
        }
        .chef-name { font-size:.82rem; color:var(--text2); font-weight:500; }

        .jours-row {
            display:flex; justify-content:space-between;
            font-size:.76rem; color:var(--muted); margin-bottom:.4rem;
        }
        .jours-pct { font-weight:600; color:var(--text); }

        .prog-bg {
            height:5px; background:var(--border);
            border-radius:50px; overflow:hidden; margin-bottom:.85rem;
        }
        .prog-fill {
            height:100%; border-radius:50px;
            background:linear-gradient(90deg,#3b82f6,#8b5cf6); transition:width .5s;
        }
        .prog-fill.finalise { background:linear-gradient(90deg,#10b981,#34d399); }
        .prog-fill.retard   { background:linear-gradient(90deg,#ef4444,#f87171); }
        .prog-fill.cours    { background:linear-gradient(90deg,#f97316,#fbbf24); }

        .blocage-tag {
            display:inline-flex; align-items:center; gap:.32rem;
            font-size:.7rem; font-weight:500;
            padding:.22rem .65rem; border-radius:50px; margin-bottom:.65rem;
        }
        [data-theme="light"] .blocage-tag { background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; }
        [data-theme="dark"]  .blocage-tag { background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.2); color:#f87171; }

        .proj-footer {
            display:flex; justify-content:flex-end; gap:.4rem;
            padding-top:.8rem; border-top:1px solid var(--border); margin-top:auto;
        }

        .act-btn {
            width:31px; height:31px; border-radius:9px;
            border:1px solid var(--border); background:var(--surface2);
            color:var(--muted); display:inline-flex; align-items:center;
            justify-content:center; text-decoration:none;
            font-size:.8rem; cursor:pointer; transition:all .18s;
        }
        .act-btn:hover          { background:var(--accent); color:white; border-color:var(--accent); }
        .act-btn.del:hover      { background:#ef4444; border-color:#ef4444; color:white; }
        .act-btn.edit-b:hover   { background:#8b5cf6; border-color:#8b5cf6; color:white; }
        .act-btn.gantt-b:hover  { background:#10b981; border-color:#10b981; color:white; }

        [data-theme="dark"] .si-blue   { background:rgba(59,130,246,.15)  !important; color:#60a5fa !important; }
        [data-theme="dark"] .si-green  { background:rgba(16,185,129,.15)  !important; color:#34d399 !important; }
        [data-theme="dark"] .si-red    { background:rgba(239,68,68,.15)   !important; color:#f87171 !important; }
        [data-theme="dark"] .si-yellow { background:rgba(217,119,6,.15)   !important; color:#fbbf24 !important; }

        .empty-state {
            text-align:center; padding:4rem 2rem;
            background:var(--surface); border-radius:16px;
            border:2px dashed var(--border);
        }
        .empty-state i { font-size:2.5rem; color:var(--muted); display:block; margin-bottom:.8rem; }

        .page-footer {
            display:flex; justify-content:space-between;
            margin-top:2rem; padding-top:1rem;
            border-top:1px solid var(--border);
            font-size:.78rem; color:var(--muted);
        }
    </style>
</head>
<body>

@php
use Illuminate\Support\Facades\DB;
try {
    $projets = DB::select("
        SELECT p.*, c.nom_client, c.secteur_activite,
               cons.nom_complet as chef_nom,
               GROUP_CONCAT(DISTINCT n.code_norme SEPARATOR '||') as normes_list
        FROM projets p
        LEFT JOIN clients c ON p.client_id = c.id
        LEFT JOIN consultants cons ON p.chef_projet_id = cons.id
        LEFT JOIN projet_normes pn ON p.id = pn.projet_id
        LEFT JOIN normes n ON pn.norme_id = n.id
        GROUP BY p.id ORDER BY p.reference_projet
    ");
    $db_error = null;
} catch (\Exception $e) {
    $projets = []; $db_error = $e->getMessage();
}
$totalProjets = count($projets);
$finalises = $enRetard = $enCours = $planifies = 0;
$totalJoursPrevus = $totalJoursRealises = 0;
foreach($projets as $p) {
    $totalJoursPrevus  += $p->jours_prevus;
    $totalJoursRealises += $p->jours_realises;
    match($p->statut) {
        'Finalisé'  => $finalises++,
        'En retard' => $enRetard++,
        'En cours'  => $enCours++,
        default     => $planifies++,
    };
}
@endphp

<!-- HEADER -->
<div class="site-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="logo">LMC CONSEIL</div>
                <div class="logo-sub">Campagne 2025 — 2026</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="meta-pill"><i class="bi bi-database me-1"></i>v2.0</span>
                <span class="meta-pill"><i class="bi bi-clock me-1"></i>{{ now()->format('d/m/Y') }}</span>
                <button class="theme-btn" id="themeToggle" title="Changer thème">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>
                <form method="POST" action="/logout" style="margin:0">
                    @csrf
                    <button type="button" class="theme-btn" title="Déconnexion"
                        onclick="this.closest('form').submit()">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="nav-wrap">
            <a href="/" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-table"></i> Données
            </a>
            <a href="/tableau-de-bord" class="nav-item {{ request()->is('tableau-de-bord') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Tableau de Bord
            </a>
            <a href="/consultants" class="nav-item {{ request()->is('consultants') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Consultants
            </a>
            <a href="/nouveau-projet" class="nav-item">
                <i class="bi bi-plus-circle"></i> Nouveau Projet
            </a>
            @if(auth()->user()->isSuperAdmin())
            <a href="/admin/users" class="nav-item {{ request()->is('admin/users') ? 'active' : '' }}">
                Accès
            </a>
            @endif
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="container py-4">

    @if(isset($db_error) && $db_error)
        <div class="alert alert-danger">{{ $db_error }}</div>
    @else

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon si-blue" style="background:#eff6ff; color:#3b82f6;">
                    <i class="bi bi-folder2"></i>
                </div>
                <div class="stat-label">Total Projets</div>
                <div class="stat-value">{{ $totalProjets }}</div>
                <div class="stat-sub">Portefeuille complet</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon si-green" style="background:#f0fdf4; color:#16a34a;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-label">Finalisés</div>
                <div class="stat-value">{{ $finalises }}</div>
                <div class="stat-sub">Certifications obtenues</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon si-red" style="background:#fff1f2; color:#e11d48;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-label">En retard</div>
                <div class="stat-value">{{ $enRetard }}</div>
                <div class="stat-sub">Attention requise</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon si-yellow" style="background:#fffbeb; color:#d97706;">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-label">Jours réalisés</div>
                <div class="stat-value">{{ $totalJoursRealises }}</div>
                <div class="stat-sub">/ {{ $totalJoursPrevus }} prévus</div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="search-wrap mb-4">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput"
               placeholder="Rechercher un projet, client, chef de projet...">
    </div>

    <!-- Cards -->
    <div class="row g-3" id="projectsContainer">
        @forelse($projets as $projet)
        @php
            $sc = match($projet->statut) {
                'Finalisé'  => 'finalise',
                'En retard' => 'retard',
                'En cours'  => 'cours',
                default     => 'planifie',
            };
            $normes   = array_filter(explode('||', $projet->normes_list ?? ''));
            $initials = collect(explode(' ', $projet->chef_nom ?? '??'))
                ->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->implode('');
        @endphp

        <div class="col-xl-4 col-md-6 project-item">
            <div class="proj-card {{ $sc }}">
                <div class="top-bar"></div>
                <div class="proj-body">

                    <div class="proj-header">
                        <span class="proj-ref">{{ $projet->reference_projet }}</span>
                        <span class="proj-badge {{ $sc }}">{{ $projet->statut }}</span>
                    </div>

                    <div class="proj-client" title="{{ $projet->nom_client }}">{{ $projet->nom_client }}</div>
                    <div class="proj-sector">
                        <i class="bi bi-building"></i>
                        {{ $projet->secteur_activite ?? 'Non spécifié' }}
                    </div>

                    @if(count($normes))
                    <div class="normes-row">
                        @foreach(array_slice($normes,0,3) as $n)
                            <span class="norme-pill">{{ $n }}</span>
                        @endforeach
                        @if(count($normes)>3)
                            <span class="norme-pill">+{{ count($normes)-3 }}</span>
                        @endif
                    </div>
                    @endif

                    <div class="proj-chef">
                        <div class="chef-av">{{ $initials }}</div>
                        <div class="chef-name">{{ $projet->chef_nom ?? '—' }}</div>
                    </div>

                    <div class="jours-row">
                        <span><i class="bi bi-clock me-1"></i>{{ $projet->jours_realises }} / {{ $projet->jours_prevus }} j</span>
                        <span class="jours-pct">{{ $projet->avancement_percent }}%</span>
                    </div>
                    <div class="prog-bg">
                        <div class="prog-fill {{ $sc }}" style="width:{{ $projet->avancement_percent }}%"></div>
                    </div>

                    @php
                        $chapitres = \Illuminate\Support\Facades\DB::table('suivi_chapitres')
                            ->where('projet_id', $projet->id)
                            ->get();
                        $avgChap = $chapitres->count() > 0
                            ? round($chapitres->avg('avancement_percent'))
                            : null;
                    @endphp
                    @if($avgChap !== null)
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:.72rem;color:var(--muted);margin-bottom:.3rem;margin-top:.4rem;">
                        <span><i class="bi bi-list-check me-1"></i>Chapitres SMI</span>
                        <span style="font-weight:600;color:var(--text2)">moy. {{ $avgChap }}%</span>
                    </div>
                    <div class="prog-bg">
                        <div class="prog-fill" style="width:{{ $avgChap }}%;background:linear-gradient(90deg,#8b5cf6,#a78bfa)"></div>
                    </div>
                    @endif

                    @if($projet->blocage && $projet->blocage !== 'RAS')
                    <div>
                        <span class="blocage-tag">
                            <i class="bi bi-exclamation-triangle-fill"></i> Blocage signalé
                        </span>
                    </div>
                    @endif

                    {{-- ════ FOOTER BOUTONS ════ --}}
                    <div class="proj-footer">

                        @if(auth()->user()->hasPermission('voir_details'))
                        <a href="/projet/{{ $projet->id }}" class="act-btn" title="Voir détails">
                            <i class="bi bi-eye"></i>
                        </a>
                        @endif

                        {{-- BOUTON GANTT — NOUVEAU --}}
                        <a href="/projet/{{ $projet->id }}/gantt" class="act-btn gantt-b" title="Planning Gantt">
                            <i class="bi bi-bar-chart-steps"></i>
                        </a>

                        @if(auth()->user()->hasPermission('modifier_projets'))
                        <a href="/projet/{{ $projet->id }}/edit" class="act-btn edit-b" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @endif

                        @if(auth()->user()->hasPermission('supprimer_projets'))
                        <button class="act-btn del" onclick="confirmDelete({{ $projet->id }})" title="Supprimer">
                            <i class="bi bi-trash"></i>
                        </button>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h5 style="color:var(--text);">Aucun projet trouvé</h5>
                <p style="color:var(--muted);font-size:.88rem;">
                    Créez votre premier projet via <strong>Nouveau Projet</strong>
                </p>
            </div>
        </div>
        @endforelse
    </div>

    <div class="page-footer">
        <span><i class="bi bi-layers me-1"></i>{{ $totalProjets }} projet(s)</span>
        <span><i class="bi bi-calendar-week me-1"></i>{{ $totalJoursRealises }} / {{ $totalJoursPrevus }} jours</span>
    </div>

    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const t = this.value.toLowerCase();
    document.querySelectorAll('.project-item').forEach(el => {
        el.style.display = el.textContent.toLowerCase().includes(t) ? '' : 'none';
    });
});

const html = document.documentElement;
const icon = document.getElementById('themeIcon');
const saved = localStorage.getItem('lmc-theme') || 'light';
applyTheme(saved);

document.getElementById('themeToggle').addEventListener('click', () => {
    const next = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    localStorage.setItem('lmc-theme', next);
    applyTheme(next);
});

function applyTheme(t) {
    html.setAttribute('data-theme', t);
    icon.className = t === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
}

function confirmDelete(id) {
    if(confirm('Supprimer ce projet définitivement ?')) {
        fetch(`/projets/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    || '{{ csrf_token() }}'
            }
        }).then(() => location.reload());
    }
}
</script>
</body>
</html>