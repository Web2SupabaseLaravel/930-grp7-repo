<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نظام حجز المواعيد</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            padding: 30px;
            background-color: #f4f4f4;
        }
        h2 {
            margin-bottom: 10px;
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 15px;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #e9e9e9;
        }
    </style>
</head>
<body>

    <h2>Book a new appointment</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('appointments.store') }}">
        @csrf

        <label for="patiant_id">(patiant_id):</label>
        <input type="number" name="patiant_id" required>

        <label for="practitioner_id">(practitioner_id):</label>
        <input type="number" name="practitioner_id" required>

        <label for="service_id">(service_id):</label>
        <input type="number" name="service_id" required>

        <label for="appointment_date">appointment_date</label>
        <input type="date" name="appointment_date" required>

        <label for="appointment_time">appointment_time</label>
        <input type="time" name="appointment_time" required>

        <label for="status">status</label>
        <select name="status" required>
            <option value="confirmed">confirmed</option>
            <option value="cncelled">Cancelled</option>
        </select>

        <button type="submit"> Book an appointment</button>
    </form>

    <h2>My appointments</h2>

    <form method="GET" action="{{ url('/appointments') }}">
        <label for="patiant_id_filter"></label>
        <input type="number" name="patiant_id" id="patiant_id_filter" required>
        <button type="submit">Enter your number to view your appointments:</button>
    </form>

    @if(isset($myAppointments))
        @if($myAppointments->isEmpty())
            <p> There are no appointments for this patient.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Dr.</th>
                        <th>service</th>
                        <th>date</th>
                        <th>time</th>
                        <th>stutus</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($myAppointments as $appointment)
                        <tr>
                            <td>{{ $appointment->practitioner->name ?? 'غير معروف' }}</td>
                            <td>{{ $appointment->service->name ?? 'غير معروف' }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>{{ $appointment->appointment_time }}</td>
                            <td>{{ $appointment->status }}</td>
                            <td>
                                @if($appointment->status !== 'confirmed')
                                    <form method="POST" action="{{ route('appointments.confirm', $appointment->appointment_id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background-color:#007bff; color:white;">confirmation</button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('appointments.destroy', $appointment->appointment_id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete the appointment?')" style="background-color:#dc3545; color:white;">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

</body>
</html>
