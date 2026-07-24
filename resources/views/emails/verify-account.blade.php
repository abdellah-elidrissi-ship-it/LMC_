@extends('emails.layout')

@section('title', 'Confirmez votre adresse email')

@section('content')
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 22px;">
    Bonjour {{ $user->name }},<br>
    Merci pour votre demande d'accès à LMC Conseil. Confirmez votre adresse
    email pour que votre demande puisse être examinée par un administrateur.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
<tr><td align="center" style="padding:10px 0 4px;">
    <a href="{{ $url }}"
        style="background:#2563eb; color:#ffffff; text-decoration:none; padding:14px 32px; border-radius:8px; font-size:14px; font-weight:700; display:inline-block; font-family:Arial,Helvetica,sans-serif;">
        Confirmer mon email
    </a>
</td></tr>
</table>

<p style="color:#94a3b8; font-size:12px; line-height:1.6; margin:24px 0 0; text-align:center;">
    Ce lien expire dans 60 minutes. Si vous n'êtes pas à l'origine de cette
    demande, vous pouvez ignorer cet email.
</p>
@endsection
