<h1>Hello</h1>
@if($status == 'createTicket')
<p>  create ticket {{$data['title']}} </p>
@endif
@if($status == 'assign'))
<p>  assign ticket {{$data['title']}} </p>
@endif
@if($status == 'invite'))
<p>  invite ticket {{$data['title']}} </p>
@endif