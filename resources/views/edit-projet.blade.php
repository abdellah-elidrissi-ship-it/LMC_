<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Projet - LMC Conseil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        [data-theme="light"] {
            --bg:#f1f5f9; --surface:#ffffff; --surface2:#f8fafc; --border:#e2e8f0;
            --text:#0f172a; --text2:#475569; --muted:#94a3b8;
            --accent:#3b82f6; --accent2:#8b5cf6;
            --input-bg:#ffffff; --input-border:#e2e8f0;
            --thead-bg:#f1f5f9; --thead-text:#475569;
            --shadow:0 2px 12px rgba(0,0,0,.06);
            --btn-primary-bg:#0f172a; --btn-primary-hover:#1e293b;
            --add-section-bg:#f8fafc;
            --cons-row-bg:#f8fafc; --cons-row-border:#3b82f6;
        }
        [data-theme="dark"] {
            --bg:#0f172a; --surface:#1e293b; --surface2:#162032; --border:#334155;
            --text:#e2e8f0; --text2:#94a3b8; --muted:#64748b;
            --accent:#3b82f6; --accent2:#a78bfa;
            --input-bg:#162032; --input-border:#334155;
            --thead-bg:#162032; --thead-text:#64748b;
            --shadow:0 2px 12px rgba(0,0,0,.3);
            --btn-primary-bg:#3b82f6; --btn-primary-hover:#2563eb;
            --add-section-bg:#162032;
            --cons-row-bg:#162032; --cons-row-border:#3b82f6;
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); transition:background .3s,color .3s; }

        .site-header { background:linear-gradient(135deg,#0f172a,#1e293b); padding:1rem 0; border-bottom:3px solid #3b82f6; }
        .logo { font-size:1.3rem; font-weight:700; color:white; }
        .logo-sub { font-size:.73rem; color:rgba(255,255,255,.4); margin-top:.1rem; }
        .meta-pill { background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.1); color:rgba(255,255,255,.5); padding:.28rem .8rem; border-radius:50px; font-size:.73rem; }
        .theme-btn { width:34px; height:34px; border-radius:50%; border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.08); color:rgba(255,255,255,.65); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .2s; }
        .theme-btn:hover { background:rgba(255,255,255,.15); color:white; }
        .nav-wrap { display:flex; gap:.3rem; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.08); padding:.38rem; border-radius:50px; margin-top:.85rem; width:fit-content; }
        .nav-item { padding:.48rem 1.15rem; border-radius:50px; font-size:.82rem; font-weight:500; color:rgba(255,255,255,.55); text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:.35rem; }
        .nav-item:hover { background:rgba(255,255,255,.08); color:white; }
        .nav-item.active { background:white; color:#0f172a; font-weight:600; }

        .form-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:1.8rem; box-shadow:var(--shadow); margin-bottom:1.5rem; transition:background .3s; }
        .section-title { font-size:1rem; font-weight:700; color:var(--text); margin-bottom:1.3rem; padding-bottom:.6rem; border-bottom:2px solid var(--accent); display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }
        .section-title i { color:var(--accent); }
        .section-hint { margin-left:auto; font-size:.71rem; font-weight:400; color:var(--muted); display:flex; align-items:center; gap:.4rem; }

        .form-label { font-size:.82rem; font-weight:600; color:var(--text2); margin-bottom:.35rem; display:flex; align-items:center; gap:.4rem; }
        .form-control, .form-select { background:var(--input-bg) !important; border:1.5px solid var(--input-border) !important; border-radius:10px !important; padding:.6rem .9rem !important; font-size:.88rem !important; color:var(--text) !important; font-family:'Inter',sans-serif !important; transition:border-color .2s !important; }
        .form-control:focus, .form-select:focus { border-color:var(--accent) !important; box-shadow:0 0 0 3px rgba(59,130,246,.12) !important; outline:none !important; }
        .form-control::placeholder { color:var(--muted) !important; }
        textarea.form-control { resize:vertical; min-height:75px; }
        textarea[readonly] { background:var(--surface2) !important; color:var(--muted) !important; }
        [data-theme="dark"] option { background:#1e293b; color:#e2e8f0; }
        input[type="number"] { -moz-appearance:textfield; }
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button { -webkit-appearance:none; }

        .form-control.auto-blue { background:rgba(59,130,246,.06) !important; border:1.5px dashed #3b82f6 !important; color:#3b82f6 !important; font-weight:700 !important; cursor:not-allowed !important; }
        .form-control.auto-purple { background:rgba(139,92,246,.06) !important; border:1.5px dashed #8b5cf6 !important; color:var(--accent2) !important; font-weight:700 !important; cursor:not-allowed !important; }
        .badge-auto { display:inline-flex; align-items:center; gap:.25rem; font-size:.67rem; font-weight:600; padding:.12rem .5rem; border-radius:50px; }
        .badge-auto.blue  { background:rgba(59,130,246,.1); color:#3b82f6; }
        .badge-auto.purple{ background:rgba(139,92,246,.1); color:var(--accent2); }
        .auto-tag { display:inline-flex; align-items:center; gap:.28rem; font-size:.7rem; font-weight:500; color:var(--muted); margin-top:.3rem; }

        .mini-prog { margin-top:.6rem; }
        .mini-prog-row { display:flex; justify-content:space-between; font-size:.71rem; color:var(--muted); margin-bottom:.3rem; }
        .mini-prog-bar { height:4px; background:var(--border); border-radius:50px; overflow:hidden; }
        .mini-prog-fill { height:100%; border-radius:50px; transition:width .35s ease; }
        .fill-blue   { background:linear-gradient(90deg,#3b82f6,#60a5fa); }
        .fill-purple { background:linear-gradient(90deg,#8b5cf6,#a78bfa); }

        .btn-main { background:var(--btn-primary-bg); color:white; border:none; border-radius:11px; padding:.7rem 1.8rem; font-weight:600; font-size:.88rem; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:.4rem; }
        .btn-main:hover { background:var(--btn-primary-hover); transform:translateY(-1px); }
        .btn-cancel { background:var(--surface); color:var(--text2); border:1.5px solid var(--border); border-radius:11px; padding:.7rem 1.8rem; font-weight:600; font-size:.88rem; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:.4rem; }
        .btn-cancel:hover { background:var(--surface2); color:var(--text); }

        .cons-row { background:var(--cons-row-bg); border:1px solid var(--border); border-left:3px solid var(--cons-row-border); border-radius:12px; padding:1rem; margin-bottom:.7rem; }
        .add-section { background:var(--add-section-bg); border:1px dashed var(--border); border-radius:14px; padding:1.2rem; margin-top:1.2rem; }
        .add-section h6 { color:var(--text2); font-size:.85rem; font-weight:600; margin-bottom:.9rem; }

        .table-smi { width:100%; border-collapse:collapse; font-size:.82rem; }
        .table-smi thead th { padding:.65rem .8rem; font-size:.71rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; background:var(--surface2); color:var(--muted); border-bottom:2px solid var(--border); border-right:1px solid var(--border); }
        .table-smi thead th:last-child { border-right:none; }
        .table-smi tbody td { padding:.55rem .75rem; border-bottom:1px solid var(--border); border-right:1px solid var(--border); vertical-align:middle; }
        .table-smi tbody td:last-child { border-right:none; }
        .table-smi tbody tr:hover td { background:rgba(59,130,246,.02); }
        .table-smi tfoot td { padding:.65rem .75rem; font-weight:700; border-top:2px solid var(--border); border-right:1px solid var(--border); background:var(--surface2); }
        .table-smi tfoot td:last-child { border-right:none; }
        .th-jours { background:rgba(59,130,246,.08) !important; color:#3b82f6 !important; }
        .th-av    { background:rgba(139,92,246,.08) !important; color:var(--accent2) !important; }
        .col-jours { background:rgba(59,130,246,.03); }
        .col-av    { background:rgba(139,92,246,.03); }
        .smi-num { border-radius:8px !important; padding:.35rem .5rem !important; text-align:center; font-size:.82rem; }
        [data-theme="light"] .smi-jours { border-color:rgba(59,130,246,.3) !important; }
        [data-theme="light"] .smi-av    { border-color:rgba(139,92,246,.3) !important; }
        [data-theme="dark"]  .smi-jours { border-color:rgba(59,130,246,.4) !important; }
        [data-theme="dark"]  .smi-av    { border-color:rgba(139,92,246,.4) !important; }
        .foot-blue   { color:#3b82f6; text-align:center; font-size:.95rem; }
        .foot-purple { color:var(--accent2); text-align:center; font-size:.95rem; }
        .foot-sub { font-size:.63rem; color:var(--muted); font-weight:400; margin-top:.15rem; }

        /* ══ LIVRABLES ══ */
        .liv-section { margin-top:1.4rem; padding-top:1.2rem; border-top:2px dashed var(--border); }
        .liv-section-title { font-size:.85rem; font-weight:700; color:var(--text2); margin-bottom:.9rem; display:flex; align-items:center; gap:.5rem; }
        .liv-accordion { border:1px solid var(--border); border-radius:14px; overflow:hidden; margin-bottom:.6rem; }
        .liv-header { display:flex; align-items:center; gap:.75rem; padding:.75rem 1rem; cursor:pointer; background:var(--surface2); border-bottom:1px solid transparent; transition:background .2s; user-select:none; }
        .liv-header:hover { background:rgba(59,130,246,.05); }
        .liv-header.open { border-bottom:1px solid var(--border); background:var(--surface); }
        .liv-chap-code { font-size:.88rem; font-weight:700; color:var(--accent); min-width:38px; }
        .liv-chap-titre { font-size:.8rem; font-weight:600; color:var(--text); flex:1; }
        .liv-counter { font-size:.72rem; color:var(--muted); display:flex; align-items:center; gap:.35rem; }
        .liv-prog-wrap { width:90px; }
        .liv-prog-bg { height:4px; background:var(--border); border-radius:50px; overflow:hidden; }
        .liv-prog-fill { height:100%; border-radius:50px; background:linear-gradient(90deg,#10b981,#34d399); transition:width .35s; }
        .liv-badge-statut { font-size:.68rem; font-weight:600; padding:.18rem .6rem; border-radius:50px; }
        .liv-badge-statut.done    { background:rgba(16,185,129,.15); color:#10b981; }
        .liv-badge-statut.partial { background:rgba(251,191,36,.15);  color:#f59e0b; }
        .liv-badge-statut.none    { background:rgba(148,163,184,.15); color:#94a3b8; }
        .liv-arrow { color:var(--muted); font-size:.75rem; transition:transform .25s; }
        .liv-header.open .liv-arrow { transform:rotate(180deg); }
        .liv-body { display:none; }
        .liv-body.open { display:block; }
        .liv-row { display:grid; grid-template-columns:65px 1fr 165px; align-items:center; gap:.7rem; padding:.55rem 1rem; border-bottom:1px solid var(--border); transition:background .15s; }
        .liv-row:last-child { border-bottom:none; }
        .liv-row:hover { background:rgba(59,130,246,.03); }
        .liv-clause { font-size:.72rem; font-weight:600; color:var(--accent); }
        .liv-libelle { font-size:.8rem; color:var(--text2); line-height:1.4; }
        .liv-statut-select { font-size:.75rem; font-weight:600; padding:.3rem .75rem; border-radius:50px; border:1.5px solid var(--border); background:var(--surface2); color:var(--text); cursor:pointer; outline:none; transition:border-color .2s,background .2s; width:100%; }
        .liv-statut-select.s-nc { border-color:rgba(148,163,184,.4); color:#94a3b8; }
        .liv-statut-select.s-ec { border-color:rgba(251,191,36,.5); color:#f59e0b; background:rgba(251,191,36,.06) !important; }
        .liv-statut-select.s-ok { border-color:rgba(16,185,129,.5); color:#10b981; background:rgba(16,185,129,.06) !important; }

        .table-bordered { border-color:var(--border) !important; }
        .table-bordered td, .table-bordered th { border-color:var(--border) !important; color:var(--text); }
        .form-check-input:checked { background-color:var(--accent); border-color:var(--accent); }
        .form-check-label { color:var(--text2); font-size:.85rem; }
        .alert-float { position:fixed; top:20px; right:20px; z-index:9999; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,.15); min-width:300px; font-size:.88rem; }
    </style>
</head>
<body>

@if(session('success'))
<div class="alert alert-success alert-float alert-dismissible fade show">
    {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-float alert-dismissible fade show">
    {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger alert-float alert-dismissible fade show">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@php
use Illuminate\Support\Facades\DB;
$livrableRows = DB::select("
    SELECT ls.id, ls.chapitre_code, ls.clause, ls.libelle, ls.ordre,
           COALESCE(pl.statut, 'Non commencé') as statut
    FROM livrables_smi ls
    LEFT JOIN projet_livrables pl ON pl.livrable_id = ls.id AND pl.projet_id = ?
    ORDER BY ls.ordre ASC
", [$projet->id]);

$livrablesByChap = [];
foreach ($livrableRows as $lrow) {
    $chap = $lrow->chapitre_code;
    if (!isset($livrablesByChap[$chap])) {
        $livrablesByChap[$chap] = ['items' => [], 'total' => 0, 'termines' => 0];
    }
    $livrablesByChap[$chap]['items'][] = $lrow;
    $livrablesByChap[$chap]['total']++;
    if ($lrow->statut === 'Terminé') $livrablesByChap[$chap]['termines']++;
}
$chapOrder  = ['§4','§5','§6','§7','§8','§9','§10','Transversal'];
$chapTitres = [
    '§4'          => 'Contexte',
    '§5'          => 'Leadership',
    '§6'          => 'Planification',
    '§7'          => 'Support',
    '§8'          => 'Réalisation',
    '§9'          => 'Évaluation',
    '§10'         => 'Amélioration',
    'Transversal' => 'Transversaux',
];
@endphp

<div class="site-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="logo">{{ $navTitle ?? 'LMC CONSEIL' }}</div>
                <div class="logo-sub">{{ $navSubtitle ?? 'Campagne 2025 — 2026' }}</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="meta-pill"><i class="bi bi-database me-1"></i>v2.0</span>
                <span class="meta-pill"><i class="bi bi-clock me-1"></i>{{ now()->format('d/m/Y') }}</span>
                <button class="theme-btn" id="themeToggle" title="Changer thème">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>
                @isset($navBackUrl)
                <a href="{{ $navBackUrl }}" class="btn-retour">
                    <i class="bi bi-arrow-left"></i> {{ $navBackLabel ?? 'Retour' }}
                </a>
                @endisset
                @unless(isset($navBackUrl))
                <form method="POST" action="/logout" style="margin:0">
                    @csrf
                    <button type="button" class="theme-btn" title="Déconnexion"
                        onclick="this.closest('form').submit()">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
                @endunless
            </div>
        </div>

        <div class="nav-wrap">
            <a href="/" class="nav-item {{ ($navActive ?? '') === 'donnees' ? 'active' : '' }}">
                <i class="bi bi-table"></i> Données
            </a>
            <a href="/tableau-de-bord" class="nav-item {{ ($navActive ?? '') === 'tableau' ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Tableau de Bord
            </a>
            <a href="/consultants" class="nav-item {{ ($navActive ?? '') === 'consultants' ? 'active' : '' }}">
                <i class="bi bi-people"></i> Consultants
            </a>
            <a href="/nouveau-projet" class="nav-item {{ ($navActive ?? '') === 'nouveau' ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Nouveau Projet
            </a>
            @isset($navExtra)
                {!! $navExtra !!}
            @endisset
            @if(auth()->check() && auth()->user()->isSuperAdmin())
            <a href="/admin/users" class="nav-item {{ ($navActive ?? '') === 'admin' ? 'active' : '' }}">
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

<div class="container py-4">
<form action="{{ route('projets.update', $projet->id) }}" method="POST">
@csrf @method('PUT')

{{-- A — INFOS --}}
<div class="form-card">
    <div class="section-title"><i class="bi bi-info-circle"></i> A — Informations Générales</div>
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Référence Projet</label>
            <input type="text" class="form-control" name="reference_projet" value="{{ old('reference_projet', $projet->reference_projet) }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Client <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="client_nom" value="{{ old('client_nom', $projet->client->nom_client ?? '') }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Chef de Projet <span class="text-danger">*</span></label>
            <select class="form-select" name="chef_projet_id" required>
                <option value="">-- Sélectionner --</option>
                @foreach($consultants as $cons)
                <option value="{{ $cons->id }}" {{ old('chef_projet_id', $projet->chef_projet_id) == $cons->id ? 'selected' : '' }}>{{ $cons->nom_complet }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Statut <span class="text-danger">*</span></label>
            <select class="form-select" name="statut" required>
                @foreach(['Planifié','En cours','En retard','Finalisé'] as $s)
                <option value="{{ $s }}" {{ old('statut', $projet->statut) == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Secteur d'activité</label>
            <input type="text" class="form-control" name="secteur_activite" value="{{ old('secteur_activite', $projet->client->secteur_activite ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Type Projet</label>
            <input type="text" class="form-control" name="type_projet" value="{{ old('type_projet', $projet->type_projet) }}">
        </div>
    </div>
</div>

{{-- DATES --}}
<div class="form-card">
    <div class="section-title"><i class="bi bi-calendar"></i> Dates</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Date début</label>
            <input type="date" class="form-control" name="date_debut" value="{{ old('date_debut', $projet->date_debut) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Date fin prévue</label>
            <input type="date" class="form-control" name="date_fin_prevue" value="{{ old('date_fin_prevue', $projet->date_fin_prevue) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Date fin réelle</label>
            <input type="date" class="form-control" name="date_fin_reelle" value="{{ old('date_fin_reelle', $projet->date_fin_reelle) }}">
        </div>
    </div>
</div>

{{-- INDICATEURS --}}
<div class="form-card">
    <div class="section-title"><i class="bi bi-graph-up"></i> Indicateurs</div>
    <div class="row g-3 align-items-start">
        <div class="col-md-4">
            <label class="form-label">Jours prévus</label>
            <input type="number" class="form-control" name="jours_prevus" id="jours_prevus"
                min="0" value="{{ old('jours_prevus', $projet->jours_prevus) }}" required oninput="recalcAll()">
        </div>
        <div class="col-md-4">
            <label class="form-label">
                Jours réalisés
                <span class="badge-auto blue"><i class="bi bi-lock-fill" style="font-size:.58rem;"></i> Auto</span>
            </label>
            <input type="number" class="form-control auto-blue" name="jours_realises" id="jours_realises"
                min="0" value="{{ old('jours_realises', $projet->jours_realises) }}" readonly>
            <div class="auto-tag"><i class="bi bi-calculator"></i> = Σ Jours d'intervention — Section C</div>
            <div class="mini-prog">
                <div class="mini-prog-row"><span>Consommation</span><span id="consoLabel">—</span></div>
                <div class="mini-prog-bar"><div class="mini-prog-fill fill-blue" id="consoBar" style="width:0%"></div></div>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label">
                Avancement %
                <span class="badge-auto purple"><i class="bi bi-lock-fill" style="font-size:.58rem;"></i> Auto</span>
            </label>
            <input type="number" class="form-control auto-purple" name="avancement_percent" id="avancement_percent"
                min="0" max="100" value="{{ old('avancement_percent', $projet->avancement_percent) }}" readonly>
            <div class="auto-tag"><i class="bi bi-bar-chart"></i> = Moyenne Av. % chapitres — Section C</div>
            <div class="mini-prog">
                <div class="mini-prog-row"><span>Avancement global</span><span id="avLabel">—</span></div>
                <div class="mini-prog-bar"><div class="mini-prog-fill fill-purple" id="avBar" style="width:0%"></div></div>
            </div>
        </div>
    </div>
</div>

{{-- NORMES --}}
<div class="form-card">
    <div class="section-title"><i class="bi bi-check-square"></i> Normes</div>
    <div class="row g-3">
        @foreach($normes as $norme)
        @php $checked = $projet->normes->contains('id', $norme->id); @endphp
        <div class="col-md-4 col-lg-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="normes[]" value="{{ $norme->id }}" id="norme{{ $norme->id }}" {{ $checked ? 'checked' : '' }}>
                <label class="form-check-label" for="norme{{ $norme->id }}">{{ $norme->code_norme }}</label>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- B — CONSULTANTS --}}
<div class="form-card">
    <div class="section-title"><i class="bi bi-people"></i> B — Charge de travail par consultant</div>
    <div id="existingConsultantsContainer">
        @forelse($projet->affectations as $aff)
        @php $charge = $aff->jours_alloues > 0 ? round(($aff->jours_realises / $aff->jours_alloues) * 100) : 0; @endphp
        <div class="cons-row" id="consultant-row-{{ $aff->consultant_id }}">
            <div class="row align-items-center g-3">
                <div class="col-md-3">
                    <span style="font-weight:600; font-size:.9rem;">
                        <i class="bi bi-person-circle me-1" style="color:var(--accent);"></i>{{ $aff->consultant->nom_complet }}
                    </span>
                    <input type="hidden" name="consultants[{{ $aff->consultant_id }}][id]" value="{{ $aff->consultant_id }}">
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" name="consultants[{{ $aff->consultant_id }}][role]">
                        @foreach(['Chef de Projet','Consultant','Consultant Ext.','Expert'] as $r)
                        <option value="{{ $r }}" {{ $aff->role_dans_projet == $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control form-control-sm" name="consultants[{{ $aff->consultant_id }}][jours_alloues]" min="0" step="0.1" value="{{ $aff->jours_alloues }}">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control form-control-sm" name="consultants[{{ $aff->consultant_id }}][jours_realises]" min="0" step="0.1" value="{{ $aff->jours_realises }}">
                </div>
                <div class="col-md-1 text-center"><span class="badge bg-info">{{ $charge }}%</span></div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeConsultant(this, {{ $aff->consultant_id }})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <p style="color:var(--muted); font-size:.85rem;">Aucun consultant associé.</p>
        @endforelse
    </div>
    <div id="newConsultantsContainer"></div>
    <div id="deletedConsultantsContainer"></div>
    <div class="add-section">
        <h6><i class="bi bi-plus-circle me-1"></i> Ajouter un consultant</h6>
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Consultant</label>
                <select class="form-select" id="existingConsultantSelect">
                    <option value="">-- Sélectionner --</option>
                    @foreach($consultants as $cons)
                    <option value="{{ $cons->id }}" data-nom="{{ $cons->nom_complet }}">{{ $cons->nom_complet }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Rôle</label>
                <select class="form-select" id="existingConsultantRole">
                    <option>Chef de Projet</option>
                    <option selected>Consultant</option>
                    <option>Consultant Ext.</option>
                    <option>Expert</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Jours alloués</label>
                <input type="number" class="form-control" id="existingConsultantJoursAlloues" min="0" step="0.1" value="0">
            </div>
            <div class="col-md-2">
                <label class="form-label">Jours réalisés</label>
                <input type="number" class="form-control" id="existingConsultantJoursRealises" min="0" step="0.1" value="0">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn-main w-100" onclick="addExistingConsultant()">
                    <i class="bi bi-plus-circle"></i> Ajouter
                </button>
            </div>
        </div>
    </div>
</div>

{{-- C — CHAPITRES SMI + LIVRABLES --}}
<div class="form-card">
    <div class="section-title">
        <i class="bi bi-journal-check"></i> C — Planification par chapitre SMI
        <span class="section-hint">
            <i class="bi bi-arrow-up" style="color:#3b82f6;"></i>
            <span style="color:#3b82f6; font-weight:600;">J. Interv.</span> → Jours réalisés
            &nbsp;·&nbsp;
            <i class="bi bi-arrow-up" style="color:var(--accent2);"></i>
            <span style="color:var(--accent2); font-weight:600;">Av. %</span> → Avancement global
        </span>
    </div>

    <div class="table-responsive">
        <table class="table-smi" style="min-width:900px;">
            <thead>
                <tr>
                    <th style="width:14%;">Chapitre</th>
                    <th style="width:22%;">Exigences Clés</th>
                    <th class="th-av" style="width:7%;"><i class="bi bi-bar-chart-fill me-1"></i>Av. %</th>
                    <th style="width:13%;">Phase</th>
                    <th class="th-jours" style="width:8%;"><i class="bi bi-clock-fill me-1"></i>J. Interv.</th>
                    <th>Observations</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projet->suiviChapitres as $index => $chap)
                <tr>
                    <td>
                        <strong style="color:var(--accent);">{{ $chap->chapitre->code_chapitre }}</strong><br>
                        <small style="color:var(--muted); display:block; margin-top:.2rem; line-height:1.3;">{{ $chap->chapitre->titre_chapitre }}</small>
                        <input type="hidden" name="chapitres[{{ $index }}][id]" value="{{ $chap->id }}">
                        <input type="hidden" name="chapitres[{{ $index }}][chapitre_id]" value="{{ $chap->chapitre_id }}">
                    </td>
                    <td>
                        <textarea class="form-control form-control-sm" rows="3" readonly>{{ $chap->chapitre->exigences_cles }}</textarea>
                    </td>
                    <td class="col-av">
                        <input type="number" class="form-control smi-num smi-av"
                            name="chapitres[{{ $index }}][avancement]"
                            min="0" max="100" value="{{ $chap->avancement_percent }}"
                            style="width:70px;" oninput="recalcAll()">
                    </td>
                    <td>
                        <select class="form-select form-select-sm" name="chapitres[{{ $index }}][phase]">
                            @foreach(['⬜ Non démarré','⏳ Démarré','🔄 En cours','✅ Terminé'] as $phase)
                            <option value="{{ $phase }}" {{ $chap->phase == $phase ? 'selected' : '' }}>{{ $phase }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="col-jours">
                        <input type="number" class="form-control smi-num smi-jours"
                            name="chapitres[{{ $index }}][jours]"
                            min="0" value="{{ $chap->jours_intervention }}"
                            style="width:70px;" oninput="recalcAll()">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="chapitres[{{ $index }}][observations]" value="{{ $chap->observations }}" placeholder="—">
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align:right; color:var(--muted); font-size:.77rem; font-weight:500;">
                        <i class="bi bi-calculator me-1"></i> Résultats →
                    </td>
                    <td class="foot-purple col-av">
                        <span id="footAvancement">{{ $projet->avancement_percent }}</span>%
                        <div class="foot-sub">moyenne</div>
                    </td>
                    <td style="background:var(--surface2);"></td>
                    <td class="foot-blue col-jours">
                        <span id="footJours">{{ $projet->suiviChapitres->sum('jours_intervention') }}</span>
                        <div class="foot-sub">total j.</div>
                    </td>
                    <td style="background:var(--surface2);"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- ══ LIVRABLES SMI ══ --}}
    @if(count($livrablesByChap))
    <div class="liv-section">
        <div class="liv-section-title">
            <i class="bi bi-list-check" style="color:var(--accent);"></i>
            Livrables SMI
            @php
                $totalLiv    = collect($livrablesByChap)->sum('total');
                $terminesLiv = collect($livrablesByChap)->sum('termines');
                $pctLiv      = $totalLiv > 0 ? round(($terminesLiv / $totalLiv) * 100) : 0;
            @endphp
            <span style="margin-left:auto; font-size:.72rem; color:var(--muted); display:flex; align-items:center; gap:.5rem;">
                <span style="color:#10b981; font-weight:700;">{{ $terminesLiv }}</span> / {{ $totalLiv }} terminés
                <span style="background:rgba(16,185,129,.12); color:#10b981; padding:.12rem .55rem; border-radius:50px; font-weight:700; font-size:.7rem;">{{ $pctLiv }}%</span>
            </span>
        </div>

        @foreach($chapOrder as $chapCode)
        @if(isset($livrablesByChap[$chapCode]))
        @php
            $chapData   = $livrablesByChap[$chapCode];
            $pct        = $chapData['total'] > 0 ? round(($chapData['termines'] / $chapData['total']) * 100) : 0;
            $badgeClass = $pct === 100 ? 'done' : ($pct > 0 ? 'partial' : 'none');
            $badgeLabel = $pct === 100 ? '✅ Terminé' : ($pct > 0 ? '🔄 En cours' : '⬜ Planifié');
            $accId      = 'eacc-' . str_replace(['§',' '],['s','-'], $chapCode);
        @endphp
        <div class="liv-accordion">
            <div class="liv-header" onclick="toggleAcc('{{ $accId }}')" id="hdr-{{ $accId }}">
                <span class="liv-chap-code">{{ $chapCode }}</span>
                <span class="liv-chap-titre">{{ $chapTitres[$chapCode] ?? $chapCode }}</span>
                <span class="liv-counter">
                    <i class="bi bi-file-earmark-check"></i>
                    {{ $chapData['termines'] }} / {{ $chapData['total'] }}
                </span>
                <div class="liv-prog-wrap">
                    <div class="liv-prog-bg">
                        <div class="liv-prog-fill" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
                <span class="liv-badge-statut {{ $badgeClass }}">{{ $badgeLabel }}</span>
                <i class="bi bi-chevron-down liv-arrow"></i>
            </div>
            <div class="liv-body" id="{{ $accId }}">
                @foreach($chapData['items'] as $liv)
                @php
                    $selClass = match($liv->statut) {
                        'Terminé'     => 's-ok',
                        'En cours'    => 's-ec',
                        default       => 's-nc',
                    };
                @endphp
                <div class="liv-row">
                    <span class="liv-clause">{{ $liv->clause ?: '—' }}</span>
                    <span class="liv-libelle">{{ $liv->libelle }}</span>
                    <select class="liv-statut-select {{ $selClass }}"
                            name="livrables[{{ $liv->id }}]"
                            onchange="onLivChange(this, '{{ $accId }}')">
                        <option value="Non commencé" {{ $liv->statut === 'Non commencé' ? 'selected' : '' }}>⬜ Non commencé</option>
                        <option value="En cours"     {{ $liv->statut === 'En cours'     ? 'selected' : '' }}>🔄 En cours</option>
                        <option value="Terminé"      {{ $liv->statut === 'Terminé'      ? 'selected' : '' }}>✅ Terminé</option>
                    </select>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @endif

</div>{{-- fin Section C --}}

{{-- D — FORMATIONS --}}
<div class="form-card">
    <div class="section-title"><i class="bi bi-mortarboard"></i> D — Plan de formation</div>
    <div class="table-responsive">
        <table class="table table-bordered" style="font-size:.83rem;">
            <thead>
                <tr style="background:var(--thead-bg);">
                    <th style="color:var(--thead-text);">Formation</th>
                    <th style="color:var(--thead-text); width:180px;">Statut</th>
                    <th style="color:var(--thead-text);">Observations</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projet->formations as $index => $form)
                <tr>
                    <td style="color:var(--text);">
                        <input type="hidden" name="formations[{{ $index }}][id]" value="{{ $form->id }}">
                        {{ $form->titre_formation }}
                    </td>
                    <td>
                        <select class="form-select form-select-sm" name="formations[{{ $index }}][statut]">
                            @foreach(['À planifier','En cours','Réalisée','Finalisée'] as $st)
                            <option value="{{ $st }}" {{ $form->pivot->statut == $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="formations[{{ $index }}][observations]" value="{{ $form->pivot->observations }}" placeholder="—">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- E — CONTRAINTES --}}
<div class="form-card">
    <div class="section-title"><i class="bi bi-exclamation-triangle"></i> E — Contraintes & Points de vigilance</div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Blocage</label>
            <textarea class="form-control" name="blocage" rows="3">{{ old('blocage', $projet->blocage) }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Commentaire</label>
            <textarea class="form-control" name="commentaire" rows="3">{{ old('commentaire', $projet->commentaire) }}</textarea>
        </div>
    </div>
</div>

{{-- BOUTONS --}}
<div class="d-flex justify-content-end gap-3 mb-5">
    <a href="{{ route('projet.details', $projet->id) }}" class="btn-cancel">
        <i class="bi bi-x-circle"></i> Annuler
    </a>
    <button type="submit" class="btn-main px-5">
        <i class="bi bi-check-circle"></i> Mettre à jour
    </button>
</div>

</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ── Theme ── */
(function() {
    const t = localStorage.getItem('lmc-theme') || 'light';
    document.documentElement.setAttribute('data-theme', t);
    document.getElementById('themeIcon').className = t === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
})();
document.getElementById('themeToggle').addEventListener('click', () => {
    const next = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('lmc-theme', next);
    document.getElementById('themeIcon').className = next === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
});

/* ── Recalc ── */
function recalcAll() {
    const jp = parseFloat(document.getElementById('jours_prevus').value) || 0;
    let totalJ = 0;
    document.querySelectorAll('input[name^="chapitres"][name$="[jours]"]').forEach(i => { totalJ += parseFloat(i.value) || 0; });
    totalJ = Math.round(totalJ * 10) / 10;
    document.getElementById('jours_realises').value    = totalJ;
    document.getElementById('footJours').textContent   = totalJ;
    const conso = jp > 0 ? Math.round((totalJ / jp) * 100) : 0;
    document.getElementById('consoLabel').textContent  = conso + '%';
    document.getElementById('consoBar').style.width    = Math.min(conso, 100) + '%';

    const avInputs = document.querySelectorAll('input[name^="chapitres"][name$="[avancement]"]');
    let sumAv = 0, countAv = 0;
    avInputs.forEach(i => { const v = parseFloat(i.value); if (!isNaN(v)) { sumAv += v; countAv++; } });
    const avgAv = countAv > 0 ? Math.round(sumAv / countAv) : 0;
    document.getElementById('avancement_percent').value  = avgAv;
    document.getElementById('footAvancement').textContent = avgAv;
    document.getElementById('avLabel').textContent = avgAv + '%';
    document.getElementById('avBar').style.width   = avgAv + '%';
}
document.addEventListener('DOMContentLoaded', recalcAll);

/* ── Accordion ── */
function toggleAcc(id) {
    document.getElementById(id).classList.toggle('open');
    document.getElementById('hdr-' + id).classList.toggle('open');
}

/* ── Livrable change ── */
function onLivChange(select, accId) {
    select.className = 'liv-statut-select ' + ({'Terminé':'s-ok','En cours':'s-ec','Non commencé':'s-nc'}[select.value] || 's-nc');
    updateChapCounter(accId);
}

function updateChapCounter(accId) {
    const body = document.getElementById(accId);
    if (!body) return;
    const selects = body.querySelectorAll('.liv-statut-select');
    let total = selects.length, termines = 0;
    selects.forEach(s => { if (s.value === 'Terminé') termines++; });
    const pct = total > 0 ? Math.round((termines / total) * 100) : 0;
    const hdr = document.getElementById('hdr-' + accId);
    const fill = hdr.querySelector('.liv-prog-fill');
    if (fill) fill.style.width = pct + '%';
    const counter = hdr.querySelector('.liv-counter');
    if (counter) counter.innerHTML = `<i class="bi bi-file-earmark-check"></i> ${termines} / ${total}`;
    const badge = hdr.querySelector('.liv-badge-statut');
    if (badge) {
        badge.className = 'liv-badge-statut ' + (pct === 100 ? 'done' : pct > 0 ? 'partial' : 'none');
        badge.textContent = pct === 100 ? '✅ Terminé' : pct > 0 ? '🔄 En cours' : '⬜ Planifié';
    }
}

/* ── Consultants ── */
function addExistingConsultant() {
    const select = document.getElementById('existingConsultantSelect');
    const consId = select.value;
    const consNom = select.options[select.selectedIndex]?.getAttribute('data-nom') || '';
    const role   = document.getElementById('existingConsultantRole').value;
    const joursA = parseFloat(document.getElementById('existingConsultantJoursAlloues').value) || 0;
    const joursR = parseFloat(document.getElementById('existingConsultantJoursRealises').value) || 0;
    if (!consId) { alert('Veuillez sélectionner un consultant'); return; }
    if (document.getElementById(`consultant-row-${consId}`)) { alert('Ce consultant est déjà affecté'); return; }
    const charge = joursA > 0 ? Math.round((joursR / joursA) * 100) : 0;
    document.getElementById('newConsultantsContainer').insertAdjacentHTML('beforeend', `
        <div class="cons-row mt-2" id="consultant-row-${consId}">
            <div class="row align-items-center g-3">
                <div class="col-md-3">
                    <span style="font-weight:600;font-size:.9rem;"><i class="bi bi-person-plus-fill me-1" style="color:#10b981;"></i>${consNom}</span>
                    <input type="hidden" name="consultants[${consId}][id]" value="${consId}">
                    <span class="badge bg-success ms-1" style="font-size:.62rem;">Nouveau</span>
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" name="consultants[${consId}][role]">
                        <option ${role==='Chef de Projet'?'selected':''}>Chef de Projet</option>
                        <option ${role==='Consultant'?'selected':''}>Consultant</option>
                        <option ${role==='Consultant Ext.'?'selected':''}>Consultant Ext.</option>
                        <option ${role==='Expert'?'selected':''}>Expert</option>
                    </select>
                </div>
                <div class="col-md-2"><input type="number" class="form-control form-control-sm" name="consultants[${consId}][jours_alloues]" min="0" step="0.1" value="${joursA}"></div>
                <div class="col-md-2"><input type="number" class="form-control form-control-sm" name="consultants[${consId}][jours_realises]" min="0" step="0.1" value="${joursR}"></div>
                <div class="col-md-1 text-center"><span class="badge bg-info">${charge}%</span></div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeConsultant(this,${consId})"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>`);
    select.value = '';
    document.getElementById('existingConsultantRole').value = 'Consultant';
    document.getElementById('existingConsultantJoursAlloues').value = '0';
    document.getElementById('existingConsultantJoursRealises').value = '0';
}

function removeConsultant(btn, consId) {
    if (confirm('Supprimer ce consultant du projet ?')) {
        btn.closest('.cons-row').remove();
        document.getElementById('deletedConsultantsContainer').insertAdjacentHTML('beforeend',
            `<input type="hidden" name="deleted_consultants[]" value="${consId}">`);
    }
}

setTimeout(() => document.querySelectorAll('.alert-float').forEach(a => a.remove()), 5000);
</script>
</body>
</html>