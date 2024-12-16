<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Code</title>
</head>
<body>
    <h1>Password Reset Code</h1>
    <p>Hello, {{ $user->name }},</p>
    <p>Below is the code to reset your password:</p>
    <h2>{{ $code }}</h2>
    <p>Please use this code to reset your password.</p>
    <p>thanks,</p>
    <p>LEARNERS LAMP</p>
</body>
</html>
