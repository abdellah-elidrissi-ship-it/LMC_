@extends('emails.layout')

@section('title', 'Demande d\'accès')

@section('content')
<h2 style="margin:0 0 16px; color:#0f172a; font-size:20px;">Votre demande d'accès</h2>
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 20px;">
    Bonjour {{ $user->name }},<br>
    Après examen, votre demande d'accès à LMC Conseil n'a pas été retenue.
</p>
@if($user->motif_refus)
<p style="color:#334155; font-size:14px; line-height:1.6; margin:0 0 20px;">
    <strong>Motif :</strong><br>{{ $user->motif_refus }}
</p>
@endif
<p style="color:#94a3b8; font-size:12px; line-height:1.6; margin:20px 0 0;">
    Pour toute question, contactez un administrateur LMC Conseil.
</p>
@endsection
