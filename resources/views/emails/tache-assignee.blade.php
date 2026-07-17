@extends('emails.layout')

@section('title', 'Nouvelle mission assignée')

@section('content')
<h2 style="margin:0 0 16px; color:#0f172a; font-size:20px;">Nouvelle mission assignée</h2>
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 20px;">
    Bonjour {{ $tache->consultant->nom_complet ?? '' }},<br>
    Une nouvelle tâche vous a été assignée par
    <strong>{{ $tache->assignePar->name ?? "l'administration" }}</strong>.
</p>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:20px;">
    <tr>
        <td style="padding:6px 0; color:#64748b; font-size:14px; width:140px;">Titre</td>
        <td style="padding:6px 0; color:#0f172a; font-size:14px; font-weight:600;">{{ $tache->titre }}</td>
    </tr>
    <tr>
        <td style="padding:6px 0; color:#64748b; font-size:14px;">Client</td>
        <td style="padding:6px 0; color:#0f172a; font-size:14px;">{{ $tache->client->nom_client ?? '—' }}</td>
    </tr>
    <tr>
        <td style="padding:6px 0; color:#64748b; font-size:14px;">Date</td>
        <td style="padding:6px 0; color:#0f172a; font-size:14px;">
            {{ optional($tache->date)->locale('fr')->translatedFormat('d F Y') }}
        </td>
    </tr>
    <tr>
        <td style="padding:6px 0; color:#64748b; font-size:14px;">Horaire</td>
        <td style="padding:6px 0; color:#0f172a; font-size:14px;">
            {{ $tache->heure_debut ? \Illuminate\Support\Str::substr($tache->heure_debut, 0, 5) : '—' }}
            -
            {{ $tache->heure_fin ? \Illuminate\Support\Str::substr($tache->heure_fin, 0, 5) : '—' }}
        </td>
    </tr>
</table>
@if($tache->objectif)
<p style="color:#334155; font-size:14px; line-height:1.6; margin:0 0 20px;">
    <strong>Objectif :</strong><br>{{ $tache->objectif }}
</p>
@endif
<div style="text-align:center; margin:28px 0 8px;">
    <a href="{{ $url }}"
        style="background:#2563eb; color:#ffffff; text-decoration:none; padding:12px 28px; border-radius:8px; font-size:14px; font-weight:600; display:inline-block;">
        Voir la tâche
    </a>
</div>
@endsection
