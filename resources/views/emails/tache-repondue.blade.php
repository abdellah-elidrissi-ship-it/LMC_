@extends('emails.layout')

@section('title', 'Réponse à une tâche')

@section('content')
<h2 style="margin:0 0 16px; color:#0f172a; font-size:20px;">Réponse à une mission</h2>
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 20px;">
    <strong>{{ $tache->consultant->nom_complet ?? 'Le consultant' }}</strong>
    a répondu à la tâche suivante :
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
        <td style="padding:6px 0; color:#64748b; font-size:14px;">Nouveau statut</td>
        <td style="padding:6px 0; font-size:14px;">
            <strong style="color:#2563eb;">{{ $tache->statut }}</strong>
        </td>
    </tr>
</table>
@if($tache->commentaire)
<p style="color:#334155; font-size:14px; line-height:1.6; margin:0 0 20px;">
    <strong>Commentaire du consultant :</strong><br>{{ $tache->commentaire }}
</p>
@endif
<div style="text-align:center; margin:28px 0 8px;">
    <a href="{{ $url }}"
        style="background:#2563eb; color:#ffffff; text-decoration:none; padding:12px 28px; border-radius:8px; font-size:14px; font-weight:600; display:inline-block;">
        Voir le calendrier
    </a>
</div>
@endsection
