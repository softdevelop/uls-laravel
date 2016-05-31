 @extends('auth')
 	@section('title')
        Login
    @stop
 @section('content')
	<div id="login_logo" class="logo text-center">
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

 	<form method="POST" action="/auth/login" novalidate>
 	 {!! csrf_field() !!}
	  
	  <div class="input-group">
	      <span class="input-group-addon glyphicon glyphicon-user"></span>
	      <input type="email" name="email" value="{{ old('email') }}" placeholder="Your Email">
	  </div>
	  <div class="input-group">
	      <span class="input-group-addon glyphicon glyphicon-lock"></span>
	      <input type="password" name="password" id="password" placeholder="Your Password">
	  </div>

	  <div class="checkbox checkbox-danger remember">
	      <input type="checkbox" name="remember">
	      <label for="checkbox2">Remember Me</label>
	  </div>

	  <div class=" actionlogin text-center">
	  	  <button type="submit" class="btn btn-primary" name="btn_login">Log In</button>
	  	  {{-- <a href="register"><span class="btn btn-primary button-o" name="btn_register">Register</span></a> --}}
	  </div>
	  <div class="forgot-login text-center">
	      <a id="reset_pwd" href="/password/email">Forgot password?</a>
	  </div>
</form>
 @stop
 