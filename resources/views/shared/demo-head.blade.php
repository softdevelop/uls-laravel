<head>
	<title>
		@yield('title') | UNIVERSAL
	</title>
	<meta charset="UTF-8">
	<meta http-equiv="content-language" content="en-us">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{URL::to('favicon.ico')}}" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	{{-- {!! Html::style('assets/css/tpl.css')!!} --}}
	{!! Html::style('css/demo-ulsinc.css')!!}
	

	{!! Html::style('bower_components/magnific-popup/dist/magnific-popup.css')!!}
	{!! Html::style('css/icon/themify-icons.css')!!}
	{!! Html::style('css/fonts/font-awesome.min.css')!!}
</head>