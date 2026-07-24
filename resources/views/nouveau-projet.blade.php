<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LMC Conseil</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        [data-theme="light"] {
            --bg-primary: #f8fafc;
            --surface: #ffffff;
            --surface-hover: #f1f5f9;
            --border: #e2e8f0;
            --border-dark: #cbd5e1;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --accent: #2563eb;
            --accent-light: #3b82f6;
            --accent-soft: #dbeafe;
            --success: #10b981;
            --success-light: #d1fae5;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --info: #6366f1;
            --info-light: #e0e7ff;
            --input-bg: #ffffff;
            --input-border: #e2e8f0;
            --thead-bg: #f1f5f9;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;
        }

        [data-theme="dark"] {
            --bg-primary: #0f172a;
            --surface: #1e293b;
            --surface-hover: #263445;
            --border: #334155;
            --border-dark: #475569;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --accent-soft: #1e3a5f;
            --success: #10b981;
            --success-light: #064e3b;
            --warning: #f59e0b;
            --warning-light: #78350f;
            --danger: #ef4444;
            --danger-light: #7f1d1d;
            --info: #6366f1;
            --info-light: #312e81;
            --input-bg: #162032;
            --input-border: #334155;
            --thead-bg: #162032;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.2s, color 0.2s;
            line-height: 1.5;
        }

        /* ===== NAVBAR STYLES ===== */
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

        /* Form Cards */
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            transition: box-shadow 0.2s, border-color 0.2s;
        }

        .form-card:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--border-dark);
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid var(--accent);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.01em;
        }

        .section-title i {
            color: var(--accent);
            font-size: 1.1rem;
        }

        .section-hint {
            margin-left: auto;
            font-size: 0.7rem;
            font-weight: 400;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* Form Elements */
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .form-control,
        .form-select {
            background: var(--input-bg) !important;
            border: 1.5px solid var(--input-border) !important;
            border-radius: var(--radius-sm) !important;
            padding: 0.6rem 0.9rem !important;
            font-size: 0.85rem !important;
            color: var(--text-primary) !important;
            font-family: 'Inter', sans-serif !important;
            transition: border-color 0.2s !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12) !important;
            outline: none !important;
        }

        .form-control::placeholder {
            color: var(--text-muted) !important;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 60px;
        }

        /* Auto-calculated fields */
        .form-control.auto-calc {
            background: rgba(59, 130, 246, 0.04) !important;
            border: 1.5px dashed var(--accent) !important;
            color: var(--accent) !important;
            font-weight: 600 !important;
            cursor: not-allowed !important;
        }

        .badge-auto {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.12rem 0.6rem;
            border-radius: 100px;
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
        }

        .auto-tag {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.68rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
        }

        /* Normes */
        .normes-section {
            background: var(--surface-hover);
            border-radius: var(--radius-md);
            padding: 1.25rem;
        }

        .normes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.75rem;
        }

        .norme-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            transition: all 0.2s;
        }

        .norme-check:hover {
            border-color: var(--accent);
            background: var(--accent-soft);
        }

        .norme-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--accent);
        }

        .norme-check label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        /* Buttons */
        .btn-primary {
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 100px;
            padding: 0.7rem 2rem;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: var(--accent-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-secondary);
            border: 1.5px solid var(--border);
            border-radius: 100px;
            padding: 0.7rem 2rem;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--surface-hover);
            color: var(--text-primary);
        }

        .btn-add {
            background: var(--success);
            color: white;
            border: none;
            border-radius: 100px;
            padding: 0.5rem 1.2rem;
            font-weight: 500;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-add:hover {
            background: #0ca678;
        }

        .btn-remove {
            background: transparent;
            color: var(--danger);
            border: 1.5px solid var(--danger);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-remove:hover {
            background: var(--danger);
            color: white;
        }

        .jours-alloues-na {
            display: block;
            text-align: center;
            font-size: 0.85rem;
            color: var(--gray-400, #9ca3af);
        }

        /* Alert */
        .alert-float {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            min-width: 300px;
            font-size: 0.85rem;
        }

        /* Auto-badge */
        .auto-badge {
            display: inline-block;
            font-size: 0.6rem;
            background: var(--accent-soft);
            color: var(--accent);
            padding: 0.1rem 0.4rem;
            border-radius: 100px;
            margin-left: 0.3rem;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .col-exigences {
                min-width: 300px;
            }
        }

        /*logo*/ 
        .form-field-full {
    grid-column: 1 / -1;
}

.logo-upload {
    min-height: 58px;
    width: 100%;
    padding: 0.65rem 0.75rem;
    border: 1px solid #d6e1ec;
    border-radius: 12px;
    background: #ffffff;

    display: flex;
    align-items: center;
    gap: 0.75rem;

    cursor: pointer;
    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;
}

.logo-upload:hover {
    border-color: #3b82f6;
    background: #f8fbff;
}

.logo-upload:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

.logo-upload__icon {
    width: 38px;
    height: 38px;
    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;
    background: #eff6ff;
    color: #2563eb;
    font-size: 1rem;
}

.logo-upload__content {
    min-width: 0;
    flex: 1;

    display: flex;
    flex-direction: column;
    gap: 0.18rem;
}

.logo-upload__title {
    color: #1e293b;
    font-size: 0.84rem;
    font-weight: 600;
}

.logo-upload__text {
    color: #64748b;
    font-size: 0.74rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.logo-upload__button {
    flex-shrink: 0;
    min-height: 36px;
    padding: 0 0.9rem;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1d4ed8;

    font-size: 0.78rem;
    font-weight: 600;

    transition:
        background 0.2s ease,
        color 0.2s ease,
        border-color 0.2s ease;
}

.logo-upload:hover .logo-upload__button {
    background: #2563eb;
    border-color: #2563eb;
    color: #ffffff;
}

.logo-upload__input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
}

.field-error {
    margin-top: 0.4rem;
    padding: 0.45rem 0.65rem;
    border-radius: 8px;
    background: #fff1f2;
    border: 1px solid #fecdd3;
    color: #b42318;
    font-size: 0.75rem;
    font-weight: 600;
}

@media (max-width: 640px) {
    .logo-upload {
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .logo-upload__button {
        width: 100%;
    }
}
    </style>
</head>
<body>

@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$user = auth()->user();

// Récupérer les consultants pour les sélecteurs
$consultants = DB::table('consultants')->where('actif', 1)->get();

// Récupérer toutes les normes disponibles
$normes = DB::table('normes')->get();

// Récupérer tous les chapitres SMI avec leurs exigences
$chapitres = DB::table('chapitres_smis')->orderBy('ordre')->get();

// Récupérer tous les livrables SMI
$livrables = DB::table('livrables_smi')->orderBy('ordre')->get();

// Organiser les livrables par chapitre
$livrablesByChap = [];
foreach ($livrables as $liv) {
    $chap = $liv->chapitre_code;
    if (!isset($livrablesByChap[$chap])) {
        $livrablesByChap[$chap] = ['items' => [], 'total' => 0];
    }
    $livrablesByChap[$chap]['items'][] = $liv;
    $livrablesByChap[$chap]['total']++;
}

$chapOrder = ['§4','§5','§6','§7','§8','§9','§10','Transversal'];
$chapTitres = [
    '§4' => 'Contexte de l\'organisme',
    '§5' => 'Leadership',
    '§6' => 'Planification',
    '§7' => 'Support',
    '§8' => 'Réalisation des activités',
    '§9' => 'Évaluation des performances',
    '§10' => 'Amélioration',
    'Transversal' => 'Exigences transversales',
];

// Générer une référence de projet automatique
$lastProjet = DB::table('projets')->orderBy('id', 'desc')->first();
$newRef = 'PRJ-' . str_pad(($lastProjet ? $lastProjet->id + 1 : 1), 3, '0', STR_PAD_LEFT);
@endphp

@if(session('success'))
<div class="alert alert-success alert-float alert-dismissible fade show">
    <i class="bi bi-check-circle-fill me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-float alert-dismissible fade show">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger alert-float alert-dismissible fade show">
    <i class="bi bi-exclamation-circle-fill me-2"></i>
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- HEADER -->
@include('partials.navbar', ['navActive' => 'nouveau'])

<!-- Main Content -->
<div class="container py-4">
    <form
    id="nouveau-projet-form"
    method="POST"
    action="{{ route('projets.store') }}"
    enctype="multipart/form-data"
>
        @csrf

        <!-- Section A - Informations générales -->
        <div class="form-card">
            <div class="section-title">
                <i class="bi bi-info-circle"></i>
                A - Informations générales
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Référence projet</label>
                    <input type="text" class="form-control" name="reference_projet"
                        value="{{ old('reference_projet', $newRef) }}" required>
                    <small class="text-muted">Généré automatiquement</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Client <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="client_nom"
                        value="{{ old('client_nom') }}" required placeholder="Nom du client">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Chef de projet <span class="text-danger">*</span></label>
                    <select class="form-select" name="chef_projet_id" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($consultants as $cons)
                        <option value="{{ $cons->id }}" {{ old('chef_projet_id') == $cons->id ? 'selected' : '' }}>
                            {{ $cons->nom_complet }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
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
                        value="{{ old('secteur_activite') }}" placeholder="Ex: Industrie, Services...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Type projet</label>
                    <input type="text" class="form-control" name="type_projet"
                        value="{{ old('type_projet', 'SMI — Système de Management Intégré') }}">
                </div>
            </div>
            <div class="form-field form-field-full">
    <label for="client_logo">Logo du client</label>

    <label for="client_logo" class="logo-upload">
        <div class="logo-upload__icon">
            <i class="bi bi-image"></i>
        </div>

        <div class="logo-upload__content">
            <span class="logo-upload__title">Sélectionner un logo</span>
            <span class="logo-upload__text" id="logoFileName">
                PNG, JPG ou WEBP — 2 Mo maximum
            </span>
        </div>

        <span class="logo-upload__button">
            Parcourir
        </span>
    </label>

    <input
        type="file"
        name="client_logo"
        id="client_logo"
        accept="image/png,image/jpeg,image/webp"
        class="logo-upload__input"
    >

    @error('client_logo')
        <div class="field-error">
            {{ $message }}
        </div>
    @enderror
</div>
        </div>

                <!-- Section F - Consultants (initialement vide) -->
        <div class="form-card">
            <div class="section-title">
                <i class="bi bi-people"></i>
                B - Équipe projet
            </div>

            <div id="existingConsultantsContainer"></div>
            <div id="newConsultantsContainer"></div>

            <div class="add-section">
                <h6>
                    <i class="bi bi-plus-circle" style="color:var(--success);"></i>
                    Ajouter un consultant
                </h6>
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
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
                    <div class="col-md-3">
                        <label class="form-label">Rôle</label>
                        <select class="form-select" id="existingConsultantRole"
                            onchange="applyJoursAllouesVisibility(this, document.getElementById('existingConsultantJoursAlloues'))">
                            <option>Chef de Projet</option>
                            <option selected>Consultant</option>
                            <option>Consultant Ext.</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">J. alloués</label>
                        <input type="number" class="form-control" id="existingConsultantJoursAlloues" min="0" step="0.1" value="0">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn-add w-100" onclick="addConsultant()">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section B - Normes -->
        <div class="form-card">
            <div class="section-title">
                <i class="bi bi-check-square"></i>
                C - Normes applicables
            </div>
            <div class="normes-section">
                <div class="normes-grid">
                    @foreach($normes as $norme)
                    <div class="norme-check">
                        <input type="checkbox" name="normes[]" value="{{ $norme->id }}"
                            id="norme{{ $norme->id }}" {{ in_array($norme->id, old('normes', [])) ? 'checked' : '' }}>
                        <label for="norme{{ $norme->id }}">{{ $norme->code_norme }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Section C - Dates -->
        <div class="form-card">
            <div class="section-title">
                <i class="bi bi-calendar"></i>
                D - Dates du projet
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Date de début</label>
                    <input type="date" class="form-control" name="date_debut"
                        value="{{ old('date_debut') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date de fin prévue</label>
                    <input type="date" class="form-control" name="date_fin_prevue"
                        value="{{ old('date_fin_prevue') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date de fin réelle</label>
                    <input type="date" class="form-control" name="date_fin_reelle"
                        value="{{ old('date_fin_reelle') }}">
                </div>
            </div>
        </div>

        <!-- Section D - Indicateurs -->
        <div class="form-card">
            <div class="section-title">
                <i class="bi bi-graph-up"></i>
                E - Indicateurs de suivi
                <span class="section-hint">
                    <i class="bi bi-info-circle"></i> Sera calculé automatiquement
                </span>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <label class="form-label">Jours prévus</label>
                    <input type="number" class="form-control" name="jours_prevus" id="jours_prevus"
                        min="0" value="{{ old('jours_prevus', 0) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jours réalisés</label>
                    <input type="number" class="form-control" name="jours_realises"
                        id="jours_realises" min="0" value="{{ old('jours_realises', 0) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">
                        Avancement global
                        <span class="badge-auto"><i class="bi bi-lock-fill"></i> Auto</span>
                    </label>
                    <input type="number" class="form-control auto-calc" name="avancement_percent"
                        id="avancement_percent" value="0" readonly>
                    <div class="auto-tag">
                        <i class="bi bi-arrow-right"></i> Basé sur les livrables
                    </div>
                </div>
            </div>
        </div>

        <!-- Section E - Suivi des chapitres SMI -->
        <div class="form-card">
            <div class="section-title">
                <i class="bi bi-journal-check"></i>
                F - Suivi des chapitres SMI
                <span class="auto-badge">Configuration initiale</span>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" style="font-size:0.85rem;">
                    <thead>
                        <tr>
                            <th style="width:10%;">Chapitre</th>
                            <th style="width:35%;">Exigences clés</th>
                            <th style="width:7%;">Av. %</th>
                            <th style="width:12%;">Phase</th>
                            <th style="width:7%;">J. Interv.</th>
                            <th style="width:15%;">Observations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($chapitres as $index => $chap)
                        <tr>
                            <td>
                                <strong style="color: var(--accent);">{{ $chap->code_chapitre }}</strong><br>
                                <small style="color: var(--text-muted);">{{ $chap->titre_chapitre }}</small>
                                <input type="hidden" name="chapitres[{{ $index }}][chapitre_id]" value="{{ $chap->id }}">
                            </td>
                            <td>
                                <textarea name="chapitres[{{ $index }}][exigences_cles]" class="form-control" rows="3">{{ $chap->exigences_cles }}</textarea>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="chapitres[{{ $index }}][avancement]" value="0" min="0" max="100" style="width:60px;">
                            </td>
                            <td>
                                <select class="form-select" name="chapitres[{{ $index }}][phase]">
                                    <option value="⬜ Non démarré">⬜ Non démarré</option>
                                    <option value="⏳ Démarré">⏳ Démarré</option>
                                    <option value="🔄 En cours">🔄 En cours</option>
                                    <option value="✅ Terminé">✅ Terminé</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="chapitres[{{ $index }}][jours]" value="0" min="0" style="width:60px;">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="chapitres[{{ $index }}][observations]" placeholder="Observations...">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        

<!-- Section G - Plan de formation (personnalisé) -->
<div class="form-card">
    <div class="section-title">
        <i class="bi bi-mortarboard"></i>
        G - Plan de formation
        <span class="section-hint">
            <i class="bi bi-plus-circle"></i> Ajoutez vos propres formations
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" style="min-width:600px;" id="formationsTable">
            <thead>
                <tr>
                    <th>Formation</th>
                    <th>Statut</th>
                    <th>Jours prévus</th>
                    <th>Date réalisation</th>
                    <th style="width:50px;"></th>
                </tr>
            </thead>
            <tbody id="formationsTbody">
                <!-- Lignes ajoutées dynamiquement ; initialement vide -->
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <button type="button" class="btn-add" onclick="addFormationRow()">
            <i class="bi bi-plus-lg"></i> Ajouter une formation
        </button>
    </div>
</div>

<!-- Section H - Sensibilisation -->
<div class="form-card">
    <div class="section-title">
        <i class="bi bi-megaphone"></i>
        H - Sensibilisation
        <span class="section-hint">
            <i class="bi bi-plus-circle"></i> Ajoutez les sensibilisations réalisées
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" style="min-width:600px;" id="sensibilisationsTable">
            <thead>
                <tr>
                    <th>Thème</th>
                    <th>Photo</th>
                    <th>Jours prévus</th>
                    <th>Date réalisation</th>
                    <th style="width:50px;"></th>
                </tr>
            </thead>
            <tbody id="sensibilisationsTbody">
                <!-- Lignes ajoutées dynamiquement ; initialement vide -->
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <button type="button" class="btn-add" onclick="addSensibilisationRow()">
            <i class="bi bi-plus-lg"></i> Ajouter une sensibilisation
        </button>
    </div>
</div>

        <!-- Section I - Contraintes -->
        <div class="form-card">
            <div class="section-title">
                <i class="bi bi-exclamation-triangle"></i>
                I - Points d'attention
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Blocage / Difficultés</label>
                    <textarea class="form-control" name="blocage" rows="3" placeholder="Décrire les blocages éventuels...">{{ old('blocage') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Commentaires généraux</label>
                    <textarea class="form-control" name="commentaire" rows="3" placeholder="Informations complémentaires...">{{ old('commentaire') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="d-flex justify-content-end gap-3 mb-5">
            <a href="{{ route('projets.index') }}" class="btn-secondary" data-persist-cancel>
                <i class="bi bi-x-circle"></i> Annuler
            </a>
            <button type="submit" class="btn-primary">
                <i class="bi bi-check-circle"></i> Créer le projet
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('client_logo');
        const fileName = document.getElementById('logoFileName');

        if (!input || !fileName) {
            return;
        }

        input.addEventListener('change', function () {
            const file = this.files && this.files[0];

            fileName.textContent = file
                ? file.name
                : 'PNG, JPG ou WEBP — 2 Mo maximum';
        });
    });
</script>

<script>


// Gestion des formations dynamiques
let formationRowIndex = 0;

function addFormationRow() {
    const tbody = document.getElementById('formationsTbody');
    const row = document.createElement('tr');
    row.id = `formation-row-${formationRowIndex}`;
    row.innerHTML = `
        <td>
            <input type="text" class="form-control" name="formations_dynamic[${formationRowIndex}][titre]" 
                   placeholder="Ex: ISO 9001 – Formation interne" required>
        </td>
        <td>
            <select class="form-select" name="formations_dynamic[${formationRowIndex}][statut]">
                <option value="À planifier">À planifier</option>
                <option value="En cours">En cours</option>
                <option value="Réalisée">Réalisée</option>
                <option value="Finalisée">Finalisée</option>
            </select>
        </td>
        <td>
            <input type="number" class="form-control" name="formations_dynamic[${formationRowIndex}][jours]" 
                   step="0.5" min="0" placeholder="Jours prévus">
        </td>
        <td>
            <input type="date" class="form-control" name="formations_dynamic[${formationRowIndex}][date_realisation]">
        </td>
        <td class="text-center">
            <button type="button" class="btn-remove" onclick="removeFormationRow(${formationRowIndex})">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;
    tbody.appendChild(row);
    formationRowIndex++;
}

function removeFormationRow(index) {
    const row = document.getElementById(`formation-row-${index}`);
    if (row) row.remove();
}


// Gestion des sensibilisations dynamiques
let sensibilisationRowIndex = 0;

function addSensibilisationRow() {
    const tbody = document.getElementById('sensibilisationsTbody');
    const row = document.createElement('tr');
    row.id = `sensibilisation-row-${sensibilisationRowIndex}`;
    row.innerHTML = `
        <td>
            <input type="text" class="form-control" name="sensibilisations[${sensibilisationRowIndex}][theme]"
                   placeholder="Ex: Sensibilisation sécurité incendie" required>
        </td>
        <td>
            <input type="file" class="form-control" name="sensibilisations[${sensibilisationRowIndex}][photo]"
                   accept="image/png,image/jpeg,image/webp">
        </td>
        <td>
            <input type="number" class="form-control" name="sensibilisations[${sensibilisationRowIndex}][jours_prevus]"
                   step="0.5" min="0" placeholder="Jours prévus">
        </td>
        <td>
            <input type="date" class="form-control" name="sensibilisations[${sensibilisationRowIndex}][date_realisation]">
        </td>
        <td class="text-center">
            <button type="button" class="btn-remove" onclick="removeSensibilisationRow(${sensibilisationRowIndex})">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;
    tbody.appendChild(row);
    sensibilisationRowIndex++;
}

function removeSensibilisationRow(index) {
    const row = document.getElementById(`sensibilisation-row-${index}`);
    if (row) row.remove();
}


// Theme toggle
(function() {
    const saved = localStorage.getItem('lmc-theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = saved === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
})();

document.getElementById('themeToggle').addEventListener('click', () => {
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('lmc-theme', next);
    const icon = document.getElementById('themeIcon');
    icon.className = next === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
});

// Le champ "J. alloués" n'est pertinent que pour les consultants externes
// (Chef de Projet / Consultant interne n'ont pas de jours alloués facturés).
// Masqué => désactivé, pour que le navigateur ne l'envoie pas dans le POST
// (le contrôleur retombe déjà sur 0 quand la clé est absente).
function applyJoursAllouesVisibility(roleSelect, joursInput) {
    if (!roleSelect || !joursInput) return;
    const hidden = roleSelect.value === 'Chef de Projet' || roleSelect.value === 'Consultant';

    joursInput.style.display = hidden ? 'none' : '';
    joursInput.disabled = hidden;
    if (hidden) joursInput.value = 0;

    let placeholder = joursInput.parentElement.querySelector('.jours-alloues-na');
    if (hidden) {
        if (!placeholder) {
            placeholder = document.createElement('span');
            placeholder.className = 'jours-alloues-na';
            placeholder.textContent = '—';
            joursInput.insertAdjacentElement('afterend', placeholder);
        }
    } else if (placeholder) {
        placeholder.remove();
    }
}

function onConsultantRoleChange(roleSelect) {
    const row = roleSelect.closest('.consultant-row');
    if (!row) return;
    applyJoursAllouesVisibility(roleSelect, row.querySelector('input[name$="[jours_alloues]"]'));
}

document.addEventListener('DOMContentLoaded', function () {
    applyJoursAllouesVisibility(
        document.getElementById('existingConsultantRole'),
        document.getElementById('existingConsultantJoursAlloues')
    );
});

// Ajouter un consultant
function addConsultant() {
    const select = document.getElementById('existingConsultantSelect');
    const consId = select.value;
    const consNom = select.options[select.selectedIndex]?.getAttribute('data-nom') || '';
    const role = document.getElementById('existingConsultantRole').value;
    const joursA = parseFloat(document.getElementById('existingConsultantJoursAlloues').value) || 0;

    if (!consId) {
        alert('Veuillez sélectionner un consultant');
        return;
    }

    if (document.getElementById(`consultant-row-${consId}`)) {
        alert('Ce consultant est déjà affecté');
        return;
    }

    document.getElementById('newConsultantsContainer').insertAdjacentHTML('beforeend', `
        <div class="consultant-row" id="consultant-row-${consId}">
            <div class="row align-items-center g-3">
                <div class="col-md-4">
                    <div style="font-weight:600;">
                        <i class="bi bi-person-plus-fill me-1" style="color:var(--success);"></i>
                        ${consNom}
                    </div>
                    <input type="hidden" name="consultants[${consId}][id]" value="${consId}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="consultants[${consId}][role]" onchange="onConsultantRoleChange(this)">
                        <option ${role === 'Chef de Projet' ? 'selected' : ''}>Chef de Projet</option>
                        <option ${role === 'Consultant' ? 'selected' : ''}>Consultant</option>
                        <option ${role === 'Consultant Ext.' ? 'selected' : ''}>Consultant Ext.</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control" name="consultants[${consId}][jours_alloues]"
                           min="0" step="0.1" value="${joursA}">
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn-remove" onclick="removeConsultant(this, ${consId})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `);

    const newRow = document.getElementById(`consultant-row-${consId}`);
    onConsultantRoleChange(newRow.querySelector('select[name$="[role]"]'));

    select.value = '';
    document.getElementById('existingConsultantRole').value = 'Consultant';
    document.getElementById('existingConsultantJoursAlloues').value = '0';
    applyJoursAllouesVisibility(
        document.getElementById('existingConsultantRole'),
        document.getElementById('existingConsultantJoursAlloues')
    );
}

function removeConsultant(btn, consId) {
    if (confirm('Retirer ce consultant du projet ?')) {
        btn.closest('.consultant-row').remove();
    }
}

// Auto-hide alerts
setTimeout(() => {
    document.querySelectorAll('.alert-float').forEach(a => a.remove());
}, 5000);
</script>
</body>
</html>