@extends('emails.layout')

@section('title', "Fin d'accès au projet")

@section('content')
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 22px;">
    Bonjour,<br>
    <strong style="color:#0a1f38;">{{ $retirePar->name }}</strong> vous a retiré l'accès au projet suivant :
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#fef2f2; border:1px solid #fecaca; border-radius:10px; margin:0 0 22px;">
<tr><td style="padding:20px 22px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td style="padding:6px 0; color:#64748b; font-size:13px; width:130px; vertical-align:top;">Projet</td>
            <td style="padding:6px 0; color:#0a1f38; font-size:14px; font-weight:700;">{{ $projet->reference_projet }}</td>
        </tr>
    </table>
</td></tr>
</table>

<p style="color:#94a3b8; font-size:12px; line-height:1.6; margin:20px 0 0;">
    Vous n'avez plus accès à ce projet dans l'application. Contactez un
    administrateur si vous pensez qu'il s'agit d'une erreur.
</p>
@endsection
