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
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
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
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.5);
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

        /* Header */
        .site-header {
            background: linear-gradient(135deg, #0a1120, #172032);
            padding: 1.25rem 0;
            border-bottom: 3px solid var(--accent);
        }

        .logo {
            font-size: 1.35rem;
            font-weight: 700;
            color: white;
            letter-spacing: -0.02em;
        }

        .logo-sub {
            font-size: 0.7rem;
            color: #94a3b8;
            margin-top: 0.15rem;
        }

        .meta-pill {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
            padding: 0.3rem 0.9rem;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .theme-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.08);
            color: #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .theme-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .btn-retour {
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            color: white;
            padding: 0.55rem 1.4rem;
            border-radius: 100px;
            font-weight: 500;
            font-size: 0.8rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
        }

        .btn-retour:hover {
            background: white;
            color: #0f172a;
        }

        /* Navigation */
        .nav-wrap {
            display: flex;
            gap: 0.25rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.4rem;
            border-radius: 100px;
            margin-top: 1rem;
            width: fit-content;
        }

        .nav-item {
            padding: 0.45rem 1.2rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 500;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item.active {
            background: white;
            color: #0f172a;
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

        /* Table SMI */
        .table-smi-container {
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .table-smi {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .table-smi thead th {
            background: var(--thead-bg);
            color: var(--text-secondary);
            padding: 0.75rem 1rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 2px solid var(--border);
            white-space: nowrap;
        }

        .table-smi tbody td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-secondary);
            vertical-align: middle;
        }

        .table-smi tbody tr:last-child td {
            border-bottom: none;
        }

        .table-smi tbody tr:hover td {
            background: var(--surface-hover);
        }

        /* Colonne Exigences Clés - élargie */
        .col-exigences {
            min-width: 380px;
            width: 35%;
        }

        .col-exigences textarea {
            width: 100%;
            min-height: 85px;
            font-size: 0.82rem;
            line-height: 1.5;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: var(--radius-sm);
            padding: 0.6rem;
            color: var(--text-primary);
        }

        .col-exigences textarea:focus {
            border-color: var(--accent);
            outline: none;
        }

        .chapitre-code {
            font-weight: 700;
            color: var(--accent);
            font-size: 0.9rem;
        }

        .chapitre-titre {
            display: block;
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 0.2rem;
        }

        /* Inputs numériques */
        .input-num {
            width: 70px;
            text-align: center;
            font-weight: 600;
        }

        .input-num.avancement {
            border-color: var(--accent) !important;
        }

        .input-num.jours {
            border-color: var(--accent) !important;
        }

        /* Phase select */
        .phase-select {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border);
            background: var(--input-bg);
            color: var(--text-primary);
            width: 140px;
        }

        /* Livrables Toggle Button */
        .livrables-toggle {
            border: 1px solid var(--border);
            background: var(--surface-hover);
            color: var(--text-secondary);
            padding: 0.2rem 0.8rem;
            font-size: 0.7rem;
            border-radius: var(--radius-sm);
            font-weight: 500;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .livrables-toggle:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .livrables-count {
            font-size: 0.65rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
            white-space: nowrap;
        }

        /* Livrables Inline Table */
        .livrables-inline-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
            background: var(--surface);
            border-radius: var(--radius-sm);
            overflow: hidden;
        }

        .livrables-inline-table thead th {
            background: var(--surface-hover);
            color: var(--text-muted);
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.5rem 0.6rem;
            border: 1px solid var(--border);
        }

        .livrables-inline-table td {
            padding: 0.45rem 0.6rem;
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .livrable-status {
            display: inline-block;
            border-radius: 100px;
            padding: 0.1rem 0.7rem;
            font-size: 0.65rem;
            font-weight: 600;
        }

        .livrable-status.completed {
            background: var(--success-light);
            color: var(--success);
        }

        .livrable-status.in-progress {
            background: var(--warning-light);
            color: var(--warning);
        }

        .livrable-status.pending {
            background: var(--surface-hover);
            color: var(--text-muted);
        }

        /* Livrables Statut Select */
        .liv-statut-select {
            font-size: 0.7rem;
            font-weight: 500;
            padding: 0.2rem 0.6rem;
            border-radius: 100px;
            border: 1.5px solid var(--border);
            background: var(--input-bg);
            color: var(--text-primary);
            cursor: pointer;
            outline: none;
            transition: all 0.2s;
            width: 130px;
        }

        .liv-statut-select.s-nc {
            border-color: var(--border);
            color: var(--text-muted);
        }

        .liv-statut-select.s-ec {
            border-color: var(--warning);
            color: var(--warning);
            background: var(--warning-light);
        }

        .liv-statut-select.s-ok {
            border-color: var(--success);
            color: var(--success);
            background: var(--success-light);
        }

        /* Consultants */
        .consultant-row {
            background: var(--surface-hover);
            border: 1px solid var(--border);
            border-left: 3px solid var(--accent);
            border-radius: var(--radius-md);
            padding: 1rem;
            margin-bottom: 0.75rem;
            transition: all 0.2s;
        }

        .consultant-row:hover {
            border-color: var(--border-dark);
        }

        .add-section {
            background: var(--surface-hover);
            border: 1px dashed var(--border);
            border-radius: var(--radius-md);
            padding: 1.25rem;
            margin-top: 1.25rem;
        }

        .add-section h6 {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        /* Table footer */
        .table-footer {
            background: var(--surface-hover);
            padding: 0.75rem 1rem;
            border-top: 2px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 2rem;
            font-weight: 600;
        }

        .footer-value {
            color: var(--accent);
            font-size: 1.1rem;
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
    </style>
</head>

<body>

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

    @php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;

    $id = $projet->id;

    // Récupérer tous les livrables avec leurs statuts pour ce projet
    $livrableRows = DB::select("
        SELECT ls.id, ls.chapitre_code, ls.clause, ls.libelle, ls.ordre,
               COALESCE(pl.statut, 'Non commencé') as statut
        FROM livrables_smi ls
        LEFT JOIN projet_livrables pl ON pl.livrable_id = ls.id AND pl.projet_id = ?
        ORDER BY ls.ordre ASC
    ", [$id]);

    // Organiser les livrables par chapitre
    $livrablesByChap = [];
    $totalLivrablesGlobal = 0;
    $terminesLivrablesGlobal = 0;

    foreach ($livrableRows as $lrow) {
        $chap = $lrow->chapitre_code;
        if (!isset($livrablesByChap[$chap])) {
            $livrablesByChap[$chap] = ['items' => [], 'total' => 0, 'termines' => 0];
        }
        $livrablesByChap[$chap]['items'][] = $lrow;
        $livrablesByChap[$chap]['total']++;
        $totalLivrablesGlobal++;
        
        if ($lrow->statut === 'Terminé') {
            $livrablesByChap[$chap]['termines']++;
            $terminesLivrablesGlobal++;
        }
    }
    
    // Calculer l'avancement par chapitre (basé sur les livrables)
    $avancementParChapitre = [];
    foreach ($livrablesByChap as $chapCode => $chapData) {
        $avancementParChapitre[$chapCode] = $chapData['total'] > 0 
            ? round(($chapData['termines'] / $chapData['total']) * 100) 
            : 0;
    }
    
    // Calcul de l'avancement global basé sur tous les livrables
    $avancementGlobal = $totalLivrablesGlobal > 0 ? round(($terminesLivrablesGlobal / $totalLivrablesGlobal) * 100) : 0;
    
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

    // Récupérer les consultants pour les sélecteurs
    $consultants = DB::table('consultants')->where('actif', 1)->get();
    $normes = DB::table('normes')->get();
    @endphp

    <!-- Header -->
    <div class="site-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="logo">LMC CONSEIL</div>
                    <div class="logo-sub">Management & Certification</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="meta-pill"><i class="bi bi-database me-1"></i>v2.1</span>
                    <span class="meta-pill"><i class="bi bi-calendar me-1"></i>{{ now()->format('d/m/Y') }}</span>
                    <button class="theme-btn" id="themeToggle">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                    <a href="{{ route('projet.details', $projet->id) }}" class="btn-retour">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <div class="nav-wrap">
                <a href="/" class="nav-item"><i class="bi bi-table"></i> Projets</a>
                <a href="/tableau-de-bord" class="nav-item"><i class="bi bi-bar-chart"></i> Tableau de bord</a>
                <a href="/consultants" class="nav-item"><i class="bi bi-people"></i> Consultants</a>
                <a href="/nouveau-projet" class="nav-item"><i class="bi bi-plus-circle"></i> Nouveau projet</a>
                @if(auth()->check() && auth()->user()->isSuperAdmin())
                <a href="/admin/users" class="nav-item"><i class="bi bi-shield-lock"></i> Administration</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-4">
        <form action="{{ route('projets.update', $projet->id) }}" method="POST" id="mainForm">
            @csrf
            @method('PUT')

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
                            value="{{ old('reference_projet', $projet->reference_projet) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Client</label>
                        <input type="text" class="form-control" name="client_nom"
                            value="{{ old('client_nom', $projet->client->nom_client ?? '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Chef de projet</label>
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
                        <label class="form-label">Statut</label>
                        <select class="form-select" name="statut" required>
                            @foreach(['Planifié','En cours','En retard','Finalisé'] as $s)
                            <option value="{{ $s }}" {{ old('statut', $projet->statut) == $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Secteur d'activité</label>
                        <input type="text" class="form-control" name="secteur_activite"
                            value="{{ old('secteur_activite', $projet->client->secteur_activite ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Type projet</label>
                        <input type="text" class="form-control" name="type_projet"
                            value="{{ old('type_projet', $projet->type_projet) }}">
                    </div>
                </div>
            </div>

            <!-- Section B - Normes -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-check-square"></i>
                    B - Normes applicables
                </div>
                <div class="normes-section">
                    <div class="normes-grid">
                        @foreach($normes as $norme)
                        @php $checked = DB::table('projet_normes')->where('projet_id', $projet->id)->where('norme_id', $norme->id)->exists(); @endphp
                        <div class="norme-check">
                            <input type="checkbox" name="normes[]" value="{{ $norme->id }}"
                                id="norme{{ $norme->id }}" {{ $checked ? 'checked' : '' }}>
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
                    C - Dates du projet
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Date de début</label>
                        <input type="date" class="form-control" name="date_debut"
                            value="{{ old('date_debut', $projet->date_debut) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date de fin prévue</label>
                        <input type="date" class="form-control" name="date_fin_prevue"
                            value="{{ old('date_fin_prevue', $projet->date_fin_prevue) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date de fin réelle</label>
                        <input type="date" class="form-control" name="date_fin_reelle"
                            value="{{ old('date_fin_reelle', $projet->date_fin_reelle) }}">
                    </div>
                </div>
            </div>

            <!-- Section D - Indicateurs -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-graph-up"></i>
                    D - Indicateurs de suivi
                    <span class="section-hint">
                        <i class="bi bi-calculator"></i> Calcul automatique
                    </span>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label">Jours prévus</label>
                        <input type="number" class="form-control" name="jours_prevus" id="jours_prevus"
                            min="0" value="{{ old('jours_prevus', $projet->jours_prevus) }}"
                            required oninput="recalcJours()">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">
                            Jours réalisés
                            <span class="badge-auto"><i class="bi bi-lock-fill"></i> Auto</span>
                        </label>
                        <input type="number" class="form-control auto-calc" name="jours_realises"
                            id="jours_realises" value="{{ old('jours_realises', $projet->jours_realises) }}" readonly>
                        <div class="auto-tag">
                            <i class="bi bi-arrow-right"></i> Somme des jours d'intervention
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">
                            Avancement global
                            <span class="badge-auto"><i class="bi bi-lock-fill"></i> Auto (livrables)</span>
                        </label>
                        <input type="number" class="form-control auto-calc" name="avancement_percent"
                            id="avancement_percent" value="{{ $avancementGlobal }}" readonly>
                        <div class="auto-tag">
                            <i class="bi bi-arrow-right"></i> {{ $terminesLivrablesGlobal }}/{{ $totalLivrablesGlobal }} livrables terminés
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section E - Suivi des chapitres SMI avec livrables intégrés (comme page détails) -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-journal-check"></i>
                    E - Suivi des chapitres SMI
                    <span class="auto-badge">Avancement automatique</span>
                </div>

                <div class="table-smi-container">
                    <table class="table-smi">
                        <thead>
                            <tr>
                                <th style="width:10%;">Chapitre</th>
                                <th style="width:15%;">Livrables</th>
                                <th class="col-exigences">Exigences clés</th>
                                <th style="width:7%;">Av. %</th>
                                <th style="width:10%;">Phase</th>
                                <th style="width:7%;">J. Interv.</th>
                                <th style="width:12%;">Observations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->suiviChapitres as $index => $chap)
                            @php
                                $codeChapitre = $chap->chapitre->code_chapitre;
                                $avancementCalcule = $avancementParChapitre[$codeChapitre] ?? 0;
                                $chapLiv = $livrablesByChap[$codeChapitre] ?? null;
                                $livTotal = $chapLiv['total'] ?? 0;
                                $livDone = $chapLiv['termines'] ?? 0;
                                $livPct = $livTotal > 0 ? round(($livDone / $livTotal) * 100) : 0;
                                $collapseId = 'liv-chap-' . $chap->chapitre_id;
                            @endphp
                            <tr>
                                <td>
                                    <span class="chapitre-code">{{ $codeChapitre }}</span>
                                    <span class="chapitre-titre">{{ $chap->chapitre->titre_chapitre }}</span>
                                    <input type="hidden" name="chapitres[{{ $index }}][id]" value="{{ $chap->id }}">
                                    <input type="hidden" name="chapitres[{{ $index }}][chapitre_id]" value="{{ $chap->chapitre_id }}">
                                </td>
                                <td>
                                    @if($livTotal > 0)
                                        <button class="livrables-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}">
                                            <i class="bi bi-list-ul me-1"></i>
                                            Voir
                                        </button>
                                        <div class="livrables-count">{{ $livDone }}/{{ $livTotal }} ({{ $livPct }}%)</div>
                                    @else
                                        <span style="color: var(--text-muted);">—</span>
                                    @endif
                                </td>
                                <td class="col-exigences">
                                    <textarea name="chapitres[{{ $index }}][exigences_cles]"
                                        class="form-control" rows="4">{{ $chap->chapitre->exigences_cles }}</textarea>
                                </td>
                                <td>
                                    <input type="number" class="form-control input-num avancement"
                                        name="chapitres[{{ $index }}][avancement]"
                                        id="avancement-{{ $codeChapitre }}"
                                        min="0" max="100" value="{{ $avancementCalcule }}"
                                        readonly>
                                    <small style="font-size: 0.6rem; color: var(--text-muted); display: block; text-align: center;">
                                        auto
                                    </small>
                                </td>
                                <td>
                                    <select class="phase-select" name="chapitres[{{ $index }}][phase]">
                                        @foreach(['⬜ Non démarré','⏳ Démarré','🔄 En cours','✅ Terminé'] as $phase)
                                        <option value="{{ $phase }}" {{ $chap->phase == $phase ? 'selected' : '' }}>
                                            {{ $phase }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control input-num jours"
                                        name="chapitres[{{ $index }}][jours]"
                                        id="jours-{{ $codeChapitre }}"
                                        min="0" value="{{ $chap->jours_intervention }}"
                                        oninput="recalcJours()">
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        name="chapitres[{{ $index }}][observations]"
                                        value="{{ $chap->observations }}" placeholder="Observations...">
                                </td>
                            </tr>

                            @if($livTotal > 0)
                            <tr class="collapse" id="{{ $collapseId }}">
                                <td colspan="7" style="background: var(--surface-hover); padding: 1rem;">
                                    <table class="livrables-inline-table">
                                        <thead>
                                            <tr>
                                                <th style="width:95px;">Clause</th>
                                                <th>Libellé</th>
                                                <th style="width:150px;">Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($chapLiv['items'] as $liv)
                                            @php
                                                $selClass = match($liv->statut) {
                                                    'Terminé' => 's-ok',
                                                    'En cours' => 's-ec',
                                                    default => 's-nc',
                                                };
                                            @endphp
                                            <tr>
                                                <td>{{ $liv->clause ?: '—' }}</td>
                                                <td>{{ $liv->libelle }}</td>
                                                <td>
                                                    <select class="liv-statut-select {{ $selClass }}"
                                                        name="livrables[{{ $liv->id }}]"
                                                        onchange="updateLivrableStatus(this, '{{ $codeChapitre }}', '{{ $collapseId }}')">
                                                        <option value="Non commencé" {{ $liv->statut === 'Non commencé' ? 'selected' : '' }}>⬜ Non commencé</option>
                                                        <option value="En cours" {{ $liv->statut === 'En cours' ? 'selected' : '' }}>🔄 En cours</option>
                                                        <option value="Terminé" {{ $liv->statut === 'Terminé' ? 'selected' : '' }}>✅ Terminé</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>

                    <div class="table-footer">
                        <span>
                            Total jours :
                            <span class="footer-value" id="footJours">{{ $projet->suiviChapitres->sum('jours_intervention') }}</span>
                        </span>
                        <span>
                            Avancement global :
                            <span class="footer-value" id="footAvancement">{{ $avancementGlobal }}</span>%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Section F - Consultants -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-people"></i>
                    F - Équipe projet
                </div>

                <div id="existingConsultantsContainer">
                    @forelse($projet->affectations as $aff)
                    @php $charge = $aff->jours_alloues > 0 ? round(($aff->jours_realises / $aff->jours_alloues) * 100) : 0; @endphp
                    <div class="consultant-row" id="consultant-row-{{ $aff->consultant_id }}">
                        <div class="row align-items-center g-3">
                            <div class="col-md-3">
                                <div style="font-weight:600;">
                                    <i class="bi bi-person-circle me-1" style="color:var(--accent);"></i>
                                    {{ $aff->consultant->nom_complet }}
                                </div>
                                <input type="hidden" name="consultants[{{ $aff->consultant_id }}][id]" value="{{ $aff->consultant_id }}">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="consultants[{{ $aff->consultant_id }}][role]">
                                    @foreach(['Chef de Projet','Consultant','Consultant Ext.','Expert'] as $r)
                                    <option value="{{ $r }}" {{ $aff->role_dans_projet == $r ? 'selected' : '' }}>
                                        {{ $r }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control"
                                    name="consultants[{{ $aff->consultant_id }}][jours_alloues]"
                                    min="0" step="0.1" value="{{ $aff->jours_alloues }}"
                                    placeholder="J. alloués">
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control"
                                    name="consultants[{{ $aff->consultant_id }}][jours_realises]"
                                    min="0" step="0.1" value="{{ $aff->jours_realises }}"
                                    placeholder="J. réalisés">
                            </div>
                            <div class="col-md-1">
                                <span class="badge bg-info">{{ $charge }}%</span>
                            </div>
                            <div class="col-md-1 text-center">
                                <button type="button" class="btn-remove" onclick="removeConsultant(this, {{ $aff->consultant_id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p style="color:var(--text-muted); text-align:center; padding:1rem;">Aucun consultant affecté</p>
                    @endforelse
                </div>

                <div id="newConsultantsContainer"></div>
                <div id="deletedConsultantsContainer"></div>

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
                            <select class="form-select" id="existingConsultantRole">
                                <option>Chef de Projet</option>
                                <option selected>Consultant</option>
                                <option>Consultant Ext.</option>
                                <option>Expert</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">J. alloués</label>
                            <input type="number" class="form-control" id="existingConsultantJoursAlloues"
                                min="0" step="0.1" value="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">J. réalisés</label>
                            <input type="number" class="form-control" id="existingConsultantJoursRealises"
                                min="0" step="0.1" value="0">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-add w-100" onclick="addExistingConsultant()">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section G - Formations -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-mortarboard"></i>
                    G - Plan de formation
                </div>
                <div class="table-responsive">
                    <table class="table-smi" style="min-width:600px;">
                        <thead>
                            <tr>
                                <th>Formation</th>
                                <th style="width:200px;">Statut</th>
                                <th>Observations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->formations as $index => $form)
                            <tr>
                                <td style="font-weight:500;">
                                    <input type="hidden" name="formations[{{ $index }}][id]" value="{{ $form->id }}">
                                    {{ $form->titre_formation }}
                                </td>
                                <td>
                                    <select class="form-select" name="formations[{{ $index }}][statut]">
                                        @foreach(['À planifier','En cours','Réalisée','Finalisée'] as $st)
                                        <option value="{{ $st }}" {{ $form->pivot->statut == $st ? 'selected' : '' }}>
                                            {{ $st }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        name="formations[{{ $index }}][observations]"
                                        value="{{ $form->pivot->observations }}" placeholder="Observations...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section H - Contraintes -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-exclamation-triangle"></i>
                    H - Points d'attention
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Blocage / Difficultés</label>
                        <textarea class="form-control" name="blocage" rows="3"
                            placeholder="Décrire les blocages éventuels...">{{ old('blocage', $projet->blocage) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Commentaires généraux</label>
                        <textarea class="form-control" name="commentaire" rows="3"
                            placeholder="Informations complémentaires...">{{ old('commentaire', $projet->commentaire) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
<div class="d-flex justify-content-end gap-3 mb-5">
    <a href="{{ route('projet.details', $projet->id) }}" class="btn-secondary">
        <i class="bi bi-x-circle"></i>
        Annuler
    </a>
    
    @if(auth()->user()->hasPermission('voir_gantt'))
    <a href="/projet/{{ $projet->id }}/gantt" class="btn btn-outline-success" style="border-radius: 100px; padding: 0.6rem 1.8rem;">
        <i class="bi bi-bar-chart-steps me-1"></i>
        Planning Gantt
        @if(isset($ganttCount) && $ganttCount > 0)
        <span class="badge bg-success text-white ms-1">{{ $ganttCount }}</span>
        @endif
    </a>
    @endif
    
    <button type="submit" class="btn-primary">
        <i class="bi bi-check-circle"></i>
        Enregistrer les modifications
    </button>
</div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Variables pour stocker les données
        let avancementParChapitre = @json($avancementParChapitre);
        let livrablesParChapitre = @json($livrablesByChap);

        // Theme toggle
        (function() {
            const savedTheme = localStorage.getItem('lmc-theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            const icon = document.getElementById('themeIcon');
            if (icon) {
                icon.className = savedTheme === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
            }
        })();

        document.getElementById('themeToggle')?.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('lmc-theme', next);
            const icon = document.getElementById('themeIcon');
            if (icon) {
                icon.className = next === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
            }
        });

        // Recalcul des jours uniquement
        function recalcJours() {
            let totalJ = 0;
            document.querySelectorAll('input[name^="chapitres"][name$="[jours]"]').forEach(i => {
                totalJ += parseFloat(i.value) || 0;
            });
            totalJ = Math.round(totalJ * 10) / 10;
            document.getElementById('jours_realises').value = totalJ;
            document.getElementById('footJours').textContent = totalJ;
        }

        // Mise à jour du statut d'un livrable
        function updateLivrableStatus(select, chapCode, collapseId) {
            // Mise à jour de la classe du select
            select.className = 'liv-statut-select ' +
                (select.value === 'Terminé' ? 's-ok' :
                    select.value === 'En cours' ? 's-ec' : 's-nc');

            // Recalcul des stats du chapitre
            const row = document.getElementById(collapseId);
            const selects = row.querySelectorAll('.liv-statut-select');
            let total = selects.length;
            let termines = 0;
            selects.forEach(s => {
                if (s.value === 'Terminé') termines++;
            });

            const pct = Math.round((termines / total) * 100);

            // Mettre à jour l'avancement du chapitre dans le tableau
            const avancementField = document.getElementById('avancement-' + chapCode);
            if (avancementField) {
                avancementField.value = pct;
            }

            // Mettre à jour le compteur dans la cellule livrables
            const parentRow = row.previousElementSibling;
            if (parentRow) {
                const countDiv = parentRow.querySelector('.livrables-count');
                if (countDiv) {
                    countDiv.innerHTML = `${termines}/${total} (${pct}%)`;
                }
            }

            // Mettre à jour l'avancement global
            updateGlobalProgress();
        }

        // Calculer et mettre à jour l'avancement global
        function updateGlobalProgress() {
            let totalGlobal = 0;
            let terminesGlobal = 0;
            
            // Parcourir tous les chapitres
            document.querySelectorAll('[id^="liv-chap-"]').forEach(body => {
                const selects = body.querySelectorAll('.liv-statut-select');
                if (selects.length > 0) {
                    totalGlobal += selects.length;
                    selects.forEach(s => {
                        if (s.value === 'Terminé') terminesGlobal++;
                    });
                }
            });
            
            const pctGlobal = totalGlobal > 0 ? Math.round((terminesGlobal / totalGlobal) * 100) : 0;
            
            // Mettre à jour le champ d'avancement global
            const avancementGlobalField = document.getElementById('avancement_percent');
            if (avancementGlobalField) {
                avancementGlobalField.value = pctGlobal;
            }
            
            // Mettre à jour le footer
            const footAvancement = document.getElementById('footAvancement');
            if (footAvancement) {
                footAvancement.textContent = pctGlobal;
            }
            
            // Mettre à jour le texte d'information
            const autoTag = document.querySelectorAll('.auto-tag');
            if (autoTag.length >= 2) {
                autoTag[1].innerHTML = `<i class="bi bi-arrow-right"></i> ${terminesGlobal}/${totalGlobal} livrables terminés`;
            }
        }

        // Consultants
        function addExistingConsultant() {
            const select = document.getElementById('existingConsultantSelect');
            const consId = select.value;
            const consNom = select.options[select.selectedIndex]?.getAttribute('data-nom') || '';
            const role = document.getElementById('existingConsultantRole').value;
            const joursA = parseFloat(document.getElementById('existingConsultantJoursAlloues').value) || 0;
            const joursR = parseFloat(document.getElementById('existingConsultantJoursRealises').value) || 0;

            if (!consId) {
                alert('Veuillez sélectionner un consultant');
                return;
            }

            if (document.getElementById(`consultant-row-${consId}`)) {
                alert('Ce consultant est déjà affecté');
                return;
            }

            const charge = joursA > 0 ? Math.round((joursR / joursA) * 100) : 0;

            document.getElementById('newConsultantsContainer').insertAdjacentHTML('beforeend', `
                <div class="consultant-row" id="consultant-row-${consId}">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <div style="font-weight:600;">
                                <i class="bi bi-person-plus-fill me-1" style="color:var(--success);"></i>
                                ${consNom}
                            </div>
                            <input type="hidden" name="consultants[${consId}][id]" value="${consId}">
                            <span class="badge bg-success" style="font-size:0.6rem;">Nouveau</span>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="consultants[${consId}][role]">
                                <option ${role === 'Chef de Projet' ? 'selected' : ''}>Chef de Projet</option>
                                <option ${role === 'Consultant' ? 'selected' : ''}>Consultant</option>
                                <option ${role === 'Consultant Ext.' ? 'selected' : ''}>Consultant Ext.</option>
                                <option ${role === 'Expert' ? 'selected' : ''}>Expert</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="consultants[${consId}][jours_alloues]" 
                                   min="0" step="0.1" value="${joursA}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="consultants[${consId}][jours_realises]" 
                                   min="0" step="0.1" value="${joursR}">
                        </div>
                        <div class="col-md-1">
                            <span class="badge bg-info">${charge}%</span>
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn-remove" onclick="removeConsultant(this, ${consId})">
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

        function removeConsultant(btn, consId) {
            if (confirm('Supprimer ce consultant du projet ?')) {
                btn.closest('.consultant-row').remove();
                document.getElementById('deletedConsultantsContainer').insertAdjacentHTML('beforeend',
                    `<input type="hidden" name="deleted_consultants[]" value="${consId}">`
                );
            }
        }

        // Auto-hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert-float').forEach(a => a.remove());
        }, 5000);

        // Initial recalc
        document.addEventListener('DOMContentLoaded', () => {
            recalcJours();
            updateGlobalProgress();
        });
    </script>
</body>

</html>