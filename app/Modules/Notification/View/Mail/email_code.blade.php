<!DOCTYPE html>
<html>
<head>
    <title>Email Notification</title>
</head>
<body>
    <h1>Hello, {{ $data['name'] }}</h1>
    <p>This is a test email.</p>
    <p><a href="{{ url('/') }}">View Website</a></p>
    <p>Thank you for using our application!</p>
</body>
</html>
