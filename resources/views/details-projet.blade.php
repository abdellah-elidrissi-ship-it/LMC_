<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Projet - LMC Conseil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        [data-theme="light"] {
            --bg:#f1f5f9; --surface:#ffffff; --surface2:#f8fafc; --border:#e2e8f0;
            --text:#0f172a; --text2:#475569; --muted:#94a3b8; --accent:#3b82f6;
            --shadow:0 2px 12px rgba(0,0,0,.06); --shadow-md:0 4px 20px rgba(0,0,0,.08);
        }
        [data-theme="dark"] {
            --bg:#0f172a; --surface:#1e293b; --surface2:#162032; --border:#334155;
            --text:#e2e8f0; --text2:#94a3b8; --muted:#64748b; --accent:#3b82f6;
            --shadow:0 2px 12px rgba(0,0,0,.3); --shadow-md:0 4px 20px rgba(0,0,0,.4);
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

        .btn-retour { background:rgba(255,255,255,.1); border:1.5px solid rgba(255,255,255,.2); color:white; padding:.55rem 1.4rem; border-radius:50px; font-weight:600; font-size:.83rem; text-decoration:none; transition:.2s; display:inline-flex; align-items:center; gap:.4rem; }
        .btn-retour:hover { background:white; color:#0f172a; }

        .detail-card { background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:1.5rem; box-shadow:var(--shadow); margin-bottom:1.3rem; transition:background .3s; }

        .section-title { font-size:1rem; font-weight:700; color:var(--text); margin-bottom:1.2rem; padding-bottom:.6rem; border-bottom:2px solid var(--accent); display:flex; align-items:center; gap:.5rem; }
        .section-title i { color:var(--accent); }

        .info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:.9rem; }
        .info-item { background:var(--surface2); padding:.9rem 1rem; border-radius:12px; border-left:3px solid var(--accent); }
        .info-label { font-size:.7rem; font-weight:600; text-transform:uppercase; letter-spacing:.07em; color:var(--muted); margin-bottom:.3rem; }
        .info-value { font-weight:600; font-size:.95rem; color:var(--text); }
        .info-sub { font-size:.78rem; color:var(--muted); margin-top:.2rem; }

        .bs { padding:.28rem .85rem; border-radius:50px; font-weight:600; font-size:.72rem; display:inline-block; }
        [data-theme="light"] .bs.finalise { background:#dcfce7; color:#166534; }
        [data-theme="light"] .bs.retard   { background:#fee2e2; color:#991b1b; }
        [data-theme="light"] .bs.cours    { background:#ffedd5; color:#9a3412; }
        [data-theme="light"] .bs.planifie { background:#ede9fe; color:#4c1d95; }
        [data-theme="dark"]  .bs.finalise { background:rgba(16,185,129,.15); color:#34d399; }
        [data-theme="dark"]  .bs.retard   { background:rgba(239,68,68,.15);  color:#f87171; }
        [data-theme="dark"]  .bs.cours    { background:rgba(249,115,22,.15); color:#fb923c; }
        [data-theme="dark"]  .bs.planifie { background:rgba(99,102,241,.15); color:#a5b4fc; }

        .norme-pill { background:var(--surface2); border:1px solid var(--border); color:var(--text2); padding:.25rem .75rem; border-radius:50px; font-size:.78rem; font-weight:500; display:inline-block; margin:.2rem; }

        .kpi-box { background:var(--surface2); border-radius:14px; padding:1rem; text-align:center; }
        .kpi-label { font-size:.72rem; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; margin-bottom:.4rem; }
        .kpi-value { font-size:1.8rem; font-weight:700; color:var(--text); line-height:1; }

        .prog-bg { height:7px; background:var(--border); border-radius:50px; overflow:hidden; margin-top:.8rem; }
        .prog-fill { height:100%; border-radius:50px; background:linear-gradient(90deg,#3b82f6,#8b5cf6); }

        .table-pro { width:100%; border-collapse:collapse; font-size:.83rem; }
        .table-pro thead th { background:var(--surface2); color:var(--muted); padding:.65rem .75rem; font-weight:600; font-size:.73rem; text-transform:uppercase; letter-spacing:.05em; border-bottom:2px solid var(--border); }
        .table-pro tbody td { padding:.65rem .75rem; border-bottom:1px solid var(--border); color:var(--text); vertical-align:middle; }
        .table-pro tbody tr:last-child td { border-bottom:none; }
        .table-pro tbody tr:hover td { background:var(--surface2); }

        .exig-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:1.3rem; margin-bottom:1.3rem; }
        .exig-title { font-size:.88rem; font-weight:700; color:var(--accent); margin-bottom:.9rem; padding-bottom:.5rem; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:.4rem; }
        .exig-item { margin-bottom:.9rem; padding-bottom:.9rem; border-bottom:1px solid var(--border); }
        .exig-item:last-child { border-bottom:none; margin-bottom:0; padding-bottom:0; }
        .exig-chap { font-size:.82rem; font-weight:700; color:var(--accent); }
        .exig-titre { font-size:.82rem; color:var(--text2); margin-bottom:.3rem; }
        .exig-content { font-size:.8rem; color:var(--muted); line-height:1.6; }

        .phase-done    { background:rgba(16,185,129,.15); color:#10b981; font-size:.72rem; font-weight:600; padding:.2rem .65rem; border-radius:50px; }
        .phase-inprog  { background:rgba(251,191,36,.15); color:#f59e0b; font-size:.72rem; font-weight:600; padding:.2rem .65rem; border-radius:50px; }
        .phase-started { background:rgba(59,130,246,.15); color:#3b82f6; font-size:.72rem; font-weight:600; padding:.2rem .65rem; border-radius:50px; }
        .phase-none    { background:rgba(148,163,184,.15); color:#94a3b8; font-size:.72rem; font-weight:600; padding:.2rem .65rem; border-radius:50px; }

        [data-theme="dark"] .alert-danger { background:rgba(239,68,68,.12); border-color:rgba(239,68,68,.25); color:#fca5a5; }
        [data-theme="dark"] .alert-info   { background:rgba(59,130,246,.12); border-color:rgba(59,130,246,.25); color:#93c5fd; }

        /* ── Livrables Accordion ── */
        .liv-accordion { border:1px solid var(--border); border-radius:14px; overflow:hidden; margin-bottom:.7rem; }
        .liv-header {
            display:flex; align-items:center; gap:.75rem;
            padding:.85rem 1.1rem; cursor:pointer;
            background:var(--surface2);
            border-bottom:1px solid transparent;
            transition:background .2s;
            user-select:none;
        }
        .liv-header:hover { background:rgba(59,130,246,.05); }
        .liv-header.open { border-bottom:1px solid var(--border); background:var(--surface); }
        .liv-chap-code { font-size:.95rem; font-weight:700; color:var(--accent); min-width:42px; }
        .liv-chap-titre { font-size:.85rem; font-weight:600; color:var(--text); flex:1; }
        .liv-counter { font-size:.75rem; color:var(--muted); display:flex; align-items:center; gap:.4rem; }
        .liv-prog-wrap { width:110px; }
        .liv-prog-bg { height:5px; background:var(--border); border-radius:50px; overflow:hidden; }
        .liv-prog-fill { height:100%; border-radius:50px; background:linear-gradient(90deg,#10b981,#34d399); transition:width .35s; }
        .liv-badge-statut {
            font-size:.7rem; font-weight:600; padding:.2rem .65rem; border-radius:50px;
        }
        .liv-badge-statut.done    { background:rgba(16,185,129,.15); color:#10b981; }
        .liv-badge-statut.partial { background:rgba(251,191,36,.15);  color:#f59e0b; }
        .liv-badge-statut.none    { background:rgba(148,163,184,.15); color:#94a3b8; }
        .liv-arrow { color:var(--muted); font-size:.8rem; transition:transform .25s; }
        .liv-header.open .liv-arrow { transform:rotate(180deg); }

        .liv-body { display:none; padding:.2rem 0; }
        .liv-body.open { display:block; }

        .liv-row {
            display:grid; grid-template-columns:70px 1fr auto;
            align-items:center; gap:.75rem;
            padding:.6rem 1.1rem;
            border-bottom:1px solid var(--border);
            transition:background .15s;
        }
        .liv-row:last-child { border-bottom:none; }
        .liv-row:hover { background:rgba(59,130,246,.03); }
        .liv-clause { font-size:.75rem; font-weight:600; color:var(--accent); }
        .liv-libelle { font-size:.82rem; color:var(--text2); line-height:1.4; }
        .liv-save-indicator { display:none; } /* unused in details */
    </style>
</head>
<body>

@php
use Illuminate\Support\Facades\DB;
$id = request()->route('id') ?? request()->query('id') ?? 0;
if($id == 0) { echo "<div class='alert alert-danger m-5'>❌ Projet non spécifié</div>"; return; }

$projet = DB::selectOne("
    SELECT p.*, c.nom_client, c.secteur_activite, cons.nom_complet as chef_nom, cons.email as chef_email
    FROM projets p
    LEFT JOIN clients c ON p.client_id = c.id
    LEFT JOIN consultants cons ON p.chef_projet_id = cons.id
    WHERE p.id = ?
", [$id]);

if(!$projet) { echo "<div class='alert alert-warning m-5'>⚠️ Projet introuvable</div>"; return; }

$normes      = DB::select("SELECT n.* FROM normes n JOIN projet_normes pn ON n.id = pn.norme_id WHERE pn.projet_id = ?", [$id]);
$consultants = DB::select("SELECT cons.*, a.role_dans_projet, a.jours_alloues, a.jours_realises FROM affectations a JOIN consultants cons ON a.consultant_id = cons.id WHERE a.projet_id = ?", [$id]);
$chapitres   = DB::select("SELECT sc.*, cs.code_chapitre, cs.titre_chapitre, cs.exigences_cles FROM suivi_chapitres sc JOIN chapitres_smis cs ON sc.chapitre_id = cs.id WHERE sc.projet_id = ? ORDER BY cs.ordre", [$id]);
$formations  = DB::select("SELECT f.*, pf.statut, pf.observations FROM formations f JOIN projet_formations pf ON f.id = pf.formation_id WHERE pf.projet_id = ?", [$id]);
$conso       = $projet->jours_prevus > 0 ? round(($projet->jours_realises / $projet->jours_prevus) * 100) : 0;
$sc = match($projet->statut) { 'Finalisé' => 'finalise', 'En retard' => 'retard', 'En cours' => 'cours', default => 'planifie' };

// Stats Gantt pour affichage rapide
$ganttCount = DB::table('gantt_taches')->where('projet_id', $id)->count();

// ── Livrables SMI par chapitre ──────────────────────────────────
$livrableRows = DB::select("
    SELECT
        ls.id, ls.chapitre_code, ls.clause, ls.libelle, ls.phase_smi, ls.ordre,
        COALESCE(pl.statut, 'Non commencé') as statut
    FROM livrables_smi ls
    LEFT JOIN projet_livrables pl ON pl.livrable_id = ls.id AND pl.projet_id = ?
    ORDER BY ls.ordre ASC
", [$id]);

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

// Calculs chapitres
$chapsColl         = collect($chapitres);
$joursRealisesCalc = $chapsColl->sum('jours_intervention');
$avancementCalc    = $chapsColl->count() > 0 ? round($chapsColl->avg('avancement_percent')) : 0;
$ecart             = $joursRealisesCalc - $projet->jours_prevus;
$totalChap         = $chapsColl->count();
$doneChap          = $chapsColl->where('phase', '✅ Terminé')->count();
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

    <!-- Infos Générales -->
    <div class="detail-card">
        <div class="section-title"><i class="bi bi-info-circle"></i> Informations Générales</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Statut</div>
                <div class="info-value"><span class="bs {{ $sc }}">{{ $projet->statut }}</span></div>
            </div>
            <div class="info-item">
                <div class="info-label">Chef de Projet</div>
                <div class="info-value">{{ $projet->chef_nom ?? '—' }}</div>
                @if($projet->chef_email)<div class="info-sub">{{ $projet->chef_email }}</div>@endif
            </div>
            <div class="info-item">
                <div class="info-label">Client</div>
                <div class="info-value">{{ $projet->nom_client }}</div>
                <div class="info-sub">{{ $projet->secteur_activite ?? 'Secteur non spécifié' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Dates</div>
                <div class="info-value" style="font-size:.85rem;">Début: {{ $projet->date_debut ?? '—' }}</div>
                <div class="info-sub">Fin prévue: {{ $projet->date_fin_prevue ?? '—' }}</div>
            </div>
        </div>

        @if(count($normes))
        <div class="mt-3">
            <div class="info-label mb-1">Normes d'accompagnement</div>
            @foreach($normes as $n)
                <span class="norme-pill">{{ $n->code_norme }}</span>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Indicateurs -->
    <div class="detail-card">
        <div class="section-title"><i class="bi bi-graph-up"></i> Indicateurs de Suivi</div>
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="kpi-box">
                    <div class="kpi-label">Jours Prévus</div>
                    <div class="kpi-value">{{ $projet->jours_prevus }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="kpi-box">
                    <div class="kpi-label">Jours Réalisés</div>
                    <div class="kpi-value">{{ $joursRealisesCalc }}</div>
                    <div style="font-size:.68rem; color:var(--muted); margin-top:.2rem;">= Σ J. Intervention</div>
                </div>
            </div>
            @php
                $consoCalc = $projet->jours_prevus > 0 ? round(($joursRealisesCalc / $projet->jours_prevus) * 100) : 0;
                $ecartCalc = $joursRealisesCalc - $projet->jours_prevus;
            @endphp
            <div class="col-md-3 col-6">
                <div class="kpi-box">
                    <div class="kpi-label">Consommation</div>
                    <div class="kpi-value">{{ $consoCalc }}%</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="kpi-box">
                    <div class="kpi-label">Écart</div>
                    <div class="kpi-value" style="color:{{ $ecartCalc >= 0 ? '#10b981' : '#ef4444' }};">
                        {{ $ecartCalc > 0 ? '+' : '' }}{{ $ecartCalc }}
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <div class="d-flex justify-content-between" style="font-size:.85rem; margin-bottom:.4rem;">
                <span style="color:var(--text2); font-weight:500;">Avancement global</span>
                <span style="font-weight:700; color:var(--text);">{{ $avancementCalc }}%</span>
            </div>
            <div class="prog-bg">
                <div class="prog-fill" style="width:{{ $avancementCalc }}%"></div>
            </div>
        </div>
    </div>

    <!-- Exigences SMI -->
    @if(count($chapitres))
    <div class="exig-card">
        <div class="exig-title"><i class="bi bi-list-check"></i> Exigences Clés SMI</div>
        @foreach($chapitres as $chap)
        <div class="exig-item">
            <span class="exig-chap">{{ $chap->code_chapitre }}</span>
            <span class="exig-titre"> — {{ $chap->titre_chapitre }}</span>
            @if($chap->exigences_cles)
            <div class="exig-content mt-1">{!! nl2br(e($chap->exigences_cles)) !!}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Chapitres SMI -->
    <div class="detail-card">
        <div class="section-title"><i class="bi bi-journal-check"></i> Suivi des Chapitres SMI</div>
        <div class="table-responsive">
            <table class="table-pro">
                <thead>
                    <tr>
                        <th>Chapitre</th>
                        <th class="text-center th-av">Av. %</th>
                        <th>Phase</th>
                        <th class="text-center th-jours">J. Interv.</th>
                        <th>Observations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chapitres as $chap)
                    @php
                        $phaseClass = match($chap->phase) {
                            '✅ Terminé'   => 'phase-done',
                            '🔄 En cours'  => 'phase-inprog',
                            '⏳ Démarré'   => 'phase-started',
                            default        => 'phase-none'
                        };
                    @endphp
                    <tr>
                        <td><strong style="color:var(--accent);">{{ $chap->code_chapitre }}</strong> <span style="color:var(--muted);">— {{ $chap->titre_chapitre }}</span></td>
                        <td class="td-av">{{ $chap->avancement_percent }}%</td>
                        <td><span class="{{ $phaseClass }}">{{ $chap->phase }}</span></td>
                        <td class="td-jours">{{ $chap->jours_intervention }}</td>
                        <td style="color:var(--muted); font-size:.8rem;">{{ Str::limit($chap->observations ?? '—', 40) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="1" style="text-align:right; color:var(--muted); font-size:.77rem; font-weight:500;"><i class="bi bi-calculator me-1"></i> Résultats →</td>
                        <td class="foot-av">{{ $avancementCalc }}%<div class="foot-note">moyenne</div></td>
                        <td style="background:var(--surface2);"></td>
                        <td class="foot-jours">{{ $joursRealisesCalc }}<div class="foot-note">total j.</div></td>
                        <td style="background:var(--surface2);"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div style="margin-top:1.2rem; padding-top:1rem; border-top:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:.82rem; font-weight:600; color:var(--text2); display:flex; align-items:center; gap:.4rem;">
                <i class="bi bi-check-circle-fill" style="color:#10b981;"></i> Chapitres terminés
            </span>
            <span style="font-size:.9rem; font-weight:700; color:var(--text);">{{ $doneChap }} / {{ $totalChap }}</span>
        </div>
    </div>

    <!-- ══ LIVRABLES SMI ══ -->
    @if(count($livrablesByChap))
    <div class="detail-card">
        <div class="section-title">
            <i class="bi bi-list-check"></i> Livrables SMI
            @php
                $totalLiv   = collect($livrablesByChap)->sum('total');
                $terminesLiv = collect($livrablesByChap)->sum('termines');
                $pctLiv     = $totalLiv > 0 ? round(($terminesLiv / $totalLiv) * 100) : 0;
            @endphp
            <span style="margin-left:auto; font-size:.75rem; font-weight:500; color:var(--muted); display:flex; align-items:center; gap:.5rem;">
                <span style="color:#10b981; font-weight:700;">{{ $terminesLiv }}</span> / {{ $totalLiv }} terminés
                <span style="background:rgba(16,185,129,.12); color:#10b981; padding:.15rem .6rem; border-radius:50px; font-weight:700; font-size:.72rem;">{{ $pctLiv }}%</span>
            </span>
        </div>

        @php
            $chapOrder = ['§4','§5','§6','§7','§8','§9','§10','Transversal'];
            $chapTitres = [
                '§4'          => 'Contexte de l\'organisme',
                '§5'          => 'Leadership & Engagement',
                '§6'          => 'Planification',
                '§7'          => 'Support',
                '§8'          => 'Réalisation des opérations',
                '§9'          => 'Évaluation des performances',
                '§10'         => 'Amélioration',
                'Transversal' => 'Documents Transversaux',
            ];
        @endphp

        @foreach($chapOrder as $chapCode)
        @if(isset($livrablesByChap[$chapCode]))
        @php
            $chapData = $livrablesByChap[$chapCode];
            $pct = $chapData['total'] > 0 ? round(($chapData['termines'] / $chapData['total']) * 100) : 0;
            $badgeClass = $pct === 100 ? 'done' : ($pct > 0 ? 'partial' : 'none');
            $badgeLabel = $pct === 100 ? '✅ Terminé' : ($pct > 0 ? '🔄 En cours' : '⬜ Planifié');
            $accordionId = 'acc-' . str_replace(['§', ' '], ['s', '-'], $chapCode);
        @endphp
        <div class="liv-accordion">
            <div class="liv-header" onclick="toggleAcc('{{ $accordionId }}')" id="hdr-{{ $accordionId }}">
                <span class="liv-chap-code">{{ $chapCode }}</span>
                <span class="liv-chap-titre">{{ $chapTitres[$chapCode] ?? $chapCode }}</span>
                <span class="liv-counter">
                    <i class="bi bi-file-earmark-check"></i>
                    {{ $chapData['termines'] }} / {{ $chapData['total'] }} livrables
                </span>
                <div class="liv-prog-wrap">
                    <div class="liv-prog-bg">
                        <div class="liv-prog-fill" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
                <span class="liv-badge-statut {{ $badgeClass }}">{{ $badgeLabel }}</span>
                <i class="bi bi-chevron-down liv-arrow"></i>
            </div>
            <div class="liv-body" id="{{ $accordionId }}">
                @foreach($chapData['items'] as $liv)
                <div class="liv-row" id="liv-row-{{ $liv->id }}">
                    <span class="liv-clause">{{ $liv->clause ?: '—' }}</span>
                    <span class="liv-libelle">{{ $liv->libelle }}</span>
                    @php
                        $badgeStatut = match($liv->statut) {
                            'Terminé'  => ['class' => 'done',    'label' => '✅ Terminé'],
                            'En cours' => ['class' => 'partial', 'label' => '🔄 En cours'],
                            default    => ['class' => 'none',    'label' => '⬜ Non commencé'],
                        };
                    @endphp
                    <span class="liv-badge-statut {{ $badgeStatut['class'] }}">{{ $badgeStatut['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @endif

    <!-- Consultants + Formations -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="detail-card" style="height:100%;">
                <div class="section-title"><i class="bi bi-people"></i> Charge de travail</div>
                @if(count($consultants))
                <table class="table-pro">
                    <thead>
                        <tr>
                            <th>Consultant</th>
                            <th>Rôle</th>
                            <th class="text-center">J.All.</th>
                            <th class="text-center">J.Réal.</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultants as $c)
                        @php $ch = $c->jours_alloues > 0 ? round(($c->jours_realises / $c->jours_alloues) * 100) : 0; @endphp
                        <tr>
                            <td style="font-weight:500;">{{ $c->nom_complet }}</td>
                            <td style="color:var(--muted); font-size:.78rem;">{{ $c->role_dans_projet }}</td>
                            <td class="text-center">{{ $c->jours_alloues }}</td>
                            <td class="text-center">{{ $c->jours_realises }}</td>
                            <td class="text-center"><strong>{{ $ch }}%</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p style="color:var(--muted); font-size:.85rem; text-align:center; padding:1rem 0;">Aucun consultant affecté</p>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="detail-card" style="height:100%;">
                <div class="section-title"><i class="bi bi-mortarboard"></i> Plan de Formation</div>
                <table class="table-pro">
                    <thead>
                        <tr>
                            <th>Formation</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formations as $f)
                        @php
                            $fClass = match($f->statut) {
                                'Finalisée'  => 'phase-done',
                                'Réalisée'   => 'phase-inprog',
                                'En cours'   => 'phase-started',
                                default      => 'phase-none'
                            };
                        @endphp
                        <tr>
                            <td>{{ $f->titre_formation }}</td>
                            <td><span class="{{ $fClass }}">{{ $f->statut }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Blocage & Commentaire -->
    @if(($projet->blocage && $projet->blocage != 'RAS') || $projet->commentaire)
    <div class="detail-card mt-3">
        <div class="section-title"><i class="bi bi-exclamation-triangle"></i> Points d'attention</div>
        @if($projet->blocage && $projet->blocage != 'RAS')
        <div class="alert alert-danger" style="border-radius:12px; font-size:.88rem;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Blocage :</strong> {{ $projet->blocage }}
        </div>
        @endif
        @if($projet->commentaire)
        <div class="alert alert-info" style="border-radius:12px; font-size:.88rem;">
            <i class="bi bi-chat-fill me-2"></i>
            <strong>Commentaire :</strong> {{ $projet->commentaire }}
        </div>
        @endif
    </div>
    @endif

    <!-- Actions — avec bouton Gantt -->
    <div class="d-flex justify-content-end gap-3 mb-5">
        <a href="{{ url('/') }}" class="btn btn-secondary" style="border-radius:11px;">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
        {{-- BOUTON GANTT — NOUVEAU --}}
        <a href="/projet/{{ $projet->id }}/gantt" class="btn btn-success" style="border-radius:11px;">
            <i class="bi bi-bar-chart-steps me-1"></i> Planning Gantt
            @if($ganttCount > 0)
            <span class="badge bg-white text-success ms-1" style="font-size:.7rem;">{{ $ganttCount }} tâches</span>
            @endif
        </a>
        @if(auth()->user()->hasPermission('modifier_projets'))
        <a href="{{ route('projet.edit', $projet->id) }}" class="btn btn-primary" style="border-radius:11px;">
            <i class="bi bi-pencil me-1"></i> Modifier
        </a>
        @endif
    </div>
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

/* ── Accordion ── */
function toggleAcc(id) {
    const body = document.getElementById(id);
    const hdr  = document.getElementById('hdr-' + id);
    body.classList.toggle('open');
    hdr.classList.toggle('open');
}
</script>
</body>
</html>