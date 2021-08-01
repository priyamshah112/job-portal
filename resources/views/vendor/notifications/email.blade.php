@component('mail::message')

{{-- Intro Lines --}}
Thank  You For Registering On Naukriwala.co.in  ,  Please  Verify Your Mail for Authentication By Clicking the Following  :

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

After  Varifying  Mail , You Can Enjoy The Services of Naukriwala. 

<br>
<br>

From,

@lang('Team')<br>
<a href='https://naukriwala.co.in/'>www.naukriwala.co.in</a><br>
<img src="https://naukriwala.co.in/images/logo/job_portal_logo1.png" style="width:200px"/>

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
