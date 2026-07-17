<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'LMC Conseil')</title>
</head>
<body style="margin:0; padding:0; background:#f1f5f9; font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9; padding:24px 0;">
<tr><td align="center">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background:#ffffff; border-radius:12px; overflow:hidden;">
<tr><td style="background:#2563eb; padding:24px 32px; text-align:center;">
<span style="color:#ffffff; font-size:20px; font-weight:700; letter-spacing:0.02em;">LMC Conseil</span>
</td></tr>
<tr><td style="padding:32px;">
@yield('content')
</td></tr>
<tr><td style="padding:20px 32px; background:#f8fafc; text-align:center; color:#94a3b8; font-size:12px;">
LMC Conseil — Gestion de missions QSE / SMI
</td></tr>
</table>
</td></tr>
</table>
</body>
</html>
