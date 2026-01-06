<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; border: 1px solid #eee; border-radius: 10px; max-width: 600px; margin: auto; }
        .header { background: #10b981; color: white; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Report Activity Notification</h1>
        </div>
        <div class="content">
            <p>Hello Manager,</p>
            <p>A user has generated a report in the system.</p>
            <p><strong>Details:</strong></p>
            <ul>
                <li><strong>User:</strong> {{ $user->name }} ({{ $user->email }})</li>
                <li><strong>Report Type:</strong> {{ $reportType }}</li>
                <li><strong>File Generated:</strong> {{ $filename }}</li>
                <li><strong>Date/Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</li>
            </ul>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Procurement MIS NSDO.
        </div>
    </div>
</body>
</html>
