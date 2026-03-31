<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultants - LMC Conseil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        [data-theme="light"] {
            --bg:#f1f5f9; --surface:#ffffff; --surface2:#f8fafc; --border:#e2e8f0;
            --text:#0f172a; --text2:#475569; --muted:#94a3b8; --accent:#3b82f6;
            --input-bg:#ffffff; --input-border:#e2e8f0;
            --shadow:0 2px 12px rgba(0,0,0,.06); --shadow-md:0 4px 20px rgba(0,0,0,.08);
            --btn-primary-bg:#0f172a; --btn-primary-hover:#1e293b;
            --card-hover-border:#3b82f6;
        }
        [data-theme="dark"] {
            --bg:#0f172a; --surface:#1e293b; --surface2:#162032; --border:#334155;
            --text:#e2e8f0; --text2:#94a3b8; --muted:#64748b; --accent:#3b82f6;
            --input-bg:#162032; --input-border:#334155;
            --shadow:0 2px 12px rgba(0,0,0,.3); --shadow-md:0 4px 20px rgba(0,0,0,.4);
            --btn-primary-bg:#3b82f6; --btn-primary-hover:#2563eb;
            --card-hover-border:#3b82f6;
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); transition:background .3s,color .3s; }

        /* ===== NOUVELLE NAVBAR ===== */
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
            border-radius: 9999px;
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
            border-radius: 9999px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .theme-btn {
            width: 36px;
            height: 36px;
            border-radius: 9999px;
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
            border-radius: 9999px;
            margin-top: 0.75rem;
            width: fit-content;
        }

        .nav-item {
            padding: 0.45rem 1.25rem;
            border-radius: 9999px;
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
        /* ===== FIN NOUVELLE NAVBAR ===== */

        .form-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:1.8rem; box-shadow:var(--shadow); margin-bottom:1.5rem; transition:background .3s,border-color .3s; }

        .section-title { font-size:1rem; font-weight:700; color:var(--text); margin-bottom:1.3rem; padding-bottom:.6rem; border-bottom:2px solid var(--accent); display:flex; align-items:center; gap:.5rem; }
        .section-title i { color:var(--accent); }

        .form-label { font-size:.82rem; font-weight:600; color:var(--text2); margin-bottom:.35rem; display:block; }
        .form-control, .form-select { background:var(--input-bg) !important; border:1.5px solid var(--input-border) !important; border-radius:10px !important; padding:.6rem .9rem !important; font-size:.88rem !important; color:var(--text) !important; font-family:'Inter',sans-serif !important; transition:border-color .2s,box-shadow .2s !important; }
        .form-control:focus, .form-select:focus { border-color:var(--accent) !important; box-shadow:0 0 0 3px rgba(59,130,246,.12) !important; outline:none !important; }
        .form-control::placeholder { color:var(--muted) !important; }
        [data-theme="dark"] option { background:#1e293b; color:#e2e8f0; }

        .btn-main { background:var(--btn-primary-bg); color:white; border:none; border-radius:10px; padding:.6rem 1.5rem; font-weight:600; font-size:.85rem; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:.4rem; }
        .btn-main:hover { background:var(--btn-primary-hover); transform:translateY(-1px); }

        /* Consultant cards */
        .cons-card { background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:1rem 1.3rem; margin-bottom:.65rem; display:flex; align-items:center; justify-content:space-between; transition:all .2s; }
        .cons-card:hover { box-shadow:var(--shadow-md); border-color:var(--card-hover-border); }
        .cons-card.inactif { opacity:.5; }

        .cons-name { font-weight:600; font-size:.95rem; color:var(--text); display:flex; align-items:center; gap:.5rem; }
        .cons-meta { font-size:.78rem; color:var(--muted); margin-top:.25rem; display:flex; flex-wrap:wrap; gap:.75rem; }
        .cons-meta i { color:var(--accent); }

        .dot { width:8px; height:8px; border-radius:50%; display:inline-block; flex-shrink:0; }
        .dot-on  { background:#10b981; }
        .dot-off { background:#ef4444; }

        .type-pill { padding:.25rem .75rem; border-radius:50px; font-size:.72rem; font-weight:600; }
        .type-Interne    { background:#dbeafe; color:#1e40af; }
        .type-Freelancer { background:#fef3c7; color:#92400e; }
        .type-Externe    { background:#f3e8ff; color:#6b21a8; }
        [data-theme="dark"] .type-Interne    { background:rgba(59,130,246,.15); color:#93c5fd; }
        [data-theme="dark"] .type-Freelancer { background:rgba(251,191,36,.15); color:#fcd34d; }
        [data-theme="dark"] .type-Externe    { background:rgba(168,85,247,.15); color:#d8b4fe; }

        .act-btn { width:31px; height:31px; border-radius:9px; border:1px solid var(--border); background:var(--surface2); color:var(--muted); display:inline-flex; align-items:center; justify-content:center; font-size:.8rem; cursor:pointer; transition:all .18s; text-decoration:none; }
        .act-btn:hover { background:var(--accent); color:white; border-color:var(--accent); }
        .act-btn.del:hover { background:#ef4444; border-color:#ef4444; color:white; }

        /* Modal */
        .modal-content { background:var(--surface); border:1px solid var(--border); border-radius:20px; color:var(--text); }
        .modal-header { border-bottom:1px solid var(--border); padding:1.3rem 1.6rem; }
        .modal-body   { padding:1.3rem 1.6rem; }
        .modal-footer { border-top:1px solid var(--border); padding:1rem 1.6rem; }
        .modal-title  { font-size:.95rem; font-weight:700; color:var(--text); }
        .btn-close { filter: var(--text) == '#e2e8f0' ? invert(1) : none; }
        [data-theme="dark"] .btn-close { filter:invert(1); }

        .form-check-input:checked { background-color:var(--accent); border-color:var(--accent); }
        .form-check-label { color:var(--text2); font-size:.85rem; }

        .alert-float { position:fixed; top:20px; right:20px; z-index:9999; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,.15); min-width:300px; font-size:.88rem; }

        .count-badge { background:var(--accent); color:white; font-size:.72rem; font-weight:700; padding:.18rem .6rem; border-radius:50px; }
    </style>
</head>
<body>

@php
$user = auth()->user();
@endphp

@if(session('success'))
<div class="alert alert-success alert-float alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-float alert-dismissible fade show">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Header -->
<div class="site-header">
    <div class="header-container">
        <div class="logo-wrapper">
            <img src="https://lmc.ma/wp-content/uploads/2021/02/LMC-Logo.png" 
                 alt="LMC Conseil" 
                 class="logo-image"
                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2280%22%20height%3D%2240%22%20viewBox%3D%220%200%2080%2040%22%3E%3Ctext%20x%3D%220%22%20y%3D%2230%22%20font-family%3D%22Inter%2C%20sans-serif%22%20font-size%3D%2220%22%20font-weight%3D%22700%22%20fill%3D%22%23ffffff%22%3ELMC%3C%2Ftext%3E%3C%2Fsvg%3E';">
            <div class="logo-text">
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
            <a href="/tableau-de-bord" class="nav-item">
                <i class="bi bi-bar-chart"></i> Tableau de Bord
            </a>
            <a href="/consultants" class="nav-item active">
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

<div class="container py-4">

    <!-- Formulaire ajout -->
    <div class="form-card">
        <div class="section-title"><i class="bi bi-person-plus"></i> Ajouter un consultant</div>
        <form action="{{ route('consultants.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nom_complet"
                        value="{{ old('nom_complet') }}" placeholder="Ex: BENOUALA Hamid" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Type <span class="text-danger">*</span></label>
                    <select class="form-select" name="type_consultant" required>
                        <option value="Interne"    {{ old('type_consultant')=='Interne'    ? 'selected':'' }}>Interne</option>
                        <option value="Freelancer" {{ old('type_consultant')=='Freelancer' ? 'selected':'' }}>Freelancer</option>
                        <option value="Externe"    {{ old('type_consultant')=='Externe'    ? 'selected':'' }}>Externe</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Spécialité</label>
                    <input type="text" class="form-control" name="specialite"
                        value="{{ old('specialite') }}" placeholder="Ex: QHSE, Systèmes Intégrés...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email"
                        value="{{ old('email') }}" placeholder="email@lmc.ma">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Téléphone</label>
                    <input type="text" class="form-control" name="telephone"
                        value="{{ old('telephone') }}" placeholder="+212 6XX...">
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn-main">
                        <i class="bi bi-plus-circle"></i> Ajouter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Liste -->
    <div class="form-card">
        <div class="section-title">
            <i class="bi bi-people"></i> Liste des consultants
            <span class="count-badge ms-1">{{ $consultants->count() }}</span>
        </div>

        <div class="mb-3">
            <input type="text" class="form-control" id="searchConsultant"
                placeholder="🔍 Rechercher un consultant...">
        </div>

        <div id="consultantsList">
            @forelse($consultants as $cons)
            <div class="cons-card {{ $cons->actif ? '' : 'inactif' }}"
                 data-search="{{ strtolower($cons->nom_complet.' '.$cons->specialite.' '.$cons->type_consultant) }}">

                <div class="d-flex align-items-center gap-3 flex-1">
                    <div>
                        <div class="cons-name">
                            <span class="dot {{ $cons->actif ? 'dot-on' : 'dot-off' }}"></span>
                            {{ $cons->nom_complet }}
                        </div>
                        <div class="cons-meta">
                            @if($cons->specialite)
                                <span><i class="bi bi-briefcase"></i> {{ $cons->specialite }}</span>
                            @endif
                            @if($cons->email)
                                <span><i class="bi bi-envelope"></i> {{ $cons->email }}</span>
                            @endif
                            @if($cons->telephone)
                                <span><i class="bi bi-telephone"></i> {{ $cons->telephone }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="type-pill type-{{ $cons->type_consultant }}">{{ $cons->type_consultant }}</span>

                    <button class="act-btn" title="Modifier"
                        onclick="openEditModal(
                            {{ $cons->id }},
                            '{{ addslashes($cons->nom_complet) }}',
                            '{{ $cons->type_consultant }}',
                            '{{ addslashes($cons->specialite ?? '') }}',
                            '{{ $cons->email ?? '' }}',
                            '{{ $cons->telephone ?? '' }}',
                            {{ $cons->actif ? 'true' : 'false' }}
                        )">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <form action="{{ route('consultants.destroy', $cons->id) }}" method="POST"
                          style="display:inline;"
                          onsubmit="return confirm('Supprimer {{ addslashes($cons->nom_complet) }} ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="act-btn del" title="Supprimer">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-4" style="color:var(--muted);">
                <i class="bi bi-people" style="font-size:2.5rem; display:block; margin-bottom:.6rem;"></i>
                Aucun consultant trouvé
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Modifier -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2 text-primary"></i>Modifier consultant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nom_complet" id="editNom" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type_consultant" id="editType">
                                <option value="Interne">Interne</option>
                                <option value="Freelancer">Freelancer</option>
                                <option value="Externe">Externe</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Spécialité</label>
                            <input type="text" class="form-control" name="specialite" id="editSpecialite">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="editEmail">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Téléphone</label>
                            <input type="text" class="form-control" name="telephone" id="editTelephone">
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="actif" id="editActif" value="1">
                                <label class="form-check-label" for="editActif">Consultant actif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-main">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
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

document.getElementById('searchConsultant').addEventListener('keyup', function() {
    const t = this.value.toLowerCase();
    document.querySelectorAll('.cons-card').forEach(c => {
        c.style.display = c.dataset.search.includes(t) ? '' : 'none';
    });
});

function openEditModal(id, nom, type, specialite, email, telephone, actif) {
    document.getElementById('editNom').value        = nom;
    document.getElementById('editType').value       = type;
    document.getElementById('editSpecialite').value = specialite;
    document.getElementById('editEmail').value      = email;
    document.getElementById('editTelephone').value  = telephone;
    document.getElementById('editActif').checked    = actif;
    document.getElementById('editForm').action      = `/consultants/${id}`;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

setTimeout(() => document.querySelectorAll('.alert-float').forEach(a => a.remove()), 5000);
</script>
</body>
</html>