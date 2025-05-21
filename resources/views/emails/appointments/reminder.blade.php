{{-- resources/views/emails/appointments/reminder.blade.php --}}
@component('mail::message')
# Reminder: Upcoming Appointment

Dear {{ $appointment->patient->name }},

This is a reminder for your upcoming appointment:

- **Doctor:** {{ $appointment->practitioner->name }}
- **Service:** {{ $appointment->service->name }}
- **Date:** {{ $appointment->appointment_date->toFormattedDateString() }}
- **Time:** {{ $appointment->appointment_time }}

Please arrive 10 minutes early.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
