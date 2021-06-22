@component('mail::message')
# Hii ,
<h2>Welcome to the site {{$user['name']}}</h2>
<br/>
Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email account
<br/>
<a href="{{url('user/verify', $user->verifyUser->token)}}">Verify Email</a>
</body>

Thanks,<br>
{{ config('app.name') }}
@endcomponent