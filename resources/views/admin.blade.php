<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h1 { color: #2c3e50; }
        a { text-decoration: none; color: #3498db; }
    </style>
</head>
<body>
    <h1>Welcome to the Admin Dashboard</h1>

    <ul>
        <li><a href="{{ route('patients.index') }}">View All Patients</a></li>
        <li><a href="#">Notifications</a></li>
        <li><a href="#">User Management</a></li>
    </ul>
</body>
</html>
