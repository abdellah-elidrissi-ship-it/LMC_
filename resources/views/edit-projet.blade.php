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
            --text:#0f172a; --text2:#475569; --muted:#94a3b8; --accent:#3b82f6;
            --input-bg:#ffffff; --input-border:#e2e8f0;
            --thead-bg:#f1f5f9; --thead-text:#475569;
            --shadow:0 2px 12px rgba(0,0,0,.06);
            --btn-primary-bg:#0f172a; --btn-primary-hover:#1e293b;
            --add-section-bg:#f8fafc;
            --cons-row-bg:#f8fafc; --cons-row-border:#3b82f6;
        }
        [data-theme="dark"] {
            --bg:#0f172a; --surface:#1e293b; --surface2:#162032; --border:#334155;
            --text:#e2e8f0; --text2:#94a3b8; --muted:#64748b; --accent:#3b82f6;
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

        .section-title { font-size:1rem; font-weight:700; color:var(--text); margin-bottom:1.3rem; padding-bottom:.6rem; border-bottom:2px solid var(--accent); display:flex; align-items:center; gap:.5rem; }
        .section-title i { color:var(--accent); }

        .form-label { font-size:.82rem; font-weight:600; color:var(--text2); margin-bottom:.35rem; display:block; }
        .form-control, .form-select { background:var(--input-bg) !important; border:1.5px solid var(--input-border) !important; border-radius:10px !important; padding:.6rem .9rem !important; font-size:.88rem !important; color:var(--text) !important; font-family:'Inter',sans-serif !important; transition:border-color .2s !important; }
        .form-control:focus, .form-select:focus { border-color:var(--accent) !important; box-shadow:0 0 0 3px rgba(59,130,246,.12) !important; outline:none !important; }
        .form-control::placeholder { color:var(--muted) !important; }
        textarea.form-control { resize:vertical; min-height:75px; }
        textarea[readonly] { background:var(--surface2) !important; color:var(--muted) !important; }
        [data-theme="dark"] option { background:#1e293b; color:#e2e8f0; }

        .btn-main { background:var(--btn-primary-bg); color:white; border:none; border-radius:11px; padding:.7rem 1.8rem; font-weight:600; font-size:.88rem; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:.4rem; }
        .btn-main:hover { background:var(--btn-primary-hover); transform:translateY(-1px); }
        .btn-cancel { background:var(--surface); color:var(--text2); border:1.5px solid var(--border); border-radius:11px; padding:.7rem 1.8rem; font-weight:600; font-size:.88rem; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:.4rem; }
        .btn-cancel:hover { background:var(--surface2); color:var(--text); }

        /* Consultant rows */
        .cons-row { background:var(--cons-row-bg); border:1px solid var(--border); border-left:3px solid var(--cons-row-border); border-radius:12px; padding:1rem; margin-bottom:.7rem; }

        /* Add section */
        .add-section { background:var(--add-section-bg); border:1px dashed var(--border); border-radius:14px; padding:1.2rem; margin-top:1.2rem; }
        .add-section h6 { color:var(--text2); font-size:.85rem; font-weight:600; margin-bottom:.9rem; }

        /* Table */
        .table-bordered { border-color:var(--border) !important; }
        .table-bordered td, .table-bordered th { border-color:var(--border) !important; color:var(--text); }
        thead.table-dark th, .thead-dark th { background:#1e293b !important; color:#94a3b8 !important; border-color:#334155 !important; font-size:.78rem; font-weight:600; text-transform:uppercase; letter-spacing:.04em; }
        [data-theme="dark"] .table-bordered td { color:var(--text); }

        .form-check-input:checked { background-color:var(--accent); border-color:var(--accent); }
        .form-check-label { color:var(--text2); font-size:.85rem; }

        .alert-float { position:fixed; top:20px; right:20px; z-index:9999; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,.15); min-width:300px; font-size:.88rem; }
        input[type="number"] { -moz-appearance:textfield; }
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button { -webkit-appearance:none; }
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

<div class="site-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="logo">LMC CONSEIL — Modifier {{ $projet->reference_projet }}</div>
                <div class="logo-sub">Mise à jour du projet</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="meta-pill"><i class="bi bi-clock me-1"></i>{{ now()->format('d/m/Y') }}</span>
                <button class="theme-btn" id="themeToggle"><i class="bi bi-moon-fill" id="themeIcon"></i></button>
            </div>
        </div>
        <div class="nav-wrap">
            <a href="/" class="nav-item"><i class="bi bi-table"></i> Données</a>
            <a href="/tableau-de-bord" class="nav-item"><i class="bi bi-bar-chart"></i> Tableau de Bord</a>
            <a href="/consultants" class="nav-item"><i class="bi bi-people"></i> Consultants</a>
            <a href="{{ route('projet.details', $projet->id) }}" class="nav-item active"><i class="bi bi-eye"></i> Détails</a>
        </div>
    </div>
</div>

<div class="container py-4">
<form action="{{ route('projets.update', $projet->id) }}" method="POST">
@csrf @method('PUT')

<!-- A - Informations Générales -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-info-circle"></i> A — Informations Générales</div>
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Référence Projet</label>
            <input type="text" class="form-control" name="reference_projet"
                value="{{ old('reference_projet', $projet->reference_projet) }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Client <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="client_nom"
                value="{{ old('client_nom', $projet->client->nom_client ?? '') }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Chef de Projet <span class="text-danger">*</span></label>
            <select class="form-select" name="chef_projet_id" required>
                <option value="">-- Sélectionner --</option>
                @foreach($consultants as $cons)
                <option value="{{ $cons->id }}"
                    {{ old('chef_projet_id', $projet->chef_projet_id) == $cons->id ? 'selected' : '' }}>
                    {{ $cons->nom_complet }}
                </option>
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
            <input type="text" class="form-control" name="secteur_activite"
                value="{{ old('secteur_activite', $projet->client->secteur_activite ?? '') }}"
                placeholder="Ex: Industrie, BTP...">
        </div>
        <div class="col-md-6">
            <label class="form-label">Type Projet</label>
            <input type="text" class="form-control" name="type_projet"
                value="{{ old('type_projet', $projet->type_projet) }}">
        </div>
    </div>
</div>

<!-- Dates -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-calendar"></i> Dates</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Date début</label>
            <input type="date" class="form-control" name="date_debut"
                value="{{ old('date_debut', $projet->date_debut) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Date fin prévue</label>
            <input type="date" class="form-control" name="date_fin_prevue"
                value="{{ old('date_fin_prevue', $projet->date_fin_prevue) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Date fin réelle</label>
            <input type="date" class="form-control" name="date_fin_reelle"
                value="{{ old('date_fin_reelle', $projet->date_fin_reelle) }}">
        </div>
    </div>
</div>

<!-- Indicateurs -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-graph-up"></i> Indicateurs</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Jours prévus</label>
            <input type="number" class="form-control" name="jours_prevus"
                min="0" value="{{ old('jours_prevus', $projet->jours_prevus) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Jours réalisés</label>
            <input type="number" class="form-control" name="jours_realises"
                min="0" value="{{ old('jours_realises', $projet->jours_realises) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Avancement %</label>
            <input type="number" class="form-control" name="avancement_percent"
                min="0" max="100" value="{{ old('avancement_percent', $projet->avancement_percent) }}" required>
        </div>
    </div>
</div>

<!-- Normes -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-check-square"></i> Normes</div>
    <div class="row g-3">
        @foreach($normes as $norme)
        @php $checked = $projet->normes->contains('id', $norme->id); @endphp
        <div class="col-md-4 col-lg-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                    name="normes[]" value="{{ $norme->id }}"
                    id="norme{{ $norme->id }}" {{ $checked ? 'checked' : '' }}>
                <label class="form-check-label" for="norme{{ $norme->id }}">{{ $norme->code_norme }}</label>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- B - Consultants -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-people"></i> B — Charge de travail par consultant</div>

    <div id="existingConsultantsContainer">
        @forelse($projet->affectations as $aff)
        @php $charge = $aff->jours_alloues > 0 ? round(($aff->jours_realises / $aff->jours_alloues) * 100) : 0; @endphp
        <div class="cons-row" id="consultant-row-{{ $aff->consultant_id }}">
            <div class="row align-items-center g-3">
                <div class="col-md-3">
                    <span style="font-weight:600; font-size:.9rem;">
                        <i class="bi bi-person-circle me-1" style="color:var(--accent);"></i>
                        {{ $aff->consultant->nom_complet }}
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
                    <input type="number" class="form-control form-control-sm"
                        name="consultants[{{ $aff->consultant_id }}][jours_alloues]"
                        min="0" step="0.1" value="{{ $aff->jours_alloues }}" placeholder="Alloués">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control form-control-sm"
                        name="consultants[{{ $aff->consultant_id }}][jours_realises]"
                        min="0" step="0.1" value="{{ $aff->jours_realises }}" placeholder="Réalisés">
                </div>
                <div class="col-md-1 text-center">
                    <span class="badge bg-info">{{ $charge }}%</span>
                </div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="removeConsultant(this, {{ $aff->consultant_id }})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <p style="color:var(--muted); font-size:.85rem;" id="emptyMsg">Aucun consultant associé.</p>
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
                <button type="button" class="btn-main w-100" onclick="addExistingConsultant()">
                    <i class="bi bi-plus-circle"></i> Ajouter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- C - Chapitres SMI -->
<div class="form-card">
    <div class="section-title"><i class="bi bi-journal-check"></i> C — Planification par chapitre SMI</div>
    <div class="table-responsive">
        <table class="table table-bordered" style="min-width:1200px; font-size:.82rem;">
            <thead>
                <tr style="background:var(--thead-bg);">
                    <th style="color:var(--thead-text); width:12%;">Chapitre</th>
                    <th style="color:var(--thead-text); width:20%;">Exigences Clés</th>
                    <th style="color:var(--thead-text); width:20%;">Livrables</th>
                    <th style="color:var(--thead-text); width:7%;">Av. %</th>
                    <th style="color:var(--thead-text); width:12%;">Phase</th>
                    <th style="color:var(--thead-text); width:7%;">J. Interv.</th>
                    <th style="color:var(--thead-text);">Observations</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projet->suiviChapitres as $index => $chap)
                <tr>
                    <td>
                        <strong style="color:var(--accent);">{{ $chap->chapitre->code_chapitre }}</strong><br>
                        <small style="color:var(--muted);">{{ $chap->chapitre->titre_chapitre }}</small>
                        <input type="hidden" name="chapitres[{{ $index }}][id]" value="{{ $chap->id }}">
                        <input type="hidden" name="chapitres[{{ $index }}][chapitre_id]" value="{{ $chap->chapitre_id }}">
                    </td>
                    <td>
                        <textarea class="form-control form-control-sm"
                            name="chapitres[{{ $index }}][exigences_cles]"
                            rows="3" readonly>{{ $chap->chapitre->exigences_cles }}</textarea>
                    </td>
                    <td>
                        <textarea class="form-control form-control-sm"
                            name="chapitres[{{ $index }}][livrables]" rows="3">{{ $chap->statut_livrables }}</textarea>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm"
                            name="chapitres[{{ $index }}][avancement]"
                            min="0" max="100" value="{{ $chap->avancement_percent }}"
                            style="width:65px; text-align:center;">
                    </td>
                    <td>
                        <select class="form-select form-select-sm" name="chapitres[{{ $index }}][phase]">
                            @foreach(['⬜ Non démarré','⏳ Démarré','🔄 En cours','✅ Terminé'] as $phase)
                            <option value="{{ $phase }}" {{ $chap->phase == $phase ? 'selected' : '' }}>{{ $phase }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm"
                            name="chapitres[{{ $index }}][jours]"
                            min="0" value="{{ $chap->jours_intervention }}"
                            style="width:65px; text-align:center;">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm"
                            name="chapitres[{{ $index }}][observations]"
                            value="{{ $chap->observations }}" placeholder="—">
                    </td>
                </tr>
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
                        <input type="text" class="form-control form-control-sm"
                            name="formations[{{ $index }}][observations]"
                            value="{{ $form->pivot->observations }}" placeholder="—">
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
            <textarea class="form-control" name="blocage" rows="3">{{ old('blocage', $projet->blocage) }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Commentaire</label>
            <textarea class="form-control" name="commentaire" rows="3">{{ old('commentaire', $projet->commentaire) }}</textarea>
        </div>
    </div>
</div>

<!-- BOUTONS -->
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
// Theme
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

let newConsultantIndex = @json(count($projet->affectations));

function addExistingConsultant() {
    const select = document.getElementById('existingConsultantSelect');
    const consId = select.value;
    const consNom = select.options[select.selectedIndex]?.getAttribute('data-nom') || '';
    const role = document.getElementById('existingConsultantRole').value;
    const joursA = parseFloat(document.getElementById('existingConsultantJoursAlloues').value) || 0;
    const joursR = parseFloat(document.getElementById('existingConsultantJoursRealises').value) || 0;

    if (!consId) { alert('Veuillez sélectionner un consultant'); return; }
    if (document.getElementById(`consultant-row-${consId}`)) { alert('Ce consultant est déjà affecté'); return; }

    const charge = joursA > 0 ? Math.round((joursR / joursA) * 100) : 0;

    document.getElementById('newConsultantsContainer').insertAdjacentHTML('beforeend', `
        <div class="cons-row mt-2" id="consultant-row-${consId}">
            <div class="row align-items-center g-3">
                <div class="col-md-3">
                    <span style="font-weight:600; font-size:.9rem;">
                        <i class="bi bi-person-plus-fill me-1" style="color:#10b981;"></i>${consNom}
                    </span>
                    <input type="hidden" name="consultants[${consId}][id]" value="${consId}">
                    <span class="badge bg-success ms-1" style="font-size:.62rem;">Nouveau</span>
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" name="consultants[${consId}][role]">
                        <option value="Chef de Projet" ${role==='Chef de Projet'?'selected':''}>Chef de Projet</option>
                        <option value="Consultant" ${role==='Consultant'?'selected':''}>Consultant</option>
                        <option value="Consultant Ext." ${role==='Consultant Ext.'?'selected':''}>Consultant Ext.</option>
                        <option value="Expert" ${role==='Expert'?'selected':''}>Expert</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control form-control-sm"
                        name="consultants[${consId}][jours_alloues]" min="0" step="0.1" value="${joursA}">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control form-control-sm"
                        name="consultants[${consId}][jours_realises]" min="0" step="0.1" value="${joursR}">
                </div>
                <div class="col-md-1 text-center">
                    <span class="badge bg-info">${charge}%</span>
                </div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="removeConsultant(this, ${consId})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `);

    select.value = '';
    document.getElementById('existingConsultantRole').value = 'Consultant';
    document.getElementById('existingConsultantJoursAlloues').value = '0';
    document.getElementById('existingConsultantJoursRealises').value = '0';
}

function removeConsultant(button, consId) {
    if (confirm('Supprimer ce consultant du projet ?')) {
        button.closest('.cons-row').remove();
        document.getElementById('deletedConsultantsContainer').insertAdjacentHTML('beforeend',
            `<input type="hidden" name="deleted_consultants[]" value="${consId}">`
        );
    }
}

setTimeout(() => document.querySelectorAll('.alert-float').forEach(a => a.remove()), 5000);
</script>
</body>
</html>
