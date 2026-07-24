@extends('emails.layout')

@section('title', 'Réponse à une tâche')

@section('content')
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 22px;">
    <strong style="color:#0a1f38;">{{ $tache->consultant->nom_complet ?? 'Le consultant' }}</strong>
    a répondu à la tâche suivante :
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc; border:1px solid #e7ebf1; border-radius:10px; margin:0 0 22px;">
<tr><td style="padding:20px 22px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td style="padding:6px 0; color:#64748b; font-size:13px; width:150px; vertical-align:top;">Titre</td>
            <td style="padding:6px 0; color:#0a1f38; font-size:14px; font-weight:700;">{{ $tache->titre }}</td>
        </tr>
        <tr>
            <td style="padding:6px 0; color:#64748b; font-size:13px; vertical-align:top;">Client</td>
            <td style="padding:6px 0; color:#0a1f38; font-size:14px;">{{ $tache->client->nom_client ?? '—' }}</td>
        </tr>
        <tr>
            <td style="padding:10px 0 0; color:#64748b; font-size:13px; vertical-align:top;">Nouveau statut</td>
            <td style="padding:10px 0 0; font-size:14px;">
                <span style="background:#dbeafe; color:#1d4ed8; font-size:12px; font-weight:700; padding:5px 14px; border-radius:999px; display:inline-block;">
                    {{ $tache->statut }}
                </span>
            </td>
        </tr>
    </table>
</td></tr>
</table>

@if($tache->commentaire)
<p style="color:#334155; font-size:14px; line-height:1.6; margin:0 0 22px;">
    <strong style="color:#0a1f38;">Commentaire du consultant :</strong><br>{{ $tache->commentaire }}
</p>
@endif

<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
<tr><td align="center" style="padding:10px 0 4px;">
    <a href="{{ $url }}"
        style="background:#2563eb; color:#ffffff; text-decoration:none; padding:14px 32px; border-radius:8px; font-size:14px; font-weight:700; display:inline-block; font-family:Arial,Helvetica,sans-serif;">
        Voir le calendrier
    </a>
</td></tr>
</table>
@endsection
