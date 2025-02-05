<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
<h2>Verify Your Email</h2>
<p>Thank you for signing up for the Boomtown mailing list!</p>
<p>Click the link below to verify your email address:</p>
<p>
    <a href="{{ $verificationLink }}" style="background-color: #007BFF; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Verify Email
    </a>
</p>
<p>If you did not sign up, please ignore this email.</p>
</body>
</html>
