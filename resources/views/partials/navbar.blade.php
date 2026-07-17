<style>
    .site-header {
        background: linear-gradient(135deg, #0a1f38 0%, #123a5e 60%, #164b78 100%);
        padding: 1rem 0;
        border-bottom: 3px solid #2ea8e0;
        position: sticky;
        top: 0;
        z-index: 50;
        box-shadow: 0 4px 20px rgba(10, 31, 56, 0.25);
        transition: transform 0.3s ease;
    }
    .site-header.nav-hidden {
    transform: translateY(-100%);
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
        gap: 0.85rem;
    }

    .logo-badge {
    height: 52px;
    width: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.logo-badge svg {
    width: 52px;
    height: 52px;
    fill: #ffffff;
}

    .logo-text {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .logo-main {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: -0.01em;
    }

    .logo-sub {
        font-size: 0.68rem;
        font-weight: 600;
        color: #6fd3f5;
        letter-spacing: 0.06em;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
        background: rgba(255,255,255,0.08);
        padding: 0.4rem 1rem;
        border-radius: 9999px;
        border: 1px solid rgba(255,255,255,0.12);
        font-size: 0.85rem;
        font-weight: 500;
    }

    .meta-pill {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.75);
        padding: 0.4rem 1rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .theme-btn {
        width: 38px;
        height: 38px;
        border-radius: 9999px;
        border: 1px solid rgba(255,255,255,0.15);
        background: rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.75);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .theme-btn:hover {
        background: #2ea8e0;
        color: #0a1f38;
        border-color: #2ea8e0;
    }

    .notif-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background: #ef4444;
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        min-width: 16px;
        height: 16px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
        line-height: 1;
    }

    .notif-wrapper {
        position: relative;
    }

    .notif-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        min-width: 300px;
        max-height: 360px;
        overflow-y: auto;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 12px 32px rgba(10, 31, 56, 0.2);
        padding: 0.5rem 0;
        z-index: 60;
    }

    .notif-dropdown.show {
        display: block;
    }

    .notif-item {
        display: block;
        padding: 0.55rem 1rem;
        text-decoration: none;
    }

    .notif-item:hover {
        background: rgba(15, 23, 42, 0.04);
    }

    .notif-item-empty {
        display: block;
        padding: 0.55rem 1rem;
        font-size: 0.85rem;
        color: #94a3b8;
    }

    .notif-item-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-primary, #0f172a);
        white-space: normal;
    }

    .notif-item-date {
        font-size: 0.72rem;
        color: #94a3b8;
    }

    .nav-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .nav-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 0.3rem;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.1);
        padding: 0.4rem;
        border-radius: 9999px;
        margin-top: 0.85rem;
        width: fit-content;
    }

    .nav-item {
        padding: 0.48rem 1.25rem;
        border-radius: 9999px;
        font-size: 0.82rem;
        font-weight: 500;
        color: rgba(255,255,255,0.65);
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        white-space: nowrap;
    }

    .nav-item:hover {
        background: rgba(255,255,255,0.1);
        color: white;
    }

    .nav-item.active {
        background: #2ea8e0;
        color: #0a1f38;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(46,168,224,0.35);
    }

    @media (max-width: 768px) {
        .header-container { padding: 0 1rem; flex-wrap: wrap; gap: 0.75rem; }
        .nav-container { padding: 0 1rem; }
        .meta-pill { display: none; }
    }
</style>

<div class="site-header">
    <div class="header-container">
        <div class="logo-wrapper">
            <span class="logo-badge">
                <svg viewBox="0 0 441 499" xmlns="http://www.w3.org/2000/svg">
    <g transform="translate(0,499) scale(0.1,-0.1)" fill="#ffffff" stroke="none">
        <path d="M1971 4969 c-849 -89 -1581 -677 -1852 -1489 -434 -1302 401 -2662 1766 -2876 148 -23 478 -23 627 -1 1093 165 1890 1081 1890 2172 0 586 -209 1108 -609 1526 -471 491 -1146 738 -1822 668z m441 -54 c295 -16 635 -129 909 -301 71 -44 86 -58 82 -74 -4 -14 0 -20 12 -20 16 0 16 -2 1 -25 -9 -14 -13 -25 -9 -25 4 0 -2 -7 -13 -15 -10 -8 -15 -15 -10 -15 5 0 1 -9 -9 -20 -12 -14 -25 -18 -41 -14 -13 4 -24 2 -24 -3 0 -5 -18 -29 -39 -53 -35 -40 -38 -47 -25 -61 20 -22 18 -31 -11 -53 -13 -10 -22 -22 -19 -27 11 -19 -19 -8 -72 26 -230 147 -634 275 -869 275 -50 0 -56 2 -45 15 7 9 8 15 2 15 -5 0 -15 12 -21 28 -6 15 -21 42 -33 61 -19 30 -20 37 -8 69 7 20 14 75 16 122 1 47 3 91 3 98 1 9 17 11 64 8 34 -3 106 -8 159 -11z m-22 -471 c524 -44 1058 -411 1300 -893 30 -60 31 -66 20 -112 -23 -95 -91 -128 -281 -136 -227 -10 -392 30 -638 154 -215 109 -443 269 -643 453 -98 90 -104 93 -114 48 -25 -114 26 -220 180 -374 165 -164 358 -301 831 -589 240 -146 297 -187 380 -277 104 -111 158 -245 135 -336 -27 -108 -68 -146 -257 -242 -237 -119 -329 -225 -277 -319 31 -56 75 -73 168 -68 117 8 185 45 311 172 146 147 244 239 250 234 2 -3 -20 -55 -49 -115 -232 -469 -666 -802 -1179 -906 -164 -34 -493 -33 -649 0 -292 63 -533 181 -764 374 -209 176 -438 505 -420 603 10 49 66 108 121 125 69 21 297 24 405 6 304 -53 728 -297 1055 -607 87 -83 96 -82 103 11 15 202 -285 479 -938 870 -270 162 -351 219 -436 304 -133 135 -184 263 -149 381 24 86 66 124 218 201 157 80 234 130 276 181 95 114 38 223 -116 223 -133 0 -204 -43 -416 -255 -87 -86 -160 -155 -163 -152 -11 11 88 199 165 314 284 424 750 695 1260 733 102 7 169 6 311 -6z M1975 3459 c-10 -16 16 -142 34 -168 49 -68 132 -112 307 -161 177 -49 454 -87 454 -61 0 6 -4 11 -9 11 -11 0 -272 175 -366 245 -74 56 -80 59 -246 100 -93 24 -172 39 -174 34z M2236 2982 c-13 -21 17 -83 56 -117 76 -65 152 -80 462 -95 183 -9 474 -39 546 -56 l24 -5 -19 21 c-25 28 -96 76 -263 179 l-133 81 -334 0 c-184 0 -336 -4 -339 -8z M1105 2830 c23 -25 164 -119 305 -203 l96 -57 332 0 332 0 0 35 c0 24 -9 45 -32 70 -68 78 -156 101 -449 115 -188 9 -488 39 -574 56 l-30 6 20 -22z M1763 2410 c76 -50 182 -122 235 -162 96 -71 97 -72 247 -109 195 -50 185 -51 185 14 -1 111 -66 185 -209 237 -178 65 -396 109 -536 110 l-60 0 138 -90z M1865 470 c-355 -25 -603 -91 -578 -155 17 -46 199 -93 468 -120 154 -16 680 -23 795 -11 25 3 77 8 115 11 297 26 504 97 449 153 -98 97 -718 158 -1249 122z"/>
    </g>
</svg>
            </span>
            <div class="logo-text">
                <span class="logo-main">LMC</span>
                <span class="logo-sub">LEAD MANAGEMENT CONSULTING</span>
            </div>
        </div>

        <div class="header-actions">
            <div class="user-info">
                <i class="bi bi-person-circle"></i>
                <span class="user-name">{{ auth()->user()->name ?? 'Utilisateur' }}</span>
            </div>
            <span class="meta-pill">
                <i class="bi bi-calendar-check"></i>
                {{ now()->format('d/m/Y') }}
            </span>
            @auth
            @php $unreadNotifs = auth()->user()->unreadNotifications; @endphp
            <div class="notif-wrapper" id="notifWrapper">
                <button class="theme-btn position-relative" id="notifBell" type="button" aria-expanded="false" title="Notifications">
                    <i class="bi bi-bell-fill"></i>
                    @if($unreadNotifs->count() > 0)
                    <span class="notif-badge" id="notifBadge">{{ $unreadNotifs->count() }}</span>
                    @endif
                </button>
                <div class="notif-dropdown" id="notifDropdown">
                    @forelse($unreadNotifs->take(8) as $notif)
                    <a class="notif-item" href="{{ route('calendrier.index') }}">
                        <div class="notif-item-title">{{ $notif->data['message'] ?? 'Nouvelle notification' }}</div>
                        <div class="notif-item-date">{{ $notif->created_at->diffForHumans() }}</div>
                    </a>
                    @empty
                    <span class="notif-item-empty">Aucune notification</span>
                    @endforelse
                </div>
            </div>
            @endauth
            <button class="theme-btn" id="themeToggle">
                <i class="bi bi-moon-fill" id="themeIcon"></i>
            </button>
            @isset($navBackUrl)
            <a href="{{ $navBackUrl }}" class="theme-btn" title="{{ $navBackLabel ?? 'Retour' }}">
                <i class="bi bi-arrow-left"></i>
            </a>
            @else
            <form method="POST" action="/logout" style="margin:0">
                @csrf
                <button type="button" class="theme-btn" title="Déconnexion"
                    onclick="this.closest('form').submit()">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
            @endisset
        </div>
    </div>

    @auth
    <div class="nav-container">
        <div class="nav-wrap">
            <a href="/" class="nav-item {{ ($navActive ?? '') === 'donnees' ? 'active' : '' }}">
                <i class="bi bi-table"></i> Données
            </a>
            @if(auth()->user()->hasPermission('voir_tableau_bord'))
            <a href="/tableau-de-bord" class="nav-item {{ ($navActive ?? '') === 'tableau' ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Tableau de Bord
            </a>
            @endif
            @if(auth()->user()->hasPermission('voir_consultants'))
            <a href="/consultants" class="nav-item {{ ($navActive ?? '') === 'consultants' ? 'active' : '' }}">
                <i class="bi bi-people"></i> Consultants
            </a>
            @endif
            @if(auth()->user()->hasPermission('creer_projets'))
            <a href="/nouveau-projet" class="nav-item {{ ($navActive ?? '') === 'nouveau' ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Nouveau Projet
            </a>
            @endif
            @if(auth()->user()->consultant_id)
            <a href="/calendrier" class="nav-item {{ ($navActive ?? '') === 'calendrier' ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> Calendrier
            </a>
            @endif
            @if(auth()->user()->isSuperAdmin() || auth()->user()->isChefProjet())
            <a href="/admin/calendrier" class="nav-item {{ ($navActive ?? '') === 'admin-calendrier' ? 'active' : '' }}">
                <i class="bi bi-calendar-week"></i> Gestion tâches
            </a>
            @endif
            @if(auth()->user()->isSuperAdmin())
            <a href="/admin/users" class="nav-item {{ ($navActive ?? '') === 'admin' ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i> Accès
            </a>
            @endif
        </div>
    </div>
    @endauth
</div>

<script>
(function() {
    let lastScroll = 0;
    const header = document.querySelector('.site-header');
    const threshold = 80; // bach ma يخبيش mnin تكون f l'top

    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

        if (currentScroll <= threshold) {
            // f l'top dyal page - dima bان
            header.classList.remove('nav-hidden');
        } else if (currentScroll > lastScroll) {
            // scroll l tحت -> khabbi
            header.classList.add('nav-hidden');
        } else {
            // scroll l fou9 -> bان
            header.classList.remove('nav-hidden');
        }

        lastScroll = currentScroll;
    }, { passive: true });
})();

const notifWrapper = document.getElementById('notifWrapper');
const notifBell = document.getElementById('notifBell');
const notifDropdown = document.getElementById('notifDropdown');
if (notifWrapper && notifBell && notifDropdown) {
    let notifMarkedRead = false;

    notifBell.addEventListener('click', function (e) {
        e.stopPropagation();
        const isOpen = notifDropdown.classList.toggle('show');
        notifBell.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

        if (isOpen && !notifMarkedRead) {
            notifMarkedRead = true;
            const badge = document.getElementById('notifBadge');
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (badge && csrfMeta) {
                fetch('{{ route('notifications.lire-tout') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfMeta.content,
                        'Accept': 'application/json',
                    },
                }).then(() => badge.remove());
            }
        }
    });

    document.addEventListener('click', function (e) {
        if (!notifWrapper.contains(e.target)) {
            notifDropdown.classList.remove('show');
            notifBell.setAttribute('aria-expanded', 'false');
        }
    });
}
</script>