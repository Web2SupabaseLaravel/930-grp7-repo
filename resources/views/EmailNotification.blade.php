@component('mail::message')
# {{ $type == 'booking_confirmation' ? 'تم تأكيد موعدك' : ($type == 'cancellation' ? 'تم إلغاء موعدك' : 'تذكير بموعد') }}

{{ $message }}

@component('mail::button', ['url' => 'https://your-clinic-site.com']) {{-- غير الرابط حسب مشروعك --}}
عرض التفاصيل
@endcomponent

شكراً لك,<br>
{{ config('app.name') }}
@endcomponent
