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
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.5);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
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

        /* Cards */
        .detail-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            transition: box-shadow 0.2s, border-color 0.2s;
        }

        .detail-card:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--border-dark);
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.25rem;
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

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
        }

        .info-item {
            background: var(--surface-hover);
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            border-left: 3px solid var(--accent);
            transition: background 0.2s;
        }

        .info-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin-bottom: 0.4rem;
        }

        .info-value {
            font-weight: 600;
            font-size: 1rem;
            color: var(--text-primary);
        }

        .info-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.25rem 1rem;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.7rem;
            display: inline-block;
            letter-spacing: 0.02em;
        }

        .status-badge.finalized {
            background: var(--success-light);
            color: var(--success);
        }

        .status-badge.delayed {
            background: var(--danger-light);
            color: var(--danger);
        }

        .status-badge.in-progress {
            background: var(--warning-light);
            color: var(--warning);
        }

        .status-badge.planned {
            background: var(--info-light);
            color: var(--info);
        }

        /* Norme Pills */
        .norme-pill {
            background: var(--surface-hover);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            padding: 0.2rem 0.9rem;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
            margin: 0.2rem;
            transition: all 0.2s;
        }

        .norme-pill:hover {
            border-color: var(--accent);
            background: var(--accent-soft);
            color: var(--accent);
        }

        /* KPI Boxes */
        .kpi-box {
            background: var(--surface-hover);
            border-radius: var(--radius-md);
            padding: 1.2rem 1rem;
            text-align: center;
            transition: transform 0.2s;
        }

        .kpi-box:hover {
            transform: translateY(-2px);
        }

        .kpi-label {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        /* Progress Bar */
        .progress-container {
            background: var(--border);
            height: 6px;
            border-radius: 100px;
            overflow: hidden;
            margin-top: 0.8rem;
        }

        .progress-fill {
            height: 100%;
            border-radius: 100px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            transition: width 0.3s ease;
        }

        /* Table Styles */
        .table-pro {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.82rem;
        }

        .table-pro thead th {
            background: var(--surface-hover);
            color: var(--text-muted);
            padding: 0.7rem 0.75rem;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 2px solid var(--border);
            white-space: nowrap;
        }

        .table-pro tbody td {
            padding: 0.7rem 0.75rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-secondary);
            vertical-align: middle;
        }

        .table-pro tbody tr:last-child td {
            border-bottom: none;
        }

        .table-pro tbody tr:hover td {
            background: var(--surface-hover);
        }

        /* Print Button Column */
        .print-col {
            width: 40px;
            text-align: center;
        }

        .btn-print-chapter {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-muted);
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .btn-print-chapter:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        /* Chapter Phase Badges */
        .phase-badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 1rem;
            border-radius: 100px;
            display: inline-block;
        }

        .phase-completed {
            background: var(--success-light);
            color: var(--success);
        }

        .phase-in-progress {
            background: var(--warning-light);
            color: var(--warning);
        }

        .phase-started {
            background: var(--info-light);
            color: var(--info);
        }

        .phase-not-started {
            background: var(--surface-hover);
            color: var(--text-muted);
        }

        /* Livrables Toggle */
        .livrables-toggle {
            border: 1px solid var(--border);
            background: var(--surface-hover);
            color: var(--text-secondary);
            padding: 0.2rem 0.8rem;
            font-size: 0.7rem;
            border-radius: var(--radius-sm);
            font-weight: 500;
            transition: all 0.2s;
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

        /* ===== STYLES POUR PREUVES ===== */
        .btn-preuve-voir {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid var(--accent);
            background: var(--accent-soft);
            color: var(--accent);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.8rem;
        }

        .btn-preuve-voir:hover {
            background: var(--accent);
            color: white;
            transform: scale(1.1);
        }

        .preuve-count-badge {
            font-size: 0.6rem;
            font-weight: 700;
            padding: 0.1rem 0.4rem;
            border-radius: 100px;
            background: var(--accent);
            color: white;
            min-width: 18px;
            text-align: center;
        }

        .preuve-count-badge.zero {
            background: var(--surface-hover);
            color: var(--text-muted);
        }

        /* Viewer modal */
        .preuve-viewer-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 11000;
        }

        .preuve-viewer-modal.active {
            display: flex;
        }

        .preuve-viewer-content {
            background: var(--surface);
            border-radius: var(--radius-lg);
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .preuve-viewer-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .preuve-viewer-header h5 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .btn-close-viewer {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 1.2rem;
            cursor: pointer;
        }

        .btn-close-viewer:hover {
            color: var(--danger);
        }

        .preuve-viewer-body {
            flex: 1;
            overflow: auto;
            padding: 1.5rem;
        }

        .preuve-viewer-body img {
            max-width: 100%;
            max-height: 70vh;
            display: block;
            margin: 0 auto;
        }

        .preuve-viewer-body .pdf-embed {
            width: 100%;
            height: 70vh;
            border: none;
        }

        .preuve-viewer-body .file-preview {
            text-align: center;
            padding: 2rem;
        }

        .btn-download {
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            font-size: 0.8rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-download:hover {
            background: var(--accent-light);
        }

        /* Preuve list */
        .preuve-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .preuve-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            background: var(--surface-hover);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
        }

        .preuve-item:hover {
            border-color: var(--accent);
        }

        .preuve-thumb {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid var(--border);
        }

        .preuve-thumb-icon {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            background: var(--accent-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 1.2rem;
        }

        .preuve-info {
            flex: 1;
        }

        .preuve-info h6 {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.2rem;
        }

        .preuve-info p {
            font-size: 0.65rem;
            color: var(--text-muted);
            margin: 0;
        }
        /* ===== FIN STYLES PREUVES ===== */

        /* ===== STYLES POUR FICHIERS D'INTERVENTION ===== */
        .intervention-section {
            margin-top: 2rem;
        }

        .intervention-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .intervention-header h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .intervention-header h4 i {
            color: var(--accent);
        }

        .intervention-count {
            background: var(--accent-soft);
            color: var(--accent);
            padding: 0.25rem 1rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .intervention-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-top: 1rem;
        }

        .intervention-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .intervention-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--accent);
        }

        .intervention-thumb {
            height: 150px;
            background: linear-gradient(135deg, var(--surface-hover), var(--surface));
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid var(--border);
        }

        .intervention-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .intervention-thumb i {
            font-size: 3.5rem;
            color: var(--accent);
        }

        .intervention-body {
            padding: 1rem;
        }

        .intervention-body h5 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .intervention-meta {
            font-size: 0.7rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .intervention-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .intervention-meta i {
            font-size: 0.65rem;
            color: var(--accent);
        }

        .intervention-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            border-top: 1px solid var(--border);
            padding-top: 0.75rem;
        }

        .intervention-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--surface-hover);
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .intervention-btn:hover {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .intervention-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            background: var(--surface-hover);
            border: 2px dashed var(--border);
            border-radius: var(--radius-lg);
            color: var(--text-muted);
        }

        .intervention-empty i {
            font-size: 3rem;
            color: var(--border);
            margin-bottom: 0.5rem;
        }

        .intervention-empty p {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .intervention-empty small {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        /* ===== FIN STYLES FICHIERS D'INTERVENTION ===== */

        /* Modal Styles */
        .print-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            backdrop-filter: blur(4px);
        }

        .print-modal.active {
            display: flex;
        }

        .print-modal-content {
            background: var(--surface);
            border-radius: var(--radius-lg);
            width: 90%;
            max-width: 900px;
            max-height: 85vh;
            overflow-y: auto;
            padding: 2rem;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            border: 1px solid var(--border);
        }

        .modal-close {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            background: var(--surface-hover);
            border: 1px solid var(--border);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--text-muted);
        }

        .modal-close:hover {
            background: var(--danger);
            border-color: var(--danger);
            color: white;
        }

        .btn-print-action {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.7rem 2rem;
            border-radius: 100px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-print-action:hover {
            background: var(--accent-light);
            transform: translateY(-2px);
        }

        /* Print Document Styles */
        .print-document {
            padding: 0.5rem;
        }

        .print-header {
            border-bottom: 2px solid var(--accent);
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .print-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 0.25rem;
        }

        .print-subtitle {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .print-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            background: var(--surface-hover);
            padding: 0.4rem 1rem;
            border-radius: 100px;
        }

        .print-section {
            margin-bottom: 2rem;
        }

        .print-section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }

        .print-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            background: var(--surface-hover);
            padding: 1.25rem;
            border-radius: var(--radius-md);
        }

        .print-info-row {
            display: flex;
            border-bottom: 1px dashed var(--border);
            padding: 0.6rem 0;
        }

        .print-info-label {
            width: 130px;
            font-weight: 600;
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .print-info-value {
            flex: 1;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .print-table th {
            background: var(--surface-hover);
            color: var(--text-muted);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 0.6rem;
            border: 1px solid var(--border);
        }

        .print-table td {
            padding: 0.6rem;
            border: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        .print-footer {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px solid var(--accent);
            text-align: center;
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .nav-wrap {
                flex-wrap: wrap;
                border-radius: var(--radius-md);
                width: 100%;
            }
            
            .intervention-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Print Styles */
        @media print {
            .site-header, .nav-wrap, .btn-retour, .theme-btn, 
            .btn-print-chapter, .livrables-toggle, .btn-print-action,
            .modal-close, .d-flex.justify-content-end, .btn-preuve-voir,
            .intervention-btn, .intervention-section {
                display: none !important;
            }
            
            body {
                background: white;
                padding: 0.5in;
            }
            
            .detail-card {
                box-shadow: none;
                border: 1px solid #ddd;
                break-inside: avoid;
                page-break-inside: avoid;
            }
            
            .print-modal, .preuve-viewer-modal {
                display: none !important;
            }
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
    </style>
</head>
<body>

@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$id = request()->route('id') ?? request()->query('id') ?? 0;
if($id == 0) { echo "<div class='alert alert-danger m-5'>Projet non spécifié</div>"; return; }

$projet = DB::selectOne("
    SELECT p.*, c.nom_client, c.secteur_activite, cons.nom_complet as chef_nom, cons.email as chef_email
    FROM projets p
    LEFT JOIN clients c ON p.client_id = c.id
    LEFT JOIN consultants cons ON p.chef_projet_id = cons.id
    WHERE p.id = ?
", [$id]);

if(!$projet) { echo "<div class='alert alert-warning m-5'>Projet introuvable</div>"; return; }

$normes      = DB::select("SELECT n.* FROM normes n JOIN projet_normes pn ON n.id = pn.norme_id WHERE pn.projet_id = ?", [$id]);
$consultants = DB::select("SELECT cons.*, a.role_dans_projet, a.jours_alloues, a.jours_realises FROM affectations a JOIN consultants cons ON a.consultant_id = cons.id WHERE a.projet_id = ?", [$id]);
$chapitres   = DB::select("SELECT sc.*, cs.code_chapitre, cs.titre_chapitre, cs.exigences_cles FROM suivi_chapitres sc JOIN chapitres_smis cs ON sc.chapitre_id = cs.id WHERE sc.projet_id = ? ORDER BY cs.ordre", [$id]);
$formations  = DB::select("SELECT f.*, pf.statut, pf.observations FROM formations f JOIN projet_formations pf ON f.id = pf.formation_id WHERE pf.projet_id = ?", [$id]);

$statusClass = match($projet->statut) {
    'Finalisé' => 'finalized',
    'En retard' => 'delayed',
    'En cours' => 'in-progress',
    default => 'planned'
};

$ganttCount = DB::table('gantt_taches')->where('projet_id', $id)->count();

$livrableRows = DB::select("
    SELECT ls.id, ls.chapitre_code, ls.clause, ls.libelle, ls.phase_smi, ls.ordre,
           COALESCE(pl.statut, 'Non commencé') as statut
    FROM livrables_smi ls
    LEFT JOIN projet_livrables pl ON pl.livrable_id = ls.id AND pl.projet_id = ?
    ORDER BY ls.ordre ASC
", [$id]);

// Récupérer les preuves par livrable
$preuvesParLivrable = [];
$preuveRows = DB::table('livrable_preuves')
    ->where('projet_id', $id)
    ->orderBy('created_at', 'desc')
    ->get();
foreach ($preuveRows as $pr) {
    $pr->url = str_starts_with($pr->fichier_path, 'http') 
    ? $pr->fichier_path 
    : asset('storage/preuves/' . $pr->fichier_path);
    $preuvesParLivrable[$pr->livrable_id][] = $pr;
}

// Récupérer les fichiers d'intervention (preuves projet)
$fichiersIntervention = DB::table('projet_preuves')
    ->where('projet_id', $id)
    ->orderBy('created_at', 'desc')
    ->get();
foreach ($fichiersIntervention as $fi) {
    $pr->url = str_starts_with($pr->fichier_path, 'http') 
    ? $pr->fichier_path 
    : asset('storage/preuves_projet/' . $pr->fichier_path);
}

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

// Calculer l'avancement par chapitre basé sur les livrables
$avancementParChapitre = [];
foreach ($livrablesByChap as $chapCode => $chapData) {
    $avancementParChapitre[$chapCode] = $chapData['total'] > 0 
        ? round(($chapData['termines'] / $chapData['total']) * 100) 
        : 0;
}

// Avancement global basé sur les livrables
$avancementGlobalLivrables = $totalLivrablesGlobal > 0 ? round(($terminesLivrablesGlobal / $totalLivrablesGlobal) * 100) : 0;

$chapCodeById = DB::table('chapitres_smis')->pluck('code_chapitre', 'id')->toArray();

$chapsColl = collect($chapitres);
$joursRealisesCalc = $chapsColl->sum('jours_intervention');
$totalChap = $chapsColl->count();
$doneChap = $chapsColl->where('phase', 'Terminé')->count();

$user = auth()->user();
@endphp

<!-- Print Modal -->
<div class="print-modal" id="printModal">
    <div class="print-modal-content" id="printContent">
        <div class="modal-close" onclick="closePrintModal()">
            <i class="bi bi-x"></i>
        </div>
        <div id="printDocument"></div>
        <div class="text-center mt-4">
            <button class="btn-print-action" onclick="printDocument()">
                <i class="bi bi-printer"></i>
                Imprimer le document
            </button>
        </div>
    </div>
</div>

<!-- Preuve Viewer Modal -->
<div class="preuve-viewer-modal" id="preuveViewerModal">
    <div class="preuve-viewer-content">
        <div class="preuve-viewer-header">
            <h5 id="preuveViewerTitle">Preuve</h5>
            <button class="btn-close-viewer" onclick="closePreuveViewer()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="preuve-viewer-body" id="preuveViewerBody">
            <!-- Contenu injecté par JS -->
        </div>
    </div>
</div>

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
            <a href="/" class="nav-item">
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

<!-- Main Content -->
<div class="container py-4">

    <!-- Informations Générales -->
    <div class="detail-card">
        <div class="section-title">
            <i class="bi bi-info-circle"></i>
            Informations générales
        </div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Statut</div>
                <div class="info-value">
                    <span class="status-badge {{ $statusClass }}">{{ $projet->statut }}</span>
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Chef de projet</div>
                <div class="info-value">{{ $projet->chef_nom ?? 'Non assigné' }}</div>
                @if($projet->chef_email)
                    <div class="info-sub">{{ $projet->chef_email }}</div>
                @endif
            </div>
            <div class="info-item">
                <div class="info-label">Client</div>
                <div class="info-value">{{ $projet->nom_client }}</div>
                <div class="info-sub">{{ $projet->secteur_activite ?? 'Secteur non spécifié' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Période</div>
                <div class="info-value">Début: {{ $projet->date_debut ? date('d/m/Y', strtotime($projet->date_debut)) : '—' }}</div>
                <div class="info-sub">Fin prévue: {{ $projet->date_fin_prevue ? date('d/m/Y', strtotime($projet->date_fin_prevue)) : '—' }}</div>
            </div>
        </div>

        @if(count($normes))
        <div class="mt-3">
            <div class="info-label mb-2">Normes applicables</div>
            @foreach($normes as $norme)
                <span class="norme-pill">{{ $norme->code_norme }}</span>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Indicateurs de suivi -->
    <div class="detail-card">
        <div class="section-title">
            <i class="bi bi-graph-up"></i>
            Indicateurs de suivi
        </div>
        @php
            $consoCalc = $projet->jours_prevus > 0 ? round(($joursRealisesCalc / $projet->jours_prevus) * 100) : 0;
            $ecartCalc = $joursRealisesCalc - $projet->jours_prevus;
        @endphp
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="kpi-box">
                    <div class="kpi-label">Jours prévus</div>
                    <div class="kpi-value">{{ $projet->jours_prevus }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="kpi-box">
                    <div class="kpi-label">Jours réalisés</div>
                    <div class="kpi-value">{{ $joursRealisesCalc }}</div>
                    <div style="font-size:0.7rem; color:var(--text-muted);">Total interventions</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="kpi-box">
                    <div class="kpi-label">Consommation</div>
                    <div class="kpi-value">{{ $consoCalc }}%</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="kpi-box">
                    <div class="kpi-label">Écart</div>
                    <div class="kpi-value" style="color:{{ $ecartCalc >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                        {{ $ecartCalc > 0 ? '+' : '' }}{{ $ecartCalc }}
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <div class="d-flex justify-content-between mb-1">
                <span style="font-size:0.8rem; color:var(--text-secondary);">Avancement global (livrables)</span>
                <span style="font-weight:600; color:var(--text-primary);">{{ $avancementGlobalLivrables }}%</span>
            </div>
            <div class="progress-container">
                <div class="progress-fill" style="width: {{ $avancementGlobalLivrables }}%;"></div>
            </div>
            <div style="font-size:0.7rem; color:var(--text-muted); text-align:right; margin-top:0.3rem;">
                {{ $terminesLivrablesGlobal }}/{{ $totalLivrablesGlobal }} livrables terminés
            </div>
        </div>
    </div>

    <!-- Exigences clés SMI -->
    @if(count($chapitres))
    <div class="detail-card">
        <div class="section-title">
            <i class="bi bi-list-check"></i>
            Exigences clés SMI
        </div>
        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
            @foreach($chapitres as $chap)
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem; {{ !$loop->last ? 'margin-bottom: 0.5rem;' : '' }}">
                <div style="display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <span style="font-weight: 700; color: var(--accent);">{{ $chap->code_chapitre }}</span>
                    <span style="color: var(--text-secondary);">—</span>
                    <span style="font-weight: 500; color: var(--text-primary);">{{ $chap->titre_chapitre }}</span>
                </div>
                @if($chap->exigences_cles)
                <div style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.6; background: var(--surface-hover); padding: 1rem; border-radius: var(--radius-sm);">
                    {!! nl2br(e($chap->exigences_cles)) !!}
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Suivi des chapitres SMI -->
    <div class="detail-card">
        <div class="section-title">
            <i class="bi bi-journal-check"></i>
            Suivi des chapitres SMI
            <span class="auto-badge">automatique</span>
        </div>
        <div class="table-responsive">
            <table class="table-pro">
                <thead>
                    <tr>
                        <th class="print-col"></th>
                        <th>Chapitre</th>
                        <th>Livrables</th>
                        <th class="text-center">Avancement</th>
                        <th>Phase</th>
                        <th class="text-center">J. intervention</th>
                        <th>Observations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chapitres as $chap)
                    @php
                        $phaseClass = match($chap->phase) {
                            'Terminé' => 'phase-completed',
                            'En cours' => 'phase-in-progress',
                            'Démarré' => 'phase-started',
                            default => 'phase-not-started'
                        };

                        $chapCode = $chapCodeById[$chap->chapitre_id] ?? $chap->code_chapitre ?? null;
                        $chapLiv = $chapCode && isset($livrablesByChap[$chapCode]) ? $livrablesByChap[$chapCode] : null;
                        $livTotal = $chapLiv['total'] ?? 0;
                        $livDone = $chapLiv['termines'] ?? 0;
                        $livPct = $livTotal > 0 ? round(($livDone / $livTotal) * 100) : 0;
                        
                        // Avancement basé sur les livrables
                        $avancementReel = $chapCode && isset($avancementParChapitre[$chapCode]) ? $avancementParChapitre[$chapCode] : $chap->avancement_percent;
                        
                        $collapseId = 'liv-chap-' . $chap->chapitre_id;
                        $chapLivrables = $chapLiv['items'] ?? [];
                    @endphp
                    <tr>
                        <td class="print-col">
                            <button class="btn-print-chapter" onclick='showPrintDocument({{ json_encode([
                                "code" => $chap->code_chapitre,
                                "titre" => $chap->titre_chapitre,
                                "phase" => $chap->phase,
                                "avancement" => $avancementReel,
                                "jours" => $chap->jours_intervention,
                                "observations" => $chap->observations,
                                "exigences" => $chap->exigences_cles,
                                "livrables" => array_map(function($l) {
                                    return [
                                        "clause" => $l->clause,
                                        "libelle" => $l->libelle,
                                        "statut" => $l->statut
                                    ];
                                }, $chapLivrables),
                                "projet_nom" => $projet->nom_client,
                                "chef_nom" => $projet->chef_nom,
                                "projet_statut" => $projet->statut
                            ]) }})'>
                                <i class="bi bi-printer"></i>
                            </button>
                        </td>
                        <td>
                            <strong style="color: var(--accent);">{{ $chap->code_chapitre }}</strong>
                            <span style="color: var(--text-muted); margin-left: 0.5rem; font-size: 0.75rem;">{{ $chap->titre_chapitre }}</span>
                        </td>
                        <td style="min-width: 180px;">
                            @if($livTotal > 0)
                                <button class="livrables-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}">
                                    <i class="bi bi-list-ul me-1"></i>
                                    Voir livrables
                                </button>
                                <div class="livrables-count">{{ $livDone }}/{{ $livTotal }} complétés ({{ $livPct }}%)</div>
                            @else
                                <span style="color: var(--text-muted);">Aucun livrable</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <strong style="color: var(--accent);">{{ $avancementReel }}%</strong>
                            @if($avancementReel != $chap->avancement_percent)
                                <div style="font-size: 0.6rem; color: var(--text-muted);">(basé sur livrables)</div>
                            @endif
                        </td>
                        <td><span class="phase-badge {{ $phaseClass }}">{{ $chap->phase }}</span></td>
                        <td class="text-center">{{ $chap->jours_intervention }}</td>
                        <td style="color: var(--text-muted); max-width: 200px;">
                            {{ Str::limit($chap->observations ?? '—', 35) }}
                        </td>
                    </tr>

                    @if($livTotal > 0)
                    <tr class="collapse" id="{{ $collapseId }}">
                        <td colspan="7" style="background: var(--surface-hover); padding: 1rem;">
                            <table class="livrables-inline-table">
                                <thead>
                                    <tr>
                                        <th>Clause</th>
                                        <th>Libellé</th>
                                        <th>Statut</th>
                                        <th style="text-align:center;">Preuves</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chapLiv['items'] as $liv)
                                    @php
                                        $statusClass = match($liv->statut) {
                                            'Terminé' => 'completed',
                                            'En cours' => 'in-progress',
                                            default => 'pending'
                                        };
                                        $livPreuves = $preuvesParLivrable[$liv->id] ?? [];
                                        $preuveCount = count($livPreuves);
                                    @endphp
                                    <tr>
                                        <td>{{ $liv->clause ?: '—' }}</td>
                                        <td>{{ $liv->libelle }}</td>
                                        <td>
                                            <span class="livrable-status {{ $statusClass }}">
                                                {{ $liv->statut }}
                                            </span>
                                        </td>
                                        <td style="text-align:center; vertical-align:middle;">
                                            <div style="display:flex; align-items:center; justify-content:center; gap:0.5rem;">
                                                <button class="btn-preuve-voir" 
                                                        onclick="showPreuves({{ $liv->id }}, '{{ addslashes($liv->libelle) }}')"
                                                        title="Voir les preuves">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                                <span class="preuve-count-badge {{ $preuveCount == 0 ? 'zero' : '' }}">
                                                    {{ $preuveCount }}
                                                </span>
                                            </div>
                                            
                                            <!-- Hidden preuves data -->
                                            <div id="preuves-{{ $liv->id }}" style="display:none;">
                                                @foreach($livPreuves as $pr)
                                                <div class="preuve-data" 
                                                     data-id="{{ $pr->id }}"
                                                     data-label="{{ $pr->label }}"
                                                     data-nom="{{ $pr->fichier_nom }}"
                                                     data-mime="{{ $pr->mime_type }}"
                                                     data-url="{{ $pr->url }}"
                                                     data-taille="{{ $pr->taille_kb }}"
                                                     data-date="{{ \Carbon\Carbon::parse($pr->created_at)->format('d/m/Y H:i') }}">
                                                </div>
                                                @endforeach
                                            </div>
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

        <div style="margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.8rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-check-circle-fill" style="color: var(--success);"></i>
                Chapitres terminés
            </span>
            <span style="font-weight: 600; color: var(--text-primary);">{{ $doneChap }}/{{ $totalChap }}</span>
        </div>
    </div>

    <!-- Consultants et formations -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="detail-card h-100">
                <div class="section-title">
                    <i class="bi bi-people"></i>
                    Charge de travail
                </div>
                @if(count($consultants))
                <table class="table-pro">
                    <thead>
                        <tr>
                            <th>Consultant</th>
                            <th>Rôle</th>
                            <th class="text-center">Alloués</th>
                            <th class="text-center">Réalisés</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultants as $c)
                        @php $pct = $c->jours_alloues > 0 ? round(($c->jours_realises / $c->jours_alloues) * 100) : 0; @endphp
                        <tr>
                            <td style="font-weight: 500;">{{ $c->nom_complet }}</td>
                            <td style="color: var(--text-muted);">{{ $c->role_dans_projet }}</td>
                            <td class="text-center">{{ $c->jours_alloues }}</td>
                            <td class="text-center">{{ $c->jours_realises }}</td>
                            <td class="text-center">
                                <span style="font-weight: 600; color: {{ $pct > 100 ? 'var(--danger)' : 'var(--success)' }};">
                                    {{ $pct }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p style="color: var(--text-muted); text-align: center; padding: 2rem;">Aucun consultant affecté</p>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="detail-card h-100">
                <div class="section-title">
                    <i class="bi bi-mortarboard"></i>
                    Plan de formation
                </div>
                @if(count($formations))
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
                            $formClass = match($f->statut) {
                                'Finalisée', 'Réalisée' => 'phase-completed',
                                'En cours' => 'phase-in-progress',
                                default => 'phase-not-started'
                            };
                        @endphp
                        <tr>
                            <td>{{ $f->titre_formation }}</td>
                            <td><span class="phase-badge {{ $formClass }}">{{ $f->statut }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p style="color: var(--text-muted); text-align: center; padding: 2rem;">Aucune formation planifiée</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Points d'attention -->
    @if(($projet->blocage && $projet->blocage != 'RAS') || $projet->commentaire)
    <div class="detail-card">
        <div class="section-title">
            <i class="bi bi-exclamation-triangle"></i>
            Points d'attention
        </div>
        @if($projet->blocage && $projet->blocage != 'RAS')
        <div style="background: var(--danger-light); border-left: 4px solid var(--danger); padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1rem;">
            <strong style="color: var(--danger);">Blocage :</strong>
            <span style="color: var(--text-secondary); margin-left: 0.5rem;">{{ $projet->blocage }}</span>
        </div>
        @endif
        @if($projet->commentaire)
        <div style="background: var(--info-light); border-left: 4px solid var(--info); padding: 1rem; border-radius: var(--radius-sm);">
            <strong style="color: var(--info);">Commentaire :</strong>
            <span style="color: var(--text-secondary); margin-left: 0.5rem;">{{ $projet->commentaire }}</span>
        </div>
        @endif
    </div>
    @endif

    <!-- ===== SECTION FICHIERS D'INTERVENTION ===== -->
    <div class="detail-card intervention-section">
        <div class="section-title">
            <i class="bi bi-folder-fill"></i>
            Fichiers d'intervention du projet
        </div>

        <div class="intervention-header">
            <h4>
                <i class="bi bi-file-earmark"></i>
                Documents et preuves du projet
            </h4>
            <span class="intervention-count">{{ count($fichiersIntervention) }} document(s)</span>
        </div>

        @if(count($fichiersIntervention) > 0)
        <div class="intervention-grid">
            @foreach($fichiersIntervention as $doc)
            @php
                $isImage = Str::startsWith($doc->mime_type, 'image/');
                $isPdf = $doc->mime_type === 'application/pdf';
                $fileIcon = $isPdf ? 'bi-file-earmark-pdf-fill' : 
                           ($isImage ? 'bi-file-earmark-image-fill' : 
                           (Str::contains($doc->mime_type, 'word') ? 'bi-file-earmark-word-fill' :
                           (Str::contains($doc->mime_type, 'excel') ? 'bi-file-earmark-excel-fill' :
                           'bi-file-earmark-fill')));
                $fileColor = $isPdf ? '#ef4444' : 
                            ($isImage ? '#3b82f6' : 
                            (Str::contains($doc->mime_type, 'word') ? '#2563eb' :
                            (Str::contains($doc->mime_type, 'excel') ? '#10b981' : '#6b7280')));
            @endphp
            <div class="intervention-card">
                <div class="intervention-thumb">
                    @if($isImage)
                    <img src="{{ $doc->url }}" alt="{{ $doc->label ?: $doc->fichier_nom }}">
                    @else
                    <i class="bi {{ $fileIcon }}" style="color: {{ $fileColor }};"></i>
                    @endif
                </div>
                <div class="intervention-body">
                    <h5 title="{{ $doc->label ?: $doc->fichier_nom }}">
                        {{ Str::limit($doc->label ?: $doc->fichier_nom, 30) }}
                    </h5>
                    <div class="intervention-meta">
                        <span><i class="bi bi-file-earmark"></i> {{ strtoupper(pathinfo($doc->fichier_nom, PATHINFO_EXTENSION)) }}</span>
                        <span><i class="bi bi-hdd"></i> {{ $doc->taille_kb }} Ko</span>
                        <span><i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($doc->created_at)->format('d/m/Y') }}</span>
                    </div>
                    <div class="intervention-actions">
                        <button class="intervention-btn" onclick="viewDocument('{{ $doc->url }}', '{{ $doc->mime_type }}', '{{ addslashes($doc->label ?: $doc->fichier_nom) }}')" title="Voir le document">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        <button class="intervention-btn" onclick="printDocumentUrl('{{ $doc->url }}', '{{ addslashes($doc->label ?: $doc->fichier_nom) }}')" title="Imprimer">
                            <i class="bi bi-printer-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="intervention-empty">
            <i class="bi bi-folder2-open"></i>
            <p>Aucun fichier d'intervention</p>
            <small>Ce projet n'a pas encore de documents attachés</small>
        </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-end gap-3 mb-5">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary" style="border-radius: 100px; padding: 0.6rem 1.8rem;">
            <i class="bi bi-arrow-left me-1"></i>
            Retour
        </a>
        
        @if($user->hasPermission('voir_gantt'))
        <a href="/projet/{{ $projet->id }}/gantt" class="btn btn-outline-success" style="border-radius: 100px; padding: 0.6rem 1.8rem;">
            <i class="bi bi-bar-chart-steps me-1"></i>
            Planning Gantt
            @if($ganttCount > 0)
            <span class="badge bg-success text-white ms-1">{{ $ganttCount }}</span>
            @endif
        </a>
        @endif
        
        @if($user->hasPermission('modifier_projets'))
        <a href="{{ route('projet.edit', $projet->id) }}" class="btn btn-primary" style="border-radius: 100px; padding: 0.6rem 1.8rem; background: var(--accent); border-color: var(--accent);">
            <i class="bi bi-pencil-square me-1"></i>
            Modifier
        </a>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Variables globales
let currentChapterData = null;
let currentPreuves = {};

// Fonction pour afficher les preuves
function showPreuves(livId, libelle) {
    const preuvesDiv = document.getElementById('preuves-' + livId);
    if (!preuvesDiv) return;
    
    const preuveItems = preuvesDiv.querySelectorAll('.preuve-data');
    if (preuveItems.length === 0) {
        alert('Aucune preuve pour ce livrable');
        return;
    }
    
    // Construire la liste des preuves
    let html = '<div class="preuve-list">';
    
    preuveItems.forEach(item => {
        const id = item.dataset.id;
        const label = item.dataset.label || item.dataset.nom;
        const nom = item.dataset.nom;
        const mime = item.dataset.mime;
        const url = item.dataset.url;
        const taille = item.dataset.taille;
        const date = item.dataset.date;
        
        const isImage = mime && mime.startsWith('image/');
        const isPdf = mime === 'application/pdf';
        const icon = isPdf ? 'bi-file-earmark-pdf-fill' : 
                     (isImage ? 'bi-file-earmark-image-fill' : 'bi-file-earmark-fill');
        
        html += `
            <div class="preuve-item" onclick="viewPreuve('${url}', '${mime}', '${label || nom}')">
                ${isImage 
                    ? `<img src="${url}" class="preuve-thumb">`
                    : `<div class="preuve-thumb-icon"><i class="bi ${icon}"></i></div>`
                }
                <div class="preuve-info">
                    <h6>${label || nom}</h6>
                    <p>${taille} Ko • ${date}</p>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    
    document.getElementById('preuveViewerTitle').textContent = `Preuves - ${libelle}`;
    document.getElementById('preuveViewerBody').innerHTML = html;
    document.getElementById('preuveViewerModal').classList.add('active');
}

// Fonction pour voir une preuve en grand
function viewPreuve(url, mime, title) {
    const body = document.getElementById('preuveViewerBody');
    const isImage = mime && mime.startsWith('image/');
    const isPdf = mime === 'application/pdf';
    
    if (isImage) {
        body.innerHTML = `<img src="${url}" alt="${title}">`;
    } else if (isPdf) {
        body.innerHTML = `<iframe src="${url}" class="pdf-embed"></iframe>`;
    } else {
        body.innerHTML = `
            <div class="file-preview">
                <i class="bi bi-file-earmark" style="font-size:4rem; color:var(--text-muted);"></i>
                <p style="margin:1rem 0;">${title}</p>
                <p style="font-size:0.8rem; color:var(--text-muted);">Aperçu non disponible</p>
                <a href="${url}" download class="btn-download">
                    <i class="bi bi-download"></i> Télécharger
                </a>
            </div>
        `;
    }
    
    document.getElementById('preuveViewerTitle').textContent = title;
}

// Fonction pour voir un document (fichier d'intervention)
function viewDocument(url, mime, title) {
    const body = document.getElementById('preuveViewerBody');
    const isImage = mime && mime.startsWith('image/');
    const isPdf = mime === 'application/pdf';
    
    if (isImage) {
        body.innerHTML = `<img src="${url}" alt="${title}">`;
    } else if (isPdf) {
        body.innerHTML = `<iframe src="${url}" class="pdf-embed"></iframe>`;
    } else {
        body.innerHTML = `
            <div class="file-preview">
                <i class="bi bi-file-earmark" style="font-size:4rem; color:var(--text-muted);"></i>
                <p style="margin:1rem 0;">${title}</p>
                <p style="font-size:0.8rem; color:var(--text-muted);">Aperçu non disponible</p>
                <a href="${url}" download class="btn-download">
                    <i class="bi bi-download"></i> Télécharger
                </a>
            </div>
        `;
    }
    
    document.getElementById('preuveViewerTitle').textContent = title;
    document.getElementById('preuveViewerModal').classList.add('active');
}

// Fonction pour imprimer un document
function printDocumentUrl(url, title) {
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Impression - ${title}</title>
            <style>
                body { margin: 0; font-family: Arial, sans-serif; }
                .header { text-align: center; padding: 10px; background: #f5f5f5; border-bottom: 1px solid #ddd; }
                iframe { width: 100%; height: 95vh; border: none; }
            </style>
        </head>
        <body>
            <div class="header">${title}</div>
            <iframe src="${url}" onload="setTimeout(() => this.contentWindow.print(), 500);"></iframe>
        </body>
        </html>
    `);
    printWindow.document.close();
}

// Fermer le viewer
function closePreuveViewer() {
    document.getElementById('preuveViewerModal').classList.remove('active');
}

// Fermer avec Echap
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closePreuveViewer();
        closePrintModal();
    }
});

// Fermer en cliquant en dehors
document.getElementById('preuveViewerModal')?.addEventListener('click', (e) => {
    if (e.target === document.getElementById('preuveViewerModal')) {
        closePreuveViewer();
    }
});

// Fonction pour afficher le document imprimable (chapitre)
function showPrintDocument(chapData) {
    currentChapterData = chapData;
    
    const modal = document.getElementById('printModal');
    const container = document.getElementById('printDocument');
    
    const today = new Date().toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
    
    // Construction du HTML du document
    let livrablesHtml = '';
    if (chapData.livrables && chapData.livrables.length > 0) {
        livrablesHtml = `
            <div class="print-section">
                <div class="print-section-title">Livrables du chapitre</div>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th>Clause</th>
                            <th>Livrable</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        chapData.livrables.forEach(liv => {
            livrablesHtml += `
                <tr>
                    <td>${liv.clause || '—'}</td>
                    <td>${liv.libelle}</td>
                    <td>${liv.statut}</td>
                </tr>
            `;
        });
        
        livrablesHtml += `
                    </tbody>
                </table>
            </div>
        `;
    }
    
    const html = `
        <div class="print-document">
            <div class="print-header">
                <div>
                    <div class="print-title">LMC CONSEIL</div>
                    <div class="print-subtitle">Management & Certification - Suivi de projet</div>
                </div>
                <div class="print-date">${today}</div>
            </div>
            
            <div class="print-section">
                <div class="print-section-title">Informations du chapitre</div>
                <div class="print-info-grid">
                    <div class="print-info-row">
                        <span class="print-info-label">Code chapitre</span>
                        <span class="print-info-value">${chapData.code}</span>
                    </div>
                    <div class="print-info-row">
                        <span class="print-info-label">Titre</span>
                        <span class="print-info-value">${chapData.titre}</span>
                    </div>
                    <div class="print-info-row">
                        <span class="print-info-label">Projet</span>
                        <span class="print-info-value">${chapData.projet_nom}</span>
                    </div>
                    <div class="print-info-row">
                        <span class="print-info-label">Chef de projet</span>
                        <span class="print-info-value">${chapData.chef_nom || 'Non assigné'}</span>
                    </div>
                    <div class="print-info-row">
                        <span class="print-info-label">Phase</span>
                        <span class="print-info-value">${chapData.phase}</span>
                    </div>
                    <div class="print-info-row">
                        <span class="print-info-label">Avancement (basé sur livrables)</span>
                        <span class="print-info-value">${chapData.avancement}%</span>
                    </div>
                    <div class="print-info-row">
                        <span class="print-info-label">Jours intervention</span>
                        <span class="print-info-value">${chapData.jours}</span>
                    </div>
                    <div class="print-info-row">
                        <span class="print-info-label">Statut projet</span>
                        <span class="print-info-value">${chapData.projet_statut}</span>
                    </div>
                </div>
            </div>
            
            <div class="print-section">
                <div class="print-section-title">Exigences clés</div>
                <div style="background: #f8fafc; padding: 1rem; border-radius: 10px; font-size: 0.9rem; line-height: 1.6;">
                    ${chapData.exigences ? chapData.exigences.replace(/\n/g, '<br>') : 'Aucune exigence spécifiée'}
                </div>
            </div>
            
            ${livrablesHtml}
            
            <div class="print-section">
                <div class="print-section-title">Observations</div>
                <div style="background: #f8fafc; padding: 1rem; border-radius: 10px; font-size: 0.9rem;">
                    ${chapData.observations || 'Aucune observation'}
                </div>
            </div>
            
            <div class="print-footer">
                <div>Document généré automatiquement - LMC Conseil</div>
                <div style="margin-top: 0.5rem; font-size: 0.7rem;">Ce document est confidentiel</div>
            </div>
        </div>
    `;
    
    container.innerHTML = html;
    modal.classList.add('active');
}

// Fermer le modal
function closePrintModal() {
    document.getElementById('printModal').classList.remove('active');
}

// Imprimer le document (chapitre)
function printDocument() {
    const printContent = document.getElementById('printDocument').innerHTML;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>LMC Conseil - Suivi chapitre ${currentChapterData.code}</title>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: 'Inter', sans-serif;
                    padding: 2rem;
                    background: white;
                    color: #0f172a;
                    line-height: 1.5;
                }
                
                .print-document {
                    max-width: 800px;
                    margin: 0 auto;
                }
                
                .print-header {
                    border-bottom: 2px solid #2563eb;
                    margin-bottom: 2rem;
                    padding-bottom: 1rem;
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-end;
                }
                
                .print-title {
                    font-size: 1.5rem;
                    font-weight: 700;
                    color: #2563eb;
                }
                
                .print-subtitle {
                    font-size: 0.8rem;
                    color: #64748b;
                }
                
                .print-date {
                    font-size: 0.8rem;
                    color: #64748b;
                    background: #f1f5f9;
                    padding: 0.4rem 1rem;
                    border-radius: 100px;
                }
                
                .print-section {
                    margin-bottom: 2rem;
                }
                
                .print-section-title {
                    font-size: 1rem;
                    font-weight: 600;
                    color: #0f172a;
                    margin-bottom: 1rem;
                    padding-bottom: 0.5rem;
                    border-bottom: 1px solid #e2e8f0;
                }
                
                .print-info-grid {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 1rem;
                    background: #f8fafc;
                    padding: 1.25rem;
                    border-radius: 12px;
                }
                
                .print-info-row {
                    display: flex;
                    border-bottom: 1px dashed #e2e8f0;
                    padding: 0.6rem 0;
                }
                
                .print-info-label {
                    width: 130px;
                    font-weight: 600;
                    color: #64748b;
                    font-size: 0.8rem;
                }
                
                .print-info-value {
                    flex: 1;
                    color: #0f172a;
                    font-weight: 500;
                    font-size: 0.9rem;
                }
                
                .print-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 1rem;
                }
                
                .print-table th {
                    background: #f1f5f9;
                    color: #64748b;
                    font-size: 0.7rem;
                    font-weight: 600;
                    text-transform: uppercase;
                    padding: 0.6rem;
                    border: 1px solid #e2e8f0;
                }
                
                .print-table td {
                    padding: 0.6rem;
                    border: 1px solid #e2e8f0;
                    color: #334155;
                    font-size: 0.8rem;
                }
                
                .print-footer {
                    margin-top: 2rem;
                    padding-top: 1rem;
                    border-top: 2px solid #2563eb;
                    text-align: center;
                    color: #64748b;
                    font-size: 0.75rem;
                }
                
                @media print {
                    body {
                        padding: 0.25in;
                    }
                    
                    .print-section {
                        page-break-inside: avoid;
                    }
                }
            </style>
        </head>
        <body>
            ${printContent}
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.focus();
    
    setTimeout(() => {
        printWindow.print();
    }, 250);
}

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
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('lmc-theme', newTheme);
    
    const icon = document.getElementById('themeIcon');
    if (icon) {
        icon.className = newTheme === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
    }
});
</script>
</body>
</html>