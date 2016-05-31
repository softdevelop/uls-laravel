@extends('email')
@section('content')

<p> {{ trans('User/email-create-password.text_email') }}: <br><a href="{{ url('password/create-password/'. $token)}}" target="_blank">{{ url('password/create-password/'. $token)}}</a></p>

@stop