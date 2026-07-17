@extends('emails.layout')

@section('title', 'Compte activé')

@section('content')
<h2 style="margin:0 0 16px; color:#0f172a; font-size:20px;">Votre compte a été activé</h2>
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 20px;">
    Bonjour {{ $user->name }},<br>
    Bonne nouvelle : votre demande d'accès à LMC Conseil a été validée par un
    administrateur. Vous pouvez maintenant vous connecter avec votre email
    et le mot de passe choisi à l'inscription.
</p>
<div style="text-align:center; margin:28px 0 8px;">
    <a href="{{ $url }}"
        style="background:#2563eb; color:#ffffff; text-decoration:none; padding:12px 28px; border-radius:8px; font-size:14px; font-weight:600; display:inline-block;">
        Se connecter
    </a>
</div>
@endsection
