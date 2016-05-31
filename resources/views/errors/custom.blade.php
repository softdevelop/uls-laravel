
@extends('auth')
@section('title')
	Error
@stop
@section('content')
    <div id="login-wrapper" class="sizer">     
        <div id="box" class="sizer well p-t-100">
          <h4>{{ $message }}</h4>
        </div>
    </div>
@stop
