@extends('ticket::ticket.layout.email')
@section('title')
	{{$type}} Task #{{$ticketId}} has been marked ready for review by {{$actionUser}} Ref#{{$hash}}
@stop
@section('body')
<p>Task #{{$ticketId}} has been marked ready for review by {{$actionUser}}.
 You can login to see the status of your task at any time by clicking this link:
  <a href="{{getBaseUrl()}}/support/show/{{$ticketId}}" target="_blank">{{getBaseUrl()}}/support/show/{{$ticketId}}.</a></p><br><br>
<p>You can respond to the task via email, or by clicking the above link and posting to the task dashboard. 
If you choose to respond via email, please do not change the subject line.</p><br><br>
<p>Thank you for using the ULS tasking system.</p>
@stop

