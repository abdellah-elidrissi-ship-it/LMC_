@extends('emails.layout')

@section('title', 'Compte activé')

@section('content')
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 22px;">
    Bonjour {{ $user->name }},<br>
    Bonne nouvelle : votre demande d'accès à LMC Conseil a été validée par un
    administrateur. Vous pouvez maintenant vous connecter avec votre email
    et le mot de passe choisi à l'inscription.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 22px;">
<tr><td style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:14px 18px;">
    <span style="background:#16a34a; color:#ffffff; font-size:12px; font-weight:700; padding:5px 14px; border-radius:999px; display:inline-block;">
        Compte actif
    </span>
</td></tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
<tr><td align="center" style="padding:10px 0 4px;">
    <a href="{{ $url }}"
        style="background:#2563eb; color:#ffffff; text-decoration:none; padding:14px 32px; border-radius:8px; font-size:14px; font-weight:700; display:inline-block; font-family:Arial,Helvetica,sans-serif;">
        Se connecter
    </a>
</td></tr>
</table>
@endsection
