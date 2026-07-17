@extends('emails.layout')

@section('title', 'Nouvelle affectation projet')

@section('content')
<h2 style="margin:0 0 16px; color:#0f172a; font-size:20px;">Nouvelle affectation projet</h2>
<p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 20px;">
    Bonjour,<br>
    Vous avez été affecté au projet suivant par
    <strong>{{ $assignePar->name }}</strong>.
</p>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:20px;">
    <tr>
        <td style="padding:6px 0; color:#64748b; font-size:14px; width:140px;">Projet</td>
        <td style="padding:6px 0; color:#0f172a; font-size:14px; font-weight:600;">{{ $projet->reference_projet }}</td>
    </tr>
    @if($role)
    <tr>
        <td style="padding:6px 0; color:#64748b; font-size:14px;">Votre rôle</td>
        <td style="padding:6px 0; color:#0f172a; font-size:14px;">{{ $role }}</td>
    </tr>
    @endif
</table>
<div style="text-align:center; margin:28px 0 8px;">
    <a href="{{ $url }}"
        style="background:#2563eb; color:#ffffff; text-decoration:none; padding:12px 28px; border-radius:8px; font-size:14px; font-weight:600; display:inline-block;">
        Voir le projet
    </a>
</div>
@endsection
