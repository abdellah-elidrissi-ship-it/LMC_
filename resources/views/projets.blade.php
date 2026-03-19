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
            --bg: #f8fafc;
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
            --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-full: 9999px;
        }

        [data-theme="dark"] {
            --bg: #0f172a;
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
            --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.3);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.4);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.5);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.6);
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            transition: background .3s, color .3s;
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

        /* ===== PAGE STYLES ===== */
        .page {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }

        .welcome-banner {
            background: linear-gradient(135deg, var(--surface), var(--surface-hover));
            border: 1px solid var(--border);
            border-radius: var(--radius-2xl);
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
        }

        .welcome-content h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .welcome-content p {
            font-size: 0.9rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .welcome-stats {
            display: flex;
            align-items: center;
            gap: 2.5rem;
        }

        .welcome-stat {
            text-align: center;
        }

        .welcome-stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
        }

        .welcome-stat-label {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            opacity: 0;
            transition: opacity 0.2s;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-icon.blue {
            background: rgba(37, 99, 235, 0.1);
            color: var(--accent);
        }

        .stat-icon.green {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-icon.red {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .stat-icon.yellow {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .stat-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        .search-section {
            margin-bottom: 2rem;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-full);
            padding: 0.5rem 1rem 0.5rem 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }

        .search-wrapper:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft);
        }

        .search-wrapper i {
            color: var(--text-muted);
            font-size: 1rem;
        }

        .search-wrapper input {
            flex: 1;
            border: none;
            background: transparent;
            color: var(--text-primary);
            font-size: 0.9rem;
            padding: 0.5rem 0;
            outline: none;
        }

        .search-wrapper input::placeholder {
            color: var(--text-muted);
        }

        .search-filters {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-left: 1rem;
            border-left: 1px solid var(--border);
        }

        .filter-chip {
            padding: 0.35rem 1.2rem;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 500;
            background: var(--surface-hover);
            color: var(--text-secondary);
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-chip:hover,
        .filter-chip.active {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .project-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-2xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
        }

        .project-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--accent);
        }

        .project-status-bar {
            height: 6px;
            width: 100%;
        }

        .project-status-bar.finalised { background: linear-gradient(90deg, #10b981, #34d399); }
        .project-status-bar.in-progress { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .project-status-bar.delayed { background: linear-gradient(90deg, #ef4444, #f87171); }
        .project-status-bar.planned { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

        .project-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .project-ref {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: var(--surface-hover);
            padding: 0.25rem 0.9rem;
            border-radius: var(--radius-full);
            border: 1px solid var(--border);
        }

        .project-badge {
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.25rem 0.9rem;
            border-radius: var(--radius-full);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .project-badge.finalised {
            background: var(--success-light);
            color: var(--success);
        }

        .project-badge.in-progress {
            background: var(--info-light);
            color: var(--info);
        }

        .project-badge.delayed {
            background: var(--danger-light);
            color: var(--danger);
        }

        .project-badge.planned {
            background: var(--warning-light);
            color: var(--warning);
        }

        .project-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .project-client {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .project-client i {
            font-size: 0.7rem;
        }

        .project-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.75rem 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .project-chef {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
        }

        .chef-avatar {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .project-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .project-days {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .project-days strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .project-percent {
            font-size: 1rem;
            font-weight: 700;
            color: var(--accent);
        }

        .progress-bar {
            height: 6px;
            background: var(--border);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .progress-fill {
            height: 100%;
            border-radius: var(--radius-full);
            transition: width 0.3s ease;
        }

        .progress-fill.finalised { background: linear-gradient(90deg, #10b981, #34d399); }
        .progress-fill.in-progress { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .progress-fill.delayed { background: linear-gradient(90deg, #ef4444, #f87171); }
        .progress-fill.planned { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

        .project-normes {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-bottom: 1rem;
        }

        .norme-tag {
            font-size: 0.65rem;
            font-weight: 500;
            padding: 0.2rem 0.6rem;
            border-radius: var(--radius-full);
            background: var(--surface-hover);
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .project-footer {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
            margin-top: auto;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            background: var(--surface-hover);
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .action-btn:hover {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .action-btn.delete:hover {
            background: var(--danger);
            border-color: var(--danger);
        }

        .action-btn.gantt:hover {
            background: var(--success);
            border-color: var(--success);
        }

        .action-btn.edit:hover {
            background: var(--info);
            border-color: var(--info);
        }

        .badge-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--success);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: var(--surface);
            border: 2px dashed var(--border);
            border-radius: var(--radius-2xl);
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--border);
        }

        .empty-state h5 {
            font-size: 1.1rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            font-size: 0.9rem;
        }

        .page-footer {
            display: flex;
            justify-content: space-between;
            padding: 1.5rem 0;
            border-top: 1px solid var(--border);
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        @media (max-width: 1200px) {
            .projects-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .projects-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-banner {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .search-wrapper {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-filters {
                border-left: none;
                border-top: 1px solid var(--border);
                padding-left: 0;
                padding-top: 0.5rem;
            }
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
    $projets = [];
    $db_error = $e->getMessage();
}

$totalProjets = count($projets);
$finalises = $enRetard = $enCours = $planifies = 0;
$totalJoursPrevus = $totalJoursRealises = 0;

foreach($projets as $p) {
    $totalJoursPrevus += $p->jours_prevus;
    $totalJoursRealises += $p->jours_realises;
    
    match($p->statut) {
        'Finalisé' => $finalises++,
        'En retard' => $enRetard++,
        'En cours' => $enCours++,
        default => $planifies++,
    };
}

$avancementGlobal = $totalJoursPrevus > 0 
    ? round(($totalJoursRealises / $totalJoursPrevus) * 100) 
    : 0;

$user = auth()->user();
$debutSemaine = now()->startOfWeek()->format('d/m');
$finSemaine = now()->endOfWeek()->format('d/m/Y');
@endphp

<!-- HEADER -->
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
            <a href="/" class="nav-item active">
                <i class="bi bi-table"></i> Données
            </a>
            <a href="/tableau-de-bord" class="nav-item">
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

<!-- MAIN CONTENT -->
<div class="page">

    @if(isset($db_error) && $db_error)
        <div class="alert alert-danger">{{ $db_error }}</div>
    @else

    <!-- WELCOME BANNER -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <h1>Bonjour, {{ $user->name }} 👋</h1>
            <p>
                <i class="bi bi-calendar-week"></i> Semaine du {{ $debutSemaine }} au {{ $finSemaine }}
                <i class="bi bi-database ms-3"></i> {{ $totalProjets }} projets actifs
            </p>
        </div>
        <div class="welcome-stats">
            <div class="welcome-stat">
                <div class="welcome-stat-value">{{ $avancementGlobal }}%</div>
                <div class="welcome-stat-label">AVANCEMENT GLOBAL</div>
            </div>
            <div class="welcome-stat">
                <div class="welcome-stat-value">{{ $totalJoursRealises }}</div>
                <div class="welcome-stat-label">JOURS RÉALISÉS</div>
            </div>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-folder2"></i>
            </div>
            <div class="stat-label">TOTAL PROJETS</div>
            <div class="stat-value">{{ $totalProjets }}</div>
            <div class="stat-sub">Portefeuille complet</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-label">FINALISÉS</div>
            <div class="stat-value">{{ $finalises }}</div>
            <div class="stat-sub">Certifications obtenues</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="bi bi-clock"></i>
            </div>
            <div class="stat-label">EN COURS</div>
            <div class="stat-value">{{ $enCours }}</div>
            <div class="stat-sub">Projets actifs</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-label">EN RETARD</div>
            <div class="stat-value">{{ $enRetard }}</div>
            <div class="stat-sub">Attention requise</div>
        </div>
    </div>

    <!-- SEARCH SECTION -->
    <div class="search-section">
        <div class="search-wrapper">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Rechercher un projet, un client, un chef de projet...">
            <div class="search-filters">
                <span class="filter-chip active" data-filter="all">Tous</span>
                <span class="filter-chip" data-filter="finalised">Finalisés</span>
                <span class="filter-chip" data-filter="in-progress">En cours</span>
                <span class="filter-chip" data-filter="delayed">En retard</span>
                <span class="filter-chip" data-filter="planned">Planifiés</span>
            </div>
        </div>
    </div>

    <!-- PROJECTS GRID -->
    <div class="projects-grid" id="projectsGrid">
        @forelse($projets as $projet)
        @php
            $statusClass = match($projet->statut) {
                'Finalisé' => 'finalised',
                'En retard' => 'delayed',
                'En cours' => 'in-progress',
                default => 'planned',
            };
            
            $normes = array_filter(explode('||', $projet->normes_list ?? ''));
            $initials = collect(explode(' ', $projet->chef_nom ?? '??'))
                ->map(fn($w) => strtoupper(substr($w,0,1)))
                ->take(2)
                ->implode('');
                
            $ganttCount = DB::table('gantt_taches')
                ->where('projet_id', $projet->id)
                ->count();
        @endphp

        <div class="project-card" data-status="{{ $statusClass }}" data-search="{{ strtolower($projet->nom_client . ' ' . $projet->reference_projet . ' ' . ($projet->chef_nom ?? '')) }}">
            <div class="project-status-bar {{ $statusClass }}"></div>
            
            <div class="project-content">
                <div class="project-header">
                    <span class="project-ref">{{ $projet->reference_projet }}</span>
                    <span class="project-badge {{ $statusClass }}">{{ $projet->statut }}</span>
                </div>
                
                <h3 class="project-title">{{ $projet->nom_client }}</h3>
                
                <div class="project-client">
                    <i class="bi bi-building"></i>
                    {{ $projet->secteur_activite ?? 'Secteur non spécifié' }}
                </div>
                
                <div class="project-meta">
                    <div class="project-chef">
                        <div class="chef-avatar">{{ $initials }}</div>
                        <span>{{ $projet->chef_nom ?? 'Non assigné' }}</span>
                    </div>
                </div>
                
                <div class="project-stats">
                    <span class="project-days">
                        <i class="bi bi-clock"></i>
                        <strong>{{ $projet->jours_realises }}</strong> / {{ $projet->jours_prevus }} jours
                    </span>
                    <span class="project-percent">{{ $projet->avancement_percent }}%</span>
                </div>
                
                <div class="progress-bar">
                    <div class="progress-fill {{ $statusClass }}" style="width: {{ $projet->avancement_percent }}%;"></div>
                </div>
                
                @if(count($normes))
                <div class="project-normes">
                    @foreach(array_slice($normes, 0, 3) as $norme)
                        <span class="norme-tag">{{ $norme }}</span>
                    @endforeach
                    @if(count($normes) > 3)
                        <span class="norme-tag">+{{ count($normes) - 3 }}</span>
                    @endif
                </div>
                @endif
                
                <div class="project-footer">
                    @if($user->hasPermission('voir_details'))
                    <a href="/projet/{{ $projet->id }}" class="action-btn" title="Voir détails">
                        <i class="bi bi-eye"></i>
                    </a>
                    @endif
                    
                    @if($user->hasPermission('voir_gantt'))
                    <a href="/projet/{{ $projet->id }}/gantt" class="action-btn gantt" title="Planning Gantt">
                        <i class="bi bi-bar-chart-steps"></i>
                        @if($ganttCount > 0)
                        <span class="badge-count">{{ $ganttCount }}</span>
                        @endif
                    </a>
                    @endif
                    
                    @if($user->hasPermission('modifier_projets'))
                    <a href="/projet/{{ $projet->id }}/edit" class="action-btn edit" title="Modifier">
                        <i class="bi bi-pencil"></i>
                    </a>
                    @endif
                    
                    @if($user->hasPermission('supprimer_projets'))
                    <button class="action-btn delete" onclick="confirmDelete({{ $projet->id }})" title="Supprimer">
                        <i class="bi bi-trash"></i>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-folder2-open"></i>
                <h5>Aucun projet trouvé</h5>
                <p>Commencez par créer votre premier projet</p>
                <a href="/nouveau-projet" class="btn btn-primary mt-3">Nouveau projet</a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- PAGE FOOTER -->
    <div class="page-footer">
        <span>
            <i class="bi bi-layers me-1"></i>
            {{ $totalProjets }} projet(s)
        </span>
        <span>
            <i class="bi bi-calendar-week me-1"></i>
            {{ $totalJoursRealises }} / {{ $totalJoursPrevus }} jours
        </span>
    </div>

    @endif
</div>

<script>
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

// Search functionality
const searchInput = document.getElementById('searchInput');
const projects = document.querySelectorAll('.project-card');

if (searchInput) {
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        
        projects.forEach(project => {
            const searchData = project.dataset.search.toLowerCase();
            if (searchData.includes(searchTerm)) {
                project.style.display = '';
            } else {
                project.style.display = 'none';
            }
        });
    });
}

// Filter chips
const filterChips = document.querySelectorAll('.filter-chip');

filterChips.forEach(chip => {
    chip.addEventListener('click', function() {
        filterChips.forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.dataset.filter;
        
        projects.forEach(project => {
            if (filter === 'all' || project.dataset.status === filter) {
                project.style.display = '';
            } else {
                project.style.display = 'none';
            }
        });
    });
});

// Delete confirmation
function confirmDelete(id) {
    if (confirm('Supprimer ce projet définitivement ?')) {
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>