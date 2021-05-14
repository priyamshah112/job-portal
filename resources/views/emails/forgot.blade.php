@component('mail::message')
# Hii ,

Dear {{ $details['first_name'] }} {{ $details['last_name'] }},<br>
Your Forgot OTP is : {{ $details['otp'] }}<br>


<br>
{{ config('app.name') }}
@endcomponent