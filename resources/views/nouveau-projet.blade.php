<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Projet - LMC Conseil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ══ THEME VARIABLES ══ */
        [data-theme="light"] {
            --bg:        #f1f5f9;
            --surface:   #ffffff;
            --surface2:  #f8fafc;
            --border:    #e2e8f0;
            --text:      #0f172a;
            --text2:     #475569;
            --muted:     #94a3b8;
            --accent:    #3b82f6;
            --input-bg:  #ffffff;
            --input-border: #e2e8f0;
            --input-focus-border: #3b82f6;
            --thead-bg:  #f1f5f9;
            --thead-text:#475569;
            --tr-hover:  #f8fafc;
            --section-border: #3b82f6;
            --shadow:    0 2px 12px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 20px rgba(0,0,0,0.08);
            --btn-primary-bg: #0f172a;
            --btn-primary-hover: #1e293b;
            --add-section-bg: #f8fafc;
        }

        [data-theme="dark"] {
            --bg:        #0f172a;
            --surface:   #1e293b;
            --surface2:  #162032;
            --border:    #334155;
            --text:      #e2e8f0;
            --text2:     #94a3b8;
            --muted:     #64748b;
            --accent:    #3b82f6;
            --input-bg:  #162032;
            --input-border: #334155;
            --input-focus-border: #3b82f6;
            --thead-bg:  #162032;
            --thead-text:#94a3b8;
            --tr-hover:  #1e3a5f22;
            --section-border: #3b82f6;
            --shadow:    0 2px 12px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 20px rgba(0,0,0,0.4);
            --btn-primary-bg: #3b82f6;
            --btn-primary-hover: #2563eb;
            --add-section-bg: #162032;
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            transition: background .3s, color .3s;
        }

        /* ══ HEADER ══ */
        .site-header {
            background: linear-gradient(135deg, #0f172a, #1e293b);
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

        /* ══ NAV ══ */
        .nav-wrap {
            display:flex; gap:.3rem;
            background:rgba(255,255,255,.1);
            border:1px solid rgba(255,255,255,.08);
            padding:.38rem; border-radius:50px;
            margin-top:.85rem; width:fit-content;
        }
        .nav-item {
            padding:.48rem 1.15rem; border-radius:50px;
            font-size:.82rem; font-weight:500;
            color:rgba(255,255,255,.55); text-decoration:none;
            transition:all .2s; display:inline-flex; align-items:center; gap:.35rem;
        }
        .nav-item:hover { background:rgba(255,255,255,.08); color:white; }
        .nav-item.active { background:white; color:#0f172a; font-weight:600; }

        /* ══ FORM CARD ══ */
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.8rem;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            transition: background .3s, border-color .3s;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 1.4rem;
            padding-bottom: .6rem;
            border-bottom: 2px solid var(--section-border);
            display: flex; align-items: center; gap: .5rem;
            letter-spacing: -.01em;
        }
        .section-title i { color: var(--accent); }

        /* ══ INPUTS ══ */
        .form-label {
            font-size: .82rem;
            font-weight: 600;
            color: var(--text2);
            margin-bottom: .35rem;
            display: block;
            letter-spacing: .01em;
        }

        .form-control, .form-select {
            background: var(--input-bg) !important;
            border: 1.5px solid var(--input-border) !important;
            border-radius: 10px !important;
            padding: .6rem .9rem !important;
            font-size: .88rem !important;
            color: var(--text) !important;
            transition: border-color .2s, box-shadow .2s !important;
            font-family: 'Inter', sans-serif !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--input-focus-border) !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,.12) !important;
            outline: none !important;
        }
        .form-control::placeholder { color: var(--muted) !important; }

        textarea.form-control { resize: vertical; min-height: 80px; }

        /* ══ TABLE ══ */
        .table-pro { width:100%; border-collapse:collapse; font-size:.85rem; }
        .table-pro thead th {
            background: var(--thead-bg);
            color: var(--thead-text);
            padding: .7rem .75rem;
            font-weight: 600; font-size: .75rem;
            text-transform: uppercase; letter-spacing: .05em;
            border-bottom: 2px solid var(--border);
        }
        .table-pro tbody td {
            padding: .65rem .75rem;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            vertical-align: middle;
        }
        .table-pro tbody tr:hover td { background: var(--tr-hover); }

        /* checkbox normes */
        .form-check-label { color: var(--text2); font-size:.85rem; }
        .form-check-input:checked { background-color: var(--accent); border-color: var(--accent); }

        /* ══ ADD SECTION ══ */
        .add-section {
            background: var(--add-section-bg);
            border: 1px dashed var(--border);
            border-radius: 14px;
            padding: 1.2rem;
            margin-top: 1.2rem;
        }
        .add-section h6 { color: var(--text2); font-size:.85rem; font-weight:600; margin-bottom:.9rem; }

        /* ══ BUTTONS ══ */
        .btn-main {
            background: var(--btn-primary-bg);
            color: white;
            border: none;
            border-radius: 11px;
            padding: .7rem 1.8rem;
            font-weight: 600;
            font-size: .88rem;
            transition: all .2s;
            cursor: pointer;
        }
        .btn-main:hover {
            background: var(--btn-primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        }

        .btn-cancel {
            background: var(--surface);
            color: var(--text2);
            border: 1.5px solid var(--border);
            border-radius: 11px;
            padding: .7rem 1.8rem;
            font-weight: 600;
            font-size: .88rem;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-cancel:hover { background: var(--surface2); color: var(--text); }

        /* ══ CHEF BADGE ══ */
        .chef-badge {
            background: #fbbf24;
            color: #78350f;
            font-size: .65rem;
            padding: .15rem .5rem;
            border-radius: 50px;
            font-weight: 700;
        }

        /* ══ ALERT FLOAT ══ */
        .alert-float {
            position: fixed; top: 20px; right: 20px;
            z-index: 9999; border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
            min-width: 300px; font-size: .88rem;
        }

        /* ══ READONLY ══ */
        textarea[readonly] {
            background: var(--surface2) !important;
            color: var(--muted) !important;
            cursor: default;
        }

        /* ══ SELECT OPTION dark fix ══ */
        [data-theme="dark"] option { background: #1e293b; color: #e2e8f0; }

        /* ══ Bootstrap table override in dark ══ */
        [data-theme="dark"] .table-light th { background: var(--thead-bg) !important; color: var(--thead-text) !important; }
        [data-theme="dark"] .table-bordered { border-color: var(--border) !important; }
        [data-theme="dark"] .table-bordered td, [data-theme="dark"] .table-bordered th { border-color: var(--border) !important; }
        [data-theme="dark"] .bg-light { background: var(--surface2) !important; }

        input[type="number"] { -moz-appearance: textfield; }
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; }
    </style>
</head>
<body>

{{-- Flash --}}
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
@if($errors->any())
<div class="alert alert-danger alert-float alert-dismissible fade show">
    <ul class="mb-0">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- HEADER -->
<div class="site-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="logo">LMC CONSEIL</div>
                <div class="logo-sub">Nouveau Projet</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="meta-pill"><i class="bi bi-clock me-1"></i>{{ now()->format('d/m/Y') }}</span>
                <button class="theme-btn" id="themeToggle" title="Changer thème">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>
            </div>
        </div>
        <div class="nav-wrap">
            <a href="/" class="nav-item"><i class="bi bi-table"></i> Données</a>
            <a href="/tableau-de-bord" class="nav-item"><i class="bi bi-bar-chart"></i> Tableau de Bord</a>
            <a href="/consultants" class="nav-item"><i class="bi bi-people"></i> Consultants</a>
            <a href="/nouveau-projet" class="nav-item active"><i class="bi bi-plus-circle"></i> Nouveau Projet</a>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="container py-4">
<form action="{{ route('projets.store') }}" method="POST">
@csrf

<!-- A - Informations Générales -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-info-circle"></i> A — Informations Générales</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Référence Projet</label>
            <input type="text" class="form-control" name="reference_projet"
                value="{{ old('reference_projet', $newReference) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Client <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="client_nom"
                value="{{ old('client_nom') }}" placeholder="Nom du client" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Statut <span class="text-danger">*</span></label>
            <select class="form-select" name="statut" required>
                @foreach(['Planifié','En cours','En retard','Finalisé'] as $s)
                <option value="{{ $s }}" {{ old('statut') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Secteur d'activité</label>
            <input type="text" class="form-control" name="secteur_activite"
                value="{{ old('secteur_activite') }}" placeholder="Ex: Industrie, BTP, Agroalimentaire...">
        </div>
        <div class="col-md-6">
            <label class="form-label">Type Projet</label>
            <input type="text" class="form-control" name="type_projet"
                value="{{ old('type_projet', 'SMI — Système de Management Intégré') }}">
        </div>
    </div>
</div>

<!-- Dates -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-calendar"></i> Dates</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Date début</label>
            <input type="date" class="form-control" name="date_debut" value="{{ old('date_debut') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Date fin prévue</label>
            <input type="date" class="form-control" name="date_fin_prevue" value="{{ old('date_fin_prevue') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Date fin réelle</label>
            <input type="date" class="form-control" name="date_fin_reelle" value="{{ old('date_fin_reelle') }}">
        </div>
    </div>
</div>

<!-- Indicateurs -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-graph-up"></i> Indicateurs</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Jours prévus</label>
            <input type="number" class="form-control" name="jours_prevus" min="0" value="{{ old('jours_prevus', 0) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Jours réalisés</label>
            <input type="number" class="form-control" name="jours_realises" min="0" value="{{ old('jours_realises', 0) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Avancement %</label>
            <input type="number" class="form-control" name="avancement_percent" min="0" max="100" value="{{ old('avancement_percent', 0) }}" required>
        </div>
    </div>
</div>

<!-- Normes -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-check-square"></i> Normes</div>
    @php $defaultNormes = ['ISO 9001:2015', 'ISO 14001:2015', 'ISO 45001:2018']; @endphp
    <div class="row g-3">
        @foreach($normes as $norme)
        <div class="col-md-4 col-lg-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                    name="normes[]" value="{{ $norme->id }}"
                    id="norme{{ $norme->id }}"
                    {{ in_array($norme->code_norme, $defaultNormes) ? 'checked' : '' }}>
                <label class="form-check-label fw-500" for="norme{{ $norme->id }}">
                    {{ $norme->code_norme }}
                </label>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-2" style="font-size:.78rem; color:var(--muted);">
        <i class="bi bi-info-circle me-1"></i> Les 3 normes principales sont sélectionnées par défaut.
    </div>
</div>

<!-- B - Consultants -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-people"></i> B — Charge de travail par consultant</div>

    <input type="hidden" name="chef_projet_id" id="chefProjetIdInput" value="">

    <div class="table-responsive">
        <table class="table-pro">
            <thead>
                <tr>
                    <th style="width:6%;">Chef ?</th>
                    <th style="width:24%;">Consultant</th>
                    <th style="width:16%;">Rôle</th>
                    <th style="width:14%;">J. Alloués</th>
                    <th style="width:14%;">J. Réalisés</th>
                    <th style="width:10%;">% Charge</th>
                    <th style="width:8%;">Action</th>
                </tr>
            </thead>
            <tbody id="consultantsTableBody"></tbody>
        </table>
        <div id="emptyConsultants" class="text-center py-3" style="color:var(--muted); font-size:.85rem;">
            <i class="bi bi-people me-1"></i> Aucun consultant ajouté
        </div>
    </div>

    <div class="add-section">
        <h6><i class="bi bi-plus-circle me-1"></i> Ajouter un consultant</h6>
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Consultant</label>
                <select class="form-select" id="existingConsultantSelect">
                    <option value="">-- Sélectionner --</option>
                    @foreach($consultants as $cons)
                    <option value="{{ $cons->id }}" data-nom="{{ $cons->nom_complet }}">
                        {{ $cons->nom_complet }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Rôle</label>
                <select class="form-select" id="existingConsultantRole">
                    <option value="Chef de Projet">Chef de Projet</option>
                    <option value="Consultant" selected>Consultant</option>
                    <option value="Consultant Ext.">Consultant Ext.</option>
                    <option value="Expert">Expert</option>
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
                <button type="button" class="btn-main w-100" onclick="addConsultant()">
                    <i class="bi bi-plus-circle me-1"></i> Ajouter
                </button>
            </div>
        </div>
    </div>
    <div class="mt-2" style="font-size:.78rem; color:var(--muted);">
        <i class="bi bi-lightbulb me-1"></i> Cochez "Chef ?" pour désigner le chef de projet.
    </div>
</div>

<!-- C - Chapitres SMI -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-journal-check"></i> C — Planification par chapitre SMI</div>
    <div class="table-responsive">
        <table class="table table-bordered" style="min-width:1200px; font-size:.83rem;">
            <thead>
                <tr style="background:var(--thead-bg);">
                    <th style="color:var(--thead-text); width:15%;">Chapitre</th>
                    <th style="color:var(--thead-text); width:22%;">Exigences Clés</th>
                    <th style="color:var(--thead-text); width:20%;">Livrables</th>
                    <th style="color:var(--thead-text); width:7%;">Av. %</th>
                    <th style="color:var(--thead-text); width:12%;">Phase</th>
                    <th style="color:var(--thead-text); width:7%;">J. Interv.</th>
                    <th style="color:var(--thead-text);">Observations</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chapitres as $index => $chap)
                <tr>
                    <td style="color:var(--text);"><strong>{{ $chap->code_chapitre }}</strong><br>
                        <small style="color:var(--muted);">{{ $chap->titre_chapitre }}</small></td>
                    <td>
                        <textarea class="form-control form-control-sm"
                            name="chapitres[{{ $index }}][exigences]"
                            rows="2" readonly>{{ $chap->exigences_cles }}</textarea>
                    </td>
                    <td>
                        <textarea class="form-control form-control-sm"
                            name="chapitres[{{ $index }}][livrables]" rows="2">✓ À définir</textarea>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm"
                            name="chapitres[{{ $index }}][avancement]"
                            min="0" max="100" value="0" style="width:65px; text-align:center;">
                    </td>
                    <td>
                        <select class="form-select form-select-sm" name="chapitres[{{ $index }}][phase]">
                            <option value="⬜ Non démarré" selected>⬜ Non démarré</option>
                            <option value="⏳ Démarré">⏳ Démarré</option>
                            <option value="🔄 En cours">🔄 En cours</option>
                            <option value="✅ Terminé">✅ Terminé</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm"
                            name="chapitres[{{ $index }}][jours]"
                            min="0" value="0" style="width:65px; text-align:center;">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm"
                            name="chapitres[{{ $index }}][observations]" placeholder="—">
                    </td>
                </tr>
                <input type="hidden" name="chapitres[{{ $index }}][chapitre_id]" value="{{ $chap->id }}">
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- D - Formations -->
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
                @foreach($formations as $index => $form)
                <tr>
                    <td style="color:var(--text);">
                        <input type="hidden" name="formations[{{ $index }}][id]" value="{{ $form->id }}">
                        {{ $form->titre_formation }}
                    </td>
                    <td>
                        <select class="form-select form-select-sm" name="formations[{{ $index }}][statut]">
                            <option value="À planifier" selected>À planifier</option>
                            <option value="En cours">En cours</option>
                            <option value="Réalisée">Réalisée</option>
                            <option value="Finalisée">Finalisée</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm"
                            name="formations[{{ $index }}][observations]" placeholder="—">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- E - Contraintes -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-exclamation-triangle"></i> E — Contraintes & Points de vigilance</div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Blocage</label>
            <textarea class="form-control" name="blocage" rows="3"
                placeholder="Décrivez les blocages éventuels...">{{ old('blocage') }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Commentaire</label>
            <textarea class="form-control" name="commentaire" rows="3"
                placeholder="Commentaires généraux...">{{ old('commentaire') }}</textarea>
        </div>
    </div>
</div>

<!-- BOUTONS -->
<div class="d-flex justify-content-end gap-3 mb-5">
    <a href="/" class="btn-cancel">Annuler</a>
    <button type="submit" class="btn-main px-5">
        <i class="bi bi-check-circle me-2"></i> Créer le projet
    </button>
</div>

</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── Theme sync ──
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

// ── Consultants logic ──
let consultantIndex = 0;

function setChefDeProjet(consultantId) {
    document.getElementById('chefProjetIdInput').value = consultantId;
    document.querySelectorAll('.chef-badge-cell').forEach(c => c.innerHTML = '');
    const cell = document.getElementById(`chef-badge-${consultantId}`);
    if (cell) cell.innerHTML = '<span class="chef-badge">⭐ Chef</span>';
    const role = document.getElementById(`role-select-${consultantId}`);
    if (role) role.value = 'Chef de Projet';
}

function addConsultant() {
    const select = document.getElementById('existingConsultantSelect');
    const consId = select.value;
    const consNom = select.options[select.selectedIndex]?.getAttribute('data-nom') || '';
    const role = document.getElementById('existingConsultantRole').value;
    const joursA = parseFloat(document.getElementById('existingConsultantJoursAlloues').value) || 0;
    const joursR = parseFloat(document.getElementById('existingConsultantJoursRealises').value) || 0;

    if (!consId) { alert('Veuillez sélectionner un consultant'); return; }
    if (document.getElementById(`consultant-row-${consId}`)) { alert('Ce consultant est déjà dans la liste'); return; }

    const charge = joursA > 0 ? Math.round((joursR / joursA) * 100) : 0;
    const idx = consultantIndex++;
    document.getElementById('emptyConsultants').style.display = 'none';

    document.getElementById('consultantsTableBody').insertAdjacentHTML('beforeend', `
        <tr id="consultant-row-${consId}">
            <td class="text-center">
                <input type="radio" name="chef_radio" value="${consId}"
                    class="form-check-input" style="transform:scale(1.2); cursor:pointer;"
                    onchange="setChefDeProjet(${consId})">
                <div class="mt-1 chef-badge-cell" id="chef-badge-${consId}"></div>
            </td>
            <td style="font-weight:600;">
                ${consNom}
                <input type="hidden" name="consultants[${idx}][id]" value="${consId}">
            </td>
            <td>
                <select class="form-select form-select-sm" name="consultants[${idx}][role]" id="role-select-${consId}">
                    <option value="Chef de Projet" ${role==='Chef de Projet'?'selected':''}>Chef de Projet</option>
                    <option value="Consultant" ${role==='Consultant'?'selected':''}>Consultant</option>
                    <option value="Consultant Ext." ${role==='Consultant Ext.'?'selected':''}>Consultant Ext.</option>
                    <option value="Expert" ${role==='Expert'?'selected':''}>Expert</option>
                </select>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm"
                    name="consultants[${idx}][jours_alloues]"
                    min="0" step="0.1" value="${joursA}" style="width:90px;"
                    oninput="updateCharge(${consId})">
            </td>
            <td>
                <input type="number" class="form-control form-control-sm"
                    name="consultants[${idx}][jours_realises]"
                    min="0" step="0.1" value="${joursR}" style="width:90px;"
                    oninput="updateCharge(${consId})">
            </td>
            <td class="text-center">
                <span class="badge bg-info" id="charge-badge-${consId}">${charge}%</span>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger"
                    onclick="removeConsultant(this, ${consId})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    `);

    select.value = '';
    document.getElementById('existingConsultantRole').value = 'Consultant';
    document.getElementById('existingConsultantJoursAlloues').value = '0';
    document.getElementById('existingConsultantJoursRealises').value = '0';
}

function updateCharge(consId) {
    const row = document.getElementById(`consultant-row-${consId}`);
    const joursA = parseFloat(row.querySelector('[name*="jours_alloues"]').value) || 0;
    const joursR = parseFloat(row.querySelector('[name*="jours_realises"]').value) || 0;
    document.getElementById(`charge-badge-${consId}`).textContent = (joursA > 0 ? Math.round((joursR/joursA)*100) : 0) + '%';
}

function removeConsultant(button, consId) {
    if (confirm('Supprimer ce consultant ?')) {
        if (document.getElementById('chefProjetIdInput').value == consId)
            document.getElementById('chefProjetIdInput').value = '';
        button.closest('tr').remove();
        if (!document.getElementById('consultantsTableBody').children.length)
            document.getElementById('emptyConsultants').style.display = 'block';
    }
}

document.querySelector('form').addEventListener('submit', function(e) {
    const chefId = document.getElementById('chefProjetIdInput').value;
    const nbCons = document.getElementById('consultantsTableBody').children.length;
    if (nbCons > 0 && !chefId) {
        e.preventDefault();
        alert('⚠️ Veuillez sélectionner un chef de projet.');
    }
});

setTimeout(() => document.querySelectorAll('.alert-float').forEach(a => a.remove()), 5000);
</script>
</body>
</html>