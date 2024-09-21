<!DOCTYPE html>
<html>
<head>
    <title>Reset Your Password</title>
</head>
<body>
    <h1>Password Reset Request</h1>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    
    <p>Click the link below to reset your password:</p>
    
    <a href="{{ route("password.reset",$token). "?email=$email" }}">Reset Password</a>

    <p>If you did not request a password reset, no further action is required.</p>

    <p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>