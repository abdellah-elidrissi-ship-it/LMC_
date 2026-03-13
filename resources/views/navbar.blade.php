<style>
    /* ══ NAVBAR PARTAGÉE ══ */
    .site-header {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        padding: 1rem 0;
        border-bottom: 3px solid #3b82f6;
    }

    .logo     { font-size:1.3rem; font-weight:700; color:white; }
    .logo-sub { font-size:.73rem; color:rgba(255,255,255,.4); margin-top:.1rem; }

    .meta-pill {
        background:rgba(255,255,255,.08);
        border:1px solid rgba(255,255,255,.1);
        color:rgba(255,255,255,.5);
        padding:.28rem .8rem; border-radius:50px; font-size:.73rem;
    }

    .theme-btn {
        width:34px; height:34px; border-radius:50%;
        border:1px solid rgba(255,255,255,.15);
        background:rgba(255,255,255,.08);
        color:rgba(255,255,255,.65);
        display:flex; align-items:center; justify-content:center;
        cursor:pointer; transition:all .2s;
    }
    .theme-btn:hover { background:rgba(255,255,255,.15); color:white; }

    .btn-retour {
        background:rgba(255,255,255,.1);
        border:1.5px solid rgba(255,255,255,.2);
        color:white; padding:.45rem 1.1rem;
        border-radius:50px; font-weight:600;
        font-size:.82rem; text-decoration:none;
        transition:.2s; display:inline-flex;
        align-items:center; gap:.4rem;
    }
    .btn-retour:hover { background:white; color:#0f172a; }

    .nav-wrap {
        display:flex; gap:.3rem;
        background:rgba(255,255,255,.1);
        border:1px solid rgba(255,255,255,.08);
        padding:.38rem; border-radius:50px;
        margin-top:.85rem; width:fit-content;
    }

    .nav-item {
        padding:.48rem 1.15rem; border-radius:50px;
        font-size:.82rem; font-weight:500;
        color:rgba(255,255,255,.5); text-decoration:none;
        transition:all .2s; display:inline-flex; align-items:center; gap:.35rem;
    }
    .nav-item:hover  { background:rgba(255,255,255,.08); color:white; }
    .nav-item.active { background:white; color:#0f172a; font-weight:600; }
</style>

<div class="site-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="logo">{{ $navTitle ?? 'LMC CONSEIL' }}</div>
                <div class="logo-sub">{{ $navSubtitle ?? 'Campagne 2025 — 2026' }}</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="meta-pill"><i class="bi bi-database me-1"></i>v2.0</span>
                <span class="meta-pill"><i class="bi bi-clock me-1"></i>{{ now()->format('d/m/Y') }}</span>
                <button class="theme-btn" id="themeToggle" title="Changer thème">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>
                @isset($navBackUrl)
                <a href="{{ $navBackUrl }}" class="btn-retour">
                    <i class="bi bi-arrow-left"></i> {{ $navBackLabel ?? 'Retour' }}
                </a>
                @endisset
                @unless(isset($navBackUrl))
                <form method="POST" action="/logout" style="margin:0">
                    @csrf
                    <button type="button" class="theme-btn" title="Déconnexion"
                        onclick="this.closest('form').submit()">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
                @endunless
            </div>
        </div>

        <div class="nav-wrap">
            <a href="/" class="nav-item {{ ($navActive ?? '') === 'donnees' ? 'active' : '' }}">
                <i class="bi bi-table"></i> Données
            </a>
            <a href="/tableau-de-bord" class="nav-item {{ ($navActive ?? '') === 'tableau' ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Tableau de Bord
            </a>
            <a href="/consultants" class="nav-item {{ ($navActive ?? '') === 'consultants' ? 'active' : '' }}">
                <i class="bi bi-people"></i> Consultants
            </a>
            <a href="/nouveau-projet" class="nav-item {{ ($navActive ?? '') === 'nouveau' ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Nouveau Projet
            </a>
            @isset($navExtra)
                {!! $navExtra !!}
            @endisset
            @if(auth()->check() && auth()->user()->isSuperAdmin())
            <a href="/admin/users" class="nav-item {{ ($navActive ?? '') === 'admin' ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i> Accès
            </a>
            @endif
        </div>
    </div>
</div>

<script>
(function() {
    const saved = localStorage.getItem('lmc-theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = saved === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
})();
document.getElementById('themeToggle')?.addEventListener('click', () => {
    const next = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('lmc-theme', next);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = next === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
});
</script>