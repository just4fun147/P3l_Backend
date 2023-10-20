@component('mail::message')
<h2>Hello {{$body['name']}},</h2>
<p>We have received your order, please make payment immediately before {{ $body['due_date'] }} and contact our Sales Manager ! @component('mail::button', ['url' => $body['url']])
Your Receipt
@endcomponent</p>

Or Click this link  : <a href="{{ $body['url'] }}">Your Receipt</a>
<br>
Contact Our Manager  : <a href="{{ $body['sm'] }}">Sales Manager</a>

 
 
{{ $body['date'] }}<br>
Grand Atma Hotel
@endcomponent