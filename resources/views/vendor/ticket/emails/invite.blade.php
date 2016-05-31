@extends('ticket::ticket.layout.email')
@section('title')
	You have been added as a follower of Ticket #{{$ticketId}} by {{$actionUser}} Ref#{{$hash}}
@stop
@section('body')
<p>{{$assigned}} has invited you to join ticket number {{$ticketId}}. You can login to see the status of this ticket at any time by clicking this link: <a href="{{getBaseUrl()}}/support/show/{{$ticketId}}" target="_blank">{{getBaseUrl()}}/support/show/{{$ticketId}}.</a></p><br><br>
<p>Thank you for using the ULS ticketing system.</p>
@stop
