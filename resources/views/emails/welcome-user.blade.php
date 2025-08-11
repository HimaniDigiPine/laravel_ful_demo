<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, {{ $user->firstname }}!</h2>
    <p>You have been added to our system. Here are your login credentials:</p>

    <ul>
        <li>Email: {{ $user->email }}</li>
        <li>Password: {{ $password }}</li>
    </ul>

    <p>Please log in and change your password after first login.</p>
    <p>Thank you!</p>
</body>
</html>