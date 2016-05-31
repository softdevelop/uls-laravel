@extends('ticket::ticket.layout.email')
@section('title')
	{{$type}} Ticket #{{$ticketId}} has been created by {{$actionUser}} Ref#{{$hash}}
@stop
@section('body')
<p>There has been a new ticket created in the ULS system, the ticket number is:{{$ticketId}}. Please login to the ULS to assign this ticket to a user in your department. You can also click this shortcut to view this ticket: 
<a href="{{getBaseUrl()}}/support/show/{{$ticketId}}" target="_blank">{{getBaseUrl()}}/support/show/{{$ticketId}}.</a></p><br><br>
<p>Thank you for using the ULS ticketing system.</p>
@stop