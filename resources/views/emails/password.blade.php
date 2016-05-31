@extends('email')
@section('content')
Click here to reset your password:<br>{{ url('password/reset/'.$token) }}
@stop