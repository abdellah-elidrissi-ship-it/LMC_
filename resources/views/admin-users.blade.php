<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LMC Conseil — Gestion des Accès</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{--bg:#f1f5f9;--surface:#fff;--surface2:#f8fafc;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--muted:#94a3b8;--accent:#3b82f6;--input-bg:#fff;--input-border:#e2e8f0;--thead-bg:#f1f5f9;--thead-text:#475569;--shadow:0 2px 12px rgba(0,0,0,.06);--btn-bg:#0f172a;--btn-hover:#1e293b;}
        [data-theme="dark"]{--bg:#0f172a;--surface:#1e293b;--surface2:#162032;--border:#334155;--text:#e2e8f0;--text2:#94a3b8;--muted:#64748b;--accent:#3b82f6;--input-bg:#162032;--input-border:#334155;--thead-bg:#162032;--thead-text:#64748b;--shadow:0 2px 12px rgba(0,0,0,.3);--btn-bg:#3b82f6;--btn-hover:#2563eb;}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;transition:background .3s,color .3s;}

        /* ══ NAVBAR — même style que toutes les pages ══ */
        .site-header{background:linear-gradient(135deg,#0f172a,#1e293b);padding:1rem 1.5rem;border-bottom:3px solid #3b82f6;}
        .logo{font-size:1.3rem;font-weight:700;color:white;}
        .logo-sub{font-size:.73rem;color:rgba(255,255,255,.4);margin-top:.1rem;}
        .meta-pill{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5);padding:.28rem .8rem;border-radius:50px;font-size:.73rem;display:inline-flex;align-items:center;gap:.35rem;}
        .theme-btn{width:34px;height:34px;border-radius:50%;border:1px solid rgba(255,255,255,.15);background:rgba(255,255,255,.08);color:rgba(255,255,255,.65);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;}
        .theme-btn:hover{background:rgba(255,255,255,.15);color:white;}
        .nav-wrap{display:flex;gap:.3rem;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.08);padding:.38rem;border-radius:50px;margin-top:.85rem;width:fit-content;}
        .nav-item{padding:.48rem 1.15rem;border-radius:50px;font-size:.82rem;font-weight:500;color:rgba(255,255,255,.5);text-decoration:none;transition:all .2s;display:inline-flex;align-items:center;gap:.35rem;}
        .nav-item:hover{background:rgba(255,255,255,.08);color:white;}
        .nav-item.active{background:white;color:#0f172a;font-weight:600;}

        /* ══ PAGE ══ */
        .page{max-width:1280px;margin:0 auto;padding:28px 32px;}
        .page-title{font-size:20px;font-weight:700;margin-bottom:4px;}
        .page-desc{font-size:13px;color:var(--text2);margin-bottom:24px;}

        .stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px;}
        @media(max-width:900px){.stats{grid-template-columns:repeat(2,1fr);}}
        .sc{background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:20px;box-shadow:var(--shadow);}
        .sc-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:17px;margin-bottom:12px;}
        .sc-icon.blue{background:rgba(59,130,246,.12);color:#3b82f6;}
        .sc-icon.red{background:rgba(239,68,68,.12);color:#ef4444;}
        .sc-icon.yellow{background:rgba(234,179,8,.12);color:#eab308;}
        .sc-icon.green{background:rgba(34,197,94,.12);color:#22c55e;}
        .sc-lbl{font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);margin-bottom:4px;}
        .sc-val{font-size:28px;font-weight:700;color:var(--text);line-height:1;margin-bottom:3px;}
        .sc-sub{font-size:12px;color:var(--muted);}

        .main-grid{display:grid;grid-template-columns:380px 1fr;gap:20px;align-items:start;}
        @media(max-width:1000px){.main-grid{grid-template-columns:1fr;}}

        .card{background:var(--surface);border:1px solid var(--border);border-radius:14px;box-shadow:var(--shadow);overflow:hidden;}
        .card-head{padding:15px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
        .card-title{font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;}
        .card-title i{color:var(--accent);}
        .card-body{padding:20px;}

        .fg{margin-bottom:15px;}
        .fl{display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.07em;color:var(--text2);margin-bottom:6px;}
        .req{color:#ef4444;margin-left:2px;}
        .fc,.fs{width:100%;background:var(--input-bg);border:1px solid var(--input-border);border-radius:9px;padding:9px 13px;font-size:13px;font-family:'Inter',sans-serif;color:var(--text);outline:none;transition:border-color .2s,box-shadow .2s;appearance:none;}
        .fc:focus,.fs:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(59,130,246,.1);}
        .fc::placeholder{color:var(--muted);}
        .sw{position:relative;}
        .sw::after{content:'\F282';font-family:'bootstrap-icons';position:absolute;right:12px;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;font-size:11px;}
        .pww{position:relative;}
        .pwe{position:absolute;right:11px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer;font-size:14px;padding:0;}
        .pwe:hover{color:var(--text2);}
        .hint{font-size:11px;color:var(--muted);margin-top:5px;display:flex;align-items:center;gap:4px;}

        .rpills{display:flex;gap:8px;flex-wrap:wrap;}
        .rr{display:none;}
        .rp{display:flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;border:1.5px solid var(--border);cursor:pointer;font-size:12px;font-weight:500;color:var(--text2);transition:all .18s;user-select:none;}
        .rp:hover{border-color:var(--accent);color:var(--accent);}
        .rr:checked+.rp{border-color:var(--accent);background:rgba(59,130,246,.08);color:var(--accent);}
        .rdot{width:7px;height:7px;border-radius:50%;}
        .rdot.a{background:#ef4444;}.rdot.c{background:#eab308;}.rdot.cn{background:#22c55e;}

        .perms-box{background:var(--surface2);border:1px solid var(--border);border-radius:10px;overflow:hidden;margin-bottom:15px;}
        .perms-hd{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);padding:11px 14px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:5px;}
        .perm-row{display:flex;justify-content:space-between;align-items:center;padding:10px 14px;border-bottom:1px solid var(--border);}
        .perm-row:last-child{border-bottom:none;}
        .perm-info{display:flex;align-items:center;gap:8px;}
        .perm-icon{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;}
        .perm-icon.blue{background:rgba(59,130,246,.1);color:#3b82f6;}
        .perm-icon.green{background:rgba(34,197,94,.1);color:#22c55e;}
        .perm-icon.yellow{background:rgba(234,179,8,.1);color:#eab308;}
        .perm-icon.red{background:rgba(239,68,68,.1);color:#ef4444;}
        .perm-icon.purple{background:rgba(139,92,246,.1);color:#8b5cf6;}
        .perm-icon.pink{background:rgba(236,72,153,.1);color:#ec4899;}
        .perm-name{font-size:12px;font-weight:500;color:var(--text);}
        .perm-desc{font-size:10px;color:var(--muted);margin-top:1px;}

        .toggle-wrap{display:flex;align-items:center;gap:6px;}
        .toggle-lbl{font-size:11px;font-weight:600;color:var(--muted);min-width:28px;text-align:right;}
        .toggle{position:relative;width:40px;height:22px;flex-shrink:0;}
        .toggle input{opacity:0;width:0;height:0;position:absolute;}
        .toggle-slider{position:absolute;inset:0;background:var(--border);border-radius:11px;cursor:pointer;transition:all .2s;}
        .toggle-slider:before{content:'';position:absolute;width:16px;height:16px;left:3px;top:3px;background:#fff;border-radius:50%;transition:all .2s;}
        .toggle input:checked~.toggle-slider{background:#22c55e;}
        .toggle input:checked~.toggle-slider:before{transform:translateX(18px);}
        .toggle-lbl.on{color:#22c55e;}
        .toggle-lbl.off{color:#ef4444;}

        .btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:9px;font-size:13px;font-family:'Inter',sans-serif;font-weight:500;cursor:pointer;border:none;transition:all .18s;}
        .btn-primary{background:var(--btn-bg);color:#fff;}
        .btn-primary:hover{background:var(--btn-hover);}
        .btn-full{width:100%;justify-content:center;}
        .btn-sm{padding:6px 14px;font-size:12px;}
        .btn-ghost{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
        .btn-ghost:hover{border-color:var(--accent);color:var(--accent);}
        .btn-del{background:rgba(239,68,68,.08);color:#ef4444;border:1px solid rgba(239,68,68,.18);}
        .btn-del:hover{background:rgba(239,68,68,.15);}

        .tw{overflow-x:auto;}
        table{width:100%;border-collapse:collapse;}
        thead th{background:var(--thead-bg);color:var(--thead-text);font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;padding:10px 16px;border-bottom:1px solid var(--border);text-align:left;white-space:nowrap;}
        tbody td{padding:12px 16px;border-bottom:1px solid var(--border);font-size:13px;vertical-align:middle;}
        tbody tr:last-child td{border-bottom:none;}
        tbody tr:hover td{background:var(--surface2);}
        .uc{display:flex;align-items:center;gap:10px;}
        .av{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;color:#fff;flex-shrink:0;}
        .un{font-weight:500;font-size:13px;}
        .ue{font-size:11px;color:var(--muted);}
        .rbadge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:500;white-space:nowrap;}
        .rbadge.admin{background:rgba(239,68,68,.1);color:#ef4444;border:1px solid rgba(239,68,68,.2);}
        .rbadge.chef{background:rgba(234,179,8,.1);color:#ca8a04;border:1px solid rgba(234,179,8,.2);}
        .rbadge.cons{background:rgba(34,197,94,.1);color:#16a34a;border:1px solid rgba(34,197,94,.2);}
        .ab{display:flex;gap:6px;}
        .ib{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:12px;cursor:pointer;border:1px solid var(--border);background:var(--surface2);color:var(--text2);transition:all .18s;}
        .ib:hover{border-color:var(--accent);color:var(--accent);background:rgba(59,130,246,.06);}
        .ib.del:hover{border-color:#ef4444;color:#ef4444;background:rgba(239,68,68,.06);}
        .ptags{display:flex;gap:3px;flex-wrap:wrap;}
        .ptag{font-size:10px;padding:2px 6px;border-radius:4px;font-weight:600;}
        .ptag.y{background:rgba(34,197,94,.12);color:#16a34a;}
        .ptag.n{background:rgba(239,68,68,.08);color:#ef4444;}
        .srch{position:relative;}
        .srch i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:12px;pointer-events:none;}
        .si{background:var(--input-bg);border:1px solid var(--input-border);border-radius:8px;padding:7px 10px 7px 30px;font-size:12px;font-family:'Inter',sans-serif;color:var(--text);outline:none;width:200px;transition:border-color .2s;}
        .si:focus{border-color:var(--accent);}
        .si::placeholder{color:var(--muted);}
        .alert{border-radius:10px;padding:11px 15px;font-size:13px;display:flex;align-items:center;gap:8px;margin-bottom:20px;}
        .alert-s{background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);color:#16a34a;}
        .alert-e{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#ef4444;}
        .empty{text-align:center;padding:48px 24px;color:var(--muted);}
        .empty i{font-size:32px;opacity:.3;display:block;margin-bottom:8px;}
        .ov{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);backdrop-filter:blur(4px);z-index:1000;align-items:center;justify-content:center;}
        .ov.open{display:flex;}
        .modal{background:var(--surface);border:1px solid var(--border);border-radius:14px;width:100%;max-width:500px;padding:26px;box-shadow:0 20px 60px rgba(0,0,0,.25);animation:mIn .22s ease both;max-height:90vh;overflow-y:auto;}
        @keyframes mIn{from{opacity:0;transform:scale(.96)}to{opacity:1;transform:scale(1)}}
        .modal-title{font-size:15px;font-weight:700;margin-bottom:4px;}
        .modal-sub{font-size:12px;color:var(--text2);margin-bottom:20px;}
        .modal-actions{display:flex;gap:8px;justify-content:flex-end;margin-top:20px;}
        .admin-note{background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.15);border-radius:9px;padding:10px 13px;font-size:12px;color:#ef4444;display:flex;align-items:center;gap:7px;margin-bottom:15px;}
    </style>
</head>
<body>
<script>(function(){const t=localStorage.getItem('lmc-theme')||'dark';document.documentElement.setAttribute('data-theme',t);})();</script>

{{-- ══ NAVBAR — même style que toutes les pages ══ --}}
<div class="site-header">
    <div style="max-width:1280px;margin:0 auto;padding:0 1rem;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
            <div>
                <div class="logo">LMC CONSEIL</div>
                <div class="logo-sub">Gestion des accès & utilisateurs</div>
            </div>
            <div style="display:flex;align-items:center;gap:.5rem;padding-top:.25rem;">
                <span class="meta-pill"><i class="bi bi-shield-fill"></i> {{ auth()->user()->name }}</span>
                <span class="meta-pill"><i class="bi bi-clock"></i> {{ now()->format('d/m/Y') }}</span>
                <button class="theme-btn" id="themeToggle" title="Changer thème">
                    <i class="bi bi-sun-fill" id="themeIcon"></i>
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
        <div class="nav-wrap">
            <a href="/"                class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-table"></i> Données
            </a>
            <a href="/tableau-de-bord" class="nav-item {{ request()->is('tableau-de-bord') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Tableau de Bord
            </a>
            <a href="/consultants"     class="nav-item {{ request()->is('consultants') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Consultants
            </a>
            <a href="/nouveau-projet"  class="nav-item {{ request()->is('nouveau-projet') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Nouveau Projet
            </a>
            @if(auth()->check() && auth()->user()->isSuperAdmin())
            <a href="/admin/users" class="nav-item {{ request()->is('admin/users') ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i> Accès
            </a>
            @endif
        </div>
    </div>
</div>

<script>
(function(){
    const t = localStorage.getItem('lmc-theme') || 'dark';
    document.documentElement.setAttribute('data-theme', t);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = t === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
})();
document.getElementById('themeToggle')?.addEventListener('click', () => {
    const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('lmc-theme', next);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = next === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
});
</script>

<div class="page">

    @if(session('success'))
    <div class="alert alert-s"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-e"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    @endif

    <div class="page-title">Gestion des Accès</div>
    <div class="page-desc">Créez des comptes et définissez les permissions de chaque utilisateur</div>

    <div class="stats">
        <div class="sc"><div class="sc-icon blue"><i class="bi bi-people-fill"></i></div><div class="sc-lbl">Total</div><div class="sc-val">{{ $users->count() }}</div><div class="sc-sub">Utilisateurs actifs</div></div>
        <div class="sc"><div class="sc-icon red"><i class="bi bi-shield-fill"></i></div><div class="sc-lbl">Super Admins</div><div class="sc-val">{{ $users->where('role','super_admin')->count() }}</div><div class="sc-sub">Accès complet</div></div>
        <div class="sc"><div class="sc-icon yellow"><i class="bi bi-person-badge-fill"></i></div><div class="sc-lbl">Chefs Projet</div><div class="sc-val">{{ $users->where('role','chef_projet')->count() }}</div><div class="sc-sub">Gestion projets</div></div>
        <div class="sc"><div class="sc-icon green"><i class="bi bi-person-fill"></i></div><div class="sc-lbl">Consultants</div><div class="sc-val">{{ $users->where('role','consultant')->count() }}</div><div class="sc-sub">Lecture & suivi</div></div>
    </div>

    <div class="main-grid">

        {{-- FORM --}}
        <div class="card">
            <div class="card-head">
                <div class="card-title"><i class="bi bi-person-plus-fill"></i> Créer un compte</div>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/users">
                    @csrf

                    <div class="fg">
                        <label class="fl">Consultant <span class="req">*</span></label>
                        <div class="sw">
                            <select name="consultant_id" class="fs" required onchange="fillName(this)">
                                <option value="">— Sélectionner —</option>
                                @foreach($consultants as $c)
                                <option value="{{ $c->id }}" data-nom="{{ $c->nom_complet }}" {{ old('consultant_id')==$c->id?'selected':'' }}>
                                    {{ $c->nom_complet }}{{ $c->user_id?' ✓':'' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="hint"><i class="bi bi-info-circle"></i> ✓ = a déjà un compte</div>
                    </div>

                    <div class="fg">
                        <label class="fl">Nom affiché <span class="req">*</span></label>
                        <input type="text" name="name" id="nameInp" class="fc" placeholder="Nom complet" value="{{ old('name') }}" required>
                    </div>

                    <div class="fg">
                        <label class="fl">Email <span class="req">*</span></label>
                        <input type="email" name="email" class="fc" placeholder="prenom.nom@lmc.ma" value="{{ old('email') }}" required>
                    </div>

                    <div class="fg">
                        <label class="fl">Mot de passe <span class="req">*</span></label>
                        <div class="pww">
                            <input type="password" name="password" id="pwInp" class="fc" placeholder="Min. 8 caractères" required minlength="8">
                            <button type="button" class="pwe" onclick="togglePw('pwInp','pwIco')"><i class="bi bi-eye" id="pwIco"></i></button>
                        </div>
                    </div>

                    <div class="fg">
                        <label class="fl">Rôle <span class="req">*</span></label>
                        <div class="rpills">
                            <input type="radio" name="role" value="super_admin" id="r1" class="rr" {{ old('role')=='super_admin'?'checked':'' }} onchange="onRoleChange('super_admin','create')">
                            <label for="r1" class="rp"><span class="rdot a"></span> Super Admin</label>
                            <input type="radio" name="role" value="chef_projet" id="r2" class="rr" {{ old('role','chef_projet')=='chef_projet'?'checked':'' }} onchange="onRoleChange('chef_projet','create')">
                            <label for="r2" class="rp"><span class="rdot c"></span> Chef Projet</label>
                            <input type="radio" name="role" value="consultant" id="r3" class="rr" {{ old('role')=='consultant'?'checked':'' }} onchange="onRoleChange('consultant','create')">
                            <label for="r3" class="rp"><span class="rdot cn"></span> Consultant</label>
                        </div>
                    </div>

                    <div id="createPermsWrap"></div>

                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="bi bi-person-plus-fill"></i> Créer le compte
                    </button>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card">
            <div class="card-head">
                <div class="card-title"><i class="bi bi-people-fill"></i> Utilisateurs ({{ $users->count() }})</div>
                <div class="srch">
                    <i class="bi bi-search"></i>
                    <input type="text" class="si" placeholder="Rechercher..." oninput="filterUsers(this.value)">
                </div>
            </div>

            @if($users->isEmpty())
            <div class="empty"><i class="bi bi-people"></i><span>Aucun utilisateur créé</span></div>
            @else
            <div class="tw">
                <table>
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Rôle</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach($users as $user)
                        @php
                            $cols=['#3b82f6','#8b5cf6','#06b6d4','#f59e0b','#ec4899','#10b981'];
                            $col=$cols[abs(crc32($user->name))%count($cols)];
                            $ini=collect(explode(' ',$user->name))->take(2)->map(fn($w)=>strtoupper($w[0]??''))->join('');
                            $perms=$user->permissions ?? [];
                            $permLabels=['voir_details'=>'Détails','creer_projets'=>'Créer','modifier_projets'=>'Modifier','supprimer_projets'=>'Supprimer','voir_consultants'=>'Consultants','voir_gantt'=>'Gantt'];
                        @endphp
                        <tr class="urow">
                            <td>
                                <div class="uc">
                                    <div class="av" style="background:{{ $col }}">{{ $ini }}</div>
                                    <div>
                                        <div class="un">{{ $user->name }}</div>
                                        <div class="ue">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->role==='super_admin') <span class="rbadge admin"><i class="bi bi-shield-fill"></i> Super Admin</span>
                                @elseif($user->role==='chef_projet') <span class="rbadge chef"><i class="bi bi-person-badge-fill"></i> Chef Projet</span>
                                @else <span class="rbadge cons"><i class="bi bi-person-fill"></i> Consultant</span>
                                @endif
                            </td>
                            <td>
                                @if($user->role==='super_admin')
                                    <span style="font-size:11px;color:#22c55e;font-weight:600">Tout autorisé</span>
                                @else
                                    <div class="ptags">
                                        @foreach($permLabels as $key => $label)
                                            @if(($perms[$key]??'no')==='yes')
                                            <span class="ptag y">{{ $label }}</span>
                                            @endif
                                        @endforeach
                                        @if(collect($permLabels)->keys()->every(fn($k)=>($perms[$k]??'no')==='no'))
                                        <span style="font-size:11px;color:var(--muted)">Aucun accès</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="ab">
                                    <button class="ib" title="Modifier"
                                        onclick="openEdit({{ $user->id }},'{{ addslashes($user->name) }}','{{ $user->email }}','{{ $user->role }}',{{ json_encode($perms) }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    @if($user->id!==auth()->id())
                                    <button class="ib del" title="Supprimer"
                                        onclick="openDelete({{ $user->id }},'{{ addslashes($user->name) }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="ov" id="editOv">
    <div class="modal">
        <div class="modal-title">Modifier l'utilisateur</div>
        <div class="modal-sub">Mettez à jour le rôle et les permissions</div>
        
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')
            
            <div class="fg">
                <label class="fl">Nom</label>
                <input type="text" name="name" id="eName" class="fc" required>
            </div>
            
            <div class="fg">
                <label class="fl">Email</label>
                <input type="email" name="email" id="eEmail" class="fc" required>
            </div>
            
            <div class="fg">
                <label class="fl">Rôle</label>
                <div class="sw">
                    <select name="role" id="eRole" class="fs" onchange="onRoleChange(this.value,'edit')">
                        <option value="super_admin">Super Admin</option>
                        <option value="chef_projet">Chef de Projet</option>
                        <option value="consultant">Consultant</option>
                    </select>
                </div>
            </div>
            
            <div class="fg">
                <label class="fl">Nouveau mot de passe</label>
                <input type="password" name="password" id="ePw" class="fc" placeholder="Laisser vide pour ne pas changer">
            </div>
            
            <div id="editPermsWrap"></div>
            
            <div class="modal-actions">
                <button type="button" class="btn btn-ghost btn-sm" onclick="closeOv('editOv')">Annuler</button>
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="ov" id="delOv">
    <div class="modal">
        <div class="modal-title" style="color:#ef4444"><i class="bi bi-exclamation-triangle-fill"></i> Supprimer l'utilisateur</div>
        <div class="modal-sub" id="delSub">Cette action est irréversible.</div>
        <form method="POST" id="delForm">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn btn-ghost btn-sm" onclick="closeOv('delOv')">Annuler</button>
                <button type="submit" class="btn btn-del btn-sm"><i class="bi bi-trash-fill"></i> Supprimer</button>
            </div>
        </form>
    </div>
</div>

<script>
const PERMS_DEF = [
    { key:'voir_details',      label:'Voir les détails',    desc:'Accéder à la fiche complète du projet', icon:'bi-eye-fill',         color:'blue'   },
    { key:'creer_projets',     label:'Créer un projet',     desc:'Ajouter de nouveaux projets',           icon:'bi-plus-circle-fill', color:'green'  },
    { key:'modifier_projets',  label:'Modifier un projet',  desc:'Éditer les informations du projet',     icon:'bi-pencil-fill',      color:'yellow' },
    { key:'supprimer_projets', label:'Supprimer un projet', desc:'Supprimer définitivement un projet',    icon:'bi-trash-fill',       color:'red'    },
    { key:'voir_consultants',  label:'Voir les consultants',desc:'Accéder à la page consultants',         icon:'bi-people-fill',      color:'purple' },
    { key:'voir_gantt',        label:'Voir le Gantt',       desc:'Accéder au planning Gantt',             icon:'bi-bar-chart-steps',  color:'pink'   },
];
let createPerms = {}, editPerms = {};

function renderPerms(containerId, permsState, prefix, role) {
    const wrap = document.getElementById(containerId);
    if (role === 'super_admin') {
        wrap.innerHTML = `<div class="admin-note"><i class="bi bi-shield-fill"></i> Super Admin a accès à tout — aucune restriction possible.</div>`;
        return;
    }
    const rows = PERMS_DEF.map(p => {
        const isOn = (permsState[p.key] ?? 'no') === 'yes';
        return `<div class="perm-row">
            <div class="perm-info">
                <div class="perm-icon ${p.color}"><i class="bi ${p.icon}"></i></div>
                <div><div class="perm-name">${p.label}</div><div class="perm-desc">${p.desc}</div></div>
            </div>
            <div class="toggle-wrap">
                <span class="toggle-lbl ${isOn?'on':'off'}" id="lbl_${prefix}_${p.key}">${isOn?'OUI':'NON'}</span>
                <label class="toggle">
                    <input type="checkbox" ${isOn?'checked':''} onchange="togglePerm('${p.key}','${prefix}',this.checked)">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <input type="hidden" name="permissions[${p.key}]" id="hid_${prefix}_${p.key}" value="${isOn?'yes':'no'}">
        </div>`;
    }).join('');
    wrap.innerHTML = `<div class="perms-box"><div class="perms-hd"><i class="bi bi-key-fill"></i> Permissions — par défaut tout est NON</div>${rows}</div>`;
}

function togglePerm(key, prefix, checked) {
    const val = checked ? 'yes' : 'no';
    if (prefix === 'create') createPerms[key] = val;
    else editPerms[key] = val;
    document.getElementById(`hid_${prefix}_${key}`).value = val;
    const lbl = document.getElementById(`lbl_${prefix}_${key}`);
    lbl.textContent = checked ? 'OUI' : 'NON';
    lbl.className = `toggle-lbl ${checked?'on':'off'}`;
}

function onRoleChange(role, prefix) {
    if (prefix === 'create') { createPerms = {}; renderPerms('createPermsWrap', createPerms, 'create', role); }
    else { editPerms = {}; renderPerms('editPermsWrap', editPerms, 'edit', role); }
}

const checked = document.querySelector('.rr:checked');
renderPerms('createPermsWrap', {}, 'create', checked ? checked.value : 'chef_projet');

function fillName(sel) {
    const opt = sel.options[sel.selectedIndex];
    if (opt.value) document.getElementById('nameInp').value = opt.dataset.nom || '';
}
function togglePw(inp, ico) {
    const i = document.getElementById(inp);
    document.getElementById(ico).className = (i.type = i.type === 'password' ? 'text' : 'password') === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
}
function filterUsers(q) {
    q = q.toLowerCase();
    document.querySelectorAll('.urow').forEach(r => r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none');
}

function openEdit(id, name, email, role, perms) {
    // Mettre à jour l'action du formulaire
    document.getElementById('editForm').action = '/admin/users/' + id;
    
    // Remplir les champs
    document.getElementById('eName').value = name;
    document.getElementById('eEmail').value = email;
    document.getElementById('eRole').value = role;
    document.getElementById('ePw').value = '';
    
    // Gérer les permissions
    editPerms = perms && typeof perms === 'object' ? {...perms} : {};
    renderPerms('editPermsWrap', editPerms, 'edit', role);
    
    // Ouvrir le modal
    document.getElementById('editOv').classList.add('open');
}

function openDelete(id, name) {
    document.getElementById('delSub').textContent = `Supprimer "${name}" ? Cette action est irréversible.`;
    document.getElementById('delForm').action = `/admin/users/${id}`;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    document.querySelector('#delForm input[name="_token"]').value = token;
    document.getElementById('delOv').classList.add('open');
}

function closeOv(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.ov').forEach(o => o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); }));
</script>
</body>
</html>