@extends('ticket::ticket.layout.email')
@section('title')
	{{$type}} Ticket #{{$ticketId}} has a new internal note added by {{$actionUser}} Ref#{{$hash}}
@stop
@section('body')

<p>Ticket number {{$ticketId}} has been Internal by {{$actionUser}}.
 You can login to see the update of your ticket at any time by clicking this link:
  <a href="{{getBaseUrl()}}/support/show/{{$ticketId}}" target="_blank">{{getBaseUrl()}}/support/show/{{$ticketId}}.</a></p><br><br>
<p>You can respond to the ticket via email, or by clicking the above link and posting to the ticket dashboard. 
If you choose to respond via email, please do not change the subject line.</p><br><br>
<p>Thank you for using the ULS ticketing system.</p>
@stop