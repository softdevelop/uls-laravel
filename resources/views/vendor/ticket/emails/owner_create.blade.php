@extends('ticket::ticket.layout.email')
@section('title')
	You Posted {{$type}} Ticket #{{$ticketId}} Ref#{{$hash}}
@stop
@section('body')
<p>You have created a new ticket in the ULS system, your ticket number is:{{$ticketId}}. 
You can login to see the status of your ticket at any time by clicking this link:  <a href="{{getBaseUrl()}}/support/show/{{$ticketId}}" target="_blank">{{getBaseUrl()}}/support/show/{{$ticketId}}.</a></p>
<p>You can respond to the ticket via email, or by clicking the above link and posting to the ticket dashboard. 
If you choose to respond via email, please do not change the subject line.</p>
<p>Thank you for using the ULS ticketing system.</p>
@stop
