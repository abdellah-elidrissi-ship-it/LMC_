<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMC Conseil - Tableau de Bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }

        /* ===== NOUVELLE NAVBAR AVEC LOGO ===== */
        .site-header {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            padding: 1rem 0;
            border-bottom: 3px solid #3b82f6;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-image {
            height: 40px;
            width: auto;
            filter: brightness(0) invert(1);
            transition: filter 0.2s;
        }

        [data-theme="dark"] .logo-image {
            filter: none;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-main {
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            letter-spacing: -0.02em;
        }

        .logo-sub {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.5);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            background: rgba(255,255,255,0.08);
            padding: 0.35rem 1rem;
            border-radius: 50px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .meta-pill {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .theme-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .theme-btn:hover {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .nav-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .nav-wrap {
            display: flex;
            gap: 0.25rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.08);
            padding: 0.4rem;
            border-radius: 50px;
            margin-top: 0.75rem;
            width: fit-content;
        }

        .nav-item {
            padding: 0.45rem 1.25rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-item.active {
            background: white;
            color: #0f172a;
            font-weight: 600;
        }

        /* ── Dark mode support ── */
        [data-theme="dark"] body {
            background: #0f172a !important;
            color: #e2e8f0 !important;
        }
        [data-theme="dark"] .stat-card,
        [data-theme="dark"] .avan-card,
        [data-theme="dark"] .chart-card,
        [data-theme="dark"] .table-card {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        [data-theme="dark"] .stat-label,
        [data-theme="dark"] .stat-sub { color: #64748b !important; }
        [data-theme="dark"] .stat-value { color: #e2e8f0 !important; }
        [data-theme="dark"] .chart-title { color: #94a3b8 !important; border-color: #1e293b !important; }
        [data-theme="dark"] .table-pro thead th {
            background: #162032 !important;
            color: #64748b !important;
            border-color: #334155 !important;
        }
        [data-theme="dark"] .table-pro tbody td {
            color: #cbd5e1 !important;
            border-color: #1e293b !important;
        }
        [data-theme="dark"] .table-pro tbody tr:hover td { background: #1e293b !important; }
        [data-theme="dark"] .tfoot-total td { background: #162032 !important; }
        [data-theme="dark"] .tfoot-ecart td { background: #1e293b !important; }
        [data-theme="dark"] .mini-prog { background: #334155 !important; }
        [data-theme="dark"] .badge-finalise { background: rgba(16,185,129,.15) !important; color: #34d399 !important; }
        [data-theme="dark"] .badge-retard   { background: rgba(239,68,68,.15) !important;  color: #f87171 !important; }
        [data-theme="dark"] .badge-cours    { background: rgba(249,115,22,.15) !important; color: #fb923c !important; }
        [data-theme="dark"] .badge-planifie { background: rgba(99,102,241,.15) !important; color: #a5b4fc !important; }
        [data-theme="dark"] .bs.finalise { background: rgba(16,185,129,.15) !important; color: #34d399 !important; }
        [data-theme="dark"] .bs.retard   { background: rgba(239,68,68,.15) !important;  color: #f87171 !important; }
        [data-theme="dark"] .bs.cours    { background: rgba(249,115,22,.15) !important; color: #fb923c !important; }
        [data-theme="dark"] .bs.planifie { background: rgba(99,102,241,.15) !important; color: #a5b4fc !important; }

        /* ── KPI Cards ── */
        .stat-card {
            background:#ffffff; border:1px solid #e2e8f0;
            border-radius:16px; padding:1.25rem 1.4rem;
            box-shadow:0 2px 12px rgba(0,0,0,0.06);
            transition:transform .2s, box-shadow .2s;
            height:100%;
        }
        .stat-card:hover {
            transform:translateY(-2px);
            box-shadow:0 4px 20px rgba(0,0,0,0.08);
        }

        .stat-icon {
            width:38px; height:38px; border-radius:11px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.15rem; margin-bottom:.85rem;
        }
        .stat-label {
            font-size:.7rem; font-weight:600; text-transform:uppercase;
            letter-spacing:.07em; color:#94a3b8; margin-bottom:.2rem;
        }
        .stat-value { font-size:1.85rem; font-weight:700; color:#0f172a; line-height:1; }
        .stat-sub   { font-size:.78rem; color:#94a3b8; margin-top:.3rem; }

        /* ── Avancement card ── */
        .avan-card {
            background:white; border:1px solid #e2e8f0;
            border-radius:16px; padding:1rem 1.5rem;
            box-shadow:0 2px 12px rgba(0,0,0,0.06);
        }

        /* ── Chart cards ── */
        .chart-card {
            background:white; border:1px solid #e2e8f0;
            border-radius:18px; padding:1.2rem;
            box-shadow:0 2px 12px rgba(0,0,0,0.06);
            height:100%;
            transition:transform .2s, box-shadow .2s;
        }
        .chart-card:hover {
            transform:translateY(-2px);
            box-shadow:0 4px 20px rgba(0,0,0,0.08);
        }

        .chart-title {
            font-size:.85rem; font-weight:600; color:#475569;
            margin-bottom:.9rem; padding-bottom:.6rem;
            border-bottom:1px solid #f1f5f9;
            display:flex; align-items:center; gap:.4rem;
        }

        .chart-container { height:190px; width:100%; position:relative; }

        /* ── Table card ── */
        .table-card {
            background:white; border:1px solid #e2e8f0;
            border-radius:18px; padding:1.3rem;
            box-shadow:0 2px 12px rgba(0,0,0,0.06);
        }

        .table-card h6 {
            font-size:.88rem; font-weight:600; color:#475569;
            display:flex; align-items:center; gap:.4rem;
            margin-bottom:1rem;
        }

        .table-pro {
            width:100%; border-collapse:collapse; font-size:.83rem;
        }

        .table-pro thead th {
            background:#f8fafc; color:#64748b;
            padding:.65rem .6rem;
            font-weight:600; font-size:.75rem;
            text-transform:uppercase; letter-spacing:.04em;
            border-bottom:2px solid #e2e8f0;
        }

        .table-pro tbody td {
            padding:.6rem .6rem;
            border-bottom:1px solid #f1f5f9;
            vertical-align:middle; color:#334155;
        }

        .table-pro tbody tr:hover td { background:#f8fafc; }
        .table-pro tbody tr:last-child td { border-bottom:none; }

        /* badges */
        .bs {
            padding:.22rem .78rem; border-radius:50px;
            font-weight:600; font-size:.7rem; display:inline-block;
        }
        .bs.finalise { background:#dcfce7; color:#166534; }
        .bs.retard   { background:#fee2e2; color:#991b1b; }
        .bs.cours    { background:#ffedd5; color:#9a3412; }
        .bs.planifie { background:#ede9fe; color:#4c1d95; }

        /* mini progress */
        .mini-prog {
            width:55px; height:4px; background:#e2e8f0;
            border-radius:50px; overflow:hidden;
        }
        .mini-prog-fill {
            height:100%; border-radius:50px;
            background:linear-gradient(90deg,#3b82f6,#8b5cf6);
        }

        /* tfoot */
        .table-pro tfoot td {
            padding:.65rem .6rem; font-size:.82rem;
        }

        .tfoot-total td {
            background:#f1f5f9; font-weight:700;
            border-top:2px solid #3b82f6;
        }

        .tfoot-ecart td {
            background:#ffffff;
            border-top:1px dashed #cbd5e1;
        }

        /* page footer */
        .page-footer {
            display:flex; justify-content:space-between;
            margin-top:2rem; padding-top:1rem;
            border-top:1px solid #e2e8f0;
            font-size:.78rem; color:#94a3b8;
        }
    </style>
</head>
<body>

@php
use Illuminate\Support\Facades\DB;

$projets = DB::select("
    SELECT p.*, c.nom_client, cons.nom_complet as chef_nom
    FROM projets p
    LEFT JOIN clients c ON p.client_id = c.id
    LEFT JOIN consultants cons ON p.chef_projet_id = cons.id
    ORDER BY p.reference_projet
");

$totalProjets = count($projets);
$finalises = $enRetard = $enCours = $planifies = 0;
$totalJoursPrevus = $totalJoursRealises = $totalEcart = 0;

foreach($projets as $p) {
    $totalJoursPrevus  += $p->jours_prevus;
    $totalJoursRealises += $p->jours_realises;
    $totalEcart        += ($p->jours_realises - $p->jours_prevus);
    match($p->statut) {
        'Finalisé'  => $finalises++,
        'En retard' => $enRetard++,
        'En cours'  => $enCours++,
        default     => $planifies++,
    };
}

$avancementMoyen = $totalProjets > 0
    ? round(array_sum(array_column($projets, 'avancement_percent')) / $totalProjets) : 0;
$consoGlobale = $totalJoursPrevus > 0
    ? round(($totalJoursRealises / $totalJoursPrevus) * 100) : 0;

$user = auth()->user();
@endphp

<!-- ══ HEADER AVEC LOGO ══ -->
<div class="site-header">
    <div class="header-container">
        <div class="logo-wrapper">
            <img src="https://lmc.ma/wp-content/uploads/2021/02/LMC-Logo.png" 
                 alt="LMC Conseil" 
                 class="logo-image"
                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2280%22%20height%3D%2240%22%20viewBox%3D%220%200%2080%2040%22%3E%3Ctext%20x%3D%220%22%20y%3D%2230%22%20font-family%3D%22Inter%2C%20sans-serif%22%20font-size%3D%2220%22%20font-weight%3D%22700%22%20fill%3D%22%23ffffff%22%3ELMC%3C%2Ftext%3E%3C%2Fsvg%3E';">
            <div class="logo-text">
                <span class="logo-main">LMC CONSEIL</span>
                <span class="logo-sub">LEAD MANAGEMENT CONSULTING</span>
            </div>
        </div>
        
        <div class="header-actions">
            <div class="user-info">
                <i class="bi bi-person-circle"></i>
                <span class="user-name">{{ $user->name ?? 'Utilisateur' }}</span>
            </div>
            <span class="meta-pill">
                <i class="bi bi-calendar-check"></i>
                {{ now()->format('d/m/Y') }}
            </span>
            <button class="theme-btn" id="themeToggle">
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

    <div class="nav-container">
        <div class="nav-wrap">
            <a href="/" class="nav-item">
                <i class="bi bi-table"></i> Données
            </a>
            <a href="/tableau-de-bord" class="nav-item active">
                <i class="bi bi-bar-chart"></i> Tableau de Bord
            </a>
            <a href="/consultants" class="nav-item">
                <i class="bi bi-people"></i> Consultants
            </a>
            <a href="/nouveau-projet" class="nav-item">
                <i class="bi bi-plus-circle"></i> Nouveau Projet
            </a>
            @if($user && $user->isSuperAdmin())
            <a href="/admin/users" class="nav-item">
                <i class="bi bi-shield-lock"></i> Accès
            </a>
            @endif
        </div>
    </div>
</div>

<script>
(function() {
    const saved = localStorage.getItem('lmc-theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = saved === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
})();
document.getElementById('themeToggle')?.addEventListener('click', () => {
    const next = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('lmc-theme', next);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = next === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
});
</script>

<!-- ══ CONTENT ══ -->
<div class="container py-4">

    <!-- KPI -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff; color:#3b82f6;">
                    <i class="bi bi-folder2"></i>
                </div>
                <div class="stat-label">Total Projets</div>
                <div class="stat-value">{{ $totalProjets }}</div>
                <div class="stat-sub">Portefeuille complet</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-label">Finalisés</div>
                <div class="stat-value">{{ $finalises }}</div>
                <div class="stat-sub">Certifications obtenues</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fff1f2; color:#e11d48;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-label">En retard</div>
                <div class="stat-value">{{ $enRetard }}</div>
                <div class="stat-sub">Attention requise</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fffbeb; color:#d97706;">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-label">Jours réalisés</div>
                <div class="stat-value">{{ $totalJoursRealises }}</div>
                <div class="stat-sub">/ {{ $totalJoursPrevus }} prévus</div>
            </div>
        </div>
    </div>

    <!-- Avancement moyen -->
    <div class="avan-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size:.82rem; font-weight:600; color:#475569;">
                <i class="bi bi-graph-up me-1 text-primary"></i>Avancement moyen du portefeuille
            </span>
            <span style="font-size:1.2rem; font-weight:700; color:#0f172a;">{{ $avancementMoyen }}%</span>
        </div>
        <div class="progress" style="height:6px; border-radius:50px;">
            <div class="progress-bar"
                 style="width:{{ $avancementMoyen }}%; background:linear-gradient(90deg,#3b82f6,#8b5cf6); border-radius:50px;">
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="chart-card">
                <div class="chart-title">
                    <i class="bi bi-pie-chart text-primary"></i> Répartition par Statut
                </div>
                <div class="chart-container">
                    <canvas id="chartStatut"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-card">
                <div class="chart-title">
                    <i class="bi bi-bar-chart text-primary"></i> Avancement par Client
                </div>
                <div class="chart-container">
                    <canvas id="chartAvancement"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-card">
                <div class="chart-title">
                    <i class="bi bi-calendar-check text-primary"></i> Jours Prévus vs Réalisés
                </div>
                <div class="chart-container">
                    <canvas id="chartJours"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        <h6>
            <i class="bi bi-table text-primary"></i> Détail des projets
        </h6>
        <div class="table-responsive">
            <table class="table-pro">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Client</th>
                        <th>Chef de Projet</th>
                        <th>Statut</th>
                        <th class="text-center">J. Prévus</th>
                        <th class="text-center">J. Réalisés</th>
                        <th class="text-center">% Conso.</th>
                        <th>Avancement</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projets as $p)
                    @php
                        $sc = match($p->statut) {
                            'Finalisé'  => 'finalise',
                            'En retard' => 'retard',
                            'En cours'  => 'cours',
                            default     => 'planifie',
                        };
                        $conso = $p->jours_prevus > 0
                            ? round(($p->jours_realises / $p->jours_prevus) * 100) : 0;
                    @endphp
                    <tr>
                        <td><strong style="color:#0f172a;">{{ $p->reference_projet }}</strong></td>
                        <td>{{ $p->nom_client }}</td>
                        <td>{{ $p->chef_nom ?? '—' }}</td>
                        <td><span class="bs {{ $sc }}">{{ $p->statut }}</span></td>
                        <td class="text-center">{{ $p->jours_prevus }}</td>
                        <td class="text-center">{{ $p->jours_realises }}</td>
                        <td class="text-center">{{ $conso }}%</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="width:28px; font-size:.78rem; font-weight:600;">{{ $p->avancement_percent }}%</span>
                                <div class="mini-prog">
                                    <div class="mini-prog-fill" style="width:{{ $p->avancement_percent }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="tfoot-total">
                        <td colspan="4" style="color:#3b82f6; font-weight:700;">
                            <i class="bi bi-layers me-1"></i> TOTAUX PORTEFEUILLE 2025-2026
                        </td>
                        <td class="text-center fw-bold">{{ $totalJoursPrevus }}</td>
                        <td class="text-center fw-bold">{{ $totalJoursRealises }}</td>
                        <td class="text-center fw-bold">{{ $consoGlobale }}%</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="width:28px; font-size:.78rem; font-weight:700;">{{ $avancementMoyen }}%</span>
                                <div class="mini-prog">
                                    <div class="mini-prog-fill" style="width:{{ $avancementMoyen }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="tfoot-ecart">
                        <td colspan="7" style="font-size:.78rem; color:#94a3b8; text-align:right;">
                            Écart total jours :
                        </td>
                        <td class="text-center fw-bold"
                            style="color:{{ $totalEcart >= 0 ? '#16a34a' : '#dc2626' }};">
                            {{ $totalEcart > 0 ? '+' : '' }}{{ $totalEcart }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="page-footer">
        <span><i class="bi bi-layers me-1"></i>{{ $totalProjets }} projet(s)</span>
        <span><i class="bi bi-calendar-week me-1"></i>{{ $totalJoursRealises }} / {{ $totalJoursPrevus }} jours</span>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Chart 1 — Répartition statut
    new Chart(document.getElementById('chartStatut'), {
        type: 'pie',
        data: {
            labels: ['Finalisé', 'En retard', 'En cours', 'Planifié'],
            datasets: [{
                data: [{{ $finalises }}, {{ $enRetard }}, {{ $enCours }}, {{ $planifies }}],
                backgroundColor: ['#10b981','#ef4444','#f97316','#6366f1'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position:'bottom', labels:{ boxWidth:10, font:{ size:10 }, padding:10 } }
            }
        }
    });

    // Chart 2 — Avancement par client
    new Chart(document.getElementById('chartAvancement'), {
        type: 'bar',
        data: {
            labels: [@foreach($projets as $p)'{{ Str::limit($p->nom_client, 12) }}',@endforeach],
            datasets: [{
                label: 'Avancement %',
                data: [@foreach($projets as $p){{ $p->avancement_percent }},@endforeach],
                backgroundColor: '#3b82f6',
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend:{ display:false } },
            scales: {
                y: { beginAtZero:true, max:100, grid:{ color:'#f1f5f9' },
                     ticks:{ font:{ size:9 }, callback: v => v+'%' } },
                x: { grid:{ display:false }, ticks:{ font:{ size:9 } } }
            }
        }
    });

    // Chart 3 — Jours prévus vs réalisés
    new Chart(document.getElementById('chartJours'), {
        type: 'bar',
        data: {
            labels: [@foreach($projets as $p)'{{ $p->reference_projet }}',@endforeach],
            datasets: [
                {
                    label: 'Prévus',
                    data: [@foreach($projets as $p){{ $p->jours_prevus }},@endforeach],
                    backgroundColor: '#cbd5e1',
                    borderRadius: 6, borderSkipped: false
                },
                {
                    label: 'Réalisés',
                    data: [@foreach($projets as $p){{ $p->jours_realises }},@endforeach],
                    backgroundColor: '#3b82f6',
                    borderRadius: 6, borderSkipped: false
                }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position:'bottom', labels:{ boxWidth:10, font:{ size:9 }, padding:8 } }
            },
            scales: {
                y: { beginAtZero:true, grid:{ color:'#f1f5f9' }, ticks:{ font:{ size:9 } } },
                x: { grid:{ display:false }, ticks:{ font:{ size:9 } } }
            }
        }
    });

});
</script>
<script>
// Sync theme from localStorage
(function() {
    const t = localStorage.getItem('lmc-theme') || 'light';
    document.documentElement.setAttribute('data-theme', t);
})();
</script>

</body>
</html>