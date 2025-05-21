{{-- resources/views/emails/appointments/confirmed.blade.php --}}
@component('mail::message')
# Booking Confirmed

Dear {{ $appointment->patient->name }},

Your appointment is confirmed:

- **Doctor:** {{ $appointment->practitioner->name }}
- **Service:** {{ $appointment->service->name }}
- **Date:** {{ $appointment->appointment_date->toFormattedDateString() }}
- **Time:** {{ $appointment->appointment_time }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
