{{-- resources/views/emails/appointments/cancelled.blade.php --}}
@component('mail::message')
# Booking Cancelled

Dear {{ $appointment->patient->name }},

Your appointment on {{ $appointment->appointment_date->toFormattedDateString() }} at {{ $appointment->appointment_time }} has been **cancelled**.

If you have any questions, please contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
