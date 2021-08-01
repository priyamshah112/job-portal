@component('mail::message')

Dear Applicant, 
<br/>
<br/>

Thank you very much  for  applying the position open with us,  As you  can imagine , we received  a large number of  applications . we are sorry to inform you  that  you have not been  selected  for this position. 

We  extend  our thanks  to  you for  the time you invested  in applying the position open with us. We encourage  you to apply  for  future openings for which you qualify. 

<br/>
Best wishes  for  a successful  job search . Thank you , again,  for your interest  in our company. 
<br/>
<br/>

Regards, <br/>

<br/>
<br/>
Company: {{$details['company_name']}}<br>
Address: {{$details['company_address']}}<br>
Contact: {{$details['mobile_number']}}

@endcomponent
