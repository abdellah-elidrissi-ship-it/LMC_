<!DOCTYPE html>
<html lang="fr" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMC Conseil — Tableau de Bord PMO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        :root {
            --blue: #2563EB;
            --lblue: #60A5FA;
            --green: #10B981;
            --orange: #F59E0B;
            --red: #EF4444;
            --purple: #8B5CF6;
            --teal: #06B6D4;
            --bg: #EEF2FF;
            --card: #FFFFFF;
            --text: #1F2937;
            --muted: #6B7280;
            --border: #E5EAF4;
            --shadow: 0 2px 16px rgba(37, 99, 235, 0.07);
        }

        [data-theme="dark"] {
            --bg: #0f172a;
            --card: #1e293b;
            --text: #f1f5f9;
            --muted: #94a3b8;
            --border: #334155;
            --shadow: 0 2px 16px rgba(0, 0, 0, 0.4);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 11px;
        }

        [data-theme="light"] body {
            background: linear-gradient(135deg, #EEF2FF 0%, #F0F9FF 50%, #F5F3FF 100%);
        }

        /* NAVBAR */
        .site-header {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            padding: .85rem 0;
            border-bottom: 3px solid #3b82f6;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .hdr-wrap {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-wrap {
            display: flex;
            align-items: center;
            gap: .7rem;
        }

        .logo-img {
            height: 34px;
            filter: brightness(0) invert(1);
        }

        [data-theme="dark"] .logo-img {
            filter: none;
        }

        .logo-main {
            font-size: 1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.02em;
        }

        .logo-sub {
            font-size: .6rem;
            color: rgba(255, 255, 255, .4);
        }

        .hdr-actions {
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: .35rem;
            color: #fff;
            background: rgba(255, 255, 255, .08);
            padding: .28rem .85rem;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, .1);
            font-size: .75rem;
            font-weight: 500;
        }

        .meta-pill {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .6);
            padding: .28rem .85rem;
            border-radius: 50px;
            font-size: .68rem;
            display: flex;
            align-items: center;
            gap: .35rem;
        }

        .icon-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .15);
            background: rgba(255, 255, 255, .08);
            color: rgba(255, 255, 255, .6);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .2s;
            font-size: .8rem;
        }

        .icon-btn:hover {
            background: #3b82f6;
            color: #fff;
            border-color: #3b82f6;
        }

        .nav-wrap-outer {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .nav-wrap {
            display: flex;
            gap: .2rem;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .08);
            padding: .3rem;
            border-radius: 50px;
            margin-top: .55rem;
            width: fit-content;
        }

        .nav-item {
            padding: .35rem 1rem;
            border-radius: 50px;
            font-size: .72rem;
            font-weight: 500;
            color: rgba(255, 255, 255, .58);
            text-decoration: none;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, .1);
            color: #fff;
        }

        .nav-item.active {
            background: #fff;
            color: #0f172a;
            font-weight: 700;
        }

        /* APP */
        #app {
            padding: 16px 18px;
            max-width: 1600px;
            margin: 0 auto;
        }

        /* PMO BANNER */
        .pmo-banner {
            background: linear-gradient(135deg, #1E3A8A 0%, #2563EB 60%, #7C3AED 100%);
            border-radius: 16px;
            padding: 16px 26px;
            color: #fff;
            box-shadow: 0 8px 32px rgba(37, 99, 235, .28);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 13px;
        }

        .banner-left {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .banner-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .banner-title {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -.3px;
        }

        .banner-sub {
            font-size: 10px;
            opacity: .7;
            margin-top: 2px;
        }

        .banner-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .bstat {
            text-align: center;
        }

        .bstat-val {
            font-size: 21px;
            font-weight: 900;
        }

        .bstat-lbl {
            font-size: 9px;
            opacity: .65;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .banner-date {
            font-size: 10px;
            opacity: .6;
            border-left: 1px solid rgba(255, 255, 255, .2);
            padding-left: 16px;
            line-height: 1.85;
        }

        /* FILTERS */
        .filters-bar {
            display: flex;
            gap: 7px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 12px;
            background: var(--card);
            border-radius: 12px;
            padding: 8px 14px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        .filter-lbl {
            font-size: 9px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .filter-sep {
            width: 1px;
            height: 20px;
            background: var(--border);
            margin: 0 3px;
        }

        .filters-bar select {
            height: 26px;
            padding: 0 8px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--text);
            font-size: 10px;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            outline: none;
            transition: border-color .2s;
        }

        .filters-bar select:hover {
            border-color: var(--blue);
        }

        .btn-reset {
            height: 26px;
            padding: 0 12px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--blue);
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-reset:hover {
            background: var(--blue);
            color: #fff;
        }

        /* KPI */
        .kpi-row {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 8px;
            margin-bottom: 12px;
        }

        .kpi {
            background: var(--card);
            border-radius: 13px;
            padding: 12px 11px 10px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: transform .18s, box-shadow .18s;
            cursor: default;
        }

        .kpi:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(37, 99, 235, .12);
        }

        .kpi::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 13px 13px 0 0;
        }

        .kpi.c-blue::before {
            background: linear-gradient(90deg, #2563EB, #60A5FA);
        }

        .kpi.c-green::before {
            background: linear-gradient(90deg, #10B981, #34D399);
        }

        .kpi.c-orange::before {
            background: linear-gradient(90deg, #F59E0B, #FCD34D);
        }

        .kpi.c-red::before {
            background: linear-gradient(90deg, #EF4444, #F87171);
        }

        .kpi.c-purple::before {
            background: linear-gradient(90deg, #8B5CF6, #C4B5FD);
        }

        .kpi.c-lblue::before {
            background: linear-gradient(90deg, #60A5FA, #BAE6FD);
        }

        .kpi.c-teal::before {
            background: linear-gradient(90deg, #06B6D4, #67E8F9);
        }

        .kpi-icon {
            width: 25px;
            height: 25px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .kpi.c-blue .kpi-icon {
            background: #DBEAFE;
        }

        .kpi.c-green .kpi-icon {
            background: #D1FAE5;
        }

        .kpi.c-orange .kpi-icon {
            background: #FEF3C7;
        }

        .kpi.c-red .kpi-icon {
            background: #FEE2E2;
        }

        .kpi.c-purple .kpi-icon {
            background: #EDE9FE;
        }

        .kpi.c-lblue .kpi-icon {
            background: #DBEAFE;
        }

        .kpi.c-teal .kpi-icon {
            background: #CFFAFE;
        }

        .kpi-lbl {
            font-size: 8.5px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: 3px;
        }

        .kpi-val {
            font-size: 21px;
            font-weight: 900;
            line-height: 1;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .kpi.c-blue .kpi-val {
            background-image: linear-gradient(135deg, #2563EB, #60A5FA);
        }

        .kpi.c-green .kpi-val {
            background-image: linear-gradient(135deg, #10B981, #34D399);
        }

        .kpi.c-orange .kpi-val {
            background-image: linear-gradient(135deg, #F59E0B, #FCD34D);
        }

        .kpi.c-red .kpi-val {
            background-image: linear-gradient(135deg, #EF4444, #F87171);
        }

        .kpi.c-purple .kpi-val {
            background-image: linear-gradient(135deg, #8B5CF6, #A78BFA);
        }

        .kpi.c-lblue .kpi-val {
            background-image: linear-gradient(135deg, #60A5FA, #38BDF8);
        }

        .kpi.c-teal .kpi-val {
            background-image: linear-gradient(135deg, #06B6D4, #22D3EE);
        }

        .kpi-sub {
            font-size: 8px;
            color: #CBD5E1;
            margin-top: 2px;
            font-weight: 500;
        }

        .kpi-trend {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            font-size: 8px;
            font-weight: 700;
            padding: 1px 5px;
            border-radius: 4px;
            margin-top: 3px;
        }

        .trend-up {
            background: #D1FAE5;
            color: #065F46;
        }

        .trend-down {
            background: #FEE2E2;
            color: #991B1B;
        }

        .trend-flat {
            background: #F1F5F9;
            color: #64748B;
        }

        /* SECTION LABEL */
        .sl {
            font-size: 9px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 7px;
            padding-left: 4px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .sl::before {
            content: '';
            display: block;
            width: 3px;
            height: 12px;
            border-radius: 2px;
        }

        .sl-port::before {
            background: var(--blue);
        }

        .sl-res::before {
            background: var(--purple);
        }

        .sl-smi::before {
            background: var(--teal);
        }

        .sl-table::before {
            background: var(--green);
        }

        /* GRID */
        .row3 {
            display: grid;
            gap: 10px;
            margin-bottom: 11px;
        }

        .c3a {
            grid-template-columns: 1fr 1.6fr 1.4fr;
        }

        .c3b {
            grid-template-columns: 1fr 1.5fr 1.5fr;
        }

        .c3c {
            grid-template-columns: 1.4fr 1.4fr 1fr;
        }

        /* CARD */
        .card {
            background: var(--card);
            border-radius: 14px;
            padding: 14px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: box-shadow .18s;
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(37, 99, 235, .09);
        }

        .ctitle {
            font-size: 10px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .cbadge {
            font-size: 8.5px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
            background: #EEF2FF;
            color: var(--blue);
            text-transform: none;
            letter-spacing: 0;
        }

        /* DONUT */
        .donut-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .donut-box {
            position: relative;
            width: 115px;
            height: 115px;
            margin: 0 auto 8px;
        }

        .donut-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }

        .dc-n {
            font-size: 19px;
            font-weight: 900;
            color: var(--text);
            line-height: 1;
        }

        .dc-l {
            font-size: 8px;
            color: var(--muted);
            font-weight: 600;
            letter-spacing: .3px;
        }

        .legend {
            display: flex;
            flex-direction: column;
            gap: 5px;
            width: 100%;
        }

        .leg {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 5px;
        }

        .leg-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .leg-lbl {
            font-size: 9px;
            color: var(--muted);
            flex: 1;
        }

        .leg-val {
            font-size: 10px;
            font-weight: 700;
            color: var(--text);
        }

        /* H-BARS */
        .bar-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 6px;
        }

        .bar-lbl {
            width: 78px;
            font-size: 9.5px;
            color: var(--text);
            text-align: right;
            flex-shrink: 0;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .bar-track {
            flex: 1;
            height: 19px;
            background: #F1F5F9;
            border-radius: 6px;
            overflow: hidden;
        }

        [data-theme="dark"] .bar-track {
            background: #334155;
        }

        .bar-fill {
            height: 100%;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 5px;
            transition: width .6s cubic-bezier(.4, 0, .2, 1);
            min-width: 3px;
        }

        .bar-pct {
            font-size: 8.5px;
            font-weight: 700;
            color: #fff;
        }

        .bar-ext {
            font-size: 9.5px;
            color: var(--muted);
            font-weight: 600;
            margin-left: 4px;
            min-width: 22px;
        }

        /* HEATMAP */
        .hm-table {
            width: 100%;
            border-collapse: collapse;
        }

        .hm-table th {
            padding: 5px 6px;
            font-size: 8.5px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 2px solid var(--border);
            text-align: center;
            background: var(--bg);
        }

        .hm-table th:first-child {
            text-align: left;
        }

        .hm-table td {
            padding: 5px 6px;
            border-bottom: 1px solid var(--border);
            text-align: center;
        }

        .hm-table tr:hover td {
            background: var(--bg);
        }

        .hm-cell {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 2px 6px;
            border-radius: 5px;
            font-size: 8px;
            font-weight: 700;
            white-space: nowrap;
        }

        .hm-g {
            background: #D1FAE5;
            color: #065F46;
        }

        .hm-o {
            background: #FEF3C7;
            color: #92400E;
        }

        .hm-r {
            background: #FEE2E2;
            color: #991B1B;
        }

        .hm-gr {
            background: #F1F5F9;
            color: #94A3B8;
        }

        .proj-id {
            font-weight: 800;
            color: var(--blue);
            font-size: 10px;
        }

        .proj-nm {
            font-size: 8.5px;
            color: var(--muted);
        }

        /* DETAIL TABLE */
        .dt-wrap {
            overflow-x: auto;
        }

        .dt {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }

        .dt thead th {
            padding: 8px 9px;
            background: linear-gradient(180deg, #F8FAFF, #F1F5FF);
            font-size: 8.5px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 2px solid var(--border);
            text-align: left;
            white-space: nowrap;
        }

        [data-theme="dark"] .dt thead th {
            background: #162032;
        }

        .dt tbody td {
            padding: 8px 9px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .dt tbody tr:hover td {
            background: var(--bg);
        }

        .dt tbody tr:last-child td {
            border-bottom: none;
        }

        .dt tfoot td {
            padding: 8px 9px;
            font-weight: 700;
            font-size: 10px;
            border-top: 2px solid var(--blue);
            background: #EEF2FF;
        }

        [data-theme="dark"] .dt tfoot td {
            background: #162032;
        }

        /* BADGES */
        .sbadge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
        }

        .s-comp {
            background: #D1FAE5;
            color: #065F46;
        }

        .s-prog {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .s-del {
            background: #FEE2E2;
            color: #991B1B;
        }

        .s-plan {
            background: #EDE9FE;
            color: #5B21B6;
        }

        .s-pause {
            background: #F1F5F9;
            color: #64748B;
        }

        /* PB */
        .pb {
            display: inline-block;
            width: 58px;
            height: 5px;
            background: #F1F5F9;
            border-radius: 3px;
            overflow: hidden;
            vertical-align: middle;
            margin-right: 4px;
        }

        [data-theme="dark"] .pb {
            background: #334155;
        }

        .pb-f {
            height: 100%;
            border-radius: 3px;
        }

        /* NORME TAG */
        .ntag {
            display: inline-block;
            padding: 1px 5px;
            background: #EEF2FF;
            border: 1px solid #BFDBFE;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 700;
            color: #1D4ED8;
            margin: 1px;
        }

        /* PERF DOT */
        .pdot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 3px;
            vertical-align: middle;
        }

        /* SMI BARS */
        .smi-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 7px;
        }

        .smi-lbl {
            width: 105px;
            font-size: 9px;
            font-weight: 600;
            color: var(--text);
            flex-shrink: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .smi-track {
            flex: 1;
            height: 13px;
            background: #F1F5F9;
            border-radius: 50px;
            overflow: hidden;
        }

        [data-theme="dark"] .smi-track {
            background: #334155;
        }

        .smi-fill {
            height: 100%;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 5px;
            transition: width .6s cubic-bezier(.4, 0, .2, 1);
        }

        .smi-pct-ext {
            font-size: 8.5px;
            font-weight: 700;
            color: var(--muted);
            min-width: 26px;
        }

        /* FOOTER */
        .pmo-footer {
            margin-top: 13px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--card);
            border-radius: 12px;
            padding: 9px 18px;
            border: 1px solid var(--border);
            font-size: 9px;
            color: var(--muted);
        }

        .footer-logo {
            font-size: 11px;
            font-weight: 800;
            color: var(--blue);
        }

        .ftag {
            background: #EEF2FF;
            color: var(--blue);
            padding: 2px 7px;
            border-radius: 6px;
            font-size: 8px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    @php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;

    $projets = DB::select("
    SELECT p.*, c.nom_client, c.secteur_activite, cons.nom_complet as chef_nom, cons.type_consultant as chef_type
    FROM projets p
    LEFT JOIN clients c ON p.client_id = c.id
    LEFT JOIN consultants cons ON p.chef_projet_id = cons.id
    ORDER BY p.reference_projet
    ");

    $totalProjets = count($projets);
    $finalises = $enRetard = $enCours = $planifies = 0;

    $totalPrevus = collect($projets)->sum('jours_prevus');
    $totalRealises = collect($projets)->sum('jours_realises');

    foreach($projets as $p) {
    match($p->statut) {
    'Finalisé' => $finalises++,
    'En retard' => $enRetard++,
    'En cours' => $enCours++,
    default => $planifies++,
    };
    }

    $avancementMoyen = $totalProjets > 0
    ? round(collect($projets)->avg('avancement_percent'))
    : 0;

    $consoGlobale = $totalPrevus > 0 ? round(($totalRealises / $totalPrevus) * 100) : 0;
    $chargeRestante = max(0, $totalPrevus - $totalRealises);
    $totalEcart = $totalRealises - $totalPrevus;

    $consultants = DB::select("
    SELECT cons.id, cons.nom_complet, cons.type_consultant,
    COALESCE(SUM(a.jours_realises),0) as total_realises,
    COALESCE(SUM(a.jours_alloues),0) as total_alloues,
    COUNT(DISTINCT a.projet_id) as nb_projets
    FROM consultants cons
    LEFT JOIN affectations a ON a.consultant_id = cons.id
    WHERE cons.actif = 1
    GROUP BY cons.id, cons.nom_complet, cons.type_consultant
    ORDER BY total_realises DESC
    ");

    $joursInternes = collect($consultants)->where('type_consultant','Interne')->sum('total_realises');
    $joursExternes = collect($consultants)->where('type_consultant','!=','Interne')->sum('total_realises');
    $totalJoursConsultants = $joursInternes + $joursExternes;
    $tauxExterne = $totalJoursConsultants > 0 ? round(($joursExternes / $totalJoursConsultants) * 100) : 0;
    $maxConsultant = collect($consultants)->max('total_realises') ?: 1;

    $normesParProjet = [];
    $normeRows = DB::select("SELECT pn.projet_id, n.code_norme FROM projet_normes pn JOIN normes n ON n.id = pn.norme_id");
    foreach($normeRows as $nr) { $normesParProjet[$nr->projet_id][] = $nr->code_norme; }

    $chapitres = DB::select("
    SELECT cs.code_chapitre, cs.titre_chapitre,
    ROUND(AVG(sc.avancement_percent)) as avg_pct,
    SUM(sc.jours_intervention) as total_jours
    FROM suivi_chapitres sc JOIN chapitres_smis cs ON cs.id = sc.chapitre_id
    GROUP BY cs.id, cs.code_chapitre, cs.titre_chapitre ORDER BY cs.ordre
    ");

    $livStats = DB::selectOne("
    SELECT COUNT(*) as total,
    SUM(CASE WHEN statut='Terminé' THEN 1 ELSE 0 END) as termines,
    SUM(CASE WHEN statut='En cours' THEN 1 ELSE 0 END) as en_cours
    FROM projet_livrables
    ");
    $livPct = ($livStats->total > 0) ? round(($livStats->termines / $livStats->total) * 100) : 0;

    $formations = DB::select("
    SELECT
    p.id as projet_id,
    c.nom_client,
    COUNT(pf.formation_id) as total,
    SUM(CASE WHEN pf.statut IN ('Finalisée','Réalisée') THEN 1 ELSE 0 END) as ok
    FROM projets p
    LEFT JOIN clients c ON c.id = p.client_id
    LEFT JOIN projet_formations pf ON pf.projet_id = p.id
    GROUP BY p.id, c.nom_client
    HAVING COUNT(pf.formation_id) > 0
    ORDER BY c.nom_client
    ");

    $affectationsRaw = DB::select("
    SELECT
    a.projet_id,
    a.consultant_id,
    cons.nom_complet,
    cons.type_consultant,
    a.jours_realises,
    a.jours_alloues
    FROM affectations a
    JOIN consultants cons ON cons.id = a.consultant_id
    WHERE cons.actif = 1
    ");

    $chapitresRaw = DB::select("
    SELECT
    sc.projet_id,
    cs.code_chapitre,
    cs.titre_chapitre,
    sc.avancement_percent,
    sc.jours_intervention
    FROM suivi_chapitres sc
    JOIN chapitres_smis cs ON cs.id = sc.chapitre_id
    ORDER BY cs.ordre
    ");

    $livrablesRaw = DB::select("
    SELECT
    projet_id,
    statut,
    COUNT(*) as total
    FROM projet_livrables
    GROUP BY projet_id, statut
    ");

    $user = auth()->user();
    @endphp

    <!-- NAVBAR -->
    <div class="site-header">
        <div class="hdr-wrap">
            <div class="logo-wrap">
                <img src="https://lmc.ma/wp-content/uploads/2021/02/LMC-Logo.png" alt="LMC" class="logo-img"
                    onerror="this.src='data:image/svg+xml,%3Csvg xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22 width%3D%2260%22 height%3D%2230%22%3E%3Ctext x%3D%220%22 y%3D%2222%22 font-family%3D%22Inter%22 font-size%3D%2218%22 font-weight%3D%22700%22 fill%3D%22%23fff%22%3ELMC%3C%2Ftext%3E%3C%2Fsvg%3E';">
                <div>
                    <div class="logo-sub">LEAD MANAGEMENT CONSULTING</div>
                </div>
            </div>
            <div class="hdr-actions">
                <div class="user-pill"><i class="bi bi-person-circle"></i> {{ $user->name ?? 'Utilisateur' }}</div>
                <div class="meta-pill"><i class="bi bi-calendar-check"></i> {{ now()->format('d/m/Y') }}</div>
                <button class="icon-btn" id="themeToggle"><i class="bi bi-moon-fill" id="themeIcon"></i></button>
                <form method="POST" action="/logout" style="margin:0">
                    @csrf
                    <button type="button" class="icon-btn" onclick="this.closest('form').submit()"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>
        <div class="nav-wrap-outer">
            <div class="nav-wrap">
                <a href="/" class="nav-item"><i class="bi bi-table"></i> Données</a>
                <a href="/tableau-de-bord" class="nav-item active"><i class="bi bi-bar-chart"></i> Tableau de Bord</a>
                <a href="/consultants" class="nav-item"><i class="bi bi-people"></i> Consultants</a>
                <a href="/nouveau-projet" class="nav-item"><i class="bi bi-plus-circle"></i> Nouveau Projet</a>
                @if($user && $user->isSuperAdmin())
                <a href="/admin/users" class="nav-item"><i class="bi bi-shield-lock"></i> Accès</a>
                @endif
            </div>
        </div>
    </div>

    <script>
        (function() {
            const t = localStorage.getItem('lmc-theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
            const i = document.getElementById('themeIcon');
            if (i) i.className = t === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
        })();
    </script>

    <div id="app">

        <!-- PMO BANNER -->
        <div class="pmo-banner">
            <div class="banner-left">
                <div class="banner-icon">📊</div>
                <div>
                    <div class="banner-title">Tableau de Bord — Portefeuille Projets</div>
                    <div class="banner-sub">PMO · Direction Générale · Pilotage Ressources & Risques SMI</div>
                </div>
            </div>
            <div class="banner-right">
                <div class="bstat">
                    <div class="bstat-val" id="bannerTotalProjets">{{ $totalProjets }}</div>
                    <div class="bstat-lbl">Projets</div>
                </div>
                <div class="bstat">
                    <div class="bstat-val" id="bannerAvancement">{{ $avancementMoyen }}%</div>
                    <div class="bstat-lbl">Avancement</div>
                </div>
                <div class="bstat">
                    <div class="bstat-val" id="bannerChargeRestante">{{ $chargeRestante }}j</div>
                    <div class="bstat-lbl">Charge restante</div>
                </div>
                <div class="bstat">
                    <div class="bstat-val" id="bannerLivPct">{{ $livPct }}%</div>
                    <div class="bstat-lbl">Livrables OK</div>
                </div>
                <div class="banner-date">📅 {{ now()->format('M Y') }}<br>Confidentiel — COPIL</div>
            </div>
        </div>

        <!-- FILTERS -->
        <div class="filters-bar">
            <span class="filter-lbl">🔍 Filtres</span>
            <div class="filter-sep"></div>
            <select id="fStatut" onchange="applyFilters()">
                <option value="">Tous les statuts</option>
                <option>Finalisé</option>
                <option>En cours</option>
                <option>En retard</option>
                <option>Planifié</option>
            </select>
            <select id="fChef" onchange="applyFilters()">
                <option value="">Tous les chefs de projet</option>
                @foreach(collect($projets)->pluck('chef_nom')->unique()->filter() as $chef)
                <option>{{ $chef }}</option>
                @endforeach
            </select>
            <select id="fSecteur" onchange="applyFilters()">
                <option value="">Tous les secteurs</option>
                @foreach(collect($projets)->pluck('secteur_activite')->unique()->filter() as $sec)
                <option>{{ $sec }}</option>
                @endforeach
            </select>
            <div class="filter-sep"></div>
            <button class="btn-reset" onclick="resetFilters()">↺ Réinitialiser</button>
            <span id="filterCount" style="font-size:8.5px;color:var(--muted);margin-left:4px;"></span>
        </div>

       <!-- KPI ROW -->
<div class="kpi-row">
    <div class="kpi c-blue">
        <div class="kpi-icon">📁</div>
        <div class="kpi-lbl">Projets totaux</div>
        <div class="kpi-val" id="kpiTotalProjets">{{ $totalProjets }}</div>
        <div class="kpi-sub">Portefeuille actif</div>
        <span class="kpi-trend trend-flat">→ Stable</span>
    </div>

    <div class="kpi c-lblue">
        <div class="kpi-icon">📈</div>
        <div class="kpi-lbl">Avancement global</div>
        <div class="kpi-val" id="kpiAvancement">{{ $avancementMoyen }}%</div>
        <div class="kpi-sub">Moyenne pondérée</div>
        <span class="kpi-trend trend-up">↑ Cumulé</span>
    </div>

    <div class="kpi c-red">
        <div class="kpi-icon">⚠</div>
        <div class="kpi-lbl">En retard</div>
        <div class="kpi-val" id="kpiRetard">{{ $enRetard }}</div>
        <div class="kpi-sub">Action requise</div>
        <span class="kpi-trend {{ $enRetard > 0 ? 'trend-down' : 'trend-up' }}">{{ $enRetard > 0 ? '↓ Critique' : '✓ OK' }}</span>
    </div>

    <div class="kpi c-orange">
        <div class="kpi-icon">⏳</div>
        <div class="kpi-lbl">Charge restante</div>
        <div class="kpi-val" id="kpiChargeRestante">{{ $chargeRestante }}j</div>
        <div class="kpi-sub">Jours à réaliser</div>
        <span class="kpi-trend trend-flat">→ Portefeuille</span>
    </div>

    <div class="kpi c-blue">
        <div class="kpi-icon">👥</div>
        <div class="kpi-lbl">Jours internes</div>
        <div class="kpi-val" id="kpiJoursInternes">{{ $joursInternes }}j</div>
        <div class="kpi-sub">Consommés</div>
        <span class="kpi-trend trend-up">↑ Réalisé</span>
    </div>

    <div class="kpi c-purple">
        <div class="kpi-icon">🤝</div>
        <div class="kpi-lbl">Jours externes</div>
        <div class="kpi-val" id="kpiJoursExternes">{{ $joursExternes }}j</div>
        <div class="kpi-sub" id="kpiJoursExternesSub">{{ $tauxExterne }}% du total</div>
        <span class="kpi-trend trend-flat">→ Ratio ext.</span>
    </div>

    <div class="kpi c-teal">
        <div class="kpi-icon">📋</div>
        <div class="kpi-lbl">Livrables terminés</div>
        <div class="kpi-val" id="kpiLivTermines">{{ $livStats->termines ?? 0 }}</div>
        <div class="kpi-sub" id="kpiLivSub">/ {{ $livStats->total ?? 0 }} total</div>
        <span class="kpi-trend trend-up">↑ {{ $livPct }}%</span>
    </div>

    <div class="kpi c-green">
        <div class="kpi-icon">💡</div>
        <div class="kpi-lbl">Taux consommation</div>
        <div class="kpi-val" id="kpiConso">{{ $consoGlobale }}%</div>
        <div class="kpi-sub">Réalisés / prévus</div>
        <span class="kpi-trend {{ $consoGlobale > 100 ? 'trend-down' : 'trend-up' }}">{{ $consoGlobale > 100 ? '↓ Dépassé' : '↑ OK' }}</span>
    </div>
</div>

        <!-- ROW 2 : PORTEFEUILLE -->
        <div class="sl sl-port">Pilotage Portefeuille</div>
        <div class="row3 c3a">
            <div class="card">
                <div class="ctitle">Répartition par Statut <span class="cbadge" id="donutBadge">{{ $totalProjets }} projets</span></div>
                <div class="donut-wrap">
                    <div class="donut-box">
                        <canvas id="donutStatut"></canvas>
                        <div class="donut-center">
                            <div class="dc-n">{{ $totalProjets }}</div>
                            <div class="dc-l">Projets</div>
                        </div>
                    </div>
                    <div class="legend">
                        <div class="leg"><span class="leg-dot" style="background:#10B981"></span><span class="leg-lbl">Finalisé</span><span class="leg-val" id="legFinalises">{{ $finalises }}</span></div>
<div class="leg"><span class="leg-dot" style="background:#2563EB"></span><span class="leg-lbl">En cours</span><span class="leg-val" id="legEnCours">{{ $enCours }}</span></div>
<div class="leg"><span class="leg-dot" style="background:#EF4444"></span><span class="leg-lbl">En retard</span><span class="leg-val" id="legEnRetard">{{ $enRetard }}</span></div>
<div class="leg"><span class="leg-dot" style="background:#8B5CF6"></span><span class="leg-lbl">Planifié</span><span class="leg-val" id="legPlanifies">{{ $planifies }}</span></div>
                    </div>
                </div>
            </div>

            <div class="card">
    <div class="ctitle">Avancement par Client <span class="cbadge">% réalisation</span></div>

    <div id="avancementClientBody">
        @foreach($projets as $p)
        @php
            $bg = $p->statut === 'Finalisé' ? 'linear-gradient(90deg,#10B981,#34D399)' :
                 ($p->statut === 'En retard' ? 'linear-gradient(90deg,#EF4444,#F87171)' :
                 ($p->avancement_percent >= 50 ? 'linear-gradient(90deg,#2563EB,#60A5FA)' :
                  'linear-gradient(90deg,#F59E0B,#FCD34D)'));
        @endphp
        <div class="bar-row">
            <span class="bar-lbl" title="{{ $p->nom_client }}">{{ Str::limit($p->nom_client, 11) }}</span>
            <div class="bar-track">
                <div class="bar-fill" style="width:{{ max(1,$p->avancement_percent) }}%;background:{{ $bg }};">
                    @if($p->avancement_percent >= 15)<span class="bar-pct">{{ $p->avancement_percent }}%</span>@endif
                </div>
            </div>
            @if($p->avancement_percent < 15)<span class="bar-ext">{{ $p->avancement_percent }}%</span>@endif
        </div>
        @endforeach
    </div>
</div>

            <div class="card">
                <div class="ctitle">Jours Prévus vs Réalisés <span class="cbadge">par projet</span></div>
                <div style="position:relative;height:185px"><canvas id="chartJours"></canvas></div>
                <div style="display:flex;gap:10px;margin-top:6px;justify-content:center;">
                    <span style="display:flex;align-items:center;gap:4px;font-size:8.5px;color:var(--muted)"><span class="leg-dot-jours" style="width:9px;height:9px;background:#CBD5E1;border-radius:2px;display:inline-block;"></span>Prévu</span>
                    <span style="display:flex;align-items:center;gap:4px;font-size:8.5px;color:var(--muted)"><span class="leg-dot-jours" style="width:9px;height:9px;background:#0EA5E9;border-radius:2px;display:inline-block;"></span>Réalisé</span>
                </div>
            </div>
        </div>

        <!-- ROW 3 : RESSOURCES -->
        <div class="sl sl-res">Pilotage Ressources</div>
        <div class="row3 c3b">
            <div class="card">
                <div class="ctitle">Charge Int. vs Ext. <span class="cbadge">{{ $totalJoursConsultants }}j</span></div>
                <div class="donut-wrap">
                    <div class="donut-box">
                        <canvas id="donutRessources"></canvas>
                        <div class="donut-center">
                            <div class="dc-n" style="font-size:13px" id="donutRessourcesCenter">{{ 100-$tauxExterne }}/{{ $tauxExterne }}</div>
                            <div class="dc-l">Int / Ext %</div>
                        </div>
                    </div>
                    <div class="legend">
                        <div class="leg"><span class="leg-dot leg-dot-res" style="background:#0EA5E9"></span><span class="leg-lbl">Interne</span><span class="leg-val" id="legInterne">{{ $joursInternes }}j · {{ 100-$tauxExterne }}%</span></div>
                        <div class="leg"><span class="leg-dot leg-dot-res" style="background:#F59E0B"></span><span class="leg-lbl">Externe</span><span class="leg-val" id="legExterne">{{ $joursExternes }}j · {{ $tauxExterne }}%</span></div>
                    </div>
                </div>
            </div>

            <div class="card">
    <div class="ctitle">Jours / Consultant <span class="cbadge">consommés</span></div>

    <div id="consultantBarsBody">
        @foreach($consultants as $c)
        @php
            $pct = $maxConsultant > 0 ? round(($c->total_realises / $maxConsultant) * 100) : 0;
            $cg = $c->type_consultant !== 'Interne'
                ? 'linear-gradient(90deg,#8B5CF6,#A78BFA)'
                : 'linear-gradient(90deg,#2563EB,#60A5FA)';
        @endphp
        <div class="bar-row">
            <span class="bar-lbl" title="{{ $c->nom_complet }}">{{ Str::limit(explode(' ', $c->nom_complet)[0], 11) }}</span>
            <div class="bar-track">
                <div class="bar-fill" style="width:{{ max(2,$pct) }}%;background:{{ $cg }};">
                    @if($c->total_realises > 0)
                        <span class="bar-pct">{{ $c->total_realises }}j</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div style="display:flex;gap:8px;margin-top:6px;font-size:8px;color:var(--muted);">
        <span style="color:#0EA5E9;font-weight:700">■</span> Interne &nbsp;
        <span style="color:#F59E0B;font-weight:700">■</span> Externe
    </div>
</div>

            <div class="card">
                <div class="ctitle">Charge / Consultant <span class="cbadge">jours réalisés</span></div>
                <div style="position:relative;height:160px"><canvas id="chartExt"></canvas></div>
            </div>
        </div>

        <!-- ROW 4 : SMI -->
        <div class="sl sl-smi">Pilotage SMI — Livrables & Formations</div>
        <div class="row3 c3c">
            <div class="card">
                <div class="ctitle">Avancement Chapitres SMI <span class="cbadge">{{ count($chapitres) }} chapitres</span></div>
                <div id="chapitresSmiBody">
    @foreach($chapitres as $chap)
    @php
        $p = $chap->avg_pct;
        $fc = $p >= 100 ? '#10B981' : ($p >= 50 ? '#2563EB' : ($p > 0 ? '#F59E0B' : '#E2E8F0'));
    @endphp
    <div class="smi-row">
        <span class="smi-lbl" title="{{ $chap->code_chapitre }} — {{ $chap->titre_chapitre }}">{{ $chap->code_chapitre }} — {{ Str::limit($chap->titre_chapitre,18) }}</span>
        <div class="smi-track">
            <div class="smi-fill" style="width:{{ max(1,$p) }}%;background:{{ $fc }};">
                @if($p >= 18)<span style="font-size:7.5px;font-weight:700;color:#fff;">{{ $p }}%</span>@endif
            </div>
        </div>
        @if($p < 18)<span class="smi-pct-ext">{{ $p }}%</span>@endif
    </div>
    @endforeach
</div>
            </div>

            <div class="card">
                <div class="ctitle">État des Formations <span class="cbadge" id="formationsCountBadge">{{ count($formations) }} projets</span></div>
                <div id="formationsBody">
    @foreach($formations as $f)
    @php
        $fp = $f->total > 0 ? round(($f->ok / $f->total) * 100) : 0;
        $fc2 = $fp >= 100 ? '#10B981' : ($fp >= 50 ? '#2563EB' : ($fp > 0 ? '#F59E0B' : '#E2E8F0'));
    @endphp
    <div class="smi-row">
        <span class="smi-lbl" title="{{ $f->nom_client }}">{{ Str::limit($f->nom_client, 22) }}</span>
        <div class="smi-track">
            <div class="smi-fill" style="width:{{ max(1,$fp) }}%;background:{{ $fc2 }};">
                @if($fp >= 18)<span style="font-size:7.5px;font-weight:700;color:#fff;">{{ $f->ok }}/{{ $f->total }}</span>@endif
            </div>
        </div>
        @if($fp < 18)<span class="smi-pct-ext">{{ $f->ok }}/{{ $f->total }}</span>@endif
    </div>
    @endforeach
</div>

                <div style="margin-top:12px;padding-top:10px;border-top:1px solid var(--border);">
                    <div style="font-size:9px;font-weight:700;color:var(--text);text-transform:uppercase;letter-spacing:.4px;margin-bottom:8px;">
                        Livrables globaux <span class="cbadge" id="livStatsBadge">{{ $livStats->termines }}/{{ $livStats->total }}</span>
                    </div>
                    @php $ecPct = ($livStats->total > 0) ? round(($livStats->en_cours / $livStats->total) * 100) : 0; @endphp
                    <div class="smi-row">
                        <span class="smi-lbl">Terminés</span>
                        <div class="smi-track">
                            <div class="smi-fill" id="livTerminesFill" style="width:{{ $livPct }}%;background:#10B981;">
                                @if($livPct >= 18)<span style="font-size:7.5px;font-weight:700;color:#fff;">{{ $livPct }}%</span>@endif
                            </div>
                        </div>
                        @if($livPct < 18)<span class="smi-pct-ext" id="livPctText" style="color:#10B981;">{{ $livPct }}%</span>@endif
                    </div>
                    <div class="smi-row">
                        <span class="smi-lbl">En cours</span>
                        <div class="smi-track">
                            <div class="smi-fill" id="livEnCoursFill" style="width:{{ max(1,$ecPct) }}%;background:#F59E0B;">
                                @if($ecPct >= 18)<span style="font-size:7.5px;font-weight:700;color:#fff;">{{ $ecPct }}%</span>@endif
                            </div>
                        </div>
                        @if($ecPct < 18)<span class="smi-pct-ext" id="livEnCoursText" style="color:#F59E0B;">{{ $ecPct }}%</span>@endif
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="ctitle">Santé Projets <span class="cbadge">{{ $totalProjets }} projets</span></div>
                <table class="hm-table">
                    <thead>
                        <tr>
                            <th style="text-align:left">Client</th>
                            <th>Planning</th>
                            <th>Budget</th>
                            <th>Risque</th>
                        </tr>
                    </thead>
                    <tbody id="heatmapBody">
                        @foreach($projets as $p)
                        @php
                        $ec = $p->jours_realises - $p->jours_prevus;
                        $planClass = $p->statut === 'En retard' ? 'hm-r' : ($p->avancement_percent > 0 ? 'hm-g' : 'hm-gr');
                        $budgClass = $ec > 5 ? 'hm-r' : ($ec > 0 ? 'hm-o' : 'hm-g');
                        $riskClass = $p->statut === 'En retard' ? 'hm-r' : ($p->statut === 'En cours' && $p->avancement_percent < 30 ? 'hm-o' : ($p->statut === 'Planifié' ? 'hm-gr' : 'hm-g'));
                            @endphp
                            <tr>
                                <td>
                                    <div class="proj-id"><a href="/projet/{{ $p->id }}" style="color:var(--blue);text-decoration:none;">{{ Str::limit($p->nom_client, 10) }}</a></div>
                                    <div class="proj-nm">{{ $p->reference_projet }}</div>
                                </td>
                                <td><span class="hm-cell {{ $planClass }}">{{ $p->statut === 'En retard' ? '✗ Retard' : ($p->avancement_percent > 0 ? '✓ OK' : '— N/D') }}</span></td>
                                <td><span class="hm-cell {{ $budgClass }}">{{ $ec > 5 ? '✗ Dépass.' : ($ec > 0 ? '⚡ Risque' : '✓ OK') }}</span></td>
                                <td><span class="hm-cell {{ $riskClass }}">{{ $p->statut === 'En retard' ? '✗ Élevé' : ($riskClass === 'hm-o' ? '⚡ Moyen' : ($riskClass === 'hm-gr' ? '— Faible' : '✓ Faible')) }}</span></td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ROW 5 : TABLE -->
        <div class="sl sl-table">Tableau Détaillé Portefeuille</div>
        <div class="card">
            <div class="ctitle">
                Vue Détaillée — Tous les Projets
                <span class="cbadge" id="rowCount">{{ $totalProjets }} lignes</span>
            </div>
            <div class="dt-wrap">
                <table class="dt">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Réf.</th>
                            <th>Chef de Projet</th>
                            <th>Statut</th>
                            <th>Normes</th>
                            <th style="text-align:right">J. Prévus</th>
                            <th style="text-align:right">J. Réalisés</th>
                            <th>Avancement</th>
                            <th style="text-align:right">Restants</th>
                            <th>Performance</th>
                        </tr>
                    </thead>
                    <tbody id="detailBody">
                        @foreach($projets as $p)
                        @php
                        $sc = match($p->statut) { 'Finalisé'=>'s-comp','En retard'=>'s-del','En cours'=>'s-prog','En pause'=>'s-pause',default=>'s-plan' };
                        $restant = max(0, $p->jours_prevus - $p->jours_realises);
                        $conso = $p->jours_prevus > 0 ? round(($p->jours_realises / $p->jours_prevus) * 100) : 0;
                        $perf = $p->statut === 'Finalisé' ? ['c'=>'#10B981','l'=>'Dans les temps'] :
                        ($p->statut === 'En retard' ? ['c'=>'#EF4444','l'=>'Critique'] :
                        ($p->avancement_percent >= 50 ? ['c'=>'#10B981','l'=>'Dans les temps'] :
                        ($p->avancement_percent > 0 ? ['c'=>'#F59E0B','l'=>'À surveiller'] : ['c'=>'#CBD5E1','l'=>'Non démarré'])));
                        $normes = $normesParProjet[$p->id] ?? [];
                        $pbColor = $p->avancement_percent === 100 ? '#10B981' : ($p->avancement_percent > 25 ? '#2563EB' : '#60A5FA');
                        @endphp
                        <tr data-statut="{{ $p->statut }}" data-chef="{{ $p->chef_nom }}" data-secteur="{{ $p->secteur_activite }}">
                            <td><a href="/projet/{{ $p->id }}" style="font-weight:700;color:var(--blue);text-decoration:none;font-size:11px;">{{ $p->nom_client }}</a></td>
                            <td><span style="font-size:8.5px;color:var(--muted);background:var(--bg);padding:1px 6px;border-radius:4px;font-weight:600;">{{ $p->reference_projet }}</span></td>
                            <td style="font-size:10px;">{{ $p->chef_nom ?? '—' }}</td>
                            <td><span class="sbadge {{ $sc }}">{{ $p->statut }}</span></td>
                            <td>@foreach($normes as $n)<span class="ntag">{{ preg_replace('/ISO\s?/','', $n) }}</span>@endforeach</td>
                            <td style="text-align:right;font-weight:700;">{{ $p->jours_prevus }}</td>
                            <td style="text-align:right;font-weight:700;color:{{ $conso > 100 ? '#EF4444' : 'inherit' }};">{{ $p->jours_realises }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:4px;">
                                    <div class="pb">
                                        <div class="pb-f" style="width:{{ $p->avancement_percent }}%;background:{{ $pbColor }};"></div>
                                    </div>
                                    <strong style="font-size:10px;">{{ $p->avancement_percent }}%</strong>
                                </div>
                            </td>
                            <td style="text-align:right;font-weight:700;color:var(--muted);">{{ $restant }}j</td>
                            <td><span class="pdot" style="background:{{ $perf['c'] }};"></span><span style="font-size:9.5px;">{{ $perf['l'] }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="color:var(--blue);">⊞ TOTAUX PORTEFEUILLE</td>
                            <td style="text-align:right;">{{ $totalPrevus }}</td>
                            <td style="text-align:right;color:{{ $totalEcart > 5 ? '#EF4444' : 'inherit' }};">{{ $totalRealises }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:4px;">
                                    <div class="pb">
                                        <div class="pb-f" style="width:{{ $avancementMoyen }}%;background:#2563EB;"></div>
                                    </div>
                                    <strong>{{ $avancementMoyen }}%</strong>
                                </div>
                            </td>
                            <td style="text-align:right;">{{ $chargeRestante }}j</td>
                            <td style="color:{{ $totalEcart >= 0 ? '#EF4444' : '#10B981' }};font-size:10px;">Écart: {{ $totalEcart > 0 ? '+' : '' }}{{ $totalEcart }}j</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="pmo-footer">
            <div class="footer-logo">◆ LMC Conseil — PMO Dashboard</div>
            <div>Données au {{ now()->format('d M Y') }} · Usage interne confidentiel · Comité de Pilotage</div>
            <div style="display:flex;gap:5px;"><span class="ftag">SMI</span><span class="ftag">ISO 9001/14001/45001</span><span class="ftag">v3.0</span></div>
        </div>

    </div>

   <script>
// ── Theme ──
document.getElementById('themeToggle')?.addEventListener('click', () => {
    const next = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('lmc-theme', next);
    document.getElementById('themeIcon').className = next === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
    setTimeout(() => location.reload(), 80);
});

// ── DATASETS ──
const ALL_PROJETS = {!! json_encode(collect($projets)->map(function($p) {
    return [
        'id'       => $p->id,
        'client'   => $p->nom_client,
        'reference'=> $p->reference_projet,
        'statut'   => $p->statut,
        'chef'     => $p->chef_nom ?? '',
        'secteur'  => $p->secteur_activite ?? '',
        'prevus'   => (int) $p->jours_prevus,
        'realises' => (int) $p->jours_realises,
        'avanct'   => (int) $p->avancement_percent,
        'normes'   => $normesParProjet[$p->id] ?? [],
    ];
})->values()) !!};

const ALL_AFFECTATIONS = {!! json_encode(collect($affectationsRaw)->map(function($a) {
    return [
        'projet_id' => (int) $a->projet_id,
        'consultant_id' => (int) $a->consultant_id,
        'nom' => $a->nom_complet,
        'type' => $a->type_consultant,
        'jours_realises' => (float) $a->jours_realises,
        'jours_alloues' => (float) $a->jours_alloues,
    ];
})->values()) !!};

const ALL_CHAPITRES_RAW = {!! json_encode(collect($chapitresRaw)->map(function($c) {
    return [
        'projet_id' => (int) $c->projet_id,
        'code' => $c->code_chapitre,
        'titre' => $c->titre_chapitre,
        'avg_pct' => (int) $c->avancement_percent,
        'total_jours' => (float) $c->jours_intervention,
    ];
})->values()) !!};

const ALL_FORMATIONS = {!! json_encode(collect($formations)->map(function($f) {
    return [
        'projet_id' => (int) $f->projet_id,
        'nom_client' => $f->nom_client,
        'total' => (int) $f->total,
        'ok' => (int) $f->ok,
    ];
})->values()) !!};

const ALL_LIVRABLES = {!! json_encode(collect($livrablesRaw)->map(function($l) {
    return [
        'projet_id' => (int) $l->projet_id,
        'statut' => $l->statut,
        'total' => (int) $l->total,
    ];
})->values()) !!};

// ── GLOBALS ──
let chartJoursInst = null;
let chartExtInst = null;
let donutStatutInst = null;
let donutRessourcesInst = null;

// ── UI COLORS ──
const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
const gc  = isDark ? '#1e293b' : '#F1F5F9';
const tc  = isDark ? '#64748b' : '#9CA3AF';
const def = { responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false } } };

const COLORS = {
    prevu:   isDark ? '#334155' : '#CBD5E1',
    realise: '#0EA5E9',
    fin:     '#10B981',
    retard:  '#EF4444',
    cours:   '#0EA5E9',
    planifie:'#8B5CF6',
    interne: '#0EA5E9',
    externe: '#F59E0B'
};

// ── HELPERS ──
const esc = (v) => String(v ?? '')
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');

const short = (v, n = 10) => {
    const s = String(v ?? '');
    return s.length > n ? s.slice(0, n) + '…' : s;
};

function getFilters() {
    return {
        statut: document.getElementById('fStatut')?.value || '',
        chef: document.getElementById('fChef')?.value || '',
        secteur: document.getElementById('fSecteur')?.value || ''
    };
}

function filterProjects(filters) {
    return ALL_PROJETS.filter(p =>
        (!filters.statut || p.statut === filters.statut) &&
        (!filters.chef || p.chef === filters.chef) &&
        (!filters.secteur || p.secteur === filters.secteur)
    );
}

function projectIds(rows) {
    return rows.map(r => r.id);
}

function sum(arr, key) {
    return arr.reduce((s, x) => s + (parseFloat(x[key]) || 0), 0);
}

function avg(arr, key) {
    return arr.length ? Math.round(sum(arr, key) / arr.length) : 0;
}

function byProjectIds(rows, ids, key = 'projet_id') {
    const set = new Set(ids);
    return rows.filter(r => set.has(r[key]));
}

function groupConsultants(ids) {
    const rows = byProjectIds(ALL_AFFECTATIONS, ids);
    const map = new Map();

    rows.forEach(r => {
        if (!map.has(r.consultant_id)) {
            map.set(r.consultant_id, {
                consultant_id: r.consultant_id,
                nom: r.nom,
                type: r.type,
                total_realises: 0,
                total_alloues: 0,
                nb_projets: 0,
                projets: new Set()
            });
        }
        const item = map.get(r.consultant_id);
        item.total_realises += Number(r.jours_realises || 0);
        item.total_alloues += Number(r.jours_alloues || 0);
        item.projets.add(r.projet_id);
    });

    return Array.from(map.values()).map(x => ({
        ...x,
        nb_projets: x.projets.size
    })).sort((a,b) => b.total_realises - a.total_realises);
}

function groupChapitres(ids) {
    const rows = byProjectIds(ALL_CHAPITRES_RAW, ids);
    const map = new Map();

    rows.forEach(r => {
        const key = r.code;
        if (!map.has(key)) {
            map.set(key, {
                code: r.code,
                titre: r.titre,
                total_pct: 0,
                total_jours: 0,
                count: 0
            });
        }
        const item = map.get(key);
        item.total_pct += Number(r.avg_pct || 0);
        item.total_jours += Number(r.total_jours || 0);
        item.count += 1;
    });

    return Array.from(map.values()).map(x => ({
        code: x.code,
        titre: x.titre,
        avg_pct: x.count ? Math.round(x.total_pct / x.count) : 0,
        total_jours: x.total_jours
    }));
}

function groupFormations(ids) {
    return byProjectIds(ALL_FORMATIONS, ids).sort((a,b) => a.nom_client.localeCompare(b.nom_client));
}

function groupLivrables(ids) {
    const rows = byProjectIds(ALL_LIVRABLES, ids);
    const total = rows.reduce((s,r) => s + r.total, 0);
    const termines = rows.filter(r => r.statut === 'Terminé').reduce((s,r) => s + r.total, 0);
    const enCours = rows.filter(r => r.statut === 'En cours').reduce((s,r) => s + r.total, 0);
    return {
        total,
        termines,
        enCours,
        pct: total > 0 ? Math.round((termines / total) * 100) : 0,
        pctEnCours: total > 0 ? Math.round((enCours / total) * 100) : 0
    };
}

function projectStats(rows) {
    const total = rows.length;
    const finalises = rows.filter(p => p.statut === 'Finalisé').length;
    const enCours = rows.filter(p => p.statut === 'En cours').length;
    const enRetard = rows.filter(p => p.statut === 'En retard').length;
    const planifies = rows.filter(p => p.statut === 'Planifié' || p.statut === 'En pause').length;
    const prevus = sum(rows, 'prevus');
    const realises = sum(rows, 'realises');
    const avancement = avg(rows, 'avanct');
    const chargeRestante = Math.max(0, prevus - realises);
    const ecart = realises - prevus;
    const conso = prevus > 0 ? Math.round((realises / prevus) * 100) : 0;

    return { total, finalises, enCours, enRetard, planifies, prevus, realises, avancement, chargeRestante, ecart, conso };
}

function consultantStats(cons) {
    const joursInternes = cons.filter(c => c.type === 'Interne').reduce((s,c) => s + c.total_realises, 0);
    const joursExternes = cons.filter(c => c.type !== 'Interne').reduce((s,c) => s + c.total_realises, 0);
    const total = joursInternes + joursExternes;
    const tauxExterne = total > 0 ? Math.round((joursExternes / total) * 100) : 0;
    const maxConsultant = cons.length ? Math.max(...cons.map(c => c.total_realises)) : 1;
    return { joursInternes, joursExternes, total, tauxExterne, maxConsultant };
}

// ── UPDATE UI ──
function setText(id, value) {
    const el = document.getElementById(id);
    if (el) el.textContent = value;
}

function updateBanner(stats, liv) {
    setText('bannerTotalProjets', stats.total);
    setText('bannerAvancement', stats.avancement + '%');
    setText('bannerChargeRestante', stats.chargeRestante + 'j');
    setText('bannerLivPct', liv.pct + '%');
}

function updateKpis(stats, consStats, liv) {
    setText('kpiTotalProjets', stats.total);
    setText('kpiAvancement', stats.avancement + '%');
    setText('kpiRetard', stats.enRetard);
    setText('kpiChargeRestante', stats.chargeRestante + 'j');
    setText('kpiJoursInternes', Math.round(consStats.joursInternes) + 'j');
    setText('kpiJoursExternes', Math.round(consStats.joursExternes) + 'j');
    setText('kpiLivTermines', liv.termines);
    setText('kpiConso', stats.conso + '%');
    setText('kpiJoursExternesSub', consStats.tauxExterne + '% du total');
    setText('kpiLivSub', '/ ' + liv.total + ' total');
}

function updateDonutStatut(stats) {
    if (!donutStatutInst) return;
    donutStatutInst.data.datasets[0].data = [
        stats.finalises,
        stats.enCours,
        stats.enRetard,
        stats.planifies
    ];
    donutStatutInst.update('active');

    setText('legFinalises', stats.finalises);
    setText('legEnCours', stats.enCours);
    setText('legEnRetard', stats.enRetard);
    setText('legPlanifies', stats.planifies);
    setText('donutBadge', stats.total + ' projets');

    const center = document.querySelector('.dc-n');
    if (center) center.textContent = stats.total;
}

function updateAvancementClient(rows) {
    const box = document.getElementById('avancementClientBody');
    if (!box) return;

    if (!rows.length) {
        box.innerHTML = `<div style="font-size:10px;color:var(--muted);padding:12px 0;">Aucun projet</div>`;
        return;
    }

    box.innerHTML = rows.map(p => {
        const bg = p.statut === 'Finalisé'
            ? 'linear-gradient(90deg,#10B981,#34D399)'
            : (p.statut === 'En retard'
                ? 'linear-gradient(90deg,#EF4444,#F87171)'
                : (p.avanct >= 50
                    ? 'linear-gradient(90deg,#2563EB,#60A5FA)'
                    : 'linear-gradient(90deg,#F59E0B,#FCD34D)'));

        return `
            <div class="bar-row">
                <span class="bar-lbl" title="${esc(p.client)}">${esc(short(p.client, 11))}</span>
                <div class="bar-track">
                    <div class="bar-fill" style="width:${Math.max(1,p.avanct)}%;background:${bg};">
                        ${p.avanct >= 15 ? `<span class="bar-pct">${p.avanct}%</span>` : ``}
                    </div>
                </div>
                ${p.avanct < 15 ? `<span class="bar-ext">${p.avanct}%</span>` : ``}
            </div>
        `;
    }).join('');
}

function updateChartJours(rows) {
    if (!chartJoursInst) return;
    chartJoursInst.data.labels = rows.map(p => short(p.client, 9));
    chartJoursInst.data.datasets[0].data = rows.map(p => p.prevus);
    chartJoursInst.data.datasets[1].data = rows.map(p => p.realises);
    chartJoursInst.update('active');
}

function updateDonutRessources(consStats) {
    if (!donutRessourcesInst) return;
    donutRessourcesInst.data.datasets[0].data = [
        Math.round(consStats.joursInternes),
        Math.round(consStats.joursExternes)
    ];
    donutRessourcesInst.update('active');

    setText('donutRessourcesCenter', `${100 - consStats.tauxExterne}/${consStats.tauxExterne}`);
    setText('legInterne', `${Math.round(consStats.joursInternes)}j · ${100 - consStats.tauxExterne}%`);
    setText('legExterne', `${Math.round(consStats.joursExternes)}j · ${consStats.tauxExterne}%`);
}

function updateConsultantBars(cons, consStats) {
    const box = document.getElementById('consultantBarsBody');
    if (!box) return;

    if (!cons.length) {
        box.innerHTML = `<div style="font-size:10px;color:var(--muted);padding:12px 0;">Aucun consultant lié aux projets filtrés</div>`;
    } else {
        box.innerHTML = cons.map(c => {
            const pct = consStats.maxConsultant > 0 ? Math.round((c.total_realises / consStats.maxConsultant) * 100) : 0;
            const cg = c.type !== 'Interne'
                ? 'linear-gradient(90deg,#8B5CF6,#A78BFA)'
                : 'linear-gradient(90deg,#2563EB,#60A5FA)';

            return `
                <div class="bar-row">
                    <span class="bar-lbl" title="${esc(c.nom)}">${esc(short((c.nom || '').split(' ')[0], 11))}</span>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:${Math.max(2,pct)}%;background:${cg};">
                            ${c.total_realises > 0 ? `<span class="bar-pct">${Math.round(c.total_realises)}j</span>` : ``}
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    if (chartExtInst) {
        chartExtInst.data.labels = cons.map(c => short((c.nom || '').split(' ')[0], 9));
        chartExtInst.data.datasets[0].data = cons.map(c => Math.round(c.total_realises));
        chartExtInst.data.datasets[0].backgroundColor = cons.map(c => c.type !== 'Interne' ? '#F59E0B' : '#0EA5E9');
        chartExtInst.update('active');
    }
}

function updateChapitres(chaps) {
    const box = document.getElementById('chapitresSmiBody');
    if (!box) return;

    if (!chaps.length) {
        box.innerHTML = `<div style="font-size:10px;color:var(--muted);padding:12px 0;">Aucun chapitre pour ce filtre</div>`;
        return;
    }

    box.innerHTML = chaps.map(chap => {
        const p = chap.avg_pct;
        const fc = p >= 100 ? '#10B981' : (p >= 50 ? '#2563EB' : (p > 0 ? '#F59E0B' : '#E2E8F0'));
        return `
            <div class="smi-row">
                <span class="smi-lbl" title="${esc(chap.code)} — ${esc(chap.titre)}">${esc(chap.code)} — ${esc(short(chap.titre, 18))}</span>
                <div class="smi-track">
                    <div class="smi-fill" style="width:${Math.max(1,p)}%;background:${fc};">
                        ${p >= 18 ? `<span style="font-size:7.5px;font-weight:700;color:#fff;">${p}%</span>` : ``}
                    </div>
                </div>
                ${p < 18 ? `<span class="smi-pct-ext">${p}%</span>` : ``}
            </div>
        `;
    }).join('');
}

function updateFormations(forms, liv) {
    const box = document.getElementById('formationsBody');
    if (!box) return;

    setText('formationsCountBadge', `${forms.length} projets`);

    if (!forms.length) {
        box.innerHTML = `<div style="font-size:10px;color:var(--muted);padding:12px 0;">Aucun plan de formation pour ce filtre</div>`;
    } else {
        box.innerHTML = forms.map(f => {
            const fp = f.total > 0 ? Math.round((f.ok / f.total) * 100) : 0;
            const fc2 = fp >= 100 ? '#10B981' : (fp >= 50 ? '#2563EB' : (fp > 0 ? '#F59E0B' : '#E2E8F0'));
            return `
                <div class="smi-row">
                    <span class="smi-lbl" title="${esc(f.nom_client)}">${esc(short(f.nom_client, 22))}</span>
                    <div class="smi-track">
                        <div class="smi-fill" style="width:${Math.max(1,fp)}%;background:${fc2};">
                            ${fp >= 18 ? `<span style="font-size:7.5px;font-weight:700;color:#fff;">${f.ok}/${f.total}</span>` : ``}
                        </div>
                    </div>
                    ${fp < 18 ? `<span class="smi-pct-ext">${f.ok}/${f.total}</span>` : ``}
                </div>
            `;
        }).join('');
    }

    setText('livStatsBadge', `${liv.termines}/${liv.total}`);
    setText('livPctText', `${liv.pct}%`);
    setText('livEnCoursText', `${liv.pctEnCours}%`);

    const termFill = document.getElementById('livTerminesFill');
    const encFill = document.getElementById('livEnCoursFill');
    if (termFill) termFill.style.width = `${liv.pct}%`;
    if (encFill) encFill.style.width = `${Math.max(1, liv.pctEnCours)}%`;
}

function updateHeatmap(rows) {
    const body = document.getElementById('heatmapBody');
    if (!body) return;

    if (!rows.length) {
        body.innerHTML = `<tr><td colspan="4" style="padding:14px;color:var(--muted);text-align:center;">Aucun projet</td></tr>`;
        return;
    }

    body.innerHTML = rows.map(p => {
        const ec = p.realises - p.prevus;
        const planClass  = p.statut === 'En retard' ? 'hm-r' : (p.avanct > 0 ? 'hm-g' : 'hm-gr');
        const budgClass  = ec > 5 ? 'hm-r' : (ec > 0 ? 'hm-o' : 'hm-g');
        const riskClass  = p.statut === 'En retard' ? 'hm-r' : (p.statut === 'En cours' && p.avanct < 30 ? 'hm-o' : (p.statut === 'Planifié' ? 'hm-gr' : 'hm-g'));

        const planText = p.statut === 'En retard' ? '✗ Retard' : (p.avanct > 0 ? '✓ OK' : '— N/D');
        const budgetText = ec > 5 ? '✗ Dépass.' : (ec > 0 ? '⚡ Risque' : '✓ OK');
        const riskText = p.statut === 'En retard' ? '✗ Élevé' : (riskClass === 'hm-o' ? '⚡ Moyen' : (riskClass === 'hm-gr' ? '— Faible' : '✓ Faible'));

        return `
            <tr>
                <td>
                    <div class="proj-id"><a href="/projet/${p.id}" style="color:var(--blue);text-decoration:none;">${esc(short(p.client, 10))}</a></div>
                    <div class="proj-nm">${esc(p.reference)}</div>
                </td>
                <td><span class="hm-cell ${planClass}">${planText}</span></td>
                <td><span class="hm-cell ${budgClass}">${budgetText}</span></td>
                <td><span class="hm-cell ${riskClass}">${riskText}</span></td>
            </tr>
        `;
    }).join('');
}

function updateTable(rows, stats) {
    const allRows = document.querySelectorAll('#detailBody tr');
    const ids = new Set(rows.map(r => String(r.id)));
    let visible = 0;

    allRows.forEach(row => {
        const href = row.querySelector('a')?.getAttribute('href') || '';
        const match = href.match(/\/projet\/(\d+)/);
        const id = match ? match[1] : null;
        const ok = id && ids.has(id);
        row.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });

    setText('rowCount', `${visible} ligne(s)`);
    setText('tfootPrevus', Math.round(stats.prevus));
    setText('tfootRealises', Math.round(stats.realises));
    setText('tfootAvancement', `${stats.avancement}%`);
    setText('tfootRestants', `${stats.chargeRestante}j`);

    const tfootEcart = document.getElementById('tfootEcart');
    if (tfootEcart) {
        tfootEcart.textContent = `Écart: ${stats.ecart > 0 ? '+' : ''}${Math.round(stats.ecart)}j`;
        tfootEcart.style.color = stats.ecart >= 0 ? '#EF4444' : '#10B981';
    }
}

function applyFilters() {
    const filters = getFilters();
    const filteredProjects = filterProjects(filters);
    const ids = projectIds(filteredProjects);

    const stats = projectStats(filteredProjects);
    const consultants = groupConsultants(ids);
    const consStats = consultantStats(consultants);
    const chapitres = groupChapitres(ids);
    const formations = groupFormations(ids);
    const liv = groupLivrables(ids);

    updateBanner(stats, liv);
    updateKpis(stats, consStats, liv);
    updateDonutStatut(stats);
    updateAvancementClient(filteredProjects);
    updateChartJours(filteredProjects);
    updateDonutRessources(consStats);
    updateConsultantBars(consultants, consStats);
    updateChapitres(chapitres);
    updateFormations(formations, liv);
    updateHeatmap(filteredProjects);
    updateTable(filteredProjects, stats);

    const fc = document.getElementById('filterCount');
    if (fc) {
        fc.textContent = (filters.statut || filters.chef || filters.secteur)
            ? `→ ${filteredProjects.length} résultat(s)`
            : '';
    }
}

function resetFilters() {
    ['fStatut','fChef','fSecteur'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    applyFilters();
}

// ── Setup Charts ──
donutStatutInst = new Chart(document.getElementById('donutStatut'), {
    type:'doughnut',
    data:{
        labels:['Finalisé','En cours','En retard','Planifié'],
        datasets:[{
            data:[{{ $finalises }},{{ $enCours }},{{ $enRetard }},{{ $planifies }}],
            backgroundColor:[COLORS.fin, COLORS.cours, COLORS.retard, COLORS.planifie],
            borderWidth: isDark ? 2 : 3,
            borderColor: isDark ? '#1e293b' : '#ffffff',
            hoverOffset:6
        }]
    },
    options:{ ...def, cutout:'65%', plugins:{ legend:{display:false}, tooltip:{ callbacks:{ label: c => ` ${c.label}: ${c.raw} projet(s)` } } } }
});

donutRessourcesInst = new Chart(document.getElementById('donutRessources'), {
    type:'doughnut',
    data:{
        labels:['Interne','Externe'],
        datasets:[{
            data:[{{ $joursInternes }},{{ $joursExternes }}],
            backgroundColor:[COLORS.interne, COLORS.externe],
            borderWidth: isDark ? 2 : 3,
            borderColor: isDark ? '#1e293b' : '#ffffff',
            hoverOffset:6
        }]
    },
    options:{ ...def, cutout:'65%', plugins:{ legend:{display:false}, tooltip:{ callbacks:{ label: c => ` ${c.label}: ${c.raw}j` } } } }
});

document.querySelectorAll('.leg-dot-res').forEach((dot, i) => {
    dot.style.background = i === 0 ? COLORS.interne : COLORS.externe;
});

chartJoursInst = new Chart(document.getElementById('chartJours'), {
    type:'bar',
    data:{
        labels:[@foreach($projets as $p)'{{ Str::limit($p->nom_client, 9) }}',@endforeach],
        datasets:[
            {
                label:'Prévu',
                data:[@foreach($projets as $p){{ $p->jours_prevus }},@endforeach],
                backgroundColor: COLORS.prevu,
                borderRadius:4, borderSkipped:false, barPercentage:.7
            },
            {
                label:'Réalisé',
                data:[@foreach($projets as $p){{ $p->jours_realises }},@endforeach],
                backgroundColor: COLORS.realise,
                borderRadius:4, borderSkipped:false, barPercentage:.7
            }
        ]
    },
    options:{ ...def,
        scales:{
            x:{ grid:{display:false}, ticks:{font:{size:8},color:tc,maxRotation:35,minRotation:25} },
            y:{ grid:{color:gc}, ticks:{font:{size:8},color:tc}, beginAtZero:true }
        },
        plugins:{
            legend:{display:false},
            tooltip:{
                mode:'index',
                callbacks:{
                    afterBody: items => {
                        const pr = items[0]?.raw || 0, re = items[1]?.raw || 0;
                        const ecart = re - pr;
                        return [`Écart: ${ecart > 0 ? '+' : ''}${ecart}j`];
                    }
                }
            }
        }
    }
});

document.querySelectorAll('.leg-dot-jours').forEach((dot, i) => {
    dot.style.background = i === 0 ? COLORS.prevu : COLORS.realise;
    if(i === 0) {
        dot.style.border = isDark ? '1px solid #64748b' : '1px solid #94a3b8';
    }
});

chartExtInst = new Chart(document.getElementById('chartExt'), {
    type:'bar',
    data:{
        labels:[@foreach($consultants as $c)'{{ Str::limit(explode(" ", $c->nom_complet)[0], 9) }}',@endforeach],
        datasets:[{
            label:'Jours',
            data:[@foreach($consultants as $c){{ $c->total_realises }},@endforeach],
            backgroundColor:[@foreach($consultants as $c)'{{ $c->type_consultant !== "Interne" ? "#F59E0B" : "#0EA5E9" }}',@endforeach],
            borderRadius:4
        }]
    },
    options:{ ...def, indexAxis:'y',
        scales:{
            x:{ grid:{color:gc}, ticks:{font:{size:8},color:tc}, beginAtZero:true },
            y:{ grid:{display:false}, ticks:{font:{size:9},color:tc} }
        },
        plugins:{ legend:{display:false}, tooltip:{ callbacks:{ label: c => ` ${c.raw} jours` } } }
    }
});

// First paint
applyFilters();
</script>
</body>

</html>