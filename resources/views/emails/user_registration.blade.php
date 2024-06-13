<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>

<body>
    <p>Hello {{ $user->first_name }},</p>
    <p>Thank you for registering. Your OTP is: {{ $otp }}</p>
    <p>Please use this OTP to verify your account.</p>
    <p>Thank you,</p>
    <p>Your Website Team</p>
</body>

</html>
