@extends('ticket::ticket.layout.email')
@section('title')
	{{$type}} Ticket #{{$ticketId}} has been closed by {{$actionUser}} Ref#{{$hash}}
@stop
@section('body')

<p>Ticket number {{$ticketId}} has been closed. If you would like to re-open this ticket, please do so within 48 hours by clicking this link: <a href="{{getBaseUrl()}}/support/show/{{$ticketId}}" target="_blank">{{getBaseUrl()}}/support/show/{{$ticketId}}.</a></p><br><br>
<p>Thank you for using the ULS ticketing system.</p>
@stop
