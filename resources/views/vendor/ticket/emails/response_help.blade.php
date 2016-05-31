@extends('ticket::ticket.layout.email')
@section('body')
			There has been a response posted to your request for help on a Ticket# {{$ticketId}}<br />
			<br />
			
<p>Please login to the Corporate Intranet and view the response <br/> <a href="{{getBaseUrl()}}/support/show/{{$ticketId}}" target="_blank">{{getBaseUrl()}}/support/show/{{$ticketId}}.</a></p>
<p>Replies to this e-mail will be added to the ticket history.</p>
@stop