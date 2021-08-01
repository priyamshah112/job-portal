@component('mail::message')

Dear Applicant, 
<br/>
<br/>

This is to the reference of your application for the position applied on web portal, Thank you for the same . 

We would like to inform you that your profile is being shortlisted for the job role and is best suited for it. Therefore, we would like to schedule  Interview  shortly.  

So  please ensure checking your mails regularly  and ensure  Your Mobile Number should be reachable for  further  details. 

<br/>
Best wishes to you,  
<br/>
<br/>

Regards, <br/>

<br/>
<br/>
Company: {{$details['company_name']}}<br>
Address: {{$details['company_address']}}<br>
Contact: {{$details['mobile_number']}}

@endcomponent
