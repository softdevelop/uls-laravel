<!DOCTYPE html>
<html lang="en" data-ng-app="uls">

    @include('shared.head')
    <body>
        @yield('content')
    @include('shared.script')
	  {!! Html::script('app/app.js') !!}
	  {!! Html::script('app/config.js') !!}
	  {!! Html::script('app/baseController.js')!!}
	  {!! Html::script('app/components/user/userService.js')!!} 
    </body>
    
</html>
