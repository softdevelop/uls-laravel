@extends('ticket::ticket.layout.email')
@section('body')
			This is a notification that <b>Ticket # {{$ticketId}}</b> has been re-assigned from {{$assigned}} to another user.<br />
@stop