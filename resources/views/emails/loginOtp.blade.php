@component('mail::message')
# Hii ,

Thank you for registering with Job Portal.

Otp: {{ $details['otp'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent