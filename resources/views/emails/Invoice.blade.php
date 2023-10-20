@component('mail::message')
<h2>Thank You {{$body['name']}},</h2>
<p>We hope you are satisfied with our service!</p>
<p>This is your invoice and see you next time</p> @component('mail::button', ['url' => $body['url']])
Your Invoice
@endcomponent

Or Click this link  : <a href="{{ $body['url'] }}">Your Invoice</a>
<br>

 
 
Best Regards,<br>
Grand Atma Hotel
@endcomponent