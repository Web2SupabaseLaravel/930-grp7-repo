<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile & Appointments</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h1 { color: #2c3e50; }
    </style>
</head>
<body>
    <h1>Welcome, {{ $user->first_name }} {{ $user->last_name }}</h1>

    <h2>Personal Information</h2>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Contact Info:</strong> {{ $user->contact_info }}</p>
    <p><strong>Insurance Info:</strong> {{ $user->insurance_info }}</p>

    <h2>My Appointments</h2>
    <ul>
        @foreach ($appointments as $appointment)
            <li>
                {{ $appointment->appointment_at }} -
                Status: {{ $appointment->status }}
            </li>
        @endforeach
    </ul>
</body>
</html>
