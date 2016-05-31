@extends('ticket::ticket.layout.email')
@section('title')
	{{$type}} Ticket #{{$ticketId}} has been assigned by {{$actionUser}} Ref#{{$hash}}
@stop
@section('body')
<p>You have been assigned a new ticket in the ULS system, the ticket number is:{{$ticketId}}. You can login to the ULS to work within the ticketing system, or you can respond to this ticket by replying to this email. If you choose to reply via email, please do not change the subject line. Here is a quick link to the ticket:  <a href="{{getBaseUrl()}}/support/show/{{$ticketId}}" target="_blank">{{getBaseUrl()}}/support/show/{{$ticketId}}.</a></p><br><br>
<p>Thank you for using the ULS ticketing system.</p>
@stop
