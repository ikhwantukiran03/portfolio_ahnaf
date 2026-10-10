<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New contact message</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2>Contacts from Freelance Portfolio site</h2>
    <p><strong>Name:</strong> {{ $senderName }}</p>
    <p><strong>Email:</strong> {{ $senderEmail }}</p>
    <p><strong>Subject:</strong> {{ $contactSubject }}</p>
    <hr>
    <p style="white-space: pre-wrap;">{{ $contactMessage }}</p>
    <hr>
    <p style="font-size: 12px; color: #6b7280;">Reply directly to this email to respond to {{ $senderName }}.</p>
</body>
</html>
