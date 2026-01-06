<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; border: 1px solid #eee; border-radius: 10px; max-width: 600px; margin: auto; }
        .header { background: #4f46e5; color: white; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Account Created</h1>
        </div>
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            <p>Your account for <strong>Procurement MIS</strong> has been successfully created.</p>
            <p>You can log in using the following credentials:</p>
            <ul>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Password:</strong> {{ $password }}</li>
                <li><strong>Assigned Role:</strong> {{ ucfirst($user->role) }}</li>
            </ul>
            <p>Please log in at: <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
            <p>We recommend changing your password after your first login.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Procurement MIS NSDO. Authorized Access Only.
        </div>
    </div>
</body>
</html>
