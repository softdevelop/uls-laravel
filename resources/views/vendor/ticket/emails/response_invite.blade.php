@extends('ticket::ticket.layout.email')
@section('title')
	{{$type}} Ticket #{{$ticketId}} has been updated by {{$actionUser}} Ref#{{$hash}}
@stop
@section('body')
<p> There has been an update to ticket number {{$ticketId}} below. You can login to see the status of your ticket at any time by clicking this link: <a href="{{getBaseUrl()}}/support/show/{{$ticketId}}" target="_blank">{{getBaseUrl()}}/support/show/{{$ticketId}}.</a></p>
##########################################################
<p>{!!$lastComment['content']!!}</p>
#########################################################
<br><br>
<p>Thank you for using the ULS ticketing system.</p>
@stop
