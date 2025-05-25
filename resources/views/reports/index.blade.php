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
        data.forEach(item => {
            container.innerHTML += `<div>${item.period}: ${item.total} appointments</div>`;
        });
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
        const container = document.getElementById('utilization-table');
        data.forEach(row => {
            container.innerHTML += `
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
        const container = document.getElementById('cancellation-table');
        data.cancellation_rates.forEach(row => {
            const noShow = data.no_show_rates.find(ns => ns.practitioner_id === row.practitioner_id);
            container.innerHTML += `
            <tr>
                <td>${row.name}</td>
                <td>${row.cancellation_rate_percent}</td>
                <td>${noShow ? noShow.no_show_count : 0}</td>
            </tr>`;
        });
    });
}
</script>
