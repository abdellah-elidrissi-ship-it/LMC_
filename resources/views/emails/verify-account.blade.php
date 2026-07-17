@extends('emails.layout')

@section('title', 'Confirmez votre adresse email')

@section('content')
<h2 style="margin:0 0 16px; color:#0f172a; font-size:20px;">Confirmez votre adresse email</h2>
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 20px;">
    Bonjour {{ $user->name }},<br>
    Merci pour votre demande d'accès à LMC Conseil. Confirmez votre adresse
    email pour que votre demande puisse être examinée par un administrateur.
</p>
<div style="text-align:center; margin:28px 0 8px;">
    <a href="{{ $url }}"
        style="background:#2563eb; color:#ffffff; text-decoration:none; padding:12px 28px; border-radius:8px; font-size:14px; font-weight:600; display:inline-block;">
        Confirmer mon email
    </a>
</div>
<p style="color:#94a3b8; font-size:12px; line-height:1.6; margin:20px 0 0;">
    Ce lien expire dans 60 minutes. Si vous n'êtes pas à l'origine de cette
    demande, vous pouvez ignorer cet email.
</p>
@endsection
