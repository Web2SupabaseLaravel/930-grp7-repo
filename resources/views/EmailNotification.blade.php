@component('mail::message')
# {{ $type == 'booking_confirmation' ? 'Your appointment has been confirmed' : ($type == 'cancellation' ? 'Your appointment has been cancelled' : 'Appointment reminder') }}

{{ $message }}

@component('mail::button', ['url' => 'https://your-clinic-site.com']) 
Show details
@endcomponent
Thank you ,<br>
{{ config('app.name') }}
@endcomponent
