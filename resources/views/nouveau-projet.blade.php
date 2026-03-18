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
            --success-soft: #ecfdf5;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --warning-soft: #fffbeb;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --danger-soft: #fef2f2;
            --info: #6366f1;
            --info-light: #e0e7ff;
            --info-soft: #eef2ff;
            --input-bg: #ffffff;
            --input-border: #e2e8f0;
            --thead-bg: #f1f5f9;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;
            --gradient-primary: linear-gradient(135deg, #2563eb, #3b82f6);
            --gradient-success: linear-gradient(135deg, #10b981, #34d399);
            --gradient-warning: linear-gradient(135deg, #f59e0b, #fbbf24);
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
            --success-soft: #022c22;
            --warning: #f59e0b;
            --warning-light: #78350f;
            --warning-soft: #422006;
            --danger: #ef4444;
            --danger-light: #7f1d1d;
            --danger-soft: #450a0a;
            --info: #6366f1;
            --info-light: #312e81;
            --info-soft: #1e1b4b;
            --input-bg: #162032;
            --input-border: #334155;
            --thead-bg: #162032;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.5);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.7);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.8);
            --gradient-primary: linear-gradient(135deg, #3b82f6, #60a5fa);
            --gradient-success: linear-gradient(135deg, #22c55e, #4ade80);
            --gradient-warning: linear-gradient(135deg, #f59e0b, #fbbf24);
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
            transition: background-color 0.3s, color 0.3s;
            line-height: 1.5;
        }

        /* Header avec effet de verre */
        .site-header {
            background: rgba(10, 17, 32, 0.95);
            backdrop-filter: blur(8px);
            padding: 1rem 0;
            border-bottom: 3px solid var(--accent);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-md);
        }

        .logo {
            font-size: 1.4rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logo-sub {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 0.1rem;
        }

        .meta-pill {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
            padding: 0.3rem 1rem;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 500;
            backdrop-filter: blur(4px);
            transition: all 0.2s;
        }

        .meta-pill:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent);
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
            backdrop-filter: blur(4px);
        }

        .theme-btn:hover {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
            transform: rotate(15deg);
        }

        .btn-retour {
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            color: white;
            padding: 0.5rem 1.4rem;
            border-radius: 100px;
            font-weight: 500;
            font-size: 0.8rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            backdrop-filter: blur(4px);
        }

        .btn-retour:hover {
            background: white;
            color: #0f172a;
            border-color: white;
            transform: translateX(-3px);
        }

        /* Navigation avec effets */
        .nav-wrap {
            display: flex;
            gap: 0.25rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.4rem;
            border-radius: 100px;
            margin-top: 0.75rem;
            width: fit-content;
            backdrop-filter: blur(4px);
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
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        /* Form Cards avec effets */
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .form-card:hover {
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .form-card:hover::before {
            opacity: 1;
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
            background: var(--accent-soft);
            padding: 0.3rem;
            border-radius: var(--radius-sm);
        }

        .section-hint {
            margin-left: auto;
            font-size: 0.7rem;
            font-weight: 400;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--surface-hover);
            padding: 0.2rem 0.8rem;
            border-radius: 100px;
        }

        /* Form Elements améliorés */
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
            transition: all 0.2s !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15) !important;
            outline: none !important;
            transform: translateY(-1px);
        }

        .form-control::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.6;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 60px;
        }

        /* Auto-calculated fields */
        .form-control.auto-calc {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(59, 130, 246, 0.02)) !important;
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
            padding: 0.15rem 0.7rem;
            border-radius: 100px;
            background: var(--accent-soft);
            color: var(--accent);
            border: 1px solid var(--accent-light);
        }

        .auto-tag {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.68rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
            background: var(--surface-hover);
            padding: 0.2rem 0.6rem;
            border-radius: 100px;
            width: fit-content;
        }

        /* Normes améliorées */
        .normes-section {
            background: var(--surface-hover);
            border-radius: var(--radius-md);
            padding: 1.5rem;
        }

        .normes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 0.75rem;
        }

        .norme-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            transition: all 0.2s;
            cursor: pointer;
        }

        .norme-check:hover {
            border-color: var(--accent);
            background: var(--accent-soft);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .norme-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .norme-check label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer;
        }

        /* Table SMI améliorée */
        .table-smi-container {
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            overflow: hidden;
            margin-top: 0.5rem;
            box-shadow: var(--shadow-sm);
        }

        .table-smi {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .table-smi thead th {
            background: var(--gradient-primary);
            color: white;
            padding: 0.9rem 1rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 2px solid var(--accent-light);
            white-space: nowrap;
        }

        .table-smi tbody td {
            padding: 0.9rem 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-secondary);
            vertical-align: middle;
            transition: background 0.2s;
        }

        .table-smi tbody tr:last-child td {
            border-bottom: none;
        }

        .table-smi tbody tr:hover td {
            background: var(--surface-hover);
        }

        /* Colonne Exigences Clés */
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
            transition: all 0.2s;
        }

        .col-exigences textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .chapitre-code {
            font-weight: 700;
            color: var(--accent);
            font-size: 0.9rem;
            background: var(--accent-soft);
            padding: 0.2rem 0.5rem;
            border-radius: var(--radius-sm);
            display: inline-block;
        }

        .chapitre-titre {
            display: block;
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
        }

        /* Inputs numériques */
        .input-num {
            width: 70px;
            text-align: center;
            font-weight: 600;
            border-radius: var(--radius-sm) !important;
        }

        .input-num.avancement {
            border-color: var(--info) !important;
            background: var(--info-soft) !important;
        }

        .input-num.jours {
            border-color: var(--accent) !important;
            background: var(--accent-soft) !important;
        }

        /* Phase select */
        .phase-select {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border);
            background: var(--input-bg);
            color: var(--text-primary);
            width: 140px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .phase-select:hover {
            border-color: var(--accent);
        }

        /* Livrables Toggle Button */
        .livrables-toggle {
            border: 1px solid var(--border);
            background: var(--gradient-primary);
            color: white;
            padding: 0.3rem 1rem;
            font-size: 0.7rem;
            border-radius: 100px;
            font-weight: 600;
            transition: all 0.2s;
            white-space: nowrap;
            box-shadow: var(--shadow-sm);
            border: none;
        }

        .livrables-toggle:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            opacity: 0.9;
        }

        .livrables-count {
            font-size: 0.65rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
            white-space: nowrap;
            font-weight: 500;
            background: var(--surface-hover);
            padding: 0.15rem 0.6rem;
            border-radius: 100px;
            display: inline-block;
        }

        /* Livrables Inline Table */
        .livrables-inline-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
            background: var(--surface);
            border-radius: var(--radius-sm);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .livrables-inline-table thead th {
            background: var(--thead-bg);
            color: var(--text-secondary);
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.6rem;
            border: 1px solid var(--border);
        }

        .livrables-inline-table td {
            padding: 0.6rem;
            border: 1px solid var(--border);
            color: var(--text-secondary);
            vertical-align: middle;
        }

        /* Livrables Statut Select */
        .liv-statut-select {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.3rem 0.8rem;
            border-radius: 100px;
            border: 1.5px solid transparent;
            background: var(--surface-hover);
            color: var(--text-primary);
            cursor: pointer;
            outline: none;
            transition: all 0.2s;
            width: 130px;
        }

        .liv-statut-select.s-nc {
            background: var(--surface-hover);
            color: var(--text-muted);
            border-color: var(--border);
        }

        .liv-statut-select.s-ec {
            background: var(--warning-soft);
            color: var(--warning);
            border-color: var(--warning);
        }

        .liv-statut-select.s-ok {
            background: var(--success-soft);
            color: var(--success);
            border-color: var(--success);
        }

        /* Consultants */
        .consultant-row {
            background: var(--surface-hover);
            border: 1px solid var(--border);
            border-left: 4px solid var(--accent);
            border-radius: var(--radius-md);
            padding: 1rem;
            margin-bottom: 0.75rem;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .consultant-row:hover {
            border-color: var(--border-dark);
            box-shadow: var(--shadow-md);
            transform: translateX(3px);
        }

        .add-section {
            background: var(--surface-hover);
            border: 2px dashed var(--border);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            margin-top: 1.25rem;
            transition: all 0.2s;
        }

        .add-section:hover {
            border-color: var(--accent);
            background: var(--accent-soft);
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

        /* Buttons améliorés */
        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 100px;
            padding: 0.7rem 2rem;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
        }

        .btn-primary:hover::after {
            width: 300px;
            height: 300px;
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
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .btn-add {
            background: var(--gradient-success);
            color: white;
            border: none;
            border-radius: 100px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .btn-remove {
            background: transparent;
            color: var(--danger);
            border: 1.5px solid var(--danger);
            border-radius: 50%;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-remove:hover {
            background: var(--danger);
            color: white;
            transform: rotate(90deg);
        }

        /* Table footer */
        .table-footer {
            background: var(--surface-hover);
            padding: 0.9rem 1.5rem;
            border-top: 2px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 2rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .footer-value {
            color: var(--accent);
            font-size: 1.2rem;
            font-weight: 700;
            background: var(--accent-soft);
            padding: 0.2rem 0.8rem;
            border-radius: 100px;
            margin-left: 0.5rem;
        }

        /* Alert */
        .alert-float {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            min-width: 320px;
            font-size: 0.85rem;
            animation: slideIn 0.3s ease;
            border: none;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Auto-badge */
        .auto-badge {
            display: inline-block;
            font-size: 0.6rem;
            background: var(--gradient-primary);
            color: white;
            padding: 0.2rem 0.8rem;
            border-radius: 100px;
            margin-left: 0.8rem;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        /* Progress indicator */
        .progress-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 0.4rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
            100% { opacity: 0.6; transform: scale(1); }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .col-exigences {
                min-width: 300px;
            }
        }

        /* Loading effect */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            to {
                left: 100%;
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

    <!-- Header -->
    <div class="site-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="logo">LMC CONSEIL</div>
                    <div class="logo-sub">Management & Certification</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="meta-pill">
                        <span class="progress-indicator" style="background: var(--success);"></span>
                        <i class="bi bi-database me-1"></i>v2.1
                    </span>
                    <span class="meta-pill"><i class="bi bi-calendar me-1"></i>{{ now()->format('d/m/Y') }}</span>
                    <button class="theme-btn" id="themeToggle">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                    <a href="{{ route('projets.index') }}" class="btn-retour">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <div class="nav-wrap">
                <a href="/" class="nav-item"><i class="bi bi-table"></i> Projets</a>
                <a href="/tableau-de-bord" class="nav-item"><i class="bi bi-bar-chart"></i> Tableau de bord</a>
                <a href="/consultants" class="nav-item"><i class="bi bi-people"></i> Consultants</a>
                <a href="/nouveau-projet" class="nav-item active"><i class="bi bi-plus-circle"></i> Nouveau projet</a>
                @if(auth()->check() && auth()->user()->isSuperAdmin())
                <a href="/admin/users" class="nav-item"><i class="bi bi-shield-lock"></i> Administration</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-4">
        <form action="{{ route('projets.store') }}" method="POST" id="mainForm">
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
                    C - Dates du projet
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
                    D - Indicateurs de suivi
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
                        <label class="form-label">
                            Jours réalisés
                            <span class="badge-auto"><i class="bi bi-lock-fill"></i> Auto</span>
                        </label>
                        <input type="number" class="form-control auto-calc" name="jours_realises"
                            id="jours_realises" value="0" readonly>
                        <div class="auto-tag">
                            <i class="bi bi-arrow-right"></i> Sera calculé après création
                        </div>
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
                    E - Suivi des chapitres SMI
                    <span class="auto-badge">Configuration initiale</span>
                </div>

                <div class="table-smi-container">
                    <table class="table-smi">
                        <thead>
                            <tr>
                                <th style="width:10%;">Chapitre</th>
                                <th style="width:12%;">Livrables</th>
                                <th class="col-exigences">Exigences clés</th>
                                <th style="width:7%;">Av. %</th>
                                <th style="width:10%;">Phase</th>
                                <th style="width:7%;">J. Interv.</th>
                                <th style="width:12%;">Observations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chapitres as $index => $chap)
                            @php
                                $codeChapitre = $chap->code_chapitre;
                                $chapLiv = $livrablesByChap[$codeChapitre] ?? null;
                                $livTotal = $chapLiv['total'] ?? 0;
                                $collapseId = 'liv-chap-' . $chap->id;
                            @endphp
                            <tr>
                                <td>
                                    <span class="chapitre-code">{{ $codeChapitre }}</span>
                                    <span class="chapitre-titre">{{ $chap->titre_chapitre }}</span>
                                    <input type="hidden" name="chapitres[{{ $index }}][chapitre_id]" value="{{ $chap->id }}">
                                </td>
                                <td>
                                    @if($livTotal > 0)
                                        <button class="livrables-toggle" type="button" onclick="toggleLivrables('{{ $collapseId }}', this)">
                                            <i class="bi bi-list-ul me-1"></i>
                                            Voir ({{ $livTotal }})
                                        </button>
                                        <div class="livrables-count" id="count-{{ $collapseId }}">0/{{ $livTotal }} (0%)</div>
                                    @else
                                        <span style="color: var(--text-muted);">—</span>
                                    @endif
                                </td>
                                <td class="col-exigences">
                                    <textarea name="chapitres[{{ $index }}][exigences_cles]"
                                        class="form-control" rows="4">{{ $chap->exigences_cles }}</textarea>
                                </td>
                                <td>
                                    <input type="number" class="form-control input-num avancement"
                                        name="chapitres[{{ $index }}][avancement]"
                                        id="avancement-{{ $codeChapitre }}"
                                        min="0" max="100" value="0"
                                        readonly>
                                    <small style="font-size: 0.6rem; color: var(--text-muted); display: block; text-align: center;">
                                        auto
                                    </small>
                                </td>
                                <td>
                                    <select class="phase-select" name="chapitres[{{ $index }}][phase]">
                                        @foreach(['⬜ Non démarré','⏳ Démarré','🔄 En cours','✅ Terminé'] as $phase)
                                        <option value="{{ $phase }}" {{ $loop->first ? 'selected' : '' }}>
                                            {{ $phase }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control input-num jours"
                                        name="chapitres[{{ $index }}][jours]"
                                        min="0" value="0">
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        name="chapitres[{{ $index }}][observations]"
                                        placeholder="Observations...">
                                </td>
                            </tr>

                            @if($livTotal > 0)
                            <tr class="livrables-row" id="{{ $collapseId }}" style="display: none;">
                                <td colspan="7" style="background: var(--surface-hover); padding: 1rem;">
                                    <table class="livrables-inline-table">
                                        <thead>
                                            <tr>
                                                <th style="width:95px;">Clause</th>
                                                <th>Libellé</th>
                                                <th style="width:150px;">Statut initial</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($chapLiv['items'] as $liv)
                                            <tr>
                                                <td>{{ $liv->clause ?: '—' }}</td>
                                                <td>{{ $liv->libelle }}</td>
                                                <td>
                                                    <select class="liv-statut-select s-nc"
                                                        name="livrables[{{ $liv->id }}]"
                                                        onchange="updateChapterProgress('{{ $codeChapitre }}', '{{ $collapseId }}')">
                                                        <option value="Non commencé" selected>⬜ Non commencé</option>
                                                        <option value="En cours">🔄 En cours</option>
                                                        <option value="Terminé">✅ Terminé</option>
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
                </div>
            </div>

            <!-- Section F - Consultants (initialement vide) -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-people"></i>
                    F - Équipe projet
                </div>

                <div id="existingConsultantsContainer">
                    <!-- Aucun consultant initialement -->
                </div>

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
                            <button type="button" class="btn-add w-100" onclick="addConsultant()">
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
                                <th style="width:200px;">Statut initial</th>
                                <th>Observations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $formations = DB::table('formations')->get();
                            @endphp
                            @foreach($formations as $index => $form)
                            <tr>
                                <td style="font-weight:500;">
                                    <input type="hidden" name="formations[{{ $index }}][id]" value="{{ $form->id }}">
                                    {{ $form->titre_formation }}
                                </td>
                                <td>
                                    <select class="form-select" name="formations[{{ $index }}][statut]">
                                        @foreach(['À planifier','En cours','Réalisée','Finalisée'] as $st)
                                        <option value="{{ $st }}" {{ $st == 'À planifier' ? 'selected' : '' }}>
                                            {{ $st }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        name="formations[{{ $index }}][observations]"
                                        placeholder="Observations...">
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
                            placeholder="Décrire les blocages éventuels...">{{ old('blocage') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Commentaires généraux</label>
                        <textarea class="form-control" name="commentaire" rows="3"
                            placeholder="Informations complémentaires...">{{ old('commentaire') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
<div class="d-flex justify-content-end gap-3 mb-5">
    <a href="{{ route('projets.index') }}" class="btn-secondary">
        <i class="bi bi-x-circle"></i>
        Annuler
    </a>
    
    <!-- Pas de bouton Gantt ici car le projet n'est pas encore créé -->
    
    <button type="submit" class="btn-primary" onclick="this.classList.add('loading')">
        <i class="bi bi-check-circle"></i>
        Créer le projet
    </button>
</div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

        // Toggle livrables
        function toggleLivrables(id, btn) {
            const element = document.getElementById(id);
            if (element.style.display === 'none') {
                element.style.display = 'table-row';
                btn.innerHTML = '<i class="bi bi-eye-slash me-1"></i> Cacher';
            } else {
                element.style.display = 'none';
                const count = element.querySelectorAll('.liv-statut-select').length;
                btn.innerHTML = `<i class="bi bi-list-ul me-1"></i> Voir (${count})`;
            }
        }

        // Mettre à jour la progression d'un chapitre
        function updateChapterProgress(chapCode, collapseId) {
            const row = document.getElementById(collapseId);
            const selects = row.querySelectorAll('.liv-statut-select');
            let total = selects.length;
            let termines = 0;
            
            selects.forEach(s => {
                if (s.value === 'Terminé') termines++;
                // Mettre à jour la classe du select
                s.className = 'liv-statut-select ' +
                    (s.value === 'Terminé' ? 's-ok' :
                        s.value === 'En cours' ? 's-ec' : 's-nc');
            });
            
            const pct = Math.round((termines / total) * 100);
            
            // Mettre à jour l'avancement du chapitre
            const avancementField = document.getElementById('avancement-' + chapCode);
            if (avancementField) {
                avancementField.value = pct;
            }
            
            // Mettre à jour le compteur
            const countDiv = document.getElementById('count-' + collapseId);
            if (countDiv) {
                countDiv.innerHTML = `${termines}/${total} (${pct}%)`;
            }
            
            // Mettre à jour l'avancement global
            updateGlobalProgress();
        }

        // Calculer l'avancement global
        function updateGlobalProgress() {
            let totalGlobal = 0;
            let terminesGlobal = 0;
            
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
            
            const avancementGlobalField = document.getElementById('avancement_percent');
            if (avancementGlobalField) {
                avancementGlobalField.value = pctGlobal;
            }
        }

        // Ajouter un consultant
        function addConsultant() {
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