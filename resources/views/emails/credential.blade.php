@component('mail::message')
# Hii ,

This is your credential for Job Portal.
{{config('app.url')}}/login

Username: {{ $details['email'] }}<br>
Password: {{ $details['password'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
