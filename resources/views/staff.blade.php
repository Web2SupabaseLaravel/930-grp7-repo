<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h1 { color: #2c3e50; }
    </style>
</head>
<body>
    <h1>Staff Dashboard</h1>

    <h2>Patient List</h2>
    <ul>
        @foreach ($patients as $patient)
            <li>{{ $patient->first_name }} {{ $patient->last_name }} - {{ $patient->email }}</li>
        @endforeach
    </ul>
</body>
</html>
