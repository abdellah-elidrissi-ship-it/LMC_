<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMC Conseil</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg: #f1f5f9;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --text2: #475569;
            --muted: #94a3b8;
            --accent: #3b82f6;
            --input-bg: #f8fafc;
            --input-border: #e2e8f0;
            --shadow: 0 24px 60px -12px rgba(15, 23, 42, .18);
            --error: #ef4444;
            --success: #16a34a;
        }
        [data-theme="dark"] {
            --bg: #0a0f1e;
            --surface: #111827;
            --border: #1f2937;
            --text: #f1f5f9;
            --text2: #94a3b8;
            --muted: #4b5563;
            --accent: #3b82f6;
            --input-bg: #0d1424;
            --input-border: #1f2937;
            --shadow: 0 24px 60px -12px rgba(0, 0, 0, .6);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            transition: background .3s, color .3s;
        }

        /* ── Layout split-screen ── */
        .auth-shell {
            display: grid;
            grid-template-columns: minmax(0, 5fr) minmax(0, 6fr);
            min-height: 100vh;
        }
        @media (max-width: 900px) {
            .auth-shell { grid-template-columns: 1fr; }
            .auth-visual { display: none; }
        }

        /* ── Panneau visuel (gauche) — même dégradé que la navbar ── */
        .auth-visual {
            position: relative;
            background: linear-gradient(135deg, #0a1f38 0%, #123a5e 60%, #164b78 100%);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 56px;
            color: #fff;
        }
        .auth-visual-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(111,211,245,.09) 1px, transparent 1px),
                linear-gradient(90deg, rgba(111,211,245,.09) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: radial-gradient(circle at 30% 30%, black 0%, transparent 75%);
        }
        .auth-visual-glow {
            position: absolute;
            width: 520px; height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(46,168,224,.35) 0%, transparent 70%);
            bottom: -220px; left: -160px;
            pointer-events: none;
        }
        .auth-visual-mark {
            position: absolute;
            right: -80px; top: 50%;
            transform: translateY(-50%);
            width: 560px; height: 560px;
            opacity: .07;
            pointer-events: none;
        }
        .auth-visual-mark svg { width: 100%; height: 100%; fill: #ffffff; }

        .auth-visual-top {
            position: relative; z-index: 2;
            display: flex; align-items: center; gap: 1.4rem;
            margin-bottom: 12px;
        }
        .auth-visual-badge {
            width: 108px; height: 108px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .auth-visual-badge svg { width: 108px; height: 108px; fill: #ffffff; }
        .auth-visual-brand-main { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.4rem; letter-spacing: -0.01em; }
        .auth-visual-brand-sub { font-size: 0.75rem; font-weight: 600; color: #6fd3f5; letter-spacing: 0.08em; }

        .auth-visual-body { position: relative; z-index: 2; max-width: 460px; }
        .auth-visual-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 2.1rem;
            line-height: 1.25;
            margin-bottom: 18px;
            text-wrap: balance;
        }
        .auth-visual-sub {
            font-size: 0.95rem;
            line-height: 1.6;
            color: rgba(255,255,255,.72);
        }

        .auth-visual-footer {
            position: relative; z-index: 2;
            display: flex;
            gap: 28px;
            font-size: 0.72rem;
            color: rgba(255,255,255,.55);
        }
        .auth-visual-footer strong { display: block; color: #fff; font-size: 1.1rem; font-family: 'Syne', sans-serif; }

        /* ── Panneau formulaire (droite) ── */
        .auth-form-panel {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            overflow: hidden;
        }
        .auth-form-panel::before {
            content: '';
            position: absolute;
            top: -180px; right: -180px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(59,130,246,.10) 0%, transparent 70%);
            pointer-events: none;
        }

        .theme-btn {
            position: fixed; top: 24px; right: 24px;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text2);
            width: 40px; height: 40px;
            border-radius: 10px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            transition: all .2s;
            z-index: 100;
            box-shadow: var(--shadow);
        }
        .theme-btn:hover { color: var(--accent); border-color: var(--accent); }

        .login-wrap {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 44px 40px;
            box-shadow: var(--shadow);
            animation: fadeUp .5s cubic-bezier(.16,1,.3,1) both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Logo — asset réel public/images/lmc-logo.png, identique à la navbar */
        .brand {
            text-align: center;
            padding-bottom: 28px;
            margin-bottom: 28px;
            border-bottom: 1px solid var(--border);
        }
        .brand-plate {
            display: inline-block;
            background: #ffffff;
            border-radius: 16px;
            padding: 16px 24px;
        }
        .brand img {
            width: 220px;
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .login-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 21px;
            color: var(--text);
            margin-bottom: 6px;
        }
        .login-sub {
            font-size: 13px;
            color: var(--text2);
            margin-bottom: 30px;
        }

        /* Form */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: var(--text2);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 8px;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 15px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 15px;
            pointer-events: none;
            transition: color .2s;
        }
        .form-input {
            width: 100%;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            padding: 13px 14px 13px 42px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            outline: none;
            transition: border-color .18s, box-shadow .18s, background .18s;
        }
        .form-input:hover { border-color: #cbd5e1; }
        .form-input:focus {
            border-color: var(--accent);
            background: var(--surface);
            box-shadow: 0 0 0 4px rgba(59,130,246,.14);
        }
        .form-input:focus ~ .input-icon,
        .input-wrap:focus-within .input-icon { color: var(--accent); }
        .form-input::placeholder { color: var(--muted); }
        .form-input.is-invalid { border-color: var(--error); }

        .pw-toggle {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 15px;
            padding: 0;
            transition: color .2s;
        }
        .pw-toggle:hover { color: var(--text2); }

        /* Messages */
        .error-msg {
            background: rgba(239,68,68,.08);
            border: 1px solid rgba(239,68,68,.2);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 13px;
            color: var(--error);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .success-msg {
            background: rgba(22,163,74,.08);
            border: 1px solid rgba(22,163,74,.2);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 13px;
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        /* Remember */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 26px;
        }
        .remember-row input[type="checkbox"] {
            accent-color: var(--accent);
            width: 15px; height: 15px;
            cursor: pointer;
        }
        .remember-row label {
            font-size: 13px;
            color: var(--text2);
            cursor: pointer;
        }

        /* Submit — dégradé, effet hover marqué */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 120%);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: .02em;
            cursor: pointer;
            transition: transform .18s, box-shadow .18s, background .3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 8px 20px -6px rgba(29,78,216,.5);
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #1e293b 0%, #2563eb 120%);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -6px rgba(29,78,216,.6);
        }
        .btn-login:active { transform: translateY(0); }

        /* Footer */
        .card-footer {
            text-align: center;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            color: var(--muted);
        }
        .card-footer span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .status-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #22c55e;
            display: inline-block;
        }
    </style>
</head>
<body>
<script>
(function() {
    const t = localStorage.getItem('lmc-theme') || 'light';
    document.documentElement.setAttribute('data-theme', t);
})();
</script>

<button class="theme-btn" id="themeToggle" title="Changer le thème">
    <i class="bi bi-moon-fill" id="themeIcon"></i>
</button>

<div class="auth-shell">
    <div class="auth-visual">
        <div class="auth-visual-grid"></div>
        <div class="auth-visual-glow"></div>
        <div class="auth-visual-mark">
            <svg viewBox="0 0 441 499" xmlns="http://www.w3.org/2000/svg">
                <g transform="translate(0,499) scale(0.1,-0.1)" stroke="none">
                    <path d="M1971 4969 c-849 -89 -1581 -677 -1852 -1489 -434 -1302 401 -2662 1766 -2876 148 -23 478 -23 627 -1 1093 165 1890 1081 1890 2172 0 586 -209 1108 -609 1526 -471 491 -1146 738 -1822 668z m441 -54 c295 -16 635 -129 909 -301 71 -44 86 -58 82 -74 -4 -14 0 -20 12 -20 16 0 16 -2 1 -25 -9 -14 -13 -25 -9 -25 4 0 -2 -7 -13 -15 -10 -8 -15 -15 -10 -15 5 0 1 -9 -9 -20 -12 -14 -25 -18 -41 -14 -13 4 -24 2 -24 -3 0 -5 -18 -29 -39 -53 -35 -40 -38 -47 -25 -61 20 -22 18 -31 -11 -53 -13 -10 -22 -22 -19 -27 11 -19 -19 -8 -72 26 -230 147 -634 275 -869 275 -50 0 -56 2 -45 15 7 9 8 15 2 15 -5 0 -15 12 -21 28 -6 15 -21 42 -33 61 -19 30 -20 37 -8 69 7 20 14 75 16 122 1 47 3 91 3 98 1 9 17 11 64 8 34 -3 106 -8 159 -11z m-22 -471 c524 -44 1058 -411 1300 -893 30 -60 31 -66 20 -112 -23 -95 -91 -128 -281 -136 -227 -10 -392 30 -638 154 -215 109 -443 269 -643 453 -98 90 -104 93 -114 48 -25 -114 26 -220 180 -374 165 -164 358 -301 831 -589 240 -146 297 -187 380 -277 104 -111 158 -245 135 -336 -27 -108 -68 -146 -257 -242 -237 -119 -329 -225 -277 -319 31 -56 75 -73 168 -68 117 8 185 45 311 172 146 147 244 239 250 234 2 -3 -20 -55 -49 -115 -232 -469 -666 -802 -1179 -906 -164 -34 -493 -33 -649 0 -292 63 -533 181 -764 374 -209 176 -438 505 -420 603 10 49 66 108 121 125 69 21 297 24 405 6 304 -53 728 -297 1055 -607 87 -83 96 -82 103 11 15 202 -285 479 -938 870 -270 162 -351 219 -436 304 -133 135 -184 263 -149 381 24 86 66 124 218 201 157 80 234 130 276 181 95 114 38 223 -116 223 -133 0 -204 -43 -416 -255 -87 -86 -160 -155 -163 -152 -11 11 88 199 165 314 284 424 750 695 1260 733 102 7 169 6 311 -6z M1975 3459 c-10 -16 16 -142 34 -168 49 -68 132 -112 307 -161 177 -49 454 -87 454 -61 0 6 -4 11 -9 11 -11 0 -272 175 -366 245 -74 56 -80 59 -246 100 -93 24 -172 39 -174 34z M2236 2982 c-13 -21 17 -83 56 -117 76 -65 152 -80 462 -95 183 -9 474 -39 546 -56 l24 -5 -19 21 c-25 28 -96 76 -263 179 l-133 81 -334 0 c-184 0 -336 -4 -339 -8z M1105 2830 c23 -25 164 -119 305 -203 l96 -57 332 0 332 0 0 35 c0 24 -9 45 -32 70 -68 78 -156 101 -449 115 -188 9 -488 39 -574 56 l-30 6 20 -22z M1763 2410 c76 -50 182 -122 235 -162 96 -71 97 -72 247 -109 195 -50 185 -51 185 14 -1 111 -66 185 -209 237 -178 65 -396 109 -536 110 l-60 0 138 -90z M1865 470 c-355 -25 -603 -91 -578 -155 17 -46 199 -93 468 -120 154 -16 680 -23 795 -11 25 3 77 8 115 11 297 26 504 97 449 153 -98 97 -718 158 -1249 122z"/>
                </g>
            </svg>
        </div>

        <div class="auth-visual-top">
            <span class="auth-visual-badge">
                <svg viewBox="0 0 441 499" xmlns="http://www.w3.org/2000/svg">
                    <g transform="translate(0,499) scale(0.1,-0.1)" stroke="none">
                        <path d="M1971 4969 c-849 -89 -1581 -677 -1852 -1489 -434 -1302 401 -2662 1766 -2876 148 -23 478 -23 627 -1 1093 165 1890 1081 1890 2172 0 586 -209 1108 -609 1526 -471 491 -1146 738 -1822 668z m441 -54 c295 -16 635 -129 909 -301 71 -44 86 -58 82 -74 -4 -14 0 -20 12 -20 16 0 16 -2 1 -25 -9 -14 -13 -25 -9 -25 4 0 -2 -7 -13 -15 -10 -8 -15 -15 -10 -15 5 0 1 -9 -9 -20 -12 -14 -25 -18 -41 -14 -13 4 -24 2 -24 -3 0 -5 -18 -29 -39 -53 -35 -40 -38 -47 -25 -61 20 -22 18 -31 -11 -53 -13 -10 -22 -22 -19 -27 11 -19 -19 -8 -72 26 -230 147 -634 275 -869 275 -50 0 -56 2 -45 15 7 9 8 15 2 15 -5 0 -15 12 -21 28 -6 15 -21 42 -33 61 -19 30 -20 37 -8 69 7 20 14 75 16 122 1 47 3 91 3 98 1 9 17 11 64 8 34 -3 106 -8 159 -11z m-22 -471 c524 -44 1058 -411 1300 -893 30 -60 31 -66 20 -112 -23 -95 -91 -128 -281 -136 -227 -10 -392 30 -638 154 -215 109 -443 269 -643 453 -98 90 -104 93 -114 48 -25 -114 26 -220 180 -374 165 -164 358 -301 831 -589 240 -146 297 -187 380 -277 104 -111 158 -245 135 -336 -27 -108 -68 -146 -257 -242 -237 -119 -329 -225 -277 -319 31 -56 75 -73 168 -68 117 8 185 45 311 172 146 147 244 239 250 234 2 -3 -20 -55 -49 -115 -232 -469 -666 -802 -1179 -906 -164 -34 -493 -33 -649 0 -292 63 -533 181 -764 374 -209 176 -438 505 -420 603 10 49 66 108 121 125 69 21 297 24 405 6 304 -53 728 -297 1055 -607 87 -83 96 -82 103 11 15 202 -285 479 -938 870 -270 162 -351 219 -436 304 -133 135 -184 263 -149 381 24 86 66 124 218 201 157 80 234 130 276 181 95 114 38 223 -116 223 -133 0 -204 -43 -416 -255 -87 -86 -160 -155 -163 -152 -11 11 88 199 165 314 284 424 750 695 1260 733 102 7 169 6 311 -6z M1975 3459 c-10 -16 16 -142 34 -168 49 -68 132 -112 307 -161 177 -49 454 -87 454 -61 0 6 -4 11 -9 11 -11 0 -272 175 -366 245 -74 56 -80 59 -246 100 -93 24 -172 39 -174 34z M2236 2982 c-13 -21 17 -83 56 -117 76 -65 152 -80 462 -95 183 -9 474 -39 546 -56 l24 -5 -19 21 c-25 28 -96 76 -263 179 l-133 81 -334 0 c-184 0 -336 -4 -339 -8z M1105 2830 c23 -25 164 -119 305 -203 l96 -57 332 0 332 0 0 35 c0 24 -9 45 -32 70 -68 78 -156 101 -449 115 -188 9 -488 39 -574 56 l-30 6 20 -22z M1763 2410 c76 -50 182 -122 235 -162 96 -71 97 -72 247 -109 195 -50 185 -51 185 14 -1 111 -66 185 -209 237 -178 65 -396 109 -536 110 l-60 0 138 -90z M1865 470 c-355 -25 -603 -91 -578 -155 17 -46 199 -93 468 -120 154 -16 680 -23 795 -11 25 3 77 8 115 11 297 26 504 97 449 153 -98 97 -718 158 -1249 122z"/>
                    </g>
                </svg>
            </span>
            <div>
                <div class="auth-visual-brand-main">LMC</div>
                <div class="auth-visual-brand-sub">LEAD MANAGEMENT CONSULTING</div>
            </div>
        </div>

        <div class="auth-visual-body">
            <div class="auth-visual-title">Pilotez vos missions QSE avec précision.</div>
            <div class="auth-visual-sub">
                Consultants, chapitres normatifs, livrables et planning Gantt —
                une plateforme unique pour vos audits ISO 9001 · 14001 · 45001.
            </div>
        </div>

        <div class="auth-visual-footer">
            <div><strong>ISO 9001</strong>Qualité</div>
            <div><strong>ISO 14001</strong>Environnement</div>
            <div><strong>ISO 45001</strong>Sécurité</div>
        </div>
    </div>

    <div class="auth-form-panel">
        <div class="login-wrap">
            <div class="login-card">

                <div class="brand">
                    <span class="brand-plate">
                        <img src="{{ asset('images/lmc-logo.png') }}" alt="LMC — Lead Management Consulting">
                    </span>
                </div>

                <div class="login-title">Connexion</div>
                <div class="login-sub">Accédez à votre espace de travail</div>

                @if(session('success'))
                <div class="success-msg">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="error-msg">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Adresse e-mail</label>
                        <div class="input-wrap">
                            <i class="bi bi-envelope input-icon"></i>
                            <input
                                type="email"
                                name="email"
                                class="form-input @error('email') is-invalid @enderror"
                                placeholder="votre@email.com"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mot de passe</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock input-icon"></i>
                            <input
                                type="password"
                                name="password"
                                id="passwordInput"
                                class="form-input"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="pw-toggle" id="pwToggle">
                                <i class="bi bi-eye" id="pwIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="remember-row">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Rester connecté</label>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Se connecter
                    </button>
                </form>

                <div class="card-footer">
                    <div style="margin-bottom: 10px;">
                        Pas encore de compte ? <a href="/register" style="color: var(--accent); text-decoration: none; font-weight: 500;">Demander un accès</a>
                    </div>
                    <span>
                        <span class="status-dot"></span>
                        Système opérationnel — LMC Conseil © {{ date('Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');

function applyTheme(t) {
    document.documentElement.setAttribute('data-theme', t);
    localStorage.setItem('lmc-theme', t);
    themeIcon.className = t === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
}

const currentTheme = localStorage.getItem('lmc-theme') || 'light';
themeIcon.className = currentTheme === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';

themeToggle.addEventListener('click', () => {
    const next = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    applyTheme(next);
});

document.getElementById('pwToggle').addEventListener('click', function() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('pwIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
});
</script>
</body>
</html>
