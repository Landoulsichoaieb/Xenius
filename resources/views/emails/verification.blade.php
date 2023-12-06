<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body>
    <h1>Hello, {{ $name }}</h1>
    <p>Please click on the following link to verify your email address:</p>
    <a href="{{ $verificationUrl }}">Click here to verify your email</a>
</body>
</html>
