{{--
    Partial FullCalendar partagé entre "Mon calendrier" (consultant) et
    "Gestion des tâches" (admin/chef de projet). Variables attendues :

    - eventsUrl (string, requis)          : endpoint JSON des événements
    - role ('consultant'|'admin', requis) : détermine les actions dispo
    - canDragDrop (bool, admin only)      : active eventDrop/eventResize
    - deplacerUrlBase (string, admin)     : base '/admin/calendrier/taches' (+ /{id}/deplacer)
    - createUrl (string, admin)           : POST création tâche
    - updateUrlBase (string, admin)       : base '/admin/calendrier/taches' (+ /{id}) pour PUT
    - destroyUrlBase (string, admin)      : base '/admin/calendrier/taches' (+ /{id}) pour DELETE
    - lireUrlBase (string, consultant)    : base '/calendrier/taches' (+ /{id}/lire)
    - repondreUrlBase (string, consultant): base '/calendrier/taches' (+ /{id}/repondre)
    - clients (collection, admin)         : pour le select du formulaire + filtre
    - ouvrirTacheId (int|null)            : deep-link email, auto-ouvre le détail
--}}
<style>
    /* ── Layout sidebar + calendrier (style Outlook Team Calendar) ── */
    .cal-shell {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 1rem;
        align-items: start;
    }
    @media (max-width: 860px) {
        .cal-shell { grid-template-columns: 1fr; }
    }
    .cal-sidebar {
        background: #fff;
        border: 1px solid #eef1f6;
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 1.1rem;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }

    /* ── Mini calendrier de navigation ── */
    .mini-cal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; }
    .mini-cal-title { font-size: 0.78rem; font-weight: 700; color: #334155; text-transform: capitalize; }
    .mini-cal-nav {
        border: none; background: transparent; color: #94a3b8;
        width: 22px; height: 22px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 0.7rem;
    }
    .mini-cal-nav:hover { background: #f1f5f9; color: #2563eb; }
    .mini-cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
    .mini-cal-dow { font-size: 0.6rem; text-align: center; color: #94a3b8; font-weight: 700; padding-bottom: 2px; }
    .mini-cal-day {
        border: none; background: transparent; font-size: 0.7rem; color: #334155;
        width: 100%; aspect-ratio: 1; border-radius: 6px; cursor: pointer;
    }
    .mini-cal-day:hover { background: #eef2ff; }
    .mini-cal-day.is-today { background: #2563eb; color: #fff; font-weight: 700; }

    /* ── Filtres admin (sidebar) ── */
    .cal-filter-group { margin-bottom: 0.75rem; }
    .cal-filter-group:last-child { margin-bottom: 0; }
    .cal-filter-label {
        display: block; font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.05em; color: #94a3b8; margin-bottom: 0.3rem;
    }

    /* ── Légende verticale ── */
    .calendrier-legende-v { display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.76rem; color: #475569; }
    .calendrier-legende-v .legend-row { display: flex; align-items: center; gap: 0.5rem; }
    .legend-swatch { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }

    /* ── Conteneur FullCalendar ── */
    #calendrierFC {
        --fc-border-color: #eef1f6;
        --fc-page-bg-color: #ffffff;
        --fc-neutral-bg-color: #f8fafc;
        --fc-today-bg-color: rgba(37, 99, 235, 0.06);
        --fc-button-bg-color: transparent;
        --fc-button-border-color: transparent;
        --fc-button-hover-bg-color: #e2e8f0;
        --fc-button-hover-border-color: transparent;
        --fc-button-active-bg-color: #2563eb;
        --fc-button-active-border-color: #2563eb;
        --fc-button-text-color: #64748b;
        font-family: 'Inter', sans-serif;
        background: #fff;
        border: 1px solid #eef1f6;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }
    #calendrierFC .fc-toolbar-title {
        font-size: 1.05rem !important;
        font-weight: 700;
        color: #0f172a;
    }
    #calendrierFC .fc-button-group {
        background: #f1f5f9;
        border-radius: 9999px;
        padding: 3px;
        gap: 2px;
    }
    #calendrierFC .fc-button {
        border: none !important;
        background: transparent !important;
        color: #64748b !important;
        box-shadow: none !important;
        border-radius: 9999px !important;
        padding: 0.35rem 0.85rem !important;
        font-size: 0.75rem !important;
        font-weight: 600;
        text-transform: capitalize;
    }
    #calendrierFC .fc-button:hover { background: #ffffff !important; color: #2563eb !important; }
    #calendrierFC .fc-button-active { background: #2563eb !important; color: #ffffff !important; }
    #calendrierFC .fc-col-header-cell-cushion {
        color: #94a3b8 !important;
        text-decoration: none !important;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 8px 4px;
    }
    #calendrierFC .fc-daygrid-day-number {
        color: #334155 !important;
        text-decoration: none !important;
        font-size: 0.78rem;
        font-weight: 500;
        padding: 6px 8px !important;
    }
    #calendrierFC .fc-daygrid-day-frame { padding: 2px; min-height: 92px; }
    #calendrierFC .fc-scrollgrid { border-radius: 8px; overflow: hidden; }

    /* ── Événements : pilules pastel par statut ── */
    #calendrierFC .fc-event { cursor: pointer; }
    #calendrierFC .fc-daygrid-event {
        border-radius: 6px !important;
        border: 1px solid transparent !important;
        padding: 2px 7px !important;
        margin: 1px 3px !important;
        font-size: 0.74rem;
        font-weight: 600;
    }
    #calendrierFC .fc-timegrid-event {
        border-radius: 6px !important;
        border: 1px solid transparent !important;
        font-size: 0.74rem;
        font-weight: 600;
    }
    #calendrierFC .fc-event-title, #calendrierFC .fc-event-time { font-weight: 600; }
    #calendrierFC .fc-tache-assignee  { background: #eef1f5 !important; color: #475569 !important; border-color: #cbd5e1 !important; }
    #calendrierFC .fc-tache-lue       { background: #fef3e2 !important; color: #b45309 !important; border-color: #fcd9a0 !important; }
    #calendrierFC .fc-tache-en-cours  { background: #e0f7fb !important; color: #0e7490 !important; border-color: #a5e9f5 !important; }
    #calendrierFC .fc-tache-acceptee  { background: #e3f8ea !important; color: #15803d !important; border-color: #a7e9bf !important; }
    #calendrierFC .fc-tache-refusee   { background: #fdeaea !important; color: #b91c1c !important; border-color: #f8c1c1 !important; }
    #calendrierFC .fc-tache-assignee *,
    #calendrierFC .fc-tache-lue *,
    #calendrierFC .fc-tache-en-cours *,
    #calendrierFC .fc-tache-acceptee *,
    #calendrierFC .fc-tache-refusee * { color: inherit !important; }

    @media (max-width: 576px) {
        #calendrierFC .fc-toolbar { flex-direction: column; gap: 0.5rem; }
        #calendrierFC .fc-toolbar-chunk { display: flex; justify-content: center; }
    }
</style>

<div class="cal-shell">
    <aside class="cal-sidebar">
        @if($role === 'admin')
        <button type="button" class="btn btn-primary w-100" onclick="ouvrirFormulaireCreation()">
            <i class="bi bi-plus-lg"></i> Assigner une tâche
        </button>
        @endif

        <div id="miniCal"></div>

        @if($role === 'admin')
        <div class="cal-filters">
            <div class="cal-filter-group">
                <label class="cal-filter-label">Client</label>
                <select class="form-select form-select-sm" id="filtreClient">
                    <option value="">Tous les clients</option>
                    @foreach($clients as $cl)
                    <option value="{{ $cl->id }}">{{ $cl->nom_client }}</option>
                    @endforeach
                </select>
            </div>
            <div class="cal-filter-group">
                <label class="cal-filter-label">Statut</label>
                <select class="form-select form-select-sm" id="filtreStatut">
                    <option value="">Tous les statuts</option>
                    @foreach(['Assignée','Lue','Acceptée','Refusée','En cours','Terminée'] as $st)
                    <option value="{{ $st }}">{{ $st }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        <div class="calendrier-legende-v">
            <div class="legend-row"><span class="legend-swatch" style="background:#94a3b8"></span> Assignée</div>
            <div class="legend-row"><span class="legend-swatch" style="background:#d97706"></span> Lue</div>
            <div class="legend-row"><span class="legend-swatch" style="background:#0891b2"></span> En cours</div>
            <div class="legend-row"><span class="legend-swatch" style="background:#16a34a"></span> Acceptée / Terminée</div>
            <div class="legend-row"><span class="legend-swatch" style="background:#dc2626"></span> Refusée</div>
        </div>
    </aside>

    <div class="cal-main">
        <div id="calendrierFC"></div>
    </div>
</div>

<!-- Modal détail tâche -->
<div class="modal fade" id="tacheDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailTitre"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($role === 'admin')
                <p class="mb-2"><strong>Consultant :</strong> <span id="detailConsultant"></span></p>
                @endif
                <p class="mb-2"><strong>Client :</strong> <span id="detailClient"></span></p>
                <p class="mb-2"><strong>Date :</strong> <span id="detailDate"></span></p>
                <p class="mb-2"><strong>Horaire :</strong> <span id="detailHeure"></span></p>
                <p class="mb-2"><strong>Assignée par :</strong> <span id="detailAssignePar"></span></p>
                <p class="mb-2"><strong>Objectif :</strong><br><span id="detailObjectif"></span></p>
                <p class="mb-3"><strong>Statut actuel :</strong> <span id="detailStatut" class="badge"></span></p>

                @if($role === 'consultant')
                <hr>
                <form id="reponseTacheForm" onsubmit="return false;">
                    <div class="mb-2">
                        <label class="form-label">Votre réponse</label>
                        <select class="form-select" id="reponseStatut" name="reponseStatut">
                            <option value="Acceptée">Accepter</option>
                            <option value="Refusée">Refuser</option>
                            <option value="En cours">Marquer en cours</option>
                            <option value="Terminée">Marquer terminée</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Commentaire</label>
                        <textarea class="form-control" id="reponseCommentaire" name="reponseCommentaire" rows="3"
                            placeholder="Laisser un commentaire..."></textarea>
                    </div>
                </form>
                @else
                <p class="mb-2"><strong>Lecture :</strong> <span id="detailLu"></span></p>
                <p class="mb-2"><strong>Commentaire du consultant :</strong><br>
                    <span id="detailCommentaire" class="text-muted"></span></p>
                @endif
            </div>
            <div class="modal-footer">
                @if($role === 'consultant')
                <button class="btn btn-primary" onclick="envoyerReponse()">
                    <i class="bi bi-check-circle"></i> Enregistrer
                </button>
                @else
                <button type="button" class="btn btn-outline-danger" onclick="supprimerTache()">
                    <i class="bi bi-trash"></i> Supprimer
                </button>
                <button type="button" class="btn btn-primary" onclick="ouvrirFormulaireModification()">
                    <i class="bi bi-pencil"></i> Modifier
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

@if($role === 'admin')
<!-- Modal Créer / Modifier une tâche -->
<div class="modal fade" id="tacheFormModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tacheForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="tacheFormTitre">Assigner une tâche</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Client concerné</label>
                        <select class="form-select" id="formClientId">
                            <option value="">-- Aucun --</option>
                            @foreach($clients as $cl)
                            <option value="{{ $cl->id }}">{{ $cl->nom_client }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="formTitre" required
                            placeholder="Ex: Audit ISO 9001 - Chapitre 6">
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="formDate" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Heure début</label>
                            <input type="time" class="form-control" id="formHeureDebut">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Heure fin</label>
                            <input type="time" class="form-control" id="formHeureFin">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Objectif de la mission</label>
                        <textarea class="form-control" id="formObjectif" rows="4"
                            placeholder="Décrire précisément ce qui est attendu..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales-all.global.min.js"></script>
<script>
(function () {
    const cfg = {
        eventsUrl: @json($eventsUrl),
        role: @json($role),
        canDragDrop: @json($canDragDrop ?? false),
        deplacerUrlBase: @json($deplacerUrlBase ?? null),
        createUrl: @json($createUrl ?? null),
        updateUrlBase: @json($updateUrlBase ?? null),
        destroyUrlBase: @json($destroyUrlBase ?? null),
        lireUrlBase: @json($lireUrlBase ?? null),
        repondreUrlBase: @json($repondreUrlBase ?? null),
        ouvrirTacheId: @json($ouvrirTacheId ?? null),
    };

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

    let calendar, tacheDetailModal, tacheFormModal;
    let currentEvent = null;
    let modeFormulaire = 'creation';

    document.addEventListener('DOMContentLoaded', function () {
        tacheDetailModal = new bootstrap.Modal(document.getElementById('tacheDetailModal'));
        if (cfg.role === 'admin') {
            tacheFormModal = new bootstrap.Modal(document.getElementById('tacheFormModal'));
        }

        const calendarEl = document.getElementById('calendrierFC');
        calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'fr',
            height: 'auto',
            eventDisplay: 'block',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
            },
            editable: cfg.canDragDrop,
            eventStartEditable: cfg.canDragDrop,
            eventDurationEditable: cfg.canDragDrop,
            events: function (info, success, failure) {
                const params = new URLSearchParams({
                    start: info.startStr,
                    end: info.endStr,
                    ...(window.calendrierExtraParams || {}),
                });
                fetch(cfg.eventsUrl + '?' + params.toString(), {
                    headers: { 'Accept': 'application/json' },
                })
                    .then(r => r.json())
                    .then(success)
                    .catch(failure);
            },
            eventClassNames: function (arg) {
                return ['fc-tache-' + statutClass(arg.event.extendedProps.statut)];
            },
            eventClick: function (info) {
                ouvrirDetail(info.event);
            },
            eventDrop: function (info) {
                deplacerTache(info);
            },
            eventResize: function (info) {
                deplacerTache(info);
            },
            dateClick: function (info) {
                if (cfg.role === 'admin') {
                    ouvrirFormulaireCreation(info.dateStr);
                }
            },
            datesSet: function () {
                renderMiniCalendar(calendar.getDate());
            },
        });
        calendar.render();

        window.calendrierRefetch = () => calendar.refetchEvents();

        if (cfg.role === 'admin') {
            document.getElementById('filtreClient').addEventListener('change', appliquerFiltres);
            document.getElementById('filtreStatut').addEventListener('change', appliquerFiltres);
            document.getElementById('tacheForm').addEventListener('submit', soumettreFormulaire);
        }

        if (cfg.ouvrirTacheId) {
            // Laisse le temps aux events de se charger avant d'ouvrir le modal
            // (une seule fois : eventsSet refire à chaque refetch ultérieur)
            let deepLinkOuvert = false;
            calendar.on('eventsSet', function onceLoaded() {
                if (deepLinkOuvert) return;
                const ev = calendar.getEventById(String(cfg.ouvrirTacheId));
                if (ev) {
                    deepLinkOuvert = true;
                    ouvrirDetail(ev);
                }
            });
        }
    });

    function statutClass(statut) {
        switch (statut) {
            case 'Acceptée':
            case 'Terminée': return 'acceptee';
            case 'En cours': return 'en-cours';
            case 'Lue': return 'lue';
            case 'Refusée': return 'refusee';
            default: return 'assignee';
        }
    }

    // ── Mini calendrier de navigation rapide (sidebar) ──
    function renderMiniCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const first = new Date(year, month, 1);
        const startOffset = (first.getDay() + 6) % 7; // lundi = 0
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const todayStr = new Date().toDateString();

        let html = `<div class="mini-cal-header">
            <button type="button" class="mini-cal-nav" data-dir="-1"><i class="bi bi-chevron-left"></i></button>
            <span class="mini-cal-title">${date.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' })}</span>
            <button type="button" class="mini-cal-nav" data-dir="1"><i class="bi bi-chevron-right"></i></button>
        </div>
        <div class="mini-cal-grid">`;

        ['L', 'M', 'M', 'J', 'V', 'S', 'D'].forEach(d => {
            html += `<span class="mini-cal-dow">${d}</span>`;
        });

        for (let i = 0; i < startOffset; i++) {
            html += `<span></span>`;
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const cellDate = new Date(year, month, d);
            const iso = cellDate.getFullYear() + '-' +
                String(cellDate.getMonth() + 1).padStart(2, '0') + '-' +
                String(cellDate.getDate()).padStart(2, '0');
            const isToday = cellDate.toDateString() === todayStr;
            html += `<button type="button" class="mini-cal-day ${isToday ? 'is-today' : ''}" data-date="${iso}">${d}</button>`;
        }

        html += `</div>`;

        const container = document.getElementById('miniCal');
        container.innerHTML = html;

        container.querySelectorAll('.mini-cal-day').forEach(btn => {
            btn.addEventListener('click', () => calendar.gotoDate(btn.dataset.date));
        });
        container.querySelectorAll('.mini-cal-nav').forEach(btn => {
            btn.addEventListener('click', () => {
                const dir = parseInt(btn.dataset.dir, 10);
                calendar.gotoDate(new Date(year, month + dir, 1));
            });
        });
    }

    function appliquerFiltres() {
        window.calendrierExtraParams = {
            client_id: document.getElementById('filtreClient').value,
            statut: document.getElementById('filtreStatut').value,
        };
        calendar.refetchEvents();
    }

    function formatHeure(props) {
        return (props.heure_debut || '—') + ' - ' + (props.heure_fin || '—');
    }

    function ouvrirDetail(event) {
        currentEvent = event;
        const p = event.extendedProps;

        document.getElementById('detailTitre').textContent = event.title;
        document.getElementById('detailClient').textContent = p.client || '—';
        document.getElementById('detailDate').textContent = p.date;
        document.getElementById('detailHeure').textContent = formatHeure(p);
        document.getElementById('detailAssignePar').textContent = p.assigne_par || '—';
        document.getElementById('detailObjectif').textContent = p.objectif || 'Aucun détail fourni.';

        const badge = document.getElementById('detailStatut');
        badge.textContent = p.statut;
        badge.className = 'badge bg-' + statutBootstrapColor(p.statut);

        if (cfg.role === 'admin') {
            document.getElementById('detailConsultant').textContent = p.consultant || '—';
            document.getElementById('detailLu').textContent = p.lu
                ? 'Vue par le consultant'
                : 'Pas encore vue par le consultant';
            document.getElementById('detailCommentaire').textContent = p.commentaire || 'Aucun commentaire.';
        } else {
            document.getElementById('reponseStatut').value =
                ['Acceptée', 'Refusée', 'En cours', 'Terminée'].includes(p.statut) ? p.statut : 'Acceptée';
            document.getElementById('reponseCommentaire').value = p.commentaire || '';

            const reponseForm = document.getElementById('reponseTacheForm');
            reponseForm.dataset.persistKey = 'reponse-' + event.id;
            if (window.FormPersist) window.FormPersist.restore(reponseForm);
        }

        tacheDetailModal.show();

        if (cfg.role === 'consultant' && !p.lu) {
            fetch(`${cfg.lireUrlBase}/${event.id}/lire`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken(), 'Accept': 'application/json' },
            });
        }
    }

    function statutBootstrapColor(statut) {
        switch (statut) {
            case 'Acceptée':
            case 'Terminée': return 'success';
            case 'En cours': return 'info';
            case 'Lue': return 'warning';
            case 'Refusée': return 'danger';
            default: return 'secondary';
        }
    }

    function envoyerReponse() {
        if (!currentEvent) return;

        const statut = document.getElementById('reponseStatut').value;
        const commentaire = document.getElementById('reponseCommentaire').value;

        fetch(`${cfg.repondreUrlBase}/${currentEvent.id}/repondre`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ statut, commentaire }),
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    if (window.FormPersist) {
                        window.FormPersist.clear(document.getElementById('reponseTacheForm'));
                    }
                    tacheDetailModal.hide();
                    calendar.refetchEvents();
                }
            });
    }

    function deplacerTache(info) {
        if (!confirm('Confirmer le déplacement de cette tâche ?')) {
            info.revert();
            return;
        }

        const event = info.event;
        const date = event.startStr.substring(0, 10);
        const heureDebut = event.allDay ? null : event.startStr.substring(11, 16);
        const heureFin = (!event.allDay && event.end) ? event.endStr.substring(11, 16) : null;

        fetch(`${cfg.deplacerUrlBase}/${event.id}/deplacer`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ date, heure_debut: heureDebut, heure_fin: heureFin }),
        })
            .then(r => {
                if (!r.ok) throw new Error('echec');
                return r.json();
            })
            .then(() => calendar.refetchEvents())
            .catch(() => info.revert());
    }

    function resetFormulaire() {
        document.getElementById('tacheForm').reset();
        document.getElementById('formClientId').value = '';
    }

    window.ouvrirFormulaireCreation = function (date = null) {
        modeFormulaire = 'creation';
        currentEvent = null;
        resetFormulaire();
        document.getElementById('tacheFormTitre').textContent = 'Assigner une tâche';
        if (date) document.getElementById('formDate').value = date;

        const tacheForm = document.getElementById('tacheForm');
        tacheForm.dataset.persistKey = 'creation';
        if (window.FormPersist) window.FormPersist.restore(tacheForm);

        tacheFormModal.show();
    };

    window.ouvrirFormulaireModification = function () {
        if (!currentEvent) return;
        const p = currentEvent.extendedProps;

        modeFormulaire = 'modification';
        document.getElementById('tacheFormTitre').textContent = 'Modifier la tâche';
        document.getElementById('formClientId').value = p.client_id || '';
        document.getElementById('formTitre').value = currentEvent.title;
        document.getElementById('formDate').value = p.date;
        document.getElementById('formHeureDebut').value = p.heure_debut || '';
        document.getElementById('formHeureFin').value = p.heure_fin || '';
        document.getElementById('formObjectif').value = p.objectif || '';

        const tacheForm = document.getElementById('tacheForm');
        tacheForm.dataset.persistKey = 'edit-' + currentEvent.id;
        if (window.FormPersist) window.FormPersist.restore(tacheForm);

        tacheDetailModal.hide();
        tacheFormModal.show();
    };

    function soumettreFormulaire(e) {
        e.preventDefault();

        const payload = {
            client_id: document.getElementById('formClientId').value || null,
            titre: document.getElementById('formTitre').value,
            date: document.getElementById('formDate').value,
            heure_debut: document.getElementById('formHeureDebut').value || null,
            heure_fin: document.getElementById('formHeureFin').value || null,
            objectif: document.getElementById('formObjectif').value,
        };

        const url = modeFormulaire === 'creation'
            ? cfg.createUrl
            : `${cfg.updateUrlBase}/${currentEvent.id}`;

        fetch(url, {
            method: modeFormulaire === 'creation' ? 'POST' : 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        }).then(() => {
            tacheFormModal.hide();
            calendar.refetchEvents();
        });
    }

    window.supprimerTache = function () {
        if (!currentEvent) return;
        if (!confirm('Supprimer définitivement cette tâche ?')) return;

        fetch(`${cfg.destroyUrlBase}/${currentEvent.id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken(), 'Accept': 'application/json' },
        }).then(() => {
            tacheDetailModal.hide();
            calendar.refetchEvents();
        });
    };

    window.envoyerReponse = envoyerReponse;
})();
</script>
