@extends('emails.layout')

@section('title', 'Fin d\'accès au projet')

@section('content')
<h2 style="margin:0 0 16px; color:#0f172a; font-size:20px;">Fin d'accès au projet</h2>
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 20px;">
    Bonjour,<br>
    <strong>{{ $retirePar->name }}</strong> vous a retiré l'accès au projet suivant :
</p>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:20px;">
    <tr>
        <td style="padding:6px 0; color:#64748b; font-size:14px; width:140px;">Projet</td>
        <td style="padding:6px 0; color:#0f172a; font-size:14px; font-weight:600;">{{ $projet->reference_projet }}</td>
    </tr>
</table>
<p style="color:#94a3b8; font-size:12px; line-height:1.6; margin:20px 0 0;">
    Vous n'avez plus accès à ce projet dans l'application. Contactez un
    administrateur si vous pensez qu'il s'agit d'une erreur.
</p>
@endsection
