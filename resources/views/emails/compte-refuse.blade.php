@extends('emails.layout')

@section('title', "Votre demande d'accès")

@section('content')
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 22px;">
    Bonjour {{ $user->name }},<br>
    Après examen, votre demande d'accès à LMC Conseil n'a pas été retenue.
</p>

@if($user->motif_refus)
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc; border:1px solid #e7ebf1; border-radius:10px; margin:0 0 22px;">
<tr><td style="padding:18px 20px;">
    <p style="margin:0 0 6px; color:#64748b; font-size:12px; text-transform:uppercase; letter-spacing:.04em; font-weight:700;">Motif</p>
    <p style="margin:0; color:#0a1f38; font-size:14px; line-height:1.6;">{{ $user->motif_refus }}</p>
</td></tr>
</table>
@endif

<p style="color:#94a3b8; font-size:12px; line-height:1.6; margin:20px 0 0;">
    Pour toute question, contactez un administrateur LMC Conseil.
</p>
@endsection
