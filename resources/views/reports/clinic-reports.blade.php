@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clinic Reports</h1>

    <div class="mb-4">
        <label for="period">Select Period:</label>
        <select id="period" class="form-select w-25" onchange="loadAppointmentVolume(this.value)">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
        </select>
    </div>

    <h2>Appointment Volume</h2>
    <div id="appointment-volume" class="mb-4"></div>

    <h2>Practitioner Utilization</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Practitioner</th>
                <th>Total Appointments</th>
                <th>Average Duration (minutes)</th>
                <th>Revenue ($)</th>
            </tr>
        </thead>
        <tbody id="utilization-table"></tbody>
    </table>

    <h2>Cancellations & No-Shows</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Practitioner</th>
                <th>Cancellation Rate (%)</th>
                <th>No-Show Count</th>
            </tr>
        </thead>
        <tbody id="cancellation-table"></tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    loadAppointmentVolume('daily');
    loadPractitionerUtilization();
    loadCancellationNoShow();
});

function loadAppointmentVolume(period = 'daily') {
    fetch(`/api/reports/appointment-volume?period=${period}`, {
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer {{ auth()->user()->api_token }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('appointment-volume');
        container.innerHTML = '';
        if (data.length === 0) {
            container.innerHTML = '<p>No data available.</p>';
        } else {
            data.forEach(item => {
                container.innerHTML += `<div>${item.period}: ${item.total} appointments</div>`;
            });
        }
    });
}

function loadPractitionerUtilization() {
    fetch(`/api/reports/practitioner-utilization`, {
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer {{ auth()->user()->api_token }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        const table = document.getElementById('utilization-table');
        table.innerHTML = '';
        data.forEach(row => {
            table.innerHTML += `
                <tr>
                    <td>${row.name}</td>
                    <td>${row.total_appointments}</td>
                    <td>${row.average_duration}</td>
                    <td>${row.revenue}</td>
                </tr>`;
        });
    });
}

function loadCancellationNoShow() {
    fetch(`/api/reports/cancellation-no-show`, {
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer {{ auth()->user()->api_token }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        const table = document.getElementById('cancellation-table');
        table.innerHTML = '';
        data.cancellation_rates.forEach(row => {
            const noShow = data.no_show_rates.find(ns => ns.practitioner_id === row.practitioner_id);
            table.innerHTML += `
                <tr>
                    <td>${row.name}</td>
                    <td>${row.cancellation_rate_percent}</td>
                    <td>${noShow ? noShow.no_show_count : 0}</td>
                </tr>`;
        });
    });
}
</script>
@endsection
