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
    </style>
</head>
<body>

@include('partials.navbar', ['navActive' => 'admin-calendrier'])

<div class="container py-4">

    <a href="{{ route('admin.calendrier.index') }}" class="text-decoration-none text-muted d-inline-block mb-3">
        <i class="bi bi-arrow-left"></i> Retour aux consultants
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="mb-0"><i class="bi bi-calendar-week"></i> Calendrier de {{ $consultant->nom_complet }}</h3>
        <div class="d-flex gap-2 align-items-center">
            <select class="form-select form-select-sm" style="max-width:260px;"
                onchange="if (this.value) window.location.href = this.value">
                <option value="">-- Changer de consultant --</option>
                @foreach($consultants as $c)
                <option value="{{ route('admin.calendrier.show', $c->id) }}" {{ $c->id === $consultant->id ? 'selected' : '' }}>
                    {{ $c->nom_complet }}
                </option>
                @endforeach
            </select>
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#viderCalendrierModal">
                <i class="bi bi-trash"></i> Supprimer le calendrier
            </button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#supprimerConsultantModal">
                <i class="bi bi-person-x"></i> Supprimer ce consultant
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Modal confirmation "Supprimer le calendrier" --}}
    <div class="modal fade" id="viderCalendrierModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Supprimer le calendrier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr ? Cette action supprimera <strong>définitivement toutes les tâches</strong>
                        de {{ $consultant->nom_complet }} dans le calendrier.</p>
                    <p class="text-danger mb-0"><strong>Cette action est irréversible.</strong> Le compte utilisateur
                        et le profil consultant ne seront pas affectés.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('admin.calendrier.vider', $consultant->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal confirmation "Supprimer ce consultant" --}}
    <div class="modal fade" id="supprimerConsultantModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Supprimer ce consultant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Cette action supprimera <strong>définitivement {{ $consultant->nom_complet }}</strong>
                        ainsi que toutes ses tâches et son compte utilisateur associé si applicable.</p>
                    <p class="text-danger mb-0"><strong>Cette action est irréversible.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('consultants.destroy', $consultant->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-person-x"></i> Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @include('partials.calendrier-fullcalendar', [
        'eventsUrl' => route('admin.calendrier.events', $consultant->id),
        'role' => 'admin',
        'canDragDrop' => true,
        'clients' => $clients,
        'createUrl' => route('admin.calendrier.tache.store', $consultant->id),
        'updateUrlBase' => '/admin/calendrier/taches',
        'deplacerUrlBase' => '/admin/calendrier/taches',
        'destroyUrlBase' => '/admin/calendrier/taches',
    ])
</div>

</body>
</html>
