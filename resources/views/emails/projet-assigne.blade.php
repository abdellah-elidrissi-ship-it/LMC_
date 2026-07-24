@extends('emails.layout')

@section('title', 'Nouvelle affectation projet')

@section('content')
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 22px;">
    Bonjour,<br>
    Vous avez été affecté au projet suivant par
    <strong style="color:#0a1f38;">{{ $assignePar->name }}</strong>.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc; border:1px solid #e7ebf1; border-radius:10px; margin:0 0 22px;">
<tr><td style="padding:20px 22px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td style="padding:6px 0; color:#64748b; font-size:13px; width:130px; vertical-align:top;">Projet</td>
            <td style="padding:6px 0; color:#0a1f38; font-size:14px; font-weight:700;">{{ $projet->reference_projet }}</td>
        </tr>
        @if($role)
        <tr>
            <td style="padding:6px 0; color:#64748b; font-size:13px; vertical-align:top;">Votre rôle</td>
            <td style="padding:6px 0; color:#0a1f38; font-size:14px;">{{ $role }}</td>
        </tr>
        @endif
    </table>
</td></tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
<tr><td align="center" style="padding:10px 0 4px;">
    <a href="{{ $url }}"
        style="background:#2563eb; color:#ffffff; text-decoration:none; padding:14px 32px; border-radius:8px; font-size:14px; font-weight:700; display:inline-block; font-family:Arial,Helvetica,sans-serif;">
        Voir le projet
    </a>
</td></tr>
</table>
@endsection
