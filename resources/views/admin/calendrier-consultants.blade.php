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
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }

        .consultant-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.2rem;
            transition: all 0.2s ease;
            height: 100%;
        }

        .consultant-card:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }

        .consultant-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }
    </style>
</head>
<body>

@include('partials.navbar', ['navActive' => 'admin-calendrier'])

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0"><i class="bi bi-calendar-week"></i> Gestion des tâches</h3>
    </div>

    <p class="text-muted mb-4">
        Sélectionnez un consultant pour accéder à son calendrier et lui assigner des tâches.
    </p>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        @forelse($consultants as $c)
        <div class="col-md-4 col-sm-6">
            <div class="consultant-card">
                <a href="{{ route('admin.calendrier.show', $c->id) }}" class="text-decoration-none">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="consultant-avatar">
                            {{ strtoupper(substr($c->nom_complet, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold text-dark">{{ $c->nom_complet }}</div>
                            <div class="text-muted" style="font-size:0.8rem;">{{ $c->type_consultant }}</div>
                        </div>
                    </div>
                </a>
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    @if($c->user_id)
                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Compte actif</span>
                    @else
                    <span class="badge bg-secondary"><i class="bi bi-exclamation-triangle"></i> Pas de compte</span>
                    @endif
                    <span class="badge bg-primary">{{ $c->taches_a_venir }} tâche(s) à venir</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-muted text-center py-5">Aucun consultant enregistré.</p>
        </div>
        @endforelse
    </div>
</div>

</body>
</html>
