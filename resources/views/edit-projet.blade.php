<!DOCTYPE html>
<html lang="fr" data-theme="light">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Projet - LMC Conseil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ===== DESIGN SYSTEM PREMIUM ===== */
        :root {
            --primary-50: #eef2ff;
            --primary-100: #e0e7ff;
            --primary-200: #c7d2fe;
            --primary-300: #a5b4fc;
            --primary-400: #818cf8;
            --primary-500: #6366f1;
            --primary-600: #4f46e5;
            --primary-700: #4338ca;
            --primary-800: #3730a3;
            --primary-900: #312e81;
            
            --success-50: #f0fdf4;
            --success-100: #dcfce7;
            --success-500: #22c55e;
            --success-600: #16a34a;
            --warning-50: #fffbeb;
            --warning-100: #fef3c7;
            --warning-500: #f59e0b;
            --warning-600: #d97706;
            --danger-50: #fef2f2;
            --danger-100: #fee2e2;
            --danger-500: #ef4444;
            --danger-600: #dc2626;
            --info-50: #eff6ff;
            --info-100: #dbeafe;
            --info-500: #3b82f6;
            --info-600: #2563eb;
            
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --shadow-xs: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            
            --radius-xs: 0.25rem;
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-3xl: 2rem;
            --radius-full: 9999px;
            
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-base: 200ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-bounce: 500ms cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        [data-theme="dark"] {
            --primary-50: #1e1b4b;
            --primary-100: #2e2a5e;
            --primary-200: #3d3a71;
            --primary-300: #4d4a84;
            --primary-400: #5c5a97;
            --primary-500: #818cf8;
            --primary-600: #a5b4fc;
            --primary-700: #c7d2fe;
            --primary-800: #e0e7ff;
            --primary-900: #eef2ff;
            
            --gray-50: #111827;
            --gray-100: #1f2937;
            --gray-200: #374151;
            --gray-300: #4b5563;
            --gray-400: #6b7280;
            --gray-500: #9ca3af;
            --gray-600: #d1d5db;
            --gray-700: #e5e7eb;
            --gray-800: #f3f4f6;
            --gray-900: #f9fafb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            transition: background-color var(--transition-base), color var(--transition-base);
            line-height: 1.5;
            font-size: 14px;
        }

        /* ===== HEADER PREMIUM ===== */
        .site-header {
            background: linear-gradient(135deg, var(--gray-900), var(--gray-800));
            padding: 1rem 0;
            border-bottom: 3px solid var(--primary-500);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--shadow-lg);
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
            transition: filter var(--transition-fast);
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
            border-radius: var(--radius-full);
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(8px);
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
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            backdrop-filter: blur(8px);
        }

        .theme-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            border: 1px solid rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-fast);
            backdrop-filter: blur(8px);
        }

        .theme-btn:hover {
            background: var(--primary-500);
            color: white;
            border-color: var(--primary-500);
            transform: rotate(15deg);
        }

        .nav-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .nav-wrap {
            display: flex;
            gap: 0.25rem;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.08);
            padding: 0.4rem;
            border-radius: var(--radius-full);
            margin-top: 0.75rem;
            width: fit-content;
            backdrop-filter: blur(8px);
        }

        .nav-item {
            padding: 0.45rem 1.25rem;
            border-radius: var(--radius-full);
            font-size: 0.8rem;
            font-weight: 500;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: all var(--transition-fast);
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
            color: var(--gray-900);
            font-weight: 600;
            box-shadow: var(--shadow-md);
        }

        /* ===== PAGE CONTENT ===== */
        .page {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* ===== FORM CARDS PREMIUM ===== */
        .form-card {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-2xl);
            padding: 2rem;
            box-shadow: var(--shadow-xl);
            margin-bottom: 2rem;
            transition: all var(--transition-base);
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
            background: linear-gradient(90deg, var(--primary-500), var(--primary-400));
            opacity: 0;
            transition: opacity var(--transition-base);
        }

        .form-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-2xl);
            border-color: var(--primary-300);
        }

        .form-card:hover::before {
            opacity: 1;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--primary-500);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.01em;
        }

        .section-title i {
            color: var(--primary-500);
            font-size: 1.2rem;
            background: linear-gradient(135deg, var(--primary-100), var(--primary-50));
            padding: 0.4rem;
            border-radius: var(--radius-md);
        }

        .section-hint {
            margin-left: auto;
            font-size: 0.7rem;
            font-weight: 400;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--gray-100);
            padding: 0.2rem 0.8rem;
            border-radius: var(--radius-full);
        }

        .auto-badge {
            display: inline-block;
            font-size: 0.6rem;
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            padding: 0.2rem 0.8rem;
            border-radius: var(--radius-full);
            margin-left: 0.5rem;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        /* ===== FORM ELEMENTS ===== */
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .form-control, .form-select {
            background: white !important;
            border: 2px solid var(--gray-200) !important;
            border-radius: var(--radius-lg) !important;
            padding: 0.7rem 1rem !important;
            font-size: 0.85rem !important;
            color: var(--gray-900) !important;
            font-family: 'Inter', sans-serif !important;
            transition: all var(--transition-fast) !important;
            box-shadow: var(--shadow-xs);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-500) !important;
            box-shadow: 0 0 0 4px var(--primary-100) !important;
            outline: none !important;
            transform: translateY(-1px);
        }

        .form-control::placeholder {
            color: var(--gray-400) !important;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .form-control.auto-calc {
            background: linear-gradient(135deg, var(--primary-50), var(--gray-50)) !important;
            border: 2px dashed var(--primary-400) !important;
            color: var(--primary-600) !important;
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
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .auto-tag {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.68rem;
            color: var(--gray-500);
            margin-top: 0.3rem;
            background: var(--gray-100);
            padding: 0.2rem 0.6rem;
            border-radius: var(--radius-full);
            width: fit-content;
        }

        /* ===== NORMES ===== */
        .normes-section {
            background: linear-gradient(135deg, var(--gray-100), var(--gray-50));
            border-radius: var(--radius-xl);
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
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            transition: all var(--transition-fast);
            cursor: pointer;
            box-shadow: var(--shadow-xs);
        }

        .norme-check:hover {
            border-color: var(--primary-500);
            background: linear-gradient(135deg, white, var(--primary-50));
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .norme-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-500);
            cursor: pointer;
        }

        .norme-check label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
        }

        /* ===== TABLE SMI PREMIUM ===== */
        .table-smi-container {
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-2xl);
            overflow: hidden;
            margin-top: 0.5rem;
            box-shadow: var(--shadow-lg);
            background: white;
        }

        .table-smi {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .table-smi thead th {
            background: linear-gradient(135deg, var(--gray-800), var(--gray-900));
            color: white;
            padding: 1rem 1rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 2px solid var(--gray-700);
            white-space: nowrap;
        }

        .table-smi tbody td {
            padding: 1rem 1rem;
            border-bottom: 1px solid var(--gray-200);
            color: var(--gray-700);
            vertical-align: middle;
        }

        .table-smi tbody tr:last-child td {
            border-bottom: none;
        }

        .table-smi tbody tr:hover td {
            background: linear-gradient(135deg, var(--gray-50), white);
        }

        .col-exigences {
            min-width: 350px;
            width: 28%;
        }

        .col-exigences textarea {
            width: 100%;
            min-height: 85px;
            font-size: 0.82rem;
            line-height: 1.5;
            background: var(--gray-50);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: 0.6rem;
            color: var(--gray-900);
            transition: all var(--transition-fast);
        }

        .col-exigences textarea:focus {
            border-color: var(--primary-500);
            box-shadow: 0 0 0 4px var(--primary-100);
            outline: none;
            background: white;
        }

        .chapitre-code {
            font-weight: 700;
            color: var(--primary-600);
            font-size: 0.9rem;
            background: linear-gradient(135deg, var(--primary-100), var(--primary-50));
            padding: 0.3rem 0.6rem;
            border-radius: var(--radius-full);
            display: inline-block;
        }

        .chapitre-titre {
            display: block;
            font-size: 0.7rem;
            color: var(--gray-500);
            margin-top: 0.3rem;
        }

        .input-num {
            width: 70px;
            text-align: center;
            font-weight: 600;
            border-radius: var(--radius-md) !important;
        }

        .input-num.avancement {
            border-color: var(--primary-500) !important;
            background: linear-gradient(135deg, var(--primary-50), white) !important;
        }

        .input-num.jours {
            border-color: var(--primary-500) !important;
            background: linear-gradient(135deg, var(--primary-50), white) !important;
        }

        .phase-select {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
            border-radius: var(--radius-md);
            border: 2px solid var(--gray-200);
            background: white;
            color: var(--gray-900);
            width: 140px;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .phase-select:hover {
            border-color: var(--primary-500);
            box-shadow: var(--shadow-sm);
        }

        .livrables-toggle {
            background: linear-gradient(135deg, var(--gray-100), var(--gray-50));
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
            padding: 0.25rem 0.9rem;
            font-size: 0.7rem;
            border-radius: var(--radius-full);
            font-weight: 600;
            transition: all var(--transition-fast);
            white-space: nowrap;
            box-shadow: var(--shadow-xs);
        }

        .livrables-toggle:hover {
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            border-color: var(--primary-600);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .livrables-count {
            font-size: 0.65rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
            white-space: nowrap;
            font-weight: 500;
        }

        /* ===== LIVRABLES INLINE TABLE ===== */
        .livrables-inline-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
            background: white;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .livrables-inline-table thead th {
            background: linear-gradient(135deg, var(--gray-100), var(--gray-50));
            color: var(--gray-600);
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.6rem;
            border: 1px solid var(--gray-200);
        }

        .livrables-inline-table td {
            padding: 0.6rem;
            border: 1px solid var(--gray-200);
            color: var(--gray-700);
            vertical-align: middle;
        }

        .liv-statut-select {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.8rem;
            border-radius: var(--radius-full);
            border: 2px solid transparent;
            background: var(--gray-100);
            color: var(--gray-700);
            cursor: pointer;
            outline: none;
            transition: all var(--transition-fast);
            width: 130px;
        }

        .liv-statut-select.s-nc {
            background: var(--gray-100);
            color: var(--gray-500);
            border-color: var(--gray-300);
        }

        .liv-statut-select.s-ec {
            background: var(--warning-100);
            color: var(--warning-600);
            border-color: var(--warning-400);
        }

        .liv-statut-select.s-ok {
            background: var(--success-100);
            color: var(--success-600);
            border-color: var(--success-400);
        }

        /* ===== PREUVES COLUMN ===== */
        .preuve-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
        }

        .preuve-btn-group {
            display: flex;
            gap: 0.35rem;
            align-items: center;
        }

        .btn-preuve-voir {
            width: 30px;
            height: 30px;
            border-radius: var(--radius-md);
            border: 2px solid var(--primary-300);
            background: linear-gradient(135deg, var(--primary-100), var(--primary-50));
            color: var(--primary-600);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-bounce);
            font-size: 0.85rem;
            position: relative;
            box-shadow: var(--shadow-sm);
        }

        .btn-preuve-voir:hover {
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            border-color: var(--primary-600);
            transform: scale(1.1) rotate(5deg);
            box-shadow: var(--shadow-lg);
        }

        .btn-preuve-add {
            width: 30px;
            height: 30px;
            border-radius: var(--radius-md);
            border: 2px solid var(--success-400);
            background: linear-gradient(135deg, var(--success-100), var(--success-50));
            color: var(--success-600);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-bounce);
            font-size: 0.85rem;
            box-shadow: var(--shadow-sm);
        }

        .btn-preuve-add:hover {
            background: linear-gradient(135deg, var(--success-500), var(--success-600));
            color: white;
            border-color: var(--success-600);
            transform: scale(1.1) rotate(-5deg);
            box-shadow: var(--shadow-lg);
        }

        .preuve-count-badge {
            font-size: 0.6rem;
            font-weight: 700;
            padding: 0.1rem 0.5rem;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            min-width: 18px;
            text-align: center;
            line-height: 1.4;
            box-shadow: var(--shadow-sm);
        }

        .preuve-count-badge.zero {
            background: var(--gray-200);
            color: var(--gray-500);
        }

        /* ===== PREUVE VIEWER PANEL ===== */
        .preuve-viewer-panel {
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .preuve-viewer-header {
            background: linear-gradient(135deg, var(--gray-100), var(--gray-50));
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--gray-200);
        }

        .preuve-viewer-header span {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-700);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .preuve-list {
            padding: 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            max-height: 300px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--gray-300) var(--gray-100);
        }

        .preuve-list::-webkit-scrollbar {
            width: 6px;
        }

        .preuve-list::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: var(--radius-full);
        }

        .preuve-list::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: var(--radius-full);
        }

        .preuve-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.75rem;
            background: linear-gradient(135deg, var(--gray-50), white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            transition: all var(--transition-fast);
        }

        .preuve-item:hover {
            border-color: var(--primary-400);
            box-shadow: var(--shadow-md);
            transform: translateX(2px);
        }

        .preuve-thumb {
            width: 45px;
            height: 45px;
            border-radius: var(--radius-md);
            object-fit: cover;
            border: 2px solid var(--gray-200);
            flex-shrink: 0;
        }

        .preuve-thumb-icon {
            width: 45px;
            height: 45px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--primary-100), var(--primary-50));
            border: 2px solid var(--primary-400);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
        }

        .preuve-info {
            flex: 1;
            min-width: 0;
        }

        .preuve-name {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-900);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preuve-meta {
            font-size: 0.65rem;
            color: var(--gray-500);
            margin-top: 0.1rem;
        }

        .preuve-item-actions {
            display: flex;
            gap: 0.35rem;
            flex-shrink: 0;
        }

        .btn-preuve-print {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-md);
            border: 2px solid var(--info-400);
            background: linear-gradient(135deg, var(--info-100), var(--info-50));
            color: var(--info-600);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-fast);
            font-size: 0.75rem;
        }

        .btn-preuve-print:hover {
            background: linear-gradient(135deg, var(--info-500), var(--info-600));
            color: white;
            border-color: var(--info-600);
        }

        .btn-preuve-delete {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-md);
            border: 2px solid var(--danger-400);
            background: linear-gradient(135deg, var(--danger-100), var(--danger-50));
            color: var(--danger-600);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-fast);
            font-size: 0.75rem;
        }

        .btn-preuve-delete:hover {
            background: linear-gradient(135deg, var(--danger-500), var(--danger-600));
            color: white;
            border-color: var(--danger-600);
        }

        .preuve-empty {
            text-align: center;
            padding: 1.5rem;
            color: var(--gray-500);
            font-size: 0.8rem;
        }

        .preuve-empty i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: var(--gray-300);
        }

        /* ===== PREUVE UPLOAD PANEL ===== */
        .preuve-upload-panel {
            background: linear-gradient(135deg, var(--success-50), white);
            border: 2px solid var(--success-200);
            border-radius: var(--radius-xl);
            padding: 1.25rem;
            margin-top: 0.5rem;
            box-shadow: var(--shadow-md);
        }

        .preuve-upload-panel h6 {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--success-600);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .preuve-drop-zone {
            border: 2px dashed var(--success-300);
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            text-align: center;
            cursor: pointer;
            transition: all var(--transition-fast);
            background: white;
            margin-bottom: 0.5rem;
        }

        .preuve-drop-zone:hover, .preuve-drop-zone.dragover {
            border-color: var(--success-500);
            background: linear-gradient(135deg, var(--success-50), white);
            transform: scale(1.01);
            box-shadow: var(--shadow-md);
        }

        .preuve-drop-zone i {
            font-size: 2rem;
            color: var(--success-500);
        }

        .preuve-drop-zone p {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin: 0.25rem 0 0;
        }

        .preuve-file-input {
            display: none;
        }

        .preuve-label-input {
            font-size: 0.8rem !important;
            padding: 0.6rem 1rem !important;
            border-radius: var(--radius-lg) !important;
            border: 2px solid var(--success-200) !important;
        }

        .upload-preview-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }

        .upload-preview-item {
            position: relative;
            width: 70px;
            height: 70px;
            border-radius: var(--radius-md);
            overflow: hidden;
            border: 2px solid var(--success-500);
            box-shadow: var(--shadow-sm);
        }

        .upload-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-preview-item .file-icon-preview {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--success-100), var(--success-50));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--success-600);
        }

        .upload-preview-item .remove-preview {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--danger-500);
            color: white;
            border: none;
            font-size: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .upload-preview-item .remove-preview:hover {
            background: var(--danger-600);
            transform: scale(1.1);
        }

        .btn-upload-confirm {
            background: linear-gradient(135deg, var(--success-500), var(--success-600));
            color: white;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.5rem 1.25rem;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-md);
        }

        .btn-upload-confirm:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-upload-cancel {
            background: white;
            color: var(--gray-600);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-full);
            padding: 0.5rem 1.25rem;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .btn-upload-cancel:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
        }

        /* ===== FULLSCREEN VIEWER ===== */
        .preuve-fullscreen-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.9);
            backdrop-filter: blur(12px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .preuve-fullscreen-overlay.active {
            display: flex;
            animation: fadeIn var(--transition-base);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .preuve-fullscreen-box {
            background: white;
            border-radius: var(--radius-2xl);
            max-width: 95vw;
            max-height: 95vh;
            width: 900px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-2xl);
            animation: scaleIn var(--transition-bounce);
        }

        @keyframes scaleIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .preuve-fullscreen-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background: linear-gradient(135deg, var(--gray-100), var(--gray-50));
        }

        .preuve-fullscreen-header h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
        }

        .preuve-fullscreen-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-fs-print {
            background: linear-gradient(135deg, var(--info-500), var(--info-600));
            color: white;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.5rem 1.25rem;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            cursor: pointer;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-sm);
        }

        .btn-fs-print:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-fs-delete {
            background: linear-gradient(135deg, var(--danger-500), var(--danger-600));
            color: white;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.5rem 1.25rem;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            cursor: pointer;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-sm);
        }

        .btn-fs-delete:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-fs-close {
            background: white;
            color: var(--gray-600);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-full);
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .btn-fs-close:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
        }

        .preuve-fullscreen-body {
            flex: 1;
            overflow: auto;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gray-50);
            min-height: 400px;
        }

        .preuve-fullscreen-body img {
            max-width: 100%;
            max-height: 70vh;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
        }

        .preuve-fullscreen-body .pdf-embed {
            width: 100%;
            height: 70vh;
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
        }

        .preuve-fullscreen-body .file-preview-generic {
            text-align: center;
            padding: 2rem;
        }

        .preuve-fullscreen-body .file-preview-generic i {
            font-size: 5rem;
            color: var(--primary-500);
            margin-bottom: 1rem;
        }

        .btn-dl {
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.75rem 2rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-fast);
        }

        .btn-dl:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* ===== CONSULTANTS ===== */
        .consultant-row {
            background: linear-gradient(135deg, var(--gray-50), white);
            border: 1px solid var(--gray-200);
            border-left: 4px solid var(--primary-500);
            border-radius: var(--radius-xl);
            padding: 1rem;
            margin-bottom: 0.75rem;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-sm);
        }

        .consultant-row:hover {
            box-shadow: var(--shadow-lg);
            transform: translateX(4px);
            border-color: var(--primary-300);
        }

        .add-section {
            background: linear-gradient(135deg, var(--gray-100), var(--gray-50));
            border: 2px dashed var(--gray-300);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            margin-top: 1.5rem;
            transition: all var(--transition-fast);
        }

        .add-section:hover {
            border-color: var(--primary-500);
            background: linear-gradient(135deg, var(--primary-50), var(--gray-50));
        }

        .add-section h6 {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.7rem 2rem;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-base);
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--gray-700);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-full);
            padding: 0.7rem 2rem;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-fast);
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--gray-100);
            border-color: var(--primary-400);
            color: var(--primary-600);
            transform: translateY(-1px);
        }

        .btn-add {
            background: linear-gradient(135deg, var(--success-500), var(--success-600));
            color: white;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-sm);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-remove {
            background: transparent;
            color: var(--danger-500);
            border: 2px solid var(--danger-400);
            border-radius: 50%;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-fast);
            cursor: pointer;
        }

        .btn-remove:hover {
            background: var(--danger-500);
            color: white;
            border-color: var(--danger-600);
            transform: rotate(90deg);
        }

        /* ===== TABLE FOOTER ===== */
        .table-footer {
            background: linear-gradient(135deg, var(--gray-100), var(--gray-50));
            padding: 0.75rem 1.5rem;
            border-top: 2px solid var(--primary-500);
            display: flex;
            justify-content: flex-end;
            gap: 2rem;
            font-weight: 600;
        }

        .footer-value {
            color: var(--primary-600);
            font-size: 1.2rem;
            font-weight: 700;
            background: white;
            padding: 0.2rem 0.8rem;
            border-radius: var(--radius-full);
            margin-left: 0.5rem;
            box-shadow: var(--shadow-sm);
        }

        /* ===== ALERTS ===== */
        .alert-float {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
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

        .alert-success {
            background: linear-gradient(135deg, var(--success-500), var(--success-600));
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, var(--danger-500), var(--danger-600));
            color: white;
        }

        /* ===== TOOLTIP ===== */
        [data-tooltip] {
            position: relative;
        }

        [data-tooltip]::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%);
            background: var(--gray-900);
            color: white;
            font-size: 0.65rem;
            font-weight: 500;
            padding: 0.25rem 0.6rem;
            border-radius: var(--radius-md);
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity var(--transition-fast);
            z-index: 100;
            box-shadow: var(--shadow-md);
        }

        [data-tooltip]:hover::after {
            opacity: 1;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .col-exigences {
                min-width: 280px;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .nav-wrap {
                flex-wrap: wrap;
                width: 100%;
                justify-content: center;
            }
            
            .table-smi {
                font-size: 0.75rem;
            }
            
            .preuve-fullscreen-box {
                width: 95%;
            }
        }

        /* ===== PREUVES PROJET SECTION ===== */
        .preuves-projet-section {
            margin-top: 2rem;
        }

        .preuves-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .preuves-header h5 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .preuves-header h5 i {
            color: var(--primary-500);
        }

        .preuves-count {
            background: var(--primary-50);
            color: var(--primary-600);
            padding: 0.25rem 1rem;
            border-radius: var(--radius-full);
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Upload button */
        .btn-upload-projet {
            background: linear-gradient(135deg, var(--success-500), var(--success-600));
            color: white;
            border: none;
            border-radius: var(--radius-full);
            padding: 0.6rem 1.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }

        .btn-upload-projet:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-upload-projet i {
            font-size: 1rem;
        }

        /* Upload panel */
        .upload-panel {
            background: linear-gradient(135deg, var(--success-50), white);
            border: 2px solid var(--success-200);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: none;
            box-shadow: var(--shadow-md);
        }

        .upload-panel.active {
            display: block;
        }

        .upload-panel h6 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--success-600);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .projet-upload-zone {
            border: 2px dashed var(--success-300);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all var(--transition-fast);
            background: white;
            margin-bottom: 1rem;
        }

        .projet-upload-zone:hover, .projet-upload-zone.dragover {
            border-color: var(--success-500);
            background: linear-gradient(135deg, var(--success-50), white);
            transform: scale(1.01);
            box-shadow: var(--shadow-md);
        }

        .projet-upload-zone i {
            font-size: 2.5rem;
            color: var(--success-500);
            margin-bottom: 0.5rem;
        }

        .projet-upload-zone h6 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-900);
            margin: 0.25rem 0;
        }

        .projet-upload-zone p {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        /* Preuves grid */
        .preuves-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-top: 1rem;
        }

        .preuve-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-sm);
        }

        .preuve-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-300);
        }

        .preuve-thumb-large {
            height: 160px;
            background: linear-gradient(135deg, var(--gray-100), var(--gray-50));
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid var(--gray-200);
        }

        .preuve-thumb-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preuve-thumb-large i {
            font-size: 4rem;
            color: var(--primary-400);
        }

        .preuve-body {
            padding: 1rem;
        }

        .preuve-body h6 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preuve-meta {
            font-size: 0.7rem;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .preuve-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            border-top: 1px solid var(--gray-200);
            padding-top: 0.75rem;
        }

        .preuve-action-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-md);
            border: 1px solid var(--gray-200);
            background: var(--gray-50);
            color: var(--gray-600);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .preuve-action-btn:hover {
            background: var(--primary-500);
            color: white;
            border-color: var(--primary-500);
        }

        .preuve-action-btn.delete:hover {
            background: var(--danger-500);
            border-color: var(--danger-500);
        }

        .preuve-action-btn.print:hover {
            background: var(--info-500);
            border-color: var(--info-500);
        }

        .empty-preuves {
            text-align: center;
            padding: 3rem;
            color: var(--gray-500);
            border: 2px dashed var(--gray-300);
            border-radius: var(--radius-xl);
            background: var(--gray-50);
        }

        .empty-preuves i {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: 0.5rem;
        }

        .empty-preuves p {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .empty-preuves small {
            font-size: 0.75rem;
            color: var(--gray-400);
        }
    </style>
</head>

<body>

    @php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;

    $id = $projet->id;

    // Récupérer les livrables avec leurs statuts
    $livrableRows = DB::select("
        SELECT ls.id, ls.chapitre_code, ls.clause, ls.libelle, ls.ordre,
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
        $pr->url = $pr->fichier_path;
        $preuvesParLivrable[$pr->livrable_id][] = $pr;
    }

    // Récupérer les preuves projet (fichiers d'intervention généraux)
    $preuvesProjet = DB::table('projet_preuves')
        ->where('projet_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();
    foreach ($preuvesProjet as $pr) {
        $pr->url = $pr->fichier_path;
    }

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

    // Calculer l'avancement par chapitre
    $avancementParChapitre = [];
    foreach ($livrablesByChap as $chapCode => $chapData) {
        $avancementParChapitre[$chapCode] = $chapData['total'] > 0
            ? round(($chapData['termines'] / $chapData['total']) * 100) : 0;
    }

    $avancementGlobal = $totalLivrablesGlobal > 0
        ? round(($terminesLivrablesGlobal / $totalLivrablesGlobal) * 100) : 0;

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

    $consultants = DB::table('consultants')->where('actif', 1)->get();
    $normes = DB::table('normes')->get();
    $user = auth()->user();
    @endphp

    <!-- ===== FULLSCREEN PREUVE VIEWER ===== -->
    <div class="preuve-fullscreen-overlay" id="preuveFullscreenOverlay">
        <div class="preuve-fullscreen-box">
            <div class="preuve-fullscreen-header">
                <h5 id="fsPreuveTitle">Preuve</h5>
                <div class="preuve-fullscreen-actions">
                    <button type="button" class="btn-fs-print" onclick="printCurrentPreuve()">
                        <i class="bi bi-printer-fill"></i> Imprimer
                    </button>
                    <button type="button" class="btn-fs-delete" onclick="deleteCurrentPreuve()">
                        <i class="bi bi-trash-fill"></i> Supprimer
                    </button>
                    <button type="button" class="btn-fs-close" onclick="closeFullscreen()">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
            <div class="preuve-fullscreen-body" id="fsPreuveBody">
                <!-- Content injected by JS -->
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="site-header">
        <div class="header-container">
            <div class="logo-wrapper">
                <img src="https://lmc.ma/wp-content/uploads/2021/02/LMC-Logo.png"
                     alt="LMC Conseil" class="logo-image"
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
                <a href="/" class="nav-item"><i class="bi bi-table"></i> Données</a>
                <a href="/tableau-de-bord" class="nav-item"><i class="bi bi-bar-chart"></i> Tableau de Bord</a>
                <a href="/consultants" class="nav-item"><i class="bi bi-people"></i> Consultants</a>
                <a href="/nouveau-projet" class="nav-item"><i class="bi bi-plus-circle"></i> Nouveau Projet</a>
                @if($user && $user->isSuperAdmin())
                <a href="/admin/users" class="nav-item"><i class="bi bi-shield-lock"></i> Accès</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="page">
        <form action="{{ route('projets.update', $projet->id) }}" method="POST" id="mainForm">
            @csrf
            @method('PUT')

            <!-- Section A -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-info-circle-fill"></i>
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

            <!-- Section B -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-check-square-fill"></i>
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

            <!-- Section C -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-calendar-check-fill"></i>
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

            <!-- Section D -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-graph-up-arrow"></i>
                    D - Indicateurs de suivi
                    <span class="section-hint">
                        <i class="bi bi-calculator-fill"></i> Calcul automatique
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
                            <i class="bi bi-arrow-right-circle-fill"></i> Somme des jours d'intervention
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
                            <i class="bi bi-arrow-right-circle-fill"></i>
                            {{ $terminesLivrablesGlobal }}/{{ $totalLivrablesGlobal }} livrables terminés
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section E - SMI avec livrables + preuves -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-journal-check-fill"></i>
                    E - Suivi des chapitres SMI
                    <span class="auto-badge">Avancement automatique</span>
                </div>

                <div class="table-smi-container">
                    <table class="table-smi">
                        <thead>
                            <tr>
                                <th style="width:9%;">Chapitre</th>
                                <th style="width:12%;">Livrables</th>
                                <th class="col-exigences">Exigences clés</th>
                                <th style="width:6%;">Av. %</th>
                                <th style="width:10%;">Phase</th>
                                <th style="width:6%;">J. Interv.</th>
                                <th style="width:10%;">Observations</th>
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
                                    <button class="livrables-toggle" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}">
                                        <i class="bi bi-list-ul me-1"></i>Voir
                                    </button>
                                    <div class="livrables-count">{{ $livDone }}/{{ $livTotal }} ({{ $livPct }}%)</div>
                                    @else
                                    <span style="color: var(--gray-500);">—</span>
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
                                        min="0" max="100" value="{{ $avancementCalcule }}" readonly>
                                    <small style="font-size:0.6rem;color:var(--gray-500);display:block;text-align:center;">auto</small>
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
                                <td colspan="7" style="background:linear-gradient(135deg, var(--gray-50), white); padding:1.25rem;">
                                    <table class="livrables-inline-table">
                                        <thead>
                                            <tr>
                                                <th style="width:90px;">Clause</th>
                                                <th>Libellé</th>
                                                <th style="width:140px;">Statut</th>
                                                <!-- ===== NOUVELLE COLONNE PREUVES ===== -->
                                                <th style="width:120px; text-align:center;">
                                                    <i class="bi bi-paperclip"></i> Preuves
                                                </th>
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
                                                $livPreuves = $preuvesParLivrable[$liv->id] ?? [];
                                                $preuveCount = count($livPreuves);
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

                                                <!-- ===== CELLULE PREUVES ===== -->
                                                <td style="text-align:center; vertical-align:middle;">
                                                    <div class="preuve-actions">
                                                        <div class="preuve-btn-group">
                                                            <!-- Voir Preuves (eye) -->
                                                            <button type="button"
                                                                class="btn-preuve-voir"
                                                                data-tooltip="Voir les preuves"
                                                                onclick="toggleViewer({{ $liv->id }})">
                                                                <i class="bi bi-eye-fill"></i>
                                                            </button>

                                                            <!-- Ajouter Preuve -->
                                                            <button type="button"
                                                                class="btn-preuve-add"
                                                                data-tooltip="Ajouter une preuve"
                                                                onclick="toggleUploader({{ $liv->id }})">
                                                                <i class="bi bi-paperclip"></i>
                                                            </button>
                                                        </div>
                                                        <!-- Count badge -->
                                                        <span class="preuve-count-badge {{ $preuveCount == 0 ? 'zero' : '' }}"
                                                              id="preuve-count-{{ $liv->id }}">
                                                            {{ $preuveCount }}
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- ===== VIEWER ROW ===== -->
                                            <tr id="viewer-row-{{ $liv->id }}" style="display:none;">
                                                <td colspan="4" style="padding:0.75rem 1rem; background:white;">
                                                    <div class="preuve-viewer-panel">
                                                        <div class="preuve-viewer-header">
                                                            <span>
                                                                <i class="bi bi-eye-fill me-1" style="color:var(--primary-500);"></i>
                                                                Preuves — {{ Str::limit($liv->libelle, 50) }}
                                                            </span>
                                                            <small style="color:var(--gray-500); font-size:0.65rem;">
                                                                {{ $preuveCount }} preuve(s)
                                                            </small>
                                                        </div>
                                                        <div class="preuve-list" id="preuve-list-{{ $liv->id }}">
                                                            @if($preuveCount === 0)
                                                            <div class="preuve-empty" id="preuve-empty-{{ $liv->id }}">
                                                                <i class="bi bi-inbox"></i>
                                                                Aucune preuve attachée
                                                            </div>
                                                            @else
                                                            @foreach($livPreuves as $pr)
                                                            @php
                                                                $isImage = Str::startsWith($pr->mime_type, 'image/');
                                                                $isPdf = $pr->mime_type === 'application/pdf';
                                                                $fileIcon = $isPdf ? 'bi-file-earmark-pdf-fill' : 
                                                                    (Str::contains($pr->mime_type, 'word') ? 'bi-file-earmark-word-fill' :
                                                                    (Str::contains($pr->mime_type, 'excel') || Str::contains($pr->mime_type, 'spreadsheet') ? 'bi-file-earmark-excel-fill' :
                                                                    'bi-file-earmark-fill'));
                                                                $iconColor = $isPdf ? '#ef4444' : 
                                                                    (Str::contains($pr->mime_type, 'word') ? '#2563eb' : 
                                                                    (Str::contains($pr->mime_type, 'excel') ? '#10b981' : '#6b7280'));
                                                            @endphp
                                                            <div class="preuve-item" id="preuve-item-{{ $pr->id }}">
                                                                @if($isImage)
                                                                <img src="{{ $pr->url }}" alt="{{ $pr->label }}" class="preuve-thumb">
                                                                @else
                                                                <div class="preuve-thumb-icon">
                                                                    <i class="bi {{ $fileIcon }}" style="color: {{ $iconColor }}"></i>
                                                                </div>
                                                                @endif
                                                                <div class="preuve-info">
                                                                    <div class="preuve-name">{{ $pr->label ?: $pr->fichier_nom }}</div>
                                                                    <div class="preuve-meta">
                                                                        {{ strtoupper(pathinfo($pr->fichier_nom, PATHINFO_EXTENSION)) }} •
                                                                        {{ number_format($pr->taille_kb, 0) }} Ko •
                                                                        {{ \Carbon\Carbon::parse($pr->created_at)->format('d/m/Y H:i') }}
                                                                    </div>
                                                                </div>
                                                                <div class="preuve-item-actions">
                                                                    <button type="button" class="btn-preuve-print"
                                                                        data-tooltip="Imprimer / Afficher"
                                                                        onclick="openFullscreen({{ $pr->id }}, '{{ addslashes($pr->label ?: $pr->fichier_nom) }}', '{{ $pr->mime_type }}', '{{ $pr->url }}')">
                                                                        <i class="bi bi-printer-fill"></i>
                                                                    </button>
                                                                    <button type="button" class="btn-preuve-delete"
                                                                        data-tooltip="Supprimer"
                                                                        onclick="deletePreuve({{ $pr->id }}, {{ $liv->id }})">
                                                                        <i class="bi bi-trash-fill"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- ===== UPLOAD ROW ===== -->
                                            <tr id="upload-row-{{ $liv->id }}" style="display:none;">
                                                <td colspan="4" style="padding:0.75rem 1rem; background:white;">
                                                    <div class="preuve-upload-panel">
                                                        <h6>
                                                            <i class="bi bi-cloud-upload-fill"></i>
                                                            Ajouter une preuve
                                                            <small style="font-size:0.7rem; color:var(--gray-500); margin-left:0.5rem;">
                                                                {{ Str::limit($liv->libelle, 40) }}
                                                            </small>
                                                        </h6>

                                                        <!-- Label -->
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control preuve-label-input"
                                                                id="label-{{ $liv->id }}"
                                                                placeholder="Libellé / description (optionnel)">
                                                        </div>

                                                        <!-- Drop zone -->
                                                        <div class="preuve-drop-zone"
                                                             id="dropzone-{{ $liv->id }}"
                                                             onclick="document.getElementById('file-input-{{ $liv->id }}').click()"
                                                             ondragover="handleDragOver(event, {{ $liv->id }})"
                                                             ondragleave="handleDragLeave({{ $liv->id }})"
                                                             ondrop="handleDrop(event, {{ $liv->id }})">
                                                            <i class="bi bi-cloud-arrow-up-fill"></i>
                                                            <strong style="display:block; font-size:0.8rem; color:var(--gray-900); margin-top:0.3rem;">
                                                                Cliquer ou glisser un fichier ici
                                                            </strong>
                                                            <p>PDF, Image, Word, Excel — max 10 MB</p>
                                                        </div>
                                                        <input type="file" class="preuve-file-input"
                                                            id="file-input-{{ $liv->id }}"
                                                            accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.doc,.docx,.xls,.xlsx"
                                                            onchange="handleFileSelect(event, {{ $liv->id }})">

                                                        <!-- Preview selected file -->
                                                        <div id="file-preview-{{ $liv->id }}" class="upload-preview-grid"></div>

                                                        <!-- Actions -->
                                                        <div style="display:flex; gap:0.5rem; margin-top:0.75rem; align-items:center;">
                                                            <button type="button" class="btn-upload-confirm"
                                                                onclick="uploadPreuve({{ $liv->id }}, {{ $projet->id }})">
                                                                <i class="bi bi-check-circle-fill"></i>
                                                                Enregistrer
                                                            </button>
                                                            <button type="button" class="btn-upload-cancel"
                                                                onclick="cancelUpload({{ $liv->id }})">
                                                                Annuler
                                                            </button>
                                                            <span id="upload-status-{{ $liv->id }}"
                                                                style="font-size:0.75rem; color:var(--gray-500); margin-left:0.5rem;"></span>
                                                        </div>
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
                    <i class="bi bi-people-fill"></i>
                    F - Équipe projet
                </div>
                <div id="existingConsultantsContainer">
                    @forelse($projet->affectations as $aff)
                    @php $charge = $aff->jours_alloues > 0 ? round(($aff->jours_realises / $aff->jours_alloues) * 100) : 0; @endphp
                    <div class="consultant-row" id="consultant-row-{{ $aff->consultant_id }}">
                        <div class="row align-items-center g-3">
                            <div class="col-md-3">
                                <div style="font-weight:600;">
                                    <i class="bi bi-person-circle me-1" style="color:var(--primary-500);"></i>
                                    {{ $aff->consultant->nom_complet }}
                                </div>
                                <input type="hidden" name="consultants[{{ $aff->consultant_id }}][id]" value="{{ $aff->consultant_id }}">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="consultants[{{ $aff->consultant_id }}][role]">
                                    @foreach(['Chef de Projet','Consultant','Consultant Ext.','Expert'] as $r)
                                    <option value="{{ $r }}" {{ $aff->role_dans_projet == $r ? 'selected' : '' }}>{{ $r }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control"
                                    name="consultants[{{ $aff->consultant_id }}][jours_alloues]"
                                    min="0" step="0.1" value="{{ $aff->jours_alloues }}" placeholder="J. alloués">
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control"
                                    name="consultants[{{ $aff->consultant_id }}][jours_realises]"
                                    min="0" step="0.1" value="{{ $aff->jours_realises }}" placeholder="J. réalisés">
                            </div>
                            <div class="col-md-1">
                                <span class="badge" style="background:linear-gradient(135deg, var(--primary-500), var(--primary-600)); color:white; padding:0.3rem 0.6rem; border-radius:var(--radius-full);">
                                    {{ $charge }}%
                                </span>
                            </div>
                            <div class="col-md-1 text-center">
                                <button type="button" class="btn-remove"
                                    onclick="removeConsultant(this, {{ $aff->consultant_id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p style="color:var(--gray-500); text-align:center; padding:1rem;">Aucun consultant affecté</p>
                    @endforelse
                </div>
                <div id="newConsultantsContainer"></div>
                <div id="deletedConsultantsContainer"></div>
                <div class="add-section">
                    <h6>
                        <i class="bi bi-plus-circle-fill" style="color:var(--success-500);"></i>
                        Ajouter un consultant
                    </h6>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Consultant</label>
                            <select class="form-select" id="existingConsultantSelect">
                                <option value="">-- Sélectionner --</option>
                                @foreach($consultants as $cons)
                                <option value="{{ $cons->id }}" data-nom="{{ $cons->nom_complet }}">{{ $cons->nom_complet }}</option>
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
                            <input type="number" class="form-control" id="existingConsultantJoursAlloues" min="0" step="0.1" value="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">J. réalisés</label>
                            <input type="number" class="form-control" id="existingConsultantJoursRealises" min="0" step="0.1" value="0">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-add w-100" onclick="addExistingConsultant()">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section G -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-mortarboard-fill"></i>
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
                                        <option value="{{ $st }}" {{ $form->pivot->statut == $st ? 'selected' : '' }}>{{ $st }}</option>
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

            <!-- Section H -->
            <div class="form-card">
                <div class="section-title">
                    <i class="bi bi-exclamation-triangle-fill"></i>
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

            
        </form>

        <!-- ===== SECTION I - FICHIERS D'INTERVENTION (HORS FORMULAIRE) ===== -->
        <div class="form-card preuves-projet-section">
            <div class="section-title">
                <i class="bi bi-folder-fill"></i>
                I - Fichiers d'intervention du projet
            </div>

            <div class="preuves-header">
                <h5>
                    <i class="bi bi-file-earmark"></i>
                    Documents et preuves du projet
                </h5>
                <span class="preuves-count">{{ count($preuvesProjet) }} document(s)</span>
            </div>

            <!-- Bouton d'ajout -->
            <button type="button" class="btn-upload-projet" onclick="toggleProjetUploadPanel()">
                <i class="bi bi-cloud-upload-fill"></i>
                Ajouter un document
            </button>

            <!-- Panel d'upload -->
            <div class="upload-panel" id="projetUploadPanel">
                <h6><i class="bi bi-cloud-upload-fill"></i> Nouveau document d'intervention</h6>
                
                <div class="mb-3">
                    <label class="form-label">Libellé / description</label>
                    <input type="text" class="form-control" id="projetLabel" placeholder="Ex: Rapport d'intervention, Compte-rendu, Photos chantier...">
                </div>

                <div class="projet-upload-zone"
                     id="projetDropzone"
                     onclick="document.getElementById('projetFileInput').click()"
                     ondragover="handleProjetDragOver(event)"
                     ondragleave="handleProjetDragLeave()"
                     ondrop="handleProjetDrop(event)">
                    <i class="bi bi-cloud-arrow-up-fill"></i>
                    <h6>Cliquez ou glissez un fichier ici</h6>
                    <p>PDF, Images, Word, Excel — max 10 MB</p>
                </div>

                <input type="file" class="preuve-file-input" id="projetFileInput"
                       accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.doc,.docx,.xls,.xlsx"
                       onchange="handleProjetFileSelect(event)">

                <!-- Preview du fichier sélectionné -->
                <div id="projetFilePreview" class="upload-preview-grid"></div>

                <!-- Actions -->
                <div style="display:flex; gap:0.5rem; margin-top:1rem;">
                    <button type="button" class="btn-upload-confirm" onclick="uploadProjetPreuve({{ $projet->id }})">
                        <i class="bi bi-check-circle-fill"></i> Enregistrer
                    </button>
                    <button type="button" class="btn-upload-cancel" onclick="cancelProjetUpload()">
                        Annuler
                    </button>
                    <span id="projetUploadStatus" style="font-size:0.75rem; color:var(--gray-500); margin-left:0.5rem;"></span>
                </div>
            </div>

            <!-- Grille des preuves -->
            <div class="preuves-grid" id="projetPreuvesGrid">
                @forelse($preuvesProjet as $preuve)
                @php
                    $isImage = Str::startsWith($preuve->mime_type, 'image/');
                    $isPdf = $preuve->mime_type === 'application/pdf';
                    $fileIcon = $isPdf ? 'bi-file-earmark-pdf-fill' : 
                               ($isImage ? 'bi-file-earmark-image-fill' : 
                               (Str::contains($preuve->mime_type, 'word') ? 'bi-file-earmark-word-fill' :
                               (Str::contains($preuve->mime_type, 'excel') ? 'bi-file-earmark-excel-fill' :
                               'bi-file-earmark-fill')));
                @endphp
                <div class="preuve-card" id="projet-preuve-{{ $preuve->id }}">
                    <div class="preuve-thumb-large">
                        @if($isImage)
                        <img src="{{ $preuve->url }}" alt="{{ $preuve->label ?: $preuve->fichier_nom }}">
                        @else
                        <i class="bi {{ $fileIcon }}"></i>
                        @endif
                    </div>
                    <div class="preuve-body">
                        <h6 title="{{ $preuve->label ?: $preuve->fichier_nom }}">
                            {{ Str::limit($preuve->label ?: $preuve->fichier_nom, 30) }}
                        </h6>
                        <div class="preuve-meta">
                            <span>{{ strtoupper(pathinfo($preuve->fichier_nom, PATHINFO_EXTENSION)) }}</span>
                            <span>{{ $preuve->taille_kb }} Ko</span>
                            <span>{{ \Carbon\Carbon::parse($preuve->created_at)->format('d/m/Y') }}</span>
                        </div>
                        <div class="preuve-actions">
                            <button type="button" class="preuve-action-btn" 
                                    onclick="openFullscreenProjet({{ $preuve->id }}, '{{ addslashes($preuve->label ?: $preuve->fichier_nom) }}', '{{ $preuve->mime_type }}', '{{ $preuve->url }}')"
                                    title="Afficher">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                            <button type="button" class="preuve-action-btn print" 
                                    onclick="printProjetPreuve('{{ $preuve->url }}', '{{ addslashes($preuve->label ?: $preuve->fichier_nom) }}')"
                                    title="Imprimer">
                                <i class="bi bi-printer-fill"></i>
                            </button>
                            <button type="button" class="preuve-action-btn delete" 
                                    onclick="deleteProjetPreuve({{ $preuve->id }})"
                                    title="Supprimer">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-preuves">
                    <i class="bi bi-folder2-open"></i>
                    <p>Aucun document</p>
                    <small>Cliquez sur "Ajouter un document" pour joindre des fichiers</small>
                </div>
                @endforelse
            </div>
        </div>

        <form action="{{ route('projets.update', $projet->id) }}" method="POST" id="mainForm">
            @csrf
            @method('PUT')
            <!-- Boutons -->
            <div class="d-flex justify-content-end gap-3 mb-5">
                <a href="{{ route('projet.details', $projet->id) }}" class="btn-secondary">
                    <i class="bi bi-x-circle"></i> Annuler
                </a>
                @if($user->hasPermission('voir_gantt'))
                <a href="/projet/{{ $projet->id }}/gantt" class="btn-primary" style="background:linear-gradient(135deg, var(--success-500), var(--success-600));">
                    <i class="bi bi-bar-chart-steps-fill"></i> Planning Gantt
                    @php $ganttCount = DB::table('gantt_taches')->where('projet_id', $projet->id)->count(); @endphp
                    @if($ganttCount > 0)
                    <span class="badge bg-white text-success ms-1" style="font-size:0.7rem;">{{ $ganttCount }}</span>
                    @endif
                </a>
                @endif
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle-fill"></i> Enregistrer les modifications
                </button>
            </div>


        </form>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ===== STATE =====
        let pendingFiles = {}; // livrable_id => File object
        let projetPendingFile = null;
        let currentFsPreuveId = null;
        let currentFsPreuveUrl = null;
        let currentFsPreuveMime = null;

        // ===== THEME =====
        (function() {
            const savedTheme = localStorage.getItem('lmc-theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            const icon = document.getElementById('themeIcon');
            if (icon) icon.className = savedTheme === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
        })();

        document.getElementById('themeToggle')?.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('lmc-theme', next);
            const icon = document.getElementById('themeIcon');
            if (icon) icon.className = next === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
        });

        // ===== JOURS RECALC =====
        function recalcJours() {
            let totalJ = 0;
            document.querySelectorAll('input[name^="chapitres"][name$="[jours]"]').forEach(i => {
                totalJ += parseFloat(i.value) || 0;
            });
            totalJ = Math.round(totalJ * 10) / 10;
            document.getElementById('jours_realises').value = totalJ;
            document.getElementById('footJours').textContent = totalJ;
        }

        // ===== LIVRABLE STATUS =====
        function updateLivrableStatus(select, chapCode, collapseId) {
            select.className = 'liv-statut-select ' +
                (select.value === 'Terminé' ? 's-ok' : select.value === 'En cours' ? 's-ec' : 's-nc');
            
            const row = document.getElementById(collapseId);
            const selects = row.querySelectorAll('.liv-statut-select');
            let total = selects.length, termines = 0;
            selects.forEach(s => { if (s.value === 'Terminé') termines++; });
            const pct = Math.round((termines / total) * 100);
            
            const af = document.getElementById('avancement-' + chapCode);
            if (af) af.value = pct;
            
            const pr = row.previousElementSibling;
            if (pr) {
                const cd = pr.querySelector('.livrables-count');
                if (cd) cd.innerHTML = `${termines}/${total} (${pct}%)`;
            }
            
            updateGlobalProgress();
        }

        function updateGlobalProgress() {
            let totalGlobal = 0, terminesGlobal = 0;
            document.querySelectorAll('[id^="liv-chap-"]').forEach(body => {
                const selects = body.querySelectorAll('.liv-statut-select');
                if (selects.length > 0) {
                    totalGlobal += selects.length;
                    selects.forEach(s => { if (s.value === 'Terminé') terminesGlobal++; });
                }
            });
            
            const pctGlobal = totalGlobal > 0 ? Math.round((terminesGlobal / totalGlobal) * 100) : 0;
            
            const ag = document.getElementById('avancement_percent');
            if (ag) ag.value = pctGlobal;
            
            const fa = document.getElementById('footAvancement');
            if (fa) fa.textContent = pctGlobal;
            
            const autoTags = document.querySelectorAll('.auto-tag');
            if (autoTags.length >= 2) {
                autoTags[1].innerHTML = `<i class="bi bi-arrow-right-circle-fill"></i> ${terminesGlobal}/${totalGlobal} livrables terminés`;
            }
        }

        // ===== PREUVES LIVRABLES (simplifiées) =====
        function toggleViewer(livId) {
            const vRow = document.getElementById(`viewer-row-${livId}`);
            const uRow = document.getElementById(`upload-row-${livId}`);
            if (uRow) uRow.style.display = 'none';
            if (vRow) vRow.style.display = vRow.style.display === 'none' ? 'table-row' : 'none';
        }

        function toggleUploader(livId) {
            const uRow = document.getElementById(`upload-row-${livId}`);
            const vRow = document.getElementById(`viewer-row-${livId}`);
            if (vRow) vRow.style.display = 'none';
            if (uRow) uRow.style.display = uRow.style.display === 'none' ? 'table-row' : 'none';
        }

        function cancelUpload(livId) {
            const uRow = document.getElementById(`upload-row-${livId}`);
            if (uRow) uRow.style.display = 'none';
            delete pendingFiles[livId];
            const preview = document.getElementById(`file-preview-${livId}`);
            if (preview) preview.innerHTML = '';
            const fi = document.getElementById(`file-input-${livId}`);
            if (fi) fi.value = '';
            const lbl = document.getElementById(`label-${livId}`);
            if (lbl) lbl.value = '';
            const dz = document.getElementById(`dropzone-${livId}`);
            if (dz) {
                dz.querySelector('strong').textContent = 'Cliquer ou glisser un fichier ici';
                dz.querySelector('p').textContent = 'PDF, Image, Word, Excel — max 10 MB';
            }
        }

        function handleDragOver(e, livId) {
            e.preventDefault();
            document.getElementById(`dropzone-${livId}`)?.classList.add('dragover');
        }

        function handleDragLeave(livId) {
            document.getElementById(`dropzone-${livId}`)?.classList.remove('dragover');
        }

        function handleDrop(e, livId) {
            e.preventDefault();
            document.getElementById(`dropzone-${livId}`)?.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file) processFile(file, livId);
        }

        function handleFileSelect(e, livId) {
            const file = e.target.files[0];
            if (file) processFile(file, livId);
        }

        function processFile(file, livId) {
            if (file.size > 10 * 1024 * 1024) {
                alert('Fichier trop grand (max 10 MB)');
                return;
            }
            pendingFiles[livId] = file;
            
            const previewContainer = document.getElementById(`file-preview-${livId}`);
            if (!previewContainer) return;
            previewContainer.innerHTML = '';

            const isImage = file.type.startsWith('image/');
            const item = document.createElement('div');
            item.className = 'upload-preview-item';

            if (isImage) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    item.innerHTML = `
                        <img src="${ev.target.result}" alt="${file.name}">
                        <button class="remove-preview" onclick="clearFile(${livId})" type="button">
                            <i class="bi bi-x"></i>
                        </button>`;
                };
                reader.readAsDataURL(file);
            } else {
                const icon = file.type === 'application/pdf' ? 'bi-file-earmark-pdf-fill' :
                    (file.name.match(/\.docx?$/i) ? 'bi-file-earmark-word-fill' :
                    (file.name.match(/\.xlsx?$/i) ? 'bi-file-earmark-excel-fill' : 'bi-file-earmark-fill'));
                item.innerHTML = `
                    <div class="file-icon-preview"><i class="bi ${icon}"></i></div>
                    <button class="remove-preview" onclick="clearFile(${livId})" type="button">
                        <i class="bi bi-x"></i>
                    </button>`;
            }
            previewContainer.appendChild(item);

            const dz = document.getElementById(`dropzone-${livId}`);
            if (dz) {
                dz.querySelector('strong').textContent = file.name;
                dz.querySelector('p').textContent = `${(file.size / 1024).toFixed(0)} Ko`;
            }
        }

        function clearFile(livId) {
            delete pendingFiles[livId];
            const preview = document.getElementById(`file-preview-${livId}`);
            if (preview) preview.innerHTML = '';
            const fi = document.getElementById(`file-input-${livId}`);
            if (fi) fi.value = '';
            const dz = document.getElementById(`dropzone-${livId}`);
            if (dz) {
                dz.querySelector('strong').textContent = 'Cliquer ou glisser un fichier ici';
                dz.querySelector('p').textContent = 'PDF, Image, Word, Excel — max 10 MB';
            }
        }

        async function uploadPreuve(livId, projetId) {
            const file = pendingFiles[livId];
            if (!file) {
                showUploadStatus(livId, 'Veuillez sélectionner un fichier', 'danger');
                return;
            }
            const label = document.getElementById(`label-${livId}`)?.value || '';

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}');
            formData.append('livrable_id', livId);
            formData.append('projet_id', projetId);
            formData.append('label', label);
            formData.append('fichier', file);

            showUploadStatus(livId, 'Envoi en cours...', 'info');

            try {
                const res = await fetch('/preuves/upload', {
                    method: 'POST',
                    body: formData,
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}' 
                    }
                });

                if (!res.ok) throw new Error('Erreur serveur ' + res.status);
                const data = await res.json();

                showUploadStatus(livId, '✅ Preuve enregistrée !', 'success');

                const badge = document.getElementById(`preuve-count-${livId}`);
                if (badge) {
                    const currentCount = parseInt(badge.textContent) || 0;
                    badge.textContent = currentCount + 1;
                    badge.classList.remove('zero');
                }

                addPreuveToViewer(livId, data.preuve);
                setTimeout(() => cancelUpload(livId), 1200);

            } catch (err) {
                showUploadStatus(livId, '❌ Erreur : ' + err.message, 'danger');
            }
        }

        function showUploadStatus(livId, msg, type) {
            const el = document.getElementById(`upload-status-${livId}`);
            if (!el) return;
            el.textContent = msg;
            el.style.color = type === 'success' ? 'var(--success-600)' :
                             type === 'danger' ? 'var(--danger-600)' : 'var(--gray-500)';
        }

        function addPreuveToViewer(livId, pr) {
            const list = document.getElementById(`preuve-list-${livId}`);
            if (!list) return;

            const empty = document.getElementById(`preuve-empty-${livId}`);
            if (empty) empty.remove();

            const isImage = pr.mime_type && pr.mime_type.startsWith('image/');
            const isPdf = pr.mime_type === 'application/pdf';
            const icon = isPdf ? 'bi-file-earmark-pdf-fill' :
                (pr.mime_type && pr.mime_type.includes('word') ? 'bi-file-earmark-word-fill' :
                (pr.mime_type && (pr.mime_type.includes('excel') || pr.mime_type.includes('spreadsheet')) ? 'bi-file-earmark-excel-fill' :
                'bi-file-earmark-fill'));
            const iconColor = isPdf ? '#ef4444' : 
                (pr.mime_type && pr.mime_type.includes('word') ? '#2563eb' : 
                (pr.mime_type && (pr.mime_type.includes('excel') || pr.mime_type.includes('spreadsheet')) ? '#10b981' : '#6b7280'));

            const item = document.createElement('div');
            item.className = 'preuve-item';
            item.id = `preuve-item-${pr.id}`;
            item.innerHTML = `
                ${isImage
                    ? `<img src="${pr.url}" alt="${pr.label || pr.fichier_nom}" class="preuve-thumb">`
                    : `<div class="preuve-thumb-icon"><i class="bi ${icon}" style="color:${iconColor}"></i></div>`
                }
                <div class="preuve-info">
                    <div class="preuve-name">${pr.label || pr.fichier_nom}</div>
                    <div class="preuve-meta">
                        ${pr.fichier_nom.split('.').pop().toUpperCase()} •
                        ${Math.round(pr.taille_kb)} Ko • Maintenant
                    </div>
                </div>
                <div class="preuve-item-actions">
                    <button type="button" class="btn-preuve-print" data-tooltip="Imprimer / Afficher"
                        onclick="openFullscreen(${pr.id}, '${(pr.label || pr.fichier_nom).replace(/'/g,"\\'")}', '${pr.mime_type}', '${pr.url}')">
                        <i class="bi bi-printer-fill"></i>
                    </button>
                    <button type="button" class="btn-preuve-delete" data-tooltip="Supprimer"
                        onclick="deletePreuve(${pr.id}, ${livId})">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </div>`;
            list.appendChild(item);
        }

        async function deletePreuve(preuveId, livId) {
            if (!confirm('Supprimer cette preuve définitivement ?')) return;
            
            try {
                const res = await fetch(`/preuves/${preuveId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
                
                if (!res.ok) throw new Error('Erreur serveur');

                const item = document.getElementById(`preuve-item-${preuveId}`);
                if (item) item.remove();

                const badge = document.getElementById(`preuve-count-${livId}`);
                if (badge) {
                    const newCount = Math.max(0, (parseInt(badge.textContent) || 0) - 1);
                    badge.textContent = newCount;
                    if (newCount === 0) badge.classList.add('zero');
                }

                const list = document.getElementById(`preuve-list-${livId}`);
                if (list && list.querySelectorAll('.preuve-item').length === 0) {
                    list.innerHTML = `<div class="preuve-empty" id="preuve-empty-${livId}">
                        <i class="bi bi-inbox"></i>Aucune preuve attachée</div>`;
                }

                closeFullscreen();

            } catch (err) {
                alert('Erreur lors de la suppression : ' + err.message);
            }
        }

        // ===== PREUVES PROJET FUNCTIONS =====
        function toggleProjetUploadPanel() {
            const panel = document.getElementById('projetUploadPanel');
            panel.classList.toggle('active');
        }

        function handleProjetDragOver(e) {
            e.preventDefault();
            document.getElementById('projetDropzone').classList.add('dragover');
        }

        function handleProjetDragLeave() {
            document.getElementById('projetDropzone').classList.remove('dragover');
        }

        function handleProjetDrop(e) {
            e.preventDefault();
            document.getElementById('projetDropzone').classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file) processProjetFile(file);
        }

        function handleProjetFileSelect(e) {
            const file = e.target.files[0];
            if (file) processProjetFile(file);
        }

        function processProjetFile(file) {
            if (file.size > 10 * 1024 * 1024) {
                alert('Fichier trop grand (max 10 MB)');
                return;
            }
            projetPendingFile = file;
            
            const preview = document.getElementById('projetFilePreview');
            preview.innerHTML = '';

            const isImage = file.type.startsWith('image/');
            const item = document.createElement('div');
            item.className = 'upload-preview-item';

            if (isImage) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    item.innerHTML = `
                        <img src="${ev.target.result}" alt="${file.name}">
                        <button class="remove-preview" onclick="clearProjetFile()" type="button">
                            <i class="bi bi-x"></i>
                        </button>`;
                };
                reader.readAsDataURL(file);
            } else {
                const icon = file.type === 'application/pdf' ? 'bi-file-earmark-pdf-fill' :
                    (file.name.match(/\.docx?$/i) ? 'bi-file-earmark-word-fill' :
                    (file.name.match(/\.xlsx?$/i) ? 'bi-file-earmark-excel-fill' : 'bi-file-earmark-fill'));
                item.innerHTML = `
                    <div class="file-icon-preview"><i class="bi ${icon}"></i></div>
                    <button class="remove-preview" onclick="clearProjetFile()" type="button">
                        <i class="bi bi-x"></i>
                    </button>`;
            }
            preview.appendChild(item);

            const dz = document.getElementById('projetDropzone');
            dz.querySelector('h6').textContent = file.name;
            dz.querySelector('p').textContent = `${(file.size / 1024).toFixed(0)} Ko`;
        }

        function clearProjetFile() {
            projetPendingFile = null;
            document.getElementById('projetFilePreview').innerHTML = '';
            document.getElementById('projetFileInput').value = '';
            const dz = document.getElementById('projetDropzone');
            dz.querySelector('h6').textContent = 'Cliquez ou glissez un fichier ici';
            dz.querySelector('p').textContent = 'PDF, Images, Word, Excel — max 10 MB';
        }

        function cancelProjetUpload() {
            clearProjetFile();
            document.getElementById('projetUploadPanel').classList.remove('active');
            document.getElementById('projetLabel').value = '';
            document.getElementById('projetUploadStatus').textContent = '';
        }

        async function uploadProjetPreuve(projetId) {
            const file = projetPendingFile;
            if (!file) {
                document.getElementById('projetUploadStatus').textContent = 'Veuillez sélectionner un fichier';
                return;
            }
            
            const label = document.getElementById('projetLabel').value || '';

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}');
            formData.append('projet_id', projetId);
            formData.append('label', label);
            formData.append('fichier', file);

            document.getElementById('projetUploadStatus').textContent = 'Envoi en cours...';

            try {
                const res = await fetch('/preuves-projet/upload', {
                    method: 'POST',
                    body: formData
                });

                if (!res.ok) throw new Error('Erreur serveur');
                const data = await res.json();

                document.getElementById('projetUploadStatus').textContent = '✅ Document ajouté !';
                
                addProjetPreuveToGrid(data.preuve);
                
                setTimeout(() => {
                    cancelProjetUpload();
                    document.getElementById('projetUploadStatus').textContent = '';
                }, 1500);

            } catch (err) {
                document.getElementById('projetUploadStatus').textContent = '❌ Erreur : ' + err.message;
            }
        }

        function addProjetPreuveToGrid(pr) {
            const grid = document.getElementById('projetPreuvesGrid');
            
            const emptyDiv = grid.querySelector('.empty-preuves');
            if (emptyDiv) emptyDiv.remove();

            const isImage = pr.mime_type && pr.mime_type.startsWith('image/');
            const isPdf = pr.mime_type === 'application/pdf';
            const fileIcon = isPdf ? 'bi-file-earmark-pdf-fill' : 
                           (isImage ? 'bi-file-earmark-image-fill' : 
                           (pr.mime_type && pr.mime_type.includes('word') ? 'bi-file-earmark-word-fill' :
                           (pr.mime_type && pr.mime_type.includes('excel') ? 'bi-file-earmark-excel-fill' :
                           'bi-file-earmark-fill')));

            const card = document.createElement('div');
            card.className = 'preuve-card';
            card.id = `projet-preuve-${pr.id}`;
            card.innerHTML = `
                <div class="preuve-thumb-large">
                    ${isImage 
                        ? `<img src="${pr.url}" alt="${pr.label || pr.fichier_nom}">`
                        : `<i class="bi ${fileIcon}"></i>`
                    }
                </div>
                <div class="preuve-body">
                    <h6 title="${pr.label || pr.fichier_nom}">${pr.label || pr.fichier_nom}</h6>
                    <div class="preuve-meta">
                        <span>${pr.fichier_nom.split('.').pop().toUpperCase()}</span>
                        <span>${Math.round(pr.taille_kb)} Ko</span>
                        <span>Maintenant</span>
                    </div>
                    <div class="preuve-actions">
                        <button type="button" class="preuve-action-btn" 
                                onclick="openFullscreenProjet(${pr.id}, '${(pr.label || pr.fichier_nom).replace(/'/g,"\\'")}', '${pr.mime_type}', '${pr.url}')"
                                title="Afficher">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        <button type="button" class="preuve-action-btn print" 
                                onclick="printProjetPreuve('${pr.url}', '${(pr.label || pr.fichier_nom).replace(/'/g,"\\'")}')"
                                title="Imprimer">
                            <i class="bi bi-printer-fill"></i>
                        </button>
                        <button type="button" class="preuve-action-btn delete" 
                                onclick="deleteProjetPreuve(${pr.id})"
                                title="Supprimer">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </div>
            `;
            
            grid.appendChild(card);
            
            const countSpan = document.querySelector('.preuves-count');
            if (countSpan) {
                const current = parseInt(countSpan.textContent) || 0;
                countSpan.textContent = (current + 1) + ' document(s)';
            }
        }

        async function deleteProjetPreuve(preuveId) {
            if (!confirm('Supprimer ce document définitivement ?')) return;
            
            try {
                const res = await fetch(`/preuves-projet/${preuveId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                    }
                });
                
                if (!res.ok) throw new Error('Erreur serveur');

                const card = document.getElementById(`projet-preuve-${preuveId}`);
                if (card) card.remove();

                const countSpan = document.querySelector('.preuves-count');
                if (countSpan) {
                    const current = parseInt(countSpan.textContent) || 0;
                    countSpan.textContent = (current - 1) + ' document(s)';
                }

                const grid = document.getElementById('projetPreuvesGrid');
                if (grid.children.length === 0) {
                    grid.innerHTML = `
                        <div class="empty-preuves">
                            <i class="bi bi-folder2-open"></i>
                            <p>Aucun document</p>
                            <small>Cliquez sur "Ajouter un document" pour joindre des fichiers</small>
                        </div>
                    `;
                }

                closeFullscreen();

            } catch (err) {
                alert('Erreur lors de la suppression : ' + err.message);
            }
        }

        // ===== FULLSCREEN VIEWER =====
        function openFullscreen(preuveId, title, mimeType, url) {
            currentFsPreuveId = preuveId;
            currentFsPreuveUrl = url;
            currentFsPreuveMime = mimeType;

            document.getElementById('fsPreuveTitle').textContent = title;

            const body = document.getElementById('fsPreuveBody');
            const isImage = mimeType && mimeType.startsWith('image/');
            const isPdf = mimeType === 'application/pdf';

            if (isImage) {
                body.innerHTML = `<img src="${url}" alt="${title}">`;
            } else if (isPdf) {
                body.innerHTML = `<iframe src="${url}" class="pdf-embed" title="${title}"></iframe>`;
            } else {
                const icon = mimeType && mimeType.includes('word') ? 'bi-file-earmark-word-fill' :
                    (mimeType && (mimeType.includes('excel') || mimeType.includes('spreadsheet')) ? 'bi-file-earmark-excel-fill' :
                    'bi-file-earmark-fill');
                body.innerHTML = `
                    <div class="file-preview-generic">
                        <i class="bi ${icon}"></i>
                        <p style="font-size:1rem; margin:0.5rem 0;">${title}</p>
                        <p style="font-size:0.8rem; color:var(--gray-500);">Aperçu non disponible</p>
                        <a href="${url}" download class="btn-dl">
                            <i class="bi bi-download"></i> Télécharger
                        </a>
                    </div>`;
            }

            document.getElementById('preuveFullscreenOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function openFullscreenProjet(preuveId, title, mimeType, url) {
            openFullscreen(preuveId, title, mimeType, url);
            currentFsPreuveId = preuveId;
        }

        function closeFullscreen() {
            document.getElementById('preuveFullscreenOverlay').classList.remove('active');
            document.body.style.overflow = '';
            currentFsPreuveId = null;
            currentFsPreuveUrl = null;
            currentFsPreuveMime = null;
        }

        function printCurrentPreuve() {
            if (!currentFsPreuveUrl) return;
            
            const isImage = currentFsPreuveMime && currentFsPreuveMime.startsWith('image/');
            const isPdf = currentFsPreuveMime === 'application/pdf';
            const title = document.getElementById('fsPreuveTitle').textContent;

            const printWindow = window.open('', '_blank');
            if (isImage) {
                printWindow.document.write(`
                    <html><head><title>Impression - ${title}</title>
                    <style>
                        body { margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; background: white; }
                        img { max-width: 100%; max-height: 95vh; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                        .header { text-align: center; padding: 10px; font-family: Arial, sans-serif; color: #333; }
                    </style></head>
                    <body>
                        <div style="text-align: center; width: 100%;">
                            <div class="header">${title}</div>
                            <img src="${currentFsPreuveUrl}" onload="window.print(); setTimeout(() => window.close(), 1000);">
                        </div>
                    </body></html>`);
            } else if (isPdf) {
                printWindow.document.write(`
                    <html><head><title>Impression - ${title}</title>
                    <style>
                        body { margin: 0; font-family: Arial, sans-serif; }
                        .header { text-align: center; padding: 10px; background: #f5f5f5; border-bottom: 1px solid #ddd; }
                    </style></head>
                    <body>
                        <div class="header">${title}</div>
                        <iframe src="${currentFsPreuveUrl}" style="width:100%;height:95vh;border:none;" onload="setTimeout(() => this.contentWindow.print(), 500);"></iframe>
                    </body></html>`);
            } else {
                printWindow.location.href = currentFsPreuveUrl;
            }
            printWindow.document.close();
        }

        function printProjetPreuve(url, title) {
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html><head><title>Impression - ${title}</title>
                <style>
                    body { margin: 0; font-family: Arial, sans-serif; }
                    .header { text-align: center; padding: 10px; background: #f5f5f5; border-bottom: 1px solid #ddd; }
                    iframe { width: 100%; height: 95vh; border: none; }
                </style></head>
                <body>
                    <div class="header">${title}</div>
                    <iframe src="${url}" onload="setTimeout(() => this.contentWindow.print(), 500);"></iframe>
                </body></html>`);
            printWindow.document.close();
        }

        function deleteCurrentPreuve() {
            if (currentFsPreuveId) {
                deleteProjetPreuve(currentFsPreuveId);
                closeFullscreen();
            }
        }

        // Close fullscreen on overlay click
        document.getElementById('preuveFullscreenOverlay')?.addEventListener('click', function(e) {
            if (e.target === this) closeFullscreen();
        });

        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeFullscreen();
        });

        // ===== CONSULTANTS =====
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
                                <i class="bi bi-person-plus-fill me-1" style="color:var(--success-500);"></i>
                                ${consNom}
                            </div>
                            <input type="hidden" name="consultants[${consId}][id]" value="${consId}">
                            <span class="badge" style="background:linear-gradient(135deg, var(--success-500), var(--success-600)); color:white; font-size:0.6rem; margin-left:0.5rem;">Nouveau</span>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="consultants[${consId}][role]">
                                <option ${role==='Chef de Projet'?'selected':''}>Chef de Projet</option>
                                <option ${role==='Consultant'?'selected':''}>Consultant</option>
                                <option ${role==='Consultant Ext.'?'selected':''}>Consultant Ext.</option>
                                <option ${role==='Expert'?'selected':''}>Expert</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="consultants[${consId}][jours_alloues]" min="0" step="0.1" value="${joursA}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="consultants[${consId}][jours_realises]" min="0" step="0.1" value="${joursR}">
                        </div>
                        <div class="col-md-1">
                            <span class="badge" style="background:linear-gradient(135deg, var(--primary-500), var(--primary-600)); color:white; padding:0.3rem 0.6rem; border-radius:var(--radius-full);">
                                ${charge}%
                            </span>
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn-remove" onclick="removeConsultant(this, ${consId})">
                                <i class="bi bi-trash"></i>
                            </button>
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
                btn.closest('.consultant-row').remove();
                document.getElementById('deletedConsultantsContainer').insertAdjacentHTML('beforeend',
                    `<input type="hidden" name="deleted_consultants[]" value="${consId}">`);
            }
        }

        // Auto-hide alerts
        setTimeout(() => { 
            document.querySelectorAll('.alert-float').forEach(a => a.remove()); 
        }, 5000);

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            recalcJours();
            updateGlobalProgress();
        });
    </script>
</body>
</html>