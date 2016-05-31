 @extends('auth')
 @section('title')
  Reset Password
 @stop
 @section('content')
  <div id="resetpassword_logo" class="logo text-center">
      <img src="{{ asset('images/navibar/uls_logo.png') }}"/>
  </div>

  @if (count($errors) > 0)
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
  @endif
  <form method="POST" action="/password/reset" novalidate>
      {!! csrf_field() !!}
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="input-group col-md-12 col-ms-12 col-xs-12">
          <span class=""></span>
          <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email Address">
      </div>
      <div class="input-group col-md-12 col-ms-12 col-xs-12">
            <span class=""></span>
            <input type="password" name="password" id="password" placeholder="Password">
      </div>
           <div class="input-group col-md-12 col-ms-12 col-xs-12">
            <span class=""></span>
            <input type="password" name="password_confirmation" id="password" placeholder="Password Again">
      </div>
      <div class=" action-reset text-center">
          <button type="submit" class="btn btn-primary" name="btn_register">Set Password</button>
      </div>
  </form>
@stop