@extends('email')
@section('content')

<p>
	{{ trans('User/email-change-email.text_email_first') }} {{$user['email']}}.{{ trans('User/email-change-email.text_email_end') }}
</p>

@stop