<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMC Conseil — Connexion</title>
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
            --accent2: #0f172a;
            --input-bg: #f8fafc;
            --input-border: #e2e8f0;
            --shadow: 0 8px 40px rgba(0,0,0,.08);
            --error: #ef4444;
        }
        [data-theme="dark"] {
            --bg: #0a0f1e;
            --surface: #111827;
            --border: #1f2937;
            --text: #f1f5f9;
            --text2: #94a3b8;
            --muted: #4b5563;
            --accent: #3b82f6;
            --accent2: #3b82f6;
            --input-bg: #0d1424;
            --input-border: #1f2937;
            --shadow: 0 8px 40px rgba(0,0,0,.4);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .3s, color .3s;
            position: relative;
            overflow: hidden;
        }

        /* Background geometry */
        body::before {
            content: '';
            position: fixed;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(59,130,246,.08) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -200px; left: -200px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(15,23,42,.06) 0%, transparent 70%);
            pointer-events: none;
        }
        [data-theme="dark"] body::before {
            background: radial-gradient(circle, rgba(59,130,246,.12) 0%, transparent 70%);
        }

        /* Grid pattern */
        .grid-bg {
            position: fixed; inset: 0;
            background-image:
                linear-gradient(rgba(59,130,246,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59,130,246,.04) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }
        [data-theme="dark"] .grid-bg {
            background-image:
                linear-gradient(rgba(59,130,246,.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59,130,246,.07) 1px, transparent 1px);
        }

        /* Theme toggle */
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

        /* Login card */
        .login-wrap {
            width: 100%;
            max-width: 420px;
            padding: 24px;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 48px 40px 40px;
            box-shadow: var(--shadow);
        }

        /* Logo */
        .brand {
            text-align: center;
            margin-bottom: 40px;
        }
        .brand-mark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px; height: 56px;
            background: #0f172a;
            border-radius: 14px;
            margin-bottom: 16px;
        }
        [data-theme="dark"] .brand-mark {
            background: #3b82f6;
        }
        .brand-mark span {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 18px;
            color: #fff;
            letter-spacing: -0.5px;
        }
        .brand-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 22px;
            color: var(--text);
            letter-spacing: -0.5px;
            display: block;
        }
        .brand-sub {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
            display: block;
        }

        /* Title */
        .login-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 20px;
            color: var(--text);
            margin-bottom: 6px;
        }
        .login-sub {
            font-size: 13px;
            color: var(--text2);
            margin-bottom: 32px;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 32px;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: var(--text2);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 8px;
        }
        .input-wrap {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 15px;
            pointer-events: none;
        }
        .form-input {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 10px;
            padding: 12px 14px 12px 40px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,130,246,.12);
        }
        .form-input::placeholder { color: var(--muted); }
        .form-input.is-invalid { border-color: var(--error); }

        /* Password toggle */
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

        /* Error */
        .error-msg {
            background: rgba(239,68,68,.08);
            border: 1px solid rgba(239,68,68,.2);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            color: var(--error);
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
            margin-bottom: 24px;
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

        /* Submit */
        .btn-login {
            width: 100%;
            background: #0f172a;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: .02em;
            cursor: pointer;
            transition: background .2s, transform .1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        [data-theme="dark"] .btn-login {
            background: #3b82f6;
        }
        .btn-login:hover { background: #1e293b; }
        [data-theme="dark"] .btn-login:hover { background: #2563eb; }
        .btn-login:active { transform: scale(.99); }

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

        /* Animations */
        .login-card {
            animation: fadeUp .4s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
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

<div class="grid-bg"></div>

<button class="theme-btn" id="themeToggle" title="Changer le thème">
    <i class="bi bi-moon-fill" id="themeIcon"></i>
</button>

<div class="login-wrap">
    <div class="login-card">

        <div class="brand">
            <div class="brand-mark"><span>LMC</span></div>
            <span class="brand-name">LMC Conseil</span>
            <span class="brand-sub">Gestion des projets & missions</span>
        </div>

        <div class="divider"></div>

        <div class="login-title">Connexion</div>
        <div class="login-sub">Accédez à votre espace de travail</div>

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
            <span>
                <span class="status-dot"></span>
                Système opérationnel — LMC Conseil © {{ date('Y') }}
            </span>
        </div>
    </div>
</div>

<script>
// Theme toggle
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');

function applyTheme(t) {
    document.documentElement.setAttribute('data-theme', t);
    localStorage.setItem('lmc-theme', t);
    themeIcon.className = t === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
}

// Init icon
const currentTheme = localStorage.getItem('lmc-theme') || 'light';
themeIcon.className = currentTheme === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';

themeToggle.addEventListener('click', () => {
    const next = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    applyTheme(next);
});

// Password toggle
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
