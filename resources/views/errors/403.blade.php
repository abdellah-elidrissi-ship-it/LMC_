<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMC Conseil</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        [data-theme="light"] {
            --bg:#f1f5f9; --surface:#ffffff; --border:#e2e8f0;
            --text:#0f172a; --text2:#475569; --muted:#94a3b8; --accent:#3b82f6;
            --shadow:0 4px 20px rgba(0,0,0,.08);
        }
        [data-theme="dark"] {
            --bg:#0f172a; --surface:#1e293b; --border:#334155;
            --text:#e2e8f0; --text2:#94a3b8; --muted:#64748b; --accent:#3b82f6;
            --shadow:0 4px 20px rgba(0,0,0,.4);
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); margin: 0; }
        .error-wrap {
            min-height: calc(100vh - 140px);
            display: flex; align-items: center; justify-content: center;
            padding: 2rem;
        }
        .error-card {
            background: var(--surface); border: 1px solid var(--border); border-radius: 12px;
            box-shadow: var(--shadow); padding: 3rem 2.5rem; text-align: center; max-width: 480px;
        }
        .error-icon {
            width: 72px; height: 72px; border-radius: 50%;
            background: rgba(239,68,68,.1); color: #ef4444;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; margin: 0 auto 1.5rem;
        }
        .error-code { font-size: 0.85rem; font-weight: 700; letter-spacing: 0.08em; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem; }
        .error-title { font-size: 1.3rem; font-weight: 700; margin-bottom: 0.75rem; }
        .error-message { color: var(--text2); font-size: 0.9rem; line-height: 1.6; margin-bottom: 2rem; }
        .btn-home {
            background: var(--accent); color: #fff; border: none; border-radius: 8px;
            padding: 0.65rem 1.5rem; font-size: 0.85rem; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-home:hover { opacity: 0.9; color: #fff; }
    </style>
</head>
<body>

@auth
@include('partials.navbar')
@endauth

<div class="error-wrap">
    <div class="error-card">
        <div class="error-icon"><i class="bi bi-shield-lock-fill"></i></div>
        <div class="error-code">Erreur 403</div>
        <div class="error-title">{{ $exception->getMessage() ?: 'Accès non autorisé' }}</div>
        <div class="error-message">
            Vous n'avez pas les permissions nécessaires pour consulter cette page. Contactez un administrateur si vous pensez qu'il s'agit d'une erreur.
        </div>
        <a href="/" class="btn-home"><i class="bi bi-house-door-fill"></i> Retour à l'accueil</a>
    </div>
</div>

</body>
</html>
