<!DOCTYPE html>
<html lang="en">
<body style="margin:0;padding:24px;background:#f6f8f4;font-family:Arial,Helvetica,sans-serif;color:#0a0a0a;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;">
        <tr>
            <td style="background:#0a0a0a;padding:20px 28px;color:#ffffff;font-size:18px;font-weight:bold;">
                <span style="color:#4caf0f;">●</span> New website inquiry
            </td>
        </tr>
        <tr>
            <td style="padding:28px;">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-size:15px;line-height:1.5;">
                    <tr><td style="padding:6px 0;width:130px;color:#666;">Name</td><td style="padding:6px 0;"><strong>{{ $inquiry->name }}</strong></td></tr>
                    <tr><td style="padding:6px 0;color:#666;">Email</td><td style="padding:6px 0;"><a href="mailto:{{ $inquiry->email }}" style="color:#2a7a1f;">{{ $inquiry->email }}</a></td></tr>
                    @if ($inquiry->phone)
                        <tr><td style="padding:6px 0;color:#666;">Phone</td><td style="padding:6px 0;">{{ $inquiry->phone }}</td></tr>
                    @endif
                    @if ($inquiry->organisation)
                        <tr><td style="padding:6px 0;color:#666;">Organisation</td><td style="padding:6px 0;">{{ $inquiry->organisation }}</td></tr>
                    @endif
                    @if ($inquiry->service)
                        <tr><td style="padding:6px 0;color:#666;">Interested in</td><td style="padding:6px 0;">{{ $inquiry->service }}</td></tr>
                    @endif
                </table>

                <p style="margin:24px 0 8px;color:#666;font-size:13px;text-transform:uppercase;letter-spacing:1px;">Message</p>
                <div style="padding:16px;background:#f6f8f4;border-left:4px solid #4caf0f;font-size:15px;line-height:1.6;white-space:pre-line;">{{ $inquiry->message }}</div>

                <p style="margin:28px 0 0;font-size:13px;color:#888;">
                    Received {{ $inquiry->created_at->format('D, j M Y \a\t H:i') }}. Reply to this email to answer {{ $inquiry->name }} directly.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
