<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'LMC Conseil')</title>
</head>
<body style="margin:0; padding:0; background:#eef2f7; font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef2f7; padding:32px 0;">
<tr><td align="center">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:580px; background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 2px 10px rgba(10,31,56,0.06);">

    <!-- Bandeau de marque -->
    <tr><td style="background:#0a1f38; height:6px; line-height:6px; font-size:0;">&nbsp;</td></tr>

    <!-- Header : logo -->
    <tr><td style="background:#ffffff; padding:36px 40px 28px; text-align:center; border-bottom:1px solid #e7ebf1;">
        <img src="https://res.cloudinary.com/dzhdfbhn8/image/upload/v1784292423/lmc/branding/lmc-logo-email.png" alt="LMC Conseil — Lead Management Consulting" width="220" style="width:220px; max-width:220px; height:auto; display:block; margin:0 auto;">
    </td></tr>

    <!-- Titre principal -->
    <tr><td style="padding:32px 40px 0;">
        <h1 style="margin:0; color:#0a1f38; font-size:23px; line-height:1.35; font-weight:800; font-family:Arial,Helvetica,sans-serif;">
            @yield('title', 'LMC Conseil')
        </h1>
    </td></tr>

    <!-- Contenu -->
    <tr><td style="padding:18px 40px 36px;">
        @yield('content')
    </td></tr>

    <!-- Footer -->
    <tr><td style="padding:22px 40px; background:#f8fafc; border-top:1px solid #e7ebf1; text-align:center;">
        <p style="margin:0 0 4px; color:#334155; font-size:13px; font-weight:700;">LMC Conseil © {{ date('Y') }}</p>
        <p style="margin:0; color:#94a3b8; font-size:12px; line-height:1.6;">
            Gestion de missions QSE / SMI — ISO 9001 · 14001 · 45001<br>
            Cet e-mail est envoyé automatiquement, merci de ne pas y répondre.
        </p>
    </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
