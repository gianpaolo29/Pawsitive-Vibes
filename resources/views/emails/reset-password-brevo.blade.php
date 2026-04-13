<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background-color:#f8f7ff;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f7ff;padding:40px 0;">
<tr>
<td align="center">
<table width="570" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:12px;border:1px solid #e0ddf5;box-shadow:0 2px 8px rgba(138,43,226,0.08);">

{{-- Header --}}
<tr>
<td align="center" style="padding:30px 0;background:linear-gradient(135deg,#f8f7ff,#fff9e6);border-radius:12px 12px 0 0;">
    <div style="width:60px;height:60px;background:linear-gradient(135deg,#8a2be2,#6a0dad);border-radius:50%;margin:0 auto 10px;line-height:60px;text-align:center;">
        <span style="font-size:28px;">&#128062;</span>
    </div>
    <span style="font-size:24px;font-weight:700;color:#8a2be2;letter-spacing:1px;">{{ $appName }}</span>
</td>
</tr>

{{-- Body --}}
<tr>
<td style="padding:32px;">
    <h1 style="color:#8a2be2;font-size:18px;font-weight:bold;margin:0 0 16px;">Hello {{ $userName }}!</h1>
    <p style="color:#444;font-size:16px;line-height:1.5;margin:0 0 16px;">We received a request to reset the password for your {{ $appName }} account.</p>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin:30px 0;">
    <tr>
    <td align="center">
        <a href="{{ $url }}" style="display:inline-block;padding:12px 32px;background-color:#8a2be2;color:#ffffff;text-decoration:none;border-radius:12px;font-size:16px;font-weight:600;letter-spacing:0.5px;">Reset Password</a>
    </td>
    </tr>
    </table>

    <p style="color:#444;font-size:16px;line-height:1.5;margin:0 0 16px;">This password reset link will expire in 60 minutes.</p>
    <p style="color:#444;font-size:16px;line-height:1.5;margin:0 0 16px;">If you did not request a password reset, no further action is required.</p>

    <p style="color:#444;font-size:16px;line-height:1.5;margin:24px 0 0;">Paws & Love,<br>The {{ $appName }} Team</p>
</td>
</tr>

{{-- Footer --}}
<tr>
<td align="center" style="padding:20px;border-top:1px solid #e0ddf5;">
    <p style="color:#999;font-size:12px;margin:0;">&copy; {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
</td>
</tr>

</table>
</td>
</tr>
</table>
</body>
</html>
