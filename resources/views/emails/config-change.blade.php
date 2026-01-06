<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; border: 1px solid #eee; border-radius: 10px; max-width: 600px; margin: auto; }
        .header { background: #6366f1; color: white; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Configuration Updated</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>This is a notification that a new system configuration has been added or updated.</p>
            <p><strong>Details of Change:</strong></p>
            <ul>
                <li><strong>Action By:</strong> {{ $userName }}</li>
                <li><strong>Category:</strong> {{ $changeType }}</li>
                <li><strong>Item Name:</strong> {{ $itemName }}</li>
                <li><strong>Date/Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</li>
            </ul>
            <p>You can view the latest changes in the system dashboard.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Procurement MIS NSDO.
        </div>
    </div>
</body>
</html>
