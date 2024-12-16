<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body>
    <h1>Contact Form Message</h1>
    <p><strong>Name:</strong> {{ $name }}</p>
    <p><strong>Phone:</strong> {{ $phone ?? 'Not provided' }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Message:</strong> {{ $messageContent }}</p>
</body>
</html>

