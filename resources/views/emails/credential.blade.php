@component('mail::message')
# Hii ,

This is your credential for NaukriWala.
{{config('app.url')}}/login

Username: {{ $details['email'] }}<br>
Password: {{ $details['password'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
